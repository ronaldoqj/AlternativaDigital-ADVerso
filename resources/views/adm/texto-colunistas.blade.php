<?php
    $register = $return['register'];
?>
@extends('layouts.adm')
@section('css')
    <style>
        label { margin-bottom: 0rem; }
        .card-header { cursor: pointer; }
        .card .border-secondary { margin: 5px 0; }
        .text-secondary { padding: 8px; }
        .btns-listagem { padding-top: 3px; height: 40px; }
        .btns-listagem .btn { padding: 3px 8px 0px; }
        .col-form-label { word-wrap:normal; }
        .imagesList:hover { border: solid 3px #999; opacity: 0.8; cursor: pointer; transition: 0.2s ease-out; }
        .imagesList { cursor: pointer; opacity: 1; border: solid 0px #999; transition: 0.2s; }
        .explicacao { font-size: 0.8em; line-height: 1.1em; color: #888; margin-top: 3px; }
        .italico { font-style: italic; text-decoration: underline; }
        .idNegrito { color: black; font-weight: bold; font-style: normal; text-decoration: underline; }
        .card .card-body .card-body { padding: 0.65rem; }

        /* Galeria */
        .thumbs { width: 102px; float: left; margin: 8px; }
        .btnThumbs { font-size: 0px; padding: 3px 13px 6px; }
        .btnThumbsImages { font-size: 0px; padding: 0px 4px 5px; }
        .inputThumb { width: 250px; }
        .custom-control-inline { margin-right: 0.5rem; }
        .custom-control { padding-left: 1.2rem; }
    </style>
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins-frameworks/ckeditor/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 m-b-20">
                <div class="card border-dark">
                    <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                        {{ csrf_field() }}
                        <div class="card-header">
                            Texto Colunistas
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <!-- <label for="inputText">Texto Jurídico:</label> -->
                                    <textarea id="inputText" name="text">{!!$register->text!!}</textarea>
                                    <script type="text/javascript">
                                        CKEDITOR.replace( 'inputText' );
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <button type="submit" id="bt-cadastrar-editar" class="btn btn-outline-success btn-block">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
