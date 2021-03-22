<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Galeria;
use App\Models\File;

class NoticiaController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request, $id = null, $title = null, $preVisualizar = null)
    {
        $return = ['title' => 'Notícia'];
        $materia = new Materia();
        $materia->setId($id);
        $materia = $materia->listNoticia();

        if( count($materia) )
        {
            $materia = $materia[0];
            $maisNoticias = new Materia();
            $maisNoticias->setId($id);
            $maisNoticias = $maisNoticias->listMaisNoticias();

            $file = new File();
            $image = $file->find($materia->image);
            $backgroundbanner = null;
            $backgroundbannerMateriaNormal = 'images/background.jpg';

            if ($image)
            {
                $image->alternative_text = $image->alternative_text == '' ? $image->name : $image->alternative_text;
                if ($file->find($materia->backgroundbanner)) {
                    $backgroundbanner = $file->find($materia->backgroundbanner);
                    $backgroundbanner = $backgroundbanner->namefilefull;
                }
            }

            if ($materia->galeria_id)
            {
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
            $return['backgroundbannerMateriaNormal'] = $backgroundbannerMateriaNormal;

            return view('noticia')->withReturn($return);
        }
        else
        {
            return redirect('/noticias');
        }
    }
}
