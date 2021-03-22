<?php
    $titleListing = 'Listagem das matérias';
    $titleRegister = 'Cadastrar nova matéria';
    $register = $return['register'];
    $galerias = $return['galerias'];

    $register->formattedDate = $register->created_at;
    if ($register->created_at != '') {
       $newDate = date_create($register->created_at);
       $register->formattedDate = date_format($newDate,"d/m/Y");
    }

    $linkReturn = '/adm/agenda/';
?>
@extends('layouts.adm')

@section('css')
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
        .box-pickmeup .card { margin: 0; }
        .box-pickmeup .card-body { margin: 0 auto; }
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

            @foreach( json_decode($register->data ) as $data )
                datas.push('{{$data}}');
            @endforeach

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
        <div class="col-md-12 m-b-10">
            <a class="btn btn-outline-dark btn-sm" href="{{$linkReturn}}" role="button">Voltar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 m-b-40">
              <div id="register" class="card">
                  <form action="" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="action" value="edit">
                      <input type="hidden" name="id" value="{{$register->id}}">

                      <div class="card-body">
                          <div class="row">
                              <?php
                                  $criador = '';
                                  $criadorName = $objCriador->name ?? '';
                                  if ( $register->criador != '' ) {
                                      $objCriador = App\Models\User::find($register->criador);
                                      $criador = '<span><span>Criado por:</span> ' . $criadorName . '</span>';
                                  }
                              ?>
                              <div class="col-md-12">
                                <span class="text-left criador">{!!$criador!!}</span>
                                  <div class="form-check text-right float-right">
                                      <input {{$register->ativo == 'S' ? 'checked' : ''}} class="form-check-input" type="checkbox" name="ativo" id="ativo" value="S" />
                                      <label class="form-check-label" for="ativo"> Ativar Notícia </label>
                                  </div>
                                  <div class="clearfix"></div>
                                  <hr />
                              </div>
                              <div class="col-md-6">
                                    <div class="form-row box-pickmeup">
                                        <label for="inputData" class="col-form-label">Data*:</label>
                                        <div class="card border-secondary col-md-12">
                                            <div class="card-body">
                                                <input type="text" class="is-invalid form-control form-control-sm" id="inputData" placeholder="Data" name="data" value="{{ implode( ",",  json_decode($register->data) ) }}" readonly />
                                                <div id="multiple-dates" class="multiple-dates"></div>
                                            </div>
                                        </div>
                                    </div>
                              </div>

                              <div class="col-md-6">
                                    <div class="form-row">
                                        <label for="inputTitle" class="col-form-label">Título:*</label>
                                        <input type="text" class="form-control form-control-sm is-invalid" id="inputTitle" placeholder="Título. [max. 240 caracteres]" name="title"  value="{{$register->title}}" required />
                                    </div>

                                    <div class="form-row">
                                        <label for="inputCartola" class="col-form-label">Cartola:*</label>
                                        <input type="text" class="form-control form-control-sm is-invalid" id="inputCartola" placeholder="Cartola. [max. 240 caracteres]" name="cartola"  value="{{$register->cartola}}" required />
                                    </div>

                                    <div class="form-row">
                                        <label for="inputLinhaDeApoio" class="col-form-label">Linha de apoio:</label>
                                        <input type="text" class="form-control form-control-sm" id="inputLinhaDeApoio" placeholder="Linha de apoio. [max. 240 caracteres]" name="linha_apoio" value="{{$register->linha_apoio}}" />
                                    </div>

                                    <div class="form-row">
                                        <label for="inputLocal" class="col-form-label">Local:</label>
                                        <input type="text" class="form-control form-control-sm" id="inputLocal" placeholder="Local. [max. 240 caracteres]" name="local" value="{{$register->local}}" />
                                    </div>

                                    <div class="form-row">
                                        <label for="inpuEventoFacebook" class="col-form-label">Evento no Facebook:</label>
                                        <input type="text" class="form-control form-control-sm" id="inpuEventoFacebook" placeholder="Evento no Facebook. [max. 240 caracteres]" name="evento_facebook" value="{{$register->evento_facebook}}" />
                                    </div>

                                    <div class="form-row">
                                        <label for="inpuTags" class="col-form-label">TAG's:</label>
                                        <input type="text" class="form-control form-control-sm" id="inpuTags" placeholder="Tags. [max. 240 caracteres]" name="tags" value="{{$register->tags}}" />
                                    </div>
                              </div>
                          </div>

                          <div class="form-row">
                              <label for="inputDescricao" class="col-md-12 col-form-label">Texto:</label>
                              <div class="col-md-12">
                                  <textarea id="text" name="text">{!!$register->text!!}</textarea>
                                  <script type="text/javascript">
                                      CKEDITOR.replace( 'text' );
                                  </script>
                              </div>
                          </div>
                      </div>
                      <div class="card-footer text-muted">
                          <div class="row">
                              <!-- <div class="col-xs-12 col-md-4"><a href="/adm/agenda/pre-visualizar/{{$register->id}}" target="_blank" class="btn btn-outline-info btn-block">Pré-visualizar</a></div> -->
                              <div class="col-xs-12 col-md-12"><button type="submit" class="btn btn-outline-success btn-block">Editar</button></div>
                          </div>
                      </div>
                  </form>
              </div>
        </div>
    </div>

</div> <!-- Fim container-fluid -->
@endsection
