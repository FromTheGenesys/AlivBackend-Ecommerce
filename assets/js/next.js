
$( document ).ready( function() {   

    $( '.searchtrigger').on( 'submit', function(){
 
        $( '.showLoader').slideToggle();
        $( '.showData').slideToggle();

    });

    $( '.addtrigger').on( 'submit', function(){
 
        $( '.showAdding').slideToggle();
        $( '.showData').slideToggle();

    });

});