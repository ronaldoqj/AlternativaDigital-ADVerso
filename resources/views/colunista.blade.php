@php
    $image = $return['image'];
    $backgroundbanner = $return['backgroundbanner'];
    $maisNoticias = $return['maisNoticias'];
    $materia = $return['materia'];
    $tipo = $materia->type;
    $cont = 0;
@endphp

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
<meta property="og:url"           content="{{url("/colunista/{$materia->id}/{$materia->title}")}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$materia->title}}" />
<meta property="og:description"   content="{{$materia->subtitle}}" />
<meta property="og:image"         content="{{url("/{$backgroundbanner->namefilefull}")}}" />
@endsection


@section('css')
<link href="/css/pages/colunista.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<link href="/plugins-frameworks/owl_carousel/owl.carousel.css" rel="stylesheet">
<link href="/plugins-frameworks/owl_carousel/owl.theme.css" rel="stylesheet">
<!-- lightbox  -->
<link rel="stylesheet" href="/plugins-frameworks/lightbox/css/lightbox.min.css">
@endsection

@section('js')
<script src="/plugins-frameworks/owl_carousel/owl.carousel.js"></script>
<!-- lightbox -->
<script src="/plugins-frameworks/lightbox/js/lightbox.min.js"></script>
<script>
    $(document).ready(function()
    {
        $("#owl-home-galeria").owlCarousel({
            //autoPlay : 4000,
            items : 2,
            itemsDesktop : [1200,2],
            itemsDesktopSmall : [979,1],
            itemsTablet: [600,1], //2 items between 600 and 0
            itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
        });

    });
</script>
@endsection

@section('content')
<div class="clearfix"></div>
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->

<div class="container-fluid box-banner" style="background-image: url(/{{$backgroundbanner->namefilefull}})">
    <div class="row">
        <div class="container banner-topo">

        </div>
    </div>
</div>



<div class="container colunista-padding">
    <div class="colunista">
        <div class="row">
            <div class="conteudo">
                <div class="box-amplia-social">
                    <div class="box-avatar">
                        <div class="title">
                            <table>
                                <tr>
                                    <td>
                                        <div class="borda-avatar">
                                            <div class="avatar" style="background-image: url(/{{$materia->avatar_namefilefull}});"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>por {{$materia->colunista_name}}</div>
                                        <p>{{$materia->colunista_cargo}}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="banner-social">
                        <p>Compartilhar</p>
                        <ul>
                          <li><a href="{{url("/colunista/{$materia->id}/{$materia->title}")}}" title="Facebook" class="btSocialNetwork"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                          <li><a href="{{url("/colunista/{$materia->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                          <li><a href="whatsapp://send?text={{$materia->title}} - {{url("/colunista/{$materia->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                        </ul>
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
                <div class="banner-texts">
                    <ul>
                        <li class="assuntos">{{$materia->assunto}}</li>
                        <li class="titles">{{$materia->title}}</li>
                    </ul>
                </div>
                <div class="clearfix"></div>

                <div class="paragrafos">
                    <p>{{$materia->subtitle}}</p>
                    {!!$materia->text1!!}
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
</div>


<!-- Outros Colunistas-->
<div class="container">
    <div class="title-outros-colunistas m-b-40">Outros colunistas</div>

    <div class="row">

        @for ($i = 0; $i < count($maisNoticias); $i++)
            @if($cont == 1)
                @php
                    $rightLeft = 'outro-spaco-left';
                    $cont = 0;
                @endphp
            @else
                @php
                    $rightLeft = 'outro-spaco-right';
                    $img = '/images/default.png';
                    if ($maisNoticias[$i]->fileBackground_namefilefull != '') {
                      $img = '/'.$maisNoticias[$i]->fileBackground_namefilefull;
                    }
                @endphp
            @endif
            @php
                $titleLink = Str::slug($maisNoticias[$i]->title, '-');
            @endphp
            <div class="col s12 m12 l6 outro {{$rightLeft}}">
                <div class="box-colunista">
                    <a href="/colunista/{{$maisNoticias[$i]->id}}/{{$titleLink}}"><div class="colunista-img" style="background-image: url({{$img}});"></div></a>
                </div>
                <div class="colunista-text">

                    <div class="sub-title">
                        <table border="1">
                              <tr>
                                  <td width="1">
                                      <div class="borda-avatar">
                                          <div class="avatar" style="background-image: url(/{{$maisNoticias[$i]->avatar_namefilefull}});"></div>
                                      </div>
                                  </td>
                                  <td class="td-avatar-info">
                                        <div class="avatar-name assuntos">por {{$maisNoticias[$i]->colunista_name}}</div>
                                        <div class="redes-sociais">
                                            <ul>
                                              <li><a href="{{url("/colunista/{$maisNoticias[$i]->id}/{$maisNoticias[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$maisNoticias[$i]->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                              <li><a href="{{url("/colunista/{$maisNoticias[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                              <li><a href="whatsapp://send?text={{$maisNoticias[$i]->title}} - {{url("/colunista/{$maisNoticias[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                                            </ul>
                                        </div>
                                  </td>
                              </tr>
                        </table>
                    </div>
                    <div class="title titles"><a href="/colunista/{{$maisNoticias[$i]->id}}/{{$titleLink}}">{{Str::limit($maisNoticias[$i]->title, 35, '...')}}</a></div>
                    <div class="subtitles"><a href="/colunista/{{$maisNoticias[$i]->id}}/{{$titleLink}}">{{Str::limit($maisNoticias[$i]->subtitle, 90, '...')}}</a></div>
                </div>
            </div>
        @endfor

        <!--
        @for ($i = 0; $i < count($maisNoticias); $i++)
            @php
              $titleLink = Str::slug($maisNoticias[$i]->title, '-');
            @endphp
            <div class="col m6 outro outro-spaco-right">
                <div class="box-colunista">
                    <div class="colunista-img" style="background-image: url('/{{$maisNoticias[$i]->namefilefull}}');">
                    </div>
                </div>
                <div class="colunista-text">
                    <ul>
                      <li><a href="{{url("/colunista/{$maisNoticias[$i]->id}/{$maisNoticias[$i]->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$backgroundbanner->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                      <li><a href="{{url("/colunista/{$maisNoticias[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                      <li><a href="whatsapp://send?text={{$maisNoticias[$i]->title}} - {{url("/colunista/{$maisNoticias[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                    </ul>
                    <div class="sub-title">
                        <div class="borda-avatar"><div class="avatar" style="background-image: url('/{{$maisNoticias[$i]->avatar_namefilefull}}');"></div></div>
                        por Paulo Machado Mors
                    </div>
                    <div class="title">{{Str::limit($maisNoticias[$i]->title, 35, '...')}}</div>
                    <div>{{Str::limit($maisNoticias[$i]->subtitle, 90, '...')}}</div>
                    <div class="colunista-leiamais"><a href="/colunista/{{$maisNoticias[$i]->id}}/{{$titleLink}}">Leia mais</a></div>
                </div>
            </div>
        @endfor
         -->
    </div>

</div>





<!-- ======================================================================= -->
<!-- vOLTAR                                                                  -->
<!-- ======================================================================= -->
<div class="container m-t-25">
    <div class="row">
        <div id="bt-voltar" onClick='window.history.back();'></div>
    </div>
</div>










@endsection
