<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Colunista;
use App\Models\Materia;
use App\Models\File;
use Classes\Helpers;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;


class BancoImagensController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Banco de imagens'];
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

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'galeria'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;

        $file = new File();
        $return['files'] = $file->listGaleria();


        if($erros)
        {
          return view('adm.banco-imagens')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.banco-imagens')->withReturn($return);
          } else {
              return redirect('/adm/banco-imagens'); //Adicionado o redirect para limpar o post
          }
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
                    'file' => 'required|image|dimensions:min_width=100,min_height=100',
                    'description' => 'max:240',
                    'alternative_text' => 'max:140',
                ];
                $messages = [
                    'category.required' => 'Campo categoria é obrigatório.',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                    'file.required' => 'Campo imagem é obrigatório.',
                    'file.image' => 'Para o campo imagem só permitido arquivos do tipo imagens.',
                    'file.dimensions' => 'A imagem não pode ter dimensões inferiores que 100x100.',
                    'description.max' => 'A descrição da imagem não pode ter mais do que 240 caracteres.',
                    'alternative_text.max' => 'O texto alternativo não pode ter mais do que 140 caracteres.',
                ];
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'category' => 'required',
                    'name' => 'required|max:140',
                    'file' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'description' => 'max:240',
                    'alternative_text' => 'max:140',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado',
                    'category.required' => 'Campo categoria é obrigatório.',
                    'name.required' => 'Campo nome é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                    'file.image' => 'Para o campo imagem só permitido arquivos do tipo imagens!',
                    'file.dimensions' => 'A imagem não pode ter dimensões inferiores que 100x100!',
                    'description.max' => 'A descrição da imagem não pode ter mais do que 240 caracteres.',
                    'alternative_text.max' => 'O texto alternativo não pode ter mais do que 140 caracteres.',
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
        if($request->input('action') == 'delete')
        {
            $validator = $this->validaDelete($request, $validator);
        }

        return $validator;
    }


    private function register(Request $request)
    {
        $helpers = new Helpers();
        $file = $helpers->loadImg( $request->file('file') );
        $nameImgNew = Str::slug($request->input('name'), '-') .
                      '_' . time() .
                      '.' . $file['OriginalExtension'];
        $path = 'images/_Galeria';
        $pathThumbMedium = 'images/_Galeria/_Medium';
        $pathThumbMini = 'images/_Galeria/_Mini';
        $file['File']->move($path, $nameImgNew);
        Image::make($path.'/'.$nameImgNew)->fit(700,500)->save($pathThumbMedium.'/'.$nameImgNew);
        Image::make($path.'/'.$nameImgNew)->fit(200,150)->save($pathThumbMini.'/'.$nameImgNew);

        if( file_exists($path.'/'.$nameImgNew) )
        {
          $fileImg = new File();
          $fileImg->path = $path;
          $fileImg->category = $request->input('category');
          $fileImg->name = $request->input('name');
          $fileImg->namefile = $nameImgNew;
          $fileImg->namefilefull = $path.'/'.$nameImgNew;
          $fileImg->mimetype = $file['MimeType'];
          $fileImg->extension = $file['OriginalExtension'];
          $fileImg->size = $file['Size'];
          $fileImg->description = $request->input('description');
          $fileImg->alternative_text = $request->input('alternative_text');

          $fileImg->save();
        }

        return true;
    }

    private function edit(Request $request)
    {
        $fileImg = new File();
        $edit = $fileImg->find($request->input('id'));

        if($edit->name != $request->input('name') || $request->file('fileEdit'))
        {
            $nameImgNew = Str::slug($request->input('name'), '-') .
                          '_' . time() .
                          '.' . $edit->extension;
            $pathFullAntigo = $edit->namefilefull;
            $nameFile = $edit->namefile;
            $path = $edit->path;
            $pathThumbMedium = 'images/_Galeria/_Medium';
            $pathThumbMini = 'images/_Galeria/_Mini';

            if ( file_exists($pathFullAntigo) )
            {
                // Caso seja informada uma imagem, é deletada a antiga e adicionada uma nova.
                // Caso contrario apenas é renomeada a existente.
                if( $request->file('fileEdit') )
                {
                    $helpers = new Helpers();
                    $file = $helpers->loadImg( $request->file('fileEdit') );

                    if(unlink($pathFullAntigo))
                    {
                        unlink($edit->path .'/_Medium/'. $nameFile);
                        unlink($edit->path .'/_Mini/'. $nameFile);
                        $file['File']->move($path, $nameImgNew);
                        Image::make($path.'/'.$nameImgNew)->fit(700,500)->save($pathThumbMedium.'/'.$nameImgNew);
                        Image::make($path.'/'.$nameImgNew)->fit(200,150)->save($pathThumbMini.'/'.$nameImgNew);
                    }

                    $edit->mimetype = $file['MimeType'];
                    $edit->extension = $file['OriginalExtension'];
                    $edit->size = $file['Size'];
                }
                else
                {
                    rename ($pathFullAntigo, $path.'/'.$nameImgNew);
                }
            }
            $edit->name = $request->input('name');
            $edit->namefile = $nameImgNew;
            $edit->namefilefull = $path.'/'.$nameImgNew;
        }

        $edit->category = $request->input('category');
        $edit->description = $request->input('description');
        $edit->alternative_text = $request->input('alternative_text');

        $edit->save();
        return true;
    }

    private function validaDelete (Request $request, $validator)
    {
        $erro = false;
        $Mensagem = '';
        $fileImg = new File();
        $image = $fileImg->find($request->input('id'));

        if (!$image)
        {
            $erro = true;
            $Mensagem = 'Não foi encontrado nenhuma imagem no Banco de Imagens';
            $this->msgErros = $Mensagem;
        }
        else
        {
            $Materia = new Materia();
            $materias = $Materia->all()->where('image', $image->id);
            $Mensagem = '';

            if( count($materias) )
            {
                $erro = true;
                $Mensagem .= 'A imagem está sendo utilizada nas seguinte(s) matéria(s):';
                $Mensagem .= '<ul>';

                foreach($materias as $materia) {
                    $Mensagem .= '<li> Título: '. $materia->title . ' ( tipo: '.$materia->type.' ).</li>';
                }

                $Mensagem .= '</ul>';
                $this->msgErros .= $Mensagem;
            }

            $Colunista = new Colunista();
            $colunistas = $Colunista->all()->where('avatar', $image->id);
            $Mensagem = '';

            if( count($colunistas) )
            {
                $erro = true;
                $Mensagem .= 'A imagem está sendo utilizada nos seguinte(s) colunista(s):';
                $Mensagem .= '<ul>';

                foreach($colunistas as $colunista) {
                    $Mensagem .= '<li> Nome: '. $colunista->name . ' ( Cargo: '.$colunista->cargo.' ).</li>';
                }

                $Mensagem .= '</ul>';
                $this->msgErros .= $Mensagem;
            }
        }

        if($erro)
        {
            $validator->after(function ($validator) {
                $validator->errors()->add('field', $this->msgErros);
            });
        }

        return $validator;
    }

    private function delete(Request $request)
    {
        $fileImg = new File();
        $delete = $fileImg->find($request->input('id'));
        $pathFullAntigo = $delete->namefilefull;

        $nameFile = $delete->namefile;
        $path = $delete->path;
        $pathThumbMedium = 'images/_Galeria/_Medium';
        $pathThumbMini = 'images/_Galeria/_Mini';

        if ( file_exists($pathFullAntigo) )
        {
            if(unlink($pathFullAntigo))
            {
                unlink($pathThumbMedium .'/'. $nameFile);
                unlink($pathThumbMini .'/'. $nameFile);
            }
        }
        $delete->delete();

        return true;
    }
}
