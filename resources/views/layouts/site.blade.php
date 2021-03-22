<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" maximum-scale="1.0"/>

    @yield('metatags')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{-- config('app.title') --}}Portal Adverso - ADUFRGS-Sindical</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/plugins-frameworks/materialize/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    @yield('css')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122533034-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-122533034-1');
    </script>
</head>
<body>
    <div id="voltarAoTopo"></div>
    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="fechar-menu-mobile">X</div>

                <div class="menu-mobile-info">
                    <div><a href="/"><img src="/images/AdVerso-logo.png" width="162" height="62" alt="ADVerso" title="ADVerso" /></a></div>
                    <div><a href="#">Portal ADverso</a></div>
                    <div class="p-l-16">51. 3228 1188</div>
                    <div><a href="#">contato@portaladverso.com.br</a></div>
                    <div><a href="#"><img src="/images/Adufrgs-sindical.png" width="79" height="23" /></a></div>
                </div>
            </div>
        </li>

        <li>
            <div style="margin-left:15px;">
            <form action="/pesquisa" method="post">
                {{ csrf_field() }}
                <input name="pesquisa" id="bt-search" class="browser-default" type="text" placeholder="Buscar" value="" required />
                <input type="submit" value="Pesquisar" />
            </form>
            </div>
        </li>
        <li><a class="waves-effect" href="/adverso">ADVERSO</a></li>
        <li><a class="waves-effect" href="/noticias">NOTÍCIAS</a></li>
        <li><a class="waves-effect" href="/galeria">GALERIA</a></li>
        <li><a class="waves-effect" href="/tv-adverso">MULTIMÍDIA</a></li>
        <li><a class="waves-effect" href="/colunistas">COLUNISTAS</a></li>
        <li><a class="waves-effect" href="/imprensa">IMPRENSA</a></li>
        <li><a class="waves-effect" href="/contato">CONTATO</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">Redes Sociais</a></li>
        <li><a class="waves-effect" target="_blank" href="https://www.facebook.com/adufrgssindical/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i> <span class="m-l--20">Facebook</span></a> </li>
        <li><a class="waves-effect" target="_blank" href="https://twitter.com/adufrgssindical" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i>  <span class="m-l--20">Twitter</span></a>  </li>
        <li><a class="waves-effect" target="_blank" href="https://www.instagram.com/adufrgssindical/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i> <span class="m-l--20">Istagram</span></a>  </li>
        <li><a class="waves-effect" target="_blank" href="https://www.youtube.com/user/CanalADUFRGS" title="Youtube"><i class="fontello-icon icon-youtube">&#xe804;</i> <span class="m-l--20">Youtube</span></a>  </li>
        <li>&nbsp;<br/>&nbsp;</li>
    </ul>

    <div class="menu-desktop">
        <div class="container background-top hide-desketop-and-down">
            <div class="row">
                <div class="col s2 m-t-28">
                    <a href="/"><img src="/images/AdVerso-logo.png" width="162" height="62" alt="ADVerso" title="ADVerso" /></a>
                </div>
                <div class="col s10">
                    <div class="menus">
                        <div class="menu-social">
                            <ul>

                                <li>
                                    <div class="group-social-network ">
                                        <ul expand="false">
                                            <li class="lupa"><a href="#"><i class="fontello-icon icon-lupa">&#xe810;</i></a></li>
                                            <li>
                                                <div buscar>Buscar</div>
                                                <div campo>
                                                    <form action="/pesquisa" method="post">
                                                        {{ csrf_field() }}
                                                        <ul>
                                                            <li><div id="search" class="close-search">X</div></li>
                                                            <li><input name="pesquisa" id="bt-search" class="browser-default" type="text" placeholder="Buscar" value="" required /></li>
                                                            <li><input type="submit" value="Pesquisar" /></li>
                                                        </ul>
                                                    </form>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <div class="group-social-network">
                                        <ul>
                                            <li><div redes-sociais>Redes sociais</div></li>
                                            <li><a target="_blank" href="https://www.facebook.com/adufrgssindical/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                            <li><a target="_blank" href="https://twitter.com/adufrgssindical" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                            <li><a target="_blank" href="https://www.instagram.com/adufrgssindical/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a></li>
                                            <li><a target="_blank" href="https://www.youtube.com/user/CanalADUFRGS" title="Youtube"><i class="fontello-icon icon-youtube">&#xe804;</i></a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="#"><img src="/images/Adufrgs-sindical.png" width="79" height="23" /></a></li>
                            </ul>
                        </div>
                        <div class="menu-principal clearfix">
                            <div class="principal-itens">
                                <ul>
                                    <li><a href="/adverso">ADVERSO</a></li>
                                    <li><a href="/noticias">NOTÍCIAS</a></li>
                                    <li><a href="/galeria">GALERIA</a></li>
                                    <li><a href="/tv-adverso">MULTIMÍDIA</a></li>
                                    <li><a href="/colunistas">COLUNISTAS</a></li>
                                    <li><a href="/imprensa">IMPRENSA</a></li>
                                    <li><a href="/contato">CONTATO</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-mobile show-xlarge clearfix">
            <div class="container">
                <div class="menu-icone right"><a href="#" data-target="slide-out" class="sidenav-trigger"><i class="fontello-icon icon-menu">&#xe800;</i></a></div>
                <div class="logo center valign-wrapper logo-mobile-left"><a href="/"><img src="/images/AdVerso-logo.png" width="131" height="50" alt="ADVerso" title="ADVerso" /></a></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    <!-- Modal Newsletter -->
    <div id="alert" class="modal modal-fixed-footer">
        <div class="modal-content">
            <div class="form-news-letter">
                <div class="col s12 title-alert">Realizado com sucesso!</div>
                <hr />
                <div class="col s12 text-alert">Realizado com sucesso!</div>
            </div>
        </div>

        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>


    @yield('content')

    <footer>
        <div class="container background-top hide-desketop-and-down">
            <div class="row">
                <div class="col s4 m-t-28">
                    <a href="/"><img src="/images/AdVerso-logo-negativo.png" width="162" height="62" alt="ADVerso" title="ADVerso" /></a>
                    <div class="footer-logo-text">
                        A Revista ADverso, após 30 anos no papel, se transformou numa página multimídia dedicada a temas de educação, pesquisa e assuntos sindicais.
                    </div>
                </div>
                <div class="col s8">
                    <div class="menus">
                        <div class="menu-principal clearfix">
                            <div class="principal-itens">
                                <ul>
                                    <li><a href="/adverso">ADVERSO</a></li>
                                    <li><a href="/noticias">NOTÍCIAS</a></li>
                                    <li><a href="/galeria">GALERIA</a></li>
                                    <li><a href="/tv-adverso">MULTIMÍDIA</a></li>
                                    <li><a href="/colunistas">COLUNISTAS</a></li>
                                    <li><a href="/imprensa">IMPRENSA</a></li>
                                    <li><a href="/contato">CONTATO</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="menu-social">
                        <ul>
                            <li>
                                <div class="group-social-network">
                                    <ul>
                                        <li><div redes-sociais>Redes sociais</div></li>
                                        <li><a target="_blank" href="https://www.facebook.com/adufrgssindical/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                        <li><a target="_blank" href="https://twitter.com/adufrgssindical" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                        <li><a target="_blank" href="https://www.instagram.com/adufrgssindical/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a></li>
                                        <li><a target="_blank" href="https://www.youtube.com/user/CanalADUFRGS" title="Youtube"><i class="fontello-icon icon-youtube">&#xe804;</i></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-mobile show-xlarge clearfix">
            <div class="container">

                <div class="row">
                    <div class="col s12 center-align footer-logo-mobile">
                        <a href="/"><img src="/images/AdVerso-logo-negativo.png" width="162" height="62" alt="ADVerso" title="ADVerso" /></a>
                        <div class="footer-logo-text">
                            A Revista ADverso, após 30 anos no papel, se transformou numa página multimídia dedicada a temas de educação, pesquisa e assuntos sindicais.
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="footer-menu-mobile">
                            <ul>
                                <li>
                                    <div class="group-social-network">
                                        <ul>
                                            <li><div redes-sociais>Redes sociais</div></li>
                                            <li><a target="_blank" href="https://www.facebook.com/adufrgssindical/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                            <li><a target="_blank" href="https://twitter.com/adufrgssindical" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>
                                            <li><a target="_blank" href="https://www.instagram.com/adufrgssindical/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a></li>
                                            <li><a target="_blank" href="https://www.youtube.com/user/CanalADUFRGS" title="Youtube"><i class="fontello-icon icon-youtube">&#xe804;</i></a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
        <div id="alternativa-digital">
            <a href="http://alternativadigital.com.br" target="_blank"><img src="/images/alternativa-digital.png" width="245" height="29" alt="Alternativa Digital" title="Alternativa Digital" /></a>
        </div>
    </footer>

    <!--  Scripts-->
    <script src="/plugins-frameworks/jquery/v3.3.1/jquery-3.3.1.min.js"></script>
    <script src="/plugins-frameworks/materialize/js/materialize.js"></script>
    <script src="/js/init.js"></script>
    @yield('js')
</body>
</html>
