<?php
    $register = $return['agenda'];
    $background = '/images/background.jpg';

    if ($register->galeria)
    {
        $galeria = $return['galeria'];
        $files = $return['files'];
        $fileIdGaleria = '';
        $cont = 0;
    }
?>

@extends('layouts.site')

@section('metatags')
<meta property="og:url"         content="{{url("/agenda/{$register->id}/{$register->title}")}}" />
<meta property="og:type"        content="website" />
<meta property="og:title"       content="{{$register->title}}" />
<meta property="og:description" content="{{$register->linha_apoio}}" />
<meta property="og:image"       content="{{url("{$register->namefilefull}")}}" />
@endsection

@section('css')
    <link href="/css/pages/agenda.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/plugins-frameworks/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins-frameworks/owl_carousel/owl.theme.css" rel="stylesheet">
    <!-- lightbox  -->
    <link rel="stylesheet" href="/plugins-frameworks/lightbox/css/lightbox.min.css">
    <style>
        body {
            background: url('{{$background}}') no-repeat;
            background-position: center top;
            background-size: contain;
            background-position-y: 50px;
        }

        .card .card-calendario { background: #9D224E; }
        .card .card-background .card-texto { border-top: 3px solid #9D224E; }
        .card:hover { border: solid 1px #9D224E; }
        .card:hover .card-background .card-texto {
            background-color: #9D224E90;
        }
    </style>
@endsection

@section('js')
    <script src="/js/pages/agenda.js"></script>
    <script src="/plugins-frameworks/owl_carousel/owl.carousel.js"></script>
    <!-- lightbox -->
    <script src="/plugins-frameworks/lightbox/js/lightbox.min.js"></script>
@endsection

@section('content')
<div class="clearfix"></div>

<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
<div class="container agenda-padding normal box-conteudo">
    <div class="agenda">
    <div class="row">
        <div class="topo-agenda">
          <div class="title-pages title-materia">Agenda</div>
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
                      <li><a href="{{url("/agenda/{$register->id}/{$register->title}")}}" title="Facebook" class="btSocialNetwork"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                      <li><a href="{{url("/agenda/{$register->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                      <li><a href="whatsapp://send?text={{$register->title}} - {{url("/agenda/{$register->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                  </ul>
              </div>
          </div>
        </div>
        <?php
            $date = $register->created_at;
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

            <div class="agendas">
                    <div class="calendario calendario-agenda calendario-agenda-agendas">
                        @if ( isset($register->calendario[0]) )
                            <div class="calendario-coluna">
                                <ul>
                                    <li>{{$register->calendario[0]['nomeDia']}}</li>
                                    <li>{{$register->calendario[0]['numeroDia']}}</li>
                                    <li>{{$register->calendario[0]['nomeMes']}}</li>
                                </ul>
                            </div>
                            @if( count($register->calendario) > 1 )
                            <div class="calendario-coluna">
                                <ul>
                                    <li><div class="divisao"></div></li>
                                    <li class="divisorLi">{{$register->calendario[1]}}</li>
                                    <li><div class="divisao"></div></li>
                                </uL>
                            </div>
                            <div class="calendario-coluna">
                                <ul>
                                    <li>{{$register->calendario[2]['nomeDia']}}</li>
                                    <li>{{$register->calendario[2]['numeroDia']}}</li>
                                    <li>{{$register->calendario[2]['nomeMes']}}</li>
                                </ul>
                            </div>
                            @endif
                        @else
                            <table class="calendario-vazio"><tr><td>&nbsp;</td></tr></table>
                        @endif
                    </div>

                    <div class="banner-texts">
                        <ul>
                            <li class="assuntos">{{$register->cartola or '&nbsp;'}}</li>
                            <li class="titles">{{$register->title or '&nbsp;'}}</li>
                            @if ($register->local != '')
                            <li class="">Local: {{$register->local or '&nbsp;'}}</li>
                            @endif
                            @if ($register->linha_apoio != '')
                            <li class="">{{$register->linha_apoio or '&nbsp;'}}</li>
                            @endif
                            <li class=""></li>
                        </ul>
                    </div>

            </div>

            <div class="clearfix"></div>
            <div class="paragrafos">
                <p>{{$register->linha_apoio}}</p>

                {!!$register->text!!}
            </div>
        </div>
    </div>
    </div>

    <!-- ======================================================================= -->
    <!-- vOLTAR                                                                  -->
    <!-- ======================================================================= -->
    <div class="container">
        <div class="row">
            <div id="bt-voltar" onClick='window.history.back();'></div>
        </div>
    </div>

</div>
@endsection
