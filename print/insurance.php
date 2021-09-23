<?php
    
    session_start();
    ini_set( 'display_errors', 1 );
    $_SESSION['OrderID']        =       $_GET['OrderID'];

    define('_URL_PATH', 'http://mvp02.basvr2003.com/');   
    define('IMGS_PATH', 'assets/img/');   
    
    # get order details 
    $connect            =           mysqli_connect( '10.0.0.203', 'mvp', 'Fornow1@', 'MVPSourceLive' );
    
    # get order details
    $getOrderData       =           mysqli_query( $connect, 'SELECT     IGASPaymentOrders.*,                                                                        
                                                                        DATE_FORMAT( IGASPaymentOrders.OrderCreated, "%W, %M %D, %Y" ) as display_date,
                                                                        sysLocations.location_name,
                                                                        UPPER( sysAccounts.account_first ) as account_first,
                                                                        UPPER( sysAccounts.account_last ) as account_last,
                                                                        ( SELECT SUM( IGASPaymentOrderItems.PolicyPayment )
                                                                        
                                                                          FROM       IGASPaymentOrderItems
                                                                          WHERE      IGASPaymentOrderItems.OrderID = IGASPaymentOrders.OrderID ) as ItemAmountTotal
                                                                          
                                                                        
                                                                        
                                                             FROM       IGASPaymentOrders
                                                             
                                                             LEFT JOIN  sysLocations
                                                             ON         IGASPaymentOrders.OrderLocation = sysLocations.id

                                                             LEFT JOIN  sysAccounts
                                                             ON         IGASPaymentOrders.OrderCSR= sysAccounts.id
                                                             
                                                             
                                                             
                                                            
                                                             WHERE      IGASPaymentOrders.OrderID      =   "'. $_GET['OrderID'] .'" 
                                                             
                                                            ');
    # get order data
    $OrderData           =           mysqli_fetch_assoc( $getOrderData );
    
    // print_r( $OrderData );
    
    # get order details
    $getOrderItems       =           mysqli_query( $connect, 'SELECT    IGASPaymentOrderItems.*,
                                                                        IGASPolicyMap.PlanNo,
                                                                        IGASPolicyMap.PlanName,
                                                                        IGASPolicyMap.PlanDescription,
                                                                        IGASPolicyMap.PlanVatable
                                                                        
                                                             FROM       IGASPaymentOrderItems
                                                             LEFT JOIN  IGASPolicyMap
                                                             ON         IGASPolicyMap.PlanNo = IGASPaymentOrderItems.PolicyPlanNo
                                                             WHERE      IGASPaymentOrderItems.OrderID      =   "'. $_GET['OrderID'] .'" 
                                                             ORDER BY   IGASPaymentOrderItems.ItemID ASC
                                                            ');
    
    
  

        function CurrencyRounding( $Amount ) {

                                                // ensure that there are two digits
            $Amount         =       number_format( $Amount, 2, '.', '' );

            // $D = dollar, $C = coins
            list( $D, $C )  =       explode( '.', $Amount );    

            // focus digit
            $Digit          =       $C[1];
            
            // if the digit is less than or equal to two ( round down to zero )
            if ( $Digit <=  '2' ) :

                $NewCoins       =        $C[0] . '0';
                $NewAmount      =        $D .'.'. $NewCoins;
                $RoundValue     =        $NewAmount;

                
            // if the digit is between 3 and 5, round up to 5
            // else, if the digit if 5 to 7, round down to 5                
            elseif( ( $Digit >= '3' ) AND ( $Digit <= '7' ) ) :

                $NewCoins       =        $C[0] . '5';
                $NewAmount      =        $D .'.'. $NewCoins;
                $RoundValue     =        $NewAmount;

                

            // else, the amount should be incremented to the nearest tenth                
            else :

                $NewCoins       =        $C[0] + 1;
                $RoundValue     =        $D + ( $NewCoins / 10 );

            endif;

            return $RoundValue;
                                    
        }
   
    
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
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway">           
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">           
        <link rel="stylesheet" type="text/css" href="<?php echo _URL_PATH; ?>public/css/main.css">     
        <script language="text/javascript">
            window.print();
        </script>
        
    </head>
    
    <body style="background-color: #FFF;" >

        <table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" style="padding-top: 0px; font-family: Raleway;">  

            <tr>
                <td align="center" colspan="2">
                    <a href="#" onclick="window.close()">
                    <img src="baf.png" style="width: 25%"/>
                    </a>
                </td>
            </tr>  

            <tr>
                <td align="center" colspan="2">
                    <b style="font-weight: 800; font-size: 18px; font-family: Ubuntu;">VAT INVOICE / SALES RECEIPT</b>
                </td>
            </tr>  

            <tr>
                <td align="center" style="padding-top: 10px;">
                    <b style="font-size: 14px; font-family: Ubuntu;">VAT Invoice / Sales Receipt No</b>: <?php echo $OrderData['OrderID']; ?>
                </td>

                <td align="center" style="padding-top: 10px;">
                    <b style="font-size: 14px; font-family: Ubuntu;">Receipt Date: </b> <?php echo date( 'd-M-Y \a\t h:i a', strtotime( $OrderData['OrderCreated'] ) ); ?>
                </td>
            </tr>  


            <tr>
                <td align="center" style="padding-top: 10px; border-right: 2px solid #000;" width="50%">
                    
                    <table border="0" cellpadding="3" cellspacing="3" width="90%" align="right" style="padding-top: 10px; font-family: Raleway;">  
                        <tr>
                            <td valign="top" style="font-weight: 700;">FROM: </td>
                            <td valign="top" style="font-size: 14px;" colspan="3"><i>
                                BAF Financial & Insurance (Bahamas) Ltd. <br />
                                Independence Drive <br />
                                P.O. Box N-4815 <br />
                                Nassau, Bahamas <br /></i>
                            </td>
                        </tr>

                        <tr>
                            <td valign="top" style="font-weight: 700;">TIN: </td>
                            <td valign="top" style="font-size: 14px;"><i>
                                100239418</i>
                            </td>
                            <td valign="top" style="font-weight: 700;" align="right">VAT Rate: </td>
                            <td valign="top" style="font-size: 14px;"><i>
                                12.00%</i>
                            </td>
                        </tr>
                    </table>

                </td>

                <td align="center" colspan="2" style="padding-top: 10px;">
                    
                </td>
            </tr>  

            <tr>
                <td class="tblRow" style="border-bottom: 2px solid #000" colspan="2">
                    &nbsp;
                </td>
            </tr>
        </table>


        <table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" style="padding-top: 10px; font-family: Raleway; font-weight: 900; font-size: 13px;">  
            <tr class="tblRow">
                <td valign="top">
                    <i>Event</i>
                </td>
                <td valign="top" width="90">
                    <i>Policy Number</i>
                </td>
                <td valign="top">
                    <i>Insured</i>
                </td>
                <td valign="top">
                    <i>* Due Date</i>
                </td>
                <td valign="top" align="center" width="75">
                    <i>Amount Excl. VAT</i>
                </td>
                <!-- <td valign="top" width="50">
                    <i>VAT Rate</i>
                </td> -->
                <td valign="top" align="center" width="75">
                    <i>VAT Amount</i>
                </td>
                <td valign="top" align="center" width="90">
                    <i>Amount Incl. VAT</i>
                </td>
            </tr>

            <tr class="tblRow">
                <td colspan="8" style="border-bottom: 2px solid #000">
                    
                </td>
            </tr>

            <?php $Collection = 0; $Loan = 0; $APL = 0; $Amount = 0; $VAT = 0; while( $ItemSet = mysqli_fetch_assoc( $getOrderItems ) ): ?>
            
                <tr class="tblRow" style="font-size: 14px; font-weight: 100;">
                    <td valign="top">

                        <?php if ( $ItemSet['ItemType'] == 'P' ) : ?>
                            <i>Premium Payment</i>
                        <?php elseif ( $ItemSet['ItemType'] == 'L' ) : ?>
                            <i>Loan Payment</i>
                        <?php elseif ( $ItemSet['ItemType'] == 'A' ) : ?>
                            <i>APL Payment</i>
                        <?php endif; ?>
                    </td>
                    <td valign="top">
                        <i><?php echo $ItemSet['PolicyNumber']; ?></i> 
                    </td>
                    <td valign="top">
                        <i><?php echo $ItemSet['PolicyLast']; ?>, <?php echo $ItemSet['PolicyFirst']; ?></i>                        
                    </td>
                    <td align="left" valign="top">

                    <?php list( $y, $m, $d )    =   explode( '-', $ItemSet['PolicyDueDate'] ); ?>
                        <?php if ( $ItemSet['ItemType'] == 'P' ) : ?>

                            <?php if ( $ItemSet['PolicyMode'] == 'Weekly' ) : ?>
                                <i><?php echo strtoupper( date( 'd-M-Y', mktime( 0, 0, 0, $m, $d + ( 7 * $ItemSet['PolicyPayIncr'] ) , $y ) ) ); ?>
                            <?php else: ?>
                                <i><?php echo strtoupper( date( 'd-M-Y', mktime( 0, 0, 0, $m + $ItemSet['PolicyPayIncr'], $d, $y ) ) ); ?>
                            <?php endif; ?>

                        <?php else: ?>

                            <i><?php echo strtoupper( date( 'd-M-Y', mktime( 0, 0, 0, $m, $d, $y ) ) ); ?>

                        <?php endif; ?>

                    </td>   
                    <td align="right" valign="top">

                        <?php if ( $ItemSet['ItemType'] == 'P' ) : ?>
                           
                                <?php if ( $ItemSet['PolicyApplyOpenPayment'] == 'Y' ) : ?>

                                    <?php if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) : ?>

                                        <i>$<?php echo number_format( $ItemSet['PolicyOpenPaymentAmount'] - $ItemSet['PolicySuspense'], 2); ?></i>

                                    <?php else: ?>

                                        <i>$<?php echo number_format( $ItemSet['PolicyOpenPaymentAmount'], 2); ?></i>

                                    <?php endif; ?>

                                <?php else: ?>

                                    <?php if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) : ?>
                                    
                                        <i>$<?php echo number_format( ( $ItemSet['PolicyAmount'] * $ItemSet['PolicyPayIncr'] ) -  $ItemSet['PolicySuspense'], 2); ?></i>

                                    <?php else: ?>

                                        <?php if ( $ItemSet['PlanVatable'] == 'Yes' ) : ?>

                                            <i>$<?php echo number_format( $ItemSet['PolicyCollection'] * $ItemSet['PolicyPayIncr'], 2); ?></i>

                                        <?php else: ?>

                                            <i>$<?php echo number_format( $ItemSet['PolicyAmount'] * $ItemSet['PolicyPayIncr'], 2); ?></i>

                                        <?php endif; ?>

                                    <?php endif; ?>

                                <?php endif; ?>

                        <?php elseif ( $ItemSet['ItemType'] == 'L' ) : ?>
                            <i>$<?php echo number_format( $ItemSet['PolicyLoanPayment'] * $ItemSet['PolicyPayIncr'], 2); ?></i>
                        <?php elseif ( $ItemSet['ItemType'] == 'A' ) : ?> 
                            <i>$<?php echo number_format( $ItemSet['PolicyAPLPayment'] * $ItemSet['PolicyPayIncr'], 2); ?></i>
                        <?php endif; ?>
                    </td>   

                    <!-- <td style="text-align: right" valign="top">
                        <?php

                            if ( $ItemSet['PlanVatable'] == 'Yes' ) :
                                echo '<i>12.00%</i>';
                            else:
                                echo '<i>0.00%</i>';
                            endif;

                        ?>


                    </td> -->

                    <td align="right" valign="top">
                        <?php if ( $ItemSet['ItemType'] == 'P' ) : ?>

                            <?php if ( $ItemSet['PlanVatable'] == 'Yes' ) : ?>
                                <i>$<?php echo number_format( $ItemSet['PolicyVAT'] * $ItemSet['PolicyPayIncr'], 2 ); ?></i>
                            <?php else: ?>
                                <i>$<?php echo '0.00'; ?></i>
                            <?php endif; ?>

                        <?php else: ?>
                            <i>$<?php echo '0.00'; ?></i>
                        <?php endif; ?>


                    </td>   

                    <td align="right" valign="top">     
                        <?php if ( $ItemSet['ItemType'] == 'P' ) : ?>
                            <?php if ( ( $ItemSet['PolicyPlanNo'] == '115') OR ( $ItemSet['PolicyPlanNo'] == '116' ) ) : ?>
                                <i>$<?php echo number_format( $ItemSet['PolicyPayment'] * $ItemSet['PolicyPayIncr'], 2 ); ?></i>                         
                            <?php else: ?>

                                <?php if ( $ItemSet['PolicyApplyOpenPayment'] == 'Y' ) : ?>
                                    <?php if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) : ?>
                                        <i>$<?php echo number_format( $ItemSet['PolicyOpenPaymentAmount'] - $ItemSet['PolicySuspense'] , 2 ); ?></i>                         
                                    <?php else: ?>
                                        <i>$<?php echo number_format( $ItemSet['PolicyOpenPaymentAmount'] , 2 ); ?></i>                         
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) : ?>
                                        <i>$<?php echo number_format( ( $ItemSet['PolicyAmount'] * $ItemSet['PolicyPayIncr'] ) - $ItemSet['PolicySuspense'], 2 ); ?></i>                         
                                    <?php else: ?>
                                        <i>$<?php echo number_format( $ItemSet['PolicyAmount'] * $ItemSet['PolicyPayIncr'], 2 ); ?></i>                         
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php elseif ( $ItemSet['ItemType'] == 'L' ) : ?>
                            <i>$<?php echo number_format( $ItemSet['PolicyLoanPayment'] * $ItemSet['PolicyPayIncr'], 2); ?></i>
                        <?php elseif ( $ItemSet['ItemType'] == 'A' ) : ?> 
                            <i>$<?php echo number_format( $ItemSet['PolicyAPLPayment'] * $ItemSet['PolicyPayIncr'], 2); ?></i>
                        <?php endif; ?>                   
                        
                    </td>   
                </tr>

                <?php if ( $ItemSet['ItemType'] == 'P' ) :

                        if ( $ItemSet['PlanVatable'] == 'Yes' ) :

                            if ( $ItemSet['PolicyApplyOpenPayment'] == 'Y' ) : 
                                
                                if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) :

                                    $Collection     =   ( $Collection + ( $ItemSet['PolicyOpenPaymentAmount'] - $ItemSet['PolicySuspense'] ) );                    
                                    $Amount         =   ( $Amount + ( $ItemSet['PolicyOpenPaymentAmount'] - $ItemSet['PolicySuspense'] ) );
                                    $VAT            =   ( $VAT + ( ( $ItemSet['PolicyAmount'] - $ItemSet['PolicyCollection'] ) ) );

                                else:

                                    $Collection     =   ( $Collection + ( $ItemSet['PolicyOpenPaymentAmount']  ) );                    
                                    $Amount         =   ( $Amount + ( $ItemSet['PolicyOpenPaymentAmount']  ) );
                                    $VAT            =   ( $VAT + ( ( $ItemSet['PolicyAmount'] - $ItemSet['PolicyCollection'] ) ) );

                                endif;

                            else:

                                if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) :

                                    $Collection     =   ( $Collection + ( $ItemSet['PolicyCollection'] * $ItemSet['PolicyPayIncr'] ) - $ItemSet['PolicySuspense'] );                    
                                    $Amount         =   ( $Amount + ( $ItemSet['PolicyAmount'] - $ItemSet['PolicySuspense']) );
                                    $VAT            =   ( $VAT + ( ( $ItemSet['PolicyAmount'] - $ItemSet['PolicyCollection'] ) * $ItemSet['PolicyPayIncr'] ) );

                                else:

                                    if ( $ItemSet['PolicyMode'] == 'Weekly') :

                                        $Collection     =   ( $Collection + ( $ItemSet['PolicyAmount'] * $ItemSet['PolicyPayIncr'] ) );                    
                                        $Amount         =   ( $Amount + ( $ItemSet['PolicyAmount']  ) );
                                        $VAT            =   ( $VAT + ( ( $ItemSet['PolicyAmount'] - $ItemSet['PolicyCollection'] ) * $ItemSet['PolicyPayIncr'] ) );

                                    else:

                                        $Collection     =   ( $Collection + ( $ItemSet['PolicyCollection'] * $ItemSet['PolicyPayIncr'] ) );                    
                                        $Amount         =   ( $Amount + ( $ItemSet['PolicyAmount']  ) );
                                        $VAT            =   ( $VAT + ( ( $ItemSet['PolicyAmount'] - $ItemSet['PolicyCollection'] ) * $ItemSet['PolicyPayIncr'] ) );

                                    endif;

                                endif;

                            endif;

                        else:

                            if ( $ItemSet['PolicyApplyOpenPayment'] == 'Y' ) : 

                                if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) :

                                    $Collection     =   ( $Collection + ( $ItemSet['PolicyOpenPaymentAmount'] ) - $ItemSet['PolicySuspense'] );                    
                                    $Amount         =   ( $Amount + ( $ItemSet['PolicyOpenPaymentAmount'] ) - $ItemSet['PolicySuspense'] );

                                else:

                                    $Collection     =   ( $Collection + ( $ItemSet['PolicyOpenPaymentAmount']  ) );                    
                                    $Amount         =   ( $Amount + ( $ItemSet['PolicyOpenPaymentAmount'] ) );

                                endif;

                            else:

                                if ( $ItemSet['PolicyApplySuspense'] == 'Y' ) :

                                    $Collection     =   ( $Collection + ( $ItemSet['PolicyPayment'] ) - $ItemSet['PolicySuspense'] );                    
                                    $Amount         =   ( $Amount + ( $ItemSet['PolicyPayment']  ) - $ItemSet['PolicySuspense'] );
                                
                                else:
                                    
                                    if ( $ItemSet['PolicyMode'] == 'Weekly') :

                                        $Collection     =   ( $Collection + ( $ItemSet['PolicyAmount'] * $ItemSet['PolicyPayIncr'] ) );                    
                                        $Amount         =   ( $Amount + ( $ItemSet['PolicyAmount'] * $ItemSet['PolicyPayIncr'] ) );

                                    else:

                                        $Collection     =   ( $Collection + ( $ItemSet['PolicyPayment'] ) );                    
                                        $Amount         =   ( $Amount + ( $ItemSet['PolicyPayment'] ) );

                                    endif;

                                    // echo $ItemSet['PolicyPayment'] * $ItemSet['PolicyPayIncr'];
                                    // $Collection     =   ( $Collection + ( $ItemSet['PolicyPayment'] * $ItemSet['PolicyPayIncr'] ) );                    
                                    // $Amount         =   ( $Amount + ( $ItemSet['PolicyPayment']  ) );
                                    // print_r( $Amount );

                                endif;

                            endif;

                        endif;

                   elseif ( $ItemSet['ItemType'] == 'L' ) : 

                        $Loan         =   ( $Loan + ( $ItemSet['PolicyLoanPayment'] * $ItemSet['PolicyPayIncr'] ) );

                   elseif ( $ItemSet['ItemType'] == 'A' ) : 

                        $APL         =   ( $APL + ( $ItemSet['PolicyAPLPayment'] * $ItemSet['PolicyPayIncr'] ) );

                    // echo $Amount;
                    // echo '<br />';

                   endif; ?>           
         
            <?php endwhile; ?>

         <tr class="tblRow">
            <td colspan="8" style="border-bottom: 2px solid #000">                    
            </td>
         </tr>

         <tr class="tblRow">
            <td colspan="4">
                <i><b>TOTALS:</b></i>
            </td>
            <td class="align-right"><i>$
                 <?php echo number_format( $Collection + $APL + $Loan, 2 ); ?></i>
            </td>
           
            <td style="text-align: right"><i>$
                <?php echo number_format( $VAT, 2 ); ?></i>
            </td>
            <td style="text-align: right"><i>$ <?php echo number_format( $Collection + $VAT + $APL + $Loan, 2 ); ?></i>
            </td>
         </tr>

        </table>

        <?php 


            $counter    =   0;
                                
            # get order details
            $getOrderChequeData       =           mysqli_query( $connect, 'SELECT   IGASPaymentOrders.*,
                                                                                    DATE_FORMAT( IGASPaymentOrders.OrderCreated, "%W, %M %D, %Y" ) as display_date,
                                                                                    sysLocations.location_name,
                                                                                    UPPER( sysAccounts.account_first ) as account_first,
                                                                                    UPPER( sysAccounts.account_last ) as account_last,

                                                                                    ( SELECT    SUM( IGASPaymentOrderItems.PolicyPayment )
                                                                                
                                                                                      FROM      IGASPaymentOrderItems
                                                                                      WHERE     IGASPaymentOrderItems.OrderID = IGASPaymentOrders.OrderID ) as ItemAmountTotal
                                                                                
                                                                           FROM     IGASPaymentOrders

                                                                           LEFT JOIN  sysLocations
                                                                           ON         IGASPaymentOrders.OrderLocation = sysLocations.id

                                                                           LEFT JOIN  sysAccounts
                                                                           ON         IGASPaymentOrders.OrderCSR = sysAccounts.id

                                                                           WHERE      IGASPaymentOrders.OrderParent    =   "'. $_GET['OrderID'] .'" 
                                                                           
                                                                        ');

            $cashDataArray      =   [];
            $chequeDataArray    =   [];
            $cardDataArray      =   [];
            $totalDataArray     =   [];

            while( $dataRow     =   mysqli_fetch_assoc( $getOrderChequeData ) ) :
               
                if ( $dataRow['OrderChequeAmount'] > 0 ) :
                    $chequeDataArray[]  =   $dataRow['OrderChequeAmount'];
                    $totalDataArray[]   =   $dataRow['OrderAmountTendered'];
                endif;

                if ( $dataRow['OrderCashAmount'] > 0 ) :
                    $cashDataArray[]  =   $dataRow['OrderCashAmount'];
                    $totalDataArray[]   =   $dataRow['OrderAmountTendered'];
                endif;

                if ( $dataRow['OrderCardAmount'] > 0 ) :
                    $cardDataArray[]  =   $dataRow['OrderCardAmount'];
                    $totalDataArray[]   =   $dataRow['OrderAmountTendered'];
                endif;

            endwhile;

            
        ?>

        <table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" style="padding-top: 5px; font-family: Raleway;">  

            <tr>
                <td align="center" valign="top" style="padding-top: 0px;" width="50%">
                    
                    <table border="0" cellpadding="3" cellspacing="3" width="100%" align="right" style="padding-top: 10px; font-family: Raleway;">  
                        <tr>
                            <td valign="top" style="font-weight: 700; font-size: 14px;"><i>Cashier: </i></td>
                            <td valign="top" style="font-size: 14px;"><i>
                                <?php echo $OrderData['account_last'] .', '. $OrderData['account_first'] .' / '. $OrderData['location_name']; ?>
                            </td>
                        </tr>                        
                    </table>

                </td>

                <td align="center" colspan="2" style="padding-top: 0px;" width="50%">
                    <table border="0" cellpadding="3" cellspacing="3" width="100%" align="right" style="padding-top: 10px; font-family: Raleway;">  
                        <tr>
                            <td valign="top" style="font-weight: 700; font-size: 14px;"><i>Cash: </i></td>
                            <td valign="top" align="right" style="font-size: 14px;"><i>$
                                <?php if ( $OrderData['OrderSplit'] == 'Y' ) :?>
                                    <?php $CashAmount = 0; foreach( array_values( $cashDataArray ) as $Amounts ) :  $CashAmount = ( $CashAmount + $Amounts ); endforeach;?>
                                    <?php echo number_format( $CashAmount, 2 ); ?>
                                <?php else: ?>
                                    <?php echo number_format( $OrderData['OrderCashAmount'], 2 ); ?>
                                <?php endif; ?>
                                <!-- <?php echo number_format( $OrderData['OrderCashAmount'], 2 ); ?>  -->
                                
                            </i></td>
                        </tr>                        
                        <tr>
                            <td valign="top" style="font-weight: 700; font-size: 14px;"><i>Cheque: </i></td>
                            <td valign="top" align="right" style="font-size: 14px;"><i>$
                                <?php if ( $OrderData['OrderSplit'] == 'Y' ) :?>
                                    <?php $ChequeAmount = 0; foreach( array_values( $chequeDataArray ) as $Amounts ) :  $ChequeAmount = ( $ChequeAmount + $Amounts ); endforeach;?>
                                    <?php echo number_format( $ChequeAmount, 2 ); ?>
                                <?php else: ?>
                                    <?php echo number_format( $OrderData['OrderChequeAmount'], 2 ); ?>
                                <?php endif; ?>
                            </i></td>

                            <?php $CardAmount = 0; foreach( array_values( $cardDataArray ) as $Amounts ) :  $CardAmount = ( $CardAmount + $Amounts ); endforeach;?>
                        </tr>                        
                        <tr>
                            <td valign="top" style="font-weight: 700; font-size: 14px;"><i>Amount Tendered: </i></td>
                            <td valign="top" align="right" style="font-size: 14px;"><i>$ 
                                <?php if ( $OrderData['OrderSplit'] == 'Y' ) :?>
                                    <?php $TotalAmount = 0; foreach( array_values( $totalDataArray ) as $Amounts ) :  $TotalAmount = ( $TotalAmount + $Amounts ); endforeach;?>
                                    <?php echo number_format( $TotalAmount, 2 ); ?>
                                <?php else: ?>
                                    <?php echo number_format( $OrderData['OrderAmountTendered'], 2 ); ?>
                                <?php endif; ?>
                            
                            <!-- <?php echo number_format( $OrderData['OrderAmountTendered'], 2 ); ?>  -->
                            </i></td>
                        </tr>                        
                        <tr>
                            <td valign="top" style="font-weight: 700; font-size: 14px;"><i>Amount Due: </i></td>
                            <td valign="top" align="right" style="font-size: 14px;"><i>$ 
                            
                                <?php if ( $OrderData['OrderPaymethod'] == 1 ) : ?>
                                    <?php echo number_format( $OrderData['OrderCashAmount'], 2 ); ?> 
                                    <?php $TotalAmountDue = $OrderData['OrderCashAmount']; ?> 
                                <?php else: ?>
                                    <?php echo number_format( $Collection + $Loan + $APL + $VAT, 2 ); ?> 
                                    <?php $TotalAmountDue = ($Collection + $Loan + $APL + $VAT ); ?> 
                                <?php endif; ?>

                            </i></td>
                        </tr>                        
                        <tr>
                            <td valign="top" style="font-weight: 700; font-size: 14px;"><i>Change: </i></td>
                            <td valign="top" align="right" style="font-size: 14px;"><i>$ 
                            <?php if ( $OrderData['OrderSplit'] == 'Y' ) :
                                
                                    echo number_format( $TotalAmountDue - ( $CashAmount + $ChequeAmount + $CardAmount ), 2 );
                                ?>


                            <?php else: ?>

                                <?php if ( $OrderData['OrderPaymethod'] == 1 ) : ?>
                                    <?php echo number_format( $OrderData['OrderCashAmount'] - $OrderData['OrderAmountTendered'], 2 ); ?>
                                <?php else: ?>
                                    <?php echo number_format( ( $Collection + $Loan + $APL + $VAT ) - $OrderData['OrderAmountTendered'], 2 ); ?> 
                                <?php endif; ?>

                            <?php endif; ?>
                            </i></td>
                        </tr>                        
                        <tr>
                            <td valign="top" style="font-weight: 700; font-size: 14px;"><i>Cheque Numbers: </i></td>
                            <td valign="top" align="right" style="font-size: 14px;"><i>
                                <!-- <?php echo $OrderData['OrderChequeNumber']; ?> - <?php echo $OrderData['OrderChequeBank']; ?> -->
                                <?php if( $OrderData['OrderSplit'] == 'N' ) : ?>
                                    <?php echo $OrderData['OrderChequeNumber']; ?> - <?php echo $OrderData['OrderChequeBank']; ?>
                                <?php else: 

                                    $counter    =   0;
                                
                               # get order details
                                $getOrderChequeData       =           mysqli_query( $connect, 'SELECT     IGASPaymentOrders.*,
                                                                                                    DATE_FORMAT( IGASPaymentOrders.OrderCreated, "%W, %M %D, %Y" ) as display_date,
                                                                                                    sysLocations.location_name,
                                                                                                    UPPER( sysAccounts.account_first ) as account_first,
                                                                                                    UPPER( sysAccounts.account_last ) as account_last,

                                                                                                    ( SELECT    SUM( IGASPaymentOrderItems.PolicyPayment )
                                                                                                    
                                                                                                      FROM      IGASPaymentOrderItems
                                                                                                      WHERE     IGASPaymentOrderItems.OrderID = IGASPaymentOrders.OrderID ) as ItemAmountTotal
                                                                                                    
                                                                                         FROM       IGASPaymentOrders

                                                                                         LEFT JOIN  sysLocations
                                                                                         ON         IGASPaymentOrders.OrderLocation = sysLocations.id

                                                                                         LEFT JOIN  sysAccounts
                                                                                         ON         IGASPaymentOrders.OrderCSR = sysAccounts.id

                                                                                         WHERE      IGASPaymentOrders.OrderParent    =   "'. $_GET['OrderID'] .'" 
                                                                                         AND        IGASPaymentOrders.OrderPaymethod =   "2"
                                                                                         ');

                                                                                         $chequeArray   =   [];

                                        while( $chequeRow   =   mysqli_fetch_assoc( $getOrderChequeData ) ) :
                                            
                                            $chequeArray[] =    [$chequeRow['OrderChequeNumber'], $chequeRow['OrderChequeBank'] ];

                                        endwhile;

                                        
                                        foreach( $chequeArray as $ChequeInfo ) :

                                            echo $ChequeInfo[0] .' - '. $ChequeInfo[1];

                                            if ( $counter < sizeof( $ChequeInfo )   ):

                                                echo '<br /> ';

                                            endif;

                                            $counter++;

                                        endforeach;

                                
                                endif; ?>
                            </i></td>
                        </tr>                        
                    </table>
                </td>
            </tr>  

            <tr>
                <td class="tblRow" style="" colspan="2">                    
                </td>
            </tr>
        </table>


        <table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" style="font-family: Raleway;">  

            <tr>
                <td align="center" style="font-size: 12px;">
                    <b>** Effective December 31st, 2020, BAF will no longer accept pennies for CASH payments. Rounding rules apply. ** </b>                    
                </td>
            </tr>  

        </table>

        <table border="0" cellpadding="0" cellspacing="0" width="99%" align="center" style="padding-top: 10px; font-family: Raleway;">  

            <tr>
                <td align="center" style="font-size: 12px;">
                    <b>Conditions of Receipt</b>
                    
                </td>
            </tr>  

            <tr>
                <td class="tblRow" style="font-size: 10px;">
                    Acceptance by the Company of the payment acknowledged by this receipt shall not waive any condition nor alter any terms of the policy. If payment is made by cheque or other negotiable instrument, this receipt shall be null and void if such negotiable instrument is not honored on presentation. If the policy is lapsed, this payment shall not reinstate the policy until the conditions mentioned in the policy or application for reinstatement are fulfilled; if such conditions are not met, this payment will be refunded.
                </td>
            </tr>

            <tr>
                <td align="center" style="font-size: 14px; padding-top: 20px; padding-bottom: 10px; border-bottom: 2px solid #000;">
                    <b>Thank you for choosing BAF Financial & Insurance (Bahamas) Ltd., Providing Financial Solutions for Life!</b>
                    
                </td>
            </tr>  

            <tr>
                <td align="center" style="font-weight: 100; font-size: 11px;" >
                    <span style="font-weight: bold; font-size: 13px;">BAF Financial & Insurance (Bahamas) Limited</span>
                    <br/>
                    Independence Drive o P.O. Box N-4815 Nassau, Bahamas Telephone: 461-1000 Fax: 361-2524
                    <br/>
                    www.mybafsolutions.com

                </td>
            </tr>

        </table>

    </body>

