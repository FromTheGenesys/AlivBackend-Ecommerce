// function addJQuery()
// {
// 	var head = document.getElementsByTagName( 'head' )[0];
// 	var scriptjQuery = document.createElement( 'script' );
// 	scriptjQuery.type = 'text/javascript';
// 	scriptjQuery.id = 'jQuery'
// 	scriptjQuery.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
// 	var script = document.getElementsByTagName( 'script' )[0];
// 	head.insertBefore(scriptjQuery, script);
// }

$( document ).ready( function() {   

    $( '.selectSheet' ).on( 'click', function() {

        var CheckedBoxes        =       0;

        $( '.selectSheet' ).each( function( index, field ) {

           if ( field.checked === true ) {

                CheckedBoxes++;

           } else {

                CheckedBoxes--;

           }

        });

        if ( CheckedBoxes > 0 ) {

            $( '#DisplayButton' ).show();

        } else {

            $( '#DisplayButton' ).hide();

        }

    });

    $( '#DTLocation' ).on( 'change', function() {

        /** update details */                
        $.post( '../../scripts/DropZoneDueToCSRs.php',
        { 
            locationID:  $( '#DTLocation' ).val(),
            csrID: $( '#CSRID' ).val()
        },
        function( data ) {

            // alert( 'Data: ' + data );
            $( '#DueToCSR' ).html( data );

        });

        if ( $( '#DTLocation' ).val() !== '*' ) {

            $( '#DueToLedgerDetails' ).show();

        } else{

            $( '#DueToLedgerDetails' ).hide();

        }

    });

    $( '#DTCSR' ).on( 'change', function() {

      
    });

    $( '#DueToAmount' ).on( 'blur', function() {

        var Amount  =    $( '#DueToAmount' ).val();
        console.log( Amount );
        
        if ( Amount !== 0 ) {

            $( '#DisplayDTButton' ).show();

        } else {

            $( '#DisplayDTButton' ).hide();

        }

    });


    $( '#DFLocation' ).on( 'change', function() {

        /** update details */                
        $.post( '../../scripts/DropZoneDueToCSRs.php',
        { 
            locationID:  $( '#DFLocation' ).val(),
            csrID: $( '#CSRID' ).val()
        },
        function( data ) {

            // alert( 'Data: ' + data );
            $( '#DueFromCSR' ).html( data );

        });

        if ( $( '#DFLocation' ).val() !== '*' ) {

            $( '#DueFromLedgerDetails' ).show();

        } else{

            $( '#DueFromLedgerDetails' ).hide();

        }

    });

    $( '#DFCSR' ).on( 'change', function() {

      
    });

    $( '#DueFromAmount' ).on( 'blur', function() {

        var Amount  =    $( '#DueFromAmount' ).val();
        
        
        if ( Amount !== 0 ) {

            $( '#DisplayDFButton' ).show();

        } else {

            $( '#DisplayDFButton' ).hide();

        }

    });

});