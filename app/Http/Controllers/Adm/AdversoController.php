<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileGaleria;
use App\Models\File;
use App\Models\Revista;
use App\Models\RevistaHasImagem;
use App\Models\Materia;
use Classes\Helpers;
use Illuminate\Support\Facades\Validator;

class AdversoController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'ADVerso'];
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
                    case 'order':
                        $this->orderRevista($request);
                        break;
                    case 'register':
                        $this->register($request);
                        break;
                    case 'edit':
                        $this->edit($request);
                        break;
                    case 'delete':
                        $this->delete($request);
                        break;
                    case 'order-image':
                        $this->orderImage($request);
                        break;
                    case 'edit-image':
                        $this->editImage($request);
                        break;
                    case 'delete-image':
                        $this->deleteImage($request);
                        break;
                }
            }
            else
            {
              $erros = true;
            }
        }

        $listRevistas = new Revista();
        $return['revistas'] = $listRevistas->all()->sortByDesc('order');
        // $return['revistas'] = $listGaleria->all()->sortByDesc('order');

        $file = new File();
        $return['files'] = $file->listGaleria();

        $revistaHasImagem = new File();
        $return['revistaHasImagem'] = $file->listGaleriaEditar();

        if($erros)
        {
          return view('adm.adverso')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.adverso')->withReturn($return);
          } else {
              return redirect('/adm/adverso'); //Adicionado o redirect para limpar o post
          }
        }
    }



    private function validator($request)
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'title' => 'required|max:240',
                    'imagens' => 'required',
                ];
                $messages = [
                    'title.required' => 'Campo nome da revista é obrigatório.',
                    'title.max' => 'Nome da revista não pode ter mais do que 240 caracteres.',
                    'imagens.required' => 'Campo imagens é obrigatório.',
                ];
                break;
            case 'order':
                $rules = [ 'id' => 'required' ];
                $messages = [ 'id.required' => 'Nenhum registro informado!' ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'title' => 'required|max:240',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'title.required' => 'Campo nome da revista é obrigatório.',
                    'title.max' => 'Nome da revista não pode ter mais do que 240 caracteres.',
                ];
                break;
            case 'delete':
                $rules = [ 'id' => 'required' ];
                $messages = [ 'id.required' => 'Nenhum registro informado!' ];
                break;
            case 'order-image':
                $rules = [ 'id' => 'required' ];
                $messages = [ 'id.required' => 'Nenhum registro informado!' ];
                break;
            case 'edit-image':
                $rules = [ 'id' => 'required' ];
                $messages = [ 'id.required' => 'Nenhum registro informado!' ];
                break;
            case 'delete-image':
                $rules = [ 'id' => 'required', ];
                $messages = [ 'id.required' => 'Nenhum registro informado!', ];
                break;
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        return $validator;
    }


    private function orderRevista(Request $request)
    {
      $trueFalse = true;
      $update = new Revista();
      $edit = $update->orderBy('order', 'desc')->get()->toArray();
      $id = $request->input('id');
      $orderNext = null;
      if( count($edit) > 1 )
      {
          for($i = 0; $i < count($edit); $i++)
          {
              if(isset($edit[$i+1]))
              {
                  if($edit[$i+1]['id'] == $id)
                  {
                      $orderNext = $edit[$i+1]['order'];

                      $next = $update->find($edit[$i+1]['id']);
                      $next->order = $edit[$i]['order'];
                      $next->save();

                      $atual = $update->find($edit[$i]['id']);
                      $atual->order = $orderNext;
                      $atual->save();
                  }
              }
          }
      }

      return $trueFalse;
    }


    private function register(Request $request)
    {
        // Save the galery
        // dd('Register');
        $register = new Revista();
        $idOrder = 0;
        if ($register->max('id')) {
            $idOrder = $register->max('id');
        }
        $idOrder++;

        $register->title = $request->input('title');
        $register->order = $idOrder;

        $register->save();

        // -------------------------------------------------------------------
        // imagens
        // -------------------------------------------------------------------
        $imagensArray = [];
        if ($request->input('imagens')) { $imagensArray = explode(",", $request->input('imagens')); }

        if (count($imagensArray))
        {
            foreach ($imagensArray as $item)
            {
                $revistaHasImagem = new RevistaHasImagem();
                $idOrder = 0;
                if ($revistaHasImagem->max('order')) {
                    $idOrder = $revistaHasImagem->max('order');
                }
                $idOrder++;
                $revistaHasImagem->order = $idOrder;
                $revistaHasImagem->id_revista = $register->id;
                $revistaHasImagem->id_file = $item;
                $revistaHasImagem->save();
            }
        }

        return true;
    }


    private function edit(Request $request)
    {
        $register = new Revista();
        $id = $request->input('id');
        $edit = $register->find($id);
        $edit->title = $request->input('title');
        $edit->save();

        // -------------------------------------------------------------------
        // imagens
        // -------------------------------------------------------------------
        $delete = new RevistaHasImagem();
        $delete = $delete->where('id_revista','=', $id);

        if ($delete->count()) {
            $delete->delete();
        }

        $imagensArray = [];
        if ($request->input('imagens')) { $imagensArray = explode(",", $request->input('imagens')); }

        if (count($imagensArray))
        {
            foreach ($imagensArray as $item)
            {
                $revistaHasImagem = new RevistaHasImagem();
                $idOrder = 0;
                if ($revistaHasImagem->max('order')) {
                    $idOrder = $revistaHasImagem->max('order');
                }
                $idOrder++;
                $revistaHasImagem->order = $idOrder;
                $revistaHasImagem->id_revista = $id;
                $revistaHasImagem->id_file = $item;
                $revistaHasImagem->save();
            }
        }


        return true;
    }

    private function delete(Request $request)
    {
        $id = $request->input('id');

        $delete = new Revista();
        $delete->find($id)->delete();

        $deleteFiles = new RevistaHasImagem();
        $deleteFiles->where('id_revista', '=', $id)->delete();

        return true;
    }


    private function orderImage(Request $request)
    {
      $trueFalse = true;
      $id = $request->input('id');
      $update = new RevistaHasImagem();
      $edit = $update->find($id);

      // dd($id);
      // $edit = $update->where('id_revista', '=', $edit->id_revista)->orderBy('order', 'asc')->get()->toArray();
      $edit = $update->where('id_revista', '=', $edit->id_revista)->orderBy('order', 'asc')->get()->toArray();
       // dd($edit);
      $orderNext = null;
      if( count($edit) > 1 )
      {
          for($i = 0; $i < count($edit); $i++)
          {
              if(isset($edit[$i-1]))
              {
                  if($edit[$i]['id'] == $id)
                  {
                      $orderPrev = $edit[$i-1]['order'];

                      $prev = $update->find($edit[$i-1]['id']);
                      $prev->order = $edit[$i]['order'];
                      $prev->save();

                      $atual = $update->find($edit[$i]['id']);
                      $atual->order = $orderPrev;
                      $atual->save();
                  }
              }
          }
      }

      return $trueFalse;
    }


    private function editImage(Request $request)
    {
        $update = new RevistaHasImagem();
        $edit = $update->find($request->input('id'));
        $edit->link = $request->input('link');

        $edit->save();
        return true;
    }

    private function deleteImage(Request $request)
    {
        $id = $request->input('id');

        $hasImagem = new RevistaHasImagem();
        $deleteHasImagem = $hasImagem->find($id);
        $deleteHasImagem->delete();

        return true;
    }

}
