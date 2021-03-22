<?php
namespace App\Http\Controllers\Adm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Texto;

class PaginasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    public function adverso(Request $request)
    {
        $return = ['title' => 'Texto Adverso'];
        $pagina = 'texto-adverso';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-adverso')->withReturn($return);
    }

    public function noticias(Request $request)
    {
        $return = ['title' => 'Texto Notícias'];
        $pagina = 'texto-noticias';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-noticias')->withReturn($return);
    }

    public function galeria(Request $request)
    {
        $return = ['title' => 'Texto Galeria'];
        $pagina = 'texto-galeria';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-galeria')->withReturn($return);
    }

    public function multimidia(Request $request)
    {
        $return = ['title' => 'Texto Multimídia'];
        $pagina = 'texto-multimidia';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-multimidia')->withReturn($return);
    }


    public function adufrgsNoAr(Request $request)
    {
        $return = ['title' => 'Texto Adufrgs No Ar'];
        $pagina = 'texto-adufrgs-no-ar';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-adufrgs-no-ar')->withReturn($return);
    }

    public function agendas(Request $request)
    {
        $return = ['title' => 'Texto Agendas'];
        $pagina = 'texto-agendas';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-agendas')->withReturn($return);
    }

    public function colunistas(Request $request)
    {
        $return = ['title' => 'Texto Colunistas'];
        $pagina = 'texto-colunistas';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-colunistas')->withReturn($return);
    }

    public function imprensa(Request $request)
    {
        $return = ['title' => 'Texto Imprensa'];
        $pagina = 'texto-imprensa';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-imprensa')->withReturn($return);
    }

    public function contato(Request $request)
    {
        $return = ['title' => 'Texto Contato'];
        $pagina = 'texto-contato';
        $select = new Texto();
        $selectLista = $select->all()->where('pagina', $pagina);
        if ( !$selectLista->count() )
        {
            $insert = new Texto();
            $insert->pagina = $pagina;
            $insert->save();
        }
        if ($request->isMethod('post'))
        {
            $update = new Texto();
            $update = $update->where('pagina', $pagina)->first();
            $update->text = $request->input('text');
            $update->save();
        }

        $return['register'] = $select->all()->where('pagina', $pagina)->first();

        return view('adm.texto-contato')->withReturn($return);
    }

}
