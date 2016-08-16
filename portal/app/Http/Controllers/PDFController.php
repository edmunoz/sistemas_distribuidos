<?php namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PDFController extends Controller {

    /**
     * @return mixed
     */
    public function descargar_xml(Request $request){
        $documento_xml = Document::select('documento_xml')
            ->where('id', '=', 17)
            ->first()
            ->toArray();

        $file = public_path();
        if ($request->ajax())
        {
            return array_flatten($documento_xml)[0];
        }
  }

    public function descargar_pdf(Request $request)
    {
        $documento_pdf = null;
        try {
            $documento_pdf = Document::select('documento_pdf')
                ->where('id', '=', 17)
                ->first()
                ->toArray();
        } catch (\Exception $e) {
            Log::error
            (
                "\nArchivo: " . $e->getFile() .
                "\nLínea  : " . $e->getLine() .
                "\nMensaje: " . $e->getMessage()
            );
        }
        if ($request->ajax()) {
            return array_flatten($documento_pdf)[0];
        }
    }

}
