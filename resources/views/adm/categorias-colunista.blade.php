@extends('layouts.adm')
@section('js')
    <script src="/js/pages/categorias.js"></script>
@stop
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
                <div>
                    <form action="" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="categoria" value="colunista">
                      <input type="hidden" name="action" value="register">

                      <div class="card border-warning">
                          <div class="card-header">
                            Adiconar Categoria
                          </div>
                          <div class="card-body">
                              <div class="input-group input-group-sm">
                                  <input type="text" class="form-control" placeholder="Informe o nome da categoria" aria-label="Recipient's username" aria-describedby="basic-addon2" name="nome">
                                  <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit">Cadastrar Categoria</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </form>

                    <div class="m-t-50"></div>

                    <form id="form-categorias" action="" method="post">
                    {{ csrf_field() }}
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="nomeEdit" value="">
                        <input type="hidden" name="action" value="">

                        <div class="card border-warning">
                          <div class="card-header">
                            Listagem das Categoria
                          </div>
                          <div class="card-body">
                            @forelse ($return['categorias'] as $categoria)

                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" rel="{{ $categoria->id }}" value="{{ $categoria->nome }}" aria-describedby="basic-addon2">
                              <div class="input-group-append">
                                <button class="btn btn-outline-secondary edita" type="button" title="Edita"><i class="material-icons i-corrige">mode_edit</i></button>
                                <button class="btn btn-outline-secondary deleta" type="button"><i class="material-icons i-corrige">delete_forever</i></button>
                              </div>
                            </div>
                            @empty
                                <h4 class="text-center"><span class="label label-default">Nenhuma categoria cadastrada.</span></h4>
                            @endforelse
                          </div>
                        </div>

                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
