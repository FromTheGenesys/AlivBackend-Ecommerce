<?php
    
    class gpAutoLoader {
        
        public static function load_library( $classname ) {
            
            require $classname . '.php';
            
        }
    
    }

    spl_autoload_register( array( 'gpAutoLoader', 'load_library' ) );