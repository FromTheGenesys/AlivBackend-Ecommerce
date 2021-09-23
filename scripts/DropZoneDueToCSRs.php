<!-- <script src="../assets/vendors/js/jquery.min.js"></script> -->
<!-- <script src="../assets/js/dropzone.js"></script>   -->
<?php

    ini_set( 'display_errors', 1 );

    function fetchEODVendorList() {
             
        $setVendors           =          [ 'Transfers - MoneyGram',
                                           'Transfers - RIA',
                                           'Airline - Bahamas Air',
                                           'Airline - Sky Bahamas',
                                           'Airline - Western Air',         
                                           'Bill Pay - ALIV',                                                    
                                           'Bill Pay - Bahamas Power & Light',
                                           'Bill Pay - Bahamas Telecommunication Company',                                                    
                                           'Bill Pay - BTC Mobile Topup',                                                                                                                 
                                           'Bill Pay - Cable Bahamas',
                                           'Bill Pay - Credit Card Payments',
                                           'Bill Pay - EZE International Topup',                                                    
                                           'Bill Pay - Grand Bahamas Power',
                                           'Bill Pay - Grand Bahamas Utility',
                                           'Bill Pay - Passport Office',
                                           'Bill Pay - Security Systems International',
                                           'Bill Pay - Water and Sewerage' ];
             
       return $setVendors;      
        
    }

    if ( $_POST['locationID'] != '*' ) :

        $host       =   'generalpurpose.cezjbr3dvdv5.us-east-1.rds.amazonaws.com';
        $user       =   'generald9e89606';
        $pswd       =   'ce530c36a4a5!!';
        $source     =   'MVPSource';

        $connect    =   mysqli_connect( $host, $user, $pswd, $source );

        $query      =   'SELECT sysAccounts.id, 
                                UPPER( sysAccounts.account_last ) as AccountLast, 
                                UPPER( sysAccounts.account_first ) as AccountFirst

                        FROM   sysAccounts
                        WHERE  sysAccounts.account_status = "1"
                        AND    sysAccounts.account_pid    = "CNG"
                        AND    FIND_IN_SET( "'. $_POST['locationID'] .'", sysAccounts.account_locations )
                        ORDER BY sysAccounts.account_last ASC
                        ';

        $result     =   mysqli_query( $connect, $query );

        echo '<div class="mt-3 font-weight-bold">';
        echo 'Select A CSR';
        echo '</div>';

        echo '<div class="mt-1">';
        echo '<select id="DTCSR" name="CSRID" class="form-control custom-select">';        
        while ( $set = mysqli_fetch_assoc( $result ) ) :

            if ( $set['id'] != $_POST['csrID'] ) : 
                echo '<option value="'. $set['id'] .'">'. $set['AccountLast'] .', '. $set['AccountFirst'] .'</option>';
            endif;

        endwhile;

        echo '</select>';
        echo '</div>';

        

        mysqli_close( $connect );

    endif;

?>