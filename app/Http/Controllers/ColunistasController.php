<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\File;
use App\Models\AdmHome;
use App\Models\Texto;

class ColunistasController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $return = ['title' => 'Matérias'];
        $home = new AdmHome();
        $home->setAtivos(['S']);

        $homeRegistros = $home->where('section', '=', 'colunista')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $return['listBanners'] = $home->listHome();

        $materias = new Materia();
        $return['listColunistas'] = $materias->listColunistasOutros();
        $return['materias-count'] = $materias->listColunistasOutros()->count();
        $return['listColunas'] = $materias->listColunas();


        $homeRegistros = $home->where('section', '=', 'colunista')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $home->setSection(['colunista']);
        $return['listColunistasTopo'] = $home->listHome();
        $return['materias-count'] = count($return['listColunistasTopo']);

        $pagina = 'texto-colunistas';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina)->first();
        $return['texto'] = $selectLista;

        return view('colunistas')->withReturn($return);
    }
}
