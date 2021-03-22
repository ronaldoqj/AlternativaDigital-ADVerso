<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Galeria;
use App\Models\File;

class ColunistaController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request, $id = null, $title = null, $preVisualizar = null)
    {
        $return = ['title' => 'Colunistas'];

        $materia = new Materia();
        $materia->setId($id);
        $materia = $materia->listNoticia();

        if( count($materia) )
        {
            $materia = $materia[0];
            $maisNoticias = new Materia();
            $maisNoticias->setId($id);
            $maisNoticias = $maisNoticias->listMaisColunas();

            $file = new File();
            $image = $file->find($materia->image);
            if ($image)
            {
                $image->alternative_text = $image->alternative_text == '' ? $image->name : $image->alternative_text;
            }

            $backgroundbanner = $file->find($materia->backgroundbanner);

            if($materia->galeria_id) {
                $listGaleria = new Galeria();
                $return['galeria'] = $listGaleria->find($materia->galeria_id);
                $listGaleria = new Galeria();
                $listGaleria->setIdGaleria($materia->galeria_id);
                $return['files'] = $listGaleria->listImagesMaterias();
            }

            $return['materia'] = $materia;
            $return['maisNoticias'] = $maisNoticias;
            $return['image'] = $image;
            $return['backgroundbanner'] = $backgroundbanner;

            return view('colunista')->withReturn($return);
        }
        else
        {
            return redirect('/colunistas');
        }
    }
}
