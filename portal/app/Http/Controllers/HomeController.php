<?php namespace App\Http\Controllers;

use App\Commands\SendDocuments;
use App\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

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
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $types = $this->list_types();
        $documents = $this->list_documents();
        return view('home', compact('documents', 'types'));
    }

    public function list_types()
    {
        try {
            $documents = Type::select('id', 'nombre_comprobante')
                ->get();
        } catch (\Exception $e) {
            Log::error
            (
                "\nArchivo: " . $e->getFile() .
                "\nLínea  : " . $e->getLine() .
                "\nMensaje: " . $e->getMessage()
            );
            return false;
        }
        return $documents;
    }

    public function list_documents()
    {
        try {
            $user = Auth::user();
            $documents = DB::table('documents')
                ->select('documents.id', 'fecha_creacion', 'nombre_comprobante', 'numero', 'documento_pdf', 'documento_xml')
                ->join('types', 'documents.types_id', '=', 'types.id')
                ->where('documents.users_id', '=', $user->id)
                ->orderBy('fecha_creacion','desc')
                ->get();
            foreach ($documents as $document)
            {
                Queue::push(new SendDocuments($document));
                //$this->dispatch(new SendDocuments($document));
            }
        } catch (\Exception $e) {
            Log::error
            (
                "\nArchivo: " . $e->getFile() .
                "\nLínea  : " . $e->getLine() .
                "\nMensaje: " . $e->getMessage()
            );
            return false;
        }
        return $documents;
    }

    public function list_documents_by_type(Request $request)
    {
        $documents = null;
        try {
            $user = Auth::user();
            $documents = DB::table('documents')
                ->select('documents.id', 'fecha_creacion', 'nombre_comprobante', 'numero')
                ->join('types', 'documents.types_id', '=', 'types.id')
                ->where('types_id', '=', intval($request['types_id']))
                ->where('users_id', '=', $user->id)
                ->get();
        } catch (\Exception $e) {
            Log::error
            (
                "\nArchivo: " . $e->getFile() .
                "\nLínea  : " . $e->getLine() .
                "\nMensaje: " . $e->getMessage()
            );
        }
        if ($request->ajax()) {
            return $documents;
        }
    }

    public function download_xml(Request $request)
    {
        $documento_xml = null;
        try {
            $documento_xml = DB::table('documents')
                ->select('documento_xml')
                ->where('id', '=', intval($request['id']))
                ->get();
        } catch (\Exception $e) {
            Log::error
            (
                "\nArchivo: " . $e->getFile() .
                "\nLínea  : " . $e->getLine() .
                "\nMensaje: " . $e->getMessage()
            );
        }
        if ($request->ajax()) {
            return $documento_xml;
        }
    }

}
