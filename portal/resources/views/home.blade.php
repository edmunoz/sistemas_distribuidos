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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/llena_tabla') }}" id="form-filter">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo Documento</label>
							<div class="col-md-6">
								<select class="form-control" name="area">
									<option value="0">TODOS</option>
									@foreach ($types as $type)
										<option value="{{ $type->id }}">{{ $type->nombre_comprobante }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</form>
					<table id="documentTable" data-toggle="table" data-search="true" data-show-export="true"
							   data-mobile-responsive="true" data-height="400" data-pagination="true" data-page-size="10"
							   data-page-list="[10,25]" data-pagination-first-text="Primero" data-pagination-pre-text="Anterior"
							   data-pagination-next-text="Siguiente" data-pagination-last-text="Último" data-row-style="rowStyle">
							<thead>
								<tr>
									<th data-field="fecha" data-sortable="true">Fecha de Emisión</th>
									<th data-field="documento" data-sortable="true">Tipo de Documento</th>
									<th data-field="numero">Número</th>
									<th data-field="d_pdf">Documento pdf</th>
									<th data-field="d_xml">Documento xml</th>
								</tr>
							</thead>
							<tbody>
								@foreach($documents as $document)
									<tr>
									 <td>{{$document->fecha_creacion}}</td>
										<td>{{$document->nombre_comprobante }}</td>
										<td>{{$document->numero}}</td>
										<td><button class="btn btn-primary">PDF</button></td>
										<td><button class="btn btn-success">XML</button></td>
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
		$(document).ready(function(){
			$("select[name='area']").change(function(){
				var token = $('input[name=_token]').val();
				var types_id = $(this).val();
				$.ajax({
					url: 'list_documents_by_type',
					type: 'POST',
					data: {'_token': token, 'types_id': types_id},
					success: function(data){
						$('#documentTable').bootstrapTable('removeAll');
						for (var i = 0; i < data.length; i++)
						{
							$('#documentTable').bootstrapTable('append', {
								fecha: data[i].fecha_creacion,
								documento: data[i].nombre_comprobante,
								numero: data[i].numero
							});
						}
					},
					error: function(){
						alert('error');
					}
				});
			});

			function fill_table(datos){
				$('#documentTable').bootstrapTable('removeAll');
				for (var i = 0; i < datos.length; i++){
					$('#documentTable').bootstrapTable('append', {
						fecha: datos[i].fecha_creacion,
						documento: datos[i].nombre_comprobante,
						numero: datos[i].numero
					});
				}
			}

		});


	</script>

@endsection
