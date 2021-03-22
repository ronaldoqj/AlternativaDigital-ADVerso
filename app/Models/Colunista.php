<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class Colunista extends Model
{
    public function listColunistas() {
       $list = DB::table('colunistas')->leftjoin('categorias', 'categorias.id', '=', 'colunistas.category')
                                 ->leftjoin('files', 'files.id', '=', 'colunistas.avatar')
                                 ->orderBy('colunistas.category', 'asc')
                                 ->orderBy('categorias.nome', 'asc');

      $listAll = $list->addSelect('colunistas.id as id',
                                  'colunistas.name as name',
                                  'colunistas.cargo as cargo',
                                  'colunistas.category as category',
                                  'colunistas.avatar as avatar',
                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }
    public function listColunista($id) {
       $list = DB::table('colunistas')->leftjoin('categorias', 'categorias.id', '=', 'colunistas.category')
                                 ->leftjoin('files', 'files.id', '=', 'colunistas.avatar')
                                 ->where('colunistas.id', $id);

      $listAll = $list->addSelect('colunistas.id as id',
                                  'colunistas.name as name',
                                  'colunistas.cargo as cargo',
                                  'colunistas.category as category',
                                  'colunistas.avatar as avatar',
                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get()->first();
       return $listAll;
    }
}
