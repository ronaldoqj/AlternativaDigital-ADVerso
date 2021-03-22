@php
  $galerias = $return['galerias'];
  $files = $return['files'];
  $texto = $return['texto'];
  $fileIdGaleria = '';
  $cont = 0;
  $contScript = 0;
@endphp
@extends('layouts.site')

@section('css')
    <link href="/css/pages/galeria.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="/plugins-frameworks/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins-frameworks/owl_carousel/owl.theme.css" rel="stylesheet">
    <!-- lightbox  -->
    <link rel="stylesheet" href="/plugins-frameworks/lightbox/css/lightbox.min.css">
@endsection

@section('js')
<script src="/js/pages/galeria.js"></script>
<script src="/plugins-frameworks/owl_carousel/owl.carousel.js"></script>
<!-- lightbox -->
<script src="/plugins-frameworks/lightbox/js/lightbox.min.js"></script>
<script>
    $(document).ready(function()
    {
        @foreach ($galerias as $galeria)
            $("#owl-home-galeria{{$contScript}}").owlCarousel({
                //autoPlay : 4000,
                items : 2,
                itemsDesktop : [1200,2],
                itemsDesktopSmall : [979,1],
                itemsTablet: [600,1], //2 items between 600 and 0
                itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
            });
            @php
              $contScript++;
            @endphp
        @endforeach
    });
</script>

@endsection

@section('content')
<!-- ======================================================================= -->
<!-- Galeria                                                                 -->
<!-- ======================================================================= -->
<div class="container-fluid galeria">
    <div class="container m-t-50 box-conteudo">
        <div class="row">

            <div class="title-pages">Galeria de fotos</div>
            <!-- <p class="subtitle-pages">Descubra as imagens que compõem o acervo do Portal ADverso. Cada galeria tem sua própria descrição. Faça buscas por temas.</p> -->
            {!!$texto->text ?? '<div class="m-b-40"></div>'!!}

            <!-- Galeria 1 -->
            @php
              $contScript = 0;
            @endphp
            @forelse ($galerias as $galeria)

                   <div class="descricao-galeria">
                    <p class="titles">{{$galeria->title}}</p>
                    <p class="subtitles">{{$galeria->description}}</p>
                </div>


                <div id="owl-home-galeria{{$contScript}}" class="owl-home-galeria">

                @for ($i = 0; $i < count($files); $i++)
                    @if($files[$i]->id_galeria == $galeria->id)
                        @php
                            $cont++;
                            if($cont > 6) { $cont = 0; }
                            $nextItem = isset($files[$i + 1]->id_galeria) ? $files[$i + 1]->id_galeria : null;
                        @endphp
                        @if($cont == 1)
                            <div class="item home-galeria" style="color: white;">
                                <div class="galeria-item">
                        @endif
                                    <a href="/{{$files[$i]->namefilefull}}" data-lightbox="galeria{{$galeria->id}}" data-title="{{$files[$i]->name}}">
                                        <div class="img-{{$cont}}" style="background-image: url(/{{$files[$i]->namefilefull}});"></div>
                                    </a>
                        @if($cont == 6 || $files[$i]->id_galeria != $nextItem)
                            @php
                                $cont = 0;
                            @endphp
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    @endif
                @endfor

                </div>
             <br><br><br>

                @php
                  $contScript++;
                @endphp

            @empty
                <p>Nenhum galeria cadastrada no momento.</p>
            @endforelse


            <!--
            <div id="owl-home-galeria1" class="owl-home-galeria">
                <div class="item home-galeria" style="color: white;">
                    <div class="galeria-item">
                        <div class="img-1" style="background-image: url('/images/galeria1.jpg');"></div>
                        <div class="img-2" style="background-image: url('/images/galeria2.jpg');"></div>
                        <div class="img-3" style="background-image: url('/images/galeria3.jpg');"></div>
                        <div class="img-4" style="background-image: url('/images/galeria4.jpg');"></div>
                        <div class="img-5" style="background-image: url('/images/galeria5.jpg');"></div>
                        <div class="img-6" style="background-image: url('/images/galeria6.jpg');"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="item home-galeria" style="color: white;">
                    <div class="galeria-item">
                        <div class="img-1" style="background-image: url('/images/galeria1.jpg');"></div>
                        <div class="img-2" style="background-image: url('/images/galeria2.jpg');"></div>
                        <div class="img-3" style="background-image: url('/images/galeria3.jpg');"></div>
                        <div class="img-4" style="background-image: url('/images/galeria4.jpg');"></div>
                        <div class="img-5" style="background-image: url('/images/galeria5.jpg');"></div>
                        <div class="img-6" style="background-image: url('/images/galeria6.jpg');"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="descricao-galeria">
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut</p>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut</p>
            </div>
             -->
<!--
        <div class="container text-center">
            <div class="title-carregar-mais">Carregar mais galerias</div>
        </div>
-->

    </div>
</div>

@endsection
