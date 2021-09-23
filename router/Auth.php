<?php

    class Auth extends gpRouter {
        
        public function __construct() {
            parent::__construct();
            
            $this->render->LogicAuth         =   new GPLogicAuth();                 # include LogicAuth Library
            $this->render->LogicIndex        =   new GPLogicIndex();                # include LogicIndex Library

            $this->render->setParams         =   [ 'header'  =>  'Auth/Header',
                                                   'footer'  =>  'Auth/Footer' ];   # include specific header and footer for Auth/ pages
         
        }
       
        public function getindex() {
            
            if ( !isset( $_SESSION['SessionIsStarted'] ) ) :
            
                # if session is not active and started, force the login prompt
                $this->render->page( 'Auth/Login', $this->render->setParams  );
            
            else: 
                
                # if session is started, route the user to the appropriate page based on their role
                $this->render->LogicIndex->routeToIndex();
                
            endif;
            
        }

        public function route() {

            $this->render->LogicIndex->routeToIndex();

        }

       
        ###############################
        #  LOGIN / LOGOUT  
        ###############################
        public function login() {
        
            # send LoginID and Password for authentication against the database
            $this->process                                  =                   $this->render->LogicAuth->processLogin();

            if ( $this->process == 1 ) :
               
                $this->getindex();
               
            elseif( $this->process == 2 ):

                $this->render->setMessage                   =                   $this->render->GPLogicMessages->setMessage( 
                                                                                   ['message'  =>  'One or more required fields to not contain the appropriate value. Please try again.',
                                                                                    'color'    =>  'danger',
                                                                                    'border'   =>  'danger',
                                                                                    'title'    =>  'Required Fields Missing',
                                                                                    'icon'     =>  'fa fa-exclamation'] );  
                                                                                
                $this->getindex();

            elseif( $this->process == 3 ):

                $this->render->setMessage                   =                   $this->render->GPLogicMessages->setMessage( 
                                                                                    ['message'  =>  'No account found matching the Network ID specified.',
                                                                                     'color'    =>  'danger',
                                                                                     'border'   =>  'danger',
                                                                                     'title'    =>  'No Account Found',
                                                                                     'icon'     =>  'fa fa-bell'] ); 
                $this->getindex();

            elseif( $this->process == 4 ):

                $this->render->setMessage                   =                   $this->render->GPLogicMessages->setMessage( 
                                                                                    ['message'  =>  'Password specified does not match the password on file for this account.',
                                                                                     'color'    =>  'danger',
                                                                                     'border'   =>  'danger',
                                                                                     'title'    =>  'Password Error',
                                                                                     'icon'     =>  'fa fa-bell'] ); 
                $this->getindex();

            endif;
            
        }
        
        public function logout() {
            
            $this->render->LogicAuth->setAuthLogout();
            
        }
        
    }