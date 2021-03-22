<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Agenda;
use App\Models\File;
use App\Models\Galeria;
use Classes\Helpers;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Auth;
use DB;

class AgendaController extends Controller
{
    private $msgErros = '';


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $url = 'agenda';
        $return = [];
        $return['title'] = 'Agenda';

        $erros = false;
        $firstCall = true;

        if ($request->isMethod('post'))
        {
            $firstCall = false;
            $validator = $this->validator($request);

            if (!$validator->fails())
            {
                switch ( $request->input('action') )
                {
                    case 'register':
                        $this->register($request);
                        break;
                    case 'edit':
                        $this->update($request);
                        break;
                    case 'delete':
                        $this->delete($request);
                        break;
                }
            }
            else
            {
                $erros = true;
            }
        }

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'materia'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;

        $file = new File();
        $return['files'] = $file->listGaleria();

        $listGaleria = new Galeria();
        $return['galerias'] = $listGaleria->all()->sortByDesc('order');

        $agenda = new Agenda();
        $return['agendas'] = $agenda->listAgendas();

        if ($erros)
        {
            return view('adm.agenda')->withReturn($return)->withErrors($validator);
        }
        else
        {
            if ($firstCall) {
                return view('adm.agenda')->withReturn($return);
            } else {
                return redirect('/adm/'.$url); //Adicionado o redirect para limpar o post
            }
        }
    }

    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'data' => 'required',
                    'title' => 'required|max:240',
                    'cartola' => 'required|max:240',
                    'linha_apoio' => 'max:240',
                    'local' => 'max:240',
                    'evento_facebook' => 'max:240',
                    'tags' => 'max:240'
                ];
                $messages = [
                    'data.required' => 'Campo data é obrigatório.',
                    'title.required' => 'Campo título é obrigatório.',
                    'title.max' => 'Campo título não pode ter mais do que 240 caracteres.',
                    'cartola.required' => 'Campo cartola é obrigatório.',
                    'cartola.max' => 'Campo cartola não pode ter mais do que 240 caracteres.',
                    'linha_apoio.max' => 'Campo linha de apoio não pode ter mais do que 240 caracteres.',
                    'local.max' => 'Campo colunas relacionadas não pode ter mais do que 240 caracteres.',
                    'evento_facebook.max' => 'Campo eventos no facebook não pode ter mais do que 240 caracteres.',
                    'tags.max' => 'Campo tags não pode ter mais do que 240 caracteres.'
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'data' => 'required',
                    'title' => 'required|max:240',
                    'cartola' => 'required|max:240',
                    'linha_apoio' => 'max:240',
                    'local' => 'max:240',
                    'evento_facebook' => 'max:240',
                    'tags' => 'max:240'
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'data.required' => 'Campo data é obrigatório.',
                    'title.required' => 'Campo título é obrigatório.',
                    'title.max' => 'Campo título não pode ter mais do que 240 caracteres.',
                    'cartola.required' => 'Campo cartola é obrigatório.',
                    'cartola.max' => 'Campo cartola não pode ter mais do que 240 caracteres.',
                    'linha_apoio.max' => 'Campo linha de apoio não pode ter mais do que 240 caracteres.',
                    'local.max' => 'Campo colunas relacionadas não pode ter mais do que 240 caracteres.',
                    'evento_facebook.max' => 'Campo eventos no facebook não pode ter mais do que 240 caracteres.',
                    'tags.max' => 'Campo tags não pode ter mais do que 240 caracteres.'
                ];
                break;
            case 'delete':
                $rules = [
                  'id' => 'required',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function register(Request $request)
    {
          $register = new Agenda();

          $register->ativo = $request->input('ativo') ? 'S' : 'N';
          $id = 0;
          if ($register->max('id')) {
              $id = $register->max('id');
          }
          $id++;
          $register->order = $id;

          $register->data = $request->input('data');
          if ($register->data)
          {
              $arrayAux = [];
              $arrayDatas = explode(",", $register->data);
              foreach ($arrayDatas  as $item)
              {
                  $datetime = new DateTime();
                  $data = $datetime->createFromFormat('d/m/Y', trim($item));
                  $arrayAux[] = $data;
              }

              sort($arrayAux);

              $register->data_inicial = $arrayAux[0];
              $register->data_final = $arrayAux[count($arrayAux)-1];
              $arrayDatas = [];

              foreach ($arrayAux as $item)
              {
                  $arrayDatas[] = $item->format('d/m/Y');
              }

              $register->data = json_encode( $arrayDatas, true );
          }
          else
          {
              $register->data = '[]';
              $register->data_inicial = new DateTime();
              $register->data_final = new DateTime();
          }

          $register->title = $request->input('title');
          $register->cartola = $request->input('cartola');
          $register->linha_apoio = $request->input('linha_apoio');
          $register->local = $request->input('local');
          $register->evento_facebook = $request->input('evento_facebook');
          $register->tags = $request->input('tags');
          $register->text = $request->input('text');

          if ( Auth::id() ) {
              $register->criador = Auth::id();
          }

          $register->save();
          return true;
    }


    public function edit(Request $request, $id = null)
    {
        $return = [];
        $return['title'] = 'Agenda';

        $erros = false;
        $firstCall = true;

        if ($request->isMethod('post'))
        {
            $firstCall = false;
            $validator = $this->validator($request);

            if (!$validator->fails())
            {
                switch ( $request->input('action') )
                {
                    case 'edit':
                        $this->update($request, $id);
                        break;
                }
            }
            else
            {
                $erros = true;
            }
        }

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'materia'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;

        $agenda = new Agenda();
        $return['agenda'] = $agenda->find($id);

        $file = new File();
        $return['files'] = $file->listGaleria();

        $listGaleria = new Galeria();
        $return['galerias'] = $listGaleria->all()->sortByDesc('order');

        $register = new Agenda();
        $register->setId($id);
        $return['register'] = $register->listAgenda();

        if(!$return['agenda']->count() || !$id) {
            return redirect('/adm/agenda'); //Se não encontrar o registro volta para listagem
        }

        if($erros)
        {
            return view('adm.agenda-edit')->withReturn($return)->withErrors($validator);
        }
        else
        {
            if($firstCall) {
                return view('adm.agenda-edit')->withReturn($return);
            } else {
                return redirect('/adm/agenda/edit/'.$id); //Adicionado o redirect para limpar o post
            }
        }
    }


    private function update(Request $request, $id = null)
    {
        $register = new Agenda();
        $edit = $register->find($request->input('id'));

        $edit->ativo = $request->input('ativo') ? 'S' : 'N';
        $edit->title = $request->input('title');
        $edit->cartola = $request->input('cartola');
        $edit->linha_apoio = $request->input('linha_apoio');
        $edit->local = $request->input('local');
        $edit->evento_facebook = $request->input('evento_facebook');
        $edit->tags = $request->input('tags');
        $edit->text = $request->input('text');

        if ($request->input('data') && $request->input('data') != '')
        {
            $arrayAux = [];
            $arrayDatas = explode(",", $request->input('data'));

            foreach ($arrayDatas  as $item)
            {
                $datetime = new DateTime();
                $data = $datetime->createFromFormat('d/m/Y', trim($item));
                $arrayAux[] = $data;
            }

            sort($arrayAux);

            $edit->data_inicial = $arrayAux[0];
            $edit->data_final = $arrayAux[count($arrayAux)-1];
            $arrayDatas = [];

            foreach ($arrayAux as $item)
            {
                $arrayDatas[] = $item->format('d/m/Y');
            }

            $edit->data = json_encode( $arrayDatas, true );
        }
        else {
            $edit->data = '[]';
            $edit->data_inicial = $edit->created_at;
            $edit->data_final = $edit->created_at;
        }

        $edit->save();
        return true;
    }

    private function delete(Request $request)
    {
        $register = new Agenda();
        $delete = $register->find($request->input('id'));
        $delete->delete();

        return true;
    }

    public function preVisualizar(Request $request, $id)
    {
        return redirect('/agenda/'. $id . '/title/pre-visualizar');
    }

}
