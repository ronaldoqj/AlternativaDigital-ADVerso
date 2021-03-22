<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\File;
use App\Models\TvAdverso;
use App\Models\Colunista;
use App\Models\Jornalista;
use App\Models\Materia;
use App\Models\Galeria;
use App\Models\AdmHome;
use Classes\Helpers;
use Illuminate\Support\Facades\Validator;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;

class MateriasController extends Controller
{
    private $msgErros = '';


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function noticiaEspecial(Request $request, $id = null) { return $this->index($request, $id, 'especial'); }
    public function noticiaNormal(Request $request, $id = null) { return  $this->index($request, $id, 'normal'); }
    public function coluna(Request $request, $id = null) { return  $this->index($request, $id, 'coluna'); }

    public function editNoticiaEspecial(Request $request, $id = null) { return $this->edit($request, $id, 'especial'); }
    public function editNoticiaNormal(Request $request, $id = null) { return  $this->edit($request, $id, 'normal'); }
    public function editNoluna(Request $request, $id = null) { return  $this->edit($request, $id, 'coluna'); }

    public function index(Request $request, $id, $typeMateria = 'normal')
    {
      $type = $typeMateria;
      $url = 'noticia-normal';
      $return = [];
      $return['title'] = 'Matérias';
      $return['typeMateria'] = $type;

      switch ( $type )
      {
          case 'especial':
              $return['title'] = 'Matérias - Notícia Especial';
              $url = 'noticia-especial';
              break;
          case 'normal':
              $return['title'] = 'Matérias - Notícia Normal';
              $url = 'noticia-normal';
              break;
          case 'coluna':
              $return['title'] = 'Matérias - Coluna';
              $url = 'coluna';
              break;
      }


      $erros = false;
      $firstCall = true;


      if ($request->isMethod('post'))
      {
          $firstCall = false;
          $validator = $this->validator($request, $type);

          if (!$validator->fails())
          {
              switch ( $request->input('action') )
              {
                  case 'register':
                      $this->register($request, $type);
                      break;
                  case 'edit':
                      $this->update($request, $type);
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

      $colunista = new Colunista();
      $return['colunistas'] = $colunista->listColunistas();

      $jornalista = new Jornalista();
      $return['jornalistas'] = $jornalista->listJornalistas();

      $materia = new Materia();
      $materia->setType($type);
      $return['materias'] = $materia->listMaterias();

      $tvAdverso = new TvAdverso();
      $tvAdversoAll = $tvAdverso->all()->sortByDesc('order'); //Retorna todos registros
      $return['tvAdverso'] = $tvAdversoAll;

      $listGaleria = new Galeria();
      $return['galerias'] = $listGaleria->all()->sortByDesc('order');

      if($erros)
      {
        return view('adm.materias')->withReturn($return)->withErrors($validator);
      }
      else
      {
        if($firstCall) {
            return view('adm.materias')->withReturn($return);
        } else {
            return redirect('/adm/materias/'.$url); //Adicionado o redirect para limpar o post
        }
      }

    }


    private function validator($request, $type = 'normal')
    {
        switch ( $request->input('action') )
        {
            case 'register':
                $rules = [
                    'type' => 'required',
                    'assunto' => 'required|max:240',
                    'title' => 'required|max:240',
                    'subtitle' => 'required|max:240',
                    'tags' => 'max:240',
                    'noticias_relacionadas' => 'max:240'
                ];
                $messages = [
                    'type.required' => 'Campo tipo de matéria é obrigatório.',
                    'title.required' => 'Campo título é obrigatório.',
                    'title.max' => 'Campo título não pode ter mais do que 240 caracteres.',
                    'assunto.required' => 'Campo cartola é obrigatório.',
                    'assunto.max' => 'Campo cartola não pode ter mais do que 240 caracteres.',
                    'subtitle.required' => 'Campo linha de apoio é obrigatório.',
                    'subtitle.max' => 'Campo linha de apoio não pode ter mais do que 240 caracteres.',
                    'tags.max' => 'Campo tags não pode ter mais do que 240 caracteres.',
                    'noticias_relacionadas.max' => 'Campo noticias relacionadas não pode ter mais do que 240 caracteres.'
                ];
                if ($request->input('type') != 'normal') {
                    if ($request->input('type') == 'coluna') {
                        $rules['colunista'] = 'required';
                        $messages['colunista.required'] = 'Campo colunista é obrigatório.';
                    }
                    $rules['backgroundbanner'] = 'required';
                    $messages['backgroundbanner.required'] = 'Campo Background/Banner é obrigatório.';
                }
                break;
            case 'edit':
                $rules = [
                    'id' => 'required',
                    'type' => 'required',
                    'assunto' => 'required|max:240',
                    'title' => 'required|max:240',
                    'subtitle' => 'required|max:240',
                    'tags' => 'max:240',
                    'noticias_relacionadas' => 'max:240'
                ];
                $messages = [
                    'id.required' => 'Nenhum registro informado!',
                    'type.required' => 'Campo tipo de matéria é obrigatório.',
                    'title.required' => 'Campo título é obrigatório.',
                    'assunto.required' => 'Campo cartola é obrigatório.',
                    'assunto.max' => 'Campo cartola não pode ter mais do que 240 caracteres.',
                    'title.max' => 'Campo título não pode ter mais do que 240 caracteres.',
                    'subtitle.required' => 'Campo linha de apoio é obrigatório.',
                    'subtitle.max' => 'Campo linha de apoio não pode ter mais do que 240 caracteres.',
                    'tags.max' => 'Campo tags não pode ter mais do que 240 caracteres.',
                    'noticias_relacionadas.max' => 'Campo noticias relacionadas não pode ter mais do que 240 caracteres.'
                ];
                if ($request->input('type') != 'normal') {
                    if ($request->input('type') == 'coluna') {
                        $rules['colunista'] = 'required';
                        $messages['colunista.required'] = 'Campo colunista é obrigatório.';
                    }
                    $rules['backgroundbanner'] = 'required';
                    $messages['backgroundbanner.required'] = 'Campo Background/Banner é obrigatório.';
                }
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


    private function register(Request $request, $type = 'normal')
    {
          $categoria = 2;
          if ($type == 'especial') { $categoria = 1; }
          if ($type == 'normal') { $categoria = 2; }
          if ($type == 'coluna') { $categoria = 3; }
          $materia = new Materia();
          $materia->type = $request->input('type');
          $materia->category = $categoria;
          $materia->ativo = $request->input('ativo') ? 'S' : 'N';
          $materia->assunto = $request->input('assunto');

          $materia->title = $request->input('title');
          $materia->subtitle = $request->input('subtitle');
          $materia->video = $request->input('video');
          $materia->galeria = $request->input('galeria');
          $materia->text1 = $request->input('text1');
          $materia->text2 = $request->input('text2');

          $materia->colunista = $request->input('colunista');
          $materia->jornalista = $request->input('jornalista');
          $materia->tags = $request->input('tags');
          $materia->backgroundbanner = $request->input('backgroundbanner');
          $materia->image = $request->input('image');
          $materia->extra_text = $request->input('extra_text');

          if ( Auth::id() ) {
              $materia->criador = Auth::id();
          }

          if ($request->input('data')) {
              $data = $pieces = explode("/", $request->input('data'));
              $data = $data[2].'-'.$data[1].'-'.$data[0]. ' ' .date("H:i:s");
              $materia->created_at = $data;
          }

          $materia->save();

        return true;
    }



    private function edit(Request $request, $id = null, $type = 'normal')
    {
        $url = 'edit-moticia-normal';
        $return = [];
        $return['title'] = 'Matérias';
        $return['typeMateria'] = $type;

        switch ( $type )
        {
            case 'especial':
                $return['title'] = 'Matérias - Edição da Notícia Especial';
                $url = 'edit-noticia-especial';
                break;
            case 'normal':
                $return['title'] = 'Matérias - Edição da Notícia Normal';
                $url = 'edit-moticia-normal';
                break;
            case 'coluna':
                $return['title'] = 'Matérias - Edição da Coluna';
                $url = 'edit-coluna';
                break;
        }

        $erros = false;
        $firstCall = true;


        if ($request->isMethod('post'))
        {
            $firstCall = false;
            $validator = $this->validator($request, $type);

            if (!$validator->fails())
            {
                switch ( $request->input('action') )
                {
                    // case 'register':
                    //     $this->register($request, $type);
                    //     break;
                    case 'edit':
                        $this->update($request, $type);
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

        $colunista = new Colunista();
        $return['colunistas'] = $colunista->listColunistas();

        $jornalista = new Jornalista();
        $return['jornalistas'] = $jornalista->listJornalistas();

        $materia = new Materia();
        $materia->setType($type);
        $return['materias'] = $materia->listMaterias();

        $tvAdverso = new TvAdverso();
        $tvAdversoAll = $tvAdverso->all()->sortByDesc('order'); //Retorna todos registros
        $return['tvAdverso'] = $tvAdversoAll;

        $listGaleria = new Galeria();
        $return['galerias'] = $listGaleria->all()->sortByDesc('order');

        $register = new Materia();
        $register->setId($id);
        $return['register'] = $register->listMateria();

        return view('adm.materias-edit')->withReturn($return);
    }



    private function update(Request $request, $id = null, $type = 'normal')
    {
          $categoria = 2;
          if ($type == 'especial') { $categoria = 1; }
          if ($type == 'normal') { $categoria = 2; }
          if ($type == 'coluna') { $categoria = 3; }

          $materia = new Materia();
          $edit = $materia->find($request->input('id'));

          $edit->type = $request->input('type');
          $edit->category = $categoria;
          $edit->ativo = $request->input('ativo') ? 'S' : 'N';
          $edit->assunto = $request->input('assunto');
          $edit->title = $request->input('title');
          $edit->subtitle = $request->input('subtitle');
          $edit->text1 = $request->input('text1');
          $edit->text2 = $request->input('text2');
          $edit->video = $request->input('video');
          $edit->galeria = $request->input('galeria');
          $edit->colunista = $request->input('colunista');
          $edit->jornalista = $request->input('jornalista');
          $edit->tags = $request->input('tags');
          $edit->backgroundbanner = $request->input('backgroundbanner');
          $edit->image = $request->input('image');
          $edit->extra_text = $request->input('extra_text');

          if ($request->input('data')) {
              $data = $pieces = explode("/", $request->input('data'));
              $data = $data[2].'-'.$data[1].'-'.$data[0]. ' ' .date("H:i:s");
          }
          else {
              $data = date("Y-m-d H:i:s");
          }
          $edit->created_at = $data;

          $edit->save();

          return true;
    }

    private function validaDelete (Request $request, $validator)
    {
        $erro = false;
        $Mensagem = '';
        $Materias = new Materia();
        $materias = $Materias->find($request->input('id'));

        if (!$materias)
        {
            $erro = true;
            $Mensagem = 'Não foi encontrado nenhuma imagem no Banco de Imagens';
            $this->msgErros = $Mensagem;
        }
        else
        {
            $AdmHome = new AdmHome();
            $admHome = $AdmHome->all()->where('materia', $materias->id);
            $Mensagem = '';

            if( count($admHome) )
            {
                $erro = true;
                $Mensagem .= 'A matéria está sendo utilizada nas seguintes seções da home (ADM):';
                $Mensagem .= '<ul>';

                foreach($admHome as $item) {
                    $renameSection = '';
                    if($item->section == 'banner') { $renameSection = 'Notícias Especiais'; }
                    if($item->section == 'destaque') { $renameSection = 'Notícias Destaques'; }
                    if($item->section == 'colunista') { $renameSection = 'Colunistas'; }
                    $Mensagem .= '<li> Seção: '. $renameSection .'.</li>';
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
        $materia = new Materia();
        $delete = $materia->find($request->input('id'));
        $delete->delete();

        return true;
    }

    public function preVisualizar(Request $request, $type, $id)
    {
        if ($type == 'coluna') {
            return redirect('/colunista/'. $id . '/title/pre-visualizar');
        }
        return redirect('/noticia/'. $id . '/title/pre-visualizar');
    }

}
