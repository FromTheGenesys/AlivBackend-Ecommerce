<?php

    class Administrator extends gpRouter {
        
        public function __construct() {
            parent::__construct();

            # if you have no access to this area, redirect to the appropriate page
            
            // if ( $_SESSION['sessAcctRole'] != 'A' ) :

            //     header( 'Location: '. gpConfig['URLPATH'] .'auth/' );

            // endif;
            
            define( '_ACCESS_', 'administrator/' );
            define( '_FOLDER_', 'Administrator/' );

            $this->render->LogicAdmin        =   new GPLogicAdministrator();                    # include LogicAdministrator Library
            $this->render->LogicGlobal       =   new GPLogicGlobal();                           # include LogicGlobal Library           
            $this->render->setParams         =   [ 'header'  =>  _FOLDER_ . 'Header',
                                                   'footer'  =>  _FOLDER_ . 'Footer' ];         # include specific header and footer for Auth/ pages
        
        }
    
        public function getindex() {
            
            # if session is not active and started, force the login prompt
            $this->render->page( _FOLDER_ . 'Dashboard', $this->render->setParams  );
            
        }

        public function accounts() {

            if ( isset( $_POST['btnAddAccount'] ) ) :

                $this->process                          =                   $this->render->LogicAdmin->ProcessAddAlivAccount();

                if ( $this->process == 1 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Account was successfully added.',
                                                                                 'color'     =>  'success',
                                                                                 'border'    =>  'success',
                                                                                 'title'     =>  'Account Added Successfully',
                                                                                 'icon'      =>  'fa fa-check'] );  

                elseif ( $this->process == 2 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'One ore more required fields do not contain the appropriate values.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Missing Required Fields',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Network Login ID provided is already on file. Please provide another.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Login ID',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Email Address provide is already on file. Please provide another.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Email Address',
                                                                                 'icon'      =>  'fa fa-alert'] );  


                endif;

            endif;


            if ( isset( $_POST['btnUpdateAccount'] ) ) :

                $this->process                          =                   $this->render->LogicAdmin->ProcessUpdateAlivAccount();

                if ( $this->process == 1 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Account was successfully added.',
                                                                                 'color'     =>  'success',
                                                                                 'border'    =>  'success',
                                                                                 'title'     =>  'Account Added Successfully',
                                                                                 'icon'      =>  'fa fa-check'] );  

                elseif ( $this->process == 2 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'One ore more required fields do not contain the appropriate values.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Missing Required Fields',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Network Login ID provided is already on file. Please provide another.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Login ID',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage           =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Email Address provide is already on file. Please provide another.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Email Address',
                                                                                 'icon'      =>  'fa fa-alert'] );  


                endif;

                // $this->render->setMessage               =                   $this->render->GPLogicMessages->setMessage( 
                //                                                                 ['message'   =>  'The Account was successfully reset.',
                //                                                                  'color'     =>  'success',
                //                                                                  'border'    =>  'success',
                //                                                                  'title'     =>  'Account Reset',
                //                                                                  'icon'      =>  'fa fa-check'] );  

            endif;

            $this->render->GetAccounts                  =                   $this->render->LogicAdmin->GetALIVAccounts();
            $this->render->page( _FOLDER_ . 'Accounts', $this->render->setParams  );

        }

        public function plans() {

            if ( isset( $_POST['btnMakeEligible'] ) ) :

                $this->process                          =                   $this->render->LogicAdmin->ProcessMakePlanEligible();

            endif;

            if ( isset( $_POST['btnSortEligible'] ) ) :

                $this->process                          =                   $this->render->LogicAdmin->ProcessSortEligible();

            endif;

            if ( isset( $_POST['btnRemovePlan'] ) ) :

                $this->process                          =                   $this->render->LogicAdmin->ProcessRemoveEligible();

            endif;

            $this->render->GetPlans                     =                   $this->render->LogicAdmin->GetALIVPlans();
            $this->render->GetEligible                  =                   $this->render->LogicAdmin->GetEligiblePlans();
            $this->render->page( _FOLDER_ . 'Plans', $this->render->setParams  );

        }

        public function devices() {

            $this->render->page( _FOLDER_ . 'Catalog', $this->render->setParams  );

        }

        public function makes() {

            if ( isset( $_POST['btnAddMakes'] ) ) :

                $this->process                           =                  $this->render->LogicAdmin->ProcessAddMakes();

                if ( $this->process  == 1 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Device Make ( Brand ) was successfully added',
                                                                                 'color'     =>  'success',
                                                                                 'border'    =>  'success',
                                                                                 'title'     =>  'Device Make Added',
                                                                                 'icon'      =>  'fa fa-check'] );  
                elseif ( $this->process == 2 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'One or more required fields do not contain the appropriate values. Please check you entries then try again.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Required Fields Missing',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Brand ( Make ) Name submitted is already on file',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Make ( Brand ) Name',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Size specified exceeds the maxium allowed size of 2mb',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Size Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 5 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Type specified is not allowed. File must be *.jpeg or *.png',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Image Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                endif;

            endif;

            if ( isset( $_POST['btnUpdateMake'] ) ) :

                $this->process                           =                  $this->render->LogicAdmin->ProcessUpdateMake();

                if ( $this->process  == 1 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Device Make ( Brand ) was successfully added',
                                                                                 'color'     =>  'success',
                                                                                 'border'    =>  'success',
                                                                                 'title'     =>  'Device Make Updated',
                                                                                 'icon'      =>  'fa fa-check'] );  
                elseif ( $this->process == 2 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'One or more required fields do not contain the appropriate values. Please check you entries then try again.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Required Fields Missing',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Brand ( Make ) Name submitted is already on file',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Make ( Brand ) Name',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Size specified exceeds the maxium allowed size of 2mb',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Size Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 5 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Type specified is not allowed. File must be *.jpeg or *.png',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Image Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                endif;

            endif;

            if ( isset( $_POST['btnAddDevice'] ) ) :

                $this->proces                            =                  $this->render->LogicAdmin->ProcessAddDevice();

                if ( $this->process  == 1 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Device was successfully added',
                                                                                 'color'     =>  'success',
                                                                                 'border'    =>  'success',
                                                                                 'title'     =>  'Device Make Added',
                                                                                 'icon'      =>  'fa fa-check'] );  
                elseif ( $this->process == 2 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'One or more required fields do not contain the appropriate values. Please check you entries then try again.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Required Fields Missing',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Device Name submitted is already for this Make ( Brand )',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Device Name',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'An invalid numeric value was submitted for the Device Cost field.',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'Invalid Cost Provided',
                                                                                'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 5 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Size is to large.  File sizes cannot exceed 2mb',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Size Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 6 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Type specified is not allowed. File must be *.jpeg or *.png',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Image Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                endif;

            endif;

            if ( isset( $_POST['btnUpdateDevice'] ) ) :

                $this->process                           =                  $this->render->LogicAdmin->ProcessUpdateDevice();

            endif;

            if ( isset( $_POST['btnAddAttribute'] ) ) :
                
                $this->process                           =                  $this->render->LogicAdmin->ProcessDeviceAttributes();    

            endif;

            if ( isset( $_POST['btnUploadPhotos'] ) ) :

                $this->process                           =                  $this->render->LogicAdmin->ProcessUploadPhotos();    

            endif;

            if ( isset( $_POST['btnUpdatePhotos'] ) ) :

                $this->process                           =                   $this->render->LogicAdmin->ProcessPhotoUpdates();

            endif;

            if ( isset( $_POST['btnUpdateAccessories'] ) ) :

                $this->process                           =                   $this->render->LogicAdmin->ProcessAccessoriesUpdates();

            endif;

            if ( isset( $_POST['btnAddAccessory'] ) ) :

                $this->process                           =                   $this->render->LogicAdmin->ProcessAddAccessory();

                if ( $this->process  == 1 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Device Accessory was successfully added',
                                                                                 'color'     =>  'success',
                                                                                 'border'    =>  'success',
                                                                                 'title'     =>  'Accessory Added',
                                                                                 'icon'      =>  'fa fa-check'] );  
                elseif ( $this->process == 2 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'One or more required fields do not contain the appropriate values. Please check you entries then try again.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Required Fields Missing',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Name submitted is already for this Accessory',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Accessory Name',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 4 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'An invalid numeric value was submitted for the Accessory Cost field.',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'Invalid Cost Provided',
                                                                                'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 5 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Size is to large.  File sizes cannot exceed 2mb',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Size Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 6 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The File Type specified is not allowed. File must be *.jpeg or *.png',
                                                                                'color'     =>  'warning',
                                                                                'border'    =>  'warning',
                                                                                'title'     =>  'File Image Error',
                                                                                'icon'      =>  'fa fa-alert'] );  

                endif;
            endif;

            $this->render->GetEligiblePlans              =                   $this->render->LogicAdmin->GetEligiblePlans();
            $this->render->GetMakes                      =                   $this->render->LogicAdmin->GetMakes();

            $this->render->page( _FOLDER_ . 'Makes', $this->render->setParams  );

        }

        public function attributes() {

            if ( isset( $_POST['btnAddAttributes'] ) ) :

                $this->process                           =                  $this->render->LogicAdmin->ProcessAddMakeAttributes();

                $this->render->setMessage                =                  $this->render->GPLogicMessages->setMessage( 
                                                                                   ['message'   =>  'The Attributes were successfully added',
                                                                                    'color'     =>  'success',
                                                                                    'border'    =>  'success',
                                                                                    'title'     =>  'Device Attributes Added',
                                                                                    'icon'      =>  'fa fa-check'] );  

            endif;
            
            if ( isset( $_POST['btnUpdateAttribute'] ) ) : 

                $this->process                           =                  $this->render->LogicAdmin->ProcessUpdateMakeAttributes();

                if ( $this->process  == 1 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Device Attribute was successfully updated.',
                                                                                 'color'     =>  'success',
                                                                                 'border'    =>  'success',
                                                                                 'title'     =>  'Device Attribute Updated',
                                                                                 'icon'      =>  'fa fa-check'] );  
                elseif ( $this->process == 2 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'One or more required fields do not contain the appropriate values. Please check you entries then try again.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Required Fields Missing',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                elseif ( $this->process == 3 ) :

                    $this->render->setMessage            =                   $this->render->GPLogicMessages->setMessage( 
                                                                                ['message'   =>  'The Attribute Name already assigned to this device. Please select another Attribute Name.',
                                                                                 'color'     =>  'warning',
                                                                                 'border'    =>  'warning',
                                                                                 'title'     =>  'Duplicate Device Name',
                                                                                 'icon'      =>  'fa fa-alert'] );  

                endif;

            endif;

            $this->render->GetMakes                      =                  $this->render->LogicAdmin->GetMakes();
            $this->render->GetAttributes                 =                  $this->render->LogicAdmin->GetDeviceAttributes();

            $this->render->page( _FOLDER_ . 'Attributes', $this->render->setParams  );

        }

        public function accessories() {

            $this->render->page( _FOLDER_ . 'Accessories', $this->render->setParams  );

        }

    }