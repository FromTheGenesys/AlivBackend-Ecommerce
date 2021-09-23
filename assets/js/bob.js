$( document ).ready( function() {   

    // tender amount
    $( '#validateBOBPayment').on( 'click', function(){

        var CashAmount    =   Number( $( '#BOBAmount' ).val() );        
        var CashTender    =     Number( $( '#BOBTender' ).val() );

        if ( CashAmount > CashTender ) {

            $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Tender is not sufficient to cover the Cash Amount due.</div>' );
            $( '#makeBOBPayment').hide();
            $( '#validateBOBPayment').show();

        } else {

            if ( $.isNumeric( CashTender ) === false ) {

                $( '#error').html( '<div class="alert mt-2 alert-danger border-danger">All values specified must be numeric. </div>' );
                $( '#makeBOBPayment').hide();
                $( '#validateBOBPayment').show();

            } else {

                if ( $.isNumeric( CashAmount ) === false ) {

                    $( '#error').html( '<div class="alert mt-2 alert-danger border-danger">All values specified must be numeric. </div>' );
                    $( '#makeBOBPayment').hide();
                    $( '#validateBOBPayment').show();

                } else { 

                    $( '#error').html( '' );
                    $( '#makeBOBPayment').show();
                    $( '#validateBOBPayment').hide();

                }
                
            }
    
        } 

    });


    $( '#BOBTender').on( 'blur', function(){

        $( '#makeBOBPayment').hide();
        $( '#validateBOBPayment').show();

    });

});