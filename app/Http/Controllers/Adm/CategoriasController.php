<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request, $id = null)
    {
        dd('Pagina Em Branco');
    }


    public function galeria(Request $request, $id = null)
    {
        $return = ['title' => 'Categorias-Banco de Imagens'];

        if ($request->isMethod('post'))
        {
            if ($request->input('action') == 'register') {
                if($this->register($request)) {}
            }

            if ($request->input('action') == 'edit') {
                if($this->update($request)) {}
            }

            if ($request->input('action') == 'delete') {
                if($this->delete($request)) {}
            }
            return redirect('/adm/categorias/galeria'); //Adicionado o redirect para limpar o post
        }

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'galeria'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;
        return view('adm.categorias-galeria')->withReturn($return);
    }

    public function materia(Request $request, $id = null)
    {
        $return = ['title' => 'Categorias-Matéria'];

        if ($request->isMethod('post'))
        {
            if ($request->input('action') == 'register') {
                if($this->register($request)) {}
            }

            if ($request->input('action') == 'edit') {
                if($this->update($request)) {}
            }

            if ($request->input('action') == 'delete') {
                if($this->delete($request)) {}
            }
            return redirect('/adm/categorias/materia'); //Adicionado o redirect para limpar o post
        }

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'materia'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;
        return view('adm.categorias-materia')->withReturn($return);
    }

    public function colunista(Request $request, $id = null)
    {
        $return = ['title' => 'Categorias-Colunista'];

        if ($request->isMethod('post'))
        {
            if ($request->input('action') == 'register') {
                if($this->register($request)) {}
            }

            if ($request->input('action') == 'edit') {
                if($this->update($request)) {}
            }

            if ($request->input('action') == 'delete') {
                if($this->delete($request)) {}
            }
            return redirect('/adm/categorias/colunista'); //Adicionado o redirect para limpar o post
        }

        $categoria = new Categoria();
        $categoriaAll = $categoria->all()->where('categoria', 'colunista'); //Retorna todos registros
        $return['categorias'] = $categoriaAll;
        return view('adm.categorias-colunista')->withReturn($return);
    }

    private function register(Request $request)
    {
      $categoria = new Categoria();
      $nomeInput = $request->input('nome');
      $categoriaInput = $request->input('categoria');

      $categoria->nome = $nomeInput;
      $categoria->categoria = $categoriaInput;
      $categoria->save();

      return true;
    }

    private function update(Request $request) {
      $categoria = new Categoria();
      $idCategoria = $request->input('id');
      $nome = $request->input('nomeEdit');
      if ($nome != '')
      {
          $categoriaEdit = $categoria->find($idCategoria);
          $categoriaEdit->nome = $nome;
          $categoriaEdit->save();
      }
        return true;
    }

    private function delete(Request $request) {
      $categoria = new Categoria();
      $idCategoria = $request->input('id');
      if ($idCategoria != '')
      {
          $categoriaDelete = $categoria->find($idCategoria);
          $categoriaDelete->delete();
      }
        return true;
    }
}
