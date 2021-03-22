<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\File;
use App\Models\Colunista;
use Illuminate\Support\Facades\Validator;

class ColunistasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Colunistas'];
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

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'colunista'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;

        $file = new File();
        $return['files'] = $file->listGaleria();

        $file = new Colunista();
        $return['colunistas'] = $file->listColunistas();

        if($erros)
        {
          return view('adm.colunistas')->withReturn($return)->withErrors($validator);
        }
        else
        {
          return view('adm.colunistas')->withReturn($return);
        }

    }

    public function edit(Request $request, $id = null)
    {
        $return = ['title' => 'Colunista - Edição'];
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

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'colunista'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;

        $file = new File();
        $return['files'] = $file->listGaleria();

        $file = new Colunista();
        $return['colunista'] = $file->listColunista($id);



        if($erros)
        {
          return view('adm.colunistas-edit')->withReturn($return)->withErrors($validator);
        }
        else
        {
          return view('adm.colunistas-edit')->withReturn($return);
        }

    }

    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'category' => 'required',
                    'name' => 'required|max:140',
                    'avatar' => 'required',
                    'cargo' => 'max:140',
                ];
                $messages = [
                    'category.required' => 'Campo categoria é obrigatório.',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                    'avatar.required' => 'Campo avatar é obrigatório.',
                    'cargo.required' => 'Campo cargo é obrigatório.',
                    'cargo.max' => 'O campo cargo não pode ter mais do que 140 caracteres.',
                ];
                break;
            case 'edit':
                $rules = [
                    'category' => 'required',
                    'name' => 'required|max:140',
                    'avatar' => 'required',
                    'cargo' => 'max:140',
                ];
                $messages = [
                    'category.required' => 'Campo categoria é obrigatório.',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                    'avatar.required' => 'Campo avatar é obrigatório.',
                    'cargo.required' => 'Campo cargo é obrigatório.',
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
          $colunista = new Colunista();
          $colunista->category = $request->input('category');
          $colunista->name = $request->input('name');
          $colunista->cargo = $request->input('cargo');
          $colunista->avatar = $request->input('avatar');

          $colunista->save();

        return true;
    }

    private function update(Request $request)
    {
          $colunista = new Colunista();
          $edit = $colunista->find($request->input('id'));
          $edit->category = $request->input('category');
          $edit->name = $request->input('name');
          $edit->cargo = $request->input('cargo');
          $edit->avatar = $request->input('avatar');

          $edit->save();

        return true;
    }

    private function delete(Request $request)
    {
        $colunista = new Colunista();
        $delete = $colunista->find($request->input('id'));
        $delete->delete();

        return true;
    }

}
