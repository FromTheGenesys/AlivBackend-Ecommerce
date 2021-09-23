<?php

    class Dashboard extends gpRouter {
        
        public function __construct() {

            parent::__construct();
            gpSecurity::enforceSession();

            # if you have no access to this area, redirect to the appropriate page
            $this->render->LogicDashboard     =   new GPLogicDashboard();                       # include LogicDashboard Library            
            $this->render->setParams          =   [ 'header'  =>  'Dashboard/Header',
                                                    'footer'  =>  'Dashboard/Footer' ];         # include specific header and footer for /Dashboard/ pages
        
        }
    
        public function getindex() {
            
            # if session is not active and started, force the login prompt
            $this->render->page( 'Dashboard/Dashboard', $this->render->setParams  );
            
        }

        /**
         * @name    accounts
         * @desc    views all system user accounts ( across all tiers )
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function accounts() {

            $this->render->GetAllAccounts                   =                   $this->render->LogicAdministrator->GetAllAccounts();            
            $this->render->page( 'Administrator/Accounts', $this->render->setParams );

        }

        /**
         * @name    accountcreate() {
         * @desc    create accounts across all levels
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function accountcreate() {
            
            $this->render->GetUserStatus                =                   $this->render->LogicAdministrator->SetUserStatus();            
            $this->render->page( 'Administrator/AccountCreate', $this->render->setParams );

        }

        /**
         * @name    createaccountauth
         * @desc    processes the creation of account
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function accountcreateauth() {
            
            $this->process                                  =                   $this->render->LogicAdministrator->ProcessCreateAccount();

            if ( $this->process == 1 ) :

                $this->render->setMessage                   =                   [ 'success', '' ];               
                $this->account( $this->render->AccountID );

            else:

                if ( $this->process == 2 ) :
            
                    $this->render->setMessage               =                   [ 'danger', 'Required Fields Missing.  All fields are required. Please ensure that each field contains an appropriate value. ' ];               
                    $this->createaccount();

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Invalid Email Address.  Please ensure that a valid email address is provided. ' ];               
                    $this->accountcreate();

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Email Address On File.  The Email Address that was provided is already attached to another account. ' ];               
                    $this->accountcreate();

                elseif ( $this->process == 5 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Password provided does not meet the required standard.  All passwords must contain at least eight (8) characters, one (1) uppercase letter, one (1) lowercase letter, one (1) numeric character and one (1) special character.' ];               
                    $this->accountcreate();

                elseif ( $this->process == 6 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Password Mismatch. The Passwords provided do not match.' ];               
                    $this->accountcreate();

                endif;

            endif;

        }

        /**
         * @name    updateaccount
         * @desc    allows for the update of account
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function accountupdate() {
            
            $this->render->AccountGUID                      =                   func_get_arg( 0 );
            $this->render->GetAccount                       =                   $this->render->LogicAdministrator->GetAdminAccount( $this->render->AccountGUID );
            
            if ( $this->render->GetAccount['count'] == 0 ) : 

                $this->render->page( 'Utility/404', $this->render->setParams );

            else:

                $this->render->GetUserStatus                =                   $this->render->LogicAdministrator->SetUserStatus();                
                $this->render->page( 'Administrator/AccountUpdate', $this->render->setParams );

            endif;

        }

        /**
         * @name    updateaccountauth
         * @desc    processes the update of a user account
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function accountupdateauth() {

            $this->render->AccountID                        =                   func_get_arg( 0 );
            $this->process                                  =                   $this->render->LogicAdministrator->ProcessUpdateDigitillAccount( $this->render->AccountID );

            if ( $this->process == 1 ) :

                $this->render->setMessage                   =                   [ 'success', 'DigiTILL user account has been successfully updated.' ];               
                $this->account( $this->render->AccountID );

            else:

                if ( $this->process == 2 ) :
            
                    $this->render->setMessage               =                   [ 'danger', 'Required Fields Missing.  All fields are required. Please ensure that each field contains an appropriate value. ' ];               
                    $this->accountupdate( $this->render->AccountID );

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Invalid Email Address.  Please ensure that a valid email address is provided. ' ];               
                    $this->accountupdate( $this->render->AccountID );

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Email Address On File.  The email address that was provided is already attached to another account. ' ];               
                    $this->accountupdate( $this->render->AccountID );

                elseif ( $this->process == 5 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Operator ID on File.  The Operator ID that was provided is already attached to another account.' ];               
                    $this->accountupdate( $this->render->AccountID );

                elseif ( $this->process == 6 ) :

                    $this->render->setMessage               =                   [ 'danger', 'Control Group ID on File.  The Control Group ID that was provided is already attached to another account.' ];               
                    $this->accountupdate( $this->render->AccountID );

                endif;

            endif;
            
        }

        /**
         * @name    account
         * @desc    allows the viewing of a specific account
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function account() {
            
            $this->render->AccountID                        =                   func_get_arg( 0 );

            # if reset password is invoked
            if ( isset( $_POST['btnReset'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessResetPassword( $this->render->AccountID );

                if ( $this->process == 1 ) :

                    $this->render->setMessage               =                   [ 'success', 'Password was successfully updated. ' ];               
    
                elseif( $this->process == 2 ) :
    
                    $this->render->setMessage               =                   [ 'danger', 'All fields are required.' ];               
    
                elseif( $this->process == 3 ) :
    
                    $this->render->setMessage               =                   [ 'danger', 'Password provided does not meet the required standard.  All passwords must contain at least eight (8) characters, one (1) uppercase letter, one (1) lowercase letter, one (1) numeric character and one (1) special character.' ];               
    
                elseif( $this->process == 4 ) :
    
                    $this->render->setMessage               =                   [ 'danger', 'Password Mismatch. The Passwords provided do not match.' ];               
    
                endif;

            endif;

            # if update is invoked
            if ( isset( $_POST['btnUpdate'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessUpdateAccount( $this->render->AccountID );
             
                if ( $this->process == 1 ) :

                    $this->render->setMessage               =                   [ 'success', 'Account Details were successfully updated. ' ];               
    
                elseif( $this->process == 2 ) :
    
                    $this->render->setMessage               =                   [ 'danger', 'All fields are required.' ];               
    
                elseif( $this->process == 3 ) :
    
                    $this->render->setMessage               =                   [ 'danger', 'Email Address provided is invalid.' ];               
    
                elseif( $this->process == 4 ) :
    
                    $this->render->setMessage               =                   [ 'danger', 'Email Address Mismatch. The Email Addresses provided do not match.' ];               
    
                endif;


            endif;

            $this->render->GetAccount                       =                   $this->render->LogicAdministrator->GetAccount( $this->render->AccountID );
            
            if ( $this->render->GetAccount['count'] == 0 ) : 

                $this->render->page( 'Utility/404', $this->render->setParams );

            else:

                

                $this->render->GetUserStatus                =                   $this->render->LogicAdministrator->SetUserStatus();                
                $this->render->page( 'Administrator/Account', $this->render->setParams );

            endif;

        }

        public function apifunctions() {

            $this->render->APIGUID                          =                   func_get_arg( 0 );
            $this->render->GetAPI                           =                   $this->render->LogicAdministrator->GetAPIByGUID( $this->render->APIGUID );
            $this->render->GetAPIFunctions                  =                   $this->render->LogicAdministrator->GetAPIFunctions( $this->render->GetAPI['data'][0]['APIName'] );
            $this->render->page( 'Administrator/APIFunctions', $this->render->setParams );
        }

        
        /**
         * @name    apis
         * @desc    views all apis ( based on search parameters )
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function apis() {

            if ( isset( $_POST['btnRegisterAPI'] ) ) :

                $this->process                              =                   $this->render->LogicDashboard->RegisterAPI();

                if ( $this->process == 1 ) :

                    $this->render->setMessage               =                   [ 'success', 'API successfully registered.' ];               

                endif;

            endif;


            if ( isset( $_POST['btnUpdateAPI'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessUpdateAPI();

                if ( $this->process == 1 ) :

                    $this->render->setMessage               =                   [ 'success', 'API successfully updated.' ];               

                endif;


            endif;

            // $this->render->GetDirectory                     =                   $this->render->LogicAdministrator->GetAPIDirectory();
            $this->render->GetAPIS                          =                   $this->render->LogicDashboard->GetRegisteredAPIs();
            $this->render->page( 'Dashboard/API', $this->render->setParams );

        }

        /**
         * @name    api
         * @desc    api views the details of a specific api
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function api() {

            $this->render->APIGUID                          =                   func_get_arg( 0 );

            if ( isset( $_POST['btnUpdateAPI'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessUpdateAPI();

            endif;

            if ( isset( $_POST['btnDefineError'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessDefineError();

            endif;
            
            if ( isset( $_POST['btnUpdateError'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessUpdateError( $_POST['RecordID'] );

            endif;
            
            if ( isset( $_POST['btnDeleteError'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessDeleteError( $_POST['RecordID'] );

            endif;
            

            $this->render->GetAPI                           =                   $this->render->LogicDashboard->GetAPIByGUID( $this->render->APIGUID );
            $this->render->GetAPIUsage                      =                   $this->render->LogicDashboard->GetAPIDistinctUsage($this->render->GetAPI['data'][0]['APIName'] );
            // $this->render->GetAPITotal                      =                   $this->render->LogicDashboard->GetAPIUsageTotal($this->render->GetAPI['data'][0]['APIName'] );
            $this->render->GetAssignedOperators             =                   $this->render->LogicDashboard->GetAssignmentOperators( $this->render->GetAPI['data'][0]['APIName'] );
            $this->render->NextError                        =                   $this->render->LogicDashboard->GetNextErrorCode();

            $this->render->NextError                        =                   $this->render->LogicDashboard->GetNextErrorCode();

            $this->render->GetDates                         =                   $this->render->LogicDashboard->GetUsageWeek( $this->render->GetAPI['data'][0]['APIName'] );
            $this->render->page( 'Dashboard/APIDetail', $this->render->setParams );

        }

        /**
         * @name    operator
         * @desc    operator shows the details of a specific operator
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function operator() {

            $this->render->OperatorToken                    =                   func_get_arg( 0 );    

            if ( isset( $_POST['btnAddWhiteList'] ) ) :

                $this->process                              =                   $this->render->LogicDashboard->ProcessAddWhiteListIP( $this->render->OperatorToken );

            endif;

            if ( isset( $_POST['btnRemoveIP'] ) ) :

                $this->process                              =                   $this->render->LogicAdministrator->ProcessRemoveIP( $this->render->OperatorToken );
                $this->render->setMessage                   =                   [ 'success', 'White Listed I.P. Address was successfully removed.' ];     

            endif;

            

            if ( isset( $_POST['btnRevokeAPI'] ) ) :

                $this->render->GetOperator                  =                   $this->render->LogicAdministrator->GetOperator( $this->render->OperatorToken );
                $this->process                              =                   $this->render->LogicAdministrator->ProcessRevokeAPI( $this->render->GetOperator['data'][0]['RowID'], $_POST['Access'] );
                $this->render->setMessage                   =                   [ 'success', 'Access to <strong>'. $_POST['Access'] .'</strong> API has been revoked.' ];            

            endif;

            $this->render->GetOperator                      =                   $this->render->LogicDashboard->GetOperator( $this->render->OperatorToken );            
            $this->render->GetAPIs                          =                   $this->render->LogicDashboard->GetRegisteredAPIs();
            $this->render->GetAPIAccess                     =                   $this->render->LogicDashboard->GetAPIOperatorAccess( $this->render->GetOperator['data'][0]['RowID'] );
            $this->render->GetIPs                           =                   $this->render->LogicDashboard->GetWhiteListIPs( $this->render->GetOperator['data'][0]['RowID'] );
            
            $this->render->page( 'Dashboard/Operator', $this->render->setParams );

        }

        /**
         * @name    dwnlopcreds
         * @desc    dwnlopcreds allows for the export of operator credentials into a csv file
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function dwnlopcreds() {

            $this->render->OperatorToken                    =                   func_get_arg( 0 );    
            $this->render->LogicDashboard->ProcessDwldOperatorCreds( $this->render->OperatorToken );  

        }

        /**
         * @name    logs
         * @desc    logs allow users to see recent requests
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function logs() {

            if ( !isset( $_POST['btnFind'] ) ) :

                $this->render->SetReturn                    =                   30;
                $this->render->SetOperator                  =                   $_SESSION['sessOpID'];
                $this->render->SetAPI                       =                   '*';
                $this->render->StartDate                    =                   date( 'Y-m-d', mktime( 0, 0, 0, date('m'), date('d') - 7, date('Y') ) );
                $this->render->StopDate                     =                   date( 'Y-m-d', mktime( 0, 0, 0, date('m'), date('d'), date('Y') ) );

            else:

                $this->render->SetReturn                    =                   $_POST['SetReturn'];
                $this->render->SetOperator                  =                   $_SESSION['sessOpID'];
                $this->render->SetAPI                       =                   $_POST['APIName'];
                $this->render->StartDate                    =                   $_POST['StartDate'];
                $this->render->StopDate                     =                   $_POST['StopDate'];

            endif;

            $this->render->GetLogs                          =                   $this->render->LogicDashboard->GetRecentLogs( $this->render->SetReturn,
                                                                                                                              $this->render->SetOperator,
                                                                                                                              $this->render->SetAPI,
                                                                                                                              $this->render->StartDate,
                                                                                                                              $this->render->StopDate );

            $this->render->GetAPIs                          =                   $this->render->LogicDashboard->GetRegisteredAPIs();
            // $this->render->GetOperators                     =                   $this->render->LogicDashboard->GetOperators();
            $this->render->page( 'Dashboard/Logs', $this->render->setParams );

        }
        /**
         * @name    errorlogs
         * @desc    logs allow users to see recent requests
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function errorlogs() {

            if ( !isset( $_POST['btnFind'] ) ) :

                $this->render->SetReturn                    =                   30;
                $this->render->SetOperator                  =                   $_SESSION['sessOpID'];
                $this->render->SetAPI                       =                   '*';
                $this->render->StartDate                    =                   date( 'Y-m-d', mktime( 0, 0, 0, date('m'), date('d') - 7, date('Y') ) );
                $this->render->StopDate                     =                   date( 'Y-m-d', mktime( 0, 0, 0, date('m'), date('d'), date('Y') ) );

            else:

                $this->render->SetReturn                    =                   $_POST['SetReturn'];
                $this->render->SetOperator                  =                   $_SESSION['sessOpID'];
                $this->render->SetAPI                       =                   $_POST['APIName'];
                $this->render->StartDate                    =                   $_POST['StartDate'];
                $this->render->StopDate                     =                   $_POST['StopDate'];

            endif;

            $this->render->GetLogs                          =                   $this->render->LogicDashboard->GetRecentErrorLogs( $this->render->SetReturn,
                                                                                                                                   $this->render->SetOperator,
                                                                                                                                   $this->render->SetAPI,
                                                                                                                                   $this->render->StartDate,
                                                                                                                                   $this->render->StopDate );

            $this->render->GetAPIs                          =                   $this->render->LogicDashboard->GetRegisteredAPIs();            
            $this->render->page( 'Dashboard/ErrorLogs', $this->render->setParams );

        }

        /**
         * @name    errorcodes
         * @desc    views all system related errorcodes
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function errorcodes() {

            $this->render->ErrorCodes                       =                   $this->render->LogicAdministrator->GetErrorCodes();            
            $this->render->page( 'Administrator/ErrorCodes', $this->render->setParams );

        }

        /**
         * @name    settings
         * @desc    settings shows all universal setting parameters and values
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function settings() {

            if ( isset( $_POST['btnUpdateTTL'] ) ) :

                $this->render->LogicAdministrator->ProcessSettingUpdateTTL();

            endif;

            if ( isset( $_POST['btnUpdateTFA'] ) ) :

                $this->render->LogicAdministrator->ProcessSettingUpdateTFA();

            endif;

            $this->render->GetSettings                  =                   $this->render->LogicAdministrator->GetUniversalSettings();

            $this->render->page( 'Administrator/Settings', $this->render->setParams );

        }

        /**
         * @name    settingsupdate
         * @desc    settingsupdate allows universal parameter values to be updated
         * @author  Vincent Rahming <vincent@genesysnow.com>
         */
        public function settingsupdate() {

            $this->render->page( 'Administrator/SettingsUpdate', $this->render->setParams );

        }
        
    }