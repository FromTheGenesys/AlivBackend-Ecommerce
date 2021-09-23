<?php
    
    session_start();
    ini_set( 'display_errors', 1 );
    
    require ('barcode/vendor/autoload.php');
    $barcode = new \Com\Tecnick\Barcode\Barcode();

    define('_URL_PATH', 'http://mvp02.basvr2003.com/');   
    define('IMGS_PATH', 'assets/img/');   
    
    # get order details 
    $connect            =           mysqli_connect( '10.0.0.203', 'mvp', 'Fornow1@', 'MVPSourceLive' );
    
    # get order details
    $getOrderData       =           mysqli_query( $connect, 'SELECT     BillPayOrders.*,
                                                                        DATE_FORMAT( BillPayOrders.OrderCreated, "%W, %M %D, %Y" ) as display_date,
                                                                        sysLocations.location_name,
                                                                        UPPER( sysAccounts.account_first ) as account_first,
                                                                        UPPER( sysAccounts.account_last ) as account_last
                                                                        
                                                             FROM       BillPayOrders
                                                             
                                                             LEFT JOIN  sysLocations
                                                             ON         sysLocations.id = BillPayOrders.LocationID 

                                                             LEFT JOIN  sysAccounts
                                                             ON         sysAccounts.id = BillPayOrders.CSRID 
                                                             
                                                            
                                                             WHERE      BillPayOrders.OrderGUID      =   "'. $_GET['OrderID'] .'" 
                                                            ');

                                                           
    # get order data
    $OrderData           =           mysqli_fetch_assoc( $getOrderData );

    # get order items
    
    $getOrderItemData    =          mysqli_query( $connect, 'SELECT     BillPayData.*
                                                                        
                                                             FROM       BillPayData                                                                                                                          
                                                             WHERE      BillPayData.OrderID      =   "'. $OrderData['OrderID'] .'" 
                                                            ');

    
    
    $VendorSet           =           array( 'BPL' =>   'Bahamas Power and Light',
                                            'BTC' =>   'Bahamas Telecommunications Company',
                                            'WSC' =>   'Water & Sewerage Corporation',
                                            'GBP' =>   'Grand Bahama Power',
                                            'GBU' =>   'Grand Bahama Utility');
   
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Customer Receipt</title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta http-equiv="cleartype" content="on">
        <meta name="viewport" content="width=device-width, initial-scale=1">                
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Questrial">           
        <link rel="stylesheet" type="text/css" href="<?php echo _URL_PATH; ?>assets/css/style.css">                
        <script type="text/javascript">
            window.print();
        </script>
    </head>
    
    <body style="background-color: #FFF;" class="font-lg">
  
        <table border="0" cellpadding="3" cellspacing="3" width="100%" align="center" style="font-family: Questrial;">
            <tr>
                <td align="center" valign="top">
                    <a href="#" onclick="window.close()">
                    <img src="<?php echo _URL_PATH . IMGS_PATH; ?>logo.png" style="border: none;"/>
                    </a>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top">
                    <span style="color: red">VAT RECEIPT # <?php echo $OrderData['OrderID']; ?> </span> <br />
                    <p><?php echo $OrderData['display_date']; ?></p>
                </td>
            </tr>    
        </table>

        <table border="0" cellpadding="3" cellspacing="3" width="95%" align="center" style="font-family: Questrial;">    
            <tr>
                <td align="center">
                    <b>Location:</b>
                </td>                                
            </tr>
            <tr>
                <td align="center">
                    <?php echo strtoupper( $OrderData['location_name'] ); ?>
                </td>                                
            </tr>
            
            <tr>
                <td align="center">
                    &nbsp;
                </td>                                
            </tr>
            
            <tr>
                <td align="center">
                    <b>Representative:</b>
                </td>                                
            </tr>
            <tr>
                <td align="center">
                    <?php echo $OrderData['account_last']; ?>,
                    <?php echo $OrderData['account_first']; ?>
                </td>                                
            </tr>            
        </table>
        
        <br />

        <h3 class="font-weight-bold text-center mb-4" style="font-family: Questrial;"><strong>PAYMENT DETAILS</strong></h3>

        <table class="font-lg" border="0" cellpadding="3" cellspacing="3" width="95%" align="center" style="font-family: Questrial;">            
        <?php while( $ItemData = mysqli_fetch_assoc( $getOrderItemData ) ) : ?>

            <tr>
                <td class="pr-3">
                    <?php echo $ItemData['BillerID']; ?>
                </td>
                <td class="font-weight-bold">
                    <?php echo $ItemData['PaymentAccount'] . ( !empty( $ItemData['PaymentLocation'] ) ? ' - '. $ItemData['PaymentLocation'] : NULL ); ?>
                </td>
                <td class="text-right pl-5" rowspan="2" valign="middle" >
                    <h4><?php echo number_format( $ItemData['PaymentAmount'] + $ItemData['PaymentFee'] + $ItemData['PaymentVAT'], 2 ); ?> </h4>               
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td style="border-top: 1px solid #000;">
                    <?php echo $ItemData['PaymentLast'] .', '. $ItemData['PaymentFirst'] ?>
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    &nbsp;
                </td>                
            </tr>

        <?php endwhile; ?>

            <tr>
                <td>
                    &nbsp;
                </td>
                <td class="text-right font-weight-bold" style="border-top: 1px solid #000;">
                    TOTAL :
                </td>
                <td class="text-right pl-5">
                    <h4><?php echo number_format( $OrderData['OrderAmount'], 2 ); ?> </h4>               
                </td>
            </tr>

            <tr>
                <td>
                    &nbsp;
                </td>
                <td class="text-right font-weight-bold" style="border-bottom: 1px solid #000;">
                    TENDERED :
                </td>
                <td class="text-right pl-5">
                    <h4><?php echo number_format( $OrderData['OrderTender'], 2 ); ?> </h4>               
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
                <td class="text-right font-weight-bold" style="border-bottom: 1px solid #000;">
                    CHANGE :
                </td>
                <td class="text-right pl-5">
                    <h4><?php echo number_format( floatval( $OrderData['OrderTender'] - $OrderData['OrderAmount'] ), 2 ); ?> </h4>               
                </td>
            </tr>

        </table>

        <!-- <table border="0" cellpadding="3" cellspacing="3" width="90%" align="center" style="font-family: Questrial;">    
            <tr>
                <td align="center">
                    <b>Customer:</b>
                </td>                                
            </tr>
            <tr>
                <td align="center">
                    <?php 
                        
                        echo $OrderData['PaymentLast'] .', '. $OrderData['PaymentFirst'];
                        echo '<br />';                        
                        
                        if ( !empty( $OrderData['PaymentAddress'] ) ) :
                              echo $OrderData['PaymentAddress'];                                                
                        endif;
                        
                    ?>
                </td>                                
            </tr>
            <tr>
                <td align="center">
                    <b>Account:</b>
                </td>                                
            </tr>
            <tr>
                <td align="center">
                    <?php           
                    
                        if ( $OrderData['BillerID'] == 'BTC' ) : 
                             
                             echo $OrderData['PaymentAccount'];       
                        
                        else:
                             
                             echo $OrderData['PaymentAccount'];
                             echo '-';
                             echo $OrderData['PaymentLocation'];
                             
                        endif;
                    ?>
                </td>                                
            </tr>
            
            <tr>
                <td align="center">
                    <b>Biller:</b>
                </td>                                
            </tr>
            
            <tr>
                <td align="center">
                    <?php echo $VendorSet[ $OrderData['BillerID'] ];  ?><br />
                    <?php echo '<img align="center" style="" src="'.  _URL_PATH . IMGS_PATH . $OrderData['BillerID'] .'.png" />&nbsp;'; ?>
                </td>                                
            </tr>
           
        </table>
        
        <table border="0" cellpadding="3" cellspacing="3" width="100%" align="center" style="font-family: Questrial;">    
            
            <tr>
                <td align="center" width="100%" colspan="2">
                    <h2 style="font-family: Questrial;">Payment Details</h2>
                </td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">
                    Payment Amount: 
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['PaymentAmount'], 2, '.', ',' ); ?>
                </td>                
            </tr>
            
            <?php if ( ( $OrderData['BillerID'] == 'GBP' ) OR ( $OrderData['BillerID'] == 'GBU' ) ) : ?>
            
            <tr>
                <td align="left" width="50%">
                    Conv. Fee:
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['PaymentFee'], 2, '.', ',' ); ?>
                </td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">
                    VAT
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['PaymentVAT'], 2, '.', ',' ); ?>
                </td>                
            </tr>
            
            
            <?php endif; ?>
            
            <tr>
                <td align="left" width="50%">
                    Tendered:
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['PaymentTendered'], 2, '.', ',' ); ?>
                </td>                
            </tr>
            
            <?php if ( $OrderData['PaymentDonation'] == 1 ) : ?>
            
                <tr>
                    <td align="left" width="50%">
                        Donation:
                    </td>                
                    <td align="right" width="50%">$
                        <?php  echo number_format( $OrderData['PaymentDonationAmount'], 2, '.', ',' ); ?>
                    </td>                
                </tr>
                
            <?php endif; ?>
                
            <tr>
                <td align="left" width="50%">
                    Change:
                </td>                
                <td align="right" width="50%" style="border-top: 1px solid #000;"><b>$
                    <?php  echo number_format( $OrderData['PaymentTendered'] - $OrderData['PaymentAmount'], 2 ); ?></b>
                </td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">
                    &nbsp;
                </td>                
                <td align="right" width="50%" ><b>
                    
                </td>                
            </tr>
                
            <tr>
                <td align="left" width="50%">
                    &nbsp;Remaining Balance
                </td>                
                <td align="right" width="50%" style="border-top: 1px solid #000;"><b>$
                    <?php  echo number_format( floatval( $OrderData['PaymentAmountOriginal'] - $OrderData['PaymentAmount'] ), 2 ); ?></b>
                </td>                
            </tr>
            
        </table>
         -->
        
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top: 50px; font-family: Questrial;">    
            
            <tr class="tblRow">
                <td valign="top" colspan="2" align="center">
                    Cash N' Go                   
                </td>                    
             </tr> 
             <tr class="tblRow">
                <td valign="top" colspan="2" align="center">
                    cashngobahamas.com
                </td>                    
             </tr> 
             <tr class="tblRow">
                <td valign="top" colspan="2" align="center">                    
                    TIN: 100347368
                </td>                    
             </tr> 
            
            <tr>
                 <td align="center" width="100%" colspan="2">

                     <br />
                     <br />
                     <?php

                        $bobj = $barcode->getBarcodeObj(
                                'QRCODE,H',                     // barcode type and additional comma-separated parameters
                                $OrderData['OrderGUID'],          // data string to encode
                                -4,                             // bar width (use absolute or negative value as multiplication factor)
                                -4,                             // bar height (use absolute or negative value as multiplication factor)
                                'black',                        // foreground color
                                array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
                                )->setBackgroundColor('white'); // background color

                        // output the barcode as HTML div (see other output formats in the documentation and examples)
                        echo $bobj->getHtmlDiv();
                    ?>
                     <br />

                 </td>                
               </tr>
        </table>
        
       