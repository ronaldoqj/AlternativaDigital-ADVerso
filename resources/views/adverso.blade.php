<?php
  $revistas = $return['revistas'];
  $revistaHasImagem = $return['revistaHasImagem'];
  $texto = $return['texto'];
  $files = $return['files'];
  $fileIdGaleria = '';
  $cont = 0;
  $contScript = 0;
?>
@extends('layouts.site')

@section('css')
    <link href="/css/pages/adverso.css" type="text/css" rel="stylesheet" media="screen,projection"/>
@endsection

@section('js')
<script src="/js/pages/adverso.js"></script>
@endsection

@section('content')

<!-- ======================================================================= -->
<!-- Galeria de fotos                                                        -->
<!-- ======================================================================= -->
<div class="container-fluid galeria">
    <div class="container m-t-50 box-conteudo">
        <div class="row">

            <div class="title-pages m-b-40">ADVerso</div>

            {!!$texto->text ?? '<div class="m-b-40"></div>'!!}
            <!-- <div class="oportal">O portal ADverso</div>

            <p>Seja bem-vindo ao Portal ADverso.</p>
            <p>A Revista ADverso, após 30 anos no papel, se transformou numa página multimídia dedicada a temas de educação, pesquisa e assuntos sindicais.</p>
            <p>Queremos que este espaço seja um difusor de ideias sobre questões importantes para a educação brasileira.</p>
            <p>O conteúdo agora é interativo e produzido em diferentes linguagens de forma mais organizada e dinâmica.</p>
            <p>Fotos, vídeos, áudios, reportagens especiais, artigos, infográficos e matérias passam a traduzir de forma simples e direta a luta da Adufrgs-Sindical em defesa da educação pública, universal e de qualidade.</p>
            <p>Expandir as fronteiras da revista foi uma decisão de ampliar as ferramentas de comunicação nessa luta. A defesa da educação pública conquistou mais esse espaço que pretende ser referência na produção de conteúdo informativo e analítico.</p>
            <p>Agora, temos um canal com vídeos, matérias e coberturas de eventos, a TV ADverso.</p>
            <p>Acompanhe também os programas Adufrgs no ar, os especiais, artigos de colunistas ADverso e utilize nosso campo de busca para encontrar temas de seu interesse.</p>
            <p>Assine nossa newsletter e receba o conteúdo do portal diretamente no seu email.</p>
            <p>Compartilhe os conteúdos nas redes sociais.</p>
            <p>Todas as edições impressas da revista continuam disponíveis para leitura. Acesse as edições abaixo.</p>
            <p>Você pode sugerir pautas e coberturas e fazer críticas e propostas pelo email comunica@adufrgs.org.br</p>
            <p>Entre agora e comece a explorar.</p> -->

            @php
              $contScript = 0;
            @endphp
            @forelse ($revistas as $revista)
                <div class="title-pages m-t-50">{{$revista->title}}</div>

                <div class="revista">
                    <div class="carousel img-revista">
                        @foreach ($revistaHasImagem as $file)
                            @if($file->revistas_has_imagem_id_revista == $revista->id)
                            <?php
                                $link = '#Não-Possui-Link';
                                if ($file->revistas_has_imagem_link != '') { $link = $file->revistas_has_imagem_link; }
                            ?>
                                <a class="carousel-item" href="{{$link}}" target="_blank">
                                    <img src="{{url('/'.$file->namefilefull)}}" width="200" class="cover" />
                                    <!-- <div class="img-revista" style="background-image: url({{'/'.$file->namefilefull}});></div> -->
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                @php
                  $contScript++;
                @endphp

            @empty
                <!-- <p>Nenhum edição cadastrada no momento.</p> -->
            @endforelse

            <?php /*
            <div class="title-pages m-t-50">Edições impressas</div>

            <div class="revista">
                <div class="carousel">
                    <a class="carousel-item" href="#one!"><img src="/images/ADVerso/img3.jpg"></a>
                    <a class="carousel-item" href="#two!"><img src="/images/ADVerso/img2.jpg"></a>
                    <a class="carousel-item" href="#three!"><img src="/images/ADVerso/img1.jpg"></a>
                    <a class="carousel-item" href="#four!"><img src="/images/ADVerso/img3.jpg"></a>
                    <a class="carousel-item" href="#five!"><img src="/images/ADVerso/img2.jpg"></a>
                </div>
            </div>
            */ ?>
        </div>
    </div>
</div>

@endsection
