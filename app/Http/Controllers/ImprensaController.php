<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Texto;

class ImprensaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $return = [];
        $pagina = 'texto-imprensa';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina)->first();
        $return['texto'] = $selectLista;
        return view('imprensa')->withReturn($return);
    }
}
