<?php
    $registers = $return['registers'];
    $texto = $return['texto'];
    $leftRight = 'outra-spaco-left';
?>

@extends('layouts.site')

@section('css')
    <link href="/css/pages/adufrgs-no-ar.css" type="text/css" rel="stylesheet" media="screen,projection"/>
@endsection

@section('js')
    <script src="/js/pages/adufrgs-no-ar.js"></script>
@endsection

@section('content')

<!-- Modal Structure -->
  <div id="modalVideos" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="video-container responsive-video">
        </div>
    </div>
    <!-- <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
    </div> -->
  </div>


<!-- ======================================================================= -->
<!-- TV Adverso                                                              -->
<!-- ======================================================================= -->
<div class="container-fluid galeria">
    <div class="container m-t-50 box-conteudo">
        <div class="row">

            <div class="title-pages">Adufrgs No Ar</div>
            {!!$texto->text ?? '<div class="m-b-40"></div>'!!}

            @forelse ($registers as $register)
                <div class="col m12 l6 outra {{$leftRight}}" rel="{{json_encode($register, true)}}">
                    <div class="box-noticia">
                        <div class="noticia-img" style="background: url(/images/player-video.png), url(http://i1.ytimg.com/vi/{{$register->id_video}}/hqdefault.jpg);">
                        </div>
                    </div>
                    <div class="descricao-galeria">
                        <!-- <p class="titles">{{Str::limit($register->title  .' '. $register->title, 35, '...')}}</p> -->
                        <br>
                        <p class="subtitles">{{Str::limit($register->description, 500, '')}}</p>
                    </div>
                </div>
                <?php
                    if ( $leftRight == 'outra-spaco-left' ) {
                        $leftRight = 'outra-spaco-right';
                    } else {
                        $leftRight = 'outra-spaco-left';
                    }
                ?>
            @empty
                <p>Nenhum vídeo cadastrado no momento.</p>
            @endforelse

        </div>
        <!--
        <div class="container text-center">
            <div class="title-carregar-mais">Carregar mais vídeos</div>
        </div>
         -->
    </div>
</div>

@endsection
