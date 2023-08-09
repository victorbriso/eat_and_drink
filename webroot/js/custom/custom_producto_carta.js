$( document ).ready(function() { 

	$('.asignar_receta_producto').on('click', function(){

		if ($('.asignar_receta_producto').prop('checked') ){

			$('.definir_receta_producto').attr('checked', false);

			$('.agregar-insumos').addClass('fadeOutDown');
			$('.agregar-insumos').removeClass('fadeInUp');
			$('.agregar-insumos').addClass('ocultar');

			$('.select_asignar_receta_producto').removeClass('ocultar');
			$('.select_asignar_receta_producto').removeClass('fadeOutDown');
			$('.select_asignar_receta_producto').addClass('fadeInUp');

		}else{
			$('.select_asignar_receta_producto').addClass('fadeOutDown');
			$('.select_asignar_receta_producto').removeClass('fadeInUp');
			$('#ProductoCartaAsignarReceta').val('');
			$('#ProductoCartaAsignarReceta').selectpicker("refresh");
		}
	});

	$('.definir_receta_producto').on('click', function(){ 

		if ($('.definir_receta_producto').prop('checked') ){

			$('.mensaje_no_receta').addClass('ocultar');

			$('.asignar_receta_producto').attr('checked', false);

			$('.select_asignar_receta_producto').addClass('fadeOutDown');
			$('.select_asignar_receta_producto').removeClass('fadeInUp');
			$('#ProductoCartaAsignarReceta').val('');
			$('#ProductoCartaAsignarReceta').selectpicker("refresh");

			$('.agregar-insumos').removeClass('ocultar');
			$('.agregar-insumos').removeClass('fadeOutDown');
			$('.agregar-insumos').addClass('fadeInUp');

		}else{
			$('.agregar-insumos').addClass('fadeOutDown');
			$('.agregar-insumos').removeClass('fadeInUp');
			$('.agregar-insumos').addClass('ocultar');
			$('.mensaje_no_receta').removeClass('ocultar');
		}
	});


	/** AGREFAR INSUMO A RECETA */

	var insumo_text_seleccionado = '';
	var unidad_text_seleccionado = '';
	var insumo_id_seleccionado = '';
	var insumo_agregado_receta = 0;
	var medioPago_agregado_detalle = 0;
	var cantidadInsumosReceta= 0;

	/**
	 * Se coloca la unidad de salida del insumo, al seleccionarlo
	 */
	$('#productoCartaInsumo').change(function(){
		var id_insumo					= $(this).val();
		var insumo_seleccionado_select 	= $('option:selected', this).text();
		insumo_seleccionado 		=	insumo_seleccionado_select;
		insumo_id_seleccionado		=	id_insumo;

	});

	/**
	 * [description]
	 * Proceso que permite agregar un insumo a la receta.
	 * @param  {[type]} ){			var id_insumo     [description]
	 * @return {[type]}           [description]
	 */
	$('.agregar_insumo_receta').on('click', function(){

		var id_insumo 	= $('#productoCartaInsumo').val();
		var cantidad 	= $('.cantidadInsumoSelect').val();
		var unidad_salida_id 				= $('#ProductoCartaUnidadInsumoSelect option:selected').val();
		var unidad_salida 				= $('#ProductoCartaUnidadInsumoSelect option:selected').text();

		$('.insumo_select_'+ insumo_id_seleccionado).hide();
		insumo_agregado_receta ++;

		if ( id_insumo != '' && id_insumo != null ){

			if ( cantidad < 0 ){
				$('.cantidadInsumoSelect').css('border', '1px dashed red');
				return;
			}
			
			var insumo = '<tr class="insumo_agregado item_insumo_' + insumo_agregado_receta + '">' +
							'<td>' + insumo_seleccionado + '<input type="hidden" name="data[DetalleReceta]['+ insumo_agregado_receta +'][insumo_id]" class="form-control" value="' + insumo_id_seleccionado +'" id="ProductoReceta'+ insumo_agregado_receta +'InsumoId"></td> ' +
							'<td>( ' + cantidad +' ) '+ unidad_salida +' <input type="hidden" name="data[DetalleReceta]['+ insumo_agregado_receta +'][cantidad]" class="form-control" value="' + cantidad + '" id="ProductoReceta'+ insumo_agregado_receta +'Cantidad"></td>' +
								'<input type="hidden" name="data[DetalleReceta]['+ insumo_agregado_receta +'][unidad_medida_id]" class="form-control" value="' + unidad_salida_id + '" id="ProductoReceta'+ insumo_agregado_receta +'unidad_medida_id"></td>'+
							'<td><span class="icon eliminar_item_insumo" item_insumo="'+ insumo_agregado_receta +'" insumo_id_item="'+ insumo_id_seleccionado +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
						'</tr>';

			$('.insumo-agregado').append(insumo);
			$('.cantidadInsumoSelect').css('border', '1px solid #D5D5D5');
			$('.cantidadInsumoSelect').val('');
			$("#productoCartaInsumo").val('default');
			$("#productoCartaInsumo").selectpicker("refresh");

			insumo_seleccionado 	=	'';
			insumo_id_seleccionado	=	'';
			cantidadInsumosReceta ++;
			if(cantidadInsumosReceta>0){
				document.getElementById('bttnEnviaFormReceta').style.display = 'inline';
			}else{
				document.getElementById('bttnEnviaFormReceta').style.display = 'none';
			}
			
		}
	});

	$('.agregar_producto_combo').on('click', function(){

		var id_insumo 	= $('#productoCartaInsumo').val();
		var cantidad 	= $('.cantidadInsumoSelect').val();
		var unidad_salida_id 				= $('#ProductoCartaUnidadInsumoSelect option:selected').val();
		var unidad_salida 				= $('#ProductoCartaUnidadInsumoSelect option:selected').text();
		var producto_id 				= $('#productoCartaInsumo option:selected').val();

		$('.insumo_select_'+ insumo_id_seleccionado).hide();
		insumo_agregado_receta ++;

		if ( id_insumo != '' && id_insumo != null ){

			if ( cantidad < 0 ){
				$('.cantidadInsumoSelect').css('border', '1px dashed red');
				return;
			}
			
			var insumo = '<tr class="insumo_agregado item_insumo_' + insumo_agregado_receta + '">' +
							'<td>' + insumo_seleccionado + '<input type="hidden" name="data[detalle]['+ insumo_agregado_receta +'][producto]" class="form-control" value="' + insumo_seleccionado +'" id="ProductoReceta'+ insumo_agregado_receta +'InsumoId"></td> ' +
							'<td>( ' + cantidad +' ) '+ unidad_salida +' <input type="hidden" name="data[detalle]['+ insumo_agregado_receta +'][cantidad]" class="form-control" value="' + cantidad + '" id="ProductoReceta'+ insumo_agregado_receta +'Cantidad"></td>' +
								'<input type="hidden" name="data[detalle]['+ insumo_agregado_receta +'][cantidad]" class="form-control" value="' + cantidad + '" id="ProductoReceta'+ insumo_agregado_receta +'unidad_medida_id"></td>'+
							'<td><span class="icon eliminar_item_insumo" item_insumo="'+ insumo_agregado_receta +'" insumo_id_item="'+ insumo_id_seleccionado +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
							'<input type="hidden" name="data[detalle]['+ insumo_agregado_receta +'][idProducto]" class="form-control" value="' + producto_id + '" id="ProductoReceta'+ insumo_agregado_receta +'unidad_medida_id"></td>'+
						'</tr> ';


			$('.insumo-agregado').append(insumo);
			$('.cantidadInsumoSelect').css('border', '1px solid #D5D5D5');
			$('.cantidadInsumoSelect').val('1');
			$("#productoCartaInsumo").val('default');
			$("#productoCartaInsumo").selectpicker("refresh");

			insumo_seleccionado 	=	'';
			insumo_id_seleccionado	=	'';
		}
	});
	
	$('.insumo-agregado').on('click', '.eliminar_item_insumo', function(event){
		event.preventDefault();
		var item_eliminar		=	$(this).attr('item_insumo');
		var id_item_eliminar	=	$(this).attr('insumo_id_item');

		$('.item_insumo_'+ item_eliminar).remove();
		$('.insumo_select_'+ id_item_eliminar).show();
		cantidadInsumosReceta --;
		if(cantidadInsumosReceta>0){
			document.getElementById('bttnEnviaFormReceta').style.display = 'inline';
		}else{
			document.getElementById('bttnEnviaFormReceta').style.display = 'none';
		}

	});


	/**
	 * Función que permite obtener el envío del información del formulario de insumos, como formulario 
	 * extra en otros modulos
	 * 
	 * @param  {[type]} event )             {	  event.preventDefault();	  	} [description]
	 * @return {[type]}       [description]
	 */
	$( "body" ).on('click', '.form-ajax-insumo', function( event ) {

	  event.preventDefault();

	  $('.btn-ajax-insumo').hide();
	  $('.gif-ajax-insumo').show();

	  var mostrar_alerta 	= false;
	  var enviar_form 		= true;
	  var campos_vacios 	= false;

	  var id_formulario 	=	$(this).attr('idform'); // ID formulario (Variable para el submit)
	  var id_editForm		=	$(this).attr('editForm'); // ID del registro (Cuando se edita el campo)
	  var campoForm			=	$(this).attr('campoForm'); // ID del registro (Cuando se edita el campo)
	  $( '.verifica_campo' ).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
	  $( '.div_campo_js').children("p").remove(); // Se quitan los mensajes de campo requerido

	  /**
	   * Verificación de lo campos obligatorios
	   */
	  $('input.verifica_campo_'+campoForm).each(function(){
	  	if ( $(this).val() == '' || $(this).val() == null ){
	  		$(this).css('border', '1px dashed #b64645');
	  		$('.campo_requerido_' + $(this).attr('id')).append('<p class="msn_campo_requerido">' + $(this).attr('mensaje_requerido') + '</p>');
	  		campos_vacios 		= true;
	  	}
	  });

	  if ( $('#addRecetaCantidadInsumo').val() == null || $('#addRecetaCantidadInsumo').val() == ''){
	  	    $('#addRecetaCantidadInsumo').css('border', '1px dashed #b64645');
	  		$('.campo_requerido_addRecetaCantidadInsumo').append('<p class="msn_campo_requerido">' + $('#addRecetaCantidadInsumo').attr('mensaje_requerido') + '</p>');
	  		campos_vacios 		= true;
	  }

	  setTimeout(function(){

	  	if ( campos_vacios == false ){

	  		/**
	  		 * Verificacion de los campos, con la base de datos
	  		 */
	  		$( ".verifica_campo_"+campoForm ).each(function(index) {

			  	var campo 			=	$(this).attr('campo'); // Nombre del campo a validar
			  	var valor_campo 	=	$(this).val(); // Valor de campo a validar
			  	var controlador 	=	$(this).attr('controlador'); // Instancia a consultar
			  	var id_campo		=	$(this).attr('id');

			  	$.ajax({
					type		: 'POST',
					url			: webroot + 'Pages/ajax_validarCampo',
					data			: {
						campo			: campo,
						valor_campo		: valor_campo,
						controlador		: controlador,
						id_editForm		: id_editForm
					},
					success		: function(msg){
						if ( msg == 1 ){
							if ( mostrar_alerta == false ){
								 mostrar_alerta = true;
								$('#alerta_datos_registrados').addClass('open');
			  					$('#' + id_campo).css('border', '1px dashed #b64645');
			  					enviar_form = false;
			  					$('.btn-ajax-insumo').show();
	  							$('.gif-ajax-insumo').hide();
							}
						}
					}

				  });

			 	});

	  		 setTimeout(function(){
	  		 	if ( enviar_form ){

	  		 		var nuevoInsumoNombre = $('#InsumoNombre').val();

	  		 		$.ajax({
						type		: 'POST',
						url			: webroot + 'Insumos/ajax_registrarInsumo',
						data			: {
							nombre_insumo			: nuevoInsumoNombre,
						},
						success		: function(msg){
							if ( msg != '' ){
								var cantidad_nuevo_insumo_receta 					= $('#addRecetaCantidadInsumo').val();
								var unidad_salida_id_nuevo_insumo_receta 			= $('#addRecetaInsumoSelect option:selected').val();
								var unidad_salida_nuevo_insumo_receta 				= $('#addRecetaInsumoSelect option:selected').text();
								insumo_agregado_receta ++;

				  		 		var insumo = '<tr class="insumo_agregado item_insumo_' + insumo_agregado_receta + '">' +
										'<td>' + nuevoInsumoNombre + '<input type="hidden" name="data[DetalleReceta]['+ insumo_agregado_receta +'][insumo_id]" class="form-control" value="' + msg +'" id="ProductoReceta'+ insumo_agregado_receta +'InsumoId"></td> ' +
										'<td>( ' + cantidad_nuevo_insumo_receta +' ) '+ unidad_salida_nuevo_insumo_receta +' <input type="hidden" name="data[DetalleReceta]['+ insumo_agregado_receta +'][cantidad]" class="form-control" value="' + cantidad_nuevo_insumo_receta + '" id="ProductoReceta'+ insumo_agregado_receta +'Cantidad"></td>' +
											'<input type="hidden" name="data[DetalleReceta]['+ insumo_agregado_receta +'][unidad_medida_id]" class="form-control" value="' + unidad_salida_id_nuevo_insumo_receta + '" id="ProductoReceta'+ insumo_agregado_receta +'unidad_medida_id"></td>'+
										'<td><span class="icon eliminar_item_insumo" item_insumo="'+ insumo_agregado_receta +'" insumo_id_item="'+ msg +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
									'</tr>';

								$('.insumo-agregado').append(insumo);

								$('#modalAddInsumo').hide();
								$('#modalAddInsumo').iziModal('destroy');
								$('.btn-ajax-insumo').show();
	  							$('.gif-ajax-insumo').hide();	
							}
						}

					});

					
	  		 	}
	  		 }, 1000);
	  	}else{
	  		$('.btn-ajax-insumo').show();
	  		$('.gif-ajax-insumo').hide();
	  	}
	  }, 200);

	});

});

/**
 * [ValidarImagen]
 * Funcion que perite obtener la información de la imagen del formulario
 * @param {[type]} obj [description]
 */
function ValidarImagen(obj){
	uploadFile = obj.files[0];
}

