// variables Globales
var cant_productos_comanda 	=	0;
var cant_clientes_comanda	=	0;
var monto_total_comanda		=	0;
var cliente_select_add		=	'';
var opcion_pago_cuenta		=	1;
var comboSeleccionado           =       null;
var comboSeleccionadoNombre     =       null;
var iteral_producto_comanda     =       0;
var comboSeleccionadoPrecio     =       0;

$( document ).ready(function() {

	/** Se reajusta el alto de los contendedores, segun alto del navegador */
	if ( $(".contenedor-info-comanda").length ){
		var alto_navegador = $( window ).height();
		var posicion_contenedor = $(".contenedor-info-comanda").offset().top;
		var dif_posiciones = parseInt(alto_navegador) - parseInt(posicion_contenedor);
		$(".contenedor-info-comanda").height( dif_posiciones - 10);
	}

	$('.contenedor-lista-productos').on('click', '.categoria', function(){
 		var id_categoria = $(this).attr('id');
 		$('.categoria').removeClass('activo');
 		$('.item_categoria_'+id_categoria).addClass('activo');
 		$('.producto_carta').addClass('ocultar');
 		$('.producto_categoria_'+id_categoria).removeClass('ocultar');
 	});

 	/** click btn seleccinar categoria padre */

 	$('.contenedor-lista-productos').on('click', '.btn-select-categoria-padre', function(){
 		var padre = $(this).attr('padre');
 		$('.btn-select-categoria-padre').removeClass('btn-ed');
 		$(this).addClass('btn-ed');
 		$('.msn-selecciones-categoria').remove();

 		$('.producto_carta').addClass('ocultar');
 		$('.categoria_hija_lista').addClass('ocultar');
 		$('.categoria_hija_'+padre).removeClass('ocultar');
 	});

	/**
	 * Acciones para la generacion de la comanda desde Desktop
	 * @param  {[type]} $('#contenedor-comanda').length [description]
	 * @return {[type]}                                         [description]
	 */
	if ( $('#contenedor-comanda').length ){

		obtenerTotalesProductos();
		obtenerCantidadCliente();
		cadenaClientes();
		/*
		if ( mesa_definida == '2' ){
			$('#contenedor-comanda').trigger('click','.ico-cambiar-mesa');
		}
		*/
		/**
		 * Variables Generales
		 */
		var iteral_cliente_comanda		=	lista_cliente;
		iteral_producto_comanda         =	cant_productos;
		var cliente_comanda_select		=	0;
		var cantidad_productos 			=	lista_cliente;
		var cantidad_clientes 			=	cant_productos;

		/**
		 * Nuevo Cliente 
		 * @param  {[type]} event){			event.preventDefault();			iteral_cliente_comanda				++;			cliente_comanda_select [description]
		 * @return {[type]}                                                                                             [description]
		 */
		$('#contenedor-comanda').on('click', '.nuevo-user-comanda', function(event){
			$('.nuevo-user-comanda').addClass('ocultar');
            $(".seleccion_cliente").attr("cliente_seleccionado", false);
			event.preventDefault();
			//document.getElementsByClassName('nuevo-user-comanda').style.display = 'none';
			$('.msn-ingresar-cliente').remove();
			$('.items-pedido-desktop').removeClass('ocultar');

			$('.figure-cliente-comanda').removeClass('activo_cliente_comanda');
			$('.tbody_item').removeClass('border-activo');
			iteral_cliente_comanda				++;
			cliente_comanda_select		=	iteral_cliente_comanda;

			var nombre_ciente_comanda	=	$('.nombre_ciente_comanda').val();
			nombre_ciente_comanda		=	( nombre_ciente_comanda == '' ? 'Cliente '+cliente_comanda_select : nombre_ciente_comanda);
			cliente_select_add			=	nombre_ciente_comanda;
			var img_user_comanda 		=	'\
                        <div class="col-'+grilla_comanda+'-'+cant_cliente_linea+' center icon_img_cliente_'+iteral_cliente_comanda+' seleccion_cliente" cliente_seleccionado="true" numero_cliente="'+iteral_cliente_comanda+'">'+
                            '<img src="/img/user_comand.png" class="img_cliente_comanda icon_click"  cliente="'+iteral_cliente_comanda+'" alt="">'+
                            '<figcaption class="figure-caption canter"><input input_cliente_comanda="'+iteral_cliente_comanda+'" class="center form-control figure-cliente-comanda activo_cliente_comanda campo_nombre_cliente_comanda text_nombre_cliente_comanda_'+iteral_cliente_comanda+' icon_cliente_comanda_'+iteral_cliente_comanda+'" type="text" name="" value="'+nombre_ciente_comanda.substring(0,12)+'"></figcaption>'+
                        '</div>';

			//var item					=	'<tr class="pidido_cliente_'+iteral_cliente_comanda+'_comanda"><td class="td_cliente_comanda" colspan="5"><code>'+nombre_ciente_comanda+'</code></td></tr>';

			var item = '<tbody class="tbody_item border-activo tbody_cliente_'+iteral_cliente_comanda+'">'+
                                    '<tr class="fila_cliente">'+
                                        '<td class="td_cliente_comanda" colspan="4"><span class="nombre_ciente_comanda_insert_'+iteral_cliente_comanda+'">'+nombre_ciente_comanda+'</span></td>'+
                                        '<td class="td_cliente_comanda eliminar_cliente_comanda icon_click" cliente="'+iteral_cliente_comanda+'">- Eliminar</td>'+
                                    '</tr>'+
                               '</tbody>';

			$('.div-users-comanda').append(img_user_comanda);
			$('.items-pedido-desktop').append(item);
			$('.nombre_ciente_comanda').val('');
			obtenerCantidadCliente();
			cadenaClientes();
			$('.nuevo-user-comanda').removeClass('ocultar');

		});

		$('#contenedor-comanda').on('keyup', '.campo_nombre_cliente_comanda', function(){
			var texto 		= 	$(this).val();
			var id_texto 	=	$(this).attr('input_cliente_comanda');

			if ( texto == ''){
				texto = 'Cliente_'+id_texto;
			}

			$('.nombre_ciente_comanda_insert_' + id_texto).html(texto);
			$('.nombre_ciente_comanda_insert_input_' + id_texto).val(texto);
			cliente_select_add		=	texto;
			cadenaClientes();
		});


		$('#contenedor-comanda').on('click', '.img_cliente_comanda', function(event){
                    event.preventDefault();
                    var cliente_comanda 		=	$(this).attr('cliente');
                    var cliente_click 			=	$(this).attr('cliente');
                    var cliente_text			=	$('.text_nombre_cliente_comanda_'+cliente_click).val();
                    cliente_select_add			=	cliente_text;

                    $('.figure-cliente-comanda').removeClass('activo_cliente_comanda');
                    $('.icon_cliente_comanda_'+cliente_click).addClass('activo_cliente_comanda');

                    $('.tbody_item').removeClass('border-activo');
                    $('.tbody_cliente_'+cliente_click).addClass('border-activo');

                    cliente_comanda_select		=	cliente_comanda;
                    
                    $(".seleccion_cliente").attr("cliente_seleccionado", false);
                    $(".icon_img_cliente_"+cliente_comanda_select).attr('cliente_seleccionado', true);
		});

		$('#contenedor-comanda').on('click', '.eliminar_cliente_comanda', function (event){
			event.preventDefault();
			var item_cliente 	=	$(this).attr('cliente');
			$('.tbody_cliente_'+item_cliente).remove();
			$('.icon_img_cliente_'+item_cliente).remove();
			obtenerCantidadCliente();
			cadenaClientes();
		});

		/**
		 * Aumentar cantidad item producto carta
		 * @param  {[type]} event){			event.preventDefault();			var item_producto [description]
		 * @return {[type]}                                          [description]
		 */
		/*$('#contenedor-comanda').on('click', '.addCantProducto', function (event){
			event.preventDefault();
			var item_producto 	=	$(this).attr('itemIcon');
			var cant_actual 	=	$('.cantidad_producto_carta_'+item_producto).attr('cant');
			var cant_nueva		=	parseInt(cant_actual) + 1;
			$('.cantidad_producto_carta_'+item_producto).html('('+cant_nueva+')');
			$('.cantidad_producto_carta_input_'+item_producto).val(cant_nueva);
			$('.cantidad_producto_carta_'+item_producto).attr('cant', cant_nueva);
			var precio_producto 	=	$('.precio_producto_carta_input_'+item_producto).val();
			var total_producto 		=	precio_producto * cant_nueva;
			$('.total_producto_carta_input_'+item_producto).val(total_producto);
			obtenerTotalesProductos();
		});*/

		/**
		 * Disminur cantidad producto carta
		 * @param  {[type]} event){			event.preventDefault();			var item_producto [description]
		 * @return {[type]}                                          [description]
		 */
		/*$('#contenedor-comanda').on('click', '.restCantProducto', function (event){
			event.preventDefault();
			var item_producto 	=	$(this).attr('itemIcon');
			var cant_actual 	=	$('.cantidad_producto_carta_'+item_producto).attr('cant');
			if (cant_actual > 1 ){
				var cant_nueva		=	parseInt(cant_actual) - 1;
				$('.cantidad_producto_carta_'+item_producto).html('('+cant_nueva+')');
				$('.cantidad_producto_carta_input_'+item_producto).val(cant_nueva);
				$('.cantidad_producto_carta_'+item_producto).attr('cant', cant_nueva);
			}
			obtenerTotalesProductos();
		});*/


                //Eliminar producto_carta
		$('#contenedor-comanda').on('click', '.deleteProducto', function (event){
            event.preventDefault();
            var item_producto = $(this).attr('itemIcon');
            $('#iteral_producto_cliente_'+item_producto).remove();
            obtenerTotalesProductos();
		});
                
        //Eliminar producto_combo
        $('#contenedor-comanda').on('click', '.deleteProductoCombo', function (event){
            event.preventDefault();
            var item_producto = $(this).attr('itemIcon');
            $('#iteral_producto_cliente_combo_'+item_producto).remove();
            obtenerTotalesProductos();
		});

		$('#contenedor-comanda').on('click', '.abreModal', function (event){
            inicializarIziModal( 'agregaAgregados' );
 			$('#agregaAgregados').removeClass('ocultar');
 			$('#agregaAgregados').iziModal('open');
 			var itemProductoAgregado=$(this).attr('itemAgregado');
 			$('#selectProducto').val(itemProductoAgregado);
		});

		$('#contenedor-comanda').on('click', '.abreModal2', function (event){
            inicializarIziModal( 'detalleAgregados' );
 			$('#detalleAgregados').removeClass('ocultar');
 			$('#detalleAgregados').iziModal('open');
 			var itemProductoAgregado=$(this).attr('itemAgregado2'); 			
			infoComentario=$('.Pedido'+itemProductoAgregado+'nombres_agregados').val();
			infoAgregado=$('.Pedido'+itemProductoAgregado+'agregados').val();
			infoAgregadoMto=$('.Pedido'+itemProductoAgregado+'total_agregados').val();
			var infoComentario=infoComentario.split('|');
			var infoAgregado=infoAgregado.split('|');
			var infoAgregadoMto=infoAgregadoMto.split('|');
			var totalAgregados=infoAgregadoMto.reduce(function(a, b){ a=parseInt(a); b=parseInt(b); return a + b; });
			var iteral = infoAgregado.length;
			if(infoAgregado!=''){
				for (paso = 0; paso < iteral; paso++) {	
					var step = paso;	
		        	var itemsAgregados=
		        		'<tr class="tablaAgdo">'+
		        			'<td><label class="switch"><input type="checkbox" checked onclick="eliminaAgdo('+step+','+itemProductoAgregado +');"><span></span></label></td>'+
		        			'<td>' + infoComentario[paso] + '</td>'+
		        			'<td>$' + formatMoney(infoAgregadoMto[paso],0,',','.') + '</td>'+
		        		'</tr>';
		          
		          $('.detalleAgregados').append(itemsAgregados);
		        };
		        var finalItemsAgregados=
		        	'<tr class="tablaTotal">'+
		        		'<td colspan="2">Total Agregados</td>'+
		        		'<td>$<div id=totalAgregados>'+formatMoney(totalAgregados,0,',','.')+'</div></td>'+
		        	'</tr>';
		        $('.detalleAgregados').append(finalItemsAgregados);	
			}       
	        
		});       

		/**
		 * Se agrega un producto carta a la comanda, asignado a un cliente
		 * @param  {[type]} event){			event.preventDefault();			if (             cliente_comanda_select > 0 ){				iteral_producto_comanda	++;								var id_producto_carta [description]
		 * @return {[type]}                                         [description]
		 */
		$('#contenedor-comanda').on('click', '.img_add_producto_carta', function(event){
			event.preventDefault();
			
			if ( cliente_comanda_select > 0 ){
				var id_producto_carta 			=	$(this).attr('id_producto_carta');
				var valor_producto_carta 		=	$(this).attr('valor_producto_carta');
				var nombre_producto_carta 		=	$(this).attr('nombre_producto_carta');
				var producto_divisible 			=	$(this).attr('producto_divisible');
				var producto_impresion 			=	$(this).attr('prod_impresion');

				if( !$('#iteral_producto_cliente_'+id_producto_carta+''+cliente_comanda_select).length ){
					iteral_producto_comanda	++;
				}

				agregarProductoComanda(cliente_comanda_select, iteral_producto_comanda, id_producto_carta,nombre_producto_carta,iteral_cliente_comanda,valor_producto_carta, producto_divisible, producto_impresion);
				
			}
		});

		$('#contenedor-comanda').on('change', '#selectProductoCarta', function(event){
			event.preventDefault();

			if ( cliente_comanda_select > 0 ){
				var id_producto_carta 			=	$(this).val();
				var nombre_producto_carta		=	$('#selectProductoCarta option:selected').text();
				var valor_producto_carta 		=	$('option:selected', this).attr('valor');
				var producto_divisible 			=	$('option:selected', this).attr('divisible');
				var producto_impresion 			=	$('option:selected', this).attr('impresion');
				
				if( !$('#iteral_producto_cliente_'+id_producto_carta+''+cliente_comanda_select).length ){
					iteral_producto_comanda	++;
				}

				agregarProductoComanda(cliente_comanda_select, iteral_producto_comanda, id_producto_carta,nombre_producto_carta,iteral_cliente_comanda,valor_producto_carta, producto_divisible, producto_impresion);
			}
		});

		/** Proceso que permite obtener el lista de las mesas que esten disponibles */
		/*
		$('#contenedor-comanda').on('click', '.ico-cambiar-mesa', function (){

			$.ajax({
				type		: 'POST',
				url			: webroot + 'Mesas/ajax_listaMesa',
				success		: function(msg){
					$('.titulo_mesa').html(msg);
				}
			 });
		});
		*/

		$('#contenedor-comanda').on('change', '#selectMesaComanda', function (){
			var mesa_id 	=	$(this).val();
			var nombre_mesa	=	$('#selectMesaComanda option:selected').text();

			$('#ComandaMesaId').val(mesa_id);
			$('#MesaId').val(mesa_id);
			var txt_comanda = '<span class="fa fa-refresh ico-cambiar-mesa"></span><span class="nombre_mesa_comanda"> '+nombre_mesa+'</span>';
			$('.titulo_mesa').html(txt_comanda);
		});


		/** REGISTRAR COMANDA */
		$( "body" ).on('click', '.form-validacion-comanda', function( event ) {

			event.preventDefault();

	  		$('.btn-form-submit').hide();
	 		$('.gif-cargando').show();

	 		if ( cant_productos_comanda > 0 ){

	 			// Total de monto monto_total_comanda
				var monto_productos = 0;

				$( ".campo_total_producto" ).each(function( index ) {
				  var monto  = $(this).val();
				  monto_productos += parseInt(monto);
				});
				monto_total_comanda = parseInt(monto_productos) + parseInt(monto_comanda);
				$('#ComandaMonto').val(monto_total_comanda);
				$('#ComandaMontoNuevo').val(monto_productos);
				obtenerCantidadCliente();
				if ( $('.cant_usuario_divisible').length){
					$('#ComandaConDivisible').val(1);
				}

	 			$( ".formularioComanda" ).submit();

	 		}else{
	 			$('.texto-alerta-js').html('Se debe ingresar por lo menos un producto');
	 			$('#alerta_js').addClass('open');
	 			$('.btn-form-submit').show();
	 			$('.gif-cargando').hide();
	 		}

		});

	}

	/**
	 * Acciones para generar la cuenta de una comanda determinada
	 * @param  {[type]} $('#contenedor-cuenta-comanda').length [description]
	 * @return {[type]}                                        [description]
	 */
	if($('#contenedor-cuenta-comandas').length){

		var opcion_cuenta = 1; // 1: Cuenta Completa - 2: Cuenta por usuario - 3: cuenta por productos

		 // Asignacion del tipo de cuenta
		 $(".opciones-cuenta").on('click', "input[type='radio']",function(){
		 	opcion_cuenta 	=	$(this).val();

		 	if ( opcion_cuenta == 1 ){

		 		$('.div-generar-cuenta').removeClass('ocultar');
		 		$('.btn-generar-cuenta-completa').removeClass('ocultar');
		 		
		 		$('.btn-genera-cuenta-usuaurio').addClass('ocultar');
		 		$('.checkbox_select_producto').addClass('ocultar');
		 		$('.btn_select_producto').addClass('ocultar');
		 		$('.div-generar-cuenta-producto').addClass('ocultar');


		 	}else if ( opcion_cuenta == 2 ){ 
		 		$('.btn-genera-cuenta-usuaurio').removeClass('ocultar');
		 		$('.btn-generar-cuenta-completa').addClass('ocultar');
		 		$('.checkbox_select_producto').addClass('ocultar');
		 		$('.btn_select_producto').addClass('ocultar');
		 		$('.div-generar-cuenta').addClass('ocultar');
		 		$('.div-generar-cuenta-producto').addClass('ocultar');

		 	}else if ( opcion_cuenta == 3){

		 		$('.btn-genera-cuenta-usuaurio').addClass('ocultar');
		 		$('.btn-generar-cuenta-completa').addClass('ocultar');
		 		$('.checkbox_select_producto').removeClass('ocultar');
		 		$('.btn_select_producto').removeClass('ocultar');
		 		$('.div-generar-cuenta').addClass('ocultar');
		 		$('.div-generar-cuenta-producto').removeClass('ocultar');
		 	}

		 });

		 // Click generar cuenta
		 $("#contenedor-cuenta-comandas").on('click', '.js-generar-cuenta', function(){
		 	var inputCuenta = $(this);
		 	var tipo_genera_cuenta  	= $(this).attr('tipo_cuenta');
		 	var correlativo_folio		=	'';
		 	var id_pedido     			=	'';
		 	
		 	if(tipo_genera_cuenta!=3){
		 		$('.btn-imprimir').addClass('ocultar'); 

			 	// consultamos el folio disponible
			 	$.ajax({
					type		: 'POST',
					url			: '/Comandas/ajaxFolioDisponible',
					headers: { 'X-XSRF-TOKEN' : token },
		            beforeSend: function (xhr) {
		                xhr.setRequestHeader('X-CSRF-Token', token);
		            },
					success		: function(msg){
						//console.log($(this));
						correlativo_folio = msg;
						$('.correlativo_folio').html(correlativo_folio);

						if ( tipo_genera_cuenta == 1 ){
							$('#VoucherGeneralFolio').val(correlativo_folio);
						}else{
							$('#VoucherEspecificoFolio').val(correlativo_folio);
						}
						$('.btn-imprimir').removeClass('ocultar');


						//Luego de obtener el folio (al terminar el ajax) continuamos con las demas operaciones
						//La variable 'inputCuenta' solo es usada cuando 'opcion_cuenta' = 2
						generarCuenta(opcion_cuenta, tipo_genera_cuenta, id_pedido, inputCuenta);
					}
				 });
		 	}
		 	if(tipo_genera_cuenta==3){
		 		var montoPagoPorProducto	= $('.total-cuenta-producto').html();
		 			var estado = true;
			 	if(montoPagoPorProducto==0 || montoPagoPorProducto==null || montoPagoPorProducto==''){
			 		var estado = false;
			 	}
			 	if(estado){
			 		$('.btn-imprimir').addClass('ocultar'); 

				 	// consultamos el folio disponible
				 	$.ajax({
						type		: 'POST',
						url			: '/Comandas/ajaxFolioDisponible',
						headers: { 'X-XSRF-TOKEN' : token },
			            beforeSend: function (xhr) {
			                xhr.setRequestHeader('X-CSRF-Token', token);
			            },
						success		: function(msg){
							//console.log($(this));
							correlativo_folio = msg;
							$('.correlativo_folio').html(correlativo_folio);

							if ( tipo_genera_cuenta == 1 ){
								$('#VoucherGeneralFolio').val(correlativo_folio);
							}else{
								$('#VoucherEspecificoFolio').val(correlativo_folio);
							}
							$('.btn-imprimir').removeClass('ocultar');


							//Luego de obtener el folio (al terminar el ajax) continuamos con las demas operaciones
							//La variable 'inputCuenta' solo es usada cuando 'opcion_cuenta' = 2
							generarCuenta(opcion_cuenta, tipo_genera_cuenta, id_pedido, inputCuenta);
						}
					 });
			 	}else{
			 		alert('Debe seleccionar al menos un producto');
			 	}
		 		
		 	}
		 	
		 });

		$("#contenedor-cuenta-comandas").on('click', '.checkbox_producto_select', function (){
			if (  opcion_cuenta == 3 ){
				totalCuentaProductos();
		 	}
		});

		$("#contenedor-cuenta-comandas").on('click', '.btn_select_producto', function(){
			if (  opcion_cuenta == 3 ){
				var cliente_id = $(this).attr('cliente_id');
				$(".checkbox_cliente_" + cliente_id).prop('checked', true);
				totalCuentaProductos();
		 	}
		});
	}
});


$(window).load(function(){ 
    $('.gif-recibiendo-info').fadeOut();
    $('.gif-recibiendo-info').remove();
    $('.contendor_generar_comanda').removeClass('opacity_0');
    $('.contendor_generar_comanda').fadeIn('slow');
});

function generarCuenta(opcion_cuenta, tipo_genera_cuenta, id_pedido, inputCuenta){

	if ( opcion_cuenta == 1 && tipo_genera_cuenta == 1){

 		var cliente_producto_divisible = '';
 		var iteral_pedido 	=	0;
 		var iteral_pedido_divisible 	=	0;

 		$('.producto_pedido').each(function(index){
 			var producto_id 		=	$(this).attr('producto_id');
 			var divisible 			=	$(this).attr('producto_divisible');
 			var usuario_id 			=	$(this).attr('usuario_id');
 			
 			if (divisible == 1 ){
 				cliente_producto_divisible += ( iteral_pedido_divisible == 0 ? '' : '|')+ '' + usuario_id+','+producto_id; 
 				iteral_pedido_divisible ++;
				}	
				iteral_pedido ++;
 		});
 		$('#VoucherGeneralUsuarioProductoDivisible').val(cliente_producto_divisible);

 		inicializarIziModal( 'modalGenerarCuentaCompleta' );
 		$('#modalGenerarCuentaCompleta').removeClass('ocultar');
 		$('#modalGenerarCuentaCompleta').iziModal('open');
 	}

 	if ( opcion_cuenta == 2  ){
 		$('.producto_select_cuenta').html('');
 		$('#VoucherEspecificoTipoCuenta').val(opcion_cuenta);

 		var cliente_id 	= inputCuenta.attr('cliente_id');
 		var cliente 	= inputCuenta.attr('cliente');
 		var total_cuenta 	=	0;
 		var propina 		=	0;
 		var iteral_pedido 	=	0;
 		var iteral_pedido_divisible 	=	0;
 		var lista_cliente_pago_producto_divisible = '';
 		var voucher_con_divisible = false;
 		var cant_cliente_pago_divisible = 0;
 		var cliente_producto_divisible = '';
 		console.log(cliente+" ("+cliente_id+")");
 		$('.data_producto_cliente_' + cliente_id).each(function(index){

 			var producto 			= 	$(this).attr('producto');
 			var producto_id 		=	$(this).attr('producto_id');
 			var precio_producto 	=	$(this).attr('precio_producto');	
 			var cant_producto 		=	$(this).attr('cant_producto');	
 			var total_producto 	 	=	$(this).attr('total_producto');	
 			var pedido 				=	$(this).attr('pedido');
 			var divisible 			=	$(this).attr('producto_divisible');
 			var usuario_id 			=	$(this).attr('usuario_id');

 			id_pedido				+=	( iteral_pedido == 0 ? '' : ',')+ '' + pedido;
 			if (divisible == 1 ){
 				voucher_con_divisible	=	1;
 				cant_cliente_pago_divisible ++;
 				cliente_producto_divisible += ( iteral_pedido_divisible == 0 ? '' : '|')+ '' + usuario_id+','+producto_id;
					lista_cliente_pago_producto_divisible	+=	( iteral_pedido_divisible == 0 ? '' : '|')+ '' + usuario_id;
					iteral_pedido_divisible
				}	

 			var html_producto =
 			'<tr>'+
                '<td>'+producto+'</td>'+
                '<td class="right">$ '+formatMoney(precio_producto,0,',','.')+'</td>'+
                '<td class="center">'+cant_producto+'</td>'+
                '<td class="right">$ '+formatMoney(total_producto,0,',','.')+'</td>'+
            '</tr>';

            total_cuenta = parseInt(total_cuenta) + parseInt(total_producto);
            $('.producto_select_cuenta').append(html_producto);
            iteral_pedido ++;
 		});	
 			$('#VoucherEspecificoIdPedido').val(id_pedido);

	 		var propina = parseInt( total_cuenta * 0.1 );
	 		var total_pagar = parseInt( total_cuenta * 1.1 );

	 		$('#VoucherEspecificoUsuarioProductoDivisible').val(cliente_producto_divisible);
	 		$('#VoucherEspecificoMontoVoucher').val(total_cuenta);
	 		$('#VoucherEspecificoMontoComandaRestante').val(parseInt( monto_original_comanda - total_cuenta));
	 		$('#VoucherEspecificoPropina').val(propina);
	 		$('#VoucherEspecificoProductoDivisible').val(voucher_con_divisible);
	 		$('#VoucherEspecificoIdUsuarioDivisible').val(lista_cliente_pago_producto_divisible);
	 		$('#VoucherEspecificoCantUsuarioPagoDivisible').val(cant_cliente_pago_divisible);

	 		$('.cuenta_usuario').html(formatMoney(total_cuenta,0,',','.'));
	 		$('.propina_usuario').html(formatMoney(propina,0,',','.'));
	 		$('.total_cuenta_usuario').html(formatMoney(total_pagar,0,',','.'));
	 		$('.cliente-cuenta').html(cliente);

	 		inicializarIziModal( 'modalGenerarCuenta' );
	 		$('#modalGenerarCuenta').removeClass('ocultar');
	 		$('#modalGenerarCuenta').iziModal('open');
 	}

 	if (  opcion_cuenta == 3 ){

 		$('.producto_select_cuenta').html('');
 		$('.cliente-cuenta').html('CUENTA POR PRODUCTOS');
 		$('#VoucherEspecificoTipoCuenta').val(opcion_cuenta);

 		var total_cuenta 	=	0;
 		var propina 		=	0;
 		var iteral_pedido 	=	0;
 		var iteral_pedido_divisible 	=	0;
 		var lista_cliente_pago_producto_divisible = '';
 		var voucher_con_divisible = false;
 		var cant_cliente_pago_divisible = 0;
 		var cliente_producto_divisible = '';

 		$('.checkbox_producto_select').each(function(index){

 			if ($(this).prop('checked')){

 				var producto 			= 	$(this).attr('producto');
 				var producto_id 		=	$(this).attr('producto_id');
	 			var precio_producto 	=	$(this).attr('precio_producto');	
	 			var cant_producto 		=	$(this).attr('cant_producto');	
	 			var total_producto 	 	=	$(this).attr('total_producto');	
	 			var pedido 				=	$(this).attr('pedido');
	 			var divisible 			=	$(this).attr('producto_divisible');
 				var usuario_id 			=	$(this).attr('usuario_id');

 				id_pedido				+=	( iteral_pedido == 0 ? '' : ',')+ '' + pedido;
 				if (divisible == true ){
 					voucher_con_divisible = true;
 					cant_cliente_pago_divisible ++;
 					cliente_producto_divisible += ( iteral_pedido_divisible == 0 ? '' : '|')+ '' + usuario_id+','+producto_id;
 					lista_cliente_pago_producto_divisible	+=	( iteral_pedido_divisible == 0 ? '' : '|')+ '' + usuario_id;
 					iteral_pedido_divisible ++;
 				}

	 			var html_producto		=	'<tr>'+
                                                '<td>'+producto+'</td>'+
                                                '<td class="right">$ '+formatMoney(precio_producto,0,',','.')+'</td>'+
                                                '<td class="center">'+cant_producto+'</td>'+
                                                '<td class="right">$ '+formatMoney(total_producto,0,',','.')+'</td>'+
                                            '</tr>';

                total_cuenta = parseInt(total_cuenta) + parseInt(total_producto);
                $('.producto_select_cuenta').append(html_producto);
                iteral_pedido ++;
 			}
 		});

 			$('#VoucherEspecificoIdPedido').val(id_pedido);

 			var propina = parseInt( total_cuenta * 0.1 );
	 		var total_pagar = parseInt( total_cuenta * 1.1 );

	 		$('#VoucherEspecificoUsuarioProductoDivisible').val(cliente_producto_divisible);
	 		$('#VoucherEspecificoMontoVoucher').val(total_cuenta);
	 		$('#VoucherEspecificoMontoComandaRestante').val(parseInt( monto_original_comanda - total_cuenta));
	 		$('#VoucherEspecificoPropina').val(propina);
	 		$('#VoucherEspecificoProductoDivisible').val(voucher_con_divisible);
	 		$('#VoucherEspecificoIdUsuarioDivisible').val(lista_cliente_pago_producto_divisible);
	 		$('#VoucherEspecificoCantUsuarioPagoDivisible').val(cant_cliente_pago_divisible);

	 		$('.cuenta_usuario').html(formatMoney(total_cuenta,0,',','.'));
	 		$('.propina_usuario').html(formatMoney(propina,0,',','.'));
	 		$('.total_cuenta_usuario').html(formatMoney(total_pagar,0,',','.'));
	 		$('.nombre_cliente').html(cliente);

	 		inicializarIziModal( 'modalGenerarCuenta' );
	 		$('#modalGenerarCuenta').removeClass('ocultar');
	 		$('#modalGenerarCuenta').iziModal('open');
 	}
}

function eliminaAgdo(paso, itemComanda){
	infoComentario=$('.Pedido'+itemComanda+'nombres_agregados').val();
	infoAgregado=$('.Pedido'+itemComanda+'agregados').val();
	infoAgregadoMto=$('.Pedido'+itemComanda+'total_agregados').val();
	//alert(infoAgregado);
	var infoComentario=infoComentario.split('|');
	var infoAgregado=infoAgregado.split('|');
	var infoAgregadoMto=infoAgregadoMto.split('|');	
	//alert(infoAgregado);
	infoComentario.splice(paso,1);
	infoAgregado.splice(paso,1);
	infoAgregadoMto.splice(paso,1);
	//alert(infoAgregado);
	var infoComentario=infoComentario.join('|');
	var infoAgregado=infoAgregado.join('|');
	var infoAgregadoMto=infoAgregadoMto.join('|');
	//alert(infoAgregado);
	$('.Pedido'+itemComanda+'nombres_agregados').val(infoComentario);
	$('.Pedido'+itemComanda+'agregados').val(infoAgregado);
	$('.Pedido'+itemComanda+'total_agregados').val(infoAgregadoMto);

	$('.tablaAgdo').remove();
	$('.tablaTotal').remove();
	recalculaModalAgdos(itemComanda);
	
}

