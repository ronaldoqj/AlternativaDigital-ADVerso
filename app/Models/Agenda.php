<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DB;
use Auth;
use DateTime;
use DateInterval;

class Agenda extends Model
{
    private $id = null;
    public function setId($id) {
        $this->id = $id;
    }

    // ADM and Site (page agenda)
    public function listAgenda()
    {
        $list = DB::table('agendas');
        $list->leftjoin('files', 'files.id', '=', 'agendas.image');
        if (!Auth::id()) {
            $list->where('agendas.ativo', 'S');
        }
        $list->where('agendas.id', $this->id);
        $list->orderBy('agendas.data_inicial', 'asc');

        $listAll = $list->addSelect( 'agendas.id as id',
                                     'agendas.ativo as ativo',
                                     'agendas.order as order',
                                     'agendas.data as data',
                                     'agendas.title as title',
                                     'agendas.cartola as cartola',
                                     'agendas.linha_apoio as linha_apoio',
                                     'agendas.local as local',
                                     'agendas.image as image',
                                     'agendas.galeria as galeria',
                                     'agendas.evento_facebook as evento_facebook',
                                     'agendas.tags as tags',
                                     'agendas.text as text',
                                     'agendas.data_inicial as data_inicial',
                                     'agendas.data_final as data_final',
                                     'agendas.criador as criador',
                                     'agendas.created_at as created_at',
                                     'agendas.updated_at as updated_at',

                                     'files.id as file_id',
                                     'files.name as file_name',
                                     'files.alternative_text as file_alternative_text',
                                     'files.path as path',
                                     'files.namefile as namefile',
                                     'files.namefilefull as namefilefull' )->get();

        // Trata Calendário
        if ($listAll->count())
        {
            $nomeDias = [ 'Sun' => 'Dom', 'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb' ];
            $nomeMeses = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];

            foreach($listAll as $item)
            {
                $list = DB::table('programacao_has_categoria')
                                  ->join('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                  ->where('programacao_has_categoria.id_programacao', $item->id);

                $calendario = json_decode($item->data);

                // Trata calendario
                $item->calendario = null;
                if (count($calendario))
                {
                    $pos = explode("/", $calendario[0]);
                    $data = new DateTime($pos[2].$pos[1].$pos[0]);

                    $item->calendario = [ ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ] ];

                    if (count($calendario) > 1)
                    {
                        if (count($calendario) == 2) {
                            $item->calendario[] = 'E';
                        } else {
                            $item->calendario[] = 'A';
                        }

                        $pos = explode("/", $calendario[count($calendario) - 1]);
                        $data = new DateTime($pos[2].$pos[1].$pos[0]);
                        $item->calendario[] = ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ];
                    }
                }
            }
        }

        return $listAll->first();
    }

    public function listAgendas()
    {
        $list = DB::table('agendas');
        $list->leftjoin('files', 'files.id', '=', 'agendas.image');
        if (!Auth::id()) {
            $list->where('agendas.ativo', 'S');
        }
        $list->orderBy('agendas.data_inicial', 'desc');

        $listAll = $list->addSelect( 'agendas.id as id',
                                     'agendas.ativo as ativo',
                                     'agendas.order as order',
                                     'agendas.data as data',
                                     'agendas.title as title',
                                     'agendas.cartola as cartola',
                                     'agendas.linha_apoio as linha_apoio',
                                     'agendas.local as local',
                                     'agendas.image as image',
                                     'agendas.galeria as galeria',
                                     'agendas.evento_facebook as evento_facebook',
                                     'agendas.tags as tags',
                                     'agendas.text as text',
                                     'agendas.data_inicial as data_inicial',
                                     'agendas.data_final as data_final',
                                     'agendas.criador as criador',
                                     'agendas.created_at as created_at',
                                     'agendas.updated_at as updated_at',

                                     'files.id as file_id',
                                     'files.name as file_name',
                                     'files.alternative_text as file_alternative_text',
                                     'files.path as path',
                                     'files.namefile as namefile',
                                     'files.namefilefull as namefilefull' )->get();
         return $listAll;
    }


    // Site
    public function listAgendaHome()
    {
        // dd(today()->endOfDay());
        $list = DB::table('agendas');
        $list->leftjoin('files', 'files.id', '=', 'agendas.image');
        if (!Auth::id()) {
            $list->where('agendas.ativo', 'S');
        }
        $list->where('agendas.data_final', '>', today()->startOfDay());
        $list->orderBy('agendas.data_inicial', 'asc');

        $listAll = $list->addSelect( 'agendas.id as id',
                                     'agendas.ativo as ativo',
                                     'agendas.order as order',
                                     'agendas.data as data',
                                     'agendas.title as title',
                                     'agendas.cartola as cartola',
                                     'agendas.linha_apoio as linha_apoio',
                                     'agendas.local as local',
                                     'agendas.image as image',
                                     'agendas.galeria as galeria',
                                     'agendas.evento_facebook as evento_facebook',
                                     'agendas.tags as tags',
                                     'agendas.text as text',
                                     'agendas.data_inicial as data_inicial',
                                     'agendas.data_final as data_final',
                                     'agendas.criador as criador',
                                     'agendas.created_at as created_at',
                                     'agendas.updated_at as updated_at',

                                     'files.id as file_id',
                                     'files.name as file_name',
                                     'files.alternative_text as file_alternative_text',
                                     'files.path as path',
                                     'files.namefile as namefile',
                                     'files.namefilefull as namefilefull' )->get();


         // Trata Calendário
         if ($listAll->count())
         {
              $nomeDias = [ 'Sun' => 'Dom', 'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb' ];
              $nomeMeses = ['01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr', '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'];

              foreach($listAll as $item)
              {
                    $list = DB::table('programacao_has_categoria')
                                      ->join('categorias', 'categorias.id', '=', 'programacao_has_categoria.id_categoria')
                                      ->where('programacao_has_categoria.id_programacao', $item->id);

                    $calendario = json_decode($item->data);

                    // Trata calendario
                    $item->calendario = null;
                    if (count($calendario))
                    {
                        $pos = explode("/", $calendario[0]);
                        $data = new DateTime($pos[2].$pos[1].$pos[0]);

                        $item->calendario = [ ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ] ];

                        if (count($calendario) > 1)
                        {
                            if (count($calendario) == 2) {
                                $item->calendario[] = 'E';
                            } else {
                                $item->calendario[] = 'A';
                            }

                            $pos = explode("/", $calendario[count($calendario) - 1]);
                            $data = new DateTime($pos[2].$pos[1].$pos[0]);
                            $item->calendario[] = ['nomeDia' => $nomeDias[$data->format('D')], 'numeroDia' => $data->format('d'), 'nomeMes' => $nomeMeses[$data->format('m')], 'numeroMes' => $data->format('m') ];
                        }
                    }
              }
         }

         return $listAll;
    }

}
