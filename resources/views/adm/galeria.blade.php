@php
  $registers = $return['galerias'];
  $files = $return['files'];
  $cont = 0;
  $contI = 0;
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
    .list-group-flush .list-group-item {
        z-index: 2;
    }
    .editGaleria { padding: 0;}
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
    <script src="/js/pages/adm/galeria.js"></script>
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
                    Cadastrar nova galeria
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card">
                        <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">
                            <div class="card-body">
                                <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-row">
                                              <label for="inputNome" class="col-sm-12 col-form-label">Nome da Galeria:*</label>
                                              <input type="text" name="title" class="form-control form-control-sm is-invalid" placeholder="Nome da Galeria. [max. 240 caracteres]" required>
                                          </div>
                                          <div class="form-row">
                                              <label for="inputNome" class="col-md-12 col-form-label">Descrição da Galeria:</label>
                                              <textarea name="description" class="form-control form-control-sm" placeholder="Descrição da Galeria" rows="3"></textarea>
                                          </div>
                                          <div class="form-row">
                                              <label for="inputNome" class="col-md-12 col-form-label">Selecionar Imagens:*</label>
                                              <div class="custom-file">
                                                  <input type="file" class="custom-file-input" name="files[]" id="customFile" multiple required>
                                                  <label class="custom-file-label" for="customFile">Selecionar Imagens*</label>
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <label for="inputNome" class="col-md-12 col-form-label">Dar um nome padrão a todas imagens:</label>
                                              <input type="text" name="namedefault" class="form-control form-control-sm" placeholder="Nome padrão a todas imagens. [max. 240 caracteres]">
                                          </div>
                                      </div>
                                </div>
                            </div>

                            <div class="card-footer text-muted">
                              <button type="submit" class="btn btn-outline-success btn-block">Cadastrar Galeria</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>




    <!-- Conteiner da listagem -->
    <div class="card bg-light">
        <div class="card-header">Listagem das Galerias</div>
        <div class="card-body">

            <div id="accordion">
              @forelse ($registers as $register)
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
                              <button class="btn btn-outline-secondary edit-galery btnThumbs" type="button" title="Ordenar" rel="{{$register->id}}" {{$ativo}}><i class="material-icons">vertical_align_top</i></button>
                              <button class="btn btn-outline-secondary delete-galery btnThumbs" type="button" title="Deletar Galeria" rel="{{$register->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                          </div>
                          <table><tr><td style="padding-top: 3px;"><i class="material-icons">photo_library</i></td><td>{{$register->title}}</td><td></td></tr></table>
                      </div>
                      <div id="collapse{{$cont}}" class="collapse {{--$showFirtsList--}}" aria-labelledby="heading{{$cont}}" data-parent="#accordion">
                          <div class="card-body">
                            <!-- ==================================================================  -->
                            <!-- ======================== Editar Galeria =========================== -->
                            <!-- ==================================================================  -->
                                <div class="col-md-12 m-b-20 editGaleria">
                                    <button class="btn btn-outline-primary btn-block" type="button" data-toggle="collapse" data-target="#registerEditar{{$register->id}}" aria-expanded="false" aria-controls="register">
                                        Editar galeria
                                    </button>
                                    <div id="registerEditar{{$register->id}}" class="collapse">
                                            <div class="card">
                                                <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{$register->id}}">
                                                    <input type="hidden" name="action" value="edit">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                  <div class="form-row">
                                                                      <label for="inputNome" class="col-md-12 col-form-label">Nome da Galeria:*</label>
                                                                      <input type="text" name="title" class="form-control form-control-sm form-control-md is-invalid" placeholder="Nome da Galeria. [max. 240 caracteres]" value="{{$register->title}}" required>
                                                                  </div>
                                                                  <div class="form-row">
                                                                      <label for="inputNome" class="col-md-12 col-form-label">Descrição da Galeria:</label>
                                                                      <textarea name="description" class="form-control form-control-sm" placeholder="Descrição da Galeria" rows="3">{{$register->description}}</textarea>
                                                                  </div>
                                                                  <div class="form-row">
                                                                      <label for="inputNome" class="col-md-12 col-form-label">Adicionar Imagens:*</label>
                                                                      <div class="custom-file">
                                                                          <input type="file" class="custom-file-input" name="files[]" id="customFile" multiple>
                                                                          <label class="custom-file-label" for="customFile">Selecionar Imagens</label>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-row">
                                                                      <label for="inputNome" class="col-md-12 col-form-label">Dar um nome padrão a todas imagens:</label>
                                                                      <input type="text" name="namedefault" class="form-control form-control-sm" placeholder="Nome padrão a todas imagens. [max. 240 caracteres]">
                                                                  </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="card-footer text-muted">
                                                        <button type="submit" class="btn btn-outline-success btn-block">Editar Galeria</button>
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
                                    @foreach ($files as $file)
                                        @if($file->id_galeria == $register->id)
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
                                                <img src="/{{$file->namefilefullthumb}}" alt="{{$file->namefile}}" title="" alt="{{$file->namefile}}" class="rounded img-fluid">
                                                <div>
                                                    <button class="btn btn-outline-secondary order-image btnThumbsImages" type="button" title="Ordenar imagem" rel="{{$file->id}}" rel2="{{$register->id}}" {{$ativoI}}><i class="material-icons">reply</i></button>
                                                    <button class="btn btn-outline-secondary edit-image btnThumbsImages" type="button" title="Editar nome da imagem" rel="{{$file->id}}"><i class="material-icons i-corrige">mode_edit</i></button>
                                                    <button class="btn btn-outline-secondary delete-image btnThumbsImages" type="button" title="Excluir Imagem" rel="{{$file->id}}" rel2="{{$file->id_galeria_has_imagem}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control form-control-sm inputNomeImagem" aria-label="Nome da imagem" value="{{$file->name}}" />
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
                  <p>Nenhum galeria cadastrada no momento.</p>
              @endforelse
            </div> <!-- Fim acordion -->

        </div> <!-- Fim card-body -->
    </div> <!-- Fim card -->
</div> <!-- Fim container-fluid -->




<form id="form-galery" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="">
      <input type="hidden" name="id" value="">
</form>
<form id="form-images" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="order">
      <input type="hidden" name="id" value="">
      <input type="hidden" name="idGaleria" value="">
      <input type="hidden" name="idhasImagem" value="">
      <input type="hidden" name="name" value="">
</form>

@endsection
