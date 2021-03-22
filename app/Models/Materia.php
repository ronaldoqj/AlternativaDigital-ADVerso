<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Materia;
use Auth;
use DB;

class Materia extends Model
{
    private $type = null;
    private $limit = null;
    private $id = null;


    public function setType($type) {
        $this->type = $type;
    }
    public function setLimit($limit) {
        $this->limit = $limit;
    }
    public function setId($id) {
        $this->id = $id;
    }

    // Usado no adm para listar as materias [Página - Materias]
    public function listMateria()
    {
        $list = DB::table('materias');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        if (!Auth::id()) {
            $list->where('materias.ativo', 'S');
        }
        $list->where('materias.id', $this->id);

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.ativo as ativo',
                                    'materias.title as title',
                                    'materias.assunto as assunto',
                                    'materias.subtitle as subtitle',
                                    'materias.colunista as colunista',
                                    'materias.jornalista as jornalista',
                                    'materias.tags as tags',
                                    'materias.category as category',
                                    'materias.video as video',
                                    'materias.galeria as galeria',
                                    'materias.text1 as text1',
                                    'materias.text2 as text2',
                                    'materias.backgroundbanner as backgroundbanner',
                                    'materias.extra_text as extra_text',
                                    'materias.criador as criador',
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
         return $listAll->first();
    }

    public function listMaterias()
    {
        $list = DB::table('materias');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        $list->where('materias.type', $this->type);
        if (!Auth::id()) {
            $list->where('materias.ativo', 'S');
        }
        $list->orderBy('materias.created_at', 'desc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.ativo as ativo',
                                    'materias.title as title',
                                    'materias.assunto as assunto',
                                    'materias.subtitle as subtitle',
                                    'materias.colunista as colunista',
                                    'materias.jornalista as jornalista',
                                    'materias.tags as tags',
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
         return $listAll;
    }

    public function listMateriasHome()
    {
        if($this->limit)
        {
            $list = DB::table('materias');
            $list->leftjoin('files', 'files.id', '=', 'materias.image');
            $list->where('materias.type', $this->type);
            if (!Auth::id()) {
               $list->where('materias.ativo', 'S');
            }
            $list->limit($this->limit);
            $list->orderBy('materias.created_at', 'desc');
        }
        else
        {
            $list = DB::table('materias');
            $list->leftjoin('files', 'files.id', '=', 'materias.image');
            if (!Auth::id()) {
               $list->where('materias.ativo', 'S');
            }
            $list->where('materias.type', $this->type);
            $list->orderBy('materias.created_at', 'desc');
            $list->orderBy('materias.category', 'asc');
        }



          $listAll = $list->addSelect('materias.id as id',
                                      'materias.ativo as ativo',
                                      'materias.type as type',
                                      'materias.assunto as assunto',
                                      'materias.title as title',
                                      'materias.subtitle as subtitle',
                                      'materias.colunista as colunista',
                                      'materias.jornalista as jornalista',
                                      'materias.tags as tags',
                                      'materias.text1 as text1',
                                      'materias.text2 as text2',
                                      'materias.backgroundbanner as backgroundbanner',
                                      'materias.image as image',
                                      'materias.facebook as facebook',
                                      'materias.twitter as twitter',
                                      'materias.whatsapp as whatsapp',
                                      'files.id as file_id',
                                      'files.name as file_name',
                                      'files.alternative_text as file_alternative_text',
                                      'files.path as path',
                                      'files.namefile as namefile',
                                      'files.namefilefull as namefilefull')->get();
           return $listAll;
    }



    public function listMateriasHomeColunistas()
    {
        $list = DB::table('materias');
        $list->join('categorias', 'categorias.id', '=', 'materias.category');
        $list->join('files', 'files.id', '=', 'materias.image');
        if (!Auth::id()) {
            $list->where('materias.ativo', 'S');
        }
        $list->where('categorias.categoria', 'materia');
        $list->where('materias.type', 'coluna');
        $list->orderBy('materias.created_at', 'desc');
        $list->orderBy('materias.category', 'asc');
        $list->orderBy('categorias.nome', 'asc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.title as title',
                                    'materias.subtitle as subtitle',
                                    'materias.colunista as colunista',
                                    'materias.jornalista as jornalista',
                                    'materias.tags as tags',
                                    'materias.category as category',
                                    'materias.text1 as text1',
                                    'materias.text2 as text2',
                                    'materias.backgroundbanner as backgroundbanner',
                                    'materias.image as image',
                                    'materias.facebook as facebook',
                                    'materias.twitter as twitter',
                                    'materias.whatsapp as whatsapp',
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



    public function listMateriasHomeADM()
    {
        $list = DB::table('materias')->join('categorias', 'categorias.id', '=', 'materias.category')
                                   ->join('files', 'files.id', '=', 'materias.image')
                                   ->where('categorias.categoria', 'materia')
                                   ->where('materias.type', $this->type)
                                   ->orderBy('materias.type', 'asc')
                                   ->orderBy('materias.created_at', 'desc')
                                   ->orderBy('materias.category', 'asc')
                                   ->orderBy('categorias.nome', 'asc');

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.title as title',
                                  'materias.subtitle as subtitle',
                                  'materias.colunista as colunista',
                                  'materias.jornalista as jornalista',
                                  'materias.tags as tags',
                                  'materias.category as category',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.backgroundbanner as backgroundbanner',
                                  'materias.image as image',
                                  'materias.facebook as facebook',
                                  'materias.twitter as twitter',
                                  'materias.whatsapp as whatsapp',
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


    public function listNoticia()
    {
        $list = DB::table('materias');
        $list->leftjoin('categorias', 'categorias.id', '=', 'materias.category');
        $list->leftjoin('tv_adverso', 'tv_adverso.id', '=', 'materias.video');
        $list->leftjoin('galerias', 'galerias.id', '=', 'materias.galeria');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        $list->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista');
        $list->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar');
        $list->where('materias.id', $this->id);
        if (!Auth::id()) {
            $list->where('materias.ativo', 'S');
        }
        $list->orderBy('materias.created_at', 'desc');
        $list->orderBy('materias.category', 'asc');

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.assunto as assunto',
                                  'materias.title as title',
                                  'materias.image as image',
                                  'materias.subtitle as subtitle',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.category as category',
                                  'materias.backgroundbanner as backgroundbanner',
                                  'materias.created_at as created_at',

                                  'colunistas.id as colunista_id',
                                  'colunistas.name as colunista_name',
                                  'colunistas.cargo as colunista_cargo',
                                  'colunistas.avatar as colunista_avatar',

                                  'galerias.id as galeria_id',

                                  'avatar.id as avatar_id',
                                  'avatar.namefilefull as avatar_namefilefull',
                                  'avatar.namefile as avatar_namefile',

                                  'tv_adverso.id as video_id',
                                  'tv_adverso.title as video_title',
                                  'tv_adverso.description as video_description',
                                  'tv_adverso.link as video_link',

                                  'files.id as file_id',
                                  'files.name as file_name',
                                  'files.alternative_text as file_alternative_text',
                                  'files.path as path',
                                  'files.namefile as namefile',
                                  'files.namefilefull as namefilefull',
                                  'categorias.id as category_id',
                                  'filesBackground.id as fileBackground_id',
                                  'filesBackground.name as fileBackground_name',
                                  'filesBackground.alternative_text as fileBackground_alternative_text',
                                  'filesBackground.path as fileBackground_path',
                                  'filesBackground.namefilefull as fileBackground_namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }



    public function listMaisNoticias()
    {
        $objNoticia = new Materia();
        $noticia = $objNoticia->find($this->id);
        $arrayIds = [];

        $noticias = $objNoticia->where('assunto', '=', $noticia->assunto)
                               ->where('id', '!=', $this->id)->get();


        if ($noticias->count()) {
            foreach ($noticias->toArray() as $item) {
              $arrayIds[] = $item['id'];
            }
        }

        $list = DB::table('materias');
        $list->leftjoin('categorias', 'categorias.id', '=', 'materias.category');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        if (!Auth::id()) {
            $list->where('materias.ativo', 'S');
        }

        if (count($arrayIds)) {
            $noticiaRelacionada = 'S';
            $list->whereIn('materias.id', $arrayIds);
        }
        else {
            $noticiaRelacionada = 'N';
            $list->whereIn('materias.type', ['normal', 'especial']);
            $list->whereNotIn('materias.id', [$this->id]);
            $list->limit(4);
        }

        $list->orderBy('materias.created_at', 'desc');
        $list->orderBy('materias.category', 'asc');
        $list->orderBy('categorias.nome', 'asc');

        $listAll = $list->addSelect('materias.id as id',
                                    DB::raw('(select "'.$noticiaRelacionada.'") as noticiaRelacionada'),
                                    'materias.type as type',
                                    'materias.assunto as assunto',
                                    'materias.title as title',
                                    'materias.image as image',
                                    'materias.subtitle as subtitle',
                                    'materias.text1 as text1',
                                    'materias.text2 as text2',
                                    'materias.category as category',
                                    'materias.backgroundbanner as backgroundbanner',
                                    'materias.created_at as created_at',
                                    'files.id as file_id',
                                    'files.name as file_name',
                                    'files.alternative_text as file_alternative_text',
                                    'files.path as path',
                                    'files.namefile as namefile',
                                    'files.namefilefull as namefilefull',
                                    'categorias.id as category_id',
                                    'filesBackground.id as fileBackground_id',
                                    'filesBackground.name as fileBackground_name',
                                    'filesBackground.alternative_text as fileBackground_alternative_text',
                                    'filesBackground.path as fileBackground_path',
                                    'filesBackground.namefilefull as fileBackground_namefilefull',
                                    'categorias.id as category_id',
                                    'categorias.nome as category_name')->get();
         return $listAll;
    }


    public function listMaisColunas()
    {
      $list = DB::table('materias');
      $list->join('categorias', 'categorias.id', '=', 'materias.category');
      $list->join('files', 'files.id', '=', 'materias.image');
      $list->join('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
      $list->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista');
      $list->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar');
      if (!Auth::id()) {
          $list->where('materias.ativo', 'S');
      }
      $list->whereIn('materias.type', ['coluna']);
      $list->whereNotIn('materias.id', [$this->id]);
      $list->orderBy('materias.created_at', 'desc');
      $list->orderBy('materias.category', 'asc');
      $list->orderBy('categorias.nome', 'asc');
      $list->limit(4);

      $listAll = $list->addSelect('materias.id as id',
                                  'materias.type as type',
                                  'materias.title as title',
                                  'materias.image as image',
                                  'materias.subtitle as subtitle',
                                  'materias.text1 as text1',
                                  'materias.text2 as text2',
                                  'materias.category as category',
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
                                  'categorias.id as category_id',
                                  'filesBackground.id as fileBackground_id',
                                  'filesBackground.name as fileBackground_name',
                                  'filesBackground.alternative_text as fileBackground_alternative_text',
                                  'filesBackground.path as fileBackground_path',
                                  'filesBackground.namefilefull as fileBackground_namefilefull',
                                  'categorias.id as category_id',
                                  'categorias.nome as category_name')->get();
       return $listAll;
    }



    public function listColunistasOutros()
    {
        $list = DB::table('colunistas');
        $list->leftjoin('files', 'files.id', '=', 'colunistas.avatar');
        $list->orderBy('colunistas.created_at', 'desc');

        $listAll = $list->addSelect('colunistas.id as id',
                                    'colunistas.name as name',
                                    'colunistas.cargo as cargo',

                                    'files.id as file_id',
                                    'files.name as file_name',
                                    'files.alternative_text as file_alternative_text',
                                    'files.path as path',
                                    'files.namefile as namefile',
                                    'files.namefilefull as namefilefull')->get();
                                    return $listAll;
    }

    public function listColunas()
    {
        $list = DB::table('materias');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        $list->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista');
        $list->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar');
        $list->whereIn('materias.type', ['coluna']);
        if (!Auth::id()) {
            $list->where('materias.ativo', 'S');
        }
        $list->orderBy('materias.created_at', 'desc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.ativo as ativo',
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
                                    return $listAll;
    }



    // =========================================================================
    // Ajaxs
    // =========================================================================

    public function ajax_listMateriasHome($params)
    {
        $list = DB::table('materias');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        if (!Auth::id()) {
            $list->where('materias.ativo', 'S');
        }
        $list->whereIn('materias.type', ['normal','especial']);
        $list->whereNotIn('materias.id', $params['NaoPermitidos']);
        // if ($this->limit) {
        //     $list->limit($this->limit);
        // }
        $list->orderBy('materias.created_at', 'desc');
        $list->orderBy('materias.category', 'asc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.ativo as ativo',
                                    'materias.assunto as assunto',
                                    'materias.title as title',
                                    'materias.subtitle as subtitle',
                                    'materias.colunista as colunista',
                                    'materias.text1 as text1',
                                    'materias.text2 as text2',
                                    'materias.backgroundbanner as backgroundbanner',
                                    'materias.image as image',
                                    'materias.facebook as facebook',
                                    'materias.twitter as twitter',
                                    'materias.whatsapp as whatsapp',
                                    'files.id as file_id',
                                    'files.name as file_name',
                                    'files.alternative_text as file_alternative_text',
                                    'files.path as path',
                                    'files.namefile as namefile',
                                    'files.namefilefull as namefilefull');
         $listAll2 = $listAll;
         $listAll = $listAll->skip($params['paginacao'])->take($params['NRegistros'])->get();
         $nextRegister = $listAll2->skip($params['paginacao'] + $params['NRegistros'])->take(1)->get();

         if ($listAll->count())
         {
              foreach($listAll as $item)
              {
                  $item->link = url("noticia/" . $item->id . "/" . $item->title);
                  $item->linkWhatssapp = url("noticia/" . $item->id);
                  $item->limitTtitle = Str::limit($item->title, 110, '');
                  $item->limitSubtitle = Str::limit($item->subtitle, 240, '...');
                  $item->nameLink = Str::slug($item->title, '-');
                  $item->paginacao = $params['paginacao'];
                  $item->nextRegister = count($nextRegister) ? true : false;
              }
         }

         return $listAll;
    }

}
