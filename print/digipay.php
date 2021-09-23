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
    $getOrderData       =           mysqli_query( $connect, 'SELECT     DigipayTransactions.*,
                                                                        DATE_FORMAT( DigipayTransactions.DigiPayCreated, "%W, %M %D, %Y" ) as display_date,
                                                                        sysLocations.location_name,
                                                                        UPPER( sysAccounts.account_first ) as account_first,
                                                                        UPPER( sysAccounts.account_last ) as account_last
                                                                        
                                                             FROM       DigipayTransactions
                                                             
                                                             LEFT JOIN  sysLocations
                                                             ON         DigipayTransactions.DigiPayLocation = sysLocations.id

                                                             LEFT JOIN  sysAccounts
                                                             ON         DigipayTransactions.DigiPayCSR = sysAccounts.id
                                                             
                                                            
                                                             WHERE      DigipayTransactions.DigiPayGUID      =   "'. $_GET['ReceiptID'] .'" 
                                                            ');

    # get order data
    $OrderData           =           mysqli_fetch_assoc( $getOrderData );
    
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
                    <img src="logo.png" style="border: none;"/>
                    </a>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top">
                    <span style="color: red">VAT RECEIPT # <?php echo  $OrderData['DGPID']; ?> </span> <br />
                    <p><?php echo $OrderData['display_date']; ?></p>
                </td>
            </tr>    
        </table>

        <p>&nbsp;</p>

        <table border="0" cellpadding="3" cellspacing="3" width="90%" align="center" style="font-family: Questrial;">    
             
            <tr>
                <td align="center">
                <table align="center" border="0" cellpadding="2" cellspacing="2" width="100%">
                        <tr>
                            <td align="right" style="font-weight: bold" >
                                Customer
                            </td>
                            <td>
                                <?php echo $OrderData['DigiPayLastName'] .', '. $OrderData['DigiPayFirstName']; ?>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td align="right" style="font-weight: bold" >
                                Email
                            </td>
                            <td>
                                <?php echo $OrderData['DigiPayEmail']; ?>
                            </td>
                        </tr> -->
                        <tr>
                            <td align="right" style="font-weight: bold" >
                                Status
                            </td>
                            <td style="color: green">
                                <?php echo ucwords( $OrderData['DigiPayStatus'] ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="font-weight: bold" >
                                G.o.B. Inv. No
                            </td>
                            <td>
                                <?php echo $OrderData['DigiPayInvRef']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="font-weight: bold" >
                                Agency Invoice
                            </td>
                            <td>
                                <?php echo $OrderData['DigiPayRefNo']; ?>
                            </td>
                        </tr>                       
                    </table>
                </td>                                
            </tr>
            
        </table>

        <p>&nbsp;</p>
        
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
                    <?php  echo number_format( $OrderData['DigiPayAmount'], 2, '.', ',' ); ?>
                </td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">
                    Tendered:
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['DigiPayTendered'], 2, '.', ',' ); ?>
                </td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">
                    Change:
                </td>                
                <td align="right" width="50%" style="border-top: 1px solid #000;"><b>$
                    <?php  echo number_format(  $OrderData['DigiPayAmount'] - $OrderData['DigiPayTendered'], 2, '.', ',' ); ?></b>
                </td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">
                    &nbsp;
                </td>                
                <td align="right" width="50%" ><b>
                    
                </td>                
            </tr>
            
        </table>
        
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
                                $OrderData['DigiPayGUID'],          // data string to encode
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
        
      