$( document ).ready( function() {   

    // tender amount
    $( '#validateGatewayPayment').on( 'click', function(){

        var CashAmount    =   Number( $( '#GatewayAmount' ).val() );        
        var CashTender    =   Number( $( '#GatewayTender' ).val() );

        if ( CashAmount > CashTender ) {

            $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Tender is not sufficient to cover the Cash Amount due.</div>' );
            $( '#makeGatewayPayment').hide();
            $( '#validateGatewayPayment').show();

        } else {

            if ( $.isNumeric( CashTender ) === false ) {

                $( '#error').html( '<div class="alert mt-2 alert-danger border-danger">All values specified must be numeric. </div>' );
                $( '#makeGatewayPayment').hide();
                $( '#validateGatewayPayment').show();

            } else {

                if ( $.isNumeric( CashAmount ) === false ) {

                    $( '#error').html( '<div class="alert mt-2 alert-danger border-danger">All values specified must be numeric. </div>' );
                    $( '#makeGatewayPayment').hide();
                    $( '#validateGatewayPayment').show();

                } else { 

                    $( '#error').html( '' );
                    $( '#makeGatewayPayment').show();
                    $( '#validateGatewayPayment').hide();

                }
                
            }
    
        } 

    });

    $( '#GatewayAmount').on( 'blur', function(){

        $( '#makeGatewayPayment').hide();
        $( '#validateGatewayPayment').show();

    });

    $( '#GatewayTender').on( 'blur', function(){

        $( '#makeGatewayPayment').hide();
        $( '#validateGatewayPayment').show();

    });

});