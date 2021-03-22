<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class Jornalista extends Model
{
    public function listJornalistas() {
       $list = DB::table('jornalistas')->leftjoin('files', 'files.id', '=', 'jornalistas.avatar')
                                 ->orderBy('jornalistas.name', 'asc');

      $listAll = $list->addSelect('jornalistas.id as id',
                                  'jornalistas.name as name',
                                  'jornalistas.cargo as cargo',
                                  'jornalistas.avatar as avatar',
                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull')->get();
       return $listAll;
    }
    public function listJornalista($id) {
       $list = DB::table('jornalistas')->leftjoin('files', 'files.id', '=', 'jornalistas.avatar')
                                 ->where('jornalistas.id', $id);

      $listAll = $list->addSelect('jornalistas.id as id',
                                  'jornalistas.name as name',
                                  'jornalistas.cargo as cargo',
                                  'jornalistas.avatar as avatar',
                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull')->get()->first();
       return $listAll;
    }
}
