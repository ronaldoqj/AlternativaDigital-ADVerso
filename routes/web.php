<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\NoticiaController;

use App\Http\Controllers\ColunistasController;


use App\Http\Controllers\AgendasController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ColunistaController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\AdversoController;
use App\Http\Controllers\TvAdversoController;
use App\Http\Controllers\AdufrgsNoArController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\ImprensaController;
use App\Http\Controllers\ContatoController;

use App\Http\Controllers\AjaxsController;

// Adm
use App\Http\Controllers\Adm\HomeController as AdmHomeController;
use App\Http\Controllers\Adm\AdversoController as AdmAdversoController;
use App\Http\Controllers\Adm\BancoImagensController as AdmBancoImagensController;
use App\Http\Controllers\Adm\GaleriaController as AdmGaleriaController;

use App\Http\Controllers\Adm\CategoriasController as AdmCategoriasController;
use App\Http\Controllers\Adm\ColunistasController as AdmColunistasController;
use App\Http\Controllers\Adm\JornalistasController as AdmJornalistasController;
use App\Http\Controllers\Adm\MateriasController as AdmMateriasController;
use App\Http\Controllers\Adm\TvAdversoController as AdmTvAdversoController;
use App\Http\Controllers\Adm\AdufrgsNoArController as AdmAdufrgsNoArController;
use App\Http\Controllers\Adm\PaginasController as AdmPaginasController;
use App\Http\Controllers\Adm\AgendaController as AdmAgendaController;
use App\Http\Controllers\Adm\UserController as AdmUserController;
use App\Http\Controllers\Adm\UsersController as AdmUsersController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Route::get('/adverso', function () { return view('adverso'); });
Route::get('/adverso', [AdversoController::class, 'index'])->name('adverso');
Route::match(['get', 'post'], '/noticias/{id?}', [NoticiasController::class, 'index'])->name('noticias');
Route::match(['get', 'post'], '/noticia/{id?}/{title?}/{previsualizar?}', [NoticiaController::class, 'index'])->name('noticia');
Route::match(['get', 'post'], '/colunistas/{id?}/{title?}', [ColunistasController::class, 'index'])->name('colunistas');
Route::match(['get', 'post'], '/agendas/{id?}/{title?}', [AgendasController::class, 'index'])->name('agendas');
Route::match(['get', 'post'], '/agenda/{id?}/{title?}/{previsualizar?}', [AgendaController::class, 'index'])->name('agenda');
Route::match(['get', 'post'], '/colunista/{id?}/{title?}/{previsualizar?}', [ColunistaController::class, 'index'])->name('colunista');
Route::match(['get', 'post'], '/galeria/{id?}', [GaleriaController::class, 'index'])->name('galeria');
Route::match(['get', 'post'], '/tv-adverso/{id?}', [TvAdversoController::class, 'index'])->name('tv-adverso');
Route::match(['get', 'post'], '/adufrgs-no-ar/{id?}', [AdufrgsNoArController::class, 'index'])->name('adufrgs-no-ar');
Route::match(['get', 'post'], '/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa');

Route::match(['get', 'post'], '/imprensa', [ImprensaController::class, 'index'])->name('imprensa');
Route::match(['get', 'post'], '/contato', [ContatoController::class, 'index'])->name('contato');


// Ajaxs
Route::any('/ajax_registerNewsLetter', [AjaxsController::class, 'ajax_registerNewsLetter'])->name('ajaxRegisterNewsLetter');
Route::any('/ajax_selectNoticias/{paginacao?}/{NRegistros?}', [AjaxsController::class, 'ajax_selectNoticias'])->name('ajaxSelectNoticias');

