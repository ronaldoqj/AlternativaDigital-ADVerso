<?php
  $registers = $return['jornalistas'];
?>

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
    .img-jornalista { height: 250px; }
  </style>
@endsection

@section('js')
    <script src="/js/pages/adm/jornalistas.js"></script>
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
                    Cadastrar novo jornalista
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
                                          <img src="/images/default.png" alt="" class="img-fluid img-thumbnail img-jornalista mx-auto d-block">
                                        </div>
                                        <div style="clear:both;"></div>
                                        <div class="form-row">
                                            <label for="inputNome" class="col-sm-2 col-form-label">Avatar</label>
                                            <select id="avatar" class="selectpicker has-img-linked form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma imagem para avatar" name="avatar">
                                                <option rel-img='{"class": "img-jornalista", "path": "" }' value="">Selecione uma imagem para avatar</option>
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
                                                            <option rel-img='{"class": "img-jornalista", "path": "{{$files[$i]->namefilefull}}" }' value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>
                                                      @if( isset($files[$i+1]->category_name) )
                                                        @if( $files[$i+1]->category_name != $controlCategory )
                                                              </optgroup>
                                                        @endif
                                                      @else <!-- Rever Futuramente essas divs de fachamentos -->
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
                                            <label for="inputDescricao" class="col-sm-2 col-form-label">Cargo</label>
                                            <input type="text" class="form-control form-control-sm" id="inputDescricao" placeholder="Cargo. [max. 240 caracteres]" name="cargo">
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


<!-- Conteiner da listagem -->
<?php /*
<div class="card bg-light">
  <div class="card-header">Listagem dos jornalistas</div>
  <div class="card-body">

        @php
          $jornalistas = $return['jornalistas'];
          $cont = 0;
          $showFirtsList = 'show';
        @endphp

        @for ($i = 0; $i < count($jornalistas); $i++)

            <!-- ==================================================================  -->
            <!-- ======================== Itens listados =========================== -->
            <!-- ==================================================================  -->
                      <div class="imagesList" style="background-image: url(/{{$jornalistas[$i]->path}}/_Mini/{{$jornalistas[$i]->namefile}});"></div>
                      <div style="float:right;" class="btns-listagem">
                          <div class="input-group-append">
                            <a href="/adm/edit-jornalistas/{{$jornalistas[$i]->id}}" class="btn btn-outline-secondary edit" type="button" title="Edita"><i class="material-icons i-corrige">mode_edit</i></a>
                            <button class="btn btn-outline-secondary delete" type="button" rel="{{$jornalistas[$i]->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                          </div>
                      </div>
                      <div style="float:left; margin-right:8px; padding-top:10px;">{{$jornalistas[$i]->name}}</div>
            <!-- ==================================================================  -->
            <!-- ======================== Itens listados =========================== -->
            <!-- ==================================================================  -->
        @endfor


        </div> <!-- Fim m12 -->
    </div> <!-- Fim row -->
*/ ?>





    <div class="row">
        <div class="col-md-12">

              <!-- Conteiner da listagem -->
              <div class="card bg-light">
                <div class="card-header">Listagem dos jornalistas</div>
                <div class="card-body">
                      <!-- ==================================================================  -->
                      <!-- ======================== Itens listados =========================== -->
                      <!-- ==================================================================  -->
                      @forelse ($registers as $register)
                          <?php
                              $img = '/images/default.png';
                              if($register->path != '') {
                                  $img = '/' . $register->path . '/_Mini/' . $register->namefile;
                              }
                          ?>
                          <div class="card border-secondary">
                            <div class="card-body text-secondary">
                                  <div class="imagesList" style="background-image: url({{$img}});"></div>
                                  <div style="float:right;" class="btns-listagem">
                                      <div class="input-group-append">
                                        <a href="/adm/edit-jornalistas/{{$register->id}}" class="btn btn-outline-secondary edit" type="button" title="Edita"><i class="material-icons i-corrige">mode_edit</i></a>
                                        <button class="btn btn-outline-secondary delete" type="button" rel="{{$register->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                      </div>
                                  </div>
                                  <div style="float:left; margin-right:8px; padding-top:10px;">{{$register->name}}</div>
                            </div>
                          </div>
                      @empty
                          <p>Nenhum jornalista cadastrado no momento.</p>
                      @endforelse
                      <!-- ==================================================================  -->
                      <!-- ======================== Itens listados =========================== -->
                      <!-- ==================================================================  -->
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
