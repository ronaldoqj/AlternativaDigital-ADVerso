<?php
  $registers = $return['usuarios'];
  $files = $return['files'];
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
    </style>
@endsection

@section('js')
    <script src="/js/pages/adm/common.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
@stop
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
                    Cadastrar novo usuário
                </button>
            </p>
            <div id="register" class="collapse">
                    <div id="register" class="card">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="S" checked>
                                            <label class="form-check-label" for="ativo"> Ativo </label>
                                        </div>

                                        <div class="form-row">
                                            <label for="inputTitle" class="col-sm-12 col-form-label">Nome do úsuario:*</label>
                                            <input type="text" class="form-control form-control-sm" id="inputTitle" placeholder="Nome. [max. 190 caracteres]" maxlength="190" name="name" value="" required />
                                        </div>

                                        <div class="form-row">
                                            <label for="inputFuncao" class="col-sm-12 col-form-label">Cargo:</label>
                                            <input type="text" class="form-control form-control-sm" id="inputFuncao" placeholder="Cargo. [max. 190 caracteres]" maxlength="190" name="funcao" value="" />
                                        </div>

                                        <div class="form-row">
                                            <label for="inputImage" class="col-md-12 col-form-label">Avatar:</label>
                                            <select class="selectpicker has-img-linked is-valid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma imagem de avatar" name="image">
                                                <option rel-img='{"class": "avatar-do-usuario", "path": "" }' value="">Selecione uma imagem de avatar</option>
                                                @php
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
                                                        <option rel-img='{"class": "avatar-do-usuario", "path": "{{$files[$i]->namefilefull}}" }' value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>
                                                    @if( isset($files[$i+1]->category_name) )
                                                      @if( $files[$i+1]->category_name != $controlCategory )
                                                          </optgroup>
                                                      @endif
                                                    @else <!-- Rever Futuramente essas divs de fachamentos -->
                                                          </optgroup>
                                                    @endif
                                                @endfor
                                            </select>
                                            <div class="box-img-ref-combobox">
                                                <img src="{{$img}}" class="img-ref-combobox avatar-do-usuario" alt="Imagem do jornanlista" />
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <label for="inputGaleria" class="col-sm-2 col-form-label">Tipo de Usuário:</label>
                                              <select class="form-control form-control-sm" name="type" required>
                                                  <option value="">Selecione o Tipo de Usuario</option>
                                                  <option value="normal">Normal</option>
                                                  <option value="master">Master</option>
                                              </select>
                                        </div>


                                        <div class="form-row">
                                            <label for="inputTitle" class="col-sm-12 col-form-label">E-Mail/Login:*</label>
                                            <input type="email" class="form-control form-control-sm" id="inputTitle" placeholder="E-Mail/Login. [max. 190 caracteres]" maxlength="190" name="email" value="" required />
                                        </div>
                                        <div class="form-row">
                                            <label for="inputTitle" class="col-sm-12 col-form-label">Senha:*</label>
                                            <input type="text" class="form-control form-control-sm" id="inputTitle" placeholder="Nome. [max. 190 caracteres]" maxlength="190" name="password" value="" required />
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
                <div class="card-header">Listagem dos usuários</div>
                <div class="card-body">
                      @forelse ($registers as $register)
                          @if ($register->hide != 'S')
                              <?php
                                  $imagemInativa = '';
                                  if ($register->ativo == 'N' ) {
                                      $imagemInativa = 'url(/images/imagemInativa.png), ';
                                  }
                                  $img = '/images/default.png';
                                  if ($register->namefilefull != '') {
                                      $img = '/' . $register->namefilefull;
                                  }
                              ?>
                              <div class="card border-secondary">
                                <div class="card-body text-secondary">
                                      <div class="imagesList" rel="{{$register->id}}" style="background-image: {{$imagemInativa}} url({{$img}});"></div>
                                      <div style="float:right;" class="btns-listagem">
                                          <div class="input-group-append">
                                            <a href="/adm/usuarios/edit/{{$register->id}}" class="btn btn-outline-secondary edit" type="button" title="Edita"><i class="material-icons i-corrige">mode_edit</i></a>
                                          </div>
                                      </div>
                                      <div style="float:left; margin-right:8px; padding-top:10px;">{{$register->name}}</div>
                                </div>
                              </div>
                          @endif
                      @empty
                          <p>Nenhum vídeo usuário extra cadastrado no momento.</p>
                      @endforelse
                </div><!-- Fim card-body -->
              </div><!-- Fim card bg-light -->

        </div> <!-- Fim m12 -->
    </div> <!-- Fim row -->
</div> <!-- Fim container-fluid -->
@endsection
