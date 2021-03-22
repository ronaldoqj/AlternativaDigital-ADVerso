<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesquisa;

class PesquisaController extends Controller
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
        $return = ['retorno' => false, 'pesquisa' => []];
        if ($request->isMethod('post'))
        {
            $inputPesquisa = $request->input('pesquisa');
            $pesquisa = new Pesquisa();
            $return = $pesquisa->pesquisa($inputPesquisa);
            // dd($return);
        }
        return view('pesquisa')->withReturn($return);
    }
}
