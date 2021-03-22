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
    .img-colunista { height: 250px; }
  </style>
@endsection

@section('js')
    <script src="/js/pages/adm/colunistas.js"></script>
    <script src="/js/pages/adm/common.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
@endsection

@section('content')

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <h5 class="text-center m-b-20"><strong>Erro ao concluir a requisição!</strong></h5>

  <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
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
                    Cadastrar novo colunista
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style="margin-bottom: 10px;">
                                            <img src="/images/default.png" alt="" class="img-fluid img-thumbnail img-colunista mx-auto d-block">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div style="clear:both;"></div>
                                        <div class="form-row">
                                            <label for="inputNome" class="col-sm-2 col-form-label">Avatar*</label>
                                            <select id="avatar" class="selectpicker has-img-linked is-invalid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma imagem para avatar" name="avatar" required>
                                                <option rel-img='{"class": "img-colunista", "path": "" }' value="">Selecione uma imagem para avatar</option>
                                                  @php
                                                    $files = $return['files'];
                                                    $controlCategory = '';
                                                    $cont = 0;
                                                    $showFirtsList = 'show';
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

                                                      <option rel-img='{"class": "img-colunista", "path": "{{$files[$i]->namefilefull}}" }' value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>

                                                      @if( isset($files[$i+1]->category_name) )
                                                        @if( $files[$i+1]->category_name != $controlCategory )
                                                              </optgroup>
                                                        @endif
                                                      @else {{-- Rever Futuramente essas divs de fachamentos --}}
                                                            </optgroup>
                                                      @endif
                                                  @endfor
                                            </select>
                                        </div>
                                        <div class="form-row">
                                            <label for="inputNome" class="col-sm-2 col-form-label">Nome*</label>
                                            <input type="text" class="form-control form-control-sm is-invalid" id="inputNome" placeholder="Nome. [max. 140 caracteres]" name="name" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="inputNome" class="col-sm-2 col-form-label">Categoria*</label>
                                            <select class="form-control form-control-sm is-invalid" name="category" required>
                                                <option value="">Selecione uma categoria</option>
                                              @foreach ($return['categorias'] as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                        <div class="form-row">
                                            <label for="inputDescricao" class="col-sm-2 col-form-label">Cargo*</label>
                                            <input type="text" class="form-control form-control-sm is-invalid" id="inputDescricao" placeholder="Cargo. [max. 240 caracteres]" name="cargo" required>
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
  <div class="card-header">Listagem dos colunistas</div>
  <div class="card-body">

      <div id="accordion">
        @php
          $colunistas = $return['colunistas'];
          $controlCategory = '';
          $cont = 0;
          $showFirtsList = 'show';
        @endphp

        @for ($i = 0; $i < count($colunistas); $i++)
            @php
                $cont++;
                if($cont > 1) { $showFirtsList = ''; }
            @endphp

            @if($colunistas[$i]->category_name != $controlCategory)
                @php
                    $controlCategory = $colunistas[$i]->category_name;
                @endphp
                <div class="card">
                  <div class="card-header" id="heading{{$cont}}" data-toggle="collapse" data-target="#collapse{{$cont}}" aria-expanded="true" aria-controls="collapse{{$cont}}">
                      <table><tr><td><i class="material-icons">apps</i></td><td>{{$colunistas[$i]->category_name}}</td></tr></table>
                  </div>
                  <div id="collapse{{$cont}}" class="collapse {{$showFirtsList}}" aria-labelledby="heading{{$cont}}" data-parent="#accordion">
                    <div class="card-body">
            @endif
            <!-- ==================================================================  -->
            <!-- ======================== Itens listados =========================== -->
            <!-- ==================================================================  -->
                  <div class="card border-secondary">
                    <div class="card-body text-secondary">
                      <div class="imagesList" style="background-image: url(/{{$colunistas[$i]->path}}/_Mini/{{$colunistas[$i]->namefile}});"></div>
                      <div style="float:right;" class="btns-listagem">
                          <div class="input-group-append">
                            <a href="/adm/edit-colunistas/{{$colunistas[$i]->id}}" class="btn btn-outline-secondary edit" type="button" title="Edita"><i class="material-icons i-corrige">mode_edit</i></a>
                            <button class="btn btn-outline-secondary delete" type="button" rel="{{$colunistas[$i]->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                          </div>
                      </div>
                      <div style="float:left; margin-right:8px; padding-top:10px;">{{$colunistas[$i]->name}}</div>

                    </div>
                  </div>
            <!-- ==================================================================  -->
            <!-- ======================== Itens listados =========================== -->
            <!-- ==================================================================  -->
            @if( isset($colunistas[$i+1]->category_name) )
              @if( $colunistas[$i+1]->category_name != $controlCategory )
                    </div>
                  </div>
                </div>
              @endif
            @else <!-- Rever Futuramente essas divs de fachamentos -->
                  </div>
                </div>
              </div>
            @endif
        @endfor
      </div> <!-- Fim acordion -->

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
