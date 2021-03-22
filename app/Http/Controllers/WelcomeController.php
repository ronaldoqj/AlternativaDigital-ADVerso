<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Galeria;
use App\Models\Agenda;
use App\Models\TvAdverso;
use App\Models\AdufrgsNoAr;
use App\Models\File;
use App\Models\FileGaleria;
use App\Models\AdmHome;

class WelcomeController extends Controller
{
    public function __construct()
    {
    }
    // listBanners
    // listDestaques
    // materias-simples
    // listColunistas
    // listTvAdverso
    // galeriaImagens
    // materias-count
    public function index()
    {
        $return = ['title' => 'Matérias'];

        $materia = new Materia();
        // $materia->setType('especial');
        // $return['materias-especiais'] = $materia->listMateriasHome();
        // $return['materias-count'] = $materia->listMateriasHome()->count();
        $materia->setType('normal');
        $materia->setLimit(4);
        $return['materias-simples'] = $materia->listMateriasHome();


        $home = new AdmHome();
        $home->setAtivos(['S']);
        $homeRegistros = $home->where('section', '=', 'banner')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $home->setSection(['banner']);
        $return['listBanners'] = $home->listHome();
        $return['materias-count'] = count($return['listBanners']);


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
        $home->setSection(['colunista']);
        $return['listColunistas'] = $home->listHome();

        $homeRegistros = $home->where('section', '=', 'tvAdverso')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $agenda = new Agenda();
        $return['listAgenda'] = $agenda->listAgendaHome()->take(4);

        $listGaleria = new Galeria();
        $filesGaleria = new FileGaleria();
        $countFilesGalerias = $filesGaleria->all()->count();

        $return['galeriaImagens'] = [];
        $return['hasGaleria'] = false;
        if ($countFilesGalerias >= 6)
        {
            if ($countFilesGalerias >= 12)
            {
                $listGaleria->setLimit(12);
            }
            elseif ($countFilesGalerias >= 6)
            {
                $listGaleria->setLimit(6);
            }

            $return['hasGaleria'] = true;
            $return['galeriaImagens'] = $listGaleria->listImagesHome();
        }

        $ObjTvAdverso = new TvAdverso();
        $tvAdverso = $ObjTvAdverso->orderBy('id', 'desc')->take(5)->get();
        $return['listTvAdverso'] = $tvAdverso;

        $ObjAdufrgsNoAr = new AdufrgsNoAr();
        $AdufrgsNoAr = $ObjAdufrgsNoAr->orderBy('id', 'desc')->take(10)->get();
        $return['listAdufrgsNoAr'] = $AdufrgsNoAr;

        return view('welcome')->withReturn($return);
    }
}
