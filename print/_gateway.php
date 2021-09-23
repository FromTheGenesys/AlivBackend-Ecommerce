<?php
    
    session_start();
    ini_set( 'display_errors', 1 );
    $_SESSION['ReceiptID']        =       $_GET['ReceiptID'];

    define('_URL_PATH', 'http://mvp02.basvr2003.com/projects/cashngo/nextmvp/');   
    define('IMGS_PATH', 'assets/img/');   

    # get order details 
    $connect            =           mysqli_connect( 'generalpurpose.cezjbr3dvdv5.us-east-1.rds.amazonaws.com', 'generald9e89606', 'ce530c36a4a5!!', 'MVPSource' );
   
    # get order details
    $getOrderData       =           mysqli_query( $connect, 'SELECT     GatewayPayments.*,
                                                                        DATE_FORMAT( GatewayPayments.PaymentCreated, "%W, %M %D, %Y" ) as display_date,
                                                                        sysLocations.location_name,
                                                                        UPPER( sysAccounts.account_first ) as account_first,
                                                                        UPPER( sysAccounts.account_last ) as account_last
                                                                        
                                                             FROM       GatewayPayments
                                                             
                                                             LEFT JOIN  sysLocations
                                                             ON         GatewayPayments.PaymentLocation = sysLocations.id

                                                             LEFT JOIN  sysAccounts
                                                             ON         GatewayPayments.PaymentCSR = sysAccounts.id
                                                             
                                                            
                                                             WHERE      GatewayPayments.PaymentID      =   "'. $_GET['ReceiptID'] .'" 
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
    
    <body style="background-color: #FFF;">
  
        <table border="0" class="table" cellpadding="3" cellspacing="3" width="700" align="center" style="font-family: Questrial;">
            <tr>
                <td align="left" valign="top">
                    <a href="#" onclick="window.close()">
                    <img src="<?php echo _URL_PATH . IMGS_PATH; ?>logo.png" style="border: none;"/>
                    </a>
                    
                </td>
                <td align="right" valign="top">
                    <br />
                    <img src="barcode.php?PaymentID=<?php echo $_GET['ReceiptID']; ?>" />   
                    <br />
                    <span style="color: red">RECEIPT # <?php echo $_GET['ReceiptID']; ?> </span> <br />
                    <p><?php echo $OrderData['display_date']; ?></p>
                </td>
            </tr>    
        </table>

        <table border="0" cellpadding="3" cellspacing="3" width="675" align="center" style="font-family: Questrial;">    
            <tr>
                <td align="left" width="33%">
                    <b>CSR Details:</b>
                </td>
                <td align="left" width="40%">
                    <b></b>
                </td>
                
                <td style="text-align: center" rowspan="2" width="27%">                    
                    <?php echo '<img src="'. _URL_PATH . IMGS_PATH .'gateway.png" />';?>
                    <!-- <?php echo '<img src="'. _URL_PATH . IMGS_PATH  .'gateway.png" />';?> -->
                    
                </td>
            </tr>    
            
            <tr>                
                <td align="left" width="33%" valign="top">
                    
                    <?php echo strtoupper( $OrderData['account_last'] ) .', '; ?>
                    <?php echo strtoupper( substr( $OrderData['account_first'], 0, 1 ) ) .'.'; ?>
                    <br />
                    <?php echo strtoupper( $OrderData['location_name'] ); ?>
                    
                    
                </td>
                <td align="left" width="40%" valign="top">
                    
                </td>                
            </tr>    
        </table>
        
        <table border="0" cellpadding="0" cellspacing="0" width="675" align="center" style="margin-top: 50px; font-family: Questrial;">    
            <tr class="tblHeader" style="background-color: #000; color: #FFF;">                
                <td colspan="2">
                    Reference
                </td>
                <td>
                    Customer
                </td>
                
                <td align="right">
                    Amount Paid&nbsp;
                </td>   
            </tr>   
            
            <tr class="tblRow" style="color: #000; border: none;">
                <td valign="top">
                    <?php echo strtoupper( $OrderData['PaymentAccount'] ); ?>
                </td>
                <td valign="top">
                    <?php echo strtoupper( $OrderData['PaymentReference'] ); ?>
                </td>
                <td valign="top">
                    <?php echo strtoupper( $OrderData['PaymentLast'] .', '. $OrderData['PaymentFirst'] ); ?>
                </td>
                
                <td align="right" valign="top">
                    <?php echo '$'. number_format( $OrderData['PaymentAmount'], 2 ); ?>
                </td>                                
            </tr>   
            
             <tr class="tblRow">
                <td valign="top" colspan="5">
                    &nbsp;
                </td>                    
             </tr> 
             
             <tr class="tblRow" style="color: #000;">
                <td valign="top">
                    &nbsp;
                </td>
                
                <td valign="top">
                    &nbsp;
                </td>
                
                
                <td align="right" valign="top">
                    Amount Tendered :
                </td>
                
                <td align="right" valign="top" style="border-bottom: 1px solid #000; ">
                    <?php echo '$'. number_format( $OrderData['PaymentTendered'], 2 ); ?>
                </td>                
                
            </tr> 
            
            <tr class="tblRow" style="color: #000;">
                <td valign="top">
                    &nbsp;
                </td>
                <td valign="top">
                    &nbsp;
                </td>
              
                <td align="right" valign="top">
                    Change :
                </td>
                
                <td align="right" valign="top" style="border-bottom: 1px solid #000; ">
                    <?php echo '$'. number_format( $OrderData['PaymentTendered'] - $OrderData['PaymentAmount'], 2 ); ?>
                </td>                                
            </tr> 
            
            <tr class="tblRow">
                <td valign="top" colspan="5">
                    &nbsp;
                </td>                    
             </tr> 
             
             <tr class="tblRow">
                <td valign="top" colspan="5">
                    &nbsp;
                </td>                    
             </tr> 
             
             <tr class="tblRow">
                <td valign="top" colspan="5">
                    &nbsp;
                </td>                    
             </tr> 
            
             <tr class="tblRow">
                <td valign="top" colspan="5" align="center">
                    Cash N Go 
                </td>                    
             </tr> 
             <tr class="tblRow">
                <td valign="top" colspan="5" align="center">
                    www.simplycashngo.com | info@simplycashngo.com
                </td>                    
             </tr> 
             <tr class="tblRow">
                <td valign="top" colspan="5" align="center">
                TIN: 100347368
                </td>                    
             </tr> 
            
        </table>