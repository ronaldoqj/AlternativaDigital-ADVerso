<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{-- config('app.name', 'Laravel') --}}ADVerso</title>

    <!-- Fonte Google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap CSS CDN -->
    <!-- <link href="/plugins-frameworks/bootstrap/v4.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="/css/adm-layout.css">
    @yield('css')
    @yield('jsHead')
</head>
<body>
  @php
      $title = 'AD Verso';
  @endphp
  @isset($return['title'])
      @php
          $home = '';
          $categorias = '';
          $bancoImagens = '';
          $galeria = '';
          $jornalistas = '';
          $colunistas = '';
          $materias = '';
          $tvadverso = '';
          $adufrgsNoAr = '';
          $adverso = '';
          $usuario = '';
          $agenda = '';

          $textosAdverso = '';
          $textosNoticias = '';
          $textosGaleria = '';
          $textosMultimidia = '';
          $textosAdufrgsNoAr = '';
          $textosAgendas = '';
          $textosColunistas = '';
          $textosImprensa = '';
          $textosContato = '';

          $title = $return['title'];

          if($title == 'ORDEM DE APRESENTAÇÃO HOME') { $home = 'active'; }
          if($title == 'Categorias-Banco de Imagens' ||
             $title == 'Categorias-Matéria' ||
             $title == 'Categorias-Colunista') { $categorias = 'active'; }
          if($title == 'Banco de imagens') { $bancoImagens = 'active'; }
          if($title == 'Galerias') { $galeria = 'active'; }
          if($title == 'Colunistas' || $title == 'Colunista - Edição') { $colunistas = 'active'; }
          if($title == 'Jornalistas' || $title == 'Jornalista - Edição') { $jornalistas = 'active'; }
          if( $title == 'Matérias - Notícia Especial' ||
              $title == 'Matérias - Notícia Normal' ||
              $title == 'Matérias - Coluna' ||
              $title == 'Matérias - Edição da Notícia Especial' ||
              $title == 'Matérias - Edição da Notícia Normal' ||
              $title == 'Matérias - Edição da Coluna')
              { $materias = 'active'; }
          if($title == 'TV ADVerso') { $tvadverso = 'active'; }
          if($title == 'Adufrgs no Ar') { $adufrgsNoAr = 'active'; }
          if($title == 'ADVerso') { $adverso = 'active'; }
          if($title == 'Agenda') { $agenda = 'active'; }
          if($title == 'Usuário') { $usuario = 'active'; }

          if($title == 'Texto Adverso') { $textosAdverso = 'active'; }
          if($title == 'Texto Notícias') { $textosNoticias = 'active'; }
          if($title == 'Texto Galeria') { $textosGaleria = 'active'; }
          if($title == 'Texto Multimídia') { $textosMultimidia = 'active'; }
          if($title == 'Texto Adufrgs No Ar') { $textosAdufrgsNoAr = 'active'; }
          if($title == 'Texto Agendas') { $textosAgendas = 'active'; }
          if($title == 'Texto Colunistas') { $textosColunistas = 'active'; }
          if($title == 'Texto Imprensa') { $textosImprensa = 'active'; }
          if($title == 'Texto Contato') { $textosContato = 'active'; }
      @endphp
  @endisset
  <?php
    $user = [];
    $user['id'] = Auth::user()->id;
    $user['name'] = Auth::user()->name;
    $user['funcao'] = Auth::user()->funcao;
    $user['type'] = Auth::user()->type;
    $user['hide'] = Auth::user()->hide;
    $user['path'] = Auth::user()->avatarPath();
  ?>
    <div id="avatar">
        <ul class="list-unstyled">
            <li class="media">
                <div class="box-img rounded-circle">
                    <a href="/adm/usuario"><img src="{{$user['path']}}" class="rounded-circle mr-3" alt="{{$user['name']}}"></a>
                </div>
                <div class="media-body text-truncate">
                  <h5 class="mt-0 mb-1"><a href="/adm/usuario">{{$user['name']}}</a></h5>
                  <a href="/adm/usuario">{{$user['funcao']}}</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3 class="text-center"><img src="/images/AdVerso-logo.png" /></h3>
                    <strong>AD</strong>
                </div>
                <ul class="list-unstyled components">
                    <!-- <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="material-icons">home</i>
                            Home
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Seção Topo</a></li>
                            <li><a href="#">Seção Filtros</a></li>
                            <li><a href="#">Seção Eventos</a></li>
                            <li><a href="#">Seção Multimídia</a></li>
                            <li><a href="#">Seção Casas</a></li>
                            <li><a href="#">Seção Parceiros</a></li>
                        </ul>
                    </li> -->

                    <li class="titulos-menus-adm">Adm Conteúdo</li>
                    <li class="{{$home}}">
                        <a href="/adm">
                            <i class="material-icons">home</i>
                            Home
                        </a>
                    </li>
                    <!-- <li class="">
                        <a href="">
                            <i class="material-icons">web</i>
                            Páginas Especiais
                        </a>
                    </li> -->
                    <li class="{{$bancoImagens}}">
                        <a href="/adm/banco-imagens">
                            <i class="material-icons">photo_library</i>
                            Banco de Imagens
                        </a>
                    </li>
                    <li class="{{$galeria}}">
                        <a href="/adm/galeria">
                            <i class="material-icons">photo_library</i>
                            Galerias de Fotos
                        </a>
                    </li>

                    <li class="{{$tvadverso}}">
                        <a href="/adm/tv-adverso">
                            <i class="material-icons">live_tv</i>
                            TV ADverso
                        </a>
                    </li>
                    <li class="{{$adufrgsNoAr}}">
                        <a href="/adm/adufrgs-no-ar">
                            <i class="material-icons">radio</i>
                            ADUFRGS no ar
                        </a>
                    </li>
                    @if ($user['type'] == 'master')
                    <li class="{{$jornalistas}}">
                        <a href="/adm/jornalistas">
                            <i class="material-icons">person_add</i>
                            Jornalistas
                        </a>
                    </li>
                    @endif
                    <li class="{{$colunistas}}">
                        <a href="/adm/colunistas">
                            <i class="material-icons">person_add</i>
                            Colunistas
                        </a>
                    </li>
                    <li class="{{$materias}}">
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="material-icons">web</i>
                            Matérias
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                              <a href="/adm/materias/noticia-especial">
                                  <i class="material-icons">subtitles</i>
                                  Notícia Especial
                              </a>
                            </li>
                            <li>
                                <a href="/adm/materias/noticia-normal">
                                  <i class="material-icons">subtitles</i>
                                  Notícia Normal
                                </a>
                            </li>
                            <li>
                                <a href="/adm/materias/coluna">
                                  <i class="material-icons">subtitles</i>
                                  Coluna
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{$adverso}}">
                        <a href="/adm/adverso">
                            <i class="material-icons">web</i>
                            ADverso
                        </a>
                    </li>
                    <li class="{{$agenda}}">
                        <a href="/adm/agenda">
                            <i class="material-icons">date_range</i>
                            Agenda
                        </a>
                    </li>
                </ul>
                <ul class="list-unstyled components">
                    <li class="titulos-menus-adm">Textos Páginas</li>

                    <li class="{{$textosAdverso}}">
                        <a href="/adm/texto-adverso">
                            <i class="material-icons">text_fields</i>
                            ADverso
                        </a>
                    </li>
                    <li class="{{$textosNoticias}}">
                        <a href="/adm/texto-noticias">
                            <i class="material-icons">text_fields</i>
                            Notícias
                        </a>
                    </li>
                    <li class="{{$textosGaleria}}">
                        <a href="/adm/texto-galeria">
                            <i class="material-icons">text_fields</i>
                            Galeria
                        </a>
                    </li>
                    <li class="{{$textosMultimidia}}">
                        <a href="/adm/texto-multimidia">
                            <i class="material-icons">text_fields</i>
                            Multimídia
                        </a>
                    </li>
                    <li class="{{$textosAgendas}}">
                        <a href="/adm/texto-agendas">
                            <i class="material-icons">text_fields</i>
                            Agendas
                        </a>
                    </li>
                    <li class="{{$textosAdufrgsNoAr}}">
                        <a href="/adm/texto-adufrgs-no-ar">
                            <i class="material-icons">text_fields</i>
                            Adufrgs No Ar
                        </a>
                    </li>
                    <li class="{{$textosColunistas}}">
                        <a href="/adm/texto-colunistas">
                            <i class="material-icons">text_fields</i>
                            Colunistas
                        </a>
                    </li>
                    <li class="{{$textosImprensa}}">
                        <a href="/adm/texto-imprensa">
                            <i class="material-icons">text_fields</i>
                            Imprensa
                        </a>
                    </li>
                    <li class="{{$textosContato}}">
                        <a href="/adm/texto-contato">
                            <i class="material-icons">text_fields</i>
                            Contato
                        </a>
                    </li>
                </ul>
                <ul class="list-unstyled list-unstyled-top">
                    <li class="titulos-menus-adm">Adm Ferramentas</li>
                    <li class="{{$categorias}}">
                        <a href="#categorias" data-toggle="collapse" aria-expanded="false">
                            <i class="material-icons">apps</i>
                            Etiquetas (CTs)
                        </a>
                        <ul class="collapse list-unstyled" id="categorias">
                            <li>
                              <a href="/adm/categorias/galeria">
                                  <i class="material-icons">loyalty</i>
                                  Banco de Imagens
                              </a>
                            </li>
                            <li>
                                <a href="/adm/categorias/colunista">
                                  <i class="material-icons">loyalty</i>
                                  Colunista
                                </a>
                            </li>
                            <li>
                                <a href="/adm/categorias/materia">
                                  <i class="material-icons">loyalty</i>
                                  Matéria
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if ($user['type'] == 'master')
                    <li class="{{$usuario}}">
                        <a href="/adm/usuarios">
                            <i class="material-icons">person</i>
                            Usuários
                        </a>
                    </li>
                    @endif
                </ul>
                <div class="m-b-40"></div>
                <!-- <ul class="list-unstyled CTAs">
                    <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li>
                    <li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>
                </ul> -->
                <div style="height: 40px;"></div>
            </nav>

            <!-- Page Content Holder -->
            <div id="content">

                <nav class="navbar navbar-default">

                    <div class="container-fluid">
                        <i id="sidebarCollapse" class="material-icons">view_compact</i>

                        <table class="table-home-title">
                            <tr> <td class="title">{{$title}}</td> </tr>
                        </table>

                        <div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>

                    </div>
                </nav>

                <div class="container-fluid">
                        <div class="col-md-12 p-0">
                            @yield('content')
                        </div>
                </div>

            </div>
        </div>


    <?php /*
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    */ ?>

    <!-- <script src="/plugins-frameworks/jquery/v3.3.1/jquery-3.3.1.min.js"></script>
    <script src="/plugins-frameworks/bootstrap/v4.0.0/js/boostrap.min.js"></script>
    <script src="/plugins-frameworks/bootstrap/v4.0.0/js/popperV1.12.9.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#avatar').toggleClass('active');
            });
        });
    </script>
    <!-- Scripts -->
    <!--script src="{{ asset('js/app.js') }}"></script-->

    @yield('js')
</body>
</html>
