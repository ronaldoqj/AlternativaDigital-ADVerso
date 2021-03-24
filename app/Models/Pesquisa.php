<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pesquisa extends Model
{
    public function pesquisa($pesquisa)
    {
        // dd($pesquisa);
        $retorno = ['retorno' => false, 'pesquisa' => []];
        $list = DB::table('materias');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        $list->whereIn('materias.type', ['especial', 'normal']);
        $list->where('materias.title', 'like', '%'.$pesquisa.'%');
        $list->orWhere('materias.assunto', 'like', '%'.$pesquisa.'%');
        $list->orWhere('materias.subtitle', 'like', '%'.$pesquisa.'%');
        $list->orderBy('materias.created_at', 'desc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.ativo as ativo',
                                    'materias.title as title',
                                    'materias.assunto as assunto',
                                    'materias.subtitle as subtitle',
                                    'materias.colunista as colunista',
                                    'materias.category as category',
                                    'materias.video as video',
                                    'materias.galeria as galeria',
                                    'materias.text1 as text1',
                                    'materias.text2 as text2',
                                    'materias.backgroundbanner as backgroundbanner',
                                    'materias.extra_text as extra_text',
                                    'materias.image as image',
                                    'materias.created_at as created_at',

                                    'files.id as file_id',
                                    'files.name as file_name',
                                    'files.alternative_text as file_alternative_text',
                                    'files.path as path',
                                    'files.namefile as namefile',
                                    'files.namefilefull as namefilefull',

                                    'filesBackground.id as fileBackground_id',
                                    'filesBackground.name as fileBackground_name',
                                    'filesBackground.alternative_text as fileBackground_alternative_text',
                                    'filesBackground.path as fileBackground_path',
                                    'filesBackground.namefile as fileBackground_namefile',
                                    'filesBackground.namefilefull as fileBackground_namefilefull')->get();
        $retorno['retorno'] = true;
        $retorno['pesquisa']['materias'] = $listAll;


        $pesquisa = 'Sobre o papel do estado';
        $list = null;
        $list = DB::table('materias');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        $list->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista');
        $list->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar');
        $list->whereIn('materias.type', ['coluna']);
        $list->where('materias.title', 'like', '%'.$pesquisa.'%');
        $list->orWhere('materias.assunto', 'like', '%'.$pesquisa.'%');
        $list->orWhere('materias.subtitle', 'like', '%'.$pesquisa.'%');
        $list->whereRaw('materias.type = ?', ['coluna']);


        // $list->where('materias.title', 'like', '%'.$pesquisa.'%');
        // $list->orWhere('materias.assunto', 'like', '%'.$pesquisa.'%');
        // $list->orWhere('materias.subtitle', 'like', '%'.$pesquisa.'%');
        $list->orderBy('materias.created_at', 'desc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.assunto as assunto',
                                    'materias.title as title',
                                    'materias.image as image',
                                    'materias.subtitle as subtitle',
                                    'materias.text1 as text1',
                                    'materias.text2 as text2',
                                    'materias.backgroundbanner as backgroundbanner',

                                    'colunistas.id as colunista_id',
                                    'colunistas.name as colunista_name',
                                    'colunistas.cargo as colunista_cargo',
                                    'colunistas.avatar as colunista_avatar',

                                    'avatar.id as avatar_id',
                                    'avatar.namefilefull as avatar_namefilefull',
                                    'avatar.namefile as avatar_namefile',

                                    'files.id as file_id',
                                    'files.name as file_name',
                                    'files.alternative_text as file_alternative_text',
                                    'files.path as path',
                                    'files.namefile as namefile',
                                    'files.namefilefull as namefilefull',
                                    'filesBackground.id as fileBackground_id',
                                    'filesBackground.name as fileBackground_name',
                                    'filesBackground.alternative_text as fileBackground_alternative_text',
                                    'filesBackground.path as fileBackground_path',
                                    'filesBackground.namefilefull as fileBackground_namefilefull')->get();
            $retorno['retorno'] = true;
            $retorno['pesquisa']['colunistas'] = $listAll;


        // $pesquisa = 'Conferência Livre';
        //
        // $list = DB::table('tv_adverso');
        // $list->where('tv_adverso.title', 'like', '%'.$pesquisa.'%');
        // $list->orWhere('tv_adverso.description', 'like', '%'.$pesquisa.'%');
        // $list->orderBy('tv_adverso.created_at', 'desc');
        // $listAll = $list->addSelect('tv_adverso.*')->get();
        //
        // if ( $listAll->count() )
        // {
        //     $retorno['retorno'] = true;
        //     $retorno['pesquisa']['tv_adverso'] = $listAll;
        // }
        // else
        // {
        //     $retorno['pesquisa']['tv_adverso'] = [];
        // }


        // dd($retorno);
        return $retorno;
    }
}
