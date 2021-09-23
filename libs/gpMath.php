<?php

    class gpMath {
        
        public function __construct() {
            //parent::__construct();            
        }

        private function processArguments( $arguments, $operation = false ) {

            if ( !is_array( $arguments ) ) :

                return 'Arguments must be provided in an array data type.';

            endif;

            # ensure that array is not empty
            if ( empty( $arguments ) ) :

                return 'No arguments provied';

            endif;

            # if only one argument in the array
            if( count( $arguments ) < 2 ) :
                
                return 'At least two arguments required to perform this operation';
                
            endif;

            # add only values in the array that are numeric/integer values
            $setNumeric         =           [];

            foreach( $arguments as $argument ) :

                if ( is_numeric( $argument ) ) :

                    array_push( $setNumeric, $argument );

                endif;
                
            endforeach;

            if ( count( $setNumeric ) < 2 ) :

                return 'At least two arguments required to perform this operation';

            endif;

            return $setNumeric;

        }

        private function iterateOperation( $arguments, $operation, $flags = false ) {

            # set base
            $setBase                =               $arguments[0];
            $iterateTotal           =               NULL;
            $iteratePosition        =               0;
            
            /** 
             *  if the operation argument is subtract 
             */
            if ( $operation == 'subtract' ) :

                foreach( $arguments as $argument ) :

                    if ( $iteratePosition == 0 ) :
    
                        $iterateTotal   =               $setBase;
                     
                    else:

                        $iterateTotal   =               ( $iterateTotal  -  $argument );
    
                    endif;
    
                    ++$iteratePosition;
    
                endforeach;  
                
            /** 
             *  if the operation argument is multiply
             */    
            elseif ( $operation == 'multiply' ) :   

                foreach( $arguments as $argument ) :

                    if ( $iteratePosition == 0 ) :
    
                        $iterateTotal   =               $setBase;
                     
                    else:

                        $iterateTotal   =               ( $iterateTotal  *  $argument );
    
                    endif;
    
                    ++$iteratePosition;
    
                endforeach;  

            /** 
             *  if the operation argument is divide 
             */    
            elseif ( $operation == 'divide' ) :   

                $iterateTotal           =               ( $arguments[0] / $arguments[1] );
        
            /** 
             *  if the operation argument is to find the exponent 
             */    
            elseif ( $operation == 'exponent' ) :   

                $iterateTotal           =               pow( $arguments[0], $arguments[1] );
        
            /** 
             *  if the operation argument is to find the square root 
             */    
            elseif ( $operation == 'squareroot' ) :   

                $iterateTotal           =               sqrt( $arguments[0] );
        
            endif;  

            # return the total after each operation
            return $iterateTotal;

        }

        /**
         * @name    add
         * @param   $arguments 
         * @desc    accepts integer/numeric values from an array and provides a sum
         */
        
        public function addValues( array $arguments ) {

            ## ###### ##
            ## RULES  ##
            ## ###### ##

            # 1. You can have multiple items in an array ( minimum of 2 integers ).
            # 2. If any of the rules are violated, return the appropriate error 

            # determine if there are any rules violation,
            # if there are none, the values on which the operation will be performed are returned in
            #       -   an array.
            if( !is_array( $this->processArguments( $arguments ) ) ) :

                return $this->processArguments( $arguments );

            endif;

            # get he index 
            return array_sum( $this->processArguments( $arguments ) );

        }

        /**
         * @name    subtract
         * @param   $arguments
         * @desc    
         */

         public function subtractValues( array $arguments ) {

             ## ###### ##
            ## RULES  ##
            ## ###### ##

            # 1. You can have multiple items in an array ( minimum of 2 integers ).
            # 2. If any of the rules are violated, return the appropriate error 

            # determine if there are any rules violation,
            # if there are none, the values on which the operation will be performed are returned in
            #       -   an array.
             if( !is_array( $this->processArguments( $arguments ) ) ) :

                return $this->processArguments( $arguments );

            endif;

            # return subtraction results
            return $this->iterateOperation( $this->processArguments( $arguments ), 'subtract' );

         }


         public function multiplyValues( array $arguments ) {

            ## ###### ##
            ## RULES  ##
            ## ###### ##

            # 1. You can have multiple items in an array ( minimum of 2 integers ).
            # 2. If any of the rules are violated, return the appropriate error 

            # determine if there are any rules violation,
            # if there are none, the values on which the operation will be performed are returned in
            #       -   an array.
            if( !is_array( $this->processArguments( $arguments ) ) ) :

                return $this->processArguments( $arguments );

            endif;

            # return multiplication results
            return $this->iterateOperation( $this->processArguments( $arguments ), 'multiply' );

         }

         public function divideValues( array $arguments ) {

            ## ###### ##
            ## RULES  ##
            ## ###### ##

            # 1. You can have ONLY two (2) items in an array ( min / max of 2 integers ).
            # 2. If any of the rules are violated, return the appropriate error 

            # determine if there are any rules violation,
            # if there are none, the values on which the operation will be performed are returned in
            #       -   an array.
            if( !is_array( $this->processArguments( $arguments ) ) ) :

                return $this->processArguments( $arguments );

            endif;

            # return division results
            return $this->iterateOperation( $this->processArguments( $arguments ), 'divide' );

         }

         public function exponent( array $arguments ) {

            ## ###### ##
            ## RULES  ##
            ## ###### ##

            # 1. You can have ONLY one (1) item in an array ( 1 integers ).        

            # determine if there are any rules violation,
            # if there are none, the values on which the operation will be performed are returned in
            #       -   an array.
            if( !is_array( $this->processArguments( $arguments ) ) ) :

                return $this->processArguments( $arguments );

            endif;

            # return exponent results
            return $this->iterateOperation( $this->processArguments( $arguments ), 'exponent' );

         }

         public function squareRoot( array $arguments ) {

            ## ###### ##
            ## RULES  ##
            ## ###### ##

            # 1. You can have ONLY one (1) item in an array ( 1 integers ).
            
            # determine if there are any rules violation,
            # if there are none, the values on which the operation will be performed are returned in
            #       -   an array.
            if( !is_array( $this->processArguments( $arguments ) ) ) :

                return $this->processArguments( $arguments );

            endif;

            # return squareroot results
            return $this->iterateOperation( $this->processArguments( $arguments ), 'squareroot' );

         }

    }