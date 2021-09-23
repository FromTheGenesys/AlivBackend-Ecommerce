<?php

    class GPLogicAuth extends gpLogic {
        
        public function __construct() {
            parent::__construct();     

        }

        /**
         * 
         * @name    processLogin
         * 
         * @desc    submits a NetworkID and NetworkPassword to the active directory for
         *          authentication and authorization purposes
         * 
         * @author  Vincent J. Rahming
         * 
         * @return  MIXED $getData
         * 
         */
        public function processLogin() {

            // print_r( $_POST );

            if ( empty( $_POST['NetworkID'] ) AND 
                 empty( $_POST['NetworkPassword'] ) ) :

                return 2;

            endif;


            # query the database to determine if the account is available
            $getData                    =                   $this->GPLogicData->sql( 'SELECT        Administrators.*

                                                                                      FROM          Administrators
                                                                                      WHERE         Administrators.AdminNetworkID   =   "'. $_POST['NetworkID'] .'"
                                                                                      AND           Administrators.AdminStatus      =   "A"' );


            if ( $getData['count'] == 0 ) :

                return 3;   # no account found

            endif;


            # check the password has to confirm that it matches
            if ( password_verify( $_POST['NetworkPassword'], $getData['data'][0]['AdminPassword'] ) === false ) :

                return 4;

            endif;

            
                
            $this->GPLogicSession->setIndex( 'sessAcctRole', $getData['data'][0]['AdminRole'] );
            $this->GPLogicSession->setIndex( 'sessAcctID', $getData['data'][0]['AdminID'] );
            $this->GPLogicSession->setIndex( 'sessAcctGUID', $getData['data'][0]['AdminGUID'] );
            $this->GPLogicSession->setIndex( 'sessAcctFirst', $getData['data'][0]['AdminFirst'] );
            $this->GPLogicSession->setIndex( 'sessAcctLast', $getData['data'][0]['AdminLast'] );
            $this->GPLogicSession->setIndex( 'SessionIsStarted', true );

            header( 'Location: '. gpConfig['URLPATH'] .'auth' );             

        }

        /**
         * 
         * @name    processGetAccountLogin
         * 
         * @desc    Validates A UserID and Password against the database
         * 
         * @author  Vincent J. Rahming
         * 
         * @return  MIXED $getData
         * 
         */
        public function processAccountLogin() {

            # account login parameters
            if ( empty( $_POST['LoginID'] ) OR 
                 empty( $_POST['Password'] ) ) :
                 
                 return 2;      # on of the required parameters is empty
                 
            endif;

            # query the database to determine if the account is available
            $getData                    =                   $this->GPLogicData->sql( 'SELECT        sysAccounts.* 

                                                                                      FROM          sysAccounts
                                                                                      WHERE         sysAccounts.account_login       =   ":LoginID"
                                                                                      AND           sysAccounts.account_password    =   ":Password"
                                                                                      AND           sysAccounts.account_pid         =   "CNG"
                                                                                      AND           sysAccounts.account_status      =   "1"', 
                                                                                      [ 'LoginID'    =>  $_POST['LoginID'],
                                                                                        'Password'   =>  md5( $_POST['Password'] ) ]  
                                                                                    );

            # if the account is not found
            if ( $getData['count'] == 0 ) :
                
                return 3;
                
            endif;
            
            # setup session variables            
            $this->GPLogicSession->setIndex( 'sessAcctID', $getData['data'][0]['id'] );
            $this->GPLogicSession->setIndex( 'sessAcctGUID', $getData['data'][0]['account_guid'] );
            $this->GPLogicSession->setIndex( 'sessFirstName', $getData['data'][0]['account_first'] );
            $this->GPLogicSession->setIndex( 'sessLastName', $getData['data'][0]['account_last'] );
            $this->GPLogicSession->setIndex( 'sessAcctEmail', $getData['data'][0]['account_email'] );            
            $this->GPLogicSession->setIndex( 'sessAcctLocations', $getData['data'][0]['account_locations'] );
            $this->GPLogicSession->setIndex( 'sessAcctRoles', $getData['data'][0]['account_roles'] );
            
            # if the account has more than one role, then select role
            if ( sizeof( explode( ',', $getData['data'][0]['account_roles'] ) ) == 1 ) :

                # determine if the role is administrative, operations, supervisor or csr
                $this->GPLogicSession->setIndex( 'sessAcctRole', $getData['data'][0]['account_roles'] );

                # account role
                if ( $_SESSION['sessAcctRole'] > 2 ) : 

                    # location must be specified
                    if ( sizeof( explode( ',', $getData['data'][0]['account_locations'] ) ) == 1 ) :

                        # assign location
                        $this->GPLogicSession->setIndex( 'sessAcctLocation', $getData['data'][0]['account_locations'] );

                        # get the module assignments for the specified location
                        $getLocationData            =                   $this->GPLogicData->sql( 'SELECT        sysLocations.location_modules, 
                                                                                                                sysLocations.location_hours

                                                                                                  FROM          sysLocations
                                                                                                  WHERE         sysLocations.id   =   "'. $getData['data'][0]['account_locations'] .'"');
                        
                        $this->GPLogicSession->setIndex( 'sessLocationModules', $getLocationData['data'][0]['location_modules'] );
                        $this->GPLogicSession->setIndex( 'sessLocationHours', $getLocationData['data'][0]['location_hours'] );

                        if ( empty( $_SESSION['sessLocationHours'] ) ) :
                            
                            header( gpConfig['URLPATH'] .'auth/hours' );

                        else:

                            $days       =       [];

                            foreach( explode( ',', $_SESSION['sessLocationHours'] ) as $HourSet ) :

                                list( $d, $start, $stop )   =   explode( '-', $HourSet );
                                $days[ $d ]     =       [ 'OpenTime' => $start, 'CloseTime' => $stop ];
                                
                            endforeach;

                            if ( in_array( date('w'), array_keys( $days ) ) ) :

                                // check hours                                
                                if ( ( strtotime( date('Y-m-d') . $days[ date('w') ]['OpenTime'] . ':00' ) <= strtotime( date('Y-m-d H:i') .':00' ) ) AND
                                     ( strtotime( date('Y-m-d') . $days[ date('w') ]['CloseTime'] . ':00') >= strtotime( date('Y-m-d H:i') .':00' ) ) ) :

                                    $this->GPLogicSession->setIndex( 'SessionIsStarted', true );
                                    header( 'Location: ' . gpConfig['URLPATH'] .'auth/route' );

                                else:
                                
                                    header( 'Location: ' .gpConfig['URLPATH'] .'auth/hours' );

                                endif;

                            else: 

                                header( 'Location: ' .gpConfig['URLPATH'] .'auth/hours' );

                            endif;
                            
                        endif;

                        # determine if the operation hours are inbounds and then allow forward movement, 
                        # else, show non operational page ( due to non permitted operating hours )

                    else:

                        # location must be selected
                        header( 'Location: ' . gpConfig['URLPATH'] .'auth/selectlocale/' );

                    endif;

                endif;
               
            else:    

                # redirect user to select role
                header( 'Location: '. gpConfig['URLPATH'] .'auth/selectrole' );

            endif;

            # if location is singular
            if ( isset( $_SESSION['sessAcctRole'] ) ) : 

                if ( sizeof( explode( ',', $_SESSION['sessAcctLocations'] ) ) == 1 ) :

                    // $this->GPLogicSession->setIndex( 'sessAcctLocation', $getData['data'][0]['account_locations'] );
                    // $this->GPLogicSession->setIndex( 'SessionIsStarted', true );
                    // header( 'Location: '. gpConfig['URLPATH'] .'auth/' );

                else:

                    # determine if the locations that are present are all active.
                    # if only multiple active locations, then show all
                    # if only one active location, forward to location
                    # if all locations are inactive, display error
                    # query the database to determine if the account is available
                    $getData                    =                   $this->GPLogicData->sql( 'SELECT        sysLocations.id,
                                                                                                            sysLocations.location_name
                                                                                                        
                                                                                              FROM          sysLocations
                                                                                              WHERE         sysLocations.location_pid       =   "CNG"
                                                                                              AND           sysLocations.location_status    =   "A"
                                                                                              AND           FIND_IN_SET( sysLocations.id, "'. $_SESSION['sessAcctLocations'] .'")' );

                    if ( $getData['count'] == 0 ) :

                        # no locations
                        header( 'Location: '. gpConfig['URLPATH'] .'auth/nolocale' );

                    elseif( $getData['count'] == 1 ) :

                        # redirect to specific index
                        # route to index
                        $this->GPLogicSession->setIndex( 'SessionIsStarted', true );
                        header( 'Location: '. gpConfig['URLPATH'] .'auth/route' );

                    elseif ( $getData['count'] > 1 ) :

                        # redirect to specific index
                        header( 'Location: '. gpConfig['URLPATH'] .'auth/selectlocale' );

                    endif;

                endif;
                
            endif;
                
        }

        /**
         * 
         * @name    processRoleSelectioin
         * 
         * @desc    Allows a user with multiple roles to specify current singular 
         *          operational role
         * 
         * @author  Vincent J. Rahming              
         * 
         */
        public function processRoleSelection() {

            # set the account role as a session variable
            $this->GPLogicSession->setIndex( 'sessAcctRole', $_POST['RoleID'] );
                
            # determine if the location has multiple options, assign location automatically
            if ( sizeof( explode( ',', $_SESSION['sessAcctLocations'] ) ) == 1 ) :

                $this->GPLogicSession->setIndex( 'sessAcctLocationName', $this->GPLogicData->sql( 'SELECT   sysLocations.location_name 
                                                                                                   FROM     sysLocations
                                                                                                   WHERE    sysLocations.id = "'. $_SESSION['sessAcctLocations'] .'"')['data'][0]['location_name'] );
                $this->GPLogicSession->setIndex( 'sessAcctLocation', $_SESSION['sessAcctLocations'] );
                $this->GPLogicSession->setIndex( 'SessionIsStarted', true );
                header( 'Location: '. gpConfig['URLPATH'] .'auth' );    # redirect to auth page.
                                                                        # auth page will forward to appropriate page using route function

            else:

                # redirect user to select role
                header( 'Location: '. gpConfig['URLPATH'] .'auth/selectlocale' );

            endif;

        }

        /**
         * 
         * @name    processLocationSelection
         * 
         * @desc    Validates A UserID and Password against the database
         * 
         * @author  Vincent J. Rahming
         * 
         */
        public function processLocationSelection() {
            
            # get the module assignments for the specified location
            $getLocationData            =                   $this->GPLogicData->sql( 'SELECT        sysLocations.location_modules, 
                                                                                                    sysLocations.location_hours

                                                                                      FROM          sysLocations
                                                                                      WHERE         sysLocations.id   =   "'. $_POST['LocationID'] .'"');

            $this->GPLogicSession->setIndex( 'sessAcctLocation', $_POST['LocationID'] );
            $this->GPLogicSession->setIndex( 'sessAcctLocationName', $this->GPLogicData->sql( 'SELECT   sysLocations.location_name 
                                                                                               FROM     sysLocations
                                                                                               WHERE    sysLocations.id = "'. $_POST['LocationID'] .'"')['data'][0]['location_name'] );
            $this->GPLogicSession->setIndex( 'sessLocationModules', $getLocationData['data'][0]['location_modules'] );
            $this->GPLogicSession->setIndex( 'sessLocationHours', $getLocationData['data'][0]['location_hours'] );
            $this->GPLogicSession->setIndex( 'SessionIsStarted', true );
            header( 'Location: ' . gpConfig['URLPATH'] .'auth/route' );
                         
            if ( empty( $getLocationData['data'][0]['location_hours'] ) ) :
                
                return null;

            else:

                $days       =       [];

                foreach( explode( ',', $getLocationData['data'][0]['location_hours'] ) as $HourSet ) :

                    list( $d, $start, $stop )   =   explode( '-', $HourSet );
                    $days[ $d ]     =       [ 'OpenTime' => $start, 'CloseTime' => $stop ];
                                
                endforeach;

                if ( in_array( date('w'), array_keys( $days ) ) ) :

                    // check hours                                
                    if ( ( strtotime( date('Y-m-d') . $days[ date('w') ]['OpenTime'] . ':00' ) <= strtotime( date('Y-m-d H:i') .':00' ) ) AND
                         ( strtotime( date('Y-m-d') . $days[ date('w') ]['CloseTime'] . ':00') >= strtotime( date('Y-m-d H:i') .':00' ) ) ) :

                         // set the account role as a session variable
                         $this->GPLogicSession->setIndex( 'sessAcctLocation', $_POST['LocationID'] );
                         $this->GPLogicSession->setIndex( 'sessAcctLocationName', $this->GPLogicData->sql( 'SELECT   sysLocations.location_name 
                                                                                                            FROM     sysLocations
                                                                                                            WHERE    sysLocations.id = "'. $_POST['LocationID'] .'"')['data'][0]['location_name'] );
                         $this->GPLogicSession->setIndex( 'sessLocationModules', $getLocationData['data'][0]['location_modules'] );
                         $this->GPLogicSession->setIndex( 'sessLocationHours', $getLocationData['data'][0]['location_hours'] );
                         $this->GPLogicSession->setIndex( 'SessionIsStarted', true );
                         header( 'Location: ' . gpConfig['URLPATH'] .'auth/route' );

                    else:
                                
                        header( 'Location: ' .gpConfig['URLPATH'] .'auth/hours' );

                    endif;

                else: 

                    header( 'Location: ' .gpConfig['URLPATH'] .'auth/hours' );

                endif;
                            
            endif;

        }

        /**
         * 
         * @name    processStartSession
         * 
         * @desc    Validates A UserID and Password against the database
         * 
         * @author  Vincent J. Rahming
         *          
         */
        public function processStartSession() {
            
            $this->GPLogicSession->setIndex( 'SessionIsStarted', true );

        }

        /**
         * 
         * @name    setAuthLogout
         * 
         * @desc    Validates A UserID and Password against the database
         * 
         * @author  Vincent J. Rahming
         *          
         */
        public function setAuthLogout() {
            
            # kill all indexes
            $this->GPLogicSession->destroyIndexes();
            
        }
         
    }