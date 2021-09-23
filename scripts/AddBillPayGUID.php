<?php

        function GUID() {

            if ( function_exists( 'com_create_guid' ) ) :
                 
                return com_create_guid();
                
           else :
                
                mt_srand( (double)microtime() * 10000 ); //optional for php 4.2.0 and up.
                $charid   =    strtolower(md5(uniqid(rand(), true)));
                $hyphen   =    chr(45); // "-"
                
                $uuid     =     substr($charid, 0, 8 )  . $hyphen
                               .substr($charid, 8, 4 )  . $hyphen
                               .substr($charid, 12, 4 ) . $hyphen
                               .substr($charid, 16, 4 ) . $hyphen
                               .substr($charid, 20,12 );
                
                return $uuid;
           
           endif; 

        }

        $connect        =   mysqli_connect( '10.0.0.203', 'mvp', 'Fornow1@', 'MVPSourceLive' );

        $query          =   mysqli_query( $connect, 'SELECT BillPayData.PaymentGUID, BillPayData.PaymentID FROM BillPayData WHERE BillPayData.PaymentGUID IS NULL ORDER BY PaymentID DESC' );

        while( $result  =   mysqli_fetch_assoc( $query ) ) :

            echo ' UPDATE BillPayData SET PaymentGUID = "'. GUID() .'" WHERE PaymentID = "'. $result['PaymentID'] .'"' . "\n";
            mysqli_query( $connect, 'UPDATE BillPayData SET PaymentGUID = "'. GUID() .'" WHERE PaymentID = "'. $result['PaymentID'] .'"' );            

        endwhile;

        mysqli_close( $connect );