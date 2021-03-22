var elem = document.querySelector('#alert');
var options = {
  opacity: 0.9
};
var register;
var instanceAlert = M.Modal.init(elem, options);
//instanceAlert.open();

(function($){
  $(function(){

    //$('.button-collapse').sideNav();
    eventsLayout();
    eventsButtons();
    eventSocialNetworks();
  }); // end of document ready
})(jQuery); // end of jQuery name space


function eventSocialNetworks()
{
    $('.btSocialNetwork').click(function()
    {
        var url = $(this).attr('href');
        var title = $(this).attr('title');

        switch( $(this).attr('title') )
        {
            case 'Facebook':
                var w = 630;
                var h = 360;
                var left = screen.width/2 - 630/2;
                var top = screen.height/2 - 360/2;

                window.open('http://www.facebook.com/sharer.php?u='+url, 'Compartilhar no facebook', 'toolbar=no, location=no, directories=no, status=no, ' + 'menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+ ', height=' + h + ', top=' + top + ', left=' + left);
                break;
            case 'Twitter':
                var ulrSN = "http://twitter.com/home?status="+url;
                window.open(ulrSN,'ADverso', 'toolbar=0, status=0, width=650, height=450');
                break;
            case 'Whatsapp':
                // code block
                break;
        }

        return false;
    });

    $('.modal-close').click(function(){
        instanceAlert.close();
    });
}

function eventsLayout()
{

    if ( $('.carousel .carousel-item').length > 1 ) {
        setInterval(function() {
          $('.carousel').carousel('next');
        }, 8000); // every 8 seconds
    }

    // Menu lateral mobile
    //$('.sidenav').sidenav();

    //$('.group-social-network li').click(function() {
    $('.group-social-network li .icon-lupa, .group-social-network li [buscar]').click(function() {
       $('.group-social-network ul').attr('expand', true);
       $('#bt-search').focus();
    });

    $('#search').click(function(){
        $('.group-social-network ul').attr('expand', false);
    });


    verificaScroll();
    $(window).scroll(function()
    {
        verificaScroll();
    });

    $('#voltarAoTopo').click(function(){
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    $('.sidenav').sidenav();
    /*
    $('.social-itens ul li:eq(1)').hover(function(){
        $('.primeiro-item-social.add').toggleClass('hover-primeiro-item-social');
    });

    $('.social-itens-rodape ul li:eq(1)').hover(function(){
        $('.primeiro-item-social-rodape.add').toggleClass('hover-primeiro-item-social-rodape');
    });

    $('.principal-itens ul li:eq(1)').hover(function(){
        $('.primeiro-item-principal.add').toggleClass('hover-primeiro-item-principal');
    });


    $('.icon-search').click(function(){
        //$('.input-search').removeClass('hide');
        $('.input-search').removeClass('hide');
        $('.input-search').hide();
        $('.input-search').show('fast');
    });


    $('.close-search').click(function(){
        $('.input-search').hide('fast', function(){
            $('.input-search').addClass('hide');
        });
        //
    });
    */
}

function verificaScroll()
{
    if($(window).scrollTop() > 200) {
        $('#voltarAoTopo').show('slow');
    } else {
        $('#voltarAoTopo').hide('slow');
    }
}

function eventsButtons()
{
    $('.fechar-menu-mobile').click(function(){
        $('.sidenav').sidenav('close');
    });
}

function owlFiltros() {
    $("#owl-filtros").owlCarousel({
        pagination : false,
        navigationText: ['<i class="tiny material-icons">chevron_left</i>', '<i class="tiny material-icons">chevron_right</i>'],
        navigation: true,
        items : 7,
        itemsDesktop : [601,5],
        itemsDesktopSmall : [560,7],
        itemsTablet: [460,5], //2 items between 600 and 0
        itemsMobile : [420,4] // itemsMobile disabled - inherit from itemsTablet option
    });

    $("#owl-destaques").owlCarousel({
        //autoPlay : 4000,
        items : 3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,2],
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });
}