function recalculaModalAgdos(itemProductoAgregado){

	infoComentario=$('.Pedido'+itemProductoAgregado+'nombres_agregados').val();
	infoAgregado=$('.Pedido'+itemProductoAgregado+'agregados').val();
	infoAgregadoMto=$('.Pedido'+itemProductoAgregado+'total_agregados').val();
	var infoComentario=infoComentario.split('|');
	var infoAgregado=infoAgregado.split('|');
	var infoAgregadoMto=infoAgregadoMto.split('|');
	var totalAgregados=infoAgregadoMto.reduce(function(a, b){ a=parseInt(a); b=parseInt(b); return a + b; });
	var iteral = infoAgregado.length;
	for (paso = 0; paso < iteral; paso++) {
		
		var valorAgdo=infoAgregadoMto[paso];
    	var itemsAgregados=
    		'<tr class="tablaAgdo">'+
    			'<td><label class="switch"><input type="checkbox" checked onclick="eliminaAgdo('+paso +','+ itemProductoAgregado +');"><span></span></label></td>'+
    			'<td>'+infoComentario[paso]+'</td>'+
    			'<td>$'+formatMoney(valorAgdo,0,',','.')+'</td>'+
    		'</tr>';
      
      $('.detalleAgregados').append(itemsAgregados);
        
    };
    var finalItemsAgregados=
    	'<tr class="tablaTotal">'+
    		'<td colspan="2">Total Agregados</td>'+
    		'<td>$<div id=totalAgregados>'+formatMoney(totalAgregados,0,',','.')+'</div></td>'+
    	'</tr>';
    $('.detalleAgregados').append(finalItemsAgregados);	
}

function finalizaAgregados(){
	$('.tablaAgdo').remove();
	$('.tablaTotal').remove();
}

function totalCuentaProductos()
{
	var total_cuenta = 0;
	$('.checkbox_producto_select').each(function(index){
		if ($(this).prop('checked')){
			var total_producto 	 	=	$(this).attr('total_producto');	
			total_cuenta = parseInt(total_cuenta) + parseInt(total_producto);
		}
		 $('.total-cuenta-producto').html(formatMoney(total_cuenta,0,',','.'));
	});
}

/**
 * [agregarProductoComanda description]
 * Funcion que permite agregar un pedido a la comanda, asignandolo a un cliente determinado
 */
function agregarProductoComanda(cliente_comanda_select, iteral_producto_comanda, id_producto_carta,nombre_producto_carta,iteral_cliente_comanda,valor_producto_carta, producto_divisible, impresion_id)
{
	/**
	 * Se revisa si el producto ya esta agregado al cliente impresion_id
	 */

	if( $('#iteral_producto_cliente_'+id_producto_carta+''+cliente_comanda_select).length ){
		var cant_actual 	=	$('#cantidad_producto_carta_'+id_producto_carta+''+cliente_comanda_select).attr('cant');
		var cant_nueva		=	parseInt(cant_actual) + 1;

		//Limite de cantidad de producto carta = 50
		if(cant_nueva <= 50){
			//var total =	parseFloat(valor_producto_carta) * parseFloat(cant_nueva);
			actualizaCant(cant_nueva, id_producto_carta, cliente_comanda_select, valor_producto_carta);


				//$('.cantidad_producto_carta_'+id_producto_carta+''+cliente_comanda_select).html('('+cant_nueva+')');
			//$('#cantidad_producto_carta_'+id_producto_carta+''+cliente_comanda_select).attr('cant', cant_nueva);
			//$("#cantidad_producto_carta_select_"+id_producto_carta+""+cliente_comanda_select).val(cant_nueva);
				//$('.cantidad_producto_carta_input_'+id_producto_carta+''+cliente_comanda_select).val(cant_nueva);
			//$('.total_producto_carta_input_'+id_producto_carta+''+cliente_comanda_select).val(total);
		}
	}
	else{
		var item_producto_comanda =
		'<tr class="tr_producto_carta" iteral_producto="'+iteral_producto_comanda+'" iteral_cliente="'+cliente_comanda_select+'" id="iteral_producto_cliente_'+id_producto_carta+''+cliente_comanda_select+'">'+
    		'<td width="10%" class="center" id="cantidad_producto_carta_'+id_producto_carta+''+cliente_comanda_select+'" cant="1">'+
        		'<select id="cantidad_producto_carta_select_'+id_producto_carta+''+cliente_comanda_select+'" name="Pedido['+iteral_producto_comanda+'][cantidad]" class="form-control select campo_cantidad" data-live-search="true" onchange="actualizaCant(this.value, '+id_producto_carta+', '+cliente_comanda_select+', '+valor_producto_carta+')">'+
            		'<option value="1" selected>1</option>'+
            		'<option value="2">2</option>'+
            		'<option value="3">3</option>'+
            		'<option value="4">4</option>'+
            		'<option value="5">5</option>'+
            		'<option value="6">6</option>'+
            		'<option value="7">7</option>'+
            		'<option value="8">8</option>'+
            		'<option value="9">9</option>'+
            		'<option value="10">10</option>'+
            		'<option value="11">11</option>'+
            		'<option value="12">12</option>'+
            		'<option value="13">13</option>'+
            		'<option value="14">14</option>'+
            		'<option value="15">15</option>'+
            		'<option value="16">16</option>'+
            		'<option value="17">17</option>'+
            		'<option value="18">18</option>'+
            		'<option value="19">19</option>'+
            		'<option value="20">20</option>'+
            		'<option value="21">21</option>'+
            		'<option value="22">22</option>'+
            		'<option value="23">23</option>'+
            		'<option value="24">24</option>'+
            		'<option value="25">25</option>'+
            		'<option value="26">26</option>'+
            		'<option value="27">27</option>'+
            		'<option value="28">28</option>'+
            		'<option value="29">29</option>'+
            		'<option value="30">30</option>'+
            		'<option value="31">31</option>'+
            		'<option value="32">32</option>'+
            		'<option value="33">33</option>'+
            		'<option value="34">34</option>'+
            		'<option value="35">35</option>'+
            		'<option value="36">36</option>'+
            		'<option value="37">37</option>'+
            		'<option value="38">38</option>'+
            		'<option value="39">39</option>'+
            		'<option value="40">40</option>'+
            		'<option value="41">41</option>'+
            		'<option value="42">42</option>'+
            		'<option value="43">43</option>'+
            		'<option value="44">44</option>'+
            		'<option value="45">45</option>'+
            		'<option value="46">46</option>'+
            		'<option value="47">47</option>'+
            		'<option value="48">48</option>'+
            		'<option value="49">49</option>'+
            		'<option value="50">50</option>'+
        		'</select>'+
    		'</td>'+
    		'<td width="30%">'+nombre_producto_carta+'</td>'+
   			'<td width="0%"><table><tr><td><img src="/img/add.png" class="abreModal" itemAgregado="'+iteral_producto_comanda+'" alt="Agregados"></td><td><button type="button" class="btn btn-primary btn-condensed abreModal2" itemAgregado2="'+iteral_producto_comanda+'"><i class="fa fa-cog"></i></button></td></tr></table></td>'+
   			'<td width="38%"><input type="text" class="form-control" value="" id="Pedido['+iteral_producto_comanda+'][comentario]" name="Pedido['+iteral_producto_comanda+'][comentario]" /></td>'+	
    		'<td width="0%" colspan="2" class="icon_actions center">'+
    			// Registro_local_id
    			'<input type="hidden" class="registro_local_id_ciente_comanda_insert_input_'+iteral_producto_comanda+'" value="'+registro_local_id+'" id="Pedido['+iteral_producto_comanda+'][registro_local_id]" name="Pedido['+iteral_producto_comanda+'][registro_local_id]" />'+
    			// tipo
    			'<input type="hidden" class="tipo_comanda_insert_input_'+iteral_producto_comanda+'" value="1" id="Pedido['+iteral_producto_comanda+'][tipo]" name="Pedido['+iteral_producto_comanda+'][tipo]" />'+
    			// nombre del cliente
    			'<input type="hidden" class="nombre_ciente_comanda_insert_input_'+iteral_producto_comanda+'" value="'+cliente_select_add+'" id="Pedido['+iteral_producto_comanda+'][nombre]" name="Pedido['+iteral_producto_comanda+'][nombre]" />'+
    			// id generado del cliente
    			'<input type="hidden" class="id_ciente_comanda_insert_input_'+iteral_producto_comanda+'" value="'+cliente_comanda_select+'" id="Pedido['+iteral_producto_comanda+'][id_cliente]" name="Pedido['+iteral_producto_comanda+'][id_cliente]" />'+
    			// id generado del cliente
    			'<input type="hidden" class="id_usuario_comanda_insert_input_'+iteral_producto_comanda+'" value="'+usuario_session_id+'" id="Pedido['+iteral_producto_comanda+'][usuario_id]" name="Pedido['+iteral_producto_comanda+'][usuario_id]" />'+
    			//input id producto
    		 	'<input type="hidden" value="'+id_producto_carta+'" id="Pedido['+iteral_producto_comanda+'][producto_carta_id]" name="Pedido['+iteral_producto_comanda+'][producto_carta_id]" />'+
    		 	//input nombre producto
    		 	'<input type="hidden" value="'+nombre_producto_carta+'" id="Pedido['+iteral_producto_comanda+'][producto]" name="Pedido['+iteral_producto_comanda+'][producto]" />'+
    		 	'<input type="hidden" value="'+impresion_id+'" id="Pedido['+iteral_producto_comanda+'][lugar_impresion]" name="Pedido['+iteral_producto_comanda+'][lugar_impresion]" />'+
    		 	'<input type="hidden" class="Pedido'+iteral_producto_comanda+'agregados" value="" id="Pedido['+iteral_producto_comanda+'][agregados]" name="Pedido['+iteral_producto_comanda+'][agregados]" />'+
    		 	'<input type="hidden" class="Pedido'+iteral_producto_comanda+'total_agregados" value="" id="Pedido['+iteral_producto_comanda+'][total_agregados]" name="Pedido['+iteral_producto_comanda+'][total_agregados]" />'+
    		 	'<input type="hidden" class="Pedido'+iteral_producto_comanda+'nombres_agregados" value="" id="Pedido['+iteral_producto_comanda+'][nombres_agregados]" name="Pedido['+iteral_producto_comanda+'][nombres_agregados]" />'+
    		 	//input cantidad
    		 	//'<input type="hidden" class="cantidad_producto_carta_input_'+id_producto_carta+''+cliente_comanda_select+' campo_cantidad" value="1" id="Pedido['+iteral_producto_comanda+'][cantidad]" name="Pedido['+iteral_producto_comanda+'][cantidad]" />'+
    		 	//input precio
    		 	'<input type="hidden" class="precio_producto_carta_input_'+id_producto_carta+''+cliente_comanda_select+'" value="'+valor_producto_carta+'" id="Pedido['+iteral_producto_comanda+'][precio]" name="Pedido['+iteral_producto_comanda+'][precio]" />'+
    		 	//input divisible
    		 	'<input type="hidden" value="'+producto_divisible+'" id="Pedido['+iteral_producto_comanda+'][divisible]" name="Pedido['+iteral_producto_comanda+'][divisible]" />';
    		 	if ( producto_divisible == 1 ){
    		 		//input cantidad usuarios divisibles divisible
    		 		item_producto_comanda	+= '<input type="hidden" class="cant_usuario_divisible" value="" id="Pedido['+iteral_producto_comanda+'][cant_divisible]" name="Pedido['+iteral_producto_comanda+'][cant_divisible]" />'+
    		 		//input cantidad usuarios divisibles restante divisible
    		 		'<input type="hidden" class="cant_usuario_divisible" value="" id="Pedido['+iteral_producto_comanda+'][cant_divisible_restante]" name="Pedido['+iteral_producto_comanda+'][cant_divisible_restante]" />';
    		 	}
    		 	
    		 	//input total
    		 	item_producto_comanda	+= '<input type="hidden" class="total_producto_carta_input_'+id_producto_carta+''+cliente_comanda_select+' campo_total_producto" value="'+valor_producto_carta+'" id="Pedido['+iteral_producto_comanda+'][total]" name="Pedido['+iteral_producto_comanda+'][total]" />'+
    		 	// Aumentar cantidad producto
    			'<!--<img src="/img/mas.png" class="addCantProducto" itemIcon="'+id_producto_carta+''+cliente_comanda_select+'" alt="Aumentar Cantidad">'+ 
    			// Disminuir cantidad producto
    			'<img src="/img/menos.png" class="restCantProducto" itemIcon="'+id_producto_carta+''+cliente_comanda_select+'" alt="Disminuir Cantidad">-->'+ 
    			// Eliminar cantidad 
    			'<img src="/img/delete_item.png" class="deleteProducto" itemIcon="'+id_producto_carta+''+cliente_comanda_select+'" alt="Eliminar Producto">'+
    		'</td>'+
		'</tr>';

   		$('.tbody_cliente_'+cliente_comanda_select).append(item_producto_comanda);
	}
	//selectProductoCarta
	obtenerTotalesProductos();
	$("#selectProductoCarta").val('default');
	$("#selectProductoCarta").selectpicker("refresh");
}

function insertaAgregado(id, nombre, precio){
	//alert(id);
	//alert(nombre);
	//alert(precio);
	itemProductoAgregado=$('#selectProducto').val();
	infoComentario=$('.Pedido'+itemProductoAgregado+'nombres_agregados').val();
	infoAgregado=$('.Pedido'+itemProductoAgregado+'agregados').val();
	infoAgregadoMto=$('.Pedido'+itemProductoAgregado+'total_agregados').val();
	if(infoComentario==''){
		//$('#Pedido['+itemProductoAgregado+'][comentario]').val(nombre);
		cdnComentario=nombre;
	}else{
		cdnComentario=infoComentario + '|' + nombre;
		//$('#Pedido['+itemProductoAgregado+'][comentario]').val(dataComentario);
	}
	if(infoAgregado==''){
		cdnaAgdo=id;
		//$('#Pedido['+itemProductoAgregado+'][agregados]').val(infoAgregado)
	}else{
		cdnaAgdo=infoAgregado + '|' + id;
		//$('#Pedido['+itemProductoAgregado+'][agregados]').val(dataAgdo)
	}
	if(infoAgregadoMto==''){
		cdnaAgdoMto=precio;
		//$('#Pedido['+itemProductoAgregado+'][total_agregados]').val(infoAgregadoMto)
	}else{
		cdnaAgdoMto=infoAgregadoMto + '|' + precio;
		//$('#Pedido['+itemProductoAgregado+'][total_agregados]').val(dataAgdoMonto);
	}
	$('.Pedido'+itemProductoAgregado+'nombres_agregados').val(cdnComentario);
	$('.Pedido'+itemProductoAgregado+'agregados').val(cdnaAgdo);
	$('.Pedido'+itemProductoAgregado+'total_agregados').val(cdnaAgdoMto);

}

/** [obtenerTotalesProductos description] */
function obtenerTotalesProductos()
{
	// Total de productos
	var cantidad_productos = 0;
	$( ".campo_cantidad" ).each(function( index ) {
	  var cantidad  = $(this).val();
	  cantidad_productos += parseInt(cantidad);
	});

	cant_productos_comanda = parseInt(cantidad_productos) + parseInt(cant_productos);
	$('#ComandaCantProductos').val(cant_productos_comanda);

}
/** [obtenerCantidadCliente description] */
function obtenerCantidadCliente()
{
	var cantidad_clientes 	= 	$( ".fila_cliente" ).length;
	cant_clientes_comanda = cantidad_clientes;
	$('#ComandaCantUsuarios').val(cant_clientes_comanda);
	$('.cant_usuario_divisible').val(cant_clientes_comanda);
}

function cadenaClientes()
{
	var nombres_clientes	=	'';
	var id_clientes			=	'';
	$('.campo_nombre_cliente_comanda').each(function(index_cliente){
		var nombre_cliente 	=	$(this).val();
		var input_cliente_comanda = $(this).attr('input_cliente_comanda');
		if ( parseInt(index_cliente) > 0 ){
			nombres_clientes += '|';
			id_clientes += '|';
		}
		nombres_clientes += (parseInt(input_cliente_comanda)+'.'+nombre_cliente);
		id_clientes		 += parseInt(input_cliente_comanda); 
		$('#ComandaUsuario').val(nombres_clientes);
		$('#ComandaIdUsuario').val(id_clientes);
	});
}

function actualizaCant(cant, id_producto_carta, cliente_comanda_select, valor_producto_carta){
	var total =	parseFloat(valor_producto_carta) * parseFloat(cant);
	obtenerTotalesProductos();
	$("#cantidad_producto_carta_"+id_producto_carta+""+cliente_comanda_select).attr('cant',cant);
	$("#cantidad_producto_carta_select_"+id_producto_carta+""+cliente_comanda_select).val(cant);
	$('.cantidad_producto_carta_input_'+id_producto_carta+''+cliente_comanda_select).val(cant);
	$('.total_producto_carta_input_'+id_producto_carta+''+cliente_comanda_select).val(total);
}

function detalleCombo(id, nombre, precio, impresion){
    comboSeleccionado = id;
    comboSeleccionadoNombre = nombre;
    comboSeleccionadoPrecio = precio;
    comboSeleccionadoImpresion = impresion;
    $("#contenedorBtnDetalleCombo"+id).hide();
    $(".contenedorCombo").hide();
    $("#contenedorCombo"+id).show();
    $("#detalleCombo"+id).show();
    $("#btnReset"+id).show();
}
function resetModalCombos(){
    $(".detalleCombo").hide();
    $(".contenedorCombo").show();
    $(".contenedorBtnDetalleCombo").show();
    $("body").css("overflow","scroll");
    $("#detalleArmadoCombo"+comboSeleccionado).html("");
    $("#detalleTotalCombo"+comboSeleccionado).html("");
    
    comboSeleccionado = null;
    comboSeleccionadoNombre = null;
    comboSeleccionadoPrecio = 0;
}
function agregaCombo(){
    var indice = comboSeleccionado;
    var impresion = comboSeleccionadoImpresion;
    
    
    if(indice != null){
        configurarCombo(indice, impresion);
    }
    else{
        $('.texto-alerta-js').html('Debes seleccionar un combo.');
        $('#alerta_monto_pago_superior').addClass('open');
    }
}
function configurarCombo(idCombo, impresion){
    if(comboSeleccionado != null){
    	if(validaSeleccionProductosCategorias(comboSeleccionado)){
    		var productosIds = '';
	        var productosNombres = '';
	        var nombresProductos = '';
	        var reccoriendo = 0;
	        var totalInputs = $(".inputCombo"+idCombo+":checked").length;
	        $(".inputCombo"+idCombo+":checked").each(function(k, v){
	            var seleccionado = $(v).is(':checked');
	            if(seleccionado){
	                productosIds += $(v).val();
	                nombresProductos += $(v).attr("nombre_producto");
	                productosNombres += $(v).attr("nombre_producto");
	                if( (reccoriendo + 1) != totalInputs){
	                    productosIds += '|';
	                    nombresProductos += '|';
	                    productosNombres += ', ';
	                }
	                reccoriendo++;
	            }
	        });
	        
	        if(productosIds != ''){
	            if($(".seleccion_cliente").length > 0){
	                $(".seleccion_cliente").each(function(){
	                    var seleccionado = $(this).attr('cliente_seleccionado');
	                    if(seleccionado == "true"){
	                        var clienteSeleccionado = $(this).attr('numero_cliente');
	                        agregarComboCliente(idCombo, clienteSeleccionado, productosIds, productosNombres, impresion);
	                        return false;
	                    }
	                });
	            }
	            else{
	                $('.texto-alerta-js').html('Por favor selecciona un cliente al cual asigar el combo.');
	                $('#alerta_monto_pago_superior').addClass('open');
	            }
	        }
	        else{
	            $('.texto-alerta-js').html('Por favor selecciona los productos que tendra el combo.');
	            $('#alerta_monto_pago_superior').addClass('open');
	        }
    	}
    }
    else{
        resetModalCombos();
        $('.texto-alerta-js').html('Por favor selecciona un combo.');
        $('#alerta_monto_pago_superior').addClass('open');
    }
}

