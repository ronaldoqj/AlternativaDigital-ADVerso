<?php
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Usuário - Login e Senha
                </div>
                <form action="" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="action" value="edit" />
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <label for="inputName" class="col-sm-12 col-form-label">Usuário:*</label>
                                    <input type="text" class="form-control form-control-sm" id="inputName" placeholder="Nome. [max. 190 caracteres]" maxlength="190" name="name" value="{{ Auth::user()->name }}" required />
                                </div>
                                <div class="form-row">
                                    <label for="inputFuncao" class="col-sm-12 col-form-label">Cargo:</label>
                                    <input type="text" class="form-control form-control-sm" id="inputFuncao" placeholder="Cargo. [max. 190 caracteres]" maxlength="190" name="funcao" value="{{ Auth::user()->funcao }}" />
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
                                                $selected = '';

                                                if($cont > 1) { $showFirtsList = ''; }
                                                if (Auth::user()->image == $files[$i]->id) {
                                                    $selected = 'selected';
                                                    $img = '/'.$files[$i]->namefilefull;
                                                }
                                            ?>

                                            @if($files[$i]->category_name != $controlCategory)
                                                @php
                                                    $controlCategory = $files[$i]->category_name;
                                                @endphp
                                                <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                                            @endif
                                                <option {{$selected}} rel-img='{"class": "avatar-do-usuario", "path": "{{$files[$i]->namefilefull}}" }' value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>
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
                                    <label for="inputTitle" class="col-sm-12 col-form-label">E-Mail/Login:*</label>
                                    <input type="email" class="form-control form-control-sm" id="inputTitle" placeholder="E-Mail/Login. [max. 190 caracteres]" name="email" value="{{ Auth::user()->email }}" required />
                                </div>
                                <div class="form-row">
                                    <label for="inputTitle" class="col-sm-12 col-form-label">Nova Senha:*</label>
                                    <input type="text" class="form-control form-control-sm" id="inputTitle" placeholder="Nome. [max. 190 caracteres]" name="password" value="" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                      <button type="Atualizar" class="btn btn-outline-success btn-block">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
