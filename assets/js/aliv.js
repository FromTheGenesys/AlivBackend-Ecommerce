$( document ).ready( function() { 

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });

    $( '#UpdatePaymentDetails' ).on( 'click', function() {

        $( '#PaymentAmount').attr('readonly', false );
        $( '#ConfirmAmount').attr('readonly', false );
        $( '#AmountTendered').attr('readonly', false);
        $( '#VerifyPaymentDetails').show();
        $( '#SettlePaymentDetails').hide();
        $( '#UpdatePaymentDetails').hide();
        $( '#PaymentAmount').focus();

        $( '#showError' ).html( '' );

    });

    $( '#VerifyPaymentDetails' ).on( 'click', function(){

        var PaymentAmount           =           Number( $( '#PaymentAmount' ).val() );
        var ConfirmAmount           =           Number( $( '#ConfirmAmount' ).val() );
        var TenderAmount            =           Number( $( '#AmountTendered' ).val() );

        if ( PaymentAmount === ConfirmAmount ) {

            if ( $.isNumeric( PaymentAmount ) === false ) {

                $( '#showError' ).html( '<div class="alert alert-danger border-danger">The Payment Amount must be numeric value.</div>' );
                $( '#VerifyPaymentDetails').show();
                $( '#PaymentAmount').focus();

            } else {

                if ( $.isNumeric( ConfirmAmount ) === false ) {

                    $( '#showError' ).html( '<div class="alert alert-danger border-danger">The Confirmed Amount must be numeric value.</div>' );
                    $( '#VerifyPaymentDetails').show();
                    $( '#ConfirmAmount').focus();

                } else {

                    if ( $.isNumeric( TenderAmount ) === false ) {

                        $( '#showError' ).html( '<div class="alert alert-danger border-danger">The Tendered Amount must be numeric value.</div>' );
                        $( '#VerifyPaymentDetails').show();
                        $( '#AmountTendered').focus();
    
                    } else {

                        if( TenderAmount < PaymentAmount ) {

                            $( '#showError' ).html( '<div class="alert alert-danger border-danger">The Tendered Amount cannot cover the cost of the transaction.</div>' );
                            $( '#VerifyPaymentDetails').show();
                            $( '#AmountTendered').focus();

                        } else{

                            $( '#PaymentAmount').attr('readonly', 'true' );
                            $( '#ConfirmAmount').attr('readonly', 'true' );
                            $( '#AmountTendered').attr('readonly', 'true' );

                            $( '#showError' ).html( '<div class="alert alert-success border-success"><i class="fa fa-thumbs-up"></i> Payment Details have been verified.</div>' );
                            $( '#VerifyPaymentDetails').hide();
                            $( '#SettlePaymentDetails').show();
                            $( '#UpdatePaymentDetails').show();

                        }

                    }

                }

            }

        } else {

            $( '#showError' ).html( '<div class="alert alert-danger border-danger">The Payment Amount and Confirm Payment Amount must be matching numeric values.</div>' );

        }

        

    });     

});