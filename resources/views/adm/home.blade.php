@extends('layouts.adm')
@section('css')
  <link rel="stylesheet" href="/plugins-frameworks/bootstrap-select-1.13.0/dist/css/bootstrap-select.css">
  <style>
    .card { margin: 10px; }
    .card-body a button { margin-bottom: 3px; }

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
    <script src="/js/pages/adm/home.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
@endsection
@section('content')


<div class="container-fluid">
    <div class="row">


@if($errors->any())
<div class="col-md-12">
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
</div>
@endif


<form id="form-edit" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="">
    <input type="hidden" name="listStringIds" value="">
    <input type="hidden" name="section" value="">
    <input type="hidden" name="action" value="edit">
</form>
<form id="form-delete" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="">
    <input type="hidden" name="section" value="">
    <input type="hidden" name="action" value="delete">
</form>

<div id="banners" class="col-md-12 col-lg-6 col-xl-4 adm-home-colunas">

      <div class="card border-secondary">
        <div class="card-header border-secondary">
          NOTÍCIAS ESPECIAIS - ORDEM HOME
        </div>
        <div class="card-body adm-home-colunas">
          @forelse ($return['listBanners'] as $listBanner)
            @if ($loop->first)
                @php
                  $ativo = 'disabled';
                @endphp
            @else
                @php
                  $ativo = '';
                @endphp
            @endif
                <div class="card border-secondary">
                  <div class="card-body text-secondary">
                    @php
                        $imagemInativa = '';
                        if($listBanner->ativo == 'N'){
                          $imagemInativa = 'url(/images/imagemInativa.png), ';
                        }

                        $image = '/' .$listBanner->path. '/_Mini/' .$listBanner->namefile;
                        if($listBanner->namefile == '') {
                            $image = '/images/default.png';
                        }
                    @endphp
                    <div class="imagesList" style="background-image: {{$imagemInativa}} url({{$image}});"></div>
                    <div style="float:right;" class="btns-listagem">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary edit" type="button" title="Edita" listStringIds="{{$return['listBannersIds']}}" rel="{{$listBanner->id}}" {{$ativo}}><i class="material-icons">vertical_align_top</i></button>
                          <button class="btn btn-outline-secondary delete" type="button" rel="{{$listBanner->id_home}}"><i class="material-icons">clear</i></button>
                        </div>
                    </div>
                    <div style="float:left; margin-right:8px; padding-top:10px;">{{$listBanner->title}}</div>

                  </div>
                </div>
          @empty
              <h4 class="text-center"><span class="label label-default">Nenhuma notícia especial cadastrada para home.</span></h4>
          @endforelse
        </div>
        <div class="card-footer bg-transparent border-secondary">
            <form class="was-validated" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="section" value="banner">
                  <input type="hidden" name="action" value="register">
                  {{-- <select id="acompanhamentosCadastrar" class="selectpicker" multiple data-actions-box="true" data-width="100%" title="Selecione uma imagem para avatar" name="avatar"> --}}
                  <select id="news" class="selectpicker mb-3 form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma notícia especial" name="news" id="customControlValidation1" required>
                        @php
                          $comboBoxBanners = $return['comboBoxBanners'];
                          $controlCategory = '';
                          $cont = 0;
                          $showFirtsList = 'show';
                        @endphp

                        @for ($i = 0; $i < count($comboBoxBanners); $i++)
                            @php
                                $cont++;
                                if($cont > 1) { $showFirtsList = ''; }

                                $image = '/' .$comboBoxBanners[$i]->path. '/_Mini/' .$comboBoxBanners[$i]->namefile;
                                if($comboBoxBanners[$i]->namefile == '') {
                                    $image = '/images/default.png';
                                }
                            @endphp

                            @if($comboBoxBanners[$i]->category_name != $controlCategory)
                                @php
                                    $controlCategory = $comboBoxBanners[$i]->category_name;
                                @endphp
                                <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                            @endif
                                {{-- ================================================================== --}}
                                {{-- ======================== Itens Listados ========================== --}}
                                {{-- ================================================================== --}}
                                    <option value="{{$comboBoxBanners[$i]->id}}" data-content="<img src='{{$image}}'  height='25' alt='{{$comboBoxBanners[$i]->title}}'> {{$comboBoxBanners[$i]->title}}">{{$comboBoxBanners[$i]->title}}</option>
                                {{-- ================================================================== --}}
                                {{-- ======================== Itens Listados ========================== --}}
                                {{-- ================================================================== --}}
                            @if( isset($comboBoxBanners[$i+1]->category_name) )
                              @if( $comboBoxBanners[$i+1]->category_name != $controlCategory )
                                    </optgroup>
                              @endif
                            @else
                                  </optgroup>
                            @endif
                        @endfor
                  </select>
                  <button type="submit" class="btn btn-outline-success btn-block">Vincular</button>
            </form>
        </div>
      </div>

</div>


<div id="destaques" class="col-md-12 col-lg-6 col-xl-4 adm-home-colunas">
      <div class="card border-secondary">
        <div class="card-header border-secondary">
            NOTÍCIAS DESTAQUES - ORDEM HOME
        </div>
        <div class="card-body adm-home-colunas">
          @forelse ($return['listDestaques'] as $listDestaque)
            @if ($loop->first)
                @php
                  $ativo = 'disabled';
                @endphp
            @else
                @php
                  $ativo = '';
                @endphp
            @endif
            @php
                $image = '/' .$listDestaque->path. '/_Mini/' .$listDestaque->namefile;
                if($listDestaque->namefile == '') {
                    $image = '/images/default.png';
                }

                $imagemInativa = '';
                if($listDestaque->ativo == 'N'){
                  $imagemInativa = 'url(/images/imagemInativa.png), ';
                }
            @endphp
                <div class="card border-secondary">
                  <div class="card-body text-secondary">

                    <div class="imagesList" style="background-image: {{$imagemInativa}} url({{$image}});"></div>
                    <div style="float:right;" class="btns-listagem">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary edit" type="button" title="Edita" listStringIds="{{$return['listDestaquesIds']}}" rel="{{$listDestaque->id}}" {{$ativo}}><i class="material-icons">vertical_align_top</i></button>
                          <button class="btn btn-outline-secondary delete" type="button" rel="{{$listDestaque->id_home}}"><i class="material-icons">clear</i></button>
                        </div>
                    </div>

                    <div style="float:left; margin-right:8px; padding-top:10px;">{{$listDestaque->title}}</div>

                  </div>
                </div>
          @empty
              <h4 class="text-center"><span class="label label-default">Nenhuma notícia destaque cadastrada para home.</span></h4>
          @endforelse
        </div>
        <div class="card-footer bg-transparent border-secondary">
            <form class="was-validated" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="section" value="destaque">
                  <input type="hidden" name="action" value="register">
                  {{-- <select id="acompanhamentosCadastrar" class="selectpicker" multiple data-actions-box="true" data-width="100%" title="Selecione uma imagem para avatar" name="avatar"> --}}
                  <select id="news" class="selectpicker mb-3 form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione uma notícia destaque" name="news" id="customControlValidation1" required>
                        @php
                          $comboBoxDestaques = $return['comboBoxDestaques'];
                          $controlCategory = '';
                          $cont = 0;
                          $showFirtsList = 'show';
                        @endphp

                        @for ($i = 0; $i < count($comboBoxDestaques); $i++)
                            @php
                                $cont++;
                                if($cont > 1) { $showFirtsList = ''; }

                                $image = '/' .$comboBoxDestaques[$i]->path. '/_Mini/' .$comboBoxDestaques[$i]->namefile;
                                if($comboBoxDestaques[$i]->namefile == '') {
                                    $image = '/images/default.png';
                                }
                            @endphp

                            @if($comboBoxDestaques[$i]->category_name != $controlCategory)
                                @php
                                    $controlCategory = $comboBoxDestaques[$i]->category_name;
                                @endphp
                                <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                            @endif
                                {{-- ================================================================== --}}
                                {{-- ======================== Itens Listados ========================== --}}
                                {{-- ================================================================== --}}
                                    <option value="{{$comboBoxDestaques[$i]->id}}" data-content="<img src='{{$image}}'  height='25' alt='{{$comboBoxDestaques[$i]->title}}'> {{$comboBoxDestaques[$i]->title}}">{{$comboBoxDestaques[$i]->title}}</option>
                                {{-- ================================================================== --}}
                                {{-- ======================== Itens Listados ========================== --}}
                                {{-- ================================================================== --}}
                            @if( isset($comboBoxDestaques[$i+1]->category_name) )
                              @if( $comboBoxDestaques[$i+1]->category_name != $controlCategory )
                                    </optgroup>
                              @endif
                            @else
                                  </optgroup>
                            @endif
                        @endfor
                  </select>
                  <button type="submit" class="btn btn-outline-success btn-block">Vincular</button>
            </form>
        </div>
      </div>

</div>


<div id="colunistas" class="col-md-12 col-lg-6 col-xl-4 adm-home-colunas">
      <div class="card border-secondary">
        <div class="card-header border-secondary">
            COLUNISTAS - ORDEM HOME
        </div>
        <div class="card-body adm-home-colunas">
          @forelse ($return['listColunistas'] as $listColunista)
            @if ($loop->first)
                @php
                  $ativo = 'disabled';
                @endphp
            @else
                @php
                  $ativo = '';
                @endphp
            @endif
            @php
                $imagemInativa = '';
                if($listColunista->ativo == 'N'){
                  $imagemInativa = 'url(/images/imagemInativa.png), ';
                }

                $image = '/' .$listColunista->path. '/_Mini/' .$listColunista->namefile;
                if($listColunista->namefile == '') {
                    $image = '/images/default.png';
                }
            @endphp

                <div class="card border-secondary">
                  <div class="card-body text-secondary">

                    <div class="imagesList" style="background-image: {{$imagemInativa}} url({{$image}});"></div>
                    <div style="float:right;" class="btns-listagem">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary edit" type="button" title="Edita" listStringIds="{{$return['listColunistasIds']}}" rel="{{$listColunista->id}}" {{$ativo}}><i class="material-icons">vertical_align_top</i></button>
                          <button class="btn btn-outline-secondary delete" type="button" rel="{{$listColunista->id_home}}"><i class="material-icons">clear</i></button>
                        </div>
                    </div>
                    <div style="float:left; margin-right:8px; padding-top:10px;">{{$listColunista->title}}</div>

                  </div>
                </div>

          @empty
              <h4 class="text-center"><span class="label label-default">Nenhum colunista cadastrado para home.</span></h4>
          @endforelse
        </div>
        <div class="card-footer bg-transparent border-secondary">
            <form class="was-validated" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="section" value="colunista">
                  <input type="hidden" name="action" value="register">
                  {{-- <select id="acompanhamentosCadastrar" class="selectpicker" multiple data-actions-box="true" data-width="100%" title="Selecione uma imagem para avatar" name="avatar"> --}}
                  <select id="news" class="selectpicker mb-3 form-control form-control-sm" data-live-search="true" data-actions-box="true" title="Selecione um colunista" name="news" id="customControlValidation1" required>
                        @php
                          $comboBoxDestaques = $return['comboBoxColunistas'];
                          $controlCategory = '';
                          $cont = 0;
                          $showFirtsList = 'show';
                        @endphp

                        @for ($i = 0; $i < count($comboBoxDestaques); $i++)
                            @php
                                $cont++;
                                if($cont > 1) { $showFirtsList = ''; }

                                $image = '/' .$comboBoxDestaques[$i]->path. '/_Mini/' .$comboBoxDestaques[$i]->namefile;
                                if($comboBoxDestaques[$i]->namefile == '') {
                                    $image = '/images/default.png';
                                }
                            @endphp

                            @if($comboBoxDestaques[$i]->category_name != $controlCategory)
                                @php
                                    $controlCategory = $comboBoxDestaques[$i]->category_name;
                                @endphp
                                <optgroup label="Categoria:" data-subtext="{{$controlCategory}}">
                            @endif
                                {{-- ================================================================== --}}
                                {{-- ======================== Itens Listados ========================== --}}
                                {{-- ================================================================== --}}
                                    <option value="{{$comboBoxDestaques[$i]->id}}" data-content="<img src='{{$image}}'  height='25' alt='{{$comboBoxDestaques[$i]->title}}'> {{$comboBoxDestaques[$i]->title}}">{{$comboBoxDestaques[$i]->title}}</option>
                                {{-- ================================================================== --}}
                                {{-- ======================== Itens Listados ========================== --}}
                                {{-- ================================================================== --}}
                            @if( isset($comboBoxDestaques[$i+1]->category_name) )
                              @if( $comboBoxDestaques[$i+1]->category_name != $controlCategory )
                                    </optgroup>
                              @endif
                            @else
                                  </optgroup>
                            @endif
                        @endfor
                  </select>
                  <button type="submit" class="btn btn-outline-success btn-block">Vincular</button>
            </form>
        </div>
      </div>

</div>

    </div>
</div>
@endsection
