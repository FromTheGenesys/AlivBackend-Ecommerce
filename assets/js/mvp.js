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

function roundCash( CashAmount ) {

    console.log( CashAmount );
    return CashAmount;

}

$( document ).ready( function() {   

    $('#phone').mask('(999) 999-9999');           
    $('.phone').mask('(999) 999-9999');           
    $('.Expire').mask('99/99');           
    $('.CardNumber').mask('9999-9999-9999-9999');   

    // 
    $( '#BillerID' ).on( 'change', function() {

        var BillerID        =       $( '#BillerID' ).val();

        if ( ( BillerID == 'BTC') || ( BillerID == 'CBL') ) {

            $( '#MVPLocation' ).hide();

            if ( BillerID == 'CBL' ) {

                $( '#CBLMessage').html( '<div class="alert bg-warning text-dark border-warning">Please Note that Cable Bahamas transaction require a direct connection. The amount of time required to return results depends on network speeds. </div>' );

            } else {

                $( '#CBLMessage').html( '' );

            }
            
            
        } else {

            $( '#CBLMessage').html( '' );
            $( '#MVPLocation' ).show();

        }

        

    });

    // show hide order details
    $( '#showHide' ).on( 'click', function() {

        $( '#FullOrder' ).slideToggle('1000');

    }); 
    
    // validate numbers
    $( '#PaymentOne').blur( function(){

        var PaymentAmount       =       $( '#PaymentOne' ).val();
        
        if ( $.isNumeric( PaymentAmount ) === false ) {

            $( '#error').html( '<div class="alert alert-danger border-danger">Payment Amount values specified must be numeric. </div>' );

        } 

    });

    // validate numbers
    $( '#PaymentTwo').blur( function(){

        var PaymentAmount       =       $( '#PaymentTwo' ).val();
        
        if ( $.isNumeric( PaymentAmount ) === false ) {

            $( '#error').html( '<div class="alert alert-danger border-danger">Payment Confirmation Amount values specified must be numeric. </div>' );

        } 

    });

    // payment method
    $( '#PaymentMethod').change( function(){

        var PaymentMethod       =   $( '#PaymentMethod' ).val();
        var OrderTotal          =   $( '#OrderTotal' ).val();
        var RoundedTotal        =   $( '#RoundedTotal' ).val();

        if ( PaymentMethod == '1' ) {

            $( '.cheque').hide();
            $( '.cash').show();
            $( '#DisplayRounding' ).text( RoundedTotal );
          
        } else {

            $( '#DisplayRounding' ).text( OrderTotal );
            $( '.cheque').show();
            $( '.cash').hide();

        }

        $( '#error').html( '' );
        $( '#makePayment').hide()
        $( '#validatePayment').show();

    });

    // tender amount
    $( '#validatePayment').click( function(){

        var PaymentMethod           =   $( '#PaymentMethod').val();

        if ( PaymentMethod == 1 ) {

            var PaymentAmount    =   $( '#BillPayTotal' ).val();        
            var PaymentGiven     =   $( '#BillPayAmount' ).val();

            if ( Number( PaymentAmount ) > Number( PaymentGiven ) ) {

                $( '#error').html( '<div class="alert alert-danger mt-2 border-danger">Please ensure that the Cash given is sufficient to cover the total due.</div>' );
                $( '#makePayment').hide();
                $( '#validatePayment').show();

            } else {

                if ( $.isNumeric( PaymentGiven ) == false ) {

                    $( '#error').html( '<div class="alert mt-2 alert-danger border-danger">All values specified must be numeric. </div>' );
                    $( '#makePayment').hide();
                    $( '#validatePayment').show();

                } else {

                    $( '#error').html( '' );
                    $( '#makePayment').show();
                    $( '#validatePayment').hide();

                }

            }
            
        } else {

            var TotalDue            =   $( '#BillPayTotal' ).val();
            var ChequeAmount        =   $( '#ChequeAmount' ).val();
            var DateParts           =   $( '#ChequeDate' ).val().split( '-' );
            var ChequeDate          =   new Date( DateParts[0], DateParts[1] - 1, DateParts[2], 0, 0, 0 ); 
            var CurrentDate         =   new Date();
            var DateDifference      =   new Date( ChequeDate - CurrentDate );

            var Days                =   DateDifference / 1000 / 60 / 60 / 24;

            var ChequeName          =   $( '#ChequeName' ).val();
            var ChequeNumber        =   $( '#ChequeNumber' ).val();

            
            if ( TotalDue != parseFloat( ChequeAmount ).toFixed(2) ) {

                $( '#error').html( '<div class="alert alert-danger border-danger">Please ensure that the Total Due and the Cheque Amount are equivalent.</div>' );
                $( '#makePayment').hide();

            } else {

                $( '#error').html( '' );

                if ( $.isNumeric( ChequeAmount ) === false ) {

                    $( '#error').html( '<div class="alert alert-danger border-danger">All values specified must be numeric. </div>' );
                    $( '#makePayment').hide();
                    $( '#ChequeAmount' ).focus();

                } else {
                    
                    if ( $.isNumeric( ChequeNumber ) === false ) {

                        $( '#error').html( '<div class="alert alert-danger border-danger"> Cheque Number must be a numeric value. </div>' );
                        $( '#makePayment').hide();
                        $( '#ChequeNumber' ).focus();

                    } else {

                        if ( $.isNumeric( ChequeName ) === true ) {

                            $( '#error').html( '<div class="alert alert-danger border-danger"> Cheque Name contain a value. </div>' );
                            $( '#makePayment').hide();
                            $( '#ChequeName' ).focus();

                        } else {

                            // check the date
                            if ( Days >= 0 ) {

                                $( '#error').html( '<div class="alert alert-danger border-danger"> The Cheque Date cannot be post dated. </div>' );
                                $( '#ChequeDate' ).focus();
                                $( '#makePayment').hide();

                            } else {

                                $( '#error').html( '' );
                                $( '#makePayment').show();
                                $( '#validatePayment').hide();

                            }
                            
                        }

                    }

                }
                    
            }

        }

    });


    // if a value is changed after the fact
    $( '#ChequeDate' ).click( function() {

        var ChequeName      =   $( '#ChequeName' ).val();
        var ChequeNumber    =   $( '#ChequeNumber' ).val();
        var ChequeAmount    =   $( '#ChequeAmount' ).val();

        if ( ChequeName != null ) {

            if ( ChequeNumber != null ) {

                if ( ChequeAmount != null ) {

                    // $( '#ChequeAmount' ).focus();
                    $( '#makePayment').hide();
                    $( '#validatePayment').show();

                }

            }

        }

    });

    $( '#ChequeName' ).click( function() {

        var ChequeNumber    =   $( '#ChequeNumber' ).val();
        var ChequeDate      =   $( '#ChequeDate' ).val();
        var ChequeAmount    =   $( '#ChequeAmount' ).val();

        if ( ChequeNumber != null ) {

            if ( ChequeDate != null ) {

                if ( ChequeAmount != null ) {

                    $( '#makePayment').hide();
                    $( '#validatePayment').show();

                }

            }

        }

    });

    $( '#ChequeAmount' ).click( function() {

        var ChequeNumber    =   $( '#ChequeNumber' ).val();
        var ChequeDate      =   $( '#ChequeDate' ).val();
        var ChequeName      =   $( '#ChequeName' ).val();

        if ( ChequeNumber != null ) {

            if ( ChequeDate != null ) {

                if ( ChequeName != null ) {

                    $( '#makePayment').hide();
                    $( '#validatePayment').show();

                }

            }

        }

    });

    $( '#ChequeNumber' ).click( function() {

        var ChequeName      =   $( '#ChequeName' ).val();
        var ChequeDate      =   $( '#ChequeDate' ).val();
        var ChequeAmount    =   $( '#ChequeAmount' ).val();

        if ( ChequeName != null ) {

            if ( ChequeDate != null ) {

                if ( ChequeAmount != null ) {

                    $( '#makePayment').hide();
                    $( '#validatePayment').show();

                }

            }

        }

    });

    // tender amount
    $( '#Tender').blur( function(){

        var PaymentAmountOne    =   $( '#PaymentOne' ).val();
        var PaymentAmountTwo    =   $( '#PaymentTwo' ).val();
        var PaymentGiven        =   $( '#Tender' ).val();

        if ( PaymentAmountOne != PaymentAmountTwo ) {

            $( '#error').html( '<div class="alert alert-danger border-danger">Please ensure that both payment amounts contain matching values</div>' );

        } else {

            if ( PaymentAmountOne > PaymentGiven ) {

                $( '#error').html( '<div class="alert alert-danger border-danger">The cash amount given does not cover the payment amount specified. </div>' );

            } else {

                $( '#error').html( '' );

                if ( $.isNumeric( PaymentAmountOne ) === false ) {

                    $( '#error').html( '<div class="alert alert-danger border-danger">All values specified must be numeric. </div>' );

                } else {
                    
                    $( '#makePayment').show();

                }
                
            }

        }

    });

    // tender amount
    $( '#BillPayAmount').click( function(){

        $( '#validatePayment').show();
        $( '#makePayment').hide();

    });

    $( "#confirmDelete" ).click( function(){

        $( '#TrashButton' ).toggle();

    });

    // insurance scripts
    $( ".insselector" ).click( function() {

        var selected        =   $( 'input[type="checkbox"]:checked' ).length;
        var notQualified    =    0;
        $( 'input[type="checkbox"]:checked' ).each( function( index, value ) {

            var position        =    this.value.split( '_')[1];            
            if ( Number( $( '.PaymentLine').eq( position ).val() ) <= 0 ) {

                // console.log( $( '.PaymentLine').eq( position ).val() );
                // $( '#error').html( '<div class="alert bg-danger border-danger">You have selected a payment amount that IS NOT greater than $0.00. Please <strong>UNSELECT</strong> the customer record and then INCREASE the payment amount, then <strong>RESELECT</strong> the customer to continue.</div>' );
                notQualified++;

            } 

        });

        if ( notQualified > 0 ) {

            $( '#error').html( '<div class="alert bg-danger border-danger">You have selected a payment amount that IS NOT greater than $0.00. Please <strong>UNSELECT</strong> the customer record and then INCREASE the payment amount, then <strong>RESELECT</strong> the customer to continue.</div>' );

            $( "#AddToCart" ).hide();
            $( "#AddViewCart" ).hide();
            
        } else {

            $( '#error').html( '' );

            if ( selected > 0 ) {

                $( "#AddToCart" ).show();
                $( "#AddViewCart" ).show();
                
            } else {
    
                $( "#AddToCart" ).hide();
                $( "#AddViewCart" ).hide();
    
            }

        }

        // if ( selected > 0 ) {

        //     $( "#AddToCart" ).show();
        //     $( "#AddViewCart" ).show();
            
        // } else {

        //     $( "#AddToCart" ).hide();
        //     $( "#AddViewCart" ).hide();

        // }

    });

    $( '#PayMethod' ).change( function() {

        var PayMethod   =   $( "#PayMethod" ).val();

        var CashTable   =   '<table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm">' +
                             '<thead class="thead-light font-weight-normal">' +
                              '<tr>' +                
                                 '<th class="text-center" colspan="2">CASH OPTIONS</th>' +                                                                                                                                                                                
                                '</tr>' +
                             '</thead>' +
                              '<tbody>' +
                                '<tr>' +
                                  '<input type="hidden" value="1" name="Method" id="Method" />' +
                                  '<td>Amount:</td><td align="right"><input class="form-control text-right" name="PaymentAmount" id="PaymentCash" required="" autocomplete="off" autofocus style="width: 140px;" /></td>' +                                 
                                '</tr>' +
                             '</tbody>' +
                            '</table>' +

                            '<div class="text-right">' +
                                '<button class="btn-lg mt-3 font-sm btn-success" name="btnPaymentCash"><i class="fa fa-check"></i> Make Payment </button>' +
                            '</div>';


        var CheckTable =   '<table class="table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm">' +
                             '<thead class="thead-light font-weight-normal">' +
                              '<tr>' +                
                                 '<th class="text-center" colspan="2">CHEQUE OPTIONS</th>' +                                                                                                                                                                                
                                '</tr>' +
                             '</thead>' +
                              '<tbody>' +
                                '<tr>' +                                  
                                  '<td>Cheque No:</td><td align="right"><input class="form-control text-right" name="ChequeNo" style="width: 140px;" /></td>' +
                                 '</tr>' +
                                '</tr>' +
                                '<tr>' +                                  
                                  '<td>Cheque Date:</td><td align="right"><input type="date" class="form-control text-right" name="ChequeDate" style="width: 140px;" /></td>' +
                                 '</tr>' +
                                '</tr>' +
                                '<tr>' +
                                  '<input type="hidden" value="2" name="Method" id="Method" />' +
                                  '<td>Amount:</td><td align="right"><input class="form-control text-right" name="PaymentAmount" id="PaymentAmount" autofocus style="width: 140px;" /></td>' +
                                 '</tr>' +
                                '</tr>' +
                             '</tbody>' +
                            '</table>';                            

        if ( PayMethod == 'Cash' ) { 

            $( '#PaymentMethod' ).html( CashTable );

        } else {

            $( '#PaymentMethod' ).html( CheckTable );
            
        }

    });


    $( '#PaymentCash').blur( function(){  

        var Method          =   $( '#Method' ).val();
        var TotalAmount     =   $( '#TotalAmount' ).val();
        var PaymentAmount   =   $( '#PaymentAmount' ).val();

        $( '#output').html( Method );

        if ( Method == 1 ) {

          //  if ( PaymentAmount > TotalAmount ) {

               // $( '#error' ).text( 'Hi' );
                //$( '#error').html( '<div class="alert alert-danger border-danger">The cash amount given does not cover the payment amount specified. </div>' );

//            }

        }

    });

    $( '#MakeSelection' ).change( function() {

        var SeniorCSR   =   $( '#MakeSelection' ).val();

        if ( SeniorCSR != '*' ) {

            $( '#DisplayButton' ).show();

        } else {

            $( '#DisplayButton' ).hide();

        }

    });

    $( '.BSD' ).blur( function() {

        var IterateTotal    =           0;        
        var Factor          =           [ 100, 50, 20, 10, 5, 1 ];

        $( '.BSD' ).each( function( index, value ) {

            if ( this.length == 0 ) {

                var FormEntry   =   0;

            } else{

                var FormEntry   =   this.value;
            
            }

            IterateTotal    =   ( IterateTotal + ( FormEntry * Factor[ index ] ) );

            $( '.TotalLine').eq( index ).val( FormEntry * Factor[ index ] + ( Number( $( '.USD' ).eq( index ).val() ) * Factor[ index ] ) );

        });

        $( '#TotalBSD' ).val( Number( IterateTotal ) );        
        $( '#CashTotal' ).val( Number( Number( $( '#TotalBSD' ).val() ) + Number( $( '#TotalUSD' ).val() ) ) );

        if ( Number( $( '#CashTotal' ).val() ) == 0 ) {

            $( '#DisplayCashButton' ).hide();
            $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The total value of your Drop Sheet must be at least $1.00.</div>');

        } else{

            if ( $.isNumeric( $( '#CashTotal' ).val() ) == false ) {

                $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The Drop Sheet must contain only numeric values. Please check your Drop Sheet then try again.</div>');
                $( '#DisplayCashButton' ).hide();

            } else {

                $( '#error' ).html('');
                $( '#DisplayCashButton' ).show();

            }

        }

    });


    $( '.SBSD' ).blur( function() {

        var IterateTotal    =           0;        
        var Factor          =           [ 100, 50, 20, 10, 5, 1 ];

        $( '.SBSD' ).each( function( index, value ) {

            if ( this.length == 0 ) {

                var FormEntry   =   0;

            } else{

                var FormEntry   =   this.value;
            
            }

            IterateTotal    =   ( IterateTotal +  FormEntry * Factor[ index ] );

            $( '.STotalLine').eq( index ).val( FormEntry * Factor[ index ] + ( Number( $( '.SUSD' ).eq( index ).val() ) * Factor[ index ] ) );

        });

        $( '#STotalBSD' ).val( Number( IterateTotal ) );        
        $( '#SCashTotal' ).val( Number( Number( $( '#STotalBSD' ).val() ) + Number( $( '#STotalUSD' ).val() ) ) );

        if ( Number( $( '#SCashTotal' ).val() ) == 0 ) {

            $( '#DisplayCashButton' ).hide();
            $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The total value of your Drop Sheet must be at least $1.00.</div>');

        } else{

            if ( $.isNumeric( $( '#SCashTotal' ).val() ) == false ) {

                $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The Drop Sheet must contain only numeric values. Please check your Drop Sheet then try again.</div>');
                $( '#DisplayCashButton' ).hide();

            } else {

                $( '#error' ).html('');
                $( '#DisplayCashButton' ).show();

            }

        }

    });

    $( '.USD' ).blur( function() {

        var IterateTotal    =           0;        
        var Factor          =           [ 100, 50, 20, 10, 5, 1 ];

        $( '.USD' ).each( function( index, value ) {

            if ( this.length == 0 ) {

                var FormEntry   =   0;

            } else{

                var FormEntry   =   this.value;
            
            }

            IterateTotal    =   ( IterateTotal + FormEntry * Factor[ index ] );

            $( '.TotalLine').eq( index ).val( FormEntry * Factor[ index ] + ( Number( $( '.BSD' ).eq( index ).val() ) * Factor[ index ] ) );

        });

        $( '#TotalUSD' ).val( Number( IterateTotal ) );                
        $( '#CashTotal' ).val( Number( Number( $( '#TotalBSD' ).val() ) + Number( $( '#TotalUSD' ).val() ) ) );

        if ( Number( $( '#CashTotal' ).val() ) == 0 ) {

            $( '#DisplayCashButton' ).hide();
            $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The total value of your Drop Sheet must be at least $1.00.</div>');

        } else{

            if ( $.isNumeric( $( '#CashTotal' ).val() ) == false ) {

                $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The Drop Sheet must contain only numeric values. Please check your Drop Sheet then try again.</div>');
                $( '#DisplayCashButton' ).hide();

            } else {

                $( '#error' ).html('');
                $( '#DisplayCashButton' ).show();

            }

        }

    });

    $( '.SUSD' ).blur( function() {

        var IterateTotal    =           0;        
        var Factor          =           [ 100, 50, 20, 10, 5, 1 ];

        $( '.SUSD' ).each( function( index, value ) {

            if ( this.length == 0 ) {

                var FormEntry   =   0;

            } else{

                var FormEntry   =   this.value;
            
            }

            IterateTotal    =   ( IterateTotal + FormEntry * Factor[ index ] );

            $( '.STotalLine').eq( index ).val( FormEntry * Factor[ index ] + ( Number( $( '.SBSD' ).eq( index ).val() ) * Factor[ index ] ) );

        });

        $( '#STotalUSD' ).val( Number( IterateTotal ) );                
        $( '#SCashTotal' ).val( Number( Number( $( '#STotalBSD' ).val() ) + Number( $( '#STotalUSD' ).val() ) ) );

        if ( Number( $( '#SCashTotal' ).val() ) == 0 ) {

            $( '#DisplayCashButton' ).hide();
            $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The total value of your Drop Sheet must be at least $1.00.</div>');

        } else{

            if ( $.isNumeric( $( '#SCashTotal' ).val() ) == false ) {

                $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The Drop Sheet must contain only numeric values. Please check your Drop Sheet then try again.</div>');
                $( '#DisplayCashButton' ).hide();

            } else {

                $( '#error' ).html('');
                $( '#DisplayCashButton' ).show();

            }

        }

    });

    $( '.Coin' ).blur( function() {

        var IterateTotal    =           0;        
        var Factor          =           [ .25, .1, .05, .01 ];

        $( '.Coin' ).each( function( index, value ) {

            if ( this.length == 0 ) {

                var FormEntry   =   0;

            } else{

                var FormEntry   =   this.value;
            
            }

            IterateTotal    =   ( IterateTotal + FormEntry * Factor[ index ] );
            var CoinLine    =   FormEntry * Factor[ index ];
            $( '.CoinLine').eq( index ).val( CoinLine.toFixed(2) );

        });

        $( '#TotalCoins' ).val( Number( IterateTotal ).toFixed(2) );                
        

        if ( Number( $( '#TotalCoins' ).val() ) == 0 ) {

            $( '#DisplayCoinButton' ).hide();
            $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The total value of your Drop Sheet must be at least $1.00.</div>');

        } else{

            if ( $.isNumeric( $( '#TotalCoins' ).val() ) == false ) {

                $( '#error' ).html( '<div class="alert mt-2 alert-danger border-danger">The Drop Sheet must contain only numeric values. Please check your Drop Sheet then try again.</div>');
                $( '#DisplayCoinButton' ).hide();

            } else {

                $( '#error' ).html('');
                $( '#DisplayCoinButton' ).show();

            }

        }

    });

    $( '#AddCheque').click( function() {

        var CheckCount      =       $( '#CheckCount').val();        
        CheckCount = ( Number( CheckCount ) + 1 );
        
        if ( CheckCount > 1 ) {

            $( '#RemoveCheque' ).show();

        } else {

            $( '#RemoveCheque' ).hide();

        }

        $( '#CheckCount').val( CheckCount );

        $( '#DisplayChequeButton' ).hide();

        var ChequeTable     =   '<table class="mt-3 table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm ChequeTable">' +
                                    '<thead class="thead-dark font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th colspan="3">New Cheque Details</th>' +                                                                                                                            
                                        '</tr>' +
                                    '</thead>' +
                                    '<thead class="thead-light font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th>Cheque No.</th>' +                                                                                
                                            '<th>Name</th>' +                                                
                                            '<th class="text-right">Amount</th>' +                                                                                                                                                                
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                        '<tr>' +
                                            '<td class="text-left">' +    
                                                '<div>' +                                                    
                                                    '<input type="text" class="form-control form-control-lg font-lg dzChequeNo" style="width: 100px;" name="ChequeNumber[]" required autocomplete="off" />' +
                                                '</div>' +
                                            '</td>' +
                                            '<td>' +
                                                '<div>' +
                                                    '<input type="text" class="form-control form-control-lg font-lg dzChequeName" name="ChequeName[]" required autocomplete="off" />' +
                                                '</div>' +                                                                    
                                            '</td>' +

                                            '<td align="right">' +
                                                '<div>' +
                                                    '<input type="text" class="form-control form-control-lg font-lg dzChequeAmount" style="width: 100px;" name="ChequeAmount[]" required autocomplete="off" />' +
                                                '</div>' +                    
                                            '</td>' +
                                                                        
                                        '</tr>' +
                                    '</tbody>' +
                                    '<thead class="thead-light font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th colspan="3">Cheque Bank</th>' +                                                                                                                    
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                        '<tr>' +
                                            '<td class="text-left" colspan="3">' +    
                                                '<div>' +                                                    
                                                    '<select class="custom-select form-control form-control-lg" name="ChequeBank[]" autocomplete="off">' +
                                                        '<option value="1">Bank To The Bahamas</option>' +
                                                        '<option value="2">CIBC / First Caribbean</option>' +
                                                        '<option value="3">Commonwealth Bank</option>' +
                                                        '<option value="4">Fidelity Bank</option>' +
                                                        '<option value="5">Royal Bank</option>' +
                                                        '<option value="6">Scotia Bank</option>' +
                                                    '</select>' +
                                                '</div>' +
                                            '</td>' +                                                                 
                                        '</tr>' +
                                    '</tbody>' +
                                    '<thead class="thead-light font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th colspan="3">Notes</th>' +                                                                                                                    
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                        '<tr>' +
                                            '<td class="text-left" colspan="3">' +    
                                                '<div>' +                                                    
                                                    '<textarea class="form-control form-control-lg font-lg" name="ChequeNotes[]"></textarea>' +
                                                '</div>' +
                                            '</td>' +                                                                 
                                        '</tr>' +
                                    '</tbody>' +

                                '</table>';

            $( '#ChequeContainer' ).append( ChequeTable );  
            
            $( '.dzChequeNo' ).eq( Number( $( '.dzChequeNo' ).length ) - 1 ).focus();

    });

    $( '#RemoveCheque' ).click( function() {

        var CheckCount      =       $( '#CheckCount').val();
        CheckCount      =   ( CheckCount - 1 );
        
        if ( CheckCount > 1 ) {

            $( '#RemoveCheque' ).show();

        } else {

            $( '#RemoveCheque' ).hide();

        }

        var setIndex    =   Number( $( '.ChequeTable').length ) - 1;
        $( '.ChequeTable' ).eq( setIndex ).remove();
        $( '.dzChequeNo' ).eq( Number( $( '.dzChequeNo' ).length ) - 1 ).focus();
        $( '#CheckCount').val( CheckCount );

    }); 


    $( '.dzChequeAmount').blur( function() {

        var FailNoCheck     =   0;
        var FailNameCheck   =   0;
        var FailAmtCheck    =   0;
        var FailCheck       =   0;

        $( '.dzChequeAmount' ).each( function( index, value ) {

            // check to ensure that name has a value
            if ( $( '.dzChequeNo' ).eq( index ).val() == '' ) {

                FailNoCheck     =   ( FailNoCheck + 1 );
                FailCheck++;
                
            }

            // check to ensure that name has a value
            if ( $( '.dzChequeName' ).eq( index ).val() == '' ) {

                FailNameCheck   =   ( FailNameCheck + 1 );
                FailCheck++;
                
            }

            // check to ensure that name has a value
            if ( $( '.dzChequeAmount' ).eq( index ).val() == '' ) {

                FailAmtCheck    =   ( FailAmtCheck + 1 );
                FailCheck++;
                
            }

            // check to ensure that the number is numeric
            if ( $.isNumeric( $( '.dzChequeNo' ).eq( index ).val() ) == false ) {

                FailNoCheck     =   ( FailNoCheck + 1 );
                FailCheck++;
                
            }

            // check to ensure that the number is numeric
            if ( $.isNumeric( $( '.dzChequeAmount' ).eq( index ).val() ) == false ) {

                FailAmtCheck    =   ( FailAmtCheck + 1 );
                FailCheck++;
                
            }

            if ( FailCheck > 0 ) {

                // console.log( '<div class="alert alert-secondary border-secondary mt-3">There is an error in the Entry of one of your Cheque Detail. Please Cheque the Details and then try again.</div>' );
                
                $( '#chequeError' ).html( '<div class="alert alert-danger border-danger mt-3">There is an error in the Entry of one of your Cheque Detail. <strong>Some fields contain the incorrect values or no values at all</strong>. Please Cheque the Details and then try again.</div>' );
                $( '#DisplayChequeButton' ).hide();
                FailCheck = 0;
                FailAmtCheck = 0;
                FailNoCheck = 0;
                FailNameCheck = 0;
                
            } else {

                $( '#chequeError' ).html( '' );
                $( '#DisplayChequeButton' ).show();                
                
            }

            console.log( FailCheck );

        });

    })

    $( '#AddCard').click( function() {

        var CardCount      =       $( '#CardCount').val();        
        CardCount = ( Number( CardCount ) + 1 );
        
        if ( CardCount > 1 ) {

            $( '#RemoveCard' ).show();

        } else {

            $( '#RemoveCard' ).hide();

        }

        $( '#CardCount').val( CardCount );

        $( '#DisplayCardButton' ).hide();

        var CardTable     =   '<table class="mt-3 table table-responsive-sm table-hover table-striped table-outline mb-0 font-sm ChequeTable">' +
                                    '<thead class="thead-dark font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th colspan="3">New Credit Card Details</th>' +                                                                                                                            
                                        '</tr>' +
                                    '</thead>' +
                                    '<thead class="thead-light font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th>Cheque No.</th>' +                                                                                
                                            '<th>Name</th>' +                                                
                                            '<th class="text-right">Amount</th>' +                                                                                                                                                                
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                        '<tr>' +
                                            '<td class="text-left">' +    
                                                '<div>' +                                                    
                                                    '<input type="text" class="form-control form-control-lg font-lg dzChequeNo" style="width: 100px;" name="ChequeNumber[]" required autocomplete="off" />' +
                                                '</div>' +
                                            '</td>' +
                                            '<td>' +
                                                '<div>' +
                                                    '<input type="text" class="form-control form-control-lg font-lg dzChequeName" name="ChequeName[]" required autocomplete="off" />' +
                                                '</div>' +                                                                    
                                            '</td>' +

                                            '<td align="right">' +
                                                '<div>' +
                                                    '<input type="text" class="form-control form-control-lg font-lg dzChequeAmount" style="width: 100px;" name="ChequeAmount[]" required autocomplete="off" />' +
                                                '</div>' +                    
                                            '</td>' +
                                                                        
                                        '</tr>' +
                                    '</tbody>' +
                                    '<thead class="thead-light font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th colspan="3">Type</th>' +                                                                                                                    
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                        '<tr>' +
                                            '<td class="text-left" colspan="3">' +    
                                                '<div>' +                                                    
                                                    '<select class="custom-select form-control form-control-lg" name="ChequeBank[]" autocomplete="off">' +
                                                        '<option value="1">Bank To The Bahamas</option>' +
                                                        '<option value="2">CIBC / First Caribbean</option>' +
                                                        '<option value="3">Commonwealth Bank</option>' +
                                                        '<option value="4">Fidelity Bank</option>' +
                                                        '<option value="5">Royal Bank</option>' +
                                                        '<option value="6">Scotia Bank</option>' +
                                                    '</select>' +
                                                '</div>' +
                                            '</td>' +                                                                 
                                        '</tr>' +
                                    '</tbody>' +
                                    '<thead class="thead-light font-weight-normal">' +
                                        '<tr>' +                  
                                            '<th colspan="3">Notes</th>' +                                                                                                                    
                                        '</tr>' +
                                    '</thead>' +
                                    '<tbody>' +
                                        '<tr>' +
                                            '<td class="text-left" colspan="3">' +    
                                                '<div>' +                                                    
                                                    '<textarea class="form-control form-control-lg font-lg" name="ChequeNotes[]"></textarea>' +
                                                '</div>' +
                                            '</td>' +                                                                 
                                        '</tr>' +
                                    '</tbody>' +

                                '</table>';

            $( '#CardContainer' ).append( CardTable );  
            
            $( '.dzChequeNo' ).eq( Number( $( '.dzChequeNo' ).length ) - 1 ).focus();

    });

    $( '#RemoveCard' ).click( function() {

        var CardCount      =       $( '#CardCount').val();
        CardCount      =   ( CardCount - 1 );
        
        if ( CardCount > 1 ) {

            $( '#RemoveCard' ).show();

        } else {

            $( '#RemoveCard' ).hide();

        }

        var setIndex    =   Number( $( '.CardTable').length ) - 1;
        $( '.CardTable' ).eq( setIndex ).remove();
        $( '.dzCardNo' ).eq( Number( $( '.dzCardNo' ).length ) - 1 ).focus();
        $( '#CardCount').val( CardCount );

    }); 

}); 