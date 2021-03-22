<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Materia;
use App\Models\AdmHome;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    private $msgErros = '';


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $return = ['title' => 'ORDEM DE APRESENTAÇÃO HOME'];
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
                        $this->edit($request);
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

        $home = new AdmHome();

        $homeRegistros = $home->where('section', '=', 'banner')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $home->setSection(['banner']);
        $return['listBanners'] = $home->listHome();
        $return['comboBoxBanners'] = $home->listComboBoxs();

        $listStringIds = [];
        foreach($return['listBanners'] as $list)
        {
            $listStringIds[] = $list->id;
        }
        $return['listBannersIds'] = collect($listStringIds)->implode(',') ;


        $homeRegistros = $home->where('section', '=', 'destaque')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $home->setSection(['destaque']);
        $return['listDestaques'] = $home->listHome();
        $return['comboBoxDestaques'] = $home->listComboBoxs();

        $listStringIds = [];
        foreach($return['listDestaques'] as $list)
        {
            $listStringIds[] = $list->id;
        }
        $return['listDestaquesIds'] = collect($listStringIds)->implode(',') ;


        $homeRegistros = $home->where('section', '=', 'colunista')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $home->setSection(['colunista']);
        $return['listColunistas'] = $home->listHome();
        $return['comboBoxColunistas'] = $home->listComboBoxsColunistas();

        $listStringIds = [];
        foreach($return['listColunistas'] as $list)
        {
            $listStringIds[] = $list->id;
        }
        $return['listColunistasIds'] = collect($listStringIds)->implode(',') ;

        $homeRegistros = $home->where('section', '=', 'tvAdverso')->get()->toArray();
        $arrayIds = [0];
        for($i = 0; $i < count($homeRegistros); $i++)
        {
            $arrayIds[] = $homeRegistros[$i]['materia'];
        }

        $home->idsPermitidos($arrayIds);
        $return['listTvAdverso'] = $home->listHomeTvAdverso();
        $return['comboBoxTvAdverso'] = $home->listComboBoxsTvAdverso();
        // dd($return['listTvAdverso']);

        if($erros)
        {
            return view('adm.home')->withReturn($return)->withErrors($validator);
        }
        else
        {
            if ($firstCall) {
                return view('adm.home')->withReturn($return);
            } else {
                return redirect('/adm'); //Adicionado o redirect para limpar o post
            }
        }

    }



    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = ['news' => 'required'];
                $messages = ['news.required' => 'Obrigatório selecionar uma notícia.'];
                break;
            case 'edit':
                $rules = ['id' => 'required'];
                $messages = ['id.required' => 'Nenhum registro informado'];
                break;
            case 'delete':
                $rules = ['id' => 'required'];
                $messages = ['id.required' => 'Nenhum registro informado!'];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if($request->input('action') == 'edit')
        {
            $validator = $this->validaEdit($request, $validator);
        }

        return $validator;
    }

    private function validaEdit(Request $request, $validator)
    {
        $erro = false;
        $Mensagem = '';

        $listStringIds = $request->input('listStringIds');
        if ( strlen($listStringIds) )
        {
            $listStringIds = explode(',', $listStringIds);

            foreach ($listStringIds as $key)
            {
                $validIds = new AdmHome();
                $edit = $validIds->where('materia', '=', $key)
                                 ->where('section', $request->input('section'))
                                 ->get();

                if ( !$edit->count() )
                {
                    $erro = true;
                    $Mensagem = 'Erro ao editar, uma ou mais matérias não encotram-se mais no sistema, tente realizar novamente a edição.';
                    $this->msgErros = $Mensagem;
                    break;
                }
            }
        }
        else
        {
            $erro = true;
            $Mensagem = 'Erro ao completar a edição, por favor tente novamente.';
            $this->msgErros = $Mensagem;
        }

        if ($erro)
        {
            $validator->after(function ($validator) {
                $validator->errors()->add('field', $this->msgErros);
            });
        }

        return $validator;
    }


    private function register(Request $request)
    {
        $register = new AdmHome();
        $id = 0;
        if ($register->max('id')) {
            $id = $register->max('id');
        }
        $id++;

        $register->materia = $request->input('news');
        $register->order = $id;
        $register->section = $request->input('section');

        $register->save();
        return true;
    }

    private function edit(Request $request)
    {
        $listStringIds = explode(',', $request->input('listStringIds'));
        $id = $request->input('id');

        if ( count($listStringIds) > 1 )
        {
            $idPosicao = array_search($id, $listStringIds);
            $idPosicaoAnterior = $idPosicao - 1;
            $AuxValorPosicaoAnterior = $listStringIds[$idPosicaoAnterior];

            if ($idPosicaoAnterior >= 0)
            {
                $listStringIds[$idPosicaoAnterior] = $listStringIds[$idPosicao];
                $listStringIds[$idPosicao] = $AuxValorPosicaoAnterior;

                $updateDelete = new AdmHome();
                $delete = $updateDelete->where('section', '=', $request->input('section'));
                $delete->delete();

                foreach ($listStringIds as $key => $value)
                {
                    $register = new AdmHome();

                    $register->materia = $value;
                    $register->order = $key;
                    $register->section = $request->input('section');

                    $register->save();
                }
            }
        }

        return true;
    }

    private function delete(Request $request)
    {
        $delete = new AdmHome();
        $del = $delete->where('id', '=', $request->input('id'));
        $del->delete();

        return true;
    }

}
