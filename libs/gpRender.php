<?php

    class gpRender {

        public function __construct() {

            require_once gpConfig['BASEPATH'] . gpConfig['LIBS'] . 'gpLibraryIndex.php';
           
        }
       
        public function page( $setPage, $setParams = false ) {
 
            if ( !empty( $setParams ) ) :
                
                # custom header
                require gpConfig['BASEPATH'] . gpConfig['RENDER'] . $setParams['header'] .'.php';
            
            else:
                
                # default header                
                require gpConfig['BASEPATH'] . gpConfig['RENDER'] . gpDefsCfg['HEADER'];
                
            endif;
            
            if ( !file_exists( gpConfig['BASEPATH'] . gpConfig['RENDER'] . $setPage .'.php') ) :
            
                require gpConfig['RENDER'] . 'Error.php';
                
            else:
                
                require gpConfig['RENDER'] . $setPage . '.php';
            
            endif;
            
            
            if ( !empty( $setParams ) ) :
                
                # custom footer
                require gpConfig['BASEPATH'] . gpConfig['RENDER'] . $setParams['footer'] . '.php';
            
            else:
                
                # default footer
                require gpConfig['BASEPATH'] . gpConfig['RENDER'] . gpDefsCfg['FOOTER'];
                
            endif;
            
        }
    }