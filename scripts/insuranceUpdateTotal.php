<?php

    ini_set( 'display_errors', 1 );

    $host       =   '10.0.0.203';
    $user       =   'mvp';
    $pswd       =   'Fornow1@';
    $source     =   'MVPSourceLive';

    $connect    =   mysqli_connect( $host, $user, $pswd, $source );

    /* update open amount */
    if ( $_POST['action'] == 1 ) :

        $query      =   'UPDATE IGASPaymentOrderItems SET PolicyApplyOpenPayment = "Y", PolicyOpenPaymentAmount = "'. $_POST['amount'] .'" WHERE ItemID = "'. $_POST['id'] .'" ';
        $result     =   mysqli_query( $connect, $query );

    endif;

    /* update increment amount */
    if ( $_POST['action'] == 2 ) :

        $query      =   'UPDATE IGASPaymentOrderItems SET PolicyPayIncr = "'. $_POST['increment'] .'" WHERE ItemID = "'. $_POST['id'] .'" ';
        $result     =   mysqli_query( $connect, $query );
        
    endif;

    /* update suspense amount */
    if ( $_POST['action'] == 3 ) :

        $query      =   'UPDATE IGASPaymentOrderItems SET PolicyApplySuspense = "'. $_POST['suspense'] .'" WHERE ItemID = "'. $_POST['id'] .'" ';
        $result     =   mysqli_query( $connect, $query );
        
    endif;

    /* update suspense amount - remove */
    if ( $_POST['action'] == 5 ) :

        $query      =   'UPDATE IGASPaymentOrderItems SET PolicyApplySuspense = "N" WHERE ItemID = "'. $_POST['id'] .'" ';
        $result     =   mysqli_query( $connect, $query );
        
    endif;

    /* update increment amount */
    if ( $_POST['action'] == 4 ) :

        $query      =   'UPDATE IGASPaymentOrderItems SET PolicyPayment = "'. $_POST['paymentAmount'] .'" WHERE ItemID = "'. $_POST['id'] .'" ';
        $result     =   mysqli_query( $connect, $query );
        
    endif;

    mysqli_close( $connect );

?>