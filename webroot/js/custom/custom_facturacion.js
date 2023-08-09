var facturacionOtroDocumento 	=	''; // Variable que contendra la realcion de otro documento (guia despacho, nota credito, nota debito)
var total_descuento_productos	= 	0;
var total_descuento_general		= 	0;
var folio_obligatorio			=	false;
var producto_asignado			=	false;
var iteral_producto_elemento 	=	0;
var tipo_factura_documento		=	1; // 0: guia despacho, 1: comanda, 2: producto
var html_guias_despacho_select	=	'<div class="table-responsive">'+
									    '<table class="table table-striped">'+
									        '<thead>'+
									            '<tr>'+
									                '<th></th>'+
									               	'<th>Emisi&oacute;n</th>'+
								                    '<th>Folio</th>'+
								                    '<th>Monto</th>'+
									            '</tr>'+
									       '</thead>'+
									        '<tbody class="lista_guias_despacho_cliente">'+
									        '</tbody>'+
									   '</table>'+
									'</div>';

$( document ).ready(function() { 

	if ( $('.modulo-emision-documentos').length ){

		$("#fecha-emision").datepicker({minDate: "-1D"});

		/** GENERRALES */

		$('#FacturacionResumenesElemento').on('change', function(){
			var tipo_elemento = $(this).val(); // 0: Guia - 1: Comanda - 2: Producto

			if ($('.emision-guia-despacho').length){
				// Se cambia el valor del tipo de elemento, cuando se genera la guia de despacho, ya que 
				// solo es por comanda y producto
				tipo_elemento = ( tipo_elemento == 0 ? 1 : 2);
			}
			tipo_factura_documento	=	tipo_elemento;

			$('.select_elememto_opcion').addClass('ocultar');

			if(tipo_elemento == 0){
				if ( $('#cliente').val() == 0 || $('#cliente').val() == null || $('#cliente').val() == ''){
			  		$('.mensaje_no_cliente_select').removeClass('ocultar');
			  	}else{
			  		$('.mensaje_no_cliente_select').addClass('ocultar');
			  		var cliente_id = $('#cliente').val();
			  		obtenerGuiasDespacho(cliente_id);
			  	}
			}
			else if (tipo_elemento == 1){
				$('.lista_comandas_elemento').removeClass('ocultar');
			}
			else if (tipo_elemento == 2){
				
				$('.lista_productos_elemento').removeClass('ocultar');
				var tabla_productos = '<p>Los valores de los productos son netos</p>'+
											'<div class="table-responsive">'+
											    '<table class="table table-striped">'+
											        '<thead>'+
											            '<tr>'+
											                '<th></th>'+
											                '<th class="center" width="25%">Producto</th>'+
											                '<th class="center" width="5%">Cantidad</th>'+
											                '<th class="center" width="40%">Descuento</th>'+
											                '<th class="center" width="15%">Neto</th>'+
											                '<th class="center" width="15%">Total</th>'+
											            '</tr>'+
											       '</thead>'+
											        '<tbody class="lista_productos_documento">'+
											        '</tbody>'+
											   '</table>'+
											'</div>';
				$('.lista_producto__comanda_factura').html(tabla_productos);
				operarTotales();
			}

		});

		$('#TipoDoc').on('change', function(){
			var tipo_doc =  $('option:selected', this).attr('doc_electronico');
			if(tipo_doc == 1){
				$('.campo_cliente_folio').val('');
				$('.campo_cliente_folio').attr('disabled', true);
				folio_obligatorio = false;
			}else{
				$('.campo_cliente_folio').attr('disabled', false);
				folio_obligatorio = true;
			}
		});

		$('#FacturacionResumenesElementoComanda').on('change', function(){

			var comanda_id		=	$(this).val();
			$.ajax({
				type		: 'POST',
				url			: webroot + 'Comandas/ajax_obtenerComandaLocal',
				data			: {
					comanda_id			: comanda_id,
				},
				success		: function(msg){
					$('.lista_producto__comanda_factura').html(msg);
					operarTotales();
				}

			 });

		});

		$('#FacturacionResumenesElementoProducto').on('change', function(){

			var producto_id 	=  $('option:selected', this).val(); 
			var producto 		=  $('option:selected', this).attr('producto'); 
			var precio 			=  $('option:selected', this).attr('precio'); 
			// Se obtiene el precio del producto sin el iva (19%)
			precio 				=  parseFloat(precio) / 1.19;
			
			var html_producto	=	'<tr class="item_producto iteral_producto_agregado_'+iteral_producto_elemento+'" item="'+iteral_producto_elemento+'">'+
										'<td><i class="fa fa-trash-o fa-lg icon eliminar_producto" item="'+iteral_producto_elemento+'" producto_select="'+producto_id+'"></i></td>'+
										'<td>'+
											producto +
											'<input type="hidden" name="data[producto]['+iteral_producto_elemento+'][producto]" value="'+producto+'" id="producto'+iteral_producto_elemento+'Producto">'+
											'<input type="hidden" name="data[producto]['+iteral_producto_elemento+'][producto_id]" value="'+producto_id+'" id="producto'+iteral_producto_elemento+'ProductoId">'+
										'</td>'+
										'<td class="center">'+
											'<input name="data[producto]['+iteral_producto_elemento+'][cantidad]" class="form-control campo_modena input-number right cantidad_producto_op cantidad_producto_'+iteral_producto_elemento+'" value="1" iteral_producto="'+iteral_producto_elemento+'" precio_producto="'+precio+'" id="producto'+iteral_producto_elemento+'Cantidad">'+
										'</td>'+
										'<td class="icheckbox">'+
											'<div class="col-md-6">'+
												' % <label class="check"><input type="radio" value="1" class="iradio radio_descuento_producto" item="'+iteral_producto_elemento+'" name="producto.'+iteral_producto_elemento+'.tipo_descuento" /></label>'+
                                                ' $ <label class="check"><input type="radio" value="2" class="iradio radio_descuento_producto" item="'+iteral_producto_elemento+'" name="producto.'+iteral_producto_elemento+'.tipo_descuento" checked /></label>'+
											'</div>'+
											'<div class="col-md-6">'+
												'<div class="input text">'+
													'<input name="data[producto]['+iteral_producto_elemento+'][descuento]" class="form-control campo_modena input-number right descuento_producto" item="'+iteral_producto_elemento+'" type="text" id="producto'+iteral_producto_elemento+'Descuento">'+
												'</div>'+
												'<input type="hidden" name="data[producto]['+iteral_producto_elemento+'][valor_descuento]" class="cantidad_descuento_producto_op producto_valor_descuento_'+iteral_producto_elemento+'" value="0" id="producto'+iteral_producto_elemento+'ValorDescuento">'+
											'</div>'+
										'</td>'+
										'<td class="right">'+
											'$ <label class="txt_pruducto_'+iteral_producto_elemento+'_neto">'+formatMoney(precio,0,',','.')+'</label>'+
											'<input type="hidden" name="data[producto]['+iteral_producto_elemento+'][neto]" class="cantidad_neto_op neto_producto_'+iteral_producto_elemento+'" value_ori="'+precio+'" value="'+precio+'" id="producto'+iteral_producto_elemento+'Neto">'+
											'<input type="hidden" name="data[producto]['+iteral_producto_elemento+'][subneto]" value="'+precio+'" id="producto'+iteral_producto_elemento+'Subneto">'+
										'</td>'+
										'<td class="right">'+
											'$ <label class="txt_pruducto_'+iteral_producto_elemento+'_total">'+formatMoney(precio,0,',','.')+'</label>'+
											'<input type="hidden" name="data[producto]['+iteral_producto_elemento+'][total]" class="cantidad_neto_op producto_total_'+iteral_producto_elemento+'"  value="'+precio+'" id="producto'+iteral_producto_elemento+'Total">'+
										'</td>'+
									'</tr>';

								
			$('.lista_productos_documento').append(html_producto);
			$('.producto_carta_select_'+producto_id).hide();
			$(".icheckbox,.iradio").iCheck({checkboxClass: 'icheckbox_minimal-grey',radioClass: 'iradio_minimal-grey'});
			iteral_producto_elemento ++;
			operarTotales();
		});	

		$('.modulo-emision-documentos').on('click', '.eliminar_producto', function(){
			var iteral_producto = 	$(this).attr('item');
			var producto_select 	=	$(this).attr('producto_select');
			$('.producto_carta_select_'+producto_select).show();
			$('.iteral_producto_agregado_'+iteral_producto).remove();
			operarTotales();
		});


		/**
		 * Escucha que permite identificar el cliente seleccionado para la factura.
		 */
		$('body').on('change', '#cliente', function(){
			var cliente_id 	=	$(this).val();
			var dia_credito =  $('option:selected', this).attr('dia_credito');
			var sii_cliente =  $('option:selected', this).attr('sii_cliente');
			$('#FacturacionResumenesDiasCredito').val(dia_credito);
			$('#FacturacionResumenesCodidoSiiCliente').val(sii_cliente);
			// leemos la fecha del primer campo
			$("#fecha-vencimiento").datepicker("setDate", "+"+dia_credito+"d");

			/** Cuando se realice una factura y esta seleccionado como elemento de la factura guia de despacho,
				se obtiene las guias registradas al cliente.
			 */
			if ($('.emision-guia-despacho').length == 0){
				var elemento_comanda = $('#FacturacionResumenesElemento').val();
				if( elemento_comanda == '0' ){
					obtenerGuiasDespacho(cliente_id);
					$('.mensaje_no_cliente_select').addClass('ocultar');
				}
			}
		});


		$('body').on('click', '.btn-asignar-guias', function(){
			$('.lista_producto__comanda_factura').html(html_guias_despacho_select);
			$('.checkbox_guia').each(function(){

				if( $(this).prop('checked') ) {
				    var guia_id 			=	$(this).attr('guia_id');
					var emision 			=	$(this).attr('emision');
					var folio 				=	$(this).attr('folio');
					var bruto 				=	$(this).attr('bruto');
					var tipo_documento 		=	$(this).attr('documento');

					var html_guia 	=	'<tr>'+
											'<td></td>'+
											'<td>'+emision+'</td>'+
			                              	'<td>'+folio+'</td>'+
			                                '<td>$ '+formatMoney(bruto/1.19,0,',','.')+
			                                	'<input type="hidden" name="data[producto]['+guia_id+'][total]" class="cantidad_neto_op producto_total_'+guia_id+'"  value="'+bruto/1.19+'" id="producto'+guia_id+'Total">'+
			                                '</td>'+
										'</tr>';

					$('.lista_guias_despacho_cliente').append(html_guia);
					facturacionOtroDocumento += ( facturacionOtroDocumento == '' ? '' : '|')+ '' + tipo_documento+'.'+folio; 
				}
			});

			$('#FacturacionResumenesOtroDoc').val(facturacionOtroDocumento);
			$('#modalGuiasDespachoCliente').hide();
			$('#modalGuiasDespachoCliente').iziModal('destroy');	

			operarTotales();
		});


		$('.modulo-emision-documentos').on('keyup', '.descuento_producto', function(){

			var monto_decuento 			=	$(this).val();
			var item_producto_desc 		=	$(this).attr('item');
			var neto_producto			=	$('#producto'+item_producto_desc+'Neto').attr('value_ori');
			var cantidad_producto		=	$('#producto'+item_producto_desc+'Cantidad').val();
			// tipo_descuento_pro. 1: % -  2: $
			var tipo_descuento_pro		=	$("input[name='producto."+item_producto_desc+".tipo_descuento']:checked").val();

			if ( tipo_descuento_pro == 1 ){

				monto_decuento = ( monto_decuento <= 100 ? monto_decuento : 0 );
				if ( monto_decuento > 0 ){
					var descuento_pro 		= 	parseInt(monto_decuento) / 100;
				}else{
					var descuento_pro 		= 	0;
					$(this).val(0);
				}
				var monto_descuento		=	parseInt(neto_producto) * descuento_pro;
				var descuento_efectuado =	parseInt(neto_producto) - parseInt(monto_descuento);
				$('#producto'+item_producto_desc+'ValorDescuento').val(monto_descuento * cantidad_producto);

			} else if ( tipo_descuento_pro == 2 ){
				if ( parseInt(monto_decuento) <= parseInt(neto_producto)) {
					var descuento_efectuado =	parseInt(neto_producto) - parseInt(monto_decuento);
				}else{
					var descuento_efectuado = parseInt(neto_producto) - 0;
					$(this).val(0);
				}
				$('#producto'+item_producto_desc+'ValorDescuento').val(parseInt(monto_decuento * cantidad_producto));
			}

			$('#producto'+item_producto_desc+'Neto').val(descuento_efectuado);
			$('.txt_pruducto_'+item_producto_desc+'_neto').html(formatMoney(descuento_efectuado,0,',','.'));
			$('#producto'+item_producto_desc+'Total').val(descuento_efectuado*cantidad_producto);
			$('.txt_pruducto_'+item_producto_desc+'_total').html(formatMoney(descuento_efectuado*cantidad_producto,0,',','.'));


			operarTotales();
			

		});


		$('.modulo-emision-documentos').on('keyup', '.cantidad_descuento_general_op', function(){

			var monto_descuento 		=	$(this).val();
			var neto_general			=	$('#FacturacionResumenesNetoFactura').val();
			
			// tipo_descuento_general. 1: % -  2: $
			var tipo_descuento_general		=	$("input[name='radio_descuento_general']:checked").val();

			if ( tipo_descuento_general == 1 ){

				monto_descuento = ( monto_descuento <= 100 ? monto_descuento : 0 );
				if ( monto_descuento > 0 ){
					var descuento_pro 		= 	parseFloat(monto_descuento) / 100;
				}else{
					var descuento_pro 		= 	0;
					$(this).val(0);
				}
				var monto_descuento		=	parseFloat(neto_general) * descuento_pro;
				$('#FacturacionResumenesDetoGeneralFactura').val(monto_descuento);

			} else if ( tipo_descuento_general == 2 ){
				if(parseFloat(monto_descuento) <= parseFloat(neto_general)){
					$('#FacturacionResumenesDetoGeneralFactura').val(monto_descuento);
				}else{
					$('#FacturacionResumenesDetoGeneralFactura').val(0);
					$(this).val(0);
				}
				
			}

			operarTotales();
			

		});

		$('.modulo-emision-documentos').on('keyup', '#FacturacionResumenesPrecioNuevoProducto', function(){
			operarTotales();
		});

		$('.modulo-emision-documentos').on('keyup', '.cantidad_producto_op', function(){
			var cantidad_nueva	=	$(this).val(); 
			var iteral_producto =	$(this).attr('iteral_producto');
			var precio_producto =	$(this).attr('precio_producto');
			cantidad_nueva 		=	(cantidad_nueva == 0 ? 1 : cantidad_nueva);
			var precio_total_producto	=	parseFloat(precio_producto) * parseFloat(cantidad_nueva);
			$('.txt_pruducto_'+iteral_producto+'_total').html(formatMoney(precio_total_producto,0,',','.'));
			$('#producto'+iteral_producto+'Total').val(precio_total_producto);
			operarTotales();
		});

		/** AGREGAR CLIENTE */
		$('body').on('click', '.form-validacion-facturacion', function(){

			event.preventDefault();

	 		$('.btn-form-submit').hide();
	  		$('.gif-cargando').show();

	  		var campos_obligatorio 		= 	false;
	  		var id_formulario 			=	$(this).attr('idform'); // ID formulario (Variable para el submit)
	  		var campoForm				=	$(this).attr('campoForm'); // ID del registro (Cuando se edita el campo)

	  		/**
		   	* Verificación de lo campos obligatorios
		   	*/
		    var campos_obligatorio 		= 	verificarCampoFormulario(campoForm);

		    if ( ! campos_obligatorio ){

		    	var info_cliente = {
			    	'rut_cliente'				:	$('#ProveedorClienteRutDni').val(),
			    	'razon_social_cliente'		:	$('#ProveedorClienteRazonSocial').val(),
			    	'giro_cliente'				:	$('#ProveedorClienteGiro').val(),
			    	'region_cliente'			:	$('#ProveedorClienteCampoDireccion1').val(),
			    	'region_cliente_id'			:	$('#ProveedorClienteCampoIdDireccion1').val(),
			    	'provincia_cliente'			:	$('#ProveedorClienteCampoDireccion2').val(),
			    	'provincia_cliente_id'		:	$('#ProveedorClienteCampoIdDireccion2').val(),
			    	'comuna_cliente'			:	$('#ProveedorClienteCampoDireccion3').val(),
			    	'comuna_cliente_id'			:	$('#ProveedorClienteCampoIdDireccion3').val(),
			    	'ubicacion_cliente'			:	$('#ProveedorClienteDireccionDefinida').val(),
			    	'forma_pago_cliente'		:	$('#ProveedorClienteFormaPago').val(),
			    	'credito_cliente'			:	$('#ProveedorClienteDiaCredito').val(),
			    	'email_cliente'				:	$('#ProveedorClienteMailDte').val(),
			    	'codigo_sii'				:	$('#ProveedorClienteCodigoSii').val(),
			    	'cant_direcciones'			: 	cant_direcciones

		   		}

		   		var dia_credito_cliente_nuevo = $('#ProveedorClienteDiaCredito').val();
		   		var codigo_sii				  = $('#ProveedorClienteCodigoSii').val();

		    	$.ajax({
					type		: 'POST',
					url			: webroot + 'ProveedorClientes/ajax_addCliente',
					data			: {
						info_cliente			: info_cliente,
					},
					success		: function(msg){

						$('.btn-form-submit').show();
	  					$('.gif-cargando').hide();

	  					$('#FacturacionResumenesDiasCredito').val(dia_credito_cliente_nuevo);
	  					$('#FacturacionResumenesCodidoSiiCliente').val(codigo_sii);

	  					$("#fecha-vencimiento").datepicker("setDate", "+"+dia_credito_cliente_nuevo+"d");
						$('.campo_cliente_factura').html(msg);
						$('.modalFormularios').each(function(){
							var modal 		=	$(this).attr('id');
							$('#' + modal).hide();
							$('#' + modal).iziModal('destroy');	
						});
					}

				 });

		    }else{
		    	$('.btn-form-submit').show();
	  			$('.gif-cargando').hide();
		    }

		});

		/** VALIDAR INGRESO DE FOLIO */


		/** REGISTRAR DOCUMENTO */
		$('.form-validacion-documento').on('click', function(event){
			event.preventDefault();

			var enviar_documento	=	true;
			var campoForm			=	$(this).attr('campoForm'); // ID del registro (Cuando se edita el campo)

			$('.btn-form-submit').hide();
			$('.gif-cargando').show();

			$('input.verifica_campo_'+campoForm).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
	  		$( '.div_campo_js').children("p").remove(); // Se quitan los mensajes de campo requerido

			 // Validar campos obligatorios
			if ( $('#TipoDoc').val() == 0 || $('#TipoDoc').val() == null || $('#TipoDoc').val() == ''){
		  		$('.campo_requerido_TipoDoc').append('<p class="msn_campo_requerido">Debe asignar un tipo al documento.</p>');
		  		enviar_documento 		= false;
		  	}

		  	if ( $('#cliente').val() == 0 || $('#cliente').val() == null || $('#cliente').val() == ''){
		  		$('.campo_requerido_Cliente').append('<p class="msn_campo_requerido">Debe asignar un cliente al documento.</p>');
		  		enviar_documento 		= false;
		  	}

		  	if ( folio_obligatorio ){
		  		if (  $('.campo_cliente_folio').val() == null || $('.campo_cliente_folio').val() == ''){
			  		$('.campo_requerido_FacturacionResumenesFolio').append('<p class="msn_campo_requerido">Debe asignar un folio al documento.</p>');
			  		enviar_documento 		= false;
			  	}
		  	}
		  	if ( enviar_documento ){
		  		
		  		if ($('.emision-guia-despacho').length){
		  			$('#FacturacionResumenesAddGuiaDespachoForm').submit();
		  		}else{
		  			$('#FacturacionResumenesAddForm').submit();
		  		}
		  		
		  	}else{
		  		$('.btn-form-submit').show();
				$('.gif-cargando').hide();
		  	}

		});


	}

	operarTotales();

});

/**
 * Funcion que permite obtener el listado de las guias de despacho pendiente de un cliente determinado
 * @param  {[type]} cliente_id [identificador del cliente ID]
 * @return {[type]}            [HTML de la lista con las guias de despacho]
 */
function obtenerGuiasDespacho(cliente_id)
{
	$.ajax({
		type		: 'POST',
		url			: webroot + 'FacturacionResumenes/ajax_obtenereGuiaDespachoCliente',
		data			: {
			cliente_id			: cliente_id,
		},
		success		: function(msg){
			$('.tabla_guias_despacho').html(msg);
			inicializarIziModal( 'modalGuiasDespachoCliente' );
			$('#modalGuiasDespachoCliente').iziModal('open');
		}

	 });
}

/**
 * [operarTotales description]
 * Funcion que permite obtener los valores totales de la factura, en funcion a los montos de los productos
 * @return {[type]} [description]
 */
function operarTotales()
{
	if ( tipo_factura_documento == 0 ){

		var aplica_descuento		=	false;
		var deto_general_total		=	$('#FacturacionResumenesValorDescuentoGeneral').val();
		var neto_guia				=	0;
		var neto_guia_ope			=	0;

		//  Obtener el monto total de las guias
		$('.cantidad_neto_op').each(function(){
			var neto_producto 		=	$(this).val();
			neto_guia 				=	parseFloat(neto_producto);
		});
		neto_guia_ope				=	neto_guia;

		// Calculo de neto e iva
		bruto_total 		= 	neto_guia_ope * 1.19;
		iva_total			=	parseFloat(bruto_total) - parseFloat(neto_guia_ope);
		// Mostrar los valores neto
		$('.neto_factura').html(formatMoney(neto_guia,0,',','.'));
		
		// Mostrar los valores descuento general
		if( deto_general_total > 0 ){
			$('.tr_descuento_general').removeClass('ocultar');
			$('.descuento_general_factura').html(formatMoney(deto_general_total,0,',','.'));
			aplica_descuento = true;
		}else{
			$('.tr_descuento_general').addClass('ocultar');
			aplica_descuento = false;
		}

		if ( aplica_descuento ){
			$('.tr_neto_desp_descuento').removeClass('ocultar');
			$('.neto_desp_descuento').html(formatMoney(neto_guia_ope,0,',','.'));
		}else{
			$('.tr_neto_desp_descuento').addClass('ocultar');
		}
		
		// Mostrar los valores iva
		$('.iva_factura').html(formatMoney(iva_total,0,',','.'));
		// Mostrar los valores total
		$('.bruto_factura').html(formatMoney(bruto_total,0,',','.'));

		// Asignacion de valores
		$('#FacturacionResumenesNetoFactura').val(neto_guia);
		$('#FacturacionResumenesIvaFactura').val(iva_total);
		$('#FacturacionResumenesTotalFactura').val(bruto_total);
		$('#FacturacionResumenesDetoProductoFactura').val(0);
		$('#FacturacionResumenesDetoGeneralFactura').val(deto_general_total);


	}else{
		var aplica_descuento		=	false;
		var productos 				=	0;
		var cant_total				=	0;
		var neto_total 				=	0;
		var neto_total_ope 			=	0;
		var iva_total				=	0;
		var bruto_total				=	0;
		var deto_producto_total		=	0;
		var deto_general_total		=	$('#FacturacionResumenesValorDescuentoGeneral').val();
		//var valor_nuevo_producto	=	$('#FacturacionResumenesPrecioNuevoProducto').val();
		//valor_nuevo_producto		=	valor_nuevo_producto.replace('.', '');
		var valor_nuevo_producto = 0;

		//  Obtener el monto total de los productos
		$('.item_producto').each(function(){
			var item_producto 		=	$(this).attr('item');
			var neto_producto 		=	$('.neto_producto_'+item_producto).attr('value_ori');
			var cantidad_producto 	=	$('.cantidad_producto_'+item_producto).val();
			neto_total				=	parseFloat(neto_total) + (parseFloat(neto_producto) * cantidad_producto );
			neto_total_ope			=	neto_total;
			//bruto_total 			=	parseFloat(neto_total_ope) + (parseFloat(neto_total_ope * cantidad_producto)); 	
		});

		if (valor_nuevo_producto > 0){
			neto_total_ope 		= neto_total_ope + parseFloat(valor_nuevo_producto);
			neto_total 			= neto_total + parseFloat(valor_nuevo_producto);
		}

		// Calculo descuento producto
		$('.cantidad_descuento_producto_op').each(function(){
			var descuento_producto 	= $(this).val();
			deto_producto_total 	=	parseFloat(deto_producto_total) + parseFloat(descuento_producto);
		});
		neto_total_ope = neto_total_ope - deto_producto_total;
		
		// calculo descuento general
		if ( deto_general_total > 0){
			neto_total_ope = neto_total_ope - parseFloat(deto_general_total);
		}

		// Calculo de neto e iva
		bruto_total 		= 	neto_total_ope * 1.19;
		iva_total			=	parseFloat(bruto_total) - parseFloat(neto_total_ope);

		// Mostrar los valores neto
		$('.neto_factura').html(formatMoney(neto_total,0,',','.'));
		// Mostrar los valores descuento producto
		if( deto_producto_total > 0 ){
			$('.tr_descuento_producto').removeClass('ocultar');
			$('.descuento_producto_factura').html(formatMoney(deto_producto_total,0,',','.'));
			aplica_descuento = true;
		}else{
			$('.tr_descuento_producto').addClass('ocultar');
		}
		// Mostrar los valores descuento general
		if( deto_general_total > 0 ){
			$('.tr_descuento_general').removeClass('ocultar');
			$('.descuento_general_factura').html(formatMoney(deto_general_total,0,',','.'));
			aplica_descuento = true;
		}else{
			$('.tr_descuento_general').addClass('ocultar');
		}

		if ( aplica_descuento ){
			$('.tr_neto_desp_descuento').removeClass('ocultar');
			$('.neto_desp_descuento').html(formatMoney(neto_total_ope,0,',','.'));
		}else{
			$('.tr_neto_desp_descuento').addClass('ocultar');
		}
		
		// Mostrar los valores iva
		$('.iva_factura').html(formatMoney(iva_total,0,',','.'));
		// Mostrar los valores total
		$('.bruto_factura').html(formatMoney(bruto_total,0,',','.'));

		// Asignacion de valores
		$('#FacturacionResumenesNetoFactura').val(neto_total);
		$('#FacturacionResumenesIvaFactura').val(iva_total);
		$('#FacturacionResumenesTotalFactura').val(bruto_total);
		$('#FacturacionResumenesDetoProductoFactura').val(deto_producto_total);
		$('#FacturacionResumenesDetoGeneralFactura').val(deto_general_total);

	}
	
}