<?= $this->Html->scriptBlock(sprintf("var carta                 = %s;", json_encode($carta))); ?>
<?= $this->Html->scriptBlock(sprintf("var localId               = %s;", json_encode($localId))); ?>
<?= $this->Html->scriptBlock(sprintf("var version               = %s;", json_encode($version))); ?>
<?= $this->Html->scriptBlock(sprintf("var mesa               	= %s;", json_encode($mesa))); ?>
<?= $this->Html->scriptBlock(sprintf("var token                 = %s;", json_encode($token))); ?>
<div class="col-12" id="vistaCategorias">
	<div class="row">
		<? foreach ($carta as $key => $value) {?>
			<div class="col-12">
				<div class="card" style="width: 100%;">
					<? $img=(file_exists(ROOT.'/webroot/img/img_cat/'.$localId.'/'.$key.'.'.$value['extension']))?'img_cat/'.$localId.'/'.$key.'.'.$value['extension']:'404-error.jpg'; ?>
                    <?= $this->Html->image($img, ['style'=>['width:100%;','height:150px;'], 'class'=>'card-img-top', 'alt'=>$value['nombre']]) ?>
					<div class="card-body">
						<h5 class="card-title" style="text-align: center;"><?= $value['nombre'] ?></h5>
					</div>
					<ul class="list-group list-group-flush">
					</ul>
					<div class="card-body">
						<button class="btn btn-info btn-block verCategoria" catid="<?=$key?>">Ver</button>
					</div>
				</div>
				<hr>
			</div>
		<?}?>
	</div>
</div>
<div class="col-12 mx-auto center" id="carga" style="display: none; margin-top: 25%"><?= $this->Html->image('cargando.gif', ['class'=>'rounded mx-auto d-block']) ?></div>
<div class="col-12" id="vistaProductos" style="display: none;">
	<button class="btn btn-success btn-block antariorGeneral">Atrás</button>
	<hr>
	<div class="row" id="vistaProductosRow"></div>
</div>
<div class="col-12" id="vistaDetalle" style="display: none;">
	<button class="btn btn-success btn-block volver" antariorCategoria="0">Atrás</button>
	<hr>
	<div class="row" id="vistaDetalleRow"></div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalMensaje">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			</div>
			<div class="modal-body">
				<p id="mensajeRespuestaModal"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var catId=0;
		$('#vistaCategorias').on('click', '.verCategoria', function(){
			$('#vistaProductosRow').html('');
			catId=parseInt($(this).attr('catid'));
			$('#vistaCategorias').hide();
			$('#carga').show();
			$.each(carta[catId]['productos'], function( index, value ){
				if(value['extension']!=null){var img = '/img/img_carta/'+localId+'/'+value['id']+'.'+value['extension'];}else{var img = '/img/404-error.jpg'; }
				var divProducto = '<div class="card" style="width: 100%;">'+
									'<img class="card-img-top" src="'+img+'" alt="'+value['nombre']+'" style="width:100%; height:150px;">'+
									'<div class="card-body">'+
										'<h5 class="card-title">'+value['nombre']+'</h5>'+
									'</div>'+
									'<ul class="list-group list-group-flush">'+
										'<li class="list-group-item">$'+new Intl.NumberFormat("de-DE").format(value['precio_actual'])+'</li>'+
									'</ul>'+
									'<div class="card-body">'+
										'<button class="btn btn-info btn-block verProducto" prodid="'+index+'">Ver</button>'+
									'</div>'+
								'</div>';
                $('#vistaProductosRow').append(divProducto);
                $('#vistaProductosRow').append('<hr>');
            });			
            $('#carga').hide();
            $('#vistaProductos').show();
		});
		$('#vistaProductos').on('click', '.verProducto', function(){
			$('#vistaDetalleRow').html('');
			var prodId=parseInt($(this).attr('prodid'));
			$('#vistaProductos').hide();
			$('#carga').show();
			var value=carta[catId]['productos'][prodId];
			if(value['desc_es']==null||value['desc_es']==''){
				var descripcion = 'Sin descripción';
			}else{
				var descripcion = value['desc_es'];
			}
			if(value['extension']!=''){var img = '/img/img_carta/'+localId+'/'+value['id']+'.'+value['extension'];}else{var img = '/img/404-error.jpg'; }
			var divProducto = '<div class="card" style="width: 100%;">'+
								'<img class="card-img-top" src="'+img+'" alt="'+value['nombre']+'" style="width:100%; height:150px;">'+
								'<div class="card-body">'+
									'<h5 class="card-title">'+value['nombre']+'</h5>'+
									'<p class="card-text">'+descripcion+'</p>'+
								'</div>'+
								'<ul class="list-group list-group-flush">'+
									'<li class="list-group-item">$'+new Intl.NumberFormat("de-DE").format(value['precio_actual'])+'</li>'+
								'</ul>'
							'</div>';
			$('#vistaDetalleRow').html(divProducto);
            $('#carga').hide();
            $('#vistaDetalle').show();
		});
		$('#vistaProductos').on('click', '.antariorGeneral', function(){
			$('#vistaProductos').hide();
			$('#vistaCategorias').show();
		});
		$('#vistaDetalle').on('click', '.volver', function(){
			$('#vistaDetalle').hide();
			$('#vistaProductos').show();
		});
		$('.llamaGarzon').on('click', function(){
			$('#mensajeRespuestaModal').html('');
			var formRetiro = {
				'mesa':mesa,
				'tipo':1,
	            '_Token[fields]':token
	        };
	        $.ajax({
	            type: 'POST',
	            url: '/Carta/notificacionCarta',
	            headers: { 'X-XSRF-TOKEN' : token },
	            beforeSend: function (xhr) {
	                xhr.setRequestHeader('X-CSRF-Token', token);
	            },
	            data: formRetiro,
	            success: function (result) {
	                if(result==1){
	                	var respuesta='Tu solicitud fue enviada con exito.';
	                }else{
	                	var respuesta='Ocurrio un error al enviar tu solicitud.';
	                }
	                $('#mensajeRespuestaModal').html(respuesta);
	                $('#modalMensaje').modal();
	            },
	            error: function (result){
	                alert('error al comunicarse con el servidor');
	            }
	        });
		});
		$('.pideCuenta').on('click', function(){
			$('#mensajeRespuestaModal').html('');
			var formRetiro = {
				'mesa':mesa,
				'tipo':2,
	            '_Token[fields]':token
	        };
	        $.ajax({
	            type: 'POST',
	            url: '/Carta/notificacionCarta',
	            headers: { 'X-XSRF-TOKEN' : token },
	            beforeSend: function (xhr) {
	                xhr.setRequestHeader('X-CSRF-Token', token);
	            },
	            data: formRetiro,
	            success: function (result) {
	                if(result==1){
	                	var respuesta='Tu solicitud fue enviada con exito.';
	                }else{
	                	var respuesta='Ocurrio un error al enviar tu solicitud.';
	                }
	                $('#mensajeRespuestaModal').html(respuesta);
	                $('#modalMensaje').modal();
	            },
	            error: function (result){
	                alert('error al comunicarse con el servidor');
	            }
	        });
		});
	});
	window.onload = inicial;
	function inicial(){
		var minutos = 60000;
		var tiempoConsulta=5*minutos;
		setTimeout(function(){ consulta(); }, tiempoConsulta);
	}
	function consulta(){
		var formRetiro = {
			'local':localId,
			'version':version,
            '_Token[fields]':token
        };
        $.ajax({
            type: 'POST',
            url: '/Carta/versionCarta',
            headers: { 'X-XSRF-TOKEN' : token },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', token);
            },
            data: formRetiro,
            success: function (result) {
                if(result==1){
                	location.reload();
                }
            },
            error: function (result){
                alert('error al comunicarse con el servidor');
            }
        });
        inicial();
	}
</script>