@php
  $type = $return['typeMateria'];
  $titleListing = 'Listagem das matérias';
  $titleRegister = 'Cadastrar nova matéria';
  $materias = $return['materias'];

  switch ( $type )
  {
      case 'especial':
          $titleListing = 'Listagem das notícias especiais';
          $titleRegister = 'Cadastrar nova notícia especial';
          break;
      case 'normal':
          $titleListing = 'Listagem das notícias normais';
          $titleRegister = 'Cadastrar nova notícia normal';
          break;
      case 'coluna':
          $titleListing = 'Listagem das colunas';
          $titleRegister = 'Cadastrar nova coluna';
          break;
  }
@endphp

@extends('layouts.adm')

@section('css')
  <link rel="stylesheet" href="/plugins-frameworks/bootstrap-select-1.13.0/dist/css/bootstrap-select.css">
  <style>
    .card-header { cursor: pointer; }
    .text-secondary { padding: 8px; }
    .btns-listagem { padding-top: 3px; height: 40px; }
    .btns-listagem .btn { padding: 3px 8px 0px; }
    .col-form-label { word-wrap:normal; }
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
    }
  </style>
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins-frameworks/ckeditor/ckeditor.js"></script>
@endsection
@section('js')
    <script src="/js/pages/adm/materias.js"></script>
    <script src="/js/pages/adm/common.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="/plugins-frameworks/jquery.mask/v1.14.15/jquery.mask.min.js"></script>
@endsection

@section('content')

<form id="formIni" action="">
    <input type="hidden" name="type" value="{{$type}}" />
</form>

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
                    {{$titleRegister}}
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">
                            <input type="hidden" name="type" value="{{$type}}">

                            <div class="card-body">
                              <div class="row">
                                    <div class="col-md-12 text-right">
                                          <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="S">
                                              <label class="form-check-label" for="ativo"> Ativar Notícia </label>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          @if($type == 'coluna')
                                              <div class="form-row">
                                                  <label for="inputNome" class="col-sm-2 col-form-label">Colunista:*</label>
                                                  <select class="selectpicker has-img-linked is-invalid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione um colunista" name="colunista" required>
                                                      <option rel-img='{"class": "image-topo-da-materia", "path": "" }' value="">Selecione um colunista</option>
                                                        @php
                                                          $colunistas = $return['colunistas'];
                                                          $controlCategory = '';
                                                          $cont = 0;
                                                          $showFirtsList = 'show';
                                                          $img = '/images/default.png';
                                                        @endphp

                                                        @for ($i = 0; $i < count($colunistas); $i++)
                                                            <?php
                                                                $cont++;
                                                                if($cont > 1) { $showFirtsList = ''; }
                                                            ?>
                                                            @if($colunistas[$i]->category_name != $controlCategory)
                                                                @php
                                                                    $controlCategory = $colunistas[$i]->category_name;
                                                                @endphp
                                                                <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                                                            @endif

                                                            <option rel-img='{"class": "image-topo-da-materia", "path": "{{$colunistas[$i]->namefilefull}}" }' value="{{$colunistas[$i]->id}}" data-content="<img src='/{{$colunistas[$i]->path}}/_Mini/{{$colunistas[$i]->namefile}}'  height='25' alt='{{$colunistas[$i]->name}}'> {{$colunistas[$i]->name}}">{{$colunistas[$i]->name}}</option>

                                                            @if( isset($colunistas[$i+1]->category_name) )
                                                              @if( $colunistas[$i+1]->category_name != $controlCategory )
                                                                    </optgroup>
                                                              @endif
                                                            @else {{-- Rever Futuramente essas divs de fachamentos --}}
                                                                  </optgroup>
                                                            @endif
                                                        @endfor
                                                  </select>
                                                  <div class="box-img-ref-combobox">
                                                      <img src="{{$img}}" class="img-ref-combobox image-topo-da-materia" alt="Imagem do colunista" />
                                                  </div>
                                              </div>
                                          @endif

                                          <div class="form-row">
                                              <label for="inputNome" class="col-form-label">Data:</label>
                                              <input type="text" class="form-control form-control-sm input-data" placeholder="{{date("d/m/Y")}}" name="data">
                                          </div>

                                          <div class="form-row">
                                              <label for="inputNome" class="col-form-label">Cartola:*</label>
                                              <input type="text" class="form-control form-control-sm is-invalid" placeholder="Cartola. [max. 240 caracteres]" name="assunto" required>
                                          </div>

                                          <div class="form-row">
                                              <label for="inputNome" class="col-form-label">Título:*</label>
                                              <input type="text" class="form-control form-control-sm is-invalid" id="inputNome" placeholder="Nome. [max. 240 caracteres]" name="title" required>
                                          </div>

                                          <div class="form-row">
                                              <label for="inputSub_title" class="col-form-label">Linha de apoio:*</label>
                                              <input type="text" class="form-control form-control-sm is-invalid" id="inputSub_title" placeholder="Linha de apoio. [max. 240 caracteres]" name="subtitle" required>
                                          </div>

                                          <div class="form-row">
                                              <label for="inputGaleria" class="col-sm-2 col-form-label">Galeria:</label>
                                                <select class="form-control form-control-sm" name="galeria">
                                                    <option value="">Selecione uma galeria</option>
                                                @foreach ($return['galerias'] as $galeria)
                                                    <option value="{{ $galeria->id }}">{{Str::limit($galeria->title, 30, '...')}}</option>
                                                @endforeach
                                                </select>
                                          </div>

                                          <div class="form-row">
                                              <label for="inputJornalista" class="col-md-12 col-form-label">Jornalista Responsável:</label>
                                              <select class="selectpicker has-img-linked is-valid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione um colunista" name="jornalista">
                                                  <option rel-img='{"class": "image-topo-do-jornalista", "path": "" }' value="">Selecione um jornalista</option>
                                                    @php
                                                      $jornalistas = $return['jornalistas'];
                                                      $img = '/images/default.png';
                                                    @endphp

                                                    @for ($i = 0; $i < count($jornalistas); $i++)
                                                        <?php
                                                          $imgThumb = '/' . $jornalistas[$i]->path . '/_Mini/' . $jornalistas[$i]->namefile;
                                                            if ($jornalistas[$i]->path == '') {
                                                              $imgThumb = '/images/default.png';
                                                            }
                                                        ?>
                                                        <option rel-img='{"class": "image-topo-do-jornalista", "path": "{{$jornalistas[$i]->namefilefull}}" }' value="{{$jornalistas[$i]->id}}" data-content="<img src='{{$imgThumb}}'  height='25' alt='{{$jornalistas[$i]->name}}'> {{$jornalistas[$i]->name}}">{{$jornalistas[$i]->name}}</option>
                                                    @endfor
                                              </select>
                                              <div class="box-img-ref-combobox">
                                                  <img src="{{$img}}" class="img-ref-combobox image-topo-do-jornalista" alt="Imagem do jornanlista" />
                                              </div>
                                          </div>

                                          <div class="form-row">
                                              <label for="inpuTags" class="col-form-label">TAG's:</label>
                                              <input type="text" class="form-control form-control-sm" id="inpuTags" placeholder="Tags. [max. 240 caracteres]" name="tags" />
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                        @if($type != 'normal')
                                            <div class="form-row">
                                                <label for="inputNome" class="col-form-label backgroundbanner">Imagem Topo:*</label>
                                                <select id="avatar" class="selectpicker has-img-linked is-invalid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma imagem" name="backgroundbanner" required>
                                                    <option rel-img='{"class": "background-da-materia", "path": "" }' value="">Selecione uma imagem</option>
                                                      @php
                                                        $files = $return['files'];
                                                        $controlCategory = '';
                                                        $cont = 0;
                                                        $showFirtsList = 'show';
                                                        $img = '/images/default.png';
                                                      @endphp

                                                      @for ($i = 0; $i < count($files); $i++)
                                                          <?php
                                                              $cont++;
                                                              if($cont > 1) { $showFirtsList = ''; }
                                                          ?>
                                                          @if($files[$i]->category_name != $controlCategory)
                                                              @php
                                                                  $controlCategory = $files[$i]->category_name;
                                                              @endphp
                                                              <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                                                          @endif

                                                          <option rel-img='{"class": "background-da-materia", "path": "{{$files[$i]->namefilefull}}" }' value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>

                                                          @if( isset($files[$i+1]->category_name) )
                                                            @if( $files[$i+1]->category_name != $controlCategory )
                                                                  </optgroup>
                                                            @endif
                                                          @else {{-- Rever Futuramente essas divs de fachamentos --}}
                                                                </optgroup>
                                                          @endif
                                                      @endfor
                                                </select>
                                                <div class="box-img-ref-combobox">
                                                    <img src="{{$img}}" class="img-ref-combobox background-da-materia" alt="Imagem topo da matéria" />
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-row">
                                            <label for="inputNome" class="col-form-label">Imagem da Matéria:</label>
                                            <select id="avatar" class="selectpicker has-img-linked is-valid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma imagem para a matéria" name="image">
                                                <option rel-img='{"class": "imagem-da-materia", "path": "" }' value="">Selecione uma imagem para a matéria</option>
                                                @php
                                                  $files = $return['files'];
                                                  $controlCategory = '';
                                                  $cont = 0;
                                                  $showFirtsList = 'show';
                                                  $img = '/images/default.png';
                                                @endphp

                                                @for ($i = 0; $i < count($files); $i++)
                                                    @php
                                                        $cont++;
                                                        if($cont > 1) { $showFirtsList = ''; }
                                                    @endphp
                                                    @if($files[$i]->category_name != $controlCategory)
                                                        @php
                                                            $controlCategory = $files[$i]->category_name;
                                                        @endphp
                                                        <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                                                    @endif

                                                    <option rel-img='{"class": "imagem-da-materia", "path": "{{$files[$i]->namefilefull}}" }' value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>

                                                    @if( isset($files[$i+1]->category_name) )
                                                      @if( $files[$i+1]->category_name != $controlCategory )
                                                          </optgroup>
                                                      @endif
                                                    @else {{-- Rever Futuramente essas divs de fachamentos --}}
                                                        </optgroup>
                                                    @endif
                                                @endfor
                                            </select>
                                            <div class="box-img-ref-combobox">
                                                <img src="{{$img}}" class="img-ref-combobox imagem-da-materia" alt="Imagem da matéria" />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <label for="inputLegenda" class="col-sm-2 col-form-label">Legenda:</label>
                                            <textarea class="form-control form-control-sm" rows="4" id="inputLegenda" placeholder="Legenda." name="extra_text"></textarea>
                                        </div>

                                        <div class="form-row">
                                            <label for="inputVideo" class="col-sm-2 col-form-label">Vídeo:</label>
                                            <select id="avatar" class="selectpicker has-video-linked is-valid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione um vídeo para a matéria" name="video">
                                            @php
                                                $video = '<img src="/images/player-video.png" class="img-ref-combobox tv-adverso-video" alt="Vídeo" />';
                                            @endphp
                                                <option rel-video='{"class": "tv-adverso-video", "path": "" }' value="">Selecione um vídeo para a matéria</option>
                                            @foreach ($return['tvAdverso'] as $tvAdverso)
                                                <option rel-video='{"class": "tv-adverso-video", "path": "{{$tvAdverso->id_video}}" }' value="{{$tvAdverso->id}}" data-content="<img src='http://i1.ytimg.com/vi/{{$tvAdverso->id_video}}/default.jpg' height='25' alt='{{$tvAdverso->title}}'> {{$tvAdverso->title}}">{{$tvAdverso->title}}</option>
                                            @endforeach
                                            </select>
                                            <div class="box-img-ref-combobox">
                                                <div class="tv-adverso-video">{!!$video!!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="inputDescricao" class="col-md-12 col-form-label">Texto 1:</label>
                                    <div class="col-sm-12">
                                        <textarea id="text1" name="text1"></textarea>
                                        <script type="text/javascript">
                                            CKEDITOR.replace( 'text1' );
                                        </script>
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
                <div class="card-header">{{$titleListing}}</div>
                <div class="card-body">
                      @for ($i = 0; $i < count($materias); $i++)
                      <?php
                          $imagemInativa = '';
                          if ($materias[$i]->ativo == 'N' ) {
                              $imagemInativa = 'url(/images/imagemInativa.png), ';
                          }
                          $image = '/images/default.png';
                          if ($materias[$i]->fileBackground_namefile != '') {
                               $image = '/' .$materias[$i]->fileBackground_path. '/_Mini/' .$materias[$i]->fileBackground_namefile;
                          } elseif ($materias[$i]->namefile != '') {
                              $image = '/' .$materias[$i]->path. '/_Mini/' .$materias[$i]->namefile;
                          }

                          $data = date_create($materias[$i]->created_at);
                          $data = date_format($data, 'd/m/Y');

                          $type = 'edit-coluna';
                          if ($materias[$i]->type == 'normal') { $type = 'edit-noticia-normal'; }
                          if ($materias[$i]->type == 'especial') { $type = 'edit-noticia-especial'; }
                      ?>
                      {{-- ======================== Item listado =========================== --}}
                            <form action="/adm/materias/{{$type}}/{{$materias[$i]->id}}">
                                <div class="card border-secondary">
                                    <div class="card-body text-secondary">
                                        <div class="imagesList" style="background-image: {{$imagemInativa}} url({{$image}});"></div>
                                        <div style="float:right;" class="btns-listagem">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary edit" type="submit" title="Edita" relData="{{$data}}"><i class="material-icons i-corrige">mode_edit</i></button>
                                                <button class="btn btn-outline-secondary delete" type="button" rel="{{$materias[$i]->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                            </div>
                                        </div>
                                        <div style="float:left; margin-right:8px; padding-top:10px;">{{date('d/m/Y', strtotime($materias[$i]->created_at))}}</div>
                                        <div style="float:left; margin-right:8px; padding-top:10px;">{{$materias[$i]->title}}</div>
                                        {{-- <div style="float:left; margin-right:8px; padding-top:10px;">{{date('d/m/Y', strtotime($materias[$i]->created_at)) .' - '. $materias[$i]->title}}</div> --}}

                                    </div>
                                </div>
                            </form>
                      {{-- ======================== Item listado =========================== --}}
                      @endfor
                </div><!-- Fim card-body -->
              </div><!-- Fim card bg-light -->

        </div> <!-- Fim m12 -->
    </div> <!-- Fim row -->
</div> <!-- Fim container-fluid -->

<form id="form-delete" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" value="">
</form>

@endsection
