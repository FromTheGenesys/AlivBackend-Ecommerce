<?php
    
    session_start();
    ini_set( 'display_errors', 1 );
    // $_SESSION['ReceiptID']        =       $_GET['ReceiptID'];

    define('_URL_PATH', 'http://localhost/projects/cashngo/nextmvp/');   
    define('IMGS_PATH', 'assets/img/');   

    # get order details 
    $connect            =           mysqli_connect( 'generalpurpose.cezjbr3dvdv5.us-east-1.rds.amazonaws.com', 'generald9e89606', 'ce530c36a4a5!!', 'MVPSource' );
   
    # get order details
    $getOrderData       =           mysqli_query( $connect, 'SELECT     BillPayData.*,
                                                                        DATE_FORMAT( BillPayData.PaymentCreated, "%W, %M %D, %Y" ) as display_date,
                                                                        sysLocations.location_name,
                                                                        UPPER( sysAccounts.account_first ) as account_first,
                                                                        UPPER( sysAccounts.account_last ) as account_last
                                                                        
                                                             FROM       BillPayData
                                                             
                                                             LEFT JOIN  sysLocations
                                                             ON         BillPayData.LocationID = sysLocations.id

                                                             LEFT JOIN  sysAccounts
                                                             ON         BillPayData.CSRID = sysAccounts.id
                                                             
                                                            
                                                             WHERE      BillPayData.PaymentGUID      =   "'. $_GET['PaymentID'] .'" 
                                                            ');
    
    # get order data
    $OrderData           =           mysqli_fetch_assoc( $getOrderData );
    
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
        
    </head>
    
    <body style="background-color: #FFF;">
  
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

        <table border="0" cellpadding="3" cellspacing="3" width="90%" align="center" style="font-family: Questrial;">    
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
        
        
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top: 50px; font-family: Questrial;">    
            
            <tr class="tblRow">
                <td valign="top" colspan="2" align="center">
                    Cash N Go                   
                </td>                    
             </tr> 
             <tr class="tblRow">
                <td valign="top" colspan="2" align="center">
                    www.simplycashngo.com
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
                     <img title="barcode" src="barcode.php?PaymentID=<?php echo $OrderData['OrderID']; ?>" />   
                     <br />

                 </td>                
               </tr>
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top: 50px; font-family: Questrial;">    
            
             
            
        </table>