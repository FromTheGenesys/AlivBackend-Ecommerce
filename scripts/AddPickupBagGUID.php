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

        $connect        =   mysqli_connect( 'generalpurpose.cezjbr3dvdv5.us-east-1.rds.amazonaws.com', 'generald9e89606', 'ce530c36a4a5!!', 'MVPSource' );

        $query          =   mysqli_query( $connect, 'SELECT dzpDropSheetPickupBags.* FROM dzpDropSheetPickupBags WHERE dzpDropSheetPickupBags.BagGUID IS NULL ORDER BY BagID DESC' );

        while( $result  =   mysqli_fetch_assoc( $query ) ) :

            $GUID       =   GUID();

            echo ' UPDATE dzpDropSheetPickupBags SET BagGUID = "'. $GUID .'" WHERE BagID = "'. $result['BagID'] .'"' . "\n";
            mysqli_query( $connect, 'UPDATE dzpDropSheetPickupBags SET BagGUID = "'. $GUID .'" WHERE BagID = "'. $result['BagID'] .'"' );            

        endwhile;

        mysqli_close( $connect );