<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileGaleria;
use App\Models\Galeria;
use App\Models\GaleriaHasImagem;
use App\Models\Materia;
use Classes\Helpers;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class GaleriaController extends Controller
{
    private $msgErros = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $id = null)
    {
        $return = ['title' => 'Galerias'];
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
                        $this->orderGalery($request);
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

        $listGaleria = new Galeria();
        $return['galerias'] = $listGaleria->all()->sortByDesc('order');

        $listGaleria = new Galeria();
        $return['files'] = $listGaleria->listImages();

        if($erros)
        {
          return view('adm.galeria')->withReturn($return)->withErrors($validator);
        }
        else
        {
          if($firstCall) {
              return view('adm.galeria')->withReturn($return);
          } else {
              return redirect('/adm/galeria'); //Adicionado o redirect para limpar o post
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
                    'files.*' => 'required|image|dimensions:min_width=100,min_height=100',
                    'namedefault' => 'nullable|max:140',
                ];
                $messages = [
                    'title.required' => 'Campo nome da galeria é obrigatório.',
                    'title.max' => 'Nome da galeria não pode ter mais do que 240 caracteres.',
                    'files.*.required' => 'É obrigatório selecionar pelo menos uma imagem.',
                    'files.*.image' => 'Para o campo imagem só permitido arquivos do tipo imagem.',
                    'files.*.dimensions' => 'As imagens não pode ser de dimensões inferiores que 100x100.',
                    'namedefault.max' => 'Nome das imagens não pode ter mais do que 140 caracteres.',
                ];
                break;
            case 'order':
                $rules = [ 'id' => 'required' ];
                $messages = [ 'id.required' => 'Nenhum registro informado!' ];
                break;
            case 'edit':
                $rules = [
                    'title' => 'required|max:240',
                    'files.*' => 'nullable|image|dimensions:min_width=100,min_height=100',
                    'namedefault' => 'nullable|max:140',
                ];
                $messages = [
                    'title.required' => 'Campo nome da galeria é obrigatório.',
                    'title.max' => 'Nome da galeria não pode ter mais do que 240 caracteres.',
                    'files.*.image' => 'Para o campo imagem só permitido arquivos do tipo imagem.',
                    'files.*.dimensions' => 'As imagens não pode ser de dimensões inferiores que 100x100.',
                    'namedefault.max' => 'Nome das imagens não pode ter mais do que 140 caracteres.',
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
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:140',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'name.required' => 'Campo nome da imagem é obrigatório.',
                    'name.max' => 'Nome da imagem não pode ter mais do que 140 caracteres.',
                ];
                break;
            case 'delete-image':
                $rules = [
                    'id' => 'required',
                    'idhasImagem' => 'required',
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'idhasImagem.required' => 'Nenhum registro informado!',
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


    private function orderGalery(Request $request)
    {
      $trueFalse = true;

      $update = new Galeria();
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
        $register = new Galeria();
        $idOrder = 0;
        if ($register->max('id')) {
            $idOrder = $register->max('id');
        }
        $idOrder++;

        $register->title = $request->input('title');
        $register->description = $request->input('description');
        $register->order = $idOrder;

        $register->save();

        // Save lot of photos
        foreach ($request->file('files') as $fileItem)
        {
            // Prepare registers and moving to files
            $helpers = new Helpers();
            $file = $helpers->loadImg( $fileItem );

            $nameImg = Str::slug(str_before($file['OriginalName'], '.'), '-');
            $nameImgNew = $nameImg .
                          '_' . time() .
                          '.' . $file['OriginalExtension'];
            $path = 'images/_Galeria/_PageGaleria';


            $nameImgThumb = Str::slug(str_before($file['OriginalName'], '.'), '-');
            $nameImgNewThumb = $nameImgThumb .
                          '_thumb' . time() .
                          '.' . $file['OriginalExtension'];
            $pathThumb = 'images/_Galeria/_PageGaleria/Thumb';
            $file['File']->move($path, $nameImgNew);
            //Thumb
            $thumb = Image::make($path.'/'.$nameImgNew)->fit(200,150)->save($pathThumb.'/'.$nameImgNewThumb);

            // Save registers in bank
            if( file_exists($path.'/'.$nameImgNew) )
            {
                // Registering the images
                $fileImg = new FileGaleria();
                $fileImg->path = $path;
                $fileImg->name = $request->input('namedefault') != '' ? $request->input('namedefault') : $nameImg;
                $fileImg->namefile = $nameImgNew;
                $fileImg->namefilefull = $path.'/'.$nameImgNew;

                $fileImg->mimetype = $file['MimeType'];
                $fileImg->extension = $file['OriginalExtension'];
                $fileImg->size = $file['Size'];

                $fileImg->paththumb = $pathThumb;
                $fileImg->namethumb = $request->input('namedefault') != '' ? $request->input('namedefault') : $nameImgThumb;
                $fileImg->namefilethumb = $nameImgNewThumb;
                $fileImg->namefilefullthumb = $pathThumb.'/'.$nameImgNewThumb;
                $fileImg->sizethumb = $thumb->filesize();

                $fileImg->save();

                // Registering the control of images and galery
                $galeriaHasImagem = new GaleriaHasImagem();
                $idOrder = 0;
                if ($galeriaHasImagem->max('order')) {
                    $idOrder = $galeriaHasImagem->max('order');
                }
                $idOrder++;
                $galeriaHasImagem->id_galeria = $register->toArray()['id'];
                $galeriaHasImagem->id_file = $fileImg->toArray()['id'];
                $galeriaHasImagem->order = $idOrder;

                $galeriaHasImagem->save();
            }
        }

        return true;
    }


    private function edit(Request $request)
    {
        $id = $request->input('id');
        $galeria = new Galeria();
        $edit = $galeria->find($id);

        $edit->title = $request->input('title');
        $edit->description = $request->input('description');

        $edit->save();

        if( count($request->file('files')) )
        {

          foreach ($request->file('files') as $fileItem)
          {
              // Prepare registers and moving to files
              $helpers = new Helpers();
              $file = $helpers->loadImg( $fileItem );

              $nameImg = Str::slug(str_before($file['OriginalName'], '.'), '-');
              $nameImgNew = $nameImg .
                            '_' . time() .
                            '.' . $file['OriginalExtension'];
              $path = 'images/_Galeria/_PageGaleria';

              $nameImgThumb = Str::slug(str_before($file['OriginalName'], '.'), '-');
              $nameImgNewThumb = $nameImgThumb .
                            '_thumb' . time() .
                            '.' . $file['OriginalExtension'];
              $pathThumb = 'images/_Galeria/_PageGaleria/Thumb';
              $file['File']->move($path, $nameImgNew);
              //Thumb
              $thumb = Image::make($path.'/'.$nameImgNew)->fit(200,150)->save($pathThumb.'/'.$nameImgNewThumb);

              // Save registers in bank
              if( file_exists($path.'/'.$nameImgNew) )
              {
                  // Registering the images
                  $fileImg = new FileGaleria();
                  $fileImg->path = $path;
                  $fileImg->name = $request->input('namedefault') != '' ? $request->input('namedefault') : $nameImg;
                  $fileImg->namefile = $nameImgNew;
                  $fileImg->namefilefull = $path.'/'.$nameImgNew;

                  $fileImg->mimetype = $file['MimeType'];
                  $fileImg->extension = $file['OriginalExtension'];
                  $fileImg->size = $file['Size'];

                  $fileImg->paththumb = $pathThumb;
                  $fileImg->namethumb = $request->input('namedefault') != '' ? $request->input('namedefault') : $nameImgThumb;
                  $fileImg->namefilethumb = $nameImgNewThumb;
                  $fileImg->namefilefullthumb = $pathThumb.'/'.$nameImgNewThumb;
                  $fileImg->sizethumb = $thumb->filesize();

                  $fileImg->save();

                  // Registering the control of images and galery
                  $galeriaHasImagem = new GaleriaHasImagem();
                  $idOrder = 0;
                  if ($galeriaHasImagem->max('order')) {
                      $idOrder = $galeriaHasImagem->max('order');
                  }
                  $idOrder++;
                  $galeriaHasImagem->id_galeria = $id;
                  $galeriaHasImagem->id_file = $fileImg->toArray()['id'];
                  $galeriaHasImagem->order = $idOrder;

                  $galeriaHasImagem->save();
              }
          }

        }

        return true;
    }


    private function validaDelete (Request $request, $validator)
    {
        $erro = false;
        $Mensagem = '';
        $galeria = new Galeria();
        $galerias = $galeria->find($request->input('id'));

        if (!$galerias)
        {
            $erro = true;
            $Mensagem = 'Não foi encontrado nenhuma galeria de imagens';
            $this->msgErros = $Mensagem;
        }
        else
        {
            $Materia = new Materia();
            $materia = $Materia->all()->where('galeria', $galerias->id);
            $Mensagem = '';

            if( count($materia) )
            {
                $erro = true;
                $Mensagem .= 'A galeria está sendo utilizada nad seguintes Materias:';
                $Mensagem .= '<ul>';

                foreach($materia as $item) {
                    $Mensagem .= '<li> Título: '. $item->title .' (tipo de materia: '.$item->type.').</li>';
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
        $id = $request->input('id');

        $galeria = new Galeria();
        $delete = $galeria->find($id);

        $galeriaHasImagem = new GaleriaHasImagem();
        $deleteGaleriaHasImagem = $galeriaHasImagem->all()->where('id_galeria', '=', $id);
        foreach ($deleteGaleriaHasImagem as $itemDelete)
        {
            $files = new FileGaleria();
            $file = $files->find($itemDelete->id_file);

            if ( file_exists($file->namefilefullthumb) ) {
                unlink($file->namefilefull);
                unlink($file->namefilefullthumb);
            }

            $file->delete();
            $itemDelete->delete();
        }

        $delete->delete();

        return true;
    }


    private function orderImage(Request $request)
    {
      $trueFalse = true;

      $update = new GaleriaHasImagem();
      $edit = $update->where('id_galeria', '=', $request->input('idGaleria'))->orderBy('order', 'asc')->get()->toArray();
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


    private function editImage(Request $request)
    {
        $update = new FileGaleria();
        $edit = $update->find($request->input('id'));
        $edit->name = $request->input('name');
        $edit->namethumb = $request->input('name');

        $edit->save();

        return true;
    }

    private function deleteImage(Request $request)
    {
        $id = $request->input('id');
        $idHasImagem = $request->input('idhasImagem');

        $hasImagem = new GaleriaHasImagem();
        $deleteHasImagem = $hasImagem->find($idHasImagem);
        $file = new FileGaleria();
        $deleteFile = $file->find($id);

        if ( file_exists($deleteFile->namefilefullthumb) ) {
            unlink($deleteFile->namefilefull);
            unlink($deleteFile->namefilefullthumb);
            $deleteFile->delete();
            $deleteHasImagem->delete();
        }

        return true;
    }

}
