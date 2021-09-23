
$( document ).ready( function() {   

    $( '#ConfirmGamingDepositAmount' ).on( 'blur', function() {

        var DepAmount           =           Number( $( '#DepositAmount' ).val() );
        var ConAmount           =           Number( $( '#ConfirmGamingDepositAmount' ).val() );
        var Operator            =           $( '#OperatorID' ).val();

        if ( DepAmount == ConAmount ) {

            if ( ( Operator == 'ASW' ) || ( Operator == 'CH' ) || ( Operator == 'TIG' ) || ( Operator == 'FML' ) ) {

                if ( DepAmount <= '25' ) {

                    var Fee     =       '0.50';
                    var VAT     =       .5 * .12;
                    var Total   =       Number( DepAmount ) - ( Number( Fee ) +  Number( VAT ) );

                } else if ( ( DepAmount > '25' ) && ( DepAmount <= '50' ) ) {

                    var Fee     =       '1.00';
                    var VAT     =       1 * .12;
                    var Total   =       Number( DepAmount ) - ( Number( Fee ) +  Number( VAT ) );

                } else if ( ( DepAmount > '50' ) && ( DepAmount <= '75' ) ) {

                    var Fee     =       '1.50';
                    var VAT     =       1.5 * .12;
                    var Total   =       Number( DepAmount ) - ( Number( Fee ) +  Number( VAT ) );

                } else  {

                    var Fee     =       '2.00';
                    var VAT     =       2 * .12;
                    var Total   =       Number( DepAmount ) - ( Number( Fee ) +  Number( VAT ) );

                }

            }

            $( '#CNGFee' ).val( Fee );
            $( '#CNGVAT' ).val( VAT.toFixed(2) );
            $( '#TotalDepositAmount' ).val( Total.toFixed(2) );

            $( '#CashTendered' ).focus()
            $( '#ShowDepositDetails' ).show();
            $( '#depositError' ).html('');

        } else {

            $( '#ShowDepositDetails' ).hide();
            $( '#depositError' ).html( '<div class="alert alert-danger border-danger mt-3">Please ensure that both amounts match.</div>' );

        }

    });


    $( '#ConfirmWithdrawAmount' ).blur( function() {

        var WithdrawAmount      =           Number( $( '#WithdrawAmount' ).val() );
        var ConAmount           =           Number( $( '#ConfirmWithdrawAmount' ).val() );
        var Operator            =           $( '#OperatorID' ).val();
        var AvailableBalance    =           Number( $( '#AvailableBalance').val() );
         

        if ( WithdrawAmount == ConAmount ) {

            if ( WithdrawAmount > AvailableBalance ) {

                $( '#ShowWithdrawDetails' ).hide();
                $( '#withdrawError' ).html( '<div class="alert alert-danger border-danger mt-3">Insufficient Funds.  The account balance is insufficient to facilite this request. Please try a lower amount.</div>' );

            } else { 

                if ( ( Operator == 'ASW' ) || ( Operator == 'CH' ) || ( Operator == 'TIG' ) || ( Operator == 'FML' ) ) {

                    if ( WithdrawAmount <= '25' ) {

                        var Fee     =       1.25;
                        var VAT     =       Fee * .12;
                        var Total   =       Number( WithdrawAmount ) - ( Number( Fee ) +  Number( VAT ) );

                    } else if ( ( WithdrawAmount > '25' ) && ( WithdrawAmount <= '50' ) ) {

                        var Fee     =       2.50;
                        var VAT     =       Fee * .12;
                        var Total   =       Number( WithdrawAmount ) - ( Number( Fee ) +  Number( VAT ) );

                    } else if ( ( WithdrawAmount > '50' ) && ( WithdrawAmount <= '75' ) ) {

                        var Fee     =       3.75;
                        var VAT     =       Fee * .12;
                        var Total   =       Number( WithdrawAmount ) - ( Number( Fee ) +  Number( VAT ) );

                    } else  {

                        var Fee     =       5;
                        var VAT     =       Fee * .12;
                        var Total   =       Number( WithdrawAmount ) - ( Number( Fee ) +  Number( VAT ) );

                    }

                }

                $( '#CNGFee' ).val( Fee.toFixed(2) );
                $( '#CNGVAT' ).val( VAT.toFixed(2) );
                $( '#TotalWithdrawalAmount' ).val( Total.toFixed(2) );

                $( '#IDNumber' ).focus()
                $( '#ShowWithdrawDetails' ).show();
                $( '#withdrawError' ).html('');

            }

        } else {

            $( '#ShowWithdrawDetails' ).hide();
            $( '#withdrawError' ).html( '<div class="alert alert-danger border-danger mt-3">Please ensure that both amounts match.</div>' );

        }

    });


    $( '#CashTendered' ).blur( function() { 

        var CashTendered        =       Number( $( '#CashTendered').val() );
        var DepAmount           =       Number( $( '#DepositAmount' ).val() );

        if ( CashTendered >= DepAmount ) {

            $( '#DepositButton' ).show();

        } else {

            $( '#DepositButton' ).hide();
            $( '#depositError' ).html( '<div class="alert alert-danger border-danger mt-3">The Cash Amount Tendered is insufficient and cannot cover the charge.</div>' );

        }

    });

    $( '#CustomerPIN' ).blur( function() { 

        var IDNumber            =       $( '#IDNumber').val().length;

        if ( IDNumber > 4 ) {

            $( '#withdrawError' ).html( '' );
            $( '#WithdrawButton' ).show();

        } else {

            $( '#withdrawError' ).html( '<div class="alert alert-danger border-danger mt-3">The ID Number Field does not contain sufficient characters. Please check your entry then try again.</div>' );
            $( '#WithdrawButton' ).hide();

        }

    });

    $( '#IDNumber' ).on( 'click', function() {

        var CustomerPIN         =       $( '#CustomerPIN' ).val().length

        if ( CustomerPIN > 0 ) {

            $( '#WithdrawButton' ).hide();

        }

    });

}); 