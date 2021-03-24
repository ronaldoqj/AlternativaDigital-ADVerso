<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Revista extends Model
{
    private $idRevista = null;
    private $limit = null;

    public function setIdRevista($id) { $this->idRevista = $id; }
    public function setLimit($limit) { $this->limit = $limit; }

    public function listImages()
    {
          $list = DB::table('revistas_has_imagem')->join('files_galeria', 'files_galeria.id', '=', 'revistas_has_imagem.id_file')
                                    ->orderBy('revistas_has_imagem.id_galeria', 'desc')
                                    ->orderBy('revistas_has_imagem.order', 'asc');

         $listAll = $list->addSelect('revistas_has_imagem.id as id',
                                     'revistas_has_imagem.order as order',
                                     'revistas_has_imagem.id_galeria as id_galeria',
                                     'revistas_has_imagem.id_file as id_file',

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
                                     'revistas_has_imagem.id as id_revistas_has_imagem'
                                     )->get();
          return $listAll;
     }

     // Utilizada para listar as galerias no site [materias]
     public function listImagesMaterias() {
          $list = DB::table('revistas_has_imagem')->join('files_galeria', 'files_galeria.id', '=', 'revistas_has_imagem.id_file')
                                    ->where('revistas_has_imagem.id_galeria', $this->idRevista)
                                    ->orderBy('revistas_has_imagem.id_galeria', 'desc')
                                    ->orderBy('revistas_has_imagem.order', 'asc');

         $listAll = $list->addSelect('revistas_has_imagem.id as id',
                                     'revistas_has_imagem.order as order',
                                     'revistas_has_imagem.id_galeria as id_galeria',
                                     'revistas_has_imagem.id_file as id_file',

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
                                     'revistas_has_imagem.id as id_revistas_has_imagem'
                                     )->get();
          return $listAll;
     }

     public function listImagesHome() {
          $list = DB::table('revistas_has_imagem')->join('files_galeria', 'files_galeria.id', '=', 'revistas_has_imagem.id_file')
                                    ->inRandomOrder()
                                    ->limit($this->limit);

         $listAll = $list->addSelect('revistas_has_imagem.id as id',
                                     'revistas_has_imagem.order as order',
                                     'revistas_has_imagem.id_galeria as id_galeria',
                                     'revistas_has_imagem.id_file as id_file',

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
                                     'revistas_has_imagem.id as id_revistas_has_imagem'
                                     )->get();
          return $listAll;
     }
}
