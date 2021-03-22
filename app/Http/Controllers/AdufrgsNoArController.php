<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdufrgsNoAr;
use Classes\Helpers;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Texto;

class AdufrgsNoArController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
      $return = ['title' => 'TV ADVerso'];
      $erros = false;
      $firstCall = true;

      $registers = new AdufrgsNoAr();
      $categoriaAll = $registers->all()->sortByDesc('order'); //Retorna todos registros
      $return['registers'] = $categoriaAll;

      $pagina = 'texto-adufrgs-no-ar';
      $select = new Texto();
      $selectLista = $select->all()->where('pagina', $pagina)->first();
      $return['texto'] = $selectLista;

      return view('adufrgs-no-ar')->withReturn($return);
    }


}
