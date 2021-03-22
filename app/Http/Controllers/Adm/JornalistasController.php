<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Jornalista;
use Illuminate\Support\Facades\Validator;

class JornalistasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Jornalistas'];
        $erros = false;

        if ($request->isMethod('post'))
        {
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

        $file = new File();
        $return['files'] = $file->listGaleria();

        $file = new Jornalista();
        $return['jornalistas'] = $file->listJornalistas();

        if($erros)
        {
          return view('adm.jornalistas')->withReturn($return)->withErrors($validator);
        }
        else
        {
          return view('adm.jornalistas')->withReturn($return);
        }

    }

    public function edit(Request $request, $id = null)
    {
        $return = ['title' => 'Jornalista - Edição'];
        $erros = false;

        if ($request->isMethod('post'))
        {
            $validator = $this->validator($request);

            if (!$validator->fails())
            {
                switch ( $request->input('action') )
                {
                    case 'edit':
                        $this->update($request);
                        break;
                }
            }
            else
            {
              $erros = true;
            }
        }

        $file = new File();
        $return['files'] = $file->listGaleria();

        $file = new Jornalista();
        $return['jornalista'] = $file->listJornalista($id);



        if($erros)
        {
          return view('adm.jornalistas-edit')->withReturn($return)->withErrors($validator);
        }
        else
        {
          return view('adm.jornalistas-edit')->withReturn($return);
        }

    }

    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'name' => 'required|max:140',
                    'cargo' => 'nullable|max:140',
                ];
                $messages = [
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                    'cargo.max' => 'O campo cargo não pode ter mais do que 140 caracteres.',
                ];
                break;
            case 'edit':
                $rules = [
                    'name' => 'required|max:140',
                    'cargo' => 'nullable|max:140',
                ];
                $messages = [
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                    'cargo.max' => 'O campo cargo não pode ter mais do que 140 caracteres.',
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
          $jornalista = new Jornalista();
          $jornalista->name = $request->input('name');
          $jornalista->cargo = $request->input('cargo');
          $jornalista->avatar = $request->input('avatar');

          $jornalista->save();

        return true;
    }

    private function update(Request $request)
    {
          $jornalista = new Jornalista();
          $edit = $jornalista->find($request->input('id'));
          $edit->name = $request->input('name');
          $edit->cargo = $request->input('cargo');
          $edit->avatar = $request->input('avatar');

          $edit->save();

        return true;
    }

    private function delete(Request $request)
    {
        $jornalista = new Jornalista();
        $delete = $jornalista->find($request->input('id'));
        $delete->delete();

        return true;
    }

}
