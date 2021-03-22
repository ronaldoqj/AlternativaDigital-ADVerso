<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      $return = ['title' => 'Usuário'];
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
                        $this->edit($request);
                }
            }
            else
            {
              $erros = true;
            }
        }

        $User = new User();
        $user = $User->get();
        $return['return'] = $user[0];

        $file = new File();
        $return['files'] = $file->listGaleria();

        if($erros)
        {
          return view('adm.user')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.user')->withReturn($return);
          } else {
              return redirect('/adm/usuario'); //Adicionado o redirect para limpar o post
          }
        }
    }


    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:190',
                    'funcao' => 'max:190',
                    'email' => 'required|max:190',
                    'password' => 'max:190'
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'name.required' => 'Campo nome é obrigatório.',
                    'email.required' => 'Campo email é obrigatório.',
                    'name.max' => 'Campo nome não pode ter mais que 190 caracteres.',
                    'funcao.max' => 'Campo cargo não pode ter mais que 190 caracteres.',
                    'email.max' => 'Campo E-Mail não pode ter mais que 190 caracteres.',
                    'password.max' => 'Campo senha não pode ter mais que 190 caracteres.'
                ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function edit($request)
    {
        $user = new User();
        $edit = $user->find(Auth::user()->id);
        $edit->name = $request->input('name');
        $edit->funcao = $request->input('funcao');
        $edit->image = $request->input('image');
        $edit->email = $request->input('email');
        if ($request->input('password')) {
            $edit->password = bcrypt($request->input('password'));
        }

        $edit->save();
        return true;
    }

}
