<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      $return = ['title' => 'Usuários'];
      $erros = false;
      $firstCall = true;

        if($request->isMethod('post'))
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
                }
            }
            else
            {
              $erros = true;
            }
        }

        $User = new User();
        $users = $User->listUsers();
        $return['usuarios'] = $users;

        $file = new File();
        $return['files'] = $file->listGaleria();

        if($erros)
        {
          return view('adm.users')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.users')->withReturn($return);
          } else {
              return redirect('/adm/usuarios'); //Adicionado o redirect para limpar o post
          }
        }
    }

    public function edit(Request $request, $id = null)
    {
        $return = ['title' => 'Usuários - Edição'];
        $erros = false;
        $firstCall = true;

        if($request->isMethod('post'))
        {
            $firstCall = false;
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

        $User = new User();
        $user = $User->listUser($id);
        $return['usuario'] = $user;

        $file = new File();
        $return['files'] = $file->listGaleria();

        if($erros || !$id)
        {
            return view('adm.users-edit')->withReturn($return)->withErrors($validator);
        }
        else
        {
            if($firstCall) {
                return view('adm.users-edit')->withReturn($return);
            } else {
                return redirect('/adm/usuarios/edit/'.$id); //Adicionado o redirect para limpar o post
            }
        }
    }

    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'name' => 'required|max:190',
                    'funcao' => 'max:190',
                    'email' => 'required|max:190',
                    'password' => 'required|max:190'
                ];
                $messages = [
                    'name.required' => 'Campo nome é obrigatório.',
                    'email.required' => 'Campo email é obrigatório.',
                    'password.required' => 'Campo password é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais que 190 caracteres.',
                    'funcao.max' => 'Campo cargo não pode ter mais que 190 caracteres.',
                    'email.max' => 'Campo E-Mail não pode ter mais que 190 caracteres.',
                    'password.max' => 'Campo senha não pode ter mais que 190 caracteres.'
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:190',
                    'password' => 'max:190'
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais que 190 caracteres.',
                    'password.max' => 'Campo senha não pode ter mais que 190 caracteres.'
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($request->input('action') == 'register' ) {
            $validator = $this->validaRegister($request, $validator);
        }
        return $validator;
    }

    private function validaRegister (Request $request, $validator)
    {
        $erro = false;
        $Mensagem = '';
        $Users = new User();
        $user = $Users->where('email', $request->input('email'))->first();
        if($user) {
            $erro = true;
            $Mensagem = 'Usuário/email existente! Por favor Informe outro usuário/email.';
            $this->msgErros = $Mensagem;
        }

        if($erro)
        {
            $validator->after(function ($validator) {
                $validator->errors()->add('field', $this->msgErros);
            });
        }

        return $validator;
    }

    private function register($request)
    {
        $user = new User();
        $user->ativo = $request->input('ativo') != 'S' ? 'N' : $request->input('ativo');
        $user->name = $request->input('name');
        $user->funcao = $request->input('funcao');
        $user->image = $request->input('image');
        $user->email = $request->input('email');
        $user->type = $request->input('type');
        $user->password = bcrypt($request->input('password'));

        $user->save();
        return true;
    }

    private function update($request)
    {
        $user = new User();
        $edit = $user->find($request->input('id'));
        $edit->ativo = $request->input('ativo') != 'S' ? 'N' : $request->input('ativo');
        $edit->name = $request->input('name');
        $edit->funcao = $request->input('funcao');
        $edit->image = $request->input('image');
        $edit->type = $request->input('type');
        if ($request->input('password')) {
            $edit->password = bcrypt($request->input('password'));
        }

        $edit->save();
        return true;
    }

}
