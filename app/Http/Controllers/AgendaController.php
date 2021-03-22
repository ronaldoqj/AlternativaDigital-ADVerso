<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Galeria;
use App\Models\Agenda;
use App\Models\Texto;

class AgendaController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request, $id = null, $title = null, $preVisualizar = null)
    {
        $return = ['title' => 'Agenda'];
        $imagem = [];
        $error = false;

        if ( is_numeric($id) )
        {
            $agenda = new Agenda();
            $agenda->setId($id);
            $return['agenda'] = $agenda->listAgenda();

            if ($return['agenda']->galeria)
            {
                $listGaleria = new Galeria();
                $return['galeria'] = $listGaleria->find($return['agenda']->galeria);
                $listGaleria = new Galeria();
                $listGaleria->setIdGaleria($return['agenda']->galeria);
                $return['files'] = $listGaleria->listImagesMaterias();
            }

            if ( !$return['agenda'] ) {
                $error = true;
            }
        }
        else
        {
            $error = true;
        }

        if ($error) {
            return redirect('/agendas');
        } else {
            return view('agenda')->withReturn($return);
        }
    }

}
