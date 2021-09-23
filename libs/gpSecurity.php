<?php

    class gpSecurity {

        /**
         * @name    enforceSession
         * @desc    enforceSession checks to see if the session is still active.  if not, it forces a logout
         */
        public static function enforceSession() {

            if ( !isset( $_SESSION['SessionIsStarted'] ) ) :

                header( 'Location: '. gpConfig['URLPATH'] .'auth/logout' );

            endif;

        }

    }