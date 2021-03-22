<?php
    $texto = $return['texto'];
?>
@extends('layouts.site')

@section('css')
    <link href="/css/pages/contato.css" type="text/css" rel="stylesheet" media="screen,projection"/>
@endsection

@section('js')
@endsection

@section('content')

<!-- ======================================================================= -->
<!-- Galeria de fotos                                                        -->
<!-- ======================================================================= -->
<div class="container-fluid galeria">
    <div class="container m-t-50 box-conteudo">
        <div class="row">
            <div class="title-pages">Contato</div>

            <div class="col m12 l5">
                <div class="logo-contato"><img src="/images/logo-contato.png" class="responsive-img"></div>
                {!!$texto->text ?? '<div class="m-b-40"></div>'!!}
            </div>
            <div class="col m12 l7">
                <form action="">
                <div class="box-contato">
                    <p>Você pode enviar sua mensagem para a equipe do Portal ADverso nos campos abaixo. Sugestões são sempre necessárias para melhorarmos nossa produção. Deixe seus contatos.</p>

                    <div class="form-contato">
                        <div class="labels-input">NOME</div>
                        <div class="inputs-contato">
                            <input type="text" name="nome" value="" class="browser-default" placeholder="NOME" required />
                        </div>
                        <div class="labels-input">TELEFONE</div>
                        <div class="inputs-contato">
                            <input type="tel" name="fone" value="" class="browser-default" placeholder="TELEFONE" required />
                        </div>
                        <div class="labels-input">E-MAIL</div>
                        <div class="inputs-contato">
                            <input type="email" name="email" value="" class="browser-default" placeholder="E-MAIL" required />
                        </div>
                        <div class="labels-input">ASSUNTO</div>
                        <div class="inputs-contato">
                            <input type="text" name="assunto" value="" class="browser-default" placeholder="ASSUNTO" required />
                        </div>
                        <div class="labels-input">MENSAGEM</div>
                        <textarea id="mensagem" name="mensagem" class="browser-default text-area" rows="7" placeholder="MENSAGEM" required></textarea>

                        <input type="submit" id="cadastrar" class="btn" value="ENVIAR" />
                    </div>
                </div>
                </form>
            </div>


        </div>
    </div>
</div>

@endsection
