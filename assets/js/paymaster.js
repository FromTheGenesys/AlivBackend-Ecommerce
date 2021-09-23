$( document ).ready( function() {   

    $( '#Payment' ).blur( function() {

        var ExchangeRate        =       $( '#ForexRate' ).val();
        var Payment             =       $( '#Payment' ).val();
        var JMDPayment          =       ( Number( Payment ) / Number( ExchangeRate ) );

        var GovtFXDuty          =       ( Number( Payment ) * 0.0125 );
        var GovtSTDuty          =       ( ( Number( Payment ) +  Number( GovtFXDuty ) ) * 0.015 );
        var TotalDue            =       ( Number( Payment ) + Number( GovtFXDuty ) + Number( GovtSTDuty ) + 1.5 + 0.18 );
        
        $( '#PaymentJMD' ).text( '$ ' + JMDPayment.toFixed( 2 ) );
        $( '#ForexDuty' ).text( '$ ' + GovtFXDuty.toFixed( 2 ) );
        $( '#StampDuty' ).text( '$ ' + GovtSTDuty.toFixed( 2 ) );
        $( '#TotalDue' ).text( '$ ' + TotalDue.toFixed( 2 ) );

        if ( isNaN( TotalDue ) === true ) {

            $( '#error' ).html( '<div class="mt-3 alert alert-danger border-danger">Payment Amount must be a valid amount. PLEASE DO NOT include dollar ($) sign.</div>' );
            $( '#PaymentBreakdown' ).hide();

        } else {

            if ( TotalDue === 1.68 ) { 

                $( '#error' ).html( '<div class="mt-3 alert alert-danger border-danger">Payment Amount MUST NOT be empty and MUST BE greater than 0.</div>' );
                $( '#PaymentBreakdown' ).hide();

            } else {

                $( '#error' ).html( '' );
                $( '#PaymentBreakdown' ).show();

            }

        }

    });


    $( '#CashTendered' ).blur( function() {

        console.log( $( '#MobilePhone' ).val().length );
        // console.log( Number( $( '#MobilePhone' ).val() ).valueAsNumber() );

        var AmountDue           =           Number( $( '#AmountDueRounded' ).val() ); 
        var CashTendered        =           Number( $( '#CashTendered' ).val() ); 
        var MobilePhone         =           $( '#MobilePhone' ).val(); 

        if ( AmountDue > CashTendered ) {

            $( '#error' ).html( '<div class="mt-3 alert alert-danger border-danger">Cash Amount provided does not cover the Total Charges Due.</div>' );
            $( '#PaymentButton' ).hide();

        } else {

            if ( $( '#MobilePhone' ).val().length !== 7 ) {

                $( '#error' ).html( '<div class="mt-3 alert alert-danger border-danger">The Mobile Number field is required. It <strong>MUST CONTAIN</strong> seven (7) digits.</div>' );
                $( '#MobilePhone' ).focus();
                $( '#PaymentButton' ).hide();

            } else { 

                if ( isNaN( Number( MobilePhone ) * 1 ) === true ) {

                    $( '#error' ).html( '<div class="mt-3 alert alert-danger border-danger">The Mobile Phone field <strong>MUST CONTAIN</strong> only numeric values.</div>' );
                    $( '#MobilePhone' ).focus();
                    $( '#PaymentButton' ).hide();

                } else {

                    $( '#error' ).html( '' );
                    $( '#PaymentButton' ).show();

                }

            }
            
        }

    });

});