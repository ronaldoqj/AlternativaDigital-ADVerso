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

    $("#owl-home-destaques").owlCarousel({
        //autoPlay : 4000,
        items : 3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,2],
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });
    
    $("#owl-home-colunistas").owlCarousel({
        //autoPlay : 4000,
        items : 2,
        itemsDesktop : [1200,1],
        itemsDesktopSmall : [979,1],
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });

    $("#owl-home-galeria").owlCarousel({
        //autoPlay : 4000,
        items : 2,
        itemsDesktop : [1200,2],
        itemsDesktopSmall : [979,1],
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });
    
    $("#owl-home-videos").owlCarousel({
        //autoPlay : 4000,
        items : 3,
        itemsDesktop : [1200,2],
        itemsDesktopSmall : [979,2],
        itemsTablet: [720,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });

});
