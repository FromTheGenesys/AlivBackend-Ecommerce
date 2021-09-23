<?php

    class gpStartup {
         
         private $_url          =   NULL;
         private $_routes       =   NULL;
         private $_router_name  =   NULL;
         
        # set error file
        private function _error() {
           
            require gpConfig['ROUTER'] . gpDefsCfg['ERROR'];
            $this->_setError = new Errors();
            $this->_setError->getindex();
            return FALSE;
            
        }
         
        # get Router Method
        private function _getRouterMethod() {
    
            $setURLSize     =   count( $this->_url );
            
            if ( $setURLSize > 1 ) :
               
                if ( !method_exists( $this->_routes, $this->_url[1] ) ) :
                    
                    $this->_error();
                    exit();
                    
                endif;
                
            endif;
            
            if ( $setURLSize == 7 ) :
                
                $this->_routes->{ $this->_url[1] }( $this->_url[2], $this->_url[3], $this->_url[4], $this->_url[5], $this->_url[6] );
                exit();
                
            elseif ( $setURLSize == 6 ) :
            
                $this->_routes->{ $this->_url[1] }( $this->_url[2], $this->_url[3], $this->_url[4], $this->_url[5] );
                exit();
                
            elseif ( $setURLSize == 5 ) :
                
                $this->_routes->{ $this->_url[1] }( $this->_url[2], $this->_url[3], $this->_url[4] );
                exit();
                
            elseif ( $setURLSize == 4 ) :
                
                $this->_routes->{ $this->_url[1] }( $this->_url[2], $this->_url[3] );
                exit();
                
            elseif ( $setURLSize == 3 ) :
                
                $this->_routes->{ $this->_url[1] }( $this->_url[2] );
                exit();
                
            elseif ( $setURLSize == 2 ) :
                
                $this->_routes->{ $this->_url[1] }();
                exit();
                
            else :
                                
                $this->_routes->getindex();
                exit();
                
            endif;
        
        }
        
        # process URL
        private function _getURL() {
            
            $this->_url     =   isset( $_GET['arguments'] ) ? filter_var( rtrim( $_GET['arguments'], '/' ), FILTER_SANITIZE_URL ) : NULL;       
            $this->_url     =   explode( '/', $this->_url );
            
        }
         
        # initialize 
        public function ignite() {
             
            # call treated URL 
            $this->_getURL(); 
            
            # load default router if none is specified            
            if ( empty( $this->_url[0] ) ) :
                
                $this->getDefaultRouter();
                return false;
                
            endif;
            
            $this->getExistingMethod();
            $this->_getRouterMethod();    
             
         }
       
        # get default router        
        public function getDefaultRouter() {              
            
            # requires default index file
            require gpConfig['ROUTER'] . gpDefsCfg['INDEX'];
            $this->_routes = new Index();            
            $this->_routes->getindex();             
            
        }
        
        # get Existing Method
        public function getExistingMethod() {
          
            if ( file_exists( gpConfig['ROUTER'] . ucwords( $this->_url[0] ) . '.php' ) ) :
                
                require gpConfig['ROUTER'] . ucwords( $this->_url[0] ) . '.php';
                $this->_router_name   =     ucwords( $this->_url[0] );                
                $this->_routes        =     new $this->_router_name;
                $this->_routes->setRoute( $this->_router_name );
                
            else:
                
                $this->_error();
                exit();
               
            endif;   
            
        }
        
     }