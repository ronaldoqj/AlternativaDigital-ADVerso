<?php
  $texto = $return['texto'];
  $agendas = $return['listAgenda'];
  $cont = 0;
?>

@extends('layouts.site')

@section('css')
    <link href="/css/pages/agendas.css" type="text/css" rel="stylesheet" media="screen,projection"/>
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

@section('content')
<div class="clearfix"></div>
<div class="container">
    <div class="title-outros-agendas m-t-25 m-b-10">Agendas</div>
    {!!$texto->text ?? '<div class="m-b-40"></div>'!!}
</div>

<!-- Agendas-->
<div class="container m-t-50">
    <div class="row">

          @foreach ($agendas as $item)
          @if($cont == 1)
              @php
                  $rightLeft = 'outro-spaco-left';
                  $cont = 0;
              @endphp
          @else
              @php
                  $rightLeft = 'outro-spaco-right';
                  $img = '/images/default.png';
                  if ($item->namefilefull != '') {
                    $img = '/'.$item->namefilefull;
                  }
              @endphp
          @endif
            <div class="col s12 m12 l6 outro {{$rightLeft}}">
                  <div class="item agendas" style="background: color: white;">

                      <a href="/agenda/{{$item->id}}/{{Str::slug($item->title, '-')}}">
                          <div class="agenda-container">
                              <div class="calendario calendario-agenda calendario-agenda-agendas">
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
                                  <div>{{$item->cartola}}</div>
                                  <div class="text-page-agendas">
                                      <p class="title">{{$item->title}}</p>
                                      <p class="local">Local: {{$item->local}}</p>
                                      <!-- <p class="linha_apoio">{{$item->linha_apoio}}</p> -->
                                  </div>
                              </div>
                              <div class="clearfix"></div>
                          </div>
                      </a>

                  </div>
              </div>
          @endforeach
          <div class="clearfix"></div>
    </div>

</div>
@endsection
