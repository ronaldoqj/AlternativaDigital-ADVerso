//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{
    /*
    var instance = M.Carousel.init({
        fullWidth: true,
        indicators: true
    });
    */
    // Or with jQuery


    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: true,
        noWrap: false
    });

    $('.control-left').click(function(){
        $('.carousel').carousel('prev');
    });

    $('.control-right').click(function(){
        $('.carousel').carousel('next');
    });

    /* Chama a função filtros que está no font init.js */
    owlFiltros();

    $("#owl-colunistas-destaques").owlCarousel({
        //autoPlay : 4000,
        items : 4,
        itemsDesktop : [2300,3],
        itemsDesktopSmall : [1500,2],
        itemsTablet: [501,2], //2 items between 600 and 0
        itemsMobile : [500,1] // itemsMobile disabled - inherit from itemsTablet option
    });
//515
});
