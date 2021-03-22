<?php
  $titleRegister = 'Cadastrar nova agenda';
  $titleListing = 'Listagem das agendas';
  $registros = $return['agendas'];
?>
@extends('layouts.adm')

@section('css')
    {{-- PickMeUp --}}
    <link rel="stylesheet" href="/plugins-frameworks/PickMeUp/css/pickmeup.css" type="text/css" />
    <link rel="stylesheet" href="/plugins-frameworks/bootstrap-select-1.13.0/dist/css/bootstrap-select.css">
    <style>
        .container-fluid .col-box { padding: 0; }
        .card-header { cursor: pointer; }
        .text-secondary { padding: 8px; }
        .btns-listagem { padding-top: 3px; height: 40px; }
        .btns-listagem .btn { padding: 3px 8px 0px; }
        .col-form-label { word-wrap:normal; }
        .imagesList {
            float: left;
            width: 100px;
            height: 60px;
            padding: 10px;
            border-radius: 3px;
            margin: -5px 8px -5px -5px;
            background-position: center !important;
            -webkit-background-size: cover !important;
            -moz-background-size: cover !important;
            -o-background-size: cover !important;
            background-size: cover !important;
            background-color: #00183F;
        }
        .box-pickmeup .card { margin: 0; }
        .box-pickmeup .card-body { margin: 0 auto; }
        .imagesList p { padding: 0; margin: -7px 0 -10px; text-align: center; color: white; }
        .imagesList .e_a { margin-top: -12px; }
        .imagesList table { height: 100%; }
        .title-list { height: 100%; }
        .title-list table { height: 100%; }
        #agenda-adm .agenda-inativa * { color: red; }
    </style>
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins-frameworks/ckeditor/ckeditor.js"></script>
@endsection
@section('js')
    {{-- PickMeUp --}}
    <script type="text/javascript" src="/plugins-frameworks/PickMeUp/js/jquery.pickmeup.twitter-bootstrap.js"></script>
    <script type="text/javascript" src="/plugins-frameworks/PickMeUp/js/pickmeup.js"></script>

    <script src="/js/pages/adm/agenda.js"></script>
    <script src="/js/pages/adm/common.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
    <script>
        $(document).ready(function()
        {
            var datas = [];
            pickmeup('.multiple-dates', {
          		flat : true,
              default_date: false,
              date: datas,
              format: 'd/m/Y',
              default_date:false,
          		mode : 'multiple'
          	});

            var el = document.getElementById('multiple-dates');
            el.addEventListener('pickmeup-change', function (e) {
                $('#inputData').val(e.detail.formatted_date);
                // console.log(e.detail.formatted_date); // New date according to current format
                // console.log(e.detail.date);           // New date as Date object
            })
        });
    </script>
@endsection

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
                    {{$titleRegister}}
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">

                            <div class="card-body">
                              <div class="row">
                                    <div class="col-md-12 text-right">
                                          <div class="form-check">
                                              <input class="form-check-input" type="checkbox" name="ativo" id="ativo" value="S">
                                              <label class="form-check-label" for="ativo"> Ativar Agenda </label>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-row box-pickmeup">
                                            <label for="inputData" class="col-form-label">Data*:</label>
                                            <div class="card border-secondary col-md-12">
                                                <div class="card-body">
                                                    <input type="text" class="is-invalid form-control form-control-sm" id="inputData" placeholder="Data" name="data" readonly />
                                                    <div id="multiple-dates" class="multiple-dates"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <label for="inputTitle" class="col-form-label">Título:*</label>
                                            <input type="text" class="form-control form-control-sm is-invalid" id="inputTitle" placeholder="Nome. [max. 240 caracteres]" name="title" required />
                                        </div>

                                        <div class="form-row">
                                            <label for="inputCartola" class="col-form-label">Cartola:*</label>
                                            <input type="text" class="form-control form-control-sm is-invalid" id="inputCartola" placeholder="Cartola. [max. 240 caracteres]" name="cartola" required />
                                        </div>

                                        <div class="form-row">
                                            <label for="inputLinhaDeApoio" class="col-form-label">Linha de Apoio:</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Linha de Apoio. [max. 240 caracteres]" name="linha_apoio" />
                                        </div>

                                        <div class="form-row">
                                            <label for="inputLocal" class="col-form-label">Local:</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Local. [max. 240 caracteres]" name="local" />
                                        </div>

                                        <div class="form-row">
                                            <label for="inpuEventoFacebook" class="col-form-label">Evento no Facebook:</label>
                                            <input type="text" class="form-control form-control-sm" id="inpuEventoFacebook" placeholder="Evento no Facebook. [max. 240 caracteres]" name="evento_facebook" />
                                        </div>

                                        <div class="form-row">
                                            <label for="inpuTags" class="col-form-label">TAG's:</label>
                                            <input type="text" class="form-control form-control-sm" id="inpuTags" placeholder="Tags. [max. 240 caracteres]" name="tags" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="inputDescricao" class="col-md-12 col-form-label">Texto:</label>
                                    <div class="col-sm-12">
                                        <textarea id="text" name="text"></textarea>
                                        <script type="text/javascript">
                                            CKEDITOR.replace( 'text' );
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

    <div id="agenda-adm" class="row m-b-20">
        <div class="col-md-12">

              <!-- Conteiner da listagem -->
              <div class="card bg-light">
                <div class="card-header">{{$titleListing}}</div>
                <div class="card-body">
                    @forelse  ($registros as $registro)
                        <?php
                            $imagemInativa = '';
                            if ($registro->ativo == 'N' ) {
                                $imagemInativa = 'url(/images/imagemInativa.png), ';
                            }
                            $image = '/images/default.png';
                            if ($registro->namefile != '') {
                                 $image = '/' .$registro->path. '/_Mini/' .$registro->namefile;
                            } elseif ($registro->namefile != '') {
                                $image = '/' .$registro->path. '/_Mini/' .$registro->namefile;
                            }

                            $datas = json_decode($registro->data);
                        ?>
                        {{-- ======================== Itens listados =========================== --}}
                        <form action="/adm/agenda/edit/{{$registro->id}}">
                            <div class="card border-secondary">
                                <div class="card-body text-secondary {{ $registro->ativo != 'S' ? 'agenda-inativa' : '' }}">
                                    <div style="float:right;" class="btns-listagem">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary edit" type="submit" title="Edita"><i class="material-icons i-corrige">mode_edit</i></button>
                                            <button class="btn btn-outline-secondary delete" type="button" rel="{{$registro->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                        </div>
                                    </div>
                                    @if( count($datas) )
                                        <div class="imagesList">
                                            <table><tr><td>
                                                <p>{{$datas[0]}}</p>
                                            @if( count($datas) > 1 )
                                                <p class="e_a">{{count($datas) == 2 ? 'e' : 'a'}}</p>
                                                <p>{{ $datas[count($datas) - 1]}}</p>
                                            @endif
                                            </td></tr></table>
                                        </div>
                                    @endif
                                    <div class="title-list"><table><tr><td>{{$registro->title}}</td></tr></table></div>
                                </div>
                            </div>
                        </form>
                      {{-- ======================== Itens listados =========================== --}}
                    @empty
                        Nenhuma agenda cadastrada
                    @endforelse
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
