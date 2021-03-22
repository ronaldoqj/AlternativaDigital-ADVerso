//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{
    $('#menos').click(function(){
        var rel = $(this).attr('rel');
        aumentaDiminui('diminui', rel);
    });

    $('#mais').click(function(){
        var rel = $(this).attr('rel');
        aumentaDiminui('aumenta', rel);
    });

    $("#owl-home-galeria").owlCarousel({
        //autoPlay : 4000,
        items : 2,
        itemsDesktop : [1200,2],
        itemsDesktopSmall : [979,1],
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });

});

function aumentaDiminui (aumentaDiminui, classe)
{
    var valor = 1;
    var obj = $('.' + classe).css('font-size');

    if(aumentaDiminui == 'aumenta') {
        $('.' + classe).css('font-size', parseFloat(obj) + valor );
    }
    if(aumentaDiminui == 'diminui') {
        $('.' + classe).css('font-size', parseFloat(obj) - valor );
    }
}
