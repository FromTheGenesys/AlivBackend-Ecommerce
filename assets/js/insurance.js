function addJQuery()
{
	var head = document.getElementsByTagName( 'head' )[0];
	var scriptjQuery = document.createElement( 'script' );
	scriptjQuery.type = 'text/javascript';
	scriptjQuery.id = 'jQuery'
	scriptjQuery.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
	var script = document.getElementsByTagName( 'script' )[0];
	head.insertBefore(scriptjQuery, script);
}

$( document ).ready( function() {   
    
    $( '.insuranceSearch' ).on( 'blur', function() {

        var EmptyCount              =       0; 

        $( '.insuranceSearch').each( function( index, value ){

            if ( $( '.insuranceSearch' ).eq( index ).val().length > 0 ) {

                EmptyCount++;

            }

        });

        if ( EmptyCount > 0 )  {

            $( '#triggerInsuranceSearch' ).show();

        } else {

            $( '#triggerInsuranceSearch' ).hide();

        }

    });

    $( '.openAmount' ).on( 'blur', function() {

        $( '.openAmount' ).each( function( index, value ) {

            if ( $( '.openAmount' ).eq( index ).val().length > 0 ) {

                var Amount  =   $( '.openAmount' ).eq( index ).val();

                $( '.lineTotal' ).eq( index ).val( Amount );

                /** update details */                
                $.post( '../../scripts/insuranceUpdateTotal.php',
                    { 
                        id: $( '.itemID' ).eq( index ).val(),
                        action: 1,                            
                        amount: $( '.openAmount' ).eq( index ).val() 
                    },
                    function( data ) {

                        // alert( 'Data: ' + data );
                        $( '.output' ).eq( index ).html( data );

                    }

                );

            }

        })

        var Total       =       0;

        $( '.lineTotal' ).each( function( index, value ) {
            Total   =   ( Number( Total ) + Number( $( '.lineTotal' ).eq( index ).val() ) );
        });

        if ( isNaN( Total ) ) {

            $( '#btnCheckout' ).hide();
            $( '.displayError').html('<div class="alert bg-danger">All amount values must be numeric, please avoid using commas (,) in your numeric values</div>');

        } else {

            var Empty   =   0;
            var Zero    =   0;

            $( '.lineTotal' ).each( function( index, field ) {  if( field.value.length === 0 ) { Empty++; }  if( Number( field.value ) === 0 ) { Zero++ } } );
            
            if ( ( Zero > 0 ) || ( Empty > 0 ) ) {

                $( '#btnCheckout' ).hide();
                $( '.displayError').html('<div class="alert bg-danger">All amount values must be numeric. Values cannot be empty</div>');

            } else {

                $( '#btnCheckout' ).show();
                $( '.displayError').html('');

            }
         
        }

        $( '#TotalDue' ).val( Total.toFixed(2) );

    });

    $( '.paymentIncrements' ).change( 'blur', function() {

        $( '.paymentIncrements' ).each( function( index, field ) {

            var PayIncr     =        field.value;            
            var LineTotal   =        $( '.policyAmount' ).eq( index ).val();
            var PolicyVAT   =        $( '.policyVAT' ).eq( index ).val();
            var CalcLine    =        Number( PayIncr ) * Number( LineTotal );
            var SuspenseOn  =        $( '.policySuspenseClick' ).eq( index )[0].checked;
            var Suspense    =        $( '.policySuspense' ).eq( index )[0].value;

            if ( PayIncr > 0 ) {

                if ( SuspenseOn === true ) {

                    var WithSuspense    =   ( Number( CalcLine ) - Number( Suspense ) );
                    $( '.lineTotal' ).eq( index ).val( WithSuspense.toFixed(2) );

                    $.post( '../../scripts/insuranceUpdateTotal.php',
                            { 
                                id: $( '.itemID' ).eq( index ).val(),
                                action: 3,                            
                                suspense: 'Y'
                            },
                            function( data ) {
                                // alert( 'Data: ' + data );
                                $( '.output' ).eq( index ).html( data );

                                console.log( data );

                            }

                    );

                } else {

                    /** update details */                
                    $.post( '../../scripts/insuranceUpdateTotal.php',
                            { 
                                id: $( '.itemID' ).eq( index ).val(),
                                action: 2,                            
                                increment: PayIncr
                            },
                            function( data ) {
                                // alert( 'Data: ' + data );
                                $( '.output' ).eq( index ).html( data );
                            }

                    );

                    $.post( '../../scripts/insuranceUpdateTotal.php',
                            { 
                                id: $( '.itemID' ).eq( index ).val(),
                                action: 3,                            
                                suspense: 'N'
                            },
                            function( data ) {
                                // alert( 'Data: ' + data );
                                $( '.output' ).eq( index ).html( data );
                            }

                    );

                    // update payment
                    $.post( '../../scripts/insuranceUpdateTotal.php',
                            { 
                                id: $( '.itemID' ).eq( index ).val(),
                                action: 4,                            
                                paymentAmount: Number( LineTotal ) * Number( PayIncr ),
                                paymentVAT: Number( PolicyVAT ) * Number( PayIncr )
                            },
                            function( data ) {
                                // alert( 'Data: ' + data );
                                $( '.output' ).eq( index ).html( data );
                            }

                    );


                    $( '.lineTotal' ).eq( index ).val( CalcLine.toFixed(2) );

                }

            }

        });

        var Total       =       0;

        $( '.lineTotal' ).each( function( index, value ) {
            Total   =   ( Number( Total ) + Number( $( '.lineTotal' ).eq( index ).val() ) );            
        });

        if ( isNaN( Total ) ) {

            $( '#btnCheckout' ).hide();
            $( '.displayError').html('<div class="alert bg-danger">All amount values must be numeric, please avoid using commas (,) in your numeric values</div>');

        } else {

            var Empty   =   0;
            var Zero    =   0;

            $( '.lineTotal' ).each( function( index, field ) {  if( field.value.length === 0 ) { Empty++; }  if( Number( field.value ) === 0 ) { Zero++ } } );
            
            if ( ( Zero > 0 ) || ( Empty > 0 ) ) {

                $( '#btnCheckout' ).hide();
                $( '.displayError').html('<div class="alert bg-danger">All amount values must be numeric. Values cannot be empty</div>');

            } else {

                $( '#btnCheckout' ).show();
                $( '.displayError').html('');

            }
         
        }

        $( '#TotalDue' ).val( Total.toFixed(2) );

        

    });

    $( '.policySuspenseClick' ).on( 'click', function() {

        $( '.policySuspenseClick' ).each( function( index, field ) {

            if ( field.checked === true ) { 

                var Suspense        =       $( '.policySuspense' ).eq( index ).val();
                
                if ( Suspense > 0 ) {

                    var LineTotal   =       $( '.lineTotal' ).eq( index ).val();                    
                    var NewTotal    =       ( Number( LineTotal ) - Number( Suspense ) );

                    $( '.lineTotal' ).eq( index ).val( NewTotal.toFixed(2) );

                    $.post( '../../scripts/insuranceUpdateTotal.php',
                    { id: $( '.itemID' ).eq( index ).val(),
                      action: 3,                            
                      suspense: 'Y'
                    },
                    function( data ) {
                        // alert( 'Data: ' + data );
                        $( '.output' ).eq( index ).html( data );

                    });

                }

            } else {

                var PayIncr                  =       $( '.paymentIncrements' ).eq( index ).val();
                var PolicyStartAmount        =       $( '.policyStartAmount' ).eq( index ).val();
                var Suspense                 =       $( '.policySuspense' ).eq( index ).val();

                if ( Suspense > 0 ) {

                    var PayIncr              =        ( PayIncr === 0 ? 1 : PayIncr );
                    $( '.lineTotal' ).eq( index ).val( Number( PolicyStartAmount * PayIncr ).toFixed(2) );

                    $.post( '../../scripts/insuranceUpdateTotal.php',
                    { id: $( '.itemID' ).eq( index ).val(),
                      action: 5,                            
                      suspense: 'N'
                    },
                    function( data ) {                        
                        $( '.output' ).eq( index ).html( data );
                    });

                }
                

            }

        });

        var Total       =       0;

        $( '.lineTotal' ).each( function( index, value ) {
            Total   =   ( Number( Total ) + Number( $( '.lineTotal' ).eq( index ).val() ) );
        });

        if ( isNaN( Total ) ) {

            $( '#btnCheckout' ).hide();
            $( '.displayError').html('<div class="alert bg-danger">All amount values must be numeric, please avoid using commas (,) in your numeric values</div>');

        } else {

            var Empty   =   0;
            var Zero    =   0;

            $( '.lineTotal' ).each( function( index, field ) {  if( field.value.length === 0 ) { Empty++; }  if( Number( field.value ) === 0 ) { Zero++ } } );
            
            if ( ( Zero > 0 ) || ( Empty > 0 ) ) {

                $( '#btnCheckout' ).hide();
                $( '.displayError').html('<div class="alert bg-danger">All amount values must be numeric. Values cannot be empty</div>');

            } else {

                $( '#btnCheckout' ).show();
                $( '.displayError').html('');

            }
         
        }

        $( '#TotalDue' ).val( Total.toFixed(2) );

    });

    $( '#validateCash' ).on( 'click', function() {

        var AmountDue       =   Number( $( '#AmountDue' ).val() );
        var AmountTender    =   Number( $( '#AmountTender' ).val() );

        if ( isNaN( AmountTender ) === true ) {

            
        } else {

            if ( AmountDue > AmountTender ) {

                $( '.displayError' ).html( '<div class="alert bg-danger">The Amount Tendered must be able to cover the Amount Due.</div>' );
                $( '#MakePayment' ).hide();

            } else {

                $( '.displayError' ).html( '' );
                $( '#validateCash' ).hide();
                $( '#AmountTender' ).attr('readonly', 'true' );
                $( '#MakePayment' ).show();
                $( '#ClearPayment' ).show();

            }

        }

        $( '#AmountTender' ).val( AmountTender.toFixed(2) );

    });

    $( '#ClearPayment' ).on( 'click', function() {

        $( '#AmountTender' ).attr('readonly', null );
        $( '#AmountTender' ).focus();
        $( '#MakePayment' ).hide();
        $( '#validateCash' ).show();
        $( '#ClearPayment' ).hide();

    });

    $( '#validateCheque' ).on( 'click', function() {

        var AmountDue       =   Number( $( '#AmountDue' ).val() );
        var AmountTender    =   Number( $( '#ChequeAmount' ).val() );
        var ChequeName      =   $( '#ChequeName' ).val().length;        
        var ChequeNumber    =   $( '#ChequeNumber' ).val();
        // var ChequeDate      =   $( '#ChequeDate' ).val();

        var DateParts           =   $( '#ChequeDate' ).val().split( '-' );
        var ChequeDate      =   new Date( DateParts[0], DateParts[1] - 1, DateParts[2], 0, 0, 0 ); 
        var CurrentDate     =   new Date();
        var DateDiff        =   new Date( ChequeDate - CurrentDate );

        var Days            =   DateDiff / 1000 / 60 / 60 / 24;

        if ( isNaN( AmountTender ) === true || isNaN( ChequeNumber) === true || ChequeNumber.length === 0 || ChequeName === 0 || Days >= 0 ) {

            $( '.displayError' ).html( '<div class="alert bg-danger">The Amount Tendered must be a numeric value. The Cheque Amount must be numeric value.  The Cheque Name must contain a value. The Cheque cannot be posted dated.</div>' );
            
        } else {

            if ( AmountDue !== AmountTender ) {

                $( '.displayError' ).html( '<div class="alert bg-danger">The Amount Tendered must be able to cover the Amount Due.</div>' );
                $( '#MakePayment' ).hide();

            } else {

                $( '.displayError' ).html( '' );
                $( '#validateCheque' ).hide();
                $( '#ChequeAmount' ).attr('readonly', 'true' );
                $( '#ChequeName' ).attr('readonly', 'true' );
                $( '#ChequeNumber' ).attr('readonly', 'true' );
                $( '#ChequeDate' ).attr('readonly', 'true' );
                $( '#ChequeBank' ).attr('readonly', 'true' );
                $( '#MakePayment' ).show();
                $( '#ClearChequePayment' ).show();

            }

        }

        $( '#ChequeAmount' ).val( AmountTender.toFixed(2) );

    });

    $( '#ClearChequePayment' ).on( 'click', function() {

        $( '#ChequeAmount' ).attr('readonly', null );
        $( '#ChequeName' ).attr('readonly', null );
        $( '#ChequeNumber' ).attr('readonly', null );
        $( '#ChequeDate' ).attr('readonly', null );
        $( '#ChequeBank' ).attr('readonly', null );
        $( '#validateCheque' ).show();
        $( '#MakePayment' ).hide();
        $( '#ClearChequePayment' ).hide();

    });

    $( '#validateCard' ).on( 'click', function() {

        var AmountDue       =   Number( $( '#AmountDue' ).val() );
        var AmountTender    =   Number( $( '#CardAmount' ).val() );
        var CardName        =   $( '#CardName' ).val().length;        
        var CardLastFour    =   $( '#CardFour' ).val();
        var CardAuth        =   $( '#CardAuth' ).val().length; ;

        console.log( CardName );
        
        if ( isNaN( AmountTender ) === true || isNaN( CardLastFour ) === true || CardLastFour.length !== 4 || CardAuth !== 6 || CardName === 0 ) {

            $( '.displayError' ).html( '<div class="alert bg-danger">The Charge Amount Tendered must be a numeric value. The Card Last Four Digits must be numeric value.  The Card Name must contain a value. The Card  Auth code must be six digits.</div>' );
            
        } else {

            if ( AmountDue !== AmountTender ) {

                $( '.displayError' ).html( '<div class="alert bg-danger">The Charge Amount and the Amount Due must be equal.</div>' );
                $( '#MakePayment' ).hide();

            } else {

                $( '.displayError' ).html( '' );
                $( '#validateCard' ).hide();
                $( '#CardAmount' ).attr('readonly', 'true' );
                $( '#CardAuth' ).attr('readonly', 'true' );
                $( '#CardFour' ).attr('readonly', 'true' );
                $( '#CardName' ).attr('readonly', 'true' );                
                $( '#CardType' ).attr('readonly', 'true' );
                $( '#MakePayment' ).show();
                $( '#ClearCardPayment' ).show();

            }

        }

        $( '#CardAmount' ).val( AmountTender.toFixed(2) );

    });

    $( '#ValidateChequePayout').on( 'click', function(){

        var Amount          =           Number( $( '#ChequeAmount' ).val() );
        var ConfirmAmt      =           Number( $( '#ConfirmAmount' ).val() );
        var MaxAmount       =           Number( $( '#MaxAmount' ).val() );

        var ChequeNumber    =           $( '#ChequeNumber' ).val();
        var ChequeName      =           $( '#ChequeName' ).val();
        var ChequeDate      =           new Date( $( '#ChequeDate' ).val() ),
            CurrentDate     =           new Date(),
            DateDifference  =           new Date( CurrentDate - ChequeDate ),
            Days            =           DateDifference/1000/60/60/24;
        
            
        // cheque amounts must be numeric values
        if ( isNaN( Amount ) || isNaN( ConfirmAmt ) ) {

            $( '#ChequeError' ).html( '<div class="mt-2 alert alert-danger border-danger font-sm">The Amounts provided must be numeric values. Please check your entries then try again.</div>');
            return null;

        }

        // cheque amounts must match
        if ( Amount !== ConfirmAmt ) {

            $( '#ChequeError' ).html( '<div class="mt-2 alert alert-danger border-danger font-sm">The Amounts provided must be equal. Please check your entries then try again.</div>');
            return null;

        }

        // cheque name must be at least 5 characters
        if ( ChequeName.length < 5 ) {

            $( '#ChequeError' ).html( '<div class="mt-2 alert alert-danger border-danger font-sm">The Name on the Cheque must be at least five characters in length. Please check the name then try again.</div>');
            return null;

        }

        // cheque number must be numeric
        if ( isNaN( ChequeNumber ) ) {

            $( '#ChequeError' ).html( '<div class="mt-2 alert alert-danger border-danger font-sm">The Cheque Number provided must be numeric value. Please check your entries then try again.</div>');
            return null;

        }

        // cheque number must be two digits long
        if ( ChequeNumber.length < 2 ) {

            $( '#ChequeError' ).html( '<div class="mt-2 alert alert-danger border-danger font-sm">The Cheque Number provided must be at least two digits in length. Please check your entries then try again.</div>');
            return null;

        }

        // cheque date
        if ( Days < 1 ) {

            $( '#ChequeError' ).html( '<div class="mt-2 alert alert-danger border-danger font-sm">The Cheque Date cannot be post dated. Please check your entries then try again.</div>');
            return null;

        }

        if ( Amount > MaxAmount ) {

            $( '#ChequeError' ).html( '<div class="mt-2 alert alert-danger border-danger font-sm">The Cheque Amount cannot exceed <strong>$' + MaxAmount.toFixed(2)  + '</strong>.  Please check your entry then try again.</div>');
            return null;
        }

       
        $('#ValidateChequePayout').hide();
        $('#MakeChequePayout').show();
        $( '#ChequeError' ).html( '');
        
    });

    $('.ClickCheque' ).on( 'click', function() {

        $('#ValidateChequePayout').show();
        $('#MakeChequePayout').hide();

    })

});