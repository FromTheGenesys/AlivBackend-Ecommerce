<?php

    class GPLogicAdministrator extends gpLogic {
        
        public function __construct() {

            parent::__construct();                                
            gpSecurity::enforceSession();
            
        }

        public function GetALIVAccounts() {

            # get aliv accounts
            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Administrators.*
                                                                                
                                                                                      FROM      Administrators
                                                                                      ORDER BY  Administrators.AdminLast ASC' );

            return $getData;

        }

        private function _checkLoginID( $LoginID ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Administrators.*
                                                                                
                                                                                      FROM      Administrators
                                                                                      WHERE     LOWER( Administrators.AdminNetworkID ) = "'. strtolower( $_POST['LoginID'] ) .'"' );

            if ( $getData['count'] == 0 ) :
                
                return false;
                
            else:

                return true;

            endif;

        }

        private function _checkEmailAddress( $EmailAddress ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Administrators.*
                                                                                
                                                                                      FROM      Administrators
                                                                                      WHERE     LOWER( Administrators.AdminEmail ) = "'. strtolower( $_POST['EmailAddress'] ) .'"' );

            if ( $getData['count'] == 0 ) :
                
                return false;
                
            else:

                return true;

            endif;

        }

        public function ProcessAddAlivAccount() {

            if ( empty( $_POST['FirstName'] ) OR
                 empty( $_POST['LastName'] ) OR 
                 empty( $_POST['EmailAddress'] ) OR 
                 empty( $_POST['Role'] ) OR 
                 empty( $_POST['LoginID'] ) ) :

                return 2;

            endif;

            # confirm that login ID is not present
            if ( $this->_checkLoginID( $_POST['LoginID'] ) == true ) :

                return 3;

            endif;

            # confirm that email address is not present
            if ( $this->_checkEmailAddress( $_POST['EmailAddress'] ) == true ) :

                return 4;

            endif;

            # insert user
            $InsertData                     =                  [ 'fields'  =>  'AdminGUID,
                                                                                AdminRole,
                                                                                AdminFirst,
                                                                                AdminLast,
                                                                                AdminNetworkID,
                                                                                AdminEmail,
                                                                                AdminPassword,
                                                                                AdminStatus,
                                                                                AdminCreated',
                     
                                                                 'values'  => [ $this->gpGenerateGUID(),
                                                                                $_POST['Role'],
                                                                                $_POST['FirstName'],
                                                                                $_POST['LastName'],
                                                                                $_POST['LoginID'],
                                                                                $_POST['EmailAddress'],
                                                                                password_hash( $_POST['EmailAddress'], PASSWORD_BCRYPT ),
                                                                                "A",
                                                                                date('Y-m-d H:i:s') ] ];

            $getData                        =                   $this->GPLogicData->insert( 'Administrators', $InsertData );

            return 1;

        }

        public function ProcessUpdateAlivAccount() {

            if ( empty( $_POST['FirstName'] ) OR
                 empty( $_POST['LastName'] ) OR 
                 empty( $_POST['EmailAddress'] ) OR 
                 empty( $_POST['Role'] ) OR 
                 empty( $_POST['LoginID'] ) ) :

                return 2;

            endif;

            if ( $_POST['LoginID'] != $_POST['LoginIDOld'] ) :

                if ( $this->_checkLoginID( $_POST['LoginID'] ) == true )  :

                    return 3;

                endif;

            endif;

            if ( $_POST['EmailAddress'] != $_POST['EmailAddressOld'] ) :
            
                if ( $this->_checkEmailAddress( $_POST['EmailAddress'] ) == true )  :

                    return 4;

                endif;

            endif;

            $updateData                     =                   $this->GPLogicData->update( 'Administrators',
                                                                                            'AdminFirst     =    "'. $_POST['FirstName'] .'",
                                                                                             AdminLast      =    "'. $_POST['LastName'] .'",
                                                                                             AdminEmail     =    "'. strtolower( $_POST['EmailAddress'] ) .'",
                                                                                             AdminRole      =    "'. $_POST['Role'] .'",
                                                                                             AdminStatus    =    "'. $_POST['Status'] .'",
                                                                                             AdminNetworkID =   "'. strtolower( $_POST['LoginID'] ) .'"',                    
                                                                                            'WHERE Administrators.AdminID    = "'. $_POST['AdminID'] .'"' );

            return 1;

        }

        public function GetALIVPlans() {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Plans.*
                                                                                
                                                                                      FROM      Plans
                                                                                      ORDER BY  Plans.PlanGroupID ASC' );

            return $getData;

        }

        public function GetEligiblePlans() {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    PlanEligible.*
                                                                                
                                                                                      FROM      PlanEligible
                                                                                      ORDER BY  PlanEligible.PlanPriority ASC' );

            return $getData;

        }

        public function ProcessMakePlanEligible() {

            if ( isset( $_POST['PlanID'] ) ) :

                foreach( $_POST['PlanID'] as $PlanID ) :

                    # determine if the plan ID is not in the elible table already

                    if ( $this->GPLogicData->sql( 'SELECT    PlanEligible.*
                                                                                
                                                   FROM      PlanEligible   
                                                   WHERE     PlanEligible.PlanID = "'. $PlanID .'"' )['count'] == 0 ) : 

                        $getData                     =                  $this->GPLogicData->sql( 'SELECT    Plans.*
                                                                                    
                                                                                                FROM      Plans   
                                                                                                WHERE     Plans.PlanID = "'. $PlanID .'"' );


                        $InsertData                  =                 [ 'fields'  =>  'PlanID,
                                                                                        PlanPriority,
                                                                                        PlanGroupID,
                                                                                        PlanGroupName,
                                                                                        PlanName,
                                                                                        PlanDescription,
                                                                                        PlanCost',
                        
                                                                        'values'  => [ $PlanID,
                                                                                        0,
                                                                                        $getData['data'][0]['PlanGroupID'],
                                                                                        $getData['data'][0]['PlanGroupName'],
                                                                                        $getData['data'][0]['PlanName'],
                                                                                        $getData['data'][0]['PlanDescription'],
                                                                                        $getData['data'][0]['PlanCost'] ] ];

                        $getData                    =                   $this->GPLogicData->insert( 'PlanEligible', $InsertData );

                    endif;                        

                endforeach;

            else:

                return 2;

            endif;

        }

        public function ProcessSortEligible() {

            $count  =   0;

            foreach( $_POST['PlanID'] as $PlanID ) :

                $updateData                         =                   $this->GPLogicData->update( 'PlanEligible',
                                                                                                    'PlanPriority     =    "'. $_POST['Priority'][ $count ] .'"',                    
                                                                                                    'WHERE PlanEligible.PlanID  = "'. $PlanID .'"' );

                ++$count;

            endforeach;

        }

        public function CheckPlanEligibility( $PlanID ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    PlanEligible.PlanID
                                                                                
                                                                                      FROM      PlanEligible
                                                                                      WHERE     PlanEligible.PlanID = "'. $PlanID .'"' );

            if ( $getData['count'] == 0 ) :
                
                return false;
                
            else:

                return true;

            endif;

        }
        
        public function ProcessRemoveEligible() {

            $getData                     =                  $this->GPLogicData->delete( 'PlanEligible',
                                                                                        'WHERE     PlanEligible.PlanID = "'. $_POST['PlanID'] .'"' );

        }

        public function ProcessAddMakes() {

            if ( empty( $_POST['MakeName'] ) ) :

                return 2;

            endif;

            // check to see if brand being uploaded already exists
            if ( $this->_checkMakeName( $_POST['MakeName'] ) == true )  :
                
                return 3;

            endif;

            if ( $_FILES['MakeLogo']['error'] != 0 ) :

                # check the file size
                if ( $_FILES['MakeLogo']['size'] > 2000000 ) :

                    return 4;

                endif;

                $MakeTypes  =   [ 'image/png', 'image/jpeg' ];

                if ( !in_array( $_FILES['MakeLogo']['type'], $MakeTypes )  ) :

                    return 5;

                endif;
                
            endif;


            # insert user
            $InsertData                     =                  [ 'fields'  =>  'MakeGUID,
                                                                                MakeName,
                                                                                MakeDescription,
                                                                                MakeStatus,
                                                                                MakeCreated',
                     
                                                                 'values'  => [ $this->gpGenerateGUID(),
                                                                                strtoupper( $_POST['MakeName'] ),
                                                                                str_replace( ",", "", $_POST['MakeDesc'] ),
                                                                                "A",                                                                                
                                                                                date('Y-m-d H:i:s') ] ];

            $getData                        =                   $this->GPLogicData->insert( 'Makes', $InsertData );

            // print_r( $getData );

            if ( !file_exists( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $getData['insertID'] .'/' ) ) :

                mkdir( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $getData['insertID'] .'/' , 0777 );

            endif;

            $NameStamp                       =                  date('Ymdhis');

            move_uploaded_file( $_FILES['MakeLogo']['tmp_name'], gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $getData['insertID'] .'/n_'. $NameStamp .'.'. explode( '/', $_FILES['MakeLogo']['type'] )[1] );

            $updateData                      =                  $this->GPLogicData->update( 'Makes',
                                                                                            'Makes.MakeLogo     =    "n_'. $NameStamp .'.'. explode( '/', $_FILES['MakeLogo']['type'] )[1] .'"',                    
                                                                                            'WHERE Makes.MakeID =    "'. $getData['insertID'] .'"' );

            return 1;


        }


        public function ProcessUpdateMake() {

            if ( empty( $_POST['MakeName'] ) ) :

                return 2;

            endif;

            // check to see if brand being uploaded already exists
            if ( $_POST['MakeName'] != $_POST['MakeNameOld'] )  :
                
                if ( $this->_checkMakeName( $_POST['MakeName'] ) == true )  :
                    
                    return 3;

                endif;

            endif;

            if ( isset( $_POST['overwrite'] ) ) : 

                if ( !empty( $_FILES['MakeLogo']['name'] ) ) :

                    if ( $_FILES['MakeLogo']['size'] > 2000000 ) :

                        return 4;

                    endif;

                    $MakeTypes  =   [ 'image/png', 'image/jpeg' ];

                    if ( !in_array( $_FILES['MakeLogo']['type'], $MakeTypes )  ) :

                        return 5;

                    endif;

                    if ( !file_exists( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/' ) ) :

                        mkdir( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/' , 0777 );
        
                    endif;

                    $NameStamp                       =                  date('Ymdhis');

                    move_uploaded_file( $_FILES['MakeLogo']['tmp_name'], gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/n_'. $NameStamp .'.'. explode( '/', $_FILES['MakeLogo']['type'] )[1] );

                    $updateData                      =                  $this->GPLogicData->update( 'Makes',
                                                                                                    'Makes.MakeName     =    "'. strtoupper( $_POST['MakeName'] ) .'",
                                                                                                     Makes.MakeDescription = "'. str_replace( ",", "", $_POST['MakeDesc'] ) .'",
                                                                                                     Makes.MakeStatus   =    "'. $_POST['MakeStatus'] .'",
                                                                                                     Makes.MakeLogo     =    "n_'. $NameStamp .'.'. explode( '/', $_FILES['MakeLogo']['type'] )[1] .'"',                    
                                                                                                    'WHERE Makes.MakeID =    "'. $_POST['MakeID'] .'"' );

                    return 1;

                endif;
            
            else: 

                if ( !empty( $_FILES['MakeLogo']['name'] ) ) :

                    # check the file size
                    if ( $_FILES['MakeLogo']['size'] > 2000000 ) :

                        return 4;

                    endif;

                    $MakeTypes  =   [ 'image/png', 'image/jpeg' ];

                    if ( !in_array( $_FILES['MakeLogo']['type'], $MakeTypes )  ) :

                        return 5;

                    endif;

                    if ( !file_exists( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/' ) ) :

                        mkdir( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/' , 0777 );
        
                    endif;

                    if ( !file_exists( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/' ) ) :

                        mkdir( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/' , 0777 );
        
                    endif;

                    $NameStamp                       =                  date('Ymdhis');

                    move_uploaded_file( $_FILES['MakeLogo']['tmp_name'], gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Makes/'. $_POST['MakeID'] .'/n_'. $NameStamp .'.'. explode( '/', $_FILES['MakeLogo']['type'] )[1] );

                    $updateData                      =                  $this->GPLogicData->update( 'Makes',
                                                                                                    'Makes.MakeName     =    "'. strtoupper( $_POST['MakeName'] ) .'",
                                                                                                     Makes.MakeDescription = "'. str_replace( ",", "", $_POST['MakeDesc'] ) .'",
                                                                                                     Makes.MakeStatus   =    "'. $_POST['MakeStatus'] .'",
                                                                                                     Makes.MakeLogo     =    "n_'. $NameStamp .'.'. explode( '/', $_FILES['MakeLogo']['type'] )[1] .'"',                    
                                                                                                    'WHERE Makes.MakeID =    "'. $_POST['MakeID'] .'"' );

                                                                                                    

                    return 1;

                else:


                    $updateData                      =                  $this->GPLogicData->update( 'Makes',
                                                                                                    'Makes.MakeName     =    "'. strtoupper( $_POST['MakeName'] ) .'",
                                                                                                     Makes.MakeDescription = "'. str_replace( ",", "", $_POST['MakeDesc'] ) .'",
                                                                                                     Makes.MakeStatus   =    "'. $_POST['MakeStatus'] .'"',                    
                                                                                                    'WHERE Makes.MakeID =    "'. $_POST['MakeID'] .'"' );

                    return 1;

                endif;
                
            endif;


        }
        

        private function _checkMakeName( $MakeName ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Makes.*
                                                                                
                                                                                      FROM      Makes
                                                                                      WHERE     UPPER( Makes.MakeName ) = "'. strtoupper( $_POST['MakeName'] ) .'"' );

            if ( $getData['count'] == 0 ) :
                
                return false;
                
            else:

                return true;

            endif;

        }

        public function GetMakes() {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Makes.*
                                                                                
                                                                                      FROM      Makes
                                                                                      ORDER BY  Makes.MakeName ASC' );

            return $getData;

        }

        public function ProcessAddDevice() {

            if ( empty( $_POST['DeviceName'] ) OR 
                 empty( $_POST['DeviceCost'] ) OR
                 empty( $_POST['DeviceSKU'] ) ) :

                 return 2;

            endif;

            if ( $this->_checkDeviceName( $_POST['MakeID'], $_POST['DeviceName'] ) == true ) :

                return 3;

            endif;

            if ( !is_numeric( $_POST['DeviceCost'] ) OR 
                 ( $_POST['DeviceCost'] <= 0 ) )  :

                 return 4;

            endif;

            $PlanRequired                   =                   ( isset( $_POST['PlanRequired'] ) ? $_POST['DeviceMinimumPlan'] :  NULL );

            # insert user
            $InsertData                     =                  [ 'fields'  =>  'DeviceGUID,
                                                                                DeviceMake,
                                                                                DeviceName,
                                                                                DeviceDescription,                                                                                
                                                                                DeviceSKU,
                                                                                DeviceCost,
                                                                                DevicePlanRequired,
                                                                                DeviceStatus,
                                                                                DeviceCreated',
                     
                                                                 'values'  => [ $this->gpGenerateGUID(),
                                                                                strtoupper( $_POST['MakeID'] ),
                                                                                $_POST['DeviceName'],
                                                                                str_replace( ",", "", $_POST['DeviceDescription'] ),
                                                                                $_POST['DeviceSKU'],
                                                                                $_POST['DeviceCost'],
                                                                                $PlanRequired,
                                                                                "A",                                                                                
                                                                                date('Y-m-d H:i:s') ] ];

            $getData                        =                   $this->GPLogicData->insert( 'Devices', $InsertData );

            if ( !empty( $_FILES['DeviceCover']['name'] ) ) :

                # check the file size
                if ( $_FILES['DeviceCover']['size'] > 2000000 ) :

                    return 5;

                endif;

                $DeviceTypes  =   [ 'image/png', 'image/jpeg' ];

                if ( !in_array( $_FILES['DeviceCover']['type'], $DeviceTypes )  ) :

                    return 6;

                endif;
                
            endif;

            if ( !file_exists( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Devices/'. $getData['insertID'] .'/' ) ) :

                mkdir( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Devices/'. $getData['insertID'] .'/' , 0777 );

            endif;

            if ( !empty( $_FILES['DeviceCover']['name'] ) ) :

                $NameStamp                       =                  date('Ymdhis');

                move_uploaded_file( $_FILES['DeviceCover']['tmp_name'], gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Devices/'. $getData['insertID'] .'/n_'. $NameStamp .'.'. explode( '/', $_FILES['DeviceCover']['type'] )[1] );

                # insert user
                $InsertCoverData                     =            [ 'fields'  =>   'ImageGUID,
                                                                                    DeviceID,
                                                                                    ImageName,
                                                                                    ImageType,
                                                                                    ImageSize',
                        
                                                                    'values'  => [ $this->gpGenerateGUID(),
                                                                                    $getData['insertID'],
                                                                                    'n_'. $NameStamp .'.'. explode( '/', $_FILES['DeviceCover']['type'] )[1],
                                                                                    $_FILES['DeviceCover']['type'],
                                                                                    $_FILES['DeviceCover']['size'] ] ];

                $setCoverData                    =                  $this->GPLogicData->insert( 'DeviceImages', $InsertCoverData );

                
                $updateData                      =                  $this->GPLogicData->update( 'Devices',
                                                                                                'Devices.DeviceCover        =    "'. $setCoverData['insertID'] .'"',                    
                                                                                                'WHERE Devices.DeviceID     =    "'. $getData['insertID'] .'"' );

                                                                                                print_r( $updateData );

            endif;

            return 1;
            
        }

        private function _checkDeviceName( $MakeID, $DeviceName ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Devices.*
                                                                                
                                                                                      FROM      Devices
                                                                                      WHERE     UPPER( Devices.DeviceName ) = "'. strtoupper( $DeviceName ) .'"
                                                                                      AND       Devices.DeviceMake = "'. $MakeID .'"' );

            if ( $getData['count'] == 0 ) :
                
                return false;
                
            else:

                return true;

            endif;

        }

        public function GetMakeDevices( $MakeID ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Devices.*
                                                                                
                                                                                      FROM      Devices
                                                                                      WHERE     Devices.DeviceMake  = "'. $MakeID .'"
                                                                                      ORDER BY  Devices.DeviceName ASC ' );

            return $getData;                                                                                    

        }

        public function ProcessUpdateDevice() {

            if ( empty( $_POST['DeviceName'] ) OR 
                 empty( $_POST['DeviceCost'] ) OR
                 empty( $_POST['DeviceSKU'] ) ) :

                 return 2;

            endif;

            if ( $_POST['DeviceName'] != $_POST["DeviceNameOld"] ) : 

                if ( $this->_checkDeviceName( $_POST['MakeID'], $_POST['DeviceName'] ) == true ) :

                    return 3;

                endif;

            endif;
            
            if ( !is_numeric( $_POST['DeviceCost'] ) OR 
                 ( $_POST['DeviceCost'] <= 0 ) )  :

                 return 4;

            endif;

            $PlanRequired                   =                   ( isset( $_POST['PlanRequired'] ) ? $_POST['DeviceMinimumPlan'] :  NULL );

            $updateData                     =                   $this->GPLogicData->update( 'Devices',
                                                                                            'Devices.DeviceName         =    "'. $_POST['DeviceName'] .'",
                                                                                             Devices.DeviceDescription  =    "'. str_replace( ",", "", $_POST['DeviceDescription'] ).'",
                                                                                             Devices.DeviceCost         =    "'. $_POST['DeviceCost'].'",
                                                                                             Devices.DeviceStatus       =    "'. $_POST['DeviceStatus'] .'",
                                                                                             Devices.DevicePlanRequired =    "'. $PlanRequired .'",
                                                                                             Devices.DeviceSKU          =    "'. $_POST['DeviceSKU'] .'"',                    
                                                                                            'WHERE Devices.DeviceID     =    "'. $_POST['DeviceID'] .'"' );

            return 1;                                                                                            

        }

        public function ProcessAddMakeAttributes( ) {

            foreach( explode( "\r", $_POST['Attributes'] ) as $AttrSet ) :

                if ( $this->_checkAttributeName( $_POST['MakeID'], trim( $AttrSet ) ) == false ) :

                    # insert user
                    $InsertData                         =            [ 'fields'  =>   'MakeID,
                                                                                       AttributeGUID,
                                                                                       AttributeName,
                                                                                       AttributeStatus,
                                                                                       AttributeCreated',
                            
                                                                        'values'  => [ $_POST['MakeID'],
                                                                                       $this->gpGenerateGUID(),
                                                                                       trim( $AttrSet ),
                                                                                       "A",
                                                                                       date('Y-m-d H:i:s')
                                                                                        ] ];

                    $setCoverData                       =             $this->GPLogicData->insert( 'Attributes', $InsertData );

                endif;

            endforeach;

        }

        private function _checkAttributeName( $MakeID, $AttrName ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Attributes.*
                                                                                
                                                                                      FROM      Attributes
                                                                                      WHERE     Attributes.MakeID = "'. $MakeID .'"
                                                                                      AND       UPPER( Attributes.AttributeName ) = "'. strtoupper( $AttrName ) .'"' );

            if ( $getData['count'] == 0 ) :
                
                return false;
                
            else:

                return true;

            endif;

        }


        public function GetDeviceAttributes() {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Attributes.*,
                                                                                                Makes.MakeName
                                                                                
                                                                                      FROM      Attributes
                                                                                      LEFT JOIN Makes
                                                                                      ON        Makes.MakeID    =    Attributes.MakeID

                                                                                      ORDER BY  Attributes.MakeID ASC, Attributes.AttributeName ASC ' );

            return $getData;                                                                                    

        }

        public function ProcessUpdateMakeAttributes() {

            if ( empty( $_POST['AttributeName'] ) ) :

                return 2;

            endif;

            if( $_POST['AttributeName'] != $_POST['AttributeNameOld'] ) :

                if ( $this->_checkAttributeName( $_POST['MakeID'], trim( $_POST['AttributeName'] ) ) == true ) :

                    return 3;

                endif;

            endif;

            $updateData                     =                   $this->GPLogicData->update( 'Attributes',
                                                                                            'Attributes.AttributeName         =    "'. $_POST['AttributeName'] .'",
                                                                                             Attributes.AttributeDescription  =    "'. str_replace( ",", "", $_POST['AttributeDescription'] ).'",
                                                                                             Attributes.AttributeStatus       =    "'. $_POST['AttributeStatus'].'"',                    
                                                                                            'WHERE Attributes.AttributeID     =    "'. $_POST['AttributeID'] .'"' );

            return 1;                                                                                            

        }


        public function GetAttributeSet( $MakeID ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    Attributes.*,
                                                                                                Makes.MakeName
                                                                                
                                                                                      FROM      Attributes
                                                                                      LEFT JOIN Makes
                                                                                      ON        Makes.MakeID    =    Attributes.MakeID

                                                                                      WHERE     Attributes.MakeID   =   "'. $MakeID .'"
                                                                                      ORDER BY  Attributes.MakeID ASC, Attributes.AttributeName ASC ' );

            return $getData;   
            
        }   

        public function ProcessDeviceAttributes() {

            if ( !isset( $_POST['AttributeID'] ) ) :

                $Attributes     =   NULL;

            else:

                $Attributes     =   implode( ',', $_POST['AttributeID'] );
                
            endif;

            $updateData                     =                   $this->GPLogicData->update( 'Devices',
                                                                                            'Devices.DeviceAttributes         =    "'. $Attributes .'"',                    
                                                                                            'WHERE Devices.DeviceID           =    "'. $_POST['DeviceID'] .'"' );

        }

        public function ProcessUploadPhotos() {

            if ( !empty( $_FILES['DevicePhotos'] ) ) :

                $count          =   0;

                $DeviceTypes    =   [ 'image/png', 'image/jpeg' ];

                foreach( $_FILES['DevicePhotos']['name'] as $PhotoName ) :

                    if ( $_FILES['DevicePhotos']['error'][$count] == 0 ) :

                        if ( $_FILES['DevicePhotos']['size'][$count] <= 2000000 ) :

                            if ( in_array( $_FILES['DevicePhotos']['type'][$count], $DeviceTypes ) ) :

                                $NameStamp                       =                  $count .'_'. date('Ymdhis');
                                move_uploaded_file( $_FILES['DevicePhotos']['tmp_name'][$count], gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Devices/'. $_POST['DeviceID'] .'/n_'. $NameStamp .'.'. explode( '/', $_FILES['DevicePhotos']['type'][$count] )[1] );

                                # insert user
                                $InsertCoverData                     =            [ 'fields'  =>   'ImageGUID,
                                                                                                    DeviceID,
                                                                                                    ImageName,
                                                                                                    ImageType,
                                                                                                    ImageSize',
                                        
                                                                                    'values'  => [ $this->gpGenerateGUID(),
                                                                                                    $_POST['DeviceID'],
                                                                                                    'n_'. $NameStamp .'.'. explode( '/', $_FILES['DevicePhotos']['type'][$count] )[1],
                                                                                                    $_FILES['DevicePhotos']['type'][$count],
                                                                                                    $_FILES['DevicePhotos']['size'][$count] ] ];

                                $setCoverData                    =                  $this->GPLogicData->insert( 'DeviceImages', $InsertCoverData );


                            endif;

                        endif;

                    endif;

                    ++$count;
                    
                endforeach;

            endif;

           return 1;

        }

        public function GetDevicePhotos( $DeviceID ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    DeviceImages.*
                                                                                
                                                                                      FROM      DeviceImages                                                                                     
                                                                                      WHERE     DeviceImages.DeviceID   =   "'. $DeviceID .'"
                                                                                      ORDER BY  DeviceImages.ImageUploaded ASC' );

            return $getData;   

        }

        public function ProcessPhotoUpdates() {

            $updateData                  =                  $this->GPLogicData->update( 'Devices',
                                                                                        'Devices.DeviceCover         =    "'. $_POST['DeviceCover'] .'"',                    
                                                                                        'WHERE Devices.DeviceID      =    "'. $_POST['DeviceID'] .'"' );

            foreach( $_POST['DeletePhoto'] as $DeletePhoto ) :
                
                // if the cover of the photo is different
                $getData                 =                  $this->GPLogicData->sql( 'SELECT    Devices.*
                                                                                
                                                                                      FROM      Devices                                                                                     
                                                                                      WHERE     Devices.DeviceCover   =   "'. $DeletePhoto .'"' );

                if ( $getData['count'] == 1 ) :

                    $GetDevicePhotos     =                  $this->GetDevicePhotos( $_POST['DeviceID'] );

                    $this->GPLogicData->update( 'Devices',
                                                'Devices.DeviceCover         =    "'. $GetDevicePhotos['data'][0]['ImageID'] .'"',                    
                                                'WHERE Devices.DeviceID      =    "'. $_POST['DeviceID'] .'"' );

                endif; 

                $updateData              =                  $this->GPLogicData->delete( 'DeviceImages',
                                                                                        'WHERE DeviceImages.ImageID  =    "'. $DeletePhoto .'"' );
                                                                                       

            endforeach;

        }

        public function ProcessAccessoriesUpdates() {

            foreach( $_POST['DeleteAccessory'] as $MarkAccssory ) :
                
                $updateData              =                  $this->GPLogicData->update( 'DeviceAccessories',
                                                                                        'AccessoryStatus = "I"',
                                                                                        'WHERE DeviceAccessories.AccessoryID  =    "'. $MarkAccssory .'"' );
                                                                 
                print_r( $updateData );                                                                                        

            endforeach;

        }

        private function _checkAccessoryName( $DeviceID, $AccessoryName ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    DeviceAccessories.*
                                                                                
                                                                                      FROM      DeviceAccessories                                                                                     
                                                                                      WHERE     DeviceAccessories.DeviceID   =   "'. $DeviceID .'"
                                                                                      AND       UPPER( DeviceAccessories.AccessoryName ) = "'. strtoupper( $AccessoryName ) .'"' );

            if ( $getData['count'] == 0 ) : 

                return false;
                
            else:

                return true;

            endif;

        }

        public function ProcessAddAccessory() {

            if ( empty( $_POST['AccessoryName'] ) OR 
                 empty( $_POST['AccessoryCost'] ) OR
                 empty( $_FILES['AccessoryCover']['name'] ) ) :

                 return 2;

            endif;

            if ( $this->_checkAccessoryName( $_POST['DeviceID'], $_POST['AccessoryName'] ) == true ) :

                return 3;

            endif;

            if ( ( !is_numeric( $_POST['AccessoryCost'] ) ) OR 
                 ( $_POST['AccessoryCost'] <= 0  ) ) :    
            
                return 4;

            endif;

            if ( !empty( $_FILES['AccessoryCover']['name'] ) ) :

                # check the file size
                if ( $_FILES['AccessoryCover']['size'] > 2000000 ) :

                    return 5;

                endif;

                $DeviceTypes  =   [ 'image/png', 'image/jpeg' ];

                if ( !in_array( $_FILES['AccessoryCover']['type'], $DeviceTypes )  ) :

                    return 6;

                endif;
                
            endif;


            $NameStamp                       =                date('Ymdhis');

             # insert user
            $InsertCoverData                 =                [ 'fields'  =>   'AccessoryGUID,
                                                                                MakeID,
                                                                                DeviceID,
                                                                                AccessoryName,
                                                                                AccessoryDescription,
                                                                                AccessoryCover,
                                                                                AccessoryCost,
                                                                                AccessoryStatus,
                                                                                AccessoryCreated',
                    
                                                                'values'  => [ $this->gpGenerateGUID(),
                                                                                $_POST['MakeID'],
                                                                                $_POST['DeviceID'],
                                                                                str_replace( ",", "", $_POST['AccessoryName'] ),
                                                                                str_replace( ",", "", $_POST['AccessoryDescription'] ),                                                                                
                                                                                'n_'. $NameStamp .'.'. explode( '/', $_FILES['AccessoryCover']['type'] )[1],
                                                                                $_POST['AccessoryCost'],
                                                                                $_POST['AccessoryStatus'],
                                                                                date('Y-m-d H:i:s') ] ];

            $setCoverData                    =                  $this->GPLogicData->insert( 'DeviceAccessories', $InsertCoverData );

            if ( !file_exists( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Accessories/'. $setCoverData['insertID'] .'/' ) ) :

                mkdir( gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Accessories/'. $setCoverData['insertID'] .'/' , 0777 );

            endif;

            // if ( !empty( $_FILES['DeviceCover']['name'] ) ) :

            move_uploaded_file( $_FILES['AccessoryCover']['tmp_name'], gpConfig['BASEPATH'] . gpConfig['DATA'] . gpConfig['UPLOADS'] . 'Accessories/'. $setCoverData['insertID'] .'/n_'. $NameStamp .'.'. explode( '/', $_FILES['AccessoryCover']['type'] )[1] );

               
        }

        public function GetDeviceAccesories( $DeviceID ) {

            $getData                     =                  $this->GPLogicData->sql( 'SELECT    DeviceAccessories.*
                                                                                
                                                                                      FROM      DeviceAccessories                                                                                     
                                                                                      WHERE     DeviceAccessories.DeviceID   =   "'. $DeviceID .'"
                                                                                      AND       DeviceAccessories.AccessoryStatus = "A"' );

            return $getData;                                                                                      

        }

    }