<?php

    class Errors extends gpRouter {
        
        public function __construct() {

            parent::__construct();
            // gpSecurity::enforceSession();

            # if you have no access to this area, redirect to the appropriate page
            // $this->render->setParams          =   [ 'header'  =>  'Administrator/Header',
            //                                         'footer'  =>  'Administrator/Footer' ];     # include specific header and footer for /Administrator/ pages
        
        }

        public function getindex() {
            
            $this->render->page( 'Error' );
            
        }
        
    }