$( document ).ready( function() {

    $( '#ConfirmDigiPay' ).on( 'click', function() {

        var TotalDue            =           Number( $( '#TotalDue' ).val() );
        var TotalTender         =           Number( $( '#TotalTendered' ).val() );
        var MobilePhone         =           $( '#MobilePhone' ).val();
        var ConfirmPhone        =           $( '#ConfirmPhone' ).val();

        console.log( $.isNumeric( $( '#TotalTendered' ).val() ) );

        if ( $.isNumeric( $( '#TotalTendered' ).val() ) === false ) {

            $( '#digipayerror' ).html( '<div class="alert alert-danger border-danger">The Total Amount Tendered is not a numeric value</div>' );
            $( '#ConfirmDigiPay' ).show();
            $( '#SettleDigiPay' ).hide();
            
        } else { 

            if ( TotalDue > TotalTender ) {

                $( '#digipayerror' ).html( '<div class="alert alert-danger border-danger">The Total Amount Tendered given does not cover the amount needed to complete this fee.</div>' );
                $( '#ConfirmDigiPay' ).show();
                $( '#SettleDigiPay' ).hide();
                
            } else {


                if ( MobilePhone !==  ConfirmPhone ) {

                    $( '#digipayerror' ).html( '<div class="alert alert-danger border-danger">Mobile Numbers Provided do not match</div>' );
                    $( '#ConfirmDigiPay' ).show();
                    $( '#SettleDigiPay' ).hide();
    
                } else {
    
                    $( '#digipayerror' ).html( '<div class="alert alert-success border-success">Payment Details are confirmed. Click Settle Payment below to continue</div>' );
                    $( '#ConfirmDigiPay' ).hide();
                    $( '#SettleDigiPay' ).show();
    
                }

                // $( '#digipayerror' ).html( '<div class="alert alert-success border-success">Payment Details are confirmed. Click Settle Payment below to continue</div>' );
                // $( '#ConfirmDigiPay' ).hide();
                // $( '#SettleDigiPay' ).show();

            }

        }

    });

    $( '#TotalTendered' ).on( 'blur', function() {

        $( '#ConfirmDigiPay' ).show();
        $( '#SettleDigiPay' ).hide();

    });

});