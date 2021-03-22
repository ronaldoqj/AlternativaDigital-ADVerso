<?php
  $materiasEspeciais = $return['listBanners'];
  $materiasDestaques = $return['listDestaques'];
  $materiasSimples = $return['materias-simples'];
  $materiasColunistas = $return['listColunistas'];
  $materiasTvAdverso = $return['listTvAdverso'];
  $texto = $return['texto'];
?>

@extends('layouts.site')

@section('css')
    <link href="/css/pages/noticias.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <!-- OWL -->
    <link href="/plugins-frameworks/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins-frameworks/owl_carousel/owl.theme.css" rel="stylesheet">

    <style>
        .card .card-calendario { background: #9D224E; }
        .card .card-background .card-texto { border-top: 3px solid #9D224E; }
        .card:hover { border: solid 1px #9D224E; }
        .card:hover .card-background .card-texto {
            background-color: #9D224E90;
        }
    </style>
@endsection

@section('js')
    <script src="/js/pages/noticias.js"></script>
    <script src="/js/pages/ajaxNoticias.js"></script>
    <!-- OWL -->
    <script src="/plugins-frameworks/owl_carousel/owl.carousel.js"></script>
@endsection

@section('content')
<div class="clearfix"></div>
<?php /*
<div class="carousel carousel-slider">

    @if($return['materias-count'] > 1)
        <div class="container">
            <div class="controls-styles control-left"><div class="arrow-left"></div></div>
            <div class="controls-styles control-right"><div class="arrow-right"></div></div>
        </div>
    @endif

    <div class="corrige-marcadores"></div>

    @for ($i = 0; $i < count($materiasEspeciais); $i++)
        @php
            $limkBanner = Str::slug($materiasEspeciais[$i]->title, '-');
        @endphp
        <div class="carousel-item white-text" href="#one!">
            <div class="box-content" style="background-image: url(/{{$materiasEspeciais[$i]->namefilefull}});">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col s12 right-align banner-social-network">
                                <ul>
                                  <li><a href="{{url("/noticia/{$materiasEspeciais[$i]->id}/{$materiasEspeciais[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$materiasEspeciais[$i]->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                  <li><a href="{{url("/noticia/{$materiasEspeciais[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                  <li><a href="whatsapp://send?text={{$materiasEspeciais[$i]->title}} - {{url("/noticia/{$materiasEspeciais[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                                </ul>
                            </div>

                            <div class="col s12 m10 l8 banner-texts">
                                <ul>
                                    <li class="assuntos truncate"><a href="/noticia/{{$materiasEspeciais[$i]->id}}/{{$limkBanner}}">{{$materiasEspeciais[$i]->assunto}}</a></li>
                                    <li class="titles"><a href="/noticia/{{$materiasEspeciais[$i]->id}}/{{$limkBanner}}">{{$materiasEspeciais[$i]->title}}</a></li>
                                    <li class="subtitles"><a href="/noticia/{{$materiasEspeciais[$i]->id}}/{{$limkBanner}}">
                                        {{$materiasEspeciais[$i]->subtitle}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor

</div>

<!-- ======================================================================= -->
<!-- Destaques                                                                   -->
<!-- ======================================================================= -->
<div class="container m-t-25">
    <div class="row">
        <div id="owl-destaques" class="owl-destaques">
            @php
                $inverse = 'inverse';
                $cont = 1;
                $color = '';
            @endphp

            @for ($i = 0; $i < count($materiasDestaques); $i++)
                @php
                    if($cont == 1) { $cont++; $color = '#007DC4'; }
                    else if($cont == 2) { $cont++; $color = '#034EA1'; }
                    else { $cont = 1; $color = '#00183F'; }
                    $inverse = $inverse == 'inverse' ? '' : 'inverse';
                    $titleLink = Str::slug($materiasDestaques[$i]->title, '-');
                @endphp
                <div class="item destaques {{$inverse}}" style="background: {{$color}}; color: white;">
                    <div class="box">
                      <a href="/noticia/{{$materiasDestaques[$i]->id}}/{{$titleLink}}"><div class="div1" style="background-image: url(/{{$materiasDestaques[$i]->namefilefull}});"></div></a>
                      <div class="div2">
                        <ul>
                          <li class="redes-sociais">
                            <a href="{{url("/noticia/{$materiasDestaques[$i]->id}/{$materiasDestaques[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$materiasDestaques[$i]->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a>
                            <a href="{{url("/noticia/{$materiasDestaques[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a>
                            <a href="whatsapp://send?text={{$materiasDestaques[$i]->title}} - {{url("/noticia/{$materiasDestaques[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a>
                          </li>
                          <li class="assuntos truncate"><a href="/noticia/{{$materiasDestaques[$i]->id}}/{{$titleLink}}">{{$materiasDestaques[$i]->assunto}}</a></li>
                          <li class="titles"><a href="/noticia/{{$materiasDestaques[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasDestaques[$i]->title, 120, '...')}}</a></li>
                          <li class="subtitles"><a href="/noticia/{{$materiasDestaques[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasDestaques[$i]->subtitle, 240, '...')}}</a></li>
                          <li><!--a href="/noticia/{{$materiasDestaques[$i]->id}}/{{$titleLink}}" style="border: 1px solid white;">Leia mais</a--></li>
                        </ul>
                      </div>
                    </div>
                </div>
            @endfor

        </div>
    </div>
</div>
*/ ?>

<!-- ======================================================================= -->
<!-- Outras Noticias                                                                -->
<!-- ======================================================================= -->
<div class="container m-t-25">
    <div class="title-outras-noticias">Notícias</div>
    <!-- <p class="subtitulo-noticias1">As notícias mais recentes você encontra neste espaço. Envie sugestões de pauta. Faça buscas por temas.</p> -->
    {!!$texto->text ?? '<div class="m-b-40"></div>'!!}
    <!-- Outras Noticias-->
    <div id='noticias' class="row">
        @for ($i = 0; $i < count($materiasSimples); $i++)
            @php
              $imagemInativa = '';
              if ( $materiasSimples[$i]->ativo == 'N' ) {
                  $imagemInativa = 'url(/images/imagemInativa.png), ';
              }

              $titleLink = Str::slug($materiasSimples[$i]->title, '-');

              $image = '/' . $materiasSimples[$i]->namefilefull;
              if($materiasSimples[$i]->namefilefull == '') {
                  $image = '/images/default.png';
              }
            @endphp
          <div class="col s12 m12 l6 xl6 outra outra-spaco-right">
              <div class="box-noticia">
                  <a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}"><div class="noticia-img" style="background-image: {{$imagemInativa}} url({{$image}});"></div></a>
              </div>
              <div class="noticia-text">
                  <!-- <ul>
                    <li><a href="{{url("/noticia/{$materiasSimples[$i]->id}/{$materiasSimples[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$materiasSimples[$i]->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                    <li><a href="{{url("/noticia/{$materiasSimples[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                    <li><a href="whatsapp://send?text={{$materiasSimples[$i]->title}} - {{url("/noticia/{$materiasSimples[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                  </ul> -->
                  <div class="sub-title truncate assuntos"><a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}">{{$materiasSimples[$i]->assunto}}</a></div>
                  <div class="title titles"><a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasSimples[$i]->title, 110, '')}}</a></div>
                  <div class="subtitles"><a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasSimples[$i]->subtitle, 240, '...')}}</a></div>
              </div>
          </div>
        @endfor
    </div>
</div>


<!-- ======================================================================= -->
<!-- Noticias                                                                -->
<!-- ======================================================================= -->
<?php /*
<div class="container m-t-25 conteiner-noticias">

    <!-- Linha 1 -->
    <div class="row">
        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>

        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha 2 -->
    <div class="row">
        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>

        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha 3 -->
    <div class="row">
        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>

        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha 4 -->
    <div class="row">
        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>

        <div class="col l3 m12 s12">
            <div class="noticias box-noticia">
                <div class="noticia-img" style="background-image: url('/images/noticia2.jpg');">
                </div>
            </div>
        </div>
        <div class="col l3 m12 s12 m-b-40">
            <div class="noticias">
                <div class="noticia-text">
                    <ul>
                        <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">Crise no campus</div>
                    <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                    <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                    <div class="noticia-leiamais"><a href="/noticia">Leia mais</a></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container text-center">
    <div class="title-carregar-mais">Carregar mais noticias</div>
</div>
*/ ?>

<div class="container text-center conteiner-carregar-mais">
    <div class="title-carregar-mais">Carregar mais notícias</div>
</div>
@endsection
