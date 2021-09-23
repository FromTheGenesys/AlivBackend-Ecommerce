<?php

    class gpMessages {

        public function __construct() {

            require_once gpConfig['BASEPATH'] . gpConfig['LIBS'] . 'gpLibraryIndex.php';
           
        }

        public function setMessage( $setParams ) {

            $setMessage         =       '<div class="mt-2 mb-4 alert ';

            /** if color is submitted */
            if ( isset( $setParams['color'] ) ) :

                $setMessage     .=      ' alert-'. $setParams['color'] .' ';    

            endif;
            
            /** if border is submitted */
            if ( isset( $setParams['border'] ) ) :

                $setMessage     .=      ' border-'. $setParams['border'] .' ';    

            endif;

            /** if font-size is submitted */
            if ( isset( $setParams['font'] ) ) :

                $setMessage     .=      ' font-'. $setParams['font'] .' ';    

            endif;
            
            $setMessage         .=      '">';

            if ( !isset( $setParams['icon'] ) ) :
            
                $setMessage     .=      $setParams['message'];    
            
            else:

                $setMessage     .=      '<div class="row">';                

                    $setMessage     .=      '<div class="col-lg-1 pt-2 text-center">';                
                    $setMessage     .=      '<i class="'. $setParams['icon'] .'" style="font-size: 35px;"></i>';                                    
                    $setMessage     .=      '</div>';                
                    
                    $setMessage     .=      '<div class="col-lg-11">';       
                    
                    if ( isset( $setParams['title'] ) ) :

                        $setMessage     .= '<div><h5><strong>';
                        $setMessage     .=  $setParams['title'];    
                        $setMessage     .= '</strong></h5></div>';

                    endif;

                    $setMessage     .=      '<div>';                    
                    $setMessage     .=      $setParams['message'];    
                    $setMessage     .=      '</div>';

                    $setMessage     .=      '</div>';

                $setMessage     .=      '</div>';

            endif;

            $setMessage         .=      '</div>';

            return $setMessage;

        }

    }