<?php
  $registers = $return['revistas'];
  $files = $return['files'];
  $revistaHasImagem = $return['revistaHasImagem'];
  $cont = 0;
  $contI = 0;
  $controlCategory = '';
  $showFirtsList = 'show';
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
    .list-group-flush .list-group-item {
        z-index: 2;
    }
    .editRevista { padding: 0;}
    .thumbs {
        width: 102px;
        /* border: solid 1px #999; */
        /* border-radius: 3px; */
        float: left;
        margin: 8px;
        /* padding: 3px; */

    }
    .btnThumbs {
        font-size: 0px;
        padding: 3px 13px 6px;
    }
    .btnThumbsImages {
        font-size: 0px;
        padding: 0px 4px 5px;
    }
    .inputThumb {
        width: 250px;
    }

  </style>
@endsection
@section('js')
    <script src="/js/pages/adm/adverso.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
@endsection

@section('content')

<!-- Large modal -->
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
                    Cadastrar Revista
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card">
                        <form id="form-register" action="" method="post" enctype="multipart/form-data" class="was-validated">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">
                            <input type="hidden" name="imagens" value="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <label for="inputNome" class="col-md-12 col-form-label">Nome da Revista:*</label>
                                            <input type="text" name="title" class="form-control form-control-sm is-invalid" placeholder="Nome da Revista. [max. 240 caracteres]" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="inputImagens">Imagens:</label>
                                            <select id="selectImagens" class="selectpicker is-valid form-control form-control-sm" data-live-search="true" data-actions-box="true" multiple title="Selecione Imagens">
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
                                                          <option value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>
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
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                <button type="submit" class="btn btn-outline-success btn-block register-galery">Cadastrar Revista</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

    @php
        $cont = 0;
    @endphp

    <!-- Conteiner da listagem -->
    <div class="card bg-light">
        <div class="card-header">Listagem das Revistas</div>
        <div class="card-body">

            <div id="accordion">
              @forelse ($registers as $register)
              {{--dd($registers)--}}
                  @php
                      $cont++;
                      if($cont > 1) { $showFirtsList = ''; }
                  @endphp
                  @if ($loop->first)
                      @php
                          $ativo = 'disabled';
                      @endphp
                  @else
                      @php
                          $ativo = '';
                      @endphp
                  @endif

                  <div class="card">
                      <div class="card-header" id="heading{{$cont}}" data-toggle="collapse" data-target="#collapse{{$cont}}" aria-expanded="true" aria-controls="collapse{{$cont}}">
                          <div style="float: right;">
                              <button class="btn btn-outline-secondary ordenar-revistas btnThumbs" type="button" title="Ordenar" rel="{{$register->id}}" {{$ativo}}><i class="material-icons">vertical_align_top</i></button>
                              <button class="btn btn-outline-secondary delete-revista btnThumbs" type="button" title="Deletar Revista" rel="{{$register->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                          </div>
                          <table><tr><td style="padding-top: 3px;"><i class="material-icons">photo_library</i></td><td>{{$register->title}}</td><td></td></tr></table>
                      </div>
                      <div id="collapse{{$cont}}" class="collapse {{--$showFirtsList--}}" aria-labelledby="heading{{$cont}}" data-parent="#accordion">
                          <div class="card-body">
                            <!-- ==================================================================  -->
                            <!-- ======================== Editar Revista =========================== -->
                            <!-- ==================================================================  -->
                                <div class="col-md-12 m-b-20 editRevista">
                                    <button class="btn btn-outline-primary btn-block" type="button" data-toggle="collapse" data-target="#registerEditar{{$cont}}" aria-expanded="false" aria-controls="register">
                                        Editar revista
                                    </button>
                                    <div id="registerEditar{{$cont}}" class="collapse">
                                            <div class="card">
                                                <form id="form-edit{{$register->id}}" action="" method="post" enctype="multipart/form-data" class="was-validated">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{$register->id}}">
                                                    <input type="hidden" name="action" value="edit">
                                                    <input type="hidden" name="imagens" value="">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-row">
                                                                    <label for="inputNome" class="col-md-12 col-form-label">Nome da Revista:*</label>
                                                                    <input type="text" name="title" class="form-control form-control-sm form-control-md is-invalid" placeholder="Nome da Revista. [max. 240 caracteres]" value="{{$register->title}}" required>
                                                                </div>

                                                                <div class="form-row">
                                                                    <label for="inputImagens">Adicionar Imagens:</label>
                                                                    <select id="selectImagens" class="selectpicker is-valid form-control form-control-sm" data-live-search="true" data-actions-box="true" multiple title="Selecione Imagens">
                                                                        @for ($i = 0; $i < count($files); $i++)
                                                                            <?php $marcado = ''; ?>
                                                                            @foreach ($revistaHasImagem as $item)
                                                                                @if($item->revistas_has_imagem_id_revista == $register->id)
                                                                                <?php if ($files[$i]->id == $item->id) { $marcado = 'selected'; } ?>
                                                                                @endif()
                                                                            @endforeach

                                                                            @if($files[$i]->category_name != $controlCategory)
                                                                                @php
                                                                                    $controlCategory = $files[$i]->category_name;
                                                                                @endphp
                                                                                <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                                                                            @endif
                                                                                <option {{$marcado}} value="{{$files[$i]->id}}" data-content="<img src='/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}}'  height='25' alt='{{$files[$i]->name}}'> {{$files[$i]->name}}">{{$files[$i]->name}}</option>
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
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="card-footer text-muted">
                                                        <button type="submit" class="btn btn-outline-success btn-block edit-revista" rel="{{$register->id}}">Editar Revista</button>
                                                    </div>
                                                </form>
                                            </div>
                                    </div>
                                </div>
                              <!-- ==================================================================  -->
                              <!-- ======================== Itens listados =========================== -->
                              <!-- ==================================================================  -->
                              <div class="card border-secondary">
                                  <div class="card-body text-secondary">


                                    <!-- <div class="card-columns"> -->
                                    <div class="box-thumbs">
                                    @foreach ($revistaHasImagem as $file)

                                    {{--dd($file)--}}
                                        @if($file->revistas_has_imagem_id_revista == $register->id)
                                            @php
                                                $contI++;
                                                if($contI > 1) { $showFirtsListI = ''; }
                                            @endphp
                                            @if ($loop->first)
                                                @php
                                                    $ativoI = 'disabled';
                                                @endphp
                                            @else
                                                @php
                                                    $ativoI = '';
                                                @endphp
                                            @endif
                                            <div class="thumbs">
                                                <img src="/{{$file->path .'/_Mini/'. $file->namefile}}" alt="{{$file->namefile}}" title="" alt="{{$file->namefile}}" class="rounded img-fluid">
                                                <div>
                                                    <button class="btn btn-outline-secondary btnThumbsImages order-image"  type="button" title="Ordenar imagem"        rel="{{$file->revistas_has_imagem_id}}" rel2="{{$register->id}}" {{$ativoI}}><i class="material-icons">reply</i></button>
                                                    <button class="btn btn-outline-secondary btnThumbsImages edit-image"   type="button" title="Editar link da imagem" rel="{{$file->revistas_has_imagem_id}}"><i class="material-icons i-corrige">mode_edit</i></button>
                                                    <button class="btn btn-outline-secondary btnThumbsImages delete-image" type="button" title="Excluir Imagem"        rel="{{$file->revistas_has_imagem_id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control form-control-sm inputNomeImagem inputLinkImagem" aria-label="Nome da imagem" value="{{$file->revistas_has_imagem_link}}" placeholder="Link" />
                                                </div>
                                            </div>


                                        @endif
                                    @endforeach
                                    </div>

                                  </div>
                              </div>
                              <!-- ==================================================================  -->
                              <!-- ======================== Itens listados =========================== -->
                              <!-- ==================================================================  -->
                          </div>
                      </div>
                  </div>
              @empty
                  <p>Nenhuma revista cadastrada no momento.</p>
              @endforelse
            </div> <!-- Fim acordion -->

        </div> <!-- Fim card-body -->
    </div> <!-- Fim card -->
</div> <!-- Fim container-fluid -->




<form id="form-revista" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="">
      <input type="hidden" name="id" value="">
      <input type="hidden" name="title" value="">
      <input type="hidden" name="link" value="">
      <input type="hidden" name="idOrder" value="">
      <input type="hidden" name="imagens" value="">
</form>
<form id="form-images" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="order">
      <input type="hidden" name="id" value="">
      <input type="hidden" name="idRevista" value="">
      <input type="hidden" name="idhasImagem" value="">
      <input type="hidden" name="name" value="">
</form>

@endsection
