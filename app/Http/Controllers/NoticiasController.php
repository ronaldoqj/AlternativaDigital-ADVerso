<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\File;
use App\Models\AdmHome;
use App\Models\Texto;

class NoticiasController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $return = ['title' => 'Matérias'];

        $materia = new Materia();
        $materia->setType('especial');
        $return['materias-especiais'] = $materia->listMateriasHome();


        $return['materias-count'] = $materia->listMateriasHome()->count();
        $materia->setType('normal');
        $materia->setLimit(6);
        $return['materias-simples'] = $materia->listMateriasHome();

        $home = new AdmHome();

        $homeRegistros = $home->where('section', '=', 'banner')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $return['listBanners'] = $home->listHome();


        $homeRegistros = $home->where('section', '=', 'destaque')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $home->setSection(['destaque']);
        $return['listDestaques'] = $home->listHome();


        $homeRegistros = $home->where('section', '=', 'colunista')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $return['listColunistas'] = $home->listHome();


        $homeRegistros = $home->where('section', '=', 'tvAdverso')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $pagina = 'texto-noticias';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina)->first();
        $return['texto'] = $selectLista;

        $home->idsPermitidos($arrayIds);
        $return['listTvAdverso'] = $home->listHomeTvAdverso();
        return view('noticias')->withReturn($return);
    }
}