function agregarComboCliente(idCombo, clienteSeleccionado, productosIds, productosNombres, impresion){
    //Obtengo el valor total del combo, sumando los valores adicionales
    var totalComboAdicional = parseFloat(obtenerTotalCombo(idCombo, comboSeleccionadoPrecio));
    
    var comboDivisible = 0;
    iteral_producto_comanda++;
    
    var item_producto_comanda =
    '<tr class="tr_producto_carta" iteral_producto="'+iteral_producto_comanda+'" iteral_cliente="'+clienteSeleccionado+'" id="iteral_producto_cliente_combo_'+idCombo+''+clienteSeleccionado+'">'+
        '<td width="2%" class="center" id="cantidad_combo_'+idCombo+''+clienteSeleccionado+'" cant="1">'+
            '<select name="Pedido['+iteral_producto_comanda+'][cantidad]" class="form-control select campo_cantidad" data-live-search="true">'+
        		'<option value="1" selected>1</option>'+
        		'<option value="2">2</option>'+
        		'<option value="3">3</option>'+
        		'<option value="4">4</option>'+
        		'<option value="5">5</option>'+
        		'<option value="6">6</option>'+
        		'<option value="7">7</option>'+
        		'<option value="8">8</option>'+
        		'<option value="9">9</option>'+
        		'<option value="10">10</option>'+
        		'<option value="11">11</option>'+
        		'<option value="12">12</option>'+
        		'<option value="13">13</option>'+
        		'<option value="14">14</option>'+
        		'<option value="15">15</option>'+
        		'<option value="16">16</option>'+
        		'<option value="17">17</option>'+
        		'<option value="18">18</option>'+
        		'<option value="19">19</option>'+
        		'<option value="20">20</option>'+
        		'<option value="21">21</option>'+
        		'<option value="22">22</option>'+
        		'<option value="23">23</option>'+
        		'<option value="24">24</option>'+
        		'<option value="25">25</option>'+
        		'<option value="26">26</option>'+
        		'<option value="27">27</option>'+
        		'<option value="28">28</option>'+
        		'<option value="29">29</option>'+
        		'<option value="30">30</option>'+
        		'<option value="31">31</option>'+
        		'<option value="32">32</option>'+
        		'<option value="33">33</option>'+
        		'<option value="34">34</option>'+
        		'<option value="35">35</option>'+
        		'<option value="36">36</option>'+
        		'<option value="37">37</option>'+
        		'<option value="38">38</option>'+
        		'<option value="39">39</option>'+
        		'<option value="40">40</option>'+
        		'<option value="41">41</option>'+
        		'<option value="42">42</option>'+
        		'<option value="43">43</option>'+
        		'<option value="44">44</option>'+
        		'<option value="45">45</option>'+
        		'<option value="46">46</option>'+
        		'<option value="47">47</option>'+
        		'<option value="48">48</option>'+
        		'<option value="49">49</option>'+
        		'<option value="50">50</option>'+
    		'</select>'+
        '</td>'+
        '<td width="30%">'+comboSeleccionadoNombre+'</td>'+
        '<td></td>'+
        '<td width="38%">'+
            '<input type="text" class="form-control" value="'+productosNombres+'" id="Pedido['+iteral_producto_comanda+'][comentario]" name="Pedido['+iteral_producto_comanda+'][comentario]" />'+
        '</td>'+
        '<td width="30%" colspan="2" class="icon_actions center">'+
            // Cantidad de productos
            //'<input type="hidden" value="1" id="Pedido['+iteral_producto_comanda+'][cantidad]" name="Pedido['+iteral_producto_comanda+'][cantidad]" class="campo_cantidad" />'+
        
            // Registro_local_id
            '<input type="hidden" value="'+registro_local_id+'" id="Pedido['+iteral_producto_comanda+'][registro_local_id]" name="Pedido['+iteral_producto_comanda+'][registro_local_id]" />'+
            
            // tipo
            '<input type="hidden" value="1" id="Pedido['+iteral_producto_comanda+'][tipo]" name="Pedido['+iteral_producto_comanda+'][tipo]" />'+
            
            // nombre del cliente
            '<input type="hidden" value="'+cliente_select_add+'" id="Pedido['+iteral_producto_comanda+'][nombre]" name="Pedido['+iteral_producto_comanda+'][nombre]" />'+
            
            // id generado del cliente
            '<input type="hidden" value="'+clienteSeleccionado+'" id="Pedido['+iteral_producto_comanda+'][id_cliente]" name="Pedido['+iteral_producto_comanda+'][id_cliente]" />'+
            
            // id generado del cliente
            '<input type="hidden" value="'+usuario_session_id+'" id="Pedido['+iteral_producto_comanda+'][usuario_id]" name="Pedido['+iteral_producto_comanda+'][usuario_id]" />'+
            
            //input id producto
            '<input type="hidden" value="'+idCombo+'" id="Pedido['+iteral_producto_comanda+'][producto_carta_id]" name="Pedido['+iteral_producto_comanda+'][producto_carta_id]" />'+
            
            //detalle_combo
            '<input type="hidden" value="'+productosIds+'" id="Pedido['+iteral_producto_comanda+'][detalle_combo]" name="Pedido['+iteral_producto_comanda+'][detalle_combo]" />'+
            
            //Combo ID
            '<input type="hidden" value="'+idCombo+'" id="Pedido['+iteral_producto_comanda+'][producto_combo_id]" name="Pedido['+iteral_producto_comanda+'][producto_combo_id]" />'+

            //IMPRESION ID
            '<input type="hidden" value="'+impresion+'" id="Pedido['+iteral_producto_comanda+'][lugar_impresion]" name="Pedido['+iteral_producto_comanda+'][lugar_impresion]" />'+
            
            //input nombre producto
            '<input type="hidden" value="'+comboSeleccionadoNombre+'" name="Pedido['+iteral_producto_comanda+'][producto]" />'+
            
            //input precio
            '<input type="hidden" value="'+totalComboAdicional+'" name="Pedido['+iteral_producto_comanda+'][precio]" />'+
            
            //input divisible
            '<input type="hidden" value="'+comboDivisible+'" name="Pedido['+iteral_producto_comanda+'][divisible]" />';
            if ( comboDivisible == 1 ){
                //input cantidad usuarios divisibles divisible
                item_producto_comanda	+= '<input type="hidden" class="cant_usuario_divisible" value="" id="Pedido['+iteral_producto_comanda+'][cant_divisible]" name="Pedido['+iteral_producto_comanda+'][cant_divisible]" />'+
                //input cantidad usuarios divisibles restante divisible
                '<input type="hidden" class="cant_usuario_divisible" value="" id="Pedido['+iteral_producto_comanda+'][cant_divisible_restante]" name="Pedido['+iteral_producto_comanda+'][cant_divisible_restante]" />';
            }
            
            //input total
            item_producto_comanda	+= '<input type="hidden" value="'+totalComboAdicional+'" name="Pedido['+iteral_producto_comanda+'][total]" />'+
            
            // Eliminar cantidad 
            '<img src="/img/delete_item.png" class="deleteProductoCombo" itemIcon="'+idCombo+''+clienteSeleccionado+'" alt="Eliminar Producto">'+
    '</td>'+
    '</tr>';

    $('.tbody_cliente_'+clienteSeleccionado).append(item_producto_comanda);
    obtenerTotalesProductos();
    $("#modalAddMesa").iziModal("close");
}
function detalleArmadoCombo(keyProducto, idCombo, idProducto, tipoCategoria, precioCombo){
    var seleccionado    = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).is(":checked");
    var categoriaId     = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("categoria_id");
    var categoriaNombre = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("nombre_categoria");
    var productoNombre  = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("nombre_producto");
    var agregado        = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("valor_agregado");
    var valor_agregado  = parseInt(agregado);
    var totalCombo      = parseFloat(precioCombo);
    var idContenedorDetalleProductoCombo = 'infoProducto'+keyProducto+'Categoria'+categoriaId+'Combo'+idCombo;
    
    if(seleccionado){
        //Existe el contenedor de la categoria actual? Si no existe, lo creo
        if(!$("#contenedorCombo"+idCombo+"Categoria"+categoriaId).length){
            var contenedorComboCategoria = '\
            <div class="col-md-12" style="margin-bottom: 10px;" id="contenedorCombo'+idCombo+'Categoria'+categoriaId+'">\n\
                <div class="col-md-12">\n\
                    <center><label>'+categoriaNombre+'</label></center>\n\
                </div>\n\
                <div class="row" id="contenedorProductosCombo'+idCombo+'Categoria'+categoriaId+'"></div>\n\
            </div>';
            $("#detalleArmadoCombo"+idCombo).append(contenedorComboCategoria);
        }
        
        var contenidoAgregado = '';
        if(valor_agregado > 0){
            var agregado_money = formatMoney(valor_agregado,0,',','');
            contenidoAgregado = '$ <span style="float: right" class="valorAdicionalCombo'+idCombo+'">'+agregado_money+'</span>';
        }

        //Si el prodcuto seleccionado no esta agregado al detalle del combo, lo agrego
        if(!$("#"+idContenedorDetalleProductoCombo).length){
            var detalleProdcuto = '\
            <div class="row" id="infoProducto'+keyProducto+'Categoria'+categoriaId+'Combo'+idCombo+'">\n\
                <div class="col-md-8">\n\
                    <li>'+productoNombre+'</li>\n\
                </div>\n\
                <div class="col-md-4">'+contenidoAgregado+'</div>\n\
            </div>';
            
            //Si es radiobutton quito el otro radiobutton seleccionado previamente (si es que existe)
            if(!tipoCategoria){
                $("#contenedorProductosCombo"+idCombo+"Categoria"+categoriaId).html("");
            }
            
            $("#contenedorProductosCombo"+idCombo+"Categoria"+categoriaId).append(detalleProdcuto);
        }
    }
    else{
        if($("#"+idContenedorDetalleProductoCombo).length){
            $("#"+idContenedorDetalleProductoCombo).remove();
            
            //Quitar categoria si esta vacia
            var productosAgregados = $("#contenedorProductosCombo"+idCombo+"Categoria"+categoriaId).children().length;
            if(!productosAgregados){
                $("#contenedorCombo"+idCombo+"Categoria"+categoriaId).remove();
            }
        }
    }
    
    //Recorro los productos agregados y sumo los valores adicionales al total del combo
    var totalComboAdicional = obtenerTotalCombo(idCombo, totalCombo);
    var total_combo_money = formatMoney(totalComboAdicional,0,',','.');
    $("#detalleTotalCombo"+idCombo).html('$ <span style="float: right;">'+total_combo_money+'</span>');
}
function obtenerTotalCombo(idCombo, totalCombo){
    var total_adicional = 0;
    if($(".valorAdicionalCombo"+idCombo).length){
        var totalComboAdicional = 0;
        $(".valorAdicionalCombo"+idCombo).each(function(){
            var adicional = parseFloat($(this).html());
            total_adicional += adicional;
        });
    }
    
    var totalComboAdicional = totalCombo + total_adicional;
    return totalComboAdicional;
}
function validaSeleccionProductosCategorias(comboSeleccionado){
	var resultado = true;
	//Recorro las categorias del combo seleccionado
	var categoriasRecorridas = new Array();
	$(".categoriaCombo"+comboSeleccionado).each(function(){
		var categoriaId = $(this).attr("categoria_id");
		var categoriaNombre = $(this).attr("nombre_categoria");
		if($.inArray(categoriaId, categoriasRecorridas) < 0){
			//Agrego el ID de la categoria para no recorrerlo denuevo
			categoriasRecorridas.push(categoriaId);

			//Verifico que al menos uno de los productos de esa categoria este seleccionado
			var productosCategoriaSeleccionados = $(".categoriaCombo"+comboSeleccionado+'Id'+categoriaId+':checked').length;

			if(productosCategoriaSeleccionados == 0){
				$('.texto-alerta-js').html('Por favor selecciona al menos un producto de la categoria "'+categoriaNombre+'".');
    			$('#alerta_monto_pago_superior').addClass('open');
        		resultado = false;
        		return false;
			}
		}
	});

	return resultado;
}