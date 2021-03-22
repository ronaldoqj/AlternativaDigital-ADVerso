var elem = document.querySelector('#modalVideos');
var options = {
  opacity: 0.9,
  onCloseEnd: closeModal
};
var register;
var instance = M.Modal.init(elem, options);

function closeModal(){
    $("#modalVideos .video-container").html('');
}


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

    $("#owl-agendas").owlCarousel({
        //autoPlay : 4000,
        items : 1,
        itemsDesktop : [1200,1],
        itemsDesktopSmall : [979,1],
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });

    $("#owl-home-colunistas").owlCarousel({
        autoPlay : 8000,
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
    $("#owl-home-adufrgs-no-ar").owlCarousel({
        //autoPlay : 4000,
        items : 6,
        itemsDesktop : [1200,5],
        itemsDesktopSmall : [979,4],
        itemsTablet: [720,3], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });


    /* MODAL Videos */
    $('.home-videos').click(function() {
        register = JSON.parse( $(this).attr('rel') );
        instance.open();
        $("#modalVideos .video-container").html(register.link);
    });

    $('#modalVideos').click(function(){
        instance.close();
    });

    /* MODAL Videos adufrgs no ar */
    $('.home-videos-adurgs-no-ar').click(function() {
        register = JSON.parse( $(this).attr('rel') );
        instance.open();
        $("#modalVideos .video-container").html(register.link);
    });

    $('#modalVideos-adufrgs-no-ar').click(function(){
        instance.close();
    });

});
