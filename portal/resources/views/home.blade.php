@extends('app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Consulta documentos electronico
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/llena_tabla') }}"
                              id="form-filter">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Tipo Documento</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="types">
                                        <option value="0">TODOS</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->nombre_comprobante }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <table id="documentTable" data-toggle="table" data-search="true" data-show-export="true"
                               data-mobile-responsive="true" data-pagination="true" data-page-size="10"
                               data-page-list="[10,25]" data-pagination-first-text="Primero"
                               data-pagination-pre-text="Anterior"
                               data-pagination-next-text="Siguiente" data-pagination-last-text="Último"
                               data-row-style="rowStyle" data-height="400">
                            <thead>
                            <tr>
                                <th data-field="id">Id</th>
                                <th data-field="fecha" data-sortable="true">Fecha de Emisión</th>
                                <th data-field="documento" data-sortable="true">Tipo de Documento</th>
                                <th data-field="numero">Número</th>
                                <th data-field="d_pdf" >Documento pdf</th>
                                <th data-field="d_xml">Documento xml</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($documents as $document)
                                <tr>
                                    <td>{{$document->id}}</td>
                                    <td>{{$document->fecha_creacion}}</td>
                                    <td>{{$document->nombre_comprobante }}</td>
                                    <td>{{$document->numero}}</td>
                                    <td>
                                        <a value='{{$document->id}}' class='btnPdf btn btn-primary'>PDF</a>
                                    </td>
                                    <td>
                                        <a value='{{$document->id}}' class="btnXml btn btn-success">XML</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        function download(data, strFileName, strMimeType) {

            var self = window, // this script is only for browsers anyway...
                    u = "application/octet-stream", // this default mime also triggers iframe downloads
                    m = strMimeType || u,
                    x = data,
                    D = document,
                    a = D.createElement("a"),
                    z = function(a){return String(a);},


                    B = self.Blob || self.MozBlob || self.WebKitBlob || z,
                    BB = self.MSBlobBuilder || self.WebKitBlobBuilder || self.BlobBuilder,
                    fn = strFileName || "download",
                    blob,
                    b,
                    ua,
                    fr;

            //if(typeof B.bind === 'function' ){ B=B.bind(self); }

            if(String(this)==="true"){ //reverse arguments, allowing download.bind(true, "text/xml", "export.xml") to act as a callback
                x=[x, m];
                m=x[0];
                x=x[1];
            }



            //go ahead and download dataURLs right away
            if(String(x).match(/^data\:[\w+\-]+\/[\w+\-]+[,;]/)){
                return navigator.msSaveBlob ?  // IE10 can't do a[download], only Blobs:
                        navigator.msSaveBlob(d2b(x), fn) :
                        saver(x) ; // everyone else can save dataURLs un-processed
            }//end if dataURL passed?

            try{

                blob = x instanceof B ?
                        x :
                        new B([x], {type: m}) ;
            }catch(y){
                if(BB){
                    b = new BB();
                    b.append([x]);
                    blob = b.getBlob(m); // the blob
                }

            }



            function d2b(u) {
                var p= u.split(/[:;,]/),
                        t= p[1],
                        dec= p[2] == "base64" ? atob : decodeURIComponent,
                        bin= dec(p.pop()),
                        mx= bin.length,
                        i= 0,
                        uia= new Uint8Array(mx);

                for(i;i<mx;++i) uia[i]= bin.charCodeAt(i);

                return new B([uia], {type: t});
            }

            function saver(url, winMode){


                if ('download' in a) { //html5 A[download]
                    a.href = url;
                    a.setAttribute("download", fn);
                    a.innerHTML = "downloading...";
                    D.body.appendChild(a);
                    setTimeout(function() {
                        a.click();
                        D.body.removeChild(a);
                        if(winMode===true){setTimeout(function(){ self.URL.revokeObjectURL(a.href);}, 250 );}
                    }, 66);
                    return true;
                }

                //do iframe dataURL download (old ch+FF):
                var f = D.createElement("iframe");
                D.body.appendChild(f);
                if(!winMode){ // force a mime that will download:
                    url="data:"+url.replace(/^data:([\w\/\-\+]+)/, u);
                }


                f.src = url;
                setTimeout(function(){ D.body.removeChild(f); }, 333);

            }//end saver


            if (navigator.msSaveBlob) { // IE10+ : (has Blob, but not a[download] or URL)
                return navigator.msSaveBlob(blob, fn);
            }

            if(self.URL){ // simple fast and modern way using Blob and URL:
                saver(self.URL.createObjectURL(blob), true);
            }else{
                // handle non-Blob()+non-URL browsers:
                if(typeof blob === "string" || blob.constructor===z ){
                    try{
                        return saver( "data:" +  m   + ";base64,"  +  self.btoa(blob)  );
                    }catch(y){
                        return saver( "data:" +  m   + "," + encodeURIComponent(blob)  );
                    }
                }

                // Blob but not URL:
                fr=new FileReader();
                fr.onload=function(e){
                    saver(this.result);
                };
                fr.readAsDataURL(blob);
            }
            return true;
        } /* end download() */

        $tabla = $('#documentTable');

        $(document).ready(function () {

            $('#documentTable').bootstrapTable('hideColumn', 'id');

            $("select[name='types']").change(function () {
                var token = $('input[name=_token]').val();
                var types_id = $(this).val();
                $.ajax({
                    url: 'list_documents_by_type',
                    type: 'POST',
                    data: {'_token': token, 'types_id': types_id},
                    success: function (data) {
                        $('#documentTable').bootstrapTable('removeAll');
                        for (var i = 0; i < data.length; i++) {
                            $('#documentTable').bootstrapTable('append', {
                                id: data[i].id,
                                fecha: data[i].fecha_creacion,
                                documento: data[i].nombre_comprobante,
                                numero: data[i].numero,
                                d_pdf: "<a value='" + data[i].id + "' class='btnPdf btn btn-primary'>PDF</a>",
                                d_xml: "<a value='" + data[i].id + "' class='btnXml btn btn-success'>XML</a>"
                            });
                        }
                    },
                    error: function () {
                        alert('error');
                    }
                });
            });

            $('.btnPdf').click(function () {
                var token = $('input[name=_token]').val();
                $.ajax({
                    url: 'descargar_pdf',
                    type: 'POST',
                    data: {'_token': token},
                    success: function (data) {
                        download(new Blob([data]), "file.pdf", "application/pdf")

                        //download("{{ asset('/files/Factura-002-002-001550122.pdf') }}", "file.pdf", "application/pdf")
                    },
                    error: function () {
                        alert('error');
                    }
                });
            });

            $('.btnXml').click(function (e) {
                var token = $('input[name=_token]').val();
                $.ajax({
                    url: 'descargar_xml',
                    type: 'POST',
                    data: {'_token': token},
                    success: function (data) {
                        download(data, "file.xml", "text/xml")
                    },
                    error: function () {
                        alert('error');
                    }
                });
            });







        });








    </script>

@endsection
