@php
  $registers = $return['registers'];
@endphp

@extends('layouts.adm')

@section('css')
  <link rel="stylesheet" href="/plugins-frameworks/bootstrap-select-1.13.0/dist/css/bootstrap-select.css">
  <style>
    .card-header { cursor: pointer; }
    .card .border-secondary { margin: 5px 0; }
    .text-secondary { padding: 8px; }
    .btns-listagem { padding-top: 3px; height: 40px; }
    .btns-listagem .btn { padding: 3px 8px 0px; }
    .col-form-label { word-wrap:normal; }
    .imagesList:hover {
        box-shadow: inset 0px 0px 0px 4px #005086;
        opacity: 0.8;
        transition: 0.3s ease-out;
        cursor: pointer;
    }
    .imagesList {
        width: 80px;
        height: 40px;
        float: left;
        margin-right: 8px;
        background-position: center !important;
        -webkit-background-size: cover !important;
        -moz-background-size: cover !important;
        -o-background-size: cover !important;
        background-size: cover !important;
        cursor: pointer;
        opacity: 1;
        box-shadow: inset 0px 0px 0px 0px #005086;
        transition: 0.3s;
    }
    .explicacao {
        font-size: 0.8em;
        line-height: 1.1em;
        color: #888;
        margin-top: 3px;
    }
    .italico { font-style: italic; text-decoration: underline; }
    .idNegrito { color: black; font-weight: bold; font-style: normal; text-decoration: underline; }
  </style>
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins-frameworks/ckeditor/ckeditor.js"></script>
@endsection
@section('js')
    <script src="/js/pages/adm/tv-adverso.js"></script>
    <script src="/js/pages/adm/common.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
@endsection

@section('content')

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <h5 class="text-center m-b-20"><strong>Erro ao concluir a requisição!</strong></h5>

  <ul>
      @foreach ($errors->all() as $error)
          <li>{!! $error !!}</li>
      @endforeach
  </ul>

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 m-b-40">
            <p>
                <button class="btn btn-outline-primary btn-block" type="button" data-toggle="collapse" data-target="#register" aria-expanded="false" aria-controls="register">
                    Cadastrar novo vídeo
                </button>
            </p>
            <div id="register" class="collapse">
                    <div id="register" class="card">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">
                            <div class="card-body">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-row">
                                          <label for="inputTitle" class="col-sm-12 col-form-label">Título*</label>
                                          <input type="text" class="form-control form-control-sm is-invalid" id="inputTitle" placeholder="Nome. [max. 240 caracteres]" name="title" required>
                                      </div>

                                      <div class="form-row">
                                          <label for="inputDescricao" class="col-sm-12 col-form-label">Descrição</label>
                                          <textarea class="form-control form-control-sm" rows="4" id="inputDescricao" placeholder="Descrição." name="description"></textarea>
                                      </div>
                                  </div>

                                  <div class="col-md-6">
                                      @php
                                          $video = '<img src="/images/player-video.png" class="img-ref-combobox adufrgs-no-ar-video" alt="Vídeo" />';
                                      @endphp
                                      <div class="form-row mb-1">
                                          <label for="inputIdVideo" class="col-sm-12 col-form-label">ID do Vídeo*</label>
                                          <input type="text" rel-video='{"class": "adufrgs-no-ar-video", "path": "" }' class="form-control has-adufrgs-no-ar-linked form-control-sm is-invalid" id="inputIdAdufrgsNoAr" placeholder="Id do vídeo. [max. 240 caracteres]" name="idVideo" required>
                                          <div class="explicacao">O ID de um vídeo é a última parte do link comum de um vídeo.<br />Exemplo: <span class="italico">https://www.youtube.com/watch?time_continue=8&v=<span class="idNegrito">M7lc1UVf-VE</span></span> (o ID é apenas a parte em negrito).</div>
                                      </div>
                                      <div class="box-img-ref-combobox">
                                          <div class="adufrgs-no-ar-video">{!!$video!!}</div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <div class="card-footer text-muted">
                                <button type="submit" class="btn btn-outline-success btn-block">Cadastrar</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

              <!-- Conteiner da listagem -->
              <div class="card bg-light">
                <div class="card-header">Listagem dos Vídeos</div>
                <div class="card-body">
                      <!-- ==================================================================  -->
                      <!-- ======================== Itens listados =========================== -->
                      <!-- ==================================================================  -->
                      @forelse ($registers as $register)
                          @if ($loop->first)
                              @php
                              $ativo = 'disabled';
                              @endphp
                          @else
                              @php
                              $ativo = '';
                              @endphp
                          @endif
                          <div class="card border-secondary">
                            <div class="card-body text-secondary">
                                  <div class="imagesList" rel="{{$register->id_video}}" style="background-image: url(http://i1.ytimg.com/vi/{{$register->id_video}}/default.jpg);"></div>
                                  <div style="float:right;" class="btns-listagem">
                                      <div class="input-group-append">
                                        <?php
                                            $registerJson = json_encode($register, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                                        ?>
                                        <button class="btn btn-outline-secondary order" type="button" title="Edita" rel="{{$register->id}}" {{$ativo}}><i class="material-icons">vertical_align_top</i></button>
                                        <button class="btn btn-outline-secondary edit" type="button" title="Edita" rel="{{$registerJson}}"><i class="material-icons i-corrige">mode_edit</i></button>
                                        <button class="btn btn-outline-secondary delete" type="button" rel="{{$register->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                      </div>
                                  </div>
                                  <div style="float:left; margin-right:8px; padding-top:10px;">{{$register->title}}</div>
                            </div>
                          </div>
                      @empty
                          <p>Nenhum vídeo cadastrado no momento.</p>
                      @endforelse
                      <!-- ==================================================================  -->
                      <!-- ======================== Itens listados =========================== -->
                      <!-- ==================================================================  -->
                </div><!-- Fim card-body -->
              </div><!-- Fim card bg-light -->

        </div> <!-- Fim m12 -->
    </div> <!-- Fim row -->
</div> <!-- Fim container-fluid -->


<!-- ======================================================================  -->
<!-- =========================== MODAL ===================================== -->
<!-- ======================================================================  -->
<div id="modalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="edit" class="modal-dialog modal-lg">
    <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Vídeo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="">

                <div class="modal-body">

                    <div style="clear:both;"></div>

                    <div class="box-img-ref-combobox">
                      <!-- <div class="iframe embed-responsive embed-responsive-16by9" style="margin-bottom: 10px;"></div> -->
                        <div class="adufrgs-no-ar-video-modal">{!!$video!!}</div>
                    </div>
                    <div class="form-row mb-1">
                        <label for="inputIdVideo" class="col-sm-12 col-form-label">ID do Vídeo*</label>
                        <input type="text" rel-video='{"class": "adufrgs-no-ar-video-modal", "path": "" }' class="form-control has-adufrgs-no-ar-linked form-control-sm is-invalid" id="inputIdAdufrgsNoAr" placeholder="Id do vídeo. [max. 240 caracteres]" name="idVideo" required>
                        <div class="explicacao">O ID de um vídeo é a última parte do link comum de um vídeo.<br />Exemplo: <span class="italico">https://www.youtube.com/watch?time_continue=8&v=<span class="idNegrito">M7lc1UVf-VE</span></span> (o ID é apenas a parte em negrito).</div>
                    </div>

                    <div class="form-row">
                        <label for="inputTitle" class="col-sm-12 col-form-label">Título*</label>
                        <input type="text" class="form-control form-control-sm is-invalid" id="inputTitle" placeholder="Nome. [max. 240 caracteres]" name="title" required>
                    </div>

                    <div class="form-row">
                        <label for="inputDescricao" class="col-sm-12 col-form-label">Descrição</label>
                        <div class="col-sm-12">
                            <textarea class="form-control form-control-sm" rows="4" id="inputDescricao" placeholder="Descrição." name="description"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
                    <button type="submit" class="btn btn-outline-success btn-block">Atualizar</button>
                </div>
          </form>
      </div>
  </div>
</div>


<div id="modalImage" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="edit" class="modal-dialog modal-lg">
    <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Thumb do Vídeo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
              <div style="margin-bottom: 10px;">
                <img src="" alt="" id="imageThumb" class="img-fluid img-thumbnail img-modal mx-auto d-block">
              </div>
              <div style="clear:both;"></div>
          </div>
      </div>
  </div>
</div>

<form id="form-order" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="">
    <input type="hidden" name="action" value="order">
</form>

<form id="form-delete" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" value="">
</form>

@endsection
