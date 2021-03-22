<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\AdmHome;
use App\Models\Newsletter;

class AjaxsController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
    }

    public function ajax_selectNoticias(Request $request)
    {
        // Declaração de variaveis
        $AdmHome = new AdmHome();
        $homeRegistros = $AdmHome->where('section', '=', 'destaque')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            // $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $params = ['paginacao' => $request->paginacao,
                   'NRegistros' => $request->NRegistros,
                   'NaoPermitidos' => $arrayIds];

        $materia = new Materia();
        $return = $materia->ajax_listMateriasHome($params);

        return $return;
    }

    public function ajax_registerNewsLetter(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');

        $newLetter = new Newsletter();
        $newLetter->name = $name;
        $newLetter->email = $email;

        $newLetter->save();
        return json_encode( true );
    }
}
