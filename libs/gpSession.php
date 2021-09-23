<?php

    class gpSession extends gpLogic {
        
        public function __construct() {
            
            $this->setManager();
            
        }
        
        public function destroyIndexes() {
            
            # destroy indexes
            session_destroy();
            header( 'Location: ' . gpConfig['URLPATH'] );
            
        }
        
        public function getIndex( $IndexName ) {
            
            # check to see if value exists, then return it, else return none
            return ( isset( $_SESSION[ $IndexName ] ) ? $_SESSION[ $IndexName ] : NULL );
            
        }
        
        public function killIndex( $IndexName ) {
            
            # unset index value
            unset( $_SESSION[ $IndexName ] );
            return NULL;
                
        }
        
        public function setManager() {
            
            # start the session
            $this->setStartup();
            
            # if the session hasn't started, record the start time of the session
            # if the user logs in, then update the start time.
            if ( !isset( $_SESSION['SessionStarted'] ) )  :
                
                $this->setSessionStart();
                
            endif;
            
            if ( isset( $_SESSION['SessionIsStarted'] ) ) : 
            
                if ( $_SESSION['SessionRemoteAddr'] != $_SERVER['REMOTE_ADDR'] ) :

                    # kill all indexes
                    # force logout 
                    $this->destroyIndexes();

                endif;
                
                if ( intval( time() - $_SESSION['SessionStarted'] ) > intval( gpConfig['TIMEOUT'] * 60 ) ) :
                    
                    # kill all indexes
                    # force logout
                    $this->destroyIndexes();
                    
                endif; 
                
            endif;
            
        }
        
        public function setIndex( $IndexName, $IndexValue ) {
        
            # set session index
            $_SESSION[ $IndexName ]     =       $IndexValue;
            
        }
        
        public function setSessionStart() {
            
            if ( isset( $_SESSION['SessionIsStarted'] ) ) : 
                
                # set Session Start Index
                $this->setIndex( 'SessionStarted', time() );            
                $this->setIndex( 'SessionRemoteAddr', $_SERVER['REMOTE_ADDR'] );            
                
            endif;
            
        }
        
        public function setStartup() {
        
            # start/continue session
            # regenerate session id
            if ( !isset( $_SESSION['SessionStarted'] ) ) :       
                
                session_regenerate_id( true );
            
            endif;
            
            $this->setSessionStart();
            
        }
        
    }     