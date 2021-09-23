$( document ).ready( function() {   

    $( '#SSIPaymentMethod' ).on( 'change', function() {

        var Method          =           $( '#SSIPaymentMethod' ).val();
        
        if ( Method == 1 ) {

            $( '#CashTable' ).show();
            $( '#ChequeTable' ).hide();

        } else {

            $( '#CashTable' ).hide();
            $( '#ChequeTable' ).show();

        }

    });

    $( '#SSIPaymentAmount').on( 'blur', function() {

        $( '#error').html( '' );
        $( '#validateSSIPayment' ).show();    
        $( '#makeSSIPayment' ).hide(); 

    });

    $( '#SSIPaymentTendered').on( 'blur', function() {

        $( '#error').html( '' );
        $( '#validateSSIPayment' ).show();    
        $( '#makeSSIPayment' ).hide(); 

    });

    $( '#validateSSIPayment' ).on( 'click', function(){

        var Method =    $( '#SSIPaymentMethod' ).val();

        console.log( Method );

        if ( Method == 1 ) {

            var CashAmount          =           Number( $( '#SSIPaymentAmount').val() );
            var CashTendered        =           Number( $( '#SSIPaymentTendered').val() );
            
            
            if ( ( $.isNumeric( CashAmount ) === false ) || ( $.isNumeric( CashTendered ) === false ) ) {

                $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Amount and/or Cash Tender and/or NIB Number fields contain numeric values.</div>' );
                $( '#validateSSIPayment' ).show();    
                $( '#makeSSIPayment' ).hide();  

            } else {

                if ( CashAmount > CashTendered ) {

                    $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash Tender is not sufficient to cover the Cash Amount due.</div>' );
                    $( '#validateSSIPayment' ).show();    
                    $( '#makeSSIPayment' ).hide();    

                } else {
                    
                    $( '#error').html( '' );
                    $( '#makeSSIPayment').show();
                    $( '#validateSSIPayment').hide();

                }

            }

        } else {
            
            var ChequeName          =           $( '#SSIChequeName' ).val();
            var ChequeNumber        =           Number( $( '#SSIChequeNumber' ).val() );
            var ChequeAmount        =           Number( $( '#SSIChequeAmount' ).val() );
            var PaymentAmount       =           Number( $( '#SSIChequePaymentAmount' ).val() );            
            var CurrentDate         =           new Date();
            var ChequeDate          =           new Date( $( '#SSIChequeDate' ).val() );


            console.log( ChequeName );
            console.log( ChequeNumber );
            console.log( ChequeAmount );
            console.log( PaymentAmount );
            console.log( CurrentDate );
            console.log( ChequeDate );

            if ( ( $.isNumeric( ChequeNumber ) === false ) || 
                 ( $.isNumeric( ChequeAmount ) === false ) ||
                 ( $.isNumeric( PaymentAmount ) === false ) ) {

                 $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Number, ChequeAmount, PaymentAmount and NIB Number must be numeric values. Please check your entries then try again.</div>' );
                 $( '#validateSSIPayment' ).show();    
                 $( '#makeSSIPayment' ).hide();    

            } else {

                // confirm that the cheque date is not post date                
                if ( ChequeName.length === 0 ) {

                    $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Name is required.</div>' );
                    $( '#validateSSIPayment' ).show();    
                    $( '#makeSSIPayment' ).hide();    

                } else {

                    if ( $( '#SSIChequeNumber' ).val().length === 0 ) {

                        $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Number is required. Please provide a cheque number to continue.</div>' );
                        $( '#validateSSIPayment' ).show();    
                        $( '#makeSSIPayment' ).hide(); 

                    } else {

                        if ( ChequeDate.getTime() > CurrentDate.getTime() ) {

                            $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Date exceeds the current date.  No post dated cheques can be accepted.</div>' );
                            $( '#validateSSIPayment' ).show();    
                            $( '#makeSSIPayment' ).hide(); 
                            

                        } else { 

                            // check to ensure that the amounts are valid
                            if ( ( ChequeAmount !== PaymentAmount ) || 
                                ( ChequeAmount === 0 ) || ( PaymentAmount === 0 ) ) {

                                $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">The Cheque Amount must match the Payment Amount. Please check your entries then try again.</div>' );
                                $( '#validateSSIPayment' ).show();    
                                $( '#makeSSIPayment' ).hide();    

                            } else {

                                $( '#error').html( '' );
                                $( '#validateSSIPayment' ).hide();    
                                $( '#makeSSIPayment' ).show();    

                            }

                        }

                    }
                    
                }

            }

        }

    });

});