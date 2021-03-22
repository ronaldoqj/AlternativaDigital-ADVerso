<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class GaleriaHasImagem extends Model
{
    protected $table = 'galeria_has_imagem';

    public function listGaleria () {
       $list = DB::table('files')->join('categorias', 'categorias.id', '=', 'files.category')
                                 ->where('categorias.categoria', 'galeria')
                                 ->orderBy('files.category', 'asc')
                                 ->orderBy('categorias.nome', 'asc');

      $listAll = $list->addSelect('files.id as id',
                                  'files.name as name',
                                  'files.description as description',
                                  'files.alternative_text as alternative_text',
                                  'files.path as path',
                                  'files.namefilefull as namefilefull',
                                  'files.created_at as created_at',
                                  'files.updated_at as img_updated_at',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
                                  //'categorias.nome as category_name')->get()->toArray();
       return $listAll;
    }
}
