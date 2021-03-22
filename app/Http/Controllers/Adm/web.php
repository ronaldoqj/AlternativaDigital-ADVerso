<?php

Route::get('/', 'IndexController@index');
Route::get('/sobre-nos', 'AboutUsController@index');
Route::get('/sobre-nos/nosso-trabalho', 'AboutUsController@ourWork');
Route::get('/sobre-nos/governanca-corporativa', 'AboutUsController@corporateGovernance');
Route::get('/investimentos', 'InvestmentsController@index');
Route::get('/investimentos/download', 'InvestmentsController@investimentsDownload');
Route::get('/investimentos/processo-de-investimento', 'InvestmentsController@investmentProcess');
Route::get('/investimentos/fundos-de-investimento', 'InvestmentsController@investmentFunds');
Route::get('/investimentos/fundos-de-investimento/renda-fixa', 'InvestmentsController@investmentFundsFixedIncome');
Route::get('/investimentos/fundos-de-investimento/renda-fixa/download/{id?}', 'InvestmentsController@investmentFundsFixedIncomeDownloads');
Route::get('/investimentos/fundos-de-investimento/credito-privado', 'InvestmentsController@investmentFundsPrivateCredit');
Route::get('/investimentos/fundos-de-investimento/credito-privado/download', 'InvestmentsController@investmentFundsPrivateCreditDownload');
Route::get('/investimentos/fundos-de-investimento/multimercado', 'InvestmentsController@investmentFundsMultimarket');
Route::get('/investimentos/fundos-de-investimento/multimercado/download/{id?}', 'InvestmentsController@investmentFundsMultimarketDownloads');
Route::get('/investimentos/fundos-de-investimento/acoes', 'InvestmentsController@investmentFundsActions');
Route::get('/investimentos/fundos-de-investimento/acoes/download', 'InvestmentsController@investmentFundsActionsDownload');
Route::get('/investimentos/fundos-de-investimento/investimentos-no-exterior', 'InvestmentsController@investmentFundsInvestmentsAbroad');
Route::get('/investimentos/fundos-de-investimento/investimentos-no-exterior/download', 'InvestmentsController@investmentFundsInvestmentsAbroadDownload');
Route::get('/investimentos/fundos-de-investimento/produto-sob-medida', 'InvestmentsController@investmentFundsCustomProduct');
Route::get('/investimentos/cota-diaria', 'InvestmentsController@dailyQuota');
Route::get('/politicas-e-manuais/{file?}', 'PoliciesAndManualsController@index');
Route::get('/na-midia/{id?}', 'InTheMediaController@index');
Route::match(['get', 'post'], '/contato', 'ContactController@index');

Auth::routes();
Route::match(['get', 'post'], '/ADM/', 'Adm\HomeController@index');
Route::group(['prefix' => 'adm'], function () {
    Route::match(['get', 'post'], '/', 'Adm\HomeController@index');
    Route::match(['get', 'post'], '/usuario', 'Adm\UserController@index');
    Route::match(['get', 'post'], '/home', 'Adm\HomeController@index');
    Route::match(['get', 'post'], '/cota-diaria', 'Adm\HomeController@index');
    Route::match(['get', 'post'], '/documentos', 'Adm\DocumentsController@index');
    Route::match(['get', 'post'], '/funcionarios', 'Adm\OfficesController@index');
    Route::match(['get', 'post'], '/na-midia', 'Adm\InTheMediaController@index');
    Route::match(['get', 'post'], '/seo', 'Adm\SeoController@index');
});