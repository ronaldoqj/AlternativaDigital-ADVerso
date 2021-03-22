<?php
    $registers = $return;
    $retorno = $registers['retorno'];
    $pesquisa = $registers['pesquisa'];
    $cont = 0;
?>

{{--dd($pesquisa)--}}
@extends('layouts.site')
@section('css')
    <link href="/css/pages/pesquisa.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/css/pages/colunistas.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/css/pages/noticias.css" type="text/css" rel="stylesheet" media="screen,projection"/>
@endsection
@section('js')
@endsection
@section('content')
<div id="pesquisa-container" class="container">
    <div class="row">
        <div class="title-pesquisa">Pesquisa</div>
        <div class="pesquisa-campos">
            <div class="form">
                <form action="" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="pesquisa"  value="" class="browser-default inputs" placeholder="PESQUISA" required />
                    <input type="submit" id="pesquisar" class="btn" value="pesquisar" />
                </form>
            </div>
        </div>


        <!-- <div class="result">Nenhum resultado encontrado.</div> -->
        @if ($retorno)
            @if ($pesquisa['materias']->count())
               <div class="title-pages">MATERIAS</div>

               <div class="row">
                   @foreach($pesquisa['materias'] as $registro)
                       <?php
                           $titleLink = Str::slug($registro->title, '-');

                           $image = $registro->namefilefull;
                           if ($registro->namefilefull == '') {
                               $image = 'images/default.png';
                           }
                       ?>
                     <div class="col s12 m12 l6 xl6 outra outra-spaco-right">
                         <div class="box-noticia">
                             <a href="/colunista/{{$registro->id}}/{{$titleLink}}"><div class="noticia-img" style="background-image: url({{$image}});"></div></a>
                         </div>
                         <div class="noticia-text">
                             <ul>
                               <li><a href="{{url("/noticia/{$registro->id}/{$registro->title}")}}" title="Facebook" class="btSocialNetwork" rel="{{url("/{$registro->namefilefull}")}}"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                               <li><a href="{{url("/noticia/{$registro->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                               <li><a href="whatsapp://send?text={{$registro->title}} - {{url("/noticia/{$registro->id}")}}" title="Whatsapp" class="icon-whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>
                             </ul>
                             <div class="sub-title truncate assuntos">{{$registro->assunto}}</div>
                             <div class="title titles"><a href="/noticia/{{$registro->id}}/{{$titleLink}}">{{Str::limit($registro->title, 35, '...')}}</a></div>
                             <div class="subtitles">{{Str::limit($registro->subtitle, 90, '...')}}</div>
                             <div class="noticia-leiamais"><a href="/noticia/{{$registro->id}}/{{$titleLink}}">Leia mais</a></div>
                         </div>
                     </div>
                   @endforeach
               </div>
            @endif

            @if ($pesquisa['colunistas']->count())
               <div class="title-pages">COLUNISTAS</div>

               <div class="row">
                   @foreach($pesquisa['colunistas'] as $coluna)
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
                       $titleLink = Str::slug($coluna->title, '-');
                   @endphp
                   <div class="col s12 m12 l6 outro {{$rightLeft}}">
                       <div class="box-colunista">
                           <a href="/colunista/{{$coluna->id}}/{{$titleLink}}"><div class="colunista-img" style="background-image: url({{$img}});"></div></a>
                       </div>
                       <div class="colunista-text">

                           <div class="sub-title">
                               <table border="1">
                                     <tr>
                                         <td width="1">
                                             <div class="borda-avatar">
                                                 <div class="avatar" style="background-image: url(/{{$coluna->avatar_namefilefull}});"></div>
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
                           <div class="title titles"><a href="/colunista/{{$coluna->id}}/{{$titleLink}}">{{Str::limit($coluna->title, 35, '...')}}</a></div>
                           <div class="subtitles">{{Str::limit($coluna->subtitle, 90, '...')}}</div>
                           <div class="colunista-leiamais"><a href="/colunista/{{$coluna->id}}/{{$titleLink}}">Leia mais</a></div>
                       </div>
                   </div>
                   @endforeach
               </div>
            @endif

            <?php /*
            @if ($pesquisa['tv_adverso']->count())
               <div class="title-pages">MULTIMÍDIA</div>
               @foreach($pesquisa['tv_adverso'] as $registro)
                   @php
                       $titleLink = Str::slug($registro->title, '-');

                       $image = $registro->namefilefull;
                       if ($registro->namefilefull == '') {
                           $image = 'images/default.png';
                       }
                   @endphp
                   <div class="row">
                       <div class="col s12 valign-wrapper">
                          <div class="col s6 m4 l3">
                            <div class="img-pesquisa col s12" style="background: url(/images/player-video.png), url(http://i1.ytimg.com/vi/{{$registro->id_video}}/hqdefault.jpg);"></div>
                          </div>
                          <div class="col s6 m8 l9 title-registros-pesquisa">
                              <a href="/noticia/{{$registro->id}}/{{$titleLink}}">
                                {{$registro->title}}
                              </a>
                          </div>
                       </div>
                   </div>
               @endforeach
            @endif
            */ ?>
        @endif
    </div>
</div>
@endsection
