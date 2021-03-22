<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;

class File extends Model
{
    public function listGaleria()
    {
         $list = DB::table('files')->join('categorias', 'categorias.id', '=', 'files.category')
                                   ->where('categorias.categoria', 'galeria')
                                   // ->orderBy('files.category', 'asc')
                                   // ->orderBy('categorias.nome', 'asc');
                                   ->orderBy('files.category', 'asc')
                                   ->orderBy('files.created_at', 'desc');

         $listAll = $list->addSelect('files.id as id',
                                     'files.name as name',
                                     'files.description as description',
                                     'files.alternative_text as alternative_text',
                                     'files.path as path',
                                     'files.namefile as namefile',
                                     'files.namefilefull as namefilefull',
                                     'files.created_at as created_at',
                                     'files.updated_at as img_updated_at',
                                     'categorias.id as category_id',
                                     'categorias.nome as category_name')->get();
         return $listAll;
    }

    public function listGaleriaEditar()
    {
         $list = DB::table('revistas_has_imagem')
                                   ->join('files', 'files.id', '=', 'revistas_has_imagem.id_file')
                                   ->orderBy('revistas_has_imagem.order', 'asc');
                                   // ->orderBy('revistas_has_imagem.created_at', 'desc');

         $listAll = $list->addSelect(
                                     'revistas_has_imagem.id as revistas_has_imagem_id',
                                     'revistas_has_imagem.id_revista as revistas_has_imagem_id_revista',
                                     'revistas_has_imagem.order as revistas_has_imagem_order',
                                     'revistas_has_imagem.link as revistas_has_imagem_link',
                                     'files.id as id',
                                     'files.name as name',
                                     'files.description as description',
                                     'files.alternative_text as alternative_text',
                                     'files.path as path',
                                     'files.namefile as namefile',
                                     'files.namefilefull as namefilefull',
                                     'files.created_at as created_at',
                                     'files.updated_at as img_updated_at')->get();
         return $listAll;
    }

}
