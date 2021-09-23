<?php

    class gpRouter {
        
        public function __construct() {
            
            # place render in global scope
            $this->render             =           new gpRender();                                                  
                                                  
        }
        
        # call corresponding Logic ( Model ) File 
        # business logic is contained in the logic folder / logic file
        public function setRoute( $getLogic ) {
            
        }
                
    }