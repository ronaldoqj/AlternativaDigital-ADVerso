<?php
  $materiasEspeciais  = $return['listBanners'];
  $materiasDestaques  = $return['listDestaques'];
  $materiasSimples    = $return['materias-simples'];
  $materiasColunistas = $return['listColunistas'];
  $materiasTvAdverso  = $return['listTvAdverso'];
  $listAdufrgsNoAr    = $return['listAdufrgsNoAr'];
  $galeriaImagens     = $return['galeriaImagens'];
  $materiasCount      = $return['materias-count'];
  $hasGaleria         = $return['hasGaleria'];
  $agendas            = $return['listAgenda'];
?>

@extends('layouts.site')

@section('css')
    <link href="/css/pages/home.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <!-- OWL -->
    <link href="/plugins-frameworks/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins-frameworks/owl_carousel/owl.theme.css" rel="stylesheet">
    <!-- lightbox  -->
    <link rel="stylesheet" href="/plugins-frameworks/lightbox/css/lightbox.min.css">
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
    <script src="/js/pages/home.js"></script>
    <script src="/js/pages/ajaxNewsLetter.js"></script>
    <!-- OWL -->
    <script src="/plugins-frameworks/owl_carousel/owl.carousel.js"></script>
@endsection

@section('content')
<!-- Modal Structure -->
<div id="modalVideos" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="video-container responsive-video">
        </div>
    </div>
</div>

<div class="clearfix"></div>
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
@if (count($materiasEspeciais))
<div class="carousel carousel-slider">

    @if($materiasCount > 1)
        <div class="container">
            <div class="controls-styles control-left"><div class="arrow-left"></div></div>
            <div class="controls-styles control-right"><div class="arrow-right"></div></div>
        </div>
    @endif

    <div class="corrige-marcadores"></div>

    @for ($i = 0; $i < count($materiasEspeciais); $i++)
        @php
            $imagemInativa = '';
            if ( $materiasEspeciais[$i]->ativo == 'N' ) {
                $imagemInativa = 'url(/images/imagemInativa.png), ';
            }
            $limkBanner = Str::slug($materiasEspeciais[$i]->title, '-');
        @endphp
        <div class="carousel-item white-text" href="#one!">
            <div class="box-content" style="background-image: {{$imagemInativa}} url(/{{$materiasEspeciais[$i]->namefilefull}});">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <!-- <div class="col s12 right-align banner-social-network">
                                <ul>
                                  <li><a href="{{url("/noticia/{$materiasEspeciais[$i]->id}/{$materiasEspeciais[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$materiasEspeciais[$i]->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                  <li><a href="{{url("/noticia/{$materiasEspeciais[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                  <li><a href="whatsapp://send?text={{$materiasEspeciais[$i]->title}} - {{url("/noticia/{$materiasEspeciais[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                                </ul>
                            </div> -->

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
@endif
<!-- ======================================================================= -->
<!-- Destaques                                                                   -->
<!-- ======================================================================= -->
@if (count($materiasDestaques))
<div class="container m-t-25">
    <div class="row">
        <a href="/noticias"><div class="title-galeria m-b-20">Notícias</div></a>
        <div id="owl-destaques" class="owl-destaques">
            @php
                $inverse = 'inverse';
                $cont = 1;
                $color = '';
            @endphp

            @for ($i = 0; $i < count($materiasDestaques); $i++)
                @php
                    $imagemInativa = '';
                    if ( $materiasDestaques[$i]->ativo == 'N' ) {
                        $imagemInativa = 'url(/images/imagemInativa.png), ';
                    }
                    if($cont == 1) { $cont++; $color = '#007DC4'; }
                    else if($cont == 2) { $cont++; $color = '#034EA1'; }
                    else { $cont = 1; $color = '#00183F'; }
                    $inverse = $inverse == 'inverse' ? '' : 'inverse';
                    $titleLink = Str::slug($materiasDestaques[$i]->title, '-');
                @endphp
                <div class="item destaques {{$inverse}}" style="background: {{$color}}; color: white;">
                    <div class="box">
                      <a href="/noticia/{{$materiasDestaques[$i]->id}}/{{$titleLink}}"><div class="div1" style="background-image: {{$imagemInativa}} url(/{{$materiasDestaques[$i]->namefilefull}});"></div></a>
                      <div class="div2">
                        <ul>
                          <li class="redes-sociais">
                            <!-- <a href="{{url("/noticia/{$materiasDestaques[$i]->id}/{$materiasDestaques[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$materiasDestaques[$i]->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a>
                            <a href="{{url("/noticia/{$materiasDestaques[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a>
                            <a href="whatsapp://send?text={{$materiasDestaques[$i]->title}} - {{url("/noticia/{$materiasDestaques[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a> -->
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
@endif


<!-- ======================================================================= -->
<!-- Noticias                                                                -->
<!-- ======================================================================= -->
@if (count($materiasSimples))
<div class="container">
    <div class="row">
        <div class="col m12 l8">

          <div class="row m-t-40">
              @for ($i = 0; $i < count($materiasSimples); $i++)
                  @php
                      $imagemInativa = '';
                      if ( $materiasSimples[$i]->ativo == 'N' ) {
                          $imagemInativa = 'url(/images/imagemInativa.png), ';
                      }
                      $titleLink = Str::slug($materiasSimples[$i]->title, '-');

                      $image = $materiasSimples[$i]->namefilefull;
                      if ($materiasSimples[$i]->namefilefull == '') {
                          $image = 'images/default.png';
                      }
                  @endphp
                  <div class="col m12 l6">
                      <a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}">
                          <div class="noticias box-noticia">
                              <div class="noticia-img" style="background-image: {{$imagemInativa}} url(/{{$image}});"></div>
                          </div>
                      </a>
                      <div class="noticias">
                          <div class="noticia-text">
                              <div class="sub-title assuntos truncate"><a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}">{{$materiasSimples[$i]->assunto}}</a></div>
                              <div class="title titles"><a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasSimples[$i]->title, 120, '...')}}</a></div>
                              <div class="subtitles"><a href="/noticia/{{$materiasSimples[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasSimples[$i]->subtitle, 240, '...')}}</a></div>
                          </div>
                      </div>
                  </div>
              @endfor
          </div>
        </div>

        <!-- <div class="col l4 hide-on-med-and-down"> -->
        <div class="col m12 l4">

                <div class="noticias">
                    <div class="newsletter">
                        <div class="title-coluna-3">Newsletter</div>
                        <p>Acompanhe as novidades do Portal Adverso no seu email</p>
                        <div class="form">
                            <form action="">
                                <input type="text" id="name_newsletter" name="name_newsletter"  value="" class="browser-default inputs" placeholder="NOME"  required />
                                <input type="text" id="email_newsletter" name="email_newsletter" value="" class="browser-default inputs" placeholder="EMAIL" required />
                                <input type="submit" id="bt_cadastrar_newsletter" class="btn" value="cadastrar" />
                            </form>
                        </div>
                    </div>
                </div>

                @if (count($agendas))
                <div id="agenda">
                    <a href="/agendas"><div class="title-galeria m-b-20">Agendas</div></a>

                    <div class="agendas">
                        @foreach ($agendas as $item)
                        <a href="/agenda/{{$item->id}}/{{Str::slug($item->title, '-')}}">
                            <div class="agenda-container {{ $item->ativo != 'S' ? 'agenda-inativa' : '' }}">
                                <div class="calendario calendario-agenda">
                                    @if ( isset($item->calendario[0]) )
                                        <div class="calendario-coluna">
                                            <ul>
                                                <li>{{$item->calendario[0]['nomeDia']}}</li>
                                                <li>{{$item->calendario[0]['numeroDia']}}</li>
                                                <li>{{$item->calendario[0]['nomeMes']}}</li>
                                            </ul>
                                        </div>
                                        @if( count($item->calendario) > 1 )
                                        <div class="calendario-coluna">
                                            <ul>
                                                <li><div class="divisao"></div></li>
                                                <li class="divisorLi">{{$item->calendario[1]}}</li>
                                                <li><div class="divisao"></div></li>
                                            </uL>
                                        </div>
                                        <div class="calendario-coluna">
                                            <ul>
                                                <li>{{$item->calendario[2]['nomeDia']}}</li>
                                                <li>{{$item->calendario[2]['numeroDia']}}</li>
                                                <li>{{$item->calendario[2]['nomeMes']}}</li>
                                            </ul>
                                        </div>
                                        @endif
                                    @else
                                        <table class="calendario-vazio"><tr><td>&nbsp;</td></tr></table>
                                    @endif
                                </div>

                                <div class="texts">
                                    <div class="agenda-titulo-home">{{$item->cartola}}</div>
                                    <div class="text-page-home">{{$item->title}}</div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div style="height:20px;"></div>
                    <a href="/agendas" class="agenda-completa">Agenda completa</a>
                </div>
                @endif

                <div class="noticias">
                    <div class="redes-sociais">
                        <div class="title-coluna-3">Redes Sociais</div>
                        <p>Acompanhe o Portal Adverso nas redes sociais</p>
                        <ul>
                            <li><a href="https://www.facebook.com/adufrgssindical/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                            <li><a href="https://twitter.com/adufrgssindical" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                            <li><a href="https://www.instagram.com/adufrgssindical/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a></li>
                        </ul>
                    </div>
                </div>

        </div>
    </div>
</div>
@endif


<!-- ======================================================================= -->
<!-- Colunistas                                                              -->
<!-- ======================================================================= -->
@if (count($materiasColunistas))
<div class="container-fluid colunistas">
    <div class="container m-t-25">
        <div class="row">
            <a href="/colunistas"><div class="title-colunistas">Colunistas</div></a>
            <p><br></p>
            <div id="owl-home-colunistas" class="owl-home-colunistas">

                @for ($i = 0; $i < count($materiasColunistas); $i++)
                    @php
                        $imagemInativa = '';
                        if ( $materiasColunistas[$i]->ativo == 'N' ) {
                            $imagemInativa = 'url(/images/imagemInativa.png), ';
                        }
                        $titleLink = Str::slug($materiasColunistas[$i]->title, '-');

                        $rightLeft = 'outro-spaco-right';
                        $img = '/images/default.png';
                        if ($materiasColunistas[$i]->fileBackground_namefilefull != '') {
                          $img = '/'.$materiasColunistas[$i]->fileBackground_namefilefull;
                        }
                    @endphp


                    <div class="col s12 m12 outro {{$rightLeft}}">
                        <div class="box-colunista">
                            <a href="/colunista/{{$materiasColunistas[$i]->id}}/{{$titleLink}}"><div class="colunista-img" style="background-image: {{$imagemInativa}} url({{$img}});"></div></a>
                        </div>
                        <div class="colunista-text">

                            <div class="sub-title">
                                <table border="1">
                                      <tr>
                                          <td width="1">
                                              <div class="borda-avatar">
                                                  <div class="avatar" style="background-image: {{$imagemInativa}} url(/{{$materiasColunistas[$i]->avatar_namefilefull}});"></div>
                                              </div>
                                          </td>
                                          <td class="td-avatar-info">
                                                <div class="avatar-name assuntos">por {{$materiasColunistas[$i]->colunista_name}}</div>
                                                <div class="redes-sociais">
                                                    <!-- <ul>
                                                      <li><a href="{{url("/colunista/{$materiasColunistas[$i]->id}/{$materiasColunistas[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url($img)}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                                      <li><a href="{{url("/colunista/{$materiasColunistas[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                                      <li><a href="whatsapp://send?text={{$materiasColunistas[$i]->title}} - {{url("/colunista/{$materiasColunistas[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                                                    </ul> -->
                                                </div>
                                          </td>
                                      </tr>
                                </table>
                            </div>
                            <div class="title titles"><a href="/colunista/{{$materiasColunistas[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasColunistas[$i]->title, 80, '')}}</a></div>
                            <div class="subtitles"><a href="/colunista/{{$materiasColunistas[$i]->id}}/{{$titleLink}}">{{Str::limit($materiasColunistas[$i]->subtitle, 80, '')}}</a></div>
                            @php
                              $titleLink = Str::slug($materiasColunistas[$i]->title, '-');
                            @endphp
                        </div>
                    </div>
                @endfor

            </div>
        </div>
    </div>
</div>
@endif

<!-- ======================================================================= -->
<!-- Galeria de fotos                                                        -->
<!-- ======================================================================= -->
@php
    $cont = 0;
@endphp

@if ($hasGaleria)
<div class="container-fluid galeria m-b-40">
    <div class="container m-t-25">
        <div class="row">
            <a href="/galeria"><div class="title-galeria">Galeria de fotos</div></a>
            <p><br></p>
            <div id="owl-home-galeria" class="owl-home-galeria">


              @for ($i = 0; $i < count($galeriaImagens); $i++)
                  @php
                      $cont++;
                      if($cont > 6) { $cont = 0; }
                  @endphp
                  @if($cont == 1)
                      <div class="item home-galeria" style="color: white;">
                          <div class="galeria-item">
                  @endif
                              <a href="/galeria"><div class="img-{{$cont}}" style="background-image: url(/{{$galeriaImagens[$i]->namefilefull}});"></div></a>
                  @if($cont == 6)
                      @php
                        $cont = 0;
                      @endphp
                          </div>
                          <div class="clearfix"></div>
                      </div>
                  @endif
              @endfor

              <?php /*
              <div class="item home-galeria" style="color: white;">
                  <div class="galeria-item">
                      <div class="img-1" style="background-image: url('/images/galeria1.jpg');"></div>
                      <div class="img-2" style="background-image: url('/images/galeria2.jpg');"></div>
                      <div class="img-3" style="background-image: url('/images/galeria3.jpg');"></div>
                      <div class="img-4" style="background-image: url('/images/galeria4.jpg');"></div>
                      <div class="img-5" style="background-image: url('/images/galeria5.jpg');"></div>
                      <div class="img-6" style="background-image: url('/images/galeria6.jpg');"></div>
                  </div>
                  <div class="clearfix"></div>
              </div>
              <div class="item home-galeria" style="color: white;">
                  <div class="galeria-item">
                      <div class="img-1" style="background-image: url('/images/galeria1.jpg');"></div>
                      <div class="img-2" style="background-image: url('/images/galeria2.jpg');"></div>
                      <div class="img-3" style="background-image: url('/images/galeria3.jpg');"></div>
                      <div class="img-4" style="background-image: url('/images/galeria4.jpg');"></div>
                      <div class="img-5" style="background-image: url('/images/galeria5.jpg');"></div>
                      <div class="img-6" style="background-image: url('/images/galeria6.jpg');"></div>
                  </div>
                  <div class="clearfix"></div>
              </div>
              */ ?>
            </div>
        </div>
    </div>
</div>
@endif

<!-- ======================================================================= -->
<!-- Videos                                                                  -->
<!-- ======================================================================= -->
@if (count($materiasTvAdverso))
<div class="container-fluid videos">
    <div class="container m-t-40">
        <div class="row">
            <a href="/tv-adverso"><div class="title-videos">Multimídia</div></a>
            <p><br></p>
            <div id="owl-home-videos" class="owl-home-videos">

                @for ($i = 0; $i < count($materiasTvAdverso); $i++)
                    <div class="item home-videos" rel="{{json_encode($materiasTvAdverso[$i], true)}}">
                        <div class="box-image"><div class="image" style="background: url(/images/player-video.png), url(http://i1.ytimg.com/vi/{{$materiasTvAdverso[$i]->id_video}}/hqdefault.jpg);"></div></div>
                        <div class="paragrafos">
                           <BR>
                            <!--<p class="titles">{{Str::limit($materiasTvAdverso[$i]->title, 80, '')}}</p> -->
                            <p class="subtitles">{{Str::limit($materiasTvAdverso[$i]->description, 240, '')}}</p>
                        </div>
                    </div>
                @endfor

            </div>
        </div>
    </div>
</div>
@endif

<!-- ======================================================================= -->
<!-- AdufrgsNoAr                                                             -->
<!-- ======================================================================= -->
@if (count($listAdufrgsNoAr))
<div class="container-fluid videos-adufrgs">
    <div class="container m-t-40">
        <div class="row">
            <a href="/adufrgs-no-ar"><div class="title-videos">ADUFRGS no ar</div></a>
            <p><br></p>
            <div id="owl-home-adufrgs-no-ar" class="owl-home-adufrgs-no-ar">

                @for ($i = 0; $i < count($listAdufrgsNoAr); $i++)
                    <div class="item home-videos-adurgs-no-ar" rel="{{json_encode($listAdufrgsNoAr[$i], true)}}">
                        <div class="box-image"><div class="image" style="background: url(/images/player-video.png), url(http://i1.ytimg.com/vi/{{$listAdufrgsNoAr[$i]->id_video}}/hqdefault.jpg);"></div></div>
                        <div class="paragrafos">
                           <BR>
                            <!--<p class="titles">{{Str::limit($listAdufrgsNoAr[$i]->title, 80, '')}}</p> -->
                            <p class="subtitles">{{Str::limit($listAdufrgsNoAr[$i]->description, 240, '')}}</p>
                        </div>
                    </div>
                @endfor

            </div>
        </div>
    </div>
</div>
@endif


@endsection