// Route::match(['get', 'post'], '/home', 'HomeController@index');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'adm'], function () {
    Route::match(['get', 'post'], '/', [AdmHomeController::class, 'index']);
    Route::match(['get', 'post'], '/home', [AdmHomeController::class, 'index'])->name('adm-home');
    Route::match(['get', 'post'], '/adverso/{id?}', [AdmAdversoController::class, 'index'])->name('adm-adverso');
    Route::match(['get', 'post'], '/banco-imagens/{id?}', [AdmBancoImagensController::class, 'index'])->name('adm-banco-imagens');
    Route::match(['get', 'post'], '/galeria/{id?}', [AdmGaleriaController::class, 'index'])->name('adm-galeria');
    Route::match(['get', 'post'], '/categorias/galeria/{id?}', [AdmCategoriasController::class, 'galeria'])->name('adm-categorias-galeria');
    Route::match(['get', 'post'], '/categorias/materia/{id?}', [AdmCategoriasController::class, 'materia'])->name('adm-categorias-materia');
    Route::match(['get', 'post'], '/categorias/colunista/{id?}', [AdmCategoriasController::class, 'colunista'])->name('adm-categorias-colunista');
    Route::match(['get', 'post'], '/colunistas/{id?}', [AdmColunistasController::class, 'index'])->name('adm-colunistas');
    Route::match(['get', 'post'], '/edit-colunistas/{id?}', [AdmColunistasController::class, 'edit'])->name('adm-edit-colunistas');
    Route::match(['get', 'post'], '/jornalistas/{id?}', [AdmJornalistasController::class, 'index'])->name('adm-jornalistas');
    Route::match(['get', 'post'], '/edit-jornalistas/{id?}', [AdmJornalistasController::class, 'edit'])->name('adm-edit-jornalistas');
    Route::match(['get', 'post'], '/materias/noticia-especial/{id?}', [AdmMateriasController::class, 'noticiaEspecial'])->name('adm-materias-noticia-especial');
    Route::match(['get', 'post'], '/materias/noticia-normal/{id?}', [AdmMateriasController::class, 'noticiaNormal'])->name('adm-materias-noticia-normal');
    Route::match(['get', 'post'], '/materias/coluna/{id?}', [AdmMateriasController::class, 'coluna'])->name('adm-materias-coluna');

    Route::match(['get', 'post'], '/materias/edit-noticia-especial/{id?}', [AdmMateriasController::class, 'editNoticiaEspecial'])->name('adm-edit-materias-noticia-especial');
    Route::match(['get', 'post'], '/materias/edit-noticia-normal/{id?}', [AdmMateriasController::class, 'editNoticiaNormal'])->name('adm-edit-materias-noticia-normal');
    Route::match(['get', 'post'], '/materias/edit-coluna/{id?}', [AdmMateriasController::class, 'editNoluna'])->name('adm-edit-materias-coluna');

    Route::match(['get', 'post'], '/materia/pre-visualizar/{type}/{id}', [AdmMateriasController::class, 'preVisualizar'])->name('adm-edit-materias-pre-visualizar');

    Route::match(['get', 'post'], '/tv-adverso/{id?}', [AdmTvAdversoController::class, 'index'])->name('adm-tv-adverso');
    Route::match(['get', 'post'], '/adufrgs-no-ar/{id?}', [AdmAdufrgsNoArController::class, 'index'])->name('adm-adufrgs-no-ar');

    Route::match(['get', 'post'], '/texto-adverso', [AdmPaginasController::class, 'adverso'])->name('adm-pagina-adverso');
    Route::match(['get', 'post'], '/texto-noticias', [AdmPaginasController::class, 'noticias'])->name('adm-pagina-noticias');
    Route::match(['get', 'post'], '/texto-galeria', [AdmPaginasController::class, 'galeria'])->name('adm-pagina-galeria');
    Route::match(['get', 'post'], '/texto-multimidia', [AdmPaginasController::class, 'multimidia'])->name('adm-pagina-multimidia');
    Route::match(['get', 'post'], '/texto-adufrgs-no-ar', [AdmPaginasController::class, 'adufrgsNoAr'])->name('adm-pagina-adufrgsNoAr');
    Route::match(['get', 'post'], '/texto-agendas', [AdmPaginasController::class, 'agendas'])->name('adm-pagina-agendas');
    Route::match(['get', 'post'], '/texto-colunistas', [AdmPaginasController::class, 'colunistas'])->name('adm-pagina-colunistas');
    Route::match(['get', 'post'], '/texto-imprensa', [AdmPaginasController::class, 'imprensa'])->name('adm-pagina-imprensa');
    Route::match(['get', 'post'], '/texto-contato', [AdmPaginasController::class, 'contato'])->name('adm-pagina-contato');
    Route::match(['get', 'post'], '/agenda', [AdmAgendaController::class, 'index'])->name('adm-agenda');
    Route::match(['get', 'post'], '/agenda/edit/{id}', [AdmAgendaController::class, 'edit'])->name('adm-agenda-edit');

    Route::match(['get', 'post'], '/usuario', [AdmUserController::class, 'index'])->name('adm-usuario');
    Route::match(['get', 'post'], '/usuarios', [AdmUsersController::class, 'index'])->name('adm-usuarios');
    Route::match(['get', 'post'], '/usuarios/edit/{id}', [AdmUsersController::class, 'edit'])->name('adm-usuarios-edit');
});















//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
