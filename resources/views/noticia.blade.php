<?php
    $image = $return['image'];
    if ( $image ) {
        $alternative_text = $image->namefilefull;
        $alternative_text = $image->alternative_text;
        $nameImage = $image->name;
        $imagePath = '/'.$image->namefilefull;
    } else {
        $alternative_text = '';
        $nameImage = '';
        $imagePath = $return['backgroundbanner'];
    }

    $backgroundbanner = $return['backgroundbanner'];
    $backgroundbannerMateriaNormal = $return['backgroundbannerMateriaNormal'];
    $maisNoticias = $return['maisNoticias'];
    $materia = $return['materia'];
    $tipo = $materia->type;
?>

@if($materia->galeria_id)
    @php
      $galeria = $return['galeria'];
      $files = $return['files'];
      $fileIdGaleria = '';
      $cont = 0;
    @endphp
@endif

@extends('layouts.site')

@section('metatags')
<meta property="og:url"           content="{{url("/noticia/{$materia->id}/{$materia->title}")}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$materia->title}}" />
<meta property="og:description"   content="{{$materia->subtitle}}" />
<meta property="og:image"         content="{{url("{$imagePath}")}}" />
@endsection

@section('css')
    <link href="/css/pages/noticia.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/plugins-frameworks/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins-frameworks/owl_carousel/owl.theme.css" rel="stylesheet">
    <!-- lightbox  -->
    <link rel="stylesheet" href="/plugins-frameworks/lightbox/css/lightbox.min.css">
    @if($tipo != 'especial')
    <style>
        body {
            background: url('/{{$backgroundbannerMateriaNormal}}') no-repeat;
            background-position: center top;
            background-size: contain;
            background-position-y: 50px;
        }
    </style>
    @endif
@endsection

@section('js')
    <script src="/js/pages/noticia.js"></script>
    <script src="/plugins-frameworks/owl_carousel/owl.carousel.js"></script>
    <!-- lightbox -->
    <script src="/plugins-frameworks/lightbox/js/lightbox.min.js"></script>
@endsection

@section('content')
<div class="clearfix"></div>

<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
@if($tipo == 'especial')
<div class="container-fluid box-banner" style="background-image: url(/{{$backgroundbanner}})">
    <div class="row">
        <div class="container banner-topo">

        </div>
    </div>
</div>
@endif

