<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class Galeria extends Model
{
    private $idGaleria = null;
    private $limit = null;

    public function setIdGaleria($id) { $this->idGaleria = $id; }
    public function setLimit($limit) { $this->limit = $limit; }

    public function listImages()
    {
          $list = DB::table('galeria_has_imagem')->join('files_galeria', 'files_galeria.id', '=', 'galeria_has_imagem.id_file')
                                    ->orderBy('galeria_has_imagem.id_galeria', 'desc')
                                    ->orderBy('galeria_has_imagem.order', 'asc');

         $listAll = $list->addSelect('galeria_has_imagem.id as id',
                                     'galeria_has_imagem.order as order',
                                     'galeria_has_imagem.id_galeria as id_galeria',
                                     'galeria_has_imagem.id_file as id_file',

                                     'files_galeria.id as file_id',
                                     'files_galeria.alternative_text as file_alternative_text',
                                     'files_galeria.name as name',
                                     'files_galeria.path as path',
                                     'files_galeria.namefile as namefile',
                                     'files_galeria.namefilefull as namefilefull',

                                     'files_galeria.namethumb as file_name_thumb',
                                     'files_galeria.paththumb as paththumb',
                                     'files_galeria.namefilethumb as namefilethumb',
                                     'files_galeria.namefilefullthumb as namefilefullthumb',
                                     'galeria_has_imagem.id as id_galeria_has_imagem'
                                     )->get();
          return $listAll;
     }

     // Utilizada para listar as galerias no site [materias]
     public function listImagesMaterias() {
          $list = DB::table('galeria_has_imagem')->join('files_galeria', 'files_galeria.id', '=', 'galeria_has_imagem.id_file')
                                    ->where('galeria_has_imagem.id_galeria', $this->idGaleria)
                                    ->orderBy('galeria_has_imagem.id_galeria', 'desc')
                                    ->orderBy('galeria_has_imagem.order', 'asc');

         $listAll = $list->addSelect('galeria_has_imagem.id as id',
                                     'galeria_has_imagem.order as order',
                                     'galeria_has_imagem.id_galeria as id_galeria',
                                     'galeria_has_imagem.id_file as id_file',

                                     'files_galeria.id as file_id',
                                     'files_galeria.alternative_text as file_alternative_text',
                                     'files_galeria.name as name',
                                     'files_galeria.path as path',
                                     'files_galeria.namefile as namefile',
                                     'files_galeria.namefilefull as namefilefull',

                                     'files_galeria.namethumb as file_name_thumb',
                                     'files_galeria.paththumb as paththumb',
                                     'files_galeria.namefilethumb as namefilethumb',
                                     'files_galeria.namefilefullthumb as namefilefullthumb',
                                     'galeria_has_imagem.id as id_galeria_has_imagem'
                                     )->get();
          return $listAll;
     }

     public function listImagesHome() {
          $list = DB::table('galeria_has_imagem')->join('files_galeria', 'files_galeria.id', '=', 'galeria_has_imagem.id_file')
                                    ->inRandomOrder()
                                    ->limit($this->limit);

         $listAll = $list->addSelect('galeria_has_imagem.id as id',
                                     'galeria_has_imagem.order as order',
                                     'galeria_has_imagem.id_galeria as id_galeria',
                                     'galeria_has_imagem.id_file as id_file',

                                     'files_galeria.id as file_id',
                                     'files_galeria.alternative_text as file_alternative_text',
                                     'files_galeria.name as name',
                                     'files_galeria.path as path',
                                     'files_galeria.namefile as namefile',
                                     'files_galeria.namefilefull as namefilefull',

                                     'files_galeria.namethumb as file_name_thumb',
                                     'files_galeria.paththumb as paththumb',
                                     'files_galeria.namefilethumb as namefilethumb',
                                     'files_galeria.namefilefullthumb as namefilefullthumb',
                                     'galeria_has_imagem.id as id_galeria_has_imagem'
                                     )->get();
          return $listAll;
     }
}
