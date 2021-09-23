<?php
    
    session_start();
    ini_set( 'display_errors', 1 );
   // $_SESSION['sessOrderID']        =       $_GET['OrderID'];

    require ('barcode/vendor/autoload.php');
    $barcode = new \Com\Tecnick\Barcode\Barcode();

   define('_URL_PATH', 'http://localhost/projects/cashngo/nextmvp/');   
   define('IMGS_PATH', 'assets/img/');   
    
    # get order details 
    $connect            =           mysqli_connect( 'generalpurpose.cezjbr3dvdv5.us-east-1.rds.amazonaws.com', 'generald9e89606', 'ce530c36a4a5!!', 'MVPSource' );

    # get order details
    $getOrderData       =           mysqli_query( $connect, 'SELECT     WebShopDeposits.*,
                                                                        DATE_FORMAT( WebShopDeposits.DepositCreated, "%W, %M %D, %Y" ) as display_date,
                                                                        sysLocations.location_name,
                                                                        WebShops.WSName,
                                                                        UPPER( sysAccounts.account_first ) as account_first,
                                                                        UPPER( sysAccounts.account_last ) as account_last
                                                                       
                                                             FROM       WebShopDeposits
                                                             
                                                             LEFT JOIN  sysLocations
                                                             ON         WebShopDeposits.DepositLocation = sysLocations.id

                                                             LEFT JOIN  sysAccounts
                                                             ON         WebShopDeposits.DepositCSR= sysAccounts.id
                                                             
                                                             LEFT JOIN  WebShops
                                                             ON         WebShops.WSID   =   WebShopDeposits.DepositWSID

                                                             WHERE      WebShopDeposits.DepositGUID      =   "'. $_GET['ReceiptID'] .'" 
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
                    <span style="color: red">VAT RECEIPT # <?php echo $OrderData['DepositID']; ?> </span> <br />
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
        <table border="0" cellpadding="3" cellspacing="3" width="95%" align="center" style="font-family: Questrial;">    
            
            <tr>
                <td align="center" colspan="2">
                    <h4 style="font-family: Questrial;"><strong>DEPOSIT DETAILS</strong></h4>
                </td>                
            </tr>
            
            <!-- <tr class="tblRow">
                <td align="left" width="50%">
                    Web Shop: 
                </td>                
                <td align="right" width="50%">
                    
                </td>                
            </tr>
            
            <tr class="tblRow">
                <td align="left" width="50%">Customer:</td>                
                <td align="right" width="50%"><?php echo $OrderData['DepositCustNo']; ?> | <?php echo strtoupper( $OrderData['DepositCustLast'] ); ?>, <?php echo strtoupper( $OrderData['DepositCustFirst'] ); ?></td>                
            </tr>
            
            <tr class="tblRow">
                <td align="left" width="50%">Trans ID:</td>                
                <td align="right" width="50%"><?php echo $OrderData['DepositWSTransID']; ?></td>                
            </tr>
            
            <tr class="tblRow">
                <td align="left" width="50%">Payment Method:</td>                
                <td align="right" width="50%">Cash</td>                
            </tr> -->
            
            <tr>
                <td align="left" width="50%">Vendor:</td>                
                <td align="right" width="50%"><?php echo $OrderData['WSName']; ?></td>                
            </tr>
            <tr>
                <td align="left" valign="top" width="50%">Customer:</td>                
                <td align="right" width="50%"><?php echo $OrderData['DepositCustNo']; ?> | <?php echo strtoupper( $OrderData['DepositCustLast'] ); ?>, <?php echo strtoupper( $OrderData['DepositCustFirst'] ); ?></td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">Trans ID:</td>                
                <td align="right" width="50%"><?php echo $OrderData['DepositWSTransID']; ?></td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">Payment Method:</td>                
                <td align="right" width="50%">Cash</td>                
            </tr>

            <tr>
                <td align="left" width="50%">Deposited Amount:</td>                
                <td align="right" width="50%">$ <?php echo number_format( $OrderData['DepositAmount'], 2, '.', ',' ); ?></td>                
            </tr>

            <tr>
                <td align="left" width="50%">
                    Service Charge:
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['DepositCommission'], 2, '.', ',' ); ?>
                </td>                
            </tr>

            <tr>
                <td align="left" width="50%">
                    VAT:
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['DepositCommissionVAT'], 2, '.', ',' ); ?>
                </td>                
            </tr>

            <tr>
                <td align="left" width="50%">
                    <b>Total:</b>
                </td>                
                <td align="right" width="50%" style="border-top: 1px solid #000;"><b>$
                    <?php  echo number_format( floatval( $OrderData['DepositAmount'] + $OrderData['DepositCommission'] + $OrderData['DepositCommissionVAT'] ), 2, '.', ',' ); ?></b>
                </td>                
            </tr>

            <tr>
                <td align="left" width="50%">
                    Tendered:
                </td>                
                <td align="right" width="50%">$
                    <?php  echo number_format( $OrderData['DepositTendered'], 2, '.', ',' ); ?>
                </td>                
            </tr>
           
            <tr>
                <td align="left" width="50%">
                    Change:
                </td>                
                <td align="right" width="50%" style="border-top: 1px solid #000;"><b>$
                    <?php  echo number_format( ( $OrderData['DepositAmount'] + $OrderData['DepositCommission'] + $OrderData['DepositCommissionVAT'] )  -  $OrderData['DepositTendered'], 2, '.', ',' ); ?></b>
                </td>                
            </tr>
            
            <tr>
                <td align="left" width="50%">
                    &nbsp;
                </td>                
                <td align="right" width="50%" ><b>
                    
                </td>                
            </tr>

            <!-- <tr>
                <td align="left" width="50%"><b>Previous Balance:</b></td>                
                <td align="right" width="50%"><b>$<?php  echo number_format( floatval( $OrderData['DepositWSBalance'] - $OrderData['DepositAmount'] ), 2, '.', ',' ); ?></b></td>                
            </tr>
            <tr>
                <td align="left" width="50%"><b>New Balance:</b></td>                
                <td align="right" width="50%"><b>$<?php  echo number_format( $OrderData['DepositWSBalance'], 2, '.', ',' ); ?></b></td>                
            </tr> -->
            
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
                                $OrderData['DepositGUID'],          // data string to encode
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
