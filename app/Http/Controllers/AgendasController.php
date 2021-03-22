<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Agenda;
use App\Models\Texto;

class AgendasController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $return = ['title' => 'Agendas'];
        $agenda = new Agenda();
        $return['listAgenda'] = $agenda->listAgendaHome();

        $pagina = 'texto-agendas';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina)->first();
        $return['texto'] = $selectLista;

        return view('agendas')->withReturn($return);
    }
}