<div class="container noticia-padding {{$tipo}} box-conteudo">
    <div class="noticia">
    <div class="row">
        <div class="topo-noticia">
          <div class="title-pages title-materia">Notícia</div>
          <div class="box-amplia-social">
              <div class="amplia-fonte">
                  <p>Ampliar fonte</p>
                  <ul>
                      <li id="menos" rel="noticia"><a>-</a></li>
                      <li>A</li>
                      <li id="mais" rel="noticia"><a>+</a></li>
                  </ul>
              </div>
              <div class="banner-social">
                  <p>Compartilhar</p>
                  <ul>
                      <li><a href="{{url("/noticia/{$materia->id}/{$materia->title}")}}" title="Facebook" class="btSocialNetwork"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                      <li><a href="{{url("/noticia/{$materia->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                      <li><a href="whatsapp://send?text={{$materia->title}} - {{url("/noticia/{$materia->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                  </ul>
              </div>
          </div>
        </div>
        <?php
            $date = $materia->created_at;
            $daysOfWeek = ['Sunday' => 'Domingo', 'Monday' => 'Segunda-feira', 'Tuesday' => 'Terça-feira', 'Wednesday' => 'Quarta-feira', 'Thursday' => 'Quinta-feira', 'Friday' => 'Sexta-feira', 'Saturday' => 'Sábado'];
            $months = ['', 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
            $month = intval( date( 'm', strtotime($date) ) );
            $dataOfNews = $daysOfWeek[date( 'l', strtotime($date) )] . ', ' .
                          date( 'd', strtotime($date) ) . ' de ' .
                          $months[$month] . ' de ' .
                          date( 'Y', strtotime($date) );
        ?>
        <div class="data">{{ $dataOfNews }}</div>
        <div class="conteudo">
            <div class="banner-texts">
                <ul>
                    <li class="assuntos">{{$materia->assunto}}</li>
                    <li class="titles">{{$materia->title}}</li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <!--div class="sub-titulo">Reportagem especial</div>
            <div class="titulo">Colapso da pesquisa no Brasil</div-->
            <div class="paragrafos">
                <p>{{$materia->subtitle}}</p>
                <!-- <p></p> -->
                {!!$materia->text1!!}
                <!-- <p></p> -->
                {!! $materia->text2 !!}
            </div>

            @if($materia->video_id)
                <div class="row">
                    <div class="video-container responsive-video m-t-50">{!!$materia->video_link!!}</div>
                </div>
            @endif

            @if($materia->galeria_id)
                <div class="row m-t-40">

                    <!-- Galeria -->
                    <div id="owl-home-galeria" class="owl-home-galeria">

                    @for ($i = 0; $i < count($files); $i++)

                            @php
                                $cont++;
                                if($cont > 6) { $cont = 0; }
                                $nextItem = isset($files[$i + 1]->id_galeria) ? $files[$i + 1]->id_galeria : null;
                            @endphp
                            @if($cont == 1)
                                <div class="item home-galeria" style="color: white;">
                                    <div class="galeria-item">
                            @endif
                                        <a href="/{{$files[$i]->namefilefull}}" data-lightbox="galeria{{$galeria->id}}" data-title="{{$files[$i]->name}}">
                                            <div class="img-{{$cont}}" style="background-image: url(/{{$files[$i]->namefilefull}});"></div>
                                        </a>
                            @if($cont == 6 || $files[$i]->id_galeria != $nextItem)
                                @php
                                  $cont = 0;
                                @endphp
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            @endif
                    @endfor

                    </div>
                    <div class="descricao-galeria">
                        <p class="titles">{{$galeria->title}}</p>
                        <p class="subtitles">{{$galeria->description}}</p>
                    </div>

                </div>
            @endif

        </div>
    </div>
    </div>

    @if (count($maisNoticias))
        <?php
          $titulo = 'Outras notícias';
          if ($maisNoticias[0]->noticiaRelacionada == 'S') {
            $titulo = 'Matérias relacionadas sobre: ' . $materia->assunto;
          }
        ?>
    <div class="row">
        <div class="col s12 m-t-80">
            <div class="title-outras-noticias m-b-40">{{$titulo}}</div>
            <!-- Outras Noticias-->

            @for ($i = 0; $i < count($maisNoticias); $i++)
                @php
                  $titleLink = Str::slug($maisNoticias[$i]->title, '-');

                  $image = '/' . $maisNoticias[$i]->namefilefull;
                  if($maisNoticias[$i]->namefilefull == '') {
                      $image = '/images/default.png';
                  }
                @endphp
              <div class="col s12 m12 l6 xl6 outra outra-spaco-right">
                  <div class="box-noticia">
                      <a href="/noticia/{{$maisNoticias[$i]->id}}/{{$titleLink}}"><div class="noticia-img" style="background-image: url({{$image}});"></div></a>
                  </div>
                  <div class="noticia-text">
                      <ul>
                        <li><a href="{{url("/noticia/{$maisNoticias[$i]->id}/{$maisNoticias[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$maisNoticias[$i]->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                        <li><a href="{{url("/noticia/{$maisNoticias[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                        <li><a href="whatsapp://send?text={{$maisNoticias[$i]->title}} - {{url("/noticia/{$maisNoticias[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                      </ul>
                      <div class="sub-title truncate assuntos"><a href="/noticia/{{$maisNoticias[$i]->id}}/{{$titleLink}}">{{$maisNoticias[$i]->assunto}}</a></div>
                      <div class="title titles"><a href="/noticia/{{$maisNoticias[$i]->id}}/{{$titleLink}}">{{Str::limit($maisNoticias[$i]->title, 35, '...')}}</a></div>
                      <div class="subtitles"><a href="/noticia/{{$maisNoticias[$i]->id}}/{{$titleLink}}">{{Str::limit($maisNoticias[$i]->subtitle, 90, '...')}}</a></div>
                  </div>
              </div>
            @endfor
        </div>
    </div>
    @endif

</div>


<!-- ======================================================================= -->
<!-- vOLTAR                                                                  -->
<!-- ======================================================================= -->
<div class="container">
    <div class="row">
        <div id="bt-voltar" onClick='window.history.back();'></div>
    </div>
</div>

@endsection
