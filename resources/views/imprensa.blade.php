<?php
    $texto = $return['texto'];
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
            <div class="title-pages">Imprensa</div>
            {!!$texto->text ?? '<div class="m-b-40"></div>'!!}
        </div>
    </div>
</div>

@endsection
