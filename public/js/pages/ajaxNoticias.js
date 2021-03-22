// Variaveis de inicialização
var paginacaoHome = 0;
var numeroDeRegistros = 6;
var search = '';

// Gets e Sets
function setPaginacaoHome ($paginacao) { paginacaoHome = $paginacao; }
function getPaginacaoHome () { return paginacaoHome; }

function getNumeroDeRegistros () { return numeroDeRegistros; }


$(document).ready(function()
{
    $('.title-carregar-mais').click(function() {
        ajaxEventoCarregarMais();
    });

    // Inicia Carregando as primeiros registros
    ajaxEventoCarregarMais();
});

function ajaxEventoCarregarMais()
{
    var retorno;

    var ajax = $.ajax({
        url: '/ajax_selectNoticias',
        method: "GET",
        data: { paginacao: getPaginacaoHome(),
                NRegistros: getNumeroDeRegistros() }
    });

    ajax.done(function (data)
    {
        var string;
        var countHome = 0;
// console.log(data);
// return false;

        if (data.length == 0)
        {
            string  = '<div class="col s12 m12 l12 xl12 center-align">';
            string += '  <h2>';
            string += '    Nenhum registro existente.';
            string += '  </h2>';
            string += '</div>';
            $("#locais .row").html(string);
            $("#locais .conteiner-carregar-mais").hide('slow');
            return false;
        }

        for (var key in data)
        {
            // console.log(data[key]);
            // console.log(data[key].categorias[0]);
            // console.log(JSON.parse(data[key].data));
            var imagemInativa = '';
            if ( data[key].ativo == 'N' ) {
                imagemInativa = 'url(/images/imagemInativa.png), ';
            }

            var img = '/images/default.png';
            var banner_principal_namefilefull = '';
            var imagem_principal_namefilefull = '';

            try {
                if ( data[key].namefilefull != null )
                img = '/' + data[key].namefilefull;
            } catch(err) {}

            var titleLink = data[key].name;
            var title = '';
            var subtitle = '';
            if ( data[key].limitTtitle != null ) { title = data[key].limitTtitle; }
            if ( data[key].limitSubtitle != null ) { subtitle = data[key].limitSubtitle; }



            string  = '<div class="col s12 m12 l6 xl6 outra outra-spaco-right item-append">';
            string += '   <div class="box-noticia">';
            string += '       <a href="/noticia/'+data[key].id+'/'+data[key].nameLink+'"><div class="noticia-img" style="background-image: '+imagemInativa+' url('+img+');"></div></a>';
            string += '   </div>';
            string += '   <div class="noticia-text">';
            // string += '       <ul>';
            // string += '           <li><a href="'+data[key].link+'" title="Facebook" class="btSocialNetwork" rel="'+data[key].namefilefull+'"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>';
            // string += '           <li><a href="'+data[key].link+'" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>';
            // string += '           <li><a href="whatsapp://send?text='+data[key].title+' - '+data[key].namefilefull+'" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>';
            // string += '       </ul>';
            string += '       <div class="sub-title truncate assuntos"><a href="/noticia/'+data[key].id+'/'+data[key].nameLink+'">'+data[key].assunto+'</a></div>';
            string += '       <div class="title titles"><a href="/noticia/'+data[key].id+'/'+data[key].nameLink+'">'+data[key].limitTtitle+'</a></div>';
            string += '       <div class="subtitles"><a href="/noticia/'+data[key].id+'/'+data[key].nameLink+'">'+data[key].limitSubtitle+'</a></div>';
            string += '   </div>';
            string += '</div>';

/*
            string  = '';
            string += '<div class="col s12 m6 xl4 item-append">';
            string += ' <div class="espacamento-cards">';
            string += '     <a href="/lugares/lugar/'+data[key].id+'/'+data[key].nameLink+'">';
            string += '     <div class="box-container">';
            string += '       <div class="box-local">';

            string += '         <div class="img-local" style="background-image: url('+$img+')"></div>';
            string += '         <div class="text-local">';
            string += '             <p class="truncate">'+data[key].name+'&nbsp;</p>';
            string += '             <p class="truncate">'+subtitle+'&nbsp;</p>';
            string += '         </div>';

            string += '       </div>';
            string += '     </div>';
            string += '     </a>';
            string += ' </div>';
            string += '</div>';
*/
            if (paginacaoHome == 0 && countHome == 0) {
                if (countHome == 0) {
                    $("#noticias").html(string);
                    countHome++;
                }
            } else {
                $("#noticias").append(string);
            }

            $( "#noticias .item-append" ).fadeTo( "slow" , 1, function() {
                $(this).removeClass('item-append');
            });

        }

        // Incrementa Paginação
        setPaginacaoHome(getPaginacaoHome() + getNumeroDeRegistros());
        retorno = data;

        // Oculta botão "carregar mais"
        // console.log(data[0].nextRegister);
        if (data[0].nextRegister == false || data.length < getNumeroDeRegistros()) {
            $(".conteiner-carregar-mais").hide('slow');
        } else {
            $(".conteiner-carregar-mais").show('slow');
        }
    });
    ajax.fail(function (jqXHR, textStatus) { console.log( "jqXHR: " + jqXHR );
                                             console.log( "Request failed: " + textStatus ); });

    eventSocialNetworks();
    return retorno;
}
