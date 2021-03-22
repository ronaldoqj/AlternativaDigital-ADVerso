<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileGaleria;
use App\Models\File;
use App\Models\Revista;
use App\Models\RevistaHasImagem;
use App\Models\Texto;

class AdversoController extends Controller
{
    public function __construct() { }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'ADVerso'];

        $listRevistas = new Revista();
        $return['revistas'] = $listRevistas->all()->sortByDesc('order');
        // $return['revistas'] = $listGaleria->all()->sortByDesc('order');

        $file = new File();
        $return['files'] = $file->listGaleria();

        $pagina = 'texto-adverso';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina)->first();
        $return['texto'] = $selectLista;

        $revistaHasImagem = new File();
        $return['revistaHasImagem'] = $file->listGaleriaEditar();
        return view('adverso')->withReturn($return);
    }

}
