
$( document ).ready( function() {   

    

    $( '#ConfirmDelete' ).click( function(){

        $( '#HideDeleteButton' ).toggle();

    }); 

    $( '#captureAccountName').click( function(){

        var placeCheque         =       $( '#storeChequeName').val();
        $( '#placeChequeName' ).val( placeCheque );

    });

    $( '#startload').submit( function(){

        $( '#loaded').toggle();
        $( '#loading').toggle();

    });

    $( '.linkload').click( function() {

        $( '#loaded').toggle();
        $( '#linkloading').toggle();

    });

    number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }

    $('.counter').each(function() {
        var $this = $(this),
            countTo = $this.attr('data-count');
        
        $({ countNum: $this.text()}).animate({
          countNum: countTo
        },
      
        {
      
          duration: 2000,
          easing:'linear',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
          complete: function() {
            $this.text( number_format( this.countNum, 0, '.', ',' ) );
            //alert('finished');
          }
      
        });  
        
    });

    $('.counterP').each(function() {

        var $this = $(this),
            countTo = $this.attr('data-count');
        
        $({ countNum: $this.text()}).animate({
          countNum: countTo
        },
      
        {
      
          duration: 3500,
          easing:'linear',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
          complete: function() {
            $this.text( number_format( this.countNum, 2, '.', ',' ) );
            //alert('finished');
          }
      
        });  
        
        
      });


    // quick pay option cash given $50
    $( '#pa50').click( function() {

        $( '#PaymentAmount').val( '50.00' ); 

    });

    // quick pay option cash given $75
    $( '#pa75').click( function() {

        $( '#PaymentAmount').val( '75.00' ); 

    });

    // quick pay option cash given $100
    $( '#pa100').click( function() {

        $( '#PaymentAmount').val( '100.00' ); 

    });

    // quick pay option cash given $125
    $( '#pa125').click( function() {

        $( '#PaymentAmount').val( '125.00' ); 

    });

    // quick pay option cash given $150
    $( '#pa150').click( function() {

        $( '#PaymentAmount').val( '150.00' ); 

    });

    // quick pay option cash given $175
    $( '#pa175').click( function() {

        $( '#PaymentAmount').val( '175.00' ); 

    });

    // quick pay option payment amount $200
    $( '#pa200').click( function() {

        $( '#PaymentAmount').val( '200.00' ); 

    });

    // quick pay option cash given $50
    $( '#ct50').click( function() {

        $( '#CashGiven').val( '50.00' ); 

    });

    // quick pay option cash given $75
    $( '#ct75').click( function() {

        $( '#CashGiven').val( '75.00' ); 

    });

    // quick pay option cash given $100
    $( '#ct100').click( function() {

        $( '#CashGiven').val( '100.00' ); 

    });

    // quick pay option cash given $125
    $( '#ct125').click( function() {

        $( '#CashGiven').val( '125.00' ); 

    });

    // quick pay option cash given $150
    $( '#ct150').click( function() {

        $( '#CashGiven').val( '150.00' ); 

    });

    // quick pay option cash given $175
    $( '#ct175').click( function() {
        $( '#CashGiven').val( '175.00' ); 

    });

    // quick pay option cash given $200
    $( '#ct200').click( function() {

        $( '#CashGiven').val( '200.00' ); 

    });


    $( '#pb100' ).blur( function(){

        var pb100       =       $( '#pb100' ).val();
        var pt100       =       ( Number( pb100 ) * 100 );
        $( '#pt100' ).val( pt100.toFixed(2) );     
        $( '#TallyAllCash' ).val( tallyCashBreakdowns );    

    }); 

    $( '#pb50' ).blur( function(){

        var pb50        =       $( '#pb50' ).val();
        var pt50        =       ( Number( pb50 ) * 50 );
        $( '#pt50' ).val( pt50.toFixed(2) );            
        $( '#TallyAllCash' ).val( tallyCashBreakdowns );  

    }); 

    $( '#pb20' ).blur( function(){

        var pb20        =       $( '#pb20' ).val();
        var pt20        =       ( Number( pb20 ) * 20 );
        $( '#pt20' ).val( pt20.toFixed(2) );            
        $( '#TallyAllCash' ).val( tallyCashBreakdowns );  

    }); 

    $( '#pb10' ).blur( function(){

        var pb10        =       $( '#pb10' ).val();
        var pt10        =       ( Number( pb10 ) * 10 );
        $( '#pt10' ).val( pt10.toFixed(2) );            
        $( '#TallyAllCash' ).val( tallyCashBreakdowns );  

    }); 

    $( '#pb5' ).blur( function(){

        var pb5         =       $( '#pb5' ).val();
        var pt5         =       ( Number( pb5 ) * 5 );
        $( '#pt5' ).val( pt5.toFixed(2) );   
        $( '#TallyAllCash' ).val( tallyCashBreakdowns );           

    }); 

    $( '#pb1' ).blur( function(){

        var pb1         =       $( '#pb1' ).val();
        var pt1         =       ( Number( pb1 ) * 1 );
        $( '#pt1' ).val( pt1.toFixed(2) );   
        $( '#TallyAllCash' ).val( tallyCashBreakdowns );  

    }); 


    function tallyCashBreakdowns() {

        var pt100       =       $( '#pt100' ).val();
        var pt50        =       $( '#pt50' ).val();    
        var pt20        =       $( '#pt20' ).val();
        var pt10        =       $( '#pt10' ).val();
        var pt5         =       $( '#pt5' ).val();
        var pt1         =       $( '#pt1' ).val();    

        var tally       =       ( Number( pt100 ) + Number( pt50 ) + Number( pt20 ) + Number( pt10 ) + Number( pt5 ) + Number( pt1 ) );
        return tally.toFixed(2);    

    }


}); 