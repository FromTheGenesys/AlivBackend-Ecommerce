<?php

    class Index extends gpRouter {
        
        public function __construct() {
            parent::__construct();
            
            $this->render->LogicIndex        =   new GPLogicIndex();
            $this->render->setParams         =   ['header'  =>  'Auth/Header',
                                                  'footer'  =>  'Auth/Footer'];
            
        }
        
        public function getindex() {
                    
            if ( !isset( $_SESSION['SessionIsStarted'] ) ) : 
                 
                $this->render->page( 'Auth/Login', $this->render->setParams );
                
            else:
                     
                # route the user to their default index page
                $this->render->LogicIndex->routeToIndex();
                     
            endif;
            
        }
        
    }