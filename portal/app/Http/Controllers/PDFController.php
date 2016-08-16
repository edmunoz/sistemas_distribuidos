<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PDFController extends Controller {

    /**
     * @return mixed
     */
    public function descargar_pdf(){
      $documento_pdf = DB::table('documents')
          ->select('documento_xml')
          ->where('id', '=', 1)
          ->get();
        $filename = 'nombre';
        $headers = array('Content-Type: text/xml',
            'Content-Disposition:attachment; filename="cv.xml"',);


        //return response()->make(base64_decode($documento_pdf), 'nombre.pdf', $headers);
        //return response()->make($documento_pdf, 200)->header('Content-Type', 'application/xml');
        return response()->download($documento_pdf, 'output.xml', ['Content-Type: application/xml']);

  }

}
