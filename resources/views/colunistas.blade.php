<?php
  $materiasEspeciais  = $return['listBanners'];
  $materiasColunistas = $return['listColunistasTopo'];
  $materiasCount      = $return['materias-count'];
  $texto = $return['texto'];
  $listColunistas = $return['listColunistas'];
  $colunas = $return['listColunas'];
  $cont = 0;
?>

@extends('layouts.site')

@section('css')
    <link href="/css/pages/colunistas.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <!-- OWL -->
    <link href="/plugins-frameworks/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins-frameworks/owl_carousel/owl.theme.css" rel="stylesheet">

    <style>
        .card .card-calendario { background: #9D224E; }
        .card .card-background .card-texto { border-top: 3px solid #9D224E; }
        .card:hover { border: solid 1px #9D224E; }
        .card:hover .card-background .card-texto {
            background-color: #9D224E90;
        }
    </style>
@endsection

@section('js')
    <script src="/js/pages/colunistas.js"></script>
    <!-- OWL -->
    <script src="/plugins-frameworks/owl_carousel/owl.carousel.js"></script>
@endsection

@section('content')
<div class="clearfix"></div>
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
<?php /*
<div class="carousel carousel-slider">
    @if($return['materias-count'] > 1)
        <div class="container">
            <div class="controls-styles control-left"><div class="arrow-left"></div></div>
            <div class="controls-styles control-right"><div class="arrow-right"></div></div>
        </div>
    @endif
    <div class="corrige-marcadores"></div>

    @for ($i = 0; $i < count($materiasColunistas); $i++)
    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('/{{$materiasColunistas[$i]->fileBackground_namefilefull}}');">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col s12 box-avatar">
                            <div class="title">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="borda-avatar">
                                                <div class="avatar" style="background-image: url('/{{$materiasColunistas[$i]->avatar_namefilefull}}');"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{$materiasColunistas[$i]->colunista_name}}</div>
                                            <p>{{$materiasColunistas[$i]->colunista_cargo}}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col s12 banner-social-network">
                            <ul>
                              <li><a href="{{url("/colunista/{$materiasColunistas[$i]->id}/{$materiasColunistas[$i]->title}")}}" title="Facebook" class="btSocialNetwork"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                              <li><a href="{{url("/colunista/{$materiasColunistas[$i]->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                              <li><a href="whatsapp://send?text={{$materiasColunistas[$i]->title}} - {{url("/colunista/{$materiasColunistas[$i]->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                            </ul>
                        </div>

                        <div class="col s12 banner-texts">
                            <ul>
                                <li class="assuntos truncate">{{$materiasColunistas[$i]->assunto}}</li>
                                <li class="titles">{{$materiasColunistas[$i]->title}}</li>
                                <li class="subtitles">
                                    {{$materiasColunistas[$i]->subtitle}}
                                </li>
                                @php
                                    $materiasColunistas[$i]->title = Str::slug($materiasColunistas[$i]->title, '-');
                                @endphp
                                <li><a href="/colunista/{{$materiasColunistas[$i]->id}}/{{$materiasColunistas[$i]->title}}">Leia mais</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endfor
</div>
*/ ?>
<div class="container">
    <div class="title-outros-colunistas m-t-25 m-b-10">Colunistas</div>
    <!-- <p class="subtitulo-colunistas">Descubra a opinião de especialistas sobre diferentes temas que impactam na educação brasileira. Os colunistas ADverso são professores, diretores da Adufrgs e parceiros do Portal. Sugira os próximos debates.</p> -->
    {!!$texto->text ?? '<div class="m-b-40"></div>'!!}
</div>

<?php /*
<!-- ======================================================================= -->
<!-- Destaques                                                                   -->
<!-- ======================================================================= -->
<div class="container m-t-30">
    <div class="row">
        <div id="owl-colunistas-destaques" class="owl-colunistas-destaques">
          @foreach ($listColunistas as $listColunista)
            <div class="item colunistas-destaques">
                <div class="box-avatar">
                    <table>
                        <tr>
                            <td width="1"><div class="borda-avatar"><div class="avatar" style="background-image: url('/{{$listColunista->namefilefull}}');"></div></div></td>
                            <td><div class="textos"><div class="name">{{$listColunista->name}}</div><p>{{$listColunista->cargo}}</p></div></td>
                        </tr>
                    </table>
                </div>
            </div>
          @endforeach
        </div>
    </div>
</div>
*/ ?>
<!-- Outros Colunistas-->
<div class="container m-t-50">

    <div class="row">
        @foreach ($colunas as $coluna)
            @if($cont == 1)
                @php
                    $rightLeft = 'outro-spaco-left';
                    $cont = 0;
                @endphp
            @else
                @php
                    $rightLeft = 'outro-spaco-right';
                    $img = '/images/default.png';
                    if ($coluna->fileBackground_namefilefull != '') {
                      $img = '/'.$coluna->fileBackground_namefilefull;
                    }
                @endphp
            @endif
            @php
                $imagemInativa = '';
                if ( $coluna->ativo == 'N' ) {
                    $imagemInativa = 'url(/images/imagemInativa.png), ';
                }
                $titleLink = Str::slug($coluna->title, '-');
            @endphp
            <div class="col s12 m12 l6 outro {{$rightLeft}}">
                <div class="box-colunista">
                    <a href="/colunista/{{$coluna->id}}/{{$titleLink}}"><div class="colunista-img" style="background-image: {{$imagemInativa}} url({{$img}});"></div></a>
                </div>
                <div class="colunista-text">

                    <div class="sub-title">
                        <table border="1">
                              <tr>
                                  <td width="1">
                                      <div class="borda-avatar">
                                          <div class="avatar" style="background-image: {{$imagemInativa}} url(/{{$coluna->avatar_namefilefull}});"></div>
                                      </div>
                                  </td>
                                  <td class="td-avatar-info">
                                        <div class="avatar-name assuntos">por {{$coluna->colunista_name}}</div>
                                        <div class="redes-sociais">
                                            <ul>
                                              <li><a href="{{url("/colunista/{$coluna->id}/{$coluna->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$coluna->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                              <li><a href="{{url("/colunista/{$coluna->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                              <li><a href="whatsapp://send?text={{$coluna->title}} - {{url("/colunista/{$coluna->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                                            </ul>
                                        </div>
                                  </td>
                              </tr>
                        </table>
                    </div>
                    <div class="title titles"><a href="/colunista/{{$coluna->id}}/{{$titleLink}}">{{Str::limit($coluna->title, 110, '...')}}</a></div>
                    <div class="subtitles"><a href="/colunista/{{$coluna->id}}/{{$titleLink}}">{{Str::limit($coluna->subtitle, 500, '')}}</a></div>
                </div>
            </div>
        @endforeach
        <?php /*
        <div class="col m6 outro outro-spaco-left">
            <div class="box-colunista">
                <div class="colunista-img" style="background-image: url('/images/colunista2.jpg');">
                </div>
            </div>
            <div class="colunista-text">
                <ul>
                    <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                    <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                    <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                </ul>
                <div class="sub-title">
                    <div class="borda-avatar"><div class="avatar" style="background-image: url('/images/COLUNISTA_Nilton-Brandao.jpg');"></div></div>
                    por Nilton Brandão
                </div>
                <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                <div class="colunista-leiamais"><a href="/colunista/19/terrorismo-adequado">Leia mais</a></div>
            </div>
        </div>
        */ ?>
    </div>

    <?php /*
    <div class="row">
        <div class="col m6 outro outro-spaco-right">
            <div class="box-colunista">
                <div class="colunista-img" style="background-image: url('/images/colunista3.jpg');">
                </div>
            </div>
            <div class="colunista-text">
                <ul>
                    <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                    <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                    <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                </ul>
                <div class="sub-title">
                    <div class="borda-avatar"><div class="avatar" style="background-image: url('/images/COLUNISTA_paulo_Mors.jpg');"></div></div>
                    por Paulo Machado Mors
                </div>
                <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                <div class="colunista-leiamais"><a href="/colunista/19/terrorismo-adequado">Leia mais</a></div>
            </div>
        </div>
        <div class="col m6 outro outro-spaco-left">
            <div class="box-colunista">
                <div class="colunista-img" style="background-image: url('/images/colunista4.jpg');">
                </div>
            </div>
            <div class="colunista-text">
                <ul>
                    <li><a href="#" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                    <li><a href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                    <li><a href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                </ul>
                <div class="sub-title">
                    <div class="borda-avatar"><div class="avatar" style="background-image: url('/images/COLUNISTA_Nilton-Brandao.jpg');"></div></div>
                    por Nilton Brandão
                </div>
                <div class="title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit<!--, sed diam--></div>
                <div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis exerci...</div>
                <div class="colunista-leiamais"><a href="/colunista/19/terrorismo-adequado">Leia mais</a></div>
            </div>
        </div>
    </div>
    */ ?>
</div>

<!--
<div class="container text-center">
    <div class="title-carregar-mais">Carregar mais colunas</div>
</div> -->

@endsection
