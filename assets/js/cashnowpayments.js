$( document ).ready( function() {   


    $( '#CashNowPaymentMethod' ).on( 'change', function() {

        var Method          =           $( '#CashNowPaymentMethod' ).val();
        
        // console.log( Method );

        if ( Method == 1 ) {

            $( '#CashTable' ).show();
            $( '#ChequeTable' ).hide();

        } else {

            $( '#CashTable' ).hide();
            $( '#ChequeTable' ).show();

        }

    });

    $( '#CashNowPaymentAmount').on( 'blur', function() {

        $( '#error').html( '' );
        $( '#validateCashNowPayment' ).show();    
        $( '#makeCashNowPayment' ).hide(); 

    });

    $( '#CashNowPaymentTendered').on( 'blur', function() {

        $( '#error').html( '' );
        $( '#validateCashNowPayment' ).show();    
        $( '#makeCashNowPayment' ).hide(); 

    });


    $( '#validateCashNowPayment' ).on( 'click', function(){

        var Method =    $( '#CashNowPaymentMethod' ).val();

        if ( Method == 1 ) {

            var CashAmount          =           Number( $( '#CashNowPaymentAmount').val() );
            var CashTendered        =           Number( $( '#CashNowPaymentTendered').val() );
            var NIB                 =           $( '#NIB').val();

            
            if ( ( $.isNumeric( CashAmount ) === false ) || ( $.isNumeric( CashTendered ) === false ) || ( $.isNumeric( NIB ) === false ) || NIB.length !== 8 ) {

                $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Amount and/or Cash Tender and/or NIB Number fields contain numeric values.</div>' );
                $( '#validateCashNowPayment' ).show();    
                $( '#makeCashNowPayment' ).hide();  

            } else {

                if ( CashAmount > CashTendered ) {

                    $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Tender is not sufficient to cover the Cash Amount due.</div>' );
                    $( '#validateCashNowPayment' ).show();    
                    $( '#makeCashNowPayment' ).hide();    

                } else {
                    
                    $( '#error').html( '' );
                    $( '#makeCashNowPayment').show();
                    $( '#validateCashNowPayment').hide();

                }

            }

        } else {
            
            var ChequeName          =           $( '#CashNowChequeName' ).val();
            var ChequeNumber        =           Number( $( '#CashNowChequeNumber' ).val() );
            var ChequeAmount        =           Number( $( '#CashNowChequeAmount' ).val() );
            var PaymentAmount       =           Number( $( '#CashNowChequePaymentAmount' ).val() );
            var NIB                 =           $( '#NIB' ).val();
            var CurrentDate         =           new Date();
            var ChequeDate          =           new Date( $( '#CashNowChequeDate' ).val() );

            if ( ( $.isNumeric( ChequeNumber ) === false ) || 
                 ( $.isNumeric( ChequeAmount ) === false ) ||
                 ( $.isNumeric( PaymentAmount ) === false ) ) {

                 $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Number, ChequeAmount, PaymentAmount and NIB Number must be numeric values. Please check your entries then try again.</div>' );
                 $( '#validateCashNowPayment' ).show();    
                 $( '#makeCashNowPayment' ).hide();    

            } else {

                // confirm that the NIB number is numeric and the length is 8
                if ( ( $.isNumeric( NIB ) === false ) || 
                     ( NIB.length != 8 ) ) {

                    $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The National Insurance Number provided is invalid. Please check the NIB Number then try again.</div>' );
                    $( '#validateCashNowPayment' ).show();    
                    $( '#makeCashNowPayment' ).hide();    

                } else {

                    // confirm that the cheque date is not post date
                    if ( ChequeDate.getTime() > CurrentDate.getTime() ) {

                        $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Date exceeds the current date.  No post dated cheques can be accepted.</div>' );
                        $( '#validateCashNowPayment' ).show();    
                        $( '#makeCashNowPayment' ).hide();    

                    } else {

                        // check to ensure that the amounts are valid
                        if ( ChequeAmount !== PaymentAmount ) {

                            $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Amount must match the Payment Amount. Please check your entries then try again.</div>' );
                            $( '#validateCashNowPayment' ).show();    
                            $( '#makeCashNowPayment' ).hide();    

                        } else {

                            $( '#error').html( '' );
                            $( '#validateCashNowPayment' ).hide();    
                            $( '#makeCashNowPayment' ).show();    

                        }

                    }

                }

            }

        }

    });

    // $( "#validateCashNowPayment" ).on( 'click', function() {

    //     var Method          =           $( '#CashNowPaymentMethod' ).val();

    //     if ( Method == 1 ) {

    //         var CashAmount          =           Number( $( '#CashNowPaymentAmount').val() );
    //         var CashTendered        =           Number( $( '#CashNowTenderAmount').val() );

    //         if ( ( $.isNumeric( CashTender ) === false ) OR ( $.isNumeric( CashAmount ) === false ) {

    //             $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Amount and/or Cash Tender are numeric values.</div>' );
    //             $( '#validateCashNowPayment' ).show();    
    //             $( '#makeCashNowPayment' ).hide();    

    //         } else {

    //             if ( CashAmount > CashTender ) {

    //                 $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Tender is not sufficient to cover the Cash Amount due.</div>' );
    //                 $( '#validateCashNowPayment' ).show();    
    //                 $( '#makeCashNowPayment' ).hide();    

    //             } else {

    //                 $( '#error').html( '' );
    //                 $( '#makeCashNowPayment').show();
    //                 $( '#validateCashNowPayment').hide();

    //             }

    //         }

    //     } else {



    //     }

    // });

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