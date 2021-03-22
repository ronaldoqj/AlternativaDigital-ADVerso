<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FileGaleria;
use App\Models\Galeria;
use App\Models\GaleriaHasImagem;
use App\Models\Texto;

class GaleriaController extends Controller
{
    public function __construct() {}

    public function index(Request $request, $tipo = 'simples')
    {
        $return = ['title' => 'Galeria de Fotos'];

        $listGaleria = new Galeria();
        $return['galerias'] = $listGaleria->all()->sortByDesc('order');
        $listGaleria = new Galeria();
        $return['files'] = $listGaleria->listImages();

        $pagina = 'texto-galeria';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina)->first();
        $return['texto'] = $selectLista;

        return view('galeria')->withReturn($return);
    }
}
