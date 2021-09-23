<?php

    class gpDateTime  {
        
        public function __construct() {
                     
        }

        private function parser( $DateArgument, $Return = false ) {

            list( $Date, $Time )    =   explode( ' ', $DateArgument );

            if ( empty( $Return ) ):

                return $Date;

            elseif ( $Return = 0 ) :

                return $Date;

            else:

                return $Time;

            endif;

        }

        public function shortDate( $Date = false ) {

            if ( empty( $Date ) ) :

                return date( 'Y-m-d' );

            else:

                return date( 'Y-m-d', strtotime( $this->parser( $Date ) ) );
   
            endif;

        }


        public function mediumDate( $Date = false ) {

        }

        public function longDate( $Date = false ) {

        }

        public function time12hours( $Date = false, $TimeZone = false ) {

            if ( empty( $Date ) ) :

                return date( 'Y-m-d' );

            else:

                return date( 'Y-m-d', strtotime( $this->parser( $Date ) ) );
   
            endif;

        }

        public function time24hours( $Date = false, $TimeZone = false ) {

        }

        public function getAge( $DateOne, $DateTwo = false, $DisplayFormat = false ) {

        }

        public function getDateTimeDifference( $DateOne, $DateTwo, $Format = false ) {

            $setDateOne         =       new DateTime( $DateOne );
            $setDateTwo         =       new DateTime( $DateTwo );

            $Interval           =       $setDateOne->diff( $setDateTwo );

            return $Interval;

        }

    }