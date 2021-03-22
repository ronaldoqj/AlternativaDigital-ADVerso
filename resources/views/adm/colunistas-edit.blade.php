<?php
   $register = $return['colunista'];
   $categorias = $return['categorias'];
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
        <div class="col-md-12 m-b-10">
            <a class="btn btn-outline-dark btn-sm" href="/adm/colunistas" role="button">Voltar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 m-b-40">
            <div class="card">
                <form action="" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="action" value="edit">
                      <input type="hidden" name="id" value="{{$register->id}}">
                      <div class="card-body">
                          <div style="margin-bottom: 10px;">
                            <img src="/{{$register->namefilefull}}" alt="" class="img-fluid img-thumbnail img-colunista mx-auto d-block">
                          </div>
                          <div style="clear:both;"></div>

                          <div class="form-row">
                              <label for="inputNome" class="col-sm-2 col-form-label">Avatar*</label>
                              <select id="acompanhamentosCadastrar" class="selectpicker has-img-linked is-invalid form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma imagem para avatar" name="avatar" required>
                                  <option rel-img='{"class": "img-colunista", "path": "" }' value="">Selecione uma imagem para avatar</option>
                                    <?php
                                      $controlCategory = '';
                                      $cont = 0;
                                      $showFirtsList = 'show';
                                    ?>

                                    @for ($i = 0; $i < count($files); $i++)
                                        <?php
                                            $cont++;
                                            if($cont > 1) { $showFirtsList = ''; }
                                            $selected = '';
                                            if($register->avatar == $files[$i]->id) {
                                                $selected = 'selected';
                                            }
                                        ?>
                                        @if($files[$i]->category_name != $controlCategory)
                                            @php
                                                $controlCategory = $files[$i]->category_name;
                                            @endphp
                                            <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                                        @endif
                                              <option {{$selected}} rel-img='{"class": "img-colunista", "path": "{{$files[$i]->namefilefull}}" }' value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->namefilefull}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>
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
                              <label for="inputNome" class="col-sm-2 col-form-label">Categoria*</label>
                              <select class="form-control form-control-sm is-invalid" name="category" required>
                                  <option value="">Selecione uma categoria</option>
                                  @foreach ($categorias as $categoria)
                                      <?php
                                          $selected = '';
                                          if ($register->category == $categoria->id) {
                                              $selected = 'selected';
                                          }
                                      ?>
                                      <option {{$selected}} value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-row">
                              <label for="inputNome" class="col-sm-2 col-form-label">Nome*</label>
                              <input type="text" class="form-control form-control-sm is-invalid" id="inputNome" placeholder="Nome. [max. 140 caracteres]" name="name" value="{{$register->name}}" required>
                          </div>
                          <div class="form-row">
                              <label for="inputDescricao" class="col-sm-2 col-form-label">Cargo*</label>
                              <input type="text" class="form-control form-control-sm is-invalid" id="inputDescricao" placeholder="Cargo. [max. 240 caracteres]" name="cargo" value="{{$register->cargo}}" required>
                          </div>
                      </div>

                      <div class="modal-footer">
                          <button type="submit" class="btn btn-outline-success btn-block">Atualizar</button>
                      </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="form-delete" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" value="">
</form>

@endsection
