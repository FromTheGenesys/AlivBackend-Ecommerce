
(function(){
    
    $( '.BSDA' ).blur( function() {

        var IterateTotal    =           0;        
        var Factor          =           [ 100, 50, 20, 10, 5, 1, .25, .1, .05 ];

        $( '.BSDA' ).each( function( index, value ) {

            if ( this.length == 0 ) {

                var FormEntry   =   0;

            } else{

                var FormEntry   =   this.value;
            
            }

            IterateTotal    =   ( IterateTotal + FormEntry * Factor[ index ] );

            $( '.TotalLineA').eq( index ).val( FormEntry * Factor[ index ]  );

        });

        $( '#TotalBSDA' ).val( Number( IterateTotal ).toFixed(2 ) );        
        $( '#CashTotalA' ).val( Number( $( '#TotalBSDA' ).val() ).toFixed(2)   );

       

        

    });

    $( '#ValidateCashNowButton').on( 'click', function() {

            var PayoutAmount            =   Number(  $( '#CNPaymentAmount').val() );
            var DenomAmount            =  Number( $( '#CashTotalA').val() );

            if( $.isNumeric( DenomAmount )  == false ) {

                $( '#cn_error').html('<div class="alert alert-danger border-danger mt-2">Not numeric</div>');
                $( '#DisplayCashNowButton' ).hide();
                $( '#ValidateCashNowButton' ).show();

            }  else {

                    if ( PayoutAmount !== DenomAmount ) {

                        $( '#cn_error').html('<div class="alert alert-danger border-danger mt-2">Not match</div>');
                        $( '#DisplayCashNowButton' ).hide();
                        $( '#ValidateCashNowButton' ).show();

                    } else {

                        $( '#cn_error').html('');
                        $( '#DisplayCashNowButton' ).show();
                        $( '#ValidateCashNowButton' ).hide();

                    }

            }

    });


    $( '.Coin' ).blur( function() {2

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

                $( '#errora' ).html('');
                $( '#DisplayCoinButton' ).show();

            }

        }

    });
})()