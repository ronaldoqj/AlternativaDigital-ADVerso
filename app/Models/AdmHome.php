<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Auth;
use DB;

class AdmHome extends Model
{
    protected $table = 'adm-home';
    private $type = null;
    private $section = ['banner'];
    private $idsPermitidos = [0];
    private $ativos = ['N', 'S'];


    public function setSection($section) {
       $this->section = $section;
    }

    public function idsPermitidos($ids) {
       $this->idsPermitidos = $ids;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setAtivos($ativos) {
        $this->ativos = $ativos;
    }

    public function listComboBoxs() {
        $list = DB::table('materias')->leftjoin('categorias', 'categorias.id', '=', 'materias.category')
                                     ->leftjoin('files', 'files.id', '=', 'materias.image')
                                     // ->where('categorias.categoria', 'materia')
                                     ->whereNotIn('materias.id', $this->idsPermitidos)
                                     // ->where('materias.type', $this->type)
                                     ->orderBy('materias.category', 'asc')
                                     ->orderBy('materias.created_at', 'desc')
                                     ->orderBy('materias.category', 'asc')
                                     ->orderBy('categorias.nome', 'asc');

        $listAll = $list->addSelect('materias.id as id',
                                    'materias.type as type',
                                    'materias.title as title',
                                    'materias.subtitle as subtitle',
                                    'materias.category as category',
                                    'materias.backgroundbanner as backgroundbanner',
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


   public function listComboBoxsColunistas() {
       $list = DB::table('materias')->join('categorias', 'categorias.id', '=', 'materias.category')
                                  ->join('files', 'files.id', '=', 'materias.image')
                                   ->where('materias.type', 'coluna')
                                  ->whereNotIn('materias.id', $this->idsPermitidos)
                                  // ->where('materias.type', $this->type)
                                  ->orderBy('materias.category', 'asc')
                                  ->orderBy('materias.created_at', 'desc')
                                  ->orderBy('materias.category', 'asc')
                                  ->orderBy('categorias.nome', 'asc');

       $listAll = $list->addSelect('materias.id as id',
                                   'materias.type as type',
                                   'materias.title as title',
                                   'materias.subtitle as subtitle',
                                   'materias.category as category',
                                   'materias.backgroundbanner as backgroundbanner',
                                   'files.id as file_id',
                                   'files.name as file_name',
                                   'files.alternative_text as file_alternative_text',
                                   'files.namefile as namefile',
                                   'files.path as path',
                                   'files.namefilefull as namefilefull',
                                   'categorias.id as category_id',
                                   'categorias.nome as category_name')->get();
        return $listAll;
  }


   public function listHome()
   {
        $list = DB::table('materias');
        $list->join('adm-home', 'adm-home.materia', '=', 'materias.id');
        $list->leftjoin('categorias', 'categorias.id', '=', 'materias.category');
        $list->leftjoin('colunistas', 'colunistas.id', '=', 'materias.colunista');
        $list->leftjoin('files as avatar', 'avatar.id', '=', 'colunistas.avatar');
        $list->leftjoin('files', 'files.id', '=', 'materias.image');
        $list->leftjoin('files as filesBackground', 'filesBackground.id', '=', 'materias.backgroundbanner');
        $list->whereIn('materias.id', $this->idsPermitidos);
        if (!Auth::id()) {
            $list->whereIn('materias.ativo', $this->ativos);
        }
        $list->whereIn('adm-home.section', $this->section);
        // ->whereIn('adm-home.section', $this->section)

        // ->where('materias.type', $this->type)
        $list->orderBy('adm-home.order', 'asc');
        $list->orderBy('materias.created_at', 'desc');
        $list->orderBy('materias.category', 'asc');
        $list->orderBy('categorias.nome', 'asc');

        $listAll = $list->addSelect( 'materias.id as id',
                                     'adm-home.id as id_home',
                                     'adm-home.section as section',
                                     'materias.type as type',
                                     'materias.ativo as ativo',
                                     'materias.assunto as assunto',
                                     'materias.title as title',
                                     'materias.subtitle as subtitle',
                                     'materias.category as category',
                                     'materias.colunista as colunista',
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
                                     'categorias.nome as category_name' )->get();
      return $listAll;
   }



   public function listComboBoxsTvAdverso() {
       $list = DB::table('tv_adverso')->whereNotIn('tv_adverso.id', $this->idsPermitidos)
                                      ->orderBy('tv_adverso.order', 'desc');

       $listAll = $list->addSelect('*')->get();
        return $listAll;
  }


   public function listHomeTvAdverso()
   {
     $list = DB::table('tv_adverso')->join('adm-home', 'adm-home.materia', '=', 'tv_adverso.id')
                                ->whereIn('tv_adverso.id', $this->idsPermitidos)
                                ->orderBy('adm-home.order', 'asc');

      $listAll = $list->addSelect('tv_adverso.id as id',
                                  'tv_adverso.title as title',
                                  'tv_adverso.description as description',
                                  'tv_adverso.link as link',
                                  'tv_adverso.id_video as id_video',
                                  'adm-home.id as id_home')->get();
      return $listAll;
   }

}
