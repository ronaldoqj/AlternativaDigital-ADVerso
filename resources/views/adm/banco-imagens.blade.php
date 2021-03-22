@extends('layouts.adm')

@section('css')
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
    <script src="/js/pages/adm/banco-imagens.js"></script>
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
                    Cadastrar nova imagem
                </button>
            </p>
            <div id="register" class="collapse">
                <div class="card">
                    <form action="" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="action" value="register">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
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
                                        <label for="inputNome" class="col-sm-2 col-form-label">Nome*</label>
                                        <input type="text" class="form-control form-control-sm is-invalid" id="inputNome" placeholder="Nome. [max. 140 caracteres]" name="name" required>
                                    </div>
                                    <div class="form-row">
                                        <label for="inputDescricao" class="col-sm-2 col-form-label">Descrição</label>
                                        <input type="text" class="form-control form-control-sm" id="inputDescricao" placeholder="Descrição. [max. 240 caracteres]" name="description">
                                    </div>
                                    <div class="form-row">
                                        <label for="inputAlternativo" class="col-sm-2 col-form-label">Tags</label>
                                        <input type="text" class="form-control form-control-sm" id="inputAlternativo" placeholder="Tags. [max. 140 caracteres]" name="alternative_text">
                                    </div>
                                    <div class="form-row">
                                        <label for="inputImagem" class="col-sm-2 col-form-label">Imagem*</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input is-invalid" id="file" name="file" required>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
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
  <div class="card-header">Listagem das imagens</div>
  <div class="card-body">

          <div id="accordion">
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
                    <div class="card">
                      <div class="card-header" id="heading{{$cont}}" data-toggle="collapse" data-target="#collapse{{$cont}}" aria-expanded="true" aria-controls="collapse{{$cont}}">
                          <table><tr><td><i class="material-icons">apps</i></td><td>{{$files[$i]->category_name}}</td></tr></table>
                      </div>
                      <div id="collapse{{$cont}}" class="collapse {{$showFirtsList}}" aria-labelledby="heading{{$cont}}" data-parent="#accordion">
                        <div class="card-body">
                @endif
                <!-- ==================================================================  -->
                <!-- ======================== Itens listados =========================== -->
                <!-- ==================================================================  -->
                      <div class="card border-secondary">
                        <div class="card-body text-secondary">

                          <div class="imagesList" style="background-image: url(/{{$files[$i]->path}}/_Mini/{{$files[$i]->namefile}});"></div>
                          <div style="float:right;" class="btns-listagem">
                              <div class="input-group-append">
                                <button class="btn btn-outline-secondary edit" type="button" title="Edita" rel="{{json_encode($files[$i], true)}}"><i class="material-icons i-corrige">mode_edit</i></button>
                                <button class="btn btn-outline-secondary delete" type="button" rel="{{$files[$i]->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                              </div>
                          </div>
                          <div style="float:left; margin-right:8px; padding-top:10px;">{{$files[$i]->name}}</div>

                        </div>
                      </div>
                <!-- ==================================================================  -->
                <!-- ======================== Itens listados =========================== -->
                <!-- ==================================================================  -->
                @if( isset($files[$i+1]->category_name) )
                  @if( $files[$i+1]->category_name != $controlCategory )
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


<!-- ======================================================================  -->
<!-- =========================== MODAL ===================================== -->
<!-- ======================================================================  -->
<div id="modalEditGalery" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Imagem</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="">

                <div class="modal-body">
                    <div style="margin-bottom: 10px;">
                        <img src="" alt="" class="img-fluid img-thumbnail img-modal mx-auto d-block">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <label for="inputNome" class="col-sm-2 col-form-label">Categoria*</label>
                                <select class="form-control form-control-sm is-invalid" name="category" required>
                                    <option>Selecione uma categoria</option>
                                  @foreach ($return['categorias'] as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="form-row">
                                <label for="inputNome" class="col-sm-2 col-form-label">Nome*</label>
                                <input type="text" class="form-control form-control-sm is-invalid" id="inputNome" placeholder="Nome. [max. 140 caracteres]" name="name" required>
                            </div>
                            <div class="form-row">
                                <label for="inputDescricao" class="col-sm-2 col-form-label">Descrição</label>
                                <input type="text" class="form-control form-control-sm" id="inputDescricao" placeholder="Descrição. [max. 240 caracteres]" name="description">
                            </div>
                            <div class="form-row">
                                <label for="inputAlternativo" class="col-sm-2 col-form-label">Tags</label>
                                <input type="text" class="form-control form-control-sm" id="inputAlternativo" placeholder="Tags. [max. 140 caracteres]" name="alternative_text">
                            </div>
                            <div class="form-row">
                                <label for="inputImagem" class="col-sm-2 col-form-label">Imagem</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileEdit" name="fileEdit">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
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

<form id="form-delete" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" value="">
</form>

@endsection
