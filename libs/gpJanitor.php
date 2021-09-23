<?php

    class gpJanitor  {
        
        public function __construct() {
                     
        }

        /**
         *
         * @name    preventXSS
         * 
         * @desc    set a Cross Site Scripting
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         */
        public function preventXSS() {

            if ( !empty( $_POST ) ) :

                foreach( $_POST as $key => $val ) :

                    if ( is_string( $val ) ) : 

                        $_POST[ $key ]  =  htmlspecialchars( $val, ENT_COMPAT );

                    endif;

                endforeach;

            endif;

        }

        /**
         *
         * @name    setCSRFToken
         * 
         * @desc    set a Cross Site Request Forgery Token
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         */
        public function setCSRFToken() {

            if ( empty( $_SESSION['GN-CSRFToken'] ) ) :

                $_SESSION['GN-CSRFToken']  =   bin2hex( random_bytes(32) );
        
             endif;

        }

        /**
         * 
         * @name    checkCSRFToken
         * 
         * @desc    Checks the CSRF Token to determine whether or not the request is valid, if there 
         *          is a fogery attempt, identify it and rever to CSRF Alert page
         * 
         * @author  Vincent J. Rahming <vincent@genesysnow.com>
         */
        public function checkCSRFToken() {

            if ( isset( $_POST ) ) :

                if ( isset( $_POST['GN-CSRFToken'] ) ) :

                    if ( $_POST['GN-CSRFToken'] !== $_SESSION['GN-CSRFToken'] ) :

                        header( 'Location: ' . gpConfig['URLPATH'] .'auth/tamper/csrf' );

                    endif;

                endif;

            endif;

         }

    }
