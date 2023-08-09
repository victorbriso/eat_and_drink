$( document ).ready(function() { 

	/** AGREFAR INSUMO A RECETA */

	var insumo_text_seleccionado = '';
	var unidad_text_seleccionado = '';
	var insumo_id_seleccionado = '';
	var insumo_agregado_receta = 0;
	var medioPago_agregado_detalle = 0;
	var insumo_agregado_receta2 = 0;

	/**
	 * Se coloca la unidad de salida del insumo, al seleccionarlo
	 */
	$('#productoCartaInsumo').change(function(){
		var id_insumo					= $(this).val();
		var insumo_seleccionado_select 	= $('option:selected', this).text();
		insumo_seleccionado 		=	insumo_seleccionado_select;
		insumo_id_seleccionado		=	id_insumo;

	});

	$('.agregar_producto_pago').on('click', function(){

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
			var dataSelect=insumo_seleccionado.split('-');
			var nombreProducto= dataSelect[0];
			var precioProducto= dataSelect[1];
			var dataId=producto_id.split('-');
			var montoOperacional=dataId[1];

			var total=montoOperacional*cantidad;
			var insumo = '<tr class="insumo_agregado item_insumo_' + insumo_agregado_receta + '">' +
							'<td>' + nombreProducto + '</td> ' +
							'<td>( ' + cantidad +' ) </td>'+ 
							'<td>' + precioProducto + '</td>'+
							'<td>$' + total + '</td>'+
							'<td><span class="icon eliminar_item_producto" item_insumo="'+ insumo_agregado_receta +'" insumo_id_item="'+ insumo_id_seleccionado +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
							'<input type="hidden" name="data[productos]['+ insumo_agregado_receta +'][idProducto]" class="form-control" value="' + dataId[0] + '" id="ProductoReceta'+ insumo_agregado_receta +'unidad_medida_id">'+
							'<input type="hidden" name="data[productos]['+ insumo_agregado_receta +'][producto]" class="form-control" value="' + nombreProducto + '" id="ProductoReceta'+ insumo_agregado_receta +'unidad_medida_id">'+
							'<input type="hidden" name="data[productos]['+ insumo_agregado_receta +'][precio]" class="form-control" value="' + dataId[1] +'" id="ProductoReceta'+ insumo_agregado_receta +'InsumoId">'+
							'<input type="hidden" name="data[productos]['+ insumo_agregado_receta +'][divisible]" class="form-control" value="' + dataId[2] +'" id="ProductoReceta'+ insumo_agregado_receta +'InsumoId">'+
							'<input type="hidden" name="data[productos]['+ insumo_agregado_receta +'][elaboracion]" class="form-control" value="' + dataId[3] +'" id="ProductoReceta'+ insumo_agregado_receta +'InsumoId">'+
							'<input type="hidden" name="data[productos]['+ insumo_agregado_receta +'][cantidad]" class="form-control" value="' + cantidad +'" id="ProductoReceta'+ insumo_agregado_receta +'InsumoId">'+
							'<input type="hidden" name="data[productos]['+ insumo_agregado_receta +'][total]" class="suma" value="' + total +'" id="ProductoReceta'+ insumo_agregado_receta +'Total">'+
						'</tr> ';

			var totalPedidoCobro	= 	document.getElementById('totalPedido').innerHTML;	
			totalPedidoCobro 		= 	parseInt(totalPedidoCobro);				
			var totalPedidoCobro	=	totalPedidoCobro+total;
			document.getElementById('totalPedido').innerHTML = totalPedidoCobro;

			var totalPendiente	= 	document.getElementById('totalPendiente').innerHTML;	
			totalPendiente 		= 	parseInt(totalPendiente);				
			var totalPendiente	=	totalPendiente+total;
			document.getElementById('totalPendiente').innerHTML = totalPendiente;



			$('.insumo-agregado').append(insumo);
			$('.cantidadInsumoSelect').val('1');
			$("#productoCartaInsumo").val('default');
			$("#productoCartaInsumo").selectpicker("refresh");
			insumo_seleccionado 	=	'';
			insumo_id_seleccionado	=	'';
		}
	});

	$('.insumo-agregado').on('click', '.eliminar_item_producto', function(event){
		event.preventDefault();

		var item_eliminar		=	$(this).attr('item_insumo');
		var id_item_eliminar	=	$(this).attr('insumo_id_item');
		var montoEliminacion	=	$('#ProductoReceta'+ item_eliminar +'Total').val();	
		var totalPedidoCobro	= 	document.getElementById('totalPedido').innerHTML;	
		totalPedidoCobro 		= 	parseInt(totalPedidoCobro);				
		var totalPedidoCobro	=	totalPedidoCobro-montoEliminacion;
		document.getElementById('totalPedido').innerHTML = totalPedidoCobro;
		var totalPendiente	= 	document.getElementById('totalPendiente').innerHTML;	
		totalPendiente 		= 	parseInt(totalPendiente);				
		var totalPendiente	=	totalPendiente-montoEliminacion;
		document.getElementById('totalPendiente').innerHTML = totalPendiente;
		

		$('.item_insumo_'+ item_eliminar).remove();
		$('.insumo_select_'+ id_item_eliminar).show();

	});

	$('.agregar_medio_pago1').on('click', function(){

		var efectivoMonto 			= $('#efectivoMonto').val();
		var efectivoMontoCancelado 	= $('#efectivoMontoCancelado').val();
		var efectivoMontoPropina 	= $('#efectivoMontoPropina').val();
		var efectivoMonto 			= efectivoMonto.replace('.', '');
		var efectivoMontoCancelado 	= efectivoMontoCancelado.replace('.', '');
		var efectivoMontoPropina 	= efectivoMontoPropina.replace('.', '');
		var totalPedidoCobro		= 	document.getElementById('totalPedido').innerHTML;

		if(efectivoMontoPropina==''){
			var efectivoMontoPropina 	= 0;
		}

		var efectivoMonto 			= parseInt(efectivoMonto);
		var efectivoMontoCancelado 	= parseInt(efectivoMontoCancelado);
		var efectivoMontoPropina 	= parseInt(efectivoMontoPropina);
		var totalPedidoCobro		= parseInt(totalPedidoCobro);


		if ( efectivoMontoCancelado != '' && efectivoMontoCancelado != null && efectivoMontoCancelado != 0 && totalPedidoCobro != 0 ){
			var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
			totalPendiente 			= 	parseInt(totalPendiente);
			
				if(efectivoMontoCancelado>=(efectivoMonto+efectivoMontoPropina)){
					if(efectivoMonto>=0 && efectivoMontoCancelado>=0 && efectivoMontoPropina>=0){
					$('.insumo_select_'+ insumo_id_seleccionado).hide();
					insumo_agregado_receta2 ++;
					var vueltoEfectivo=efectivoMontoCancelado-efectivoMonto-efectivoMontoPropina;
					
					var detallePago = '<tr class="insumo_agregado item_pago_' + insumo_agregado_receta2 + '">' +
									'<td>Efectivo</td> ' +
									'<td>$' + efectivoMonto +'  </td>'+ 
									'<td>$' + efectivoMontoPropina + '</td>'+
									'<td>$' + vueltoEfectivo + '</td>'+
									'<td>0</td>'+
									'<td><span class="icon eliminar_item_pago" item_pago="'+ insumo_agregado_receta2 +'" insumo_id_item="'+ insumo_agregado_receta2 +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
									'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][tipoPago]" class="form-control" value="1" id="ProductoReceta'+ insumo_agregado_receta2 +'tipoPago"></td>'+
									'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][monto]" class="form-control" value="' + efectivoMonto +'" id="ProductoReceta'+ insumo_agregado_receta2 +'monto">'+
									'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][efectivo]" class="form-control" value="' + efectivoMontoCancelado +'" id="ProductoReceta'+ insumo_agregado_receta2 +'efectivo">'+
									'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][propina]" class="form-control" value="' + efectivoMontoPropina +'" id="ProductoReceta'+ insumo_agregado_receta2 +'propina">'+
									'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vuelto]" class="form-control" value="' + vueltoEfectivo +'" id="ProductoReceta'+ insumo_agregado_receta2 +'vuelto">'+
									'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vueltoTBK]" class="form-control" value="0" id="ProductoReceta'+ insumo_agregado_receta2 +'vueltoTBK">'+
								'</tr> ';
					/*****************************MONTO CANCELADO************************************************/
					var totalCancelado		= 	document.getElementById('totalCancelado').innerHTML;	
					var totalCancelado 		= 	parseInt(totalCancelado);				
					var totalCancelado		=	totalCancelado+parseInt(efectivoMonto);
					document.getElementById('totalCancelado').innerHTML = totalCancelado;
					var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
					totalPendiente 			= 	parseInt(totalPendiente);
					var totalPendiente		=	totalPendiente-parseInt(efectivoMonto);
					document.getElementById('totalPendiente').innerHTML = totalPendiente;
					/*****************************MONTO PROPINAS************************************************/
					var totalPropinas		= 	document.getElementById('totalPropinas').innerHTML;	
					var totalPropinas 		= 	parseInt(totalPropinas);				
					var totalPropinas		=	totalPropinas+parseInt(efectivoMontoPropina);
					document.getElementById('totalPropinas').innerHTML = totalPropinas;
					/*****************************MONTO VUELTO************************************************/
					var vuelto				= 	document.getElementById('vuelto').innerHTML;	
					var vuelto 				= 	parseInt(vuelto);				
					var vuelto				=	vuelto+parseInt(vueltoEfectivo);
					document.getElementById('vuelto').innerHTML = vuelto;
					

					$('.pago-agregado').append(detallePago);
					$("#efectivoMonto").val('default');
					$("#efectivoMontoCancelado").val('default');
					$("#efectivoMontoPropina").val('default');

					insumo_seleccionado 	=	'';
					insumo_id_seleccionado	=	'';
					if(totalCancelado>=totalPendiente){
						document.getElementById('finalizarPosExpress').style.display = 'block';
					}
					}else{
						alert ('Hay uno o mas valores en negativo');
					}
				}else{
					alert ('El monto de efectivo es menor al monto del pago');
					var faltanteEfectivo=parseInt(totalPendiente)+parseInt(efectivoMontoPropina);
					$("#efectivoMonto").val(totalPendiente);
					$("#efectivoMontoCancelado").val(faltanteEfectivo);
					$("#efectivoMontoPropina").val(efectivoMontoPropina);
				}

				
						
		}else{
			alert ('Faltan valores o hay montos mal ingresados');
		}		
	});

	$('.pago-agregado').on('click', '.eliminar_item_pago', function(event){
		event.preventDefault();
		var item_eliminar		=	$(this).attr('item_pago');
		var id_item_eliminar	=	$(this).attr('insumo_id_item');
		/*******************************MONTO CANCELADO**********************************/
		var montoEliminacion	=	$('#ProductoReceta'+ item_eliminar +'monto').val();	
		var totalCancelado		= 	document.getElementById('totalCancelado').innerHTML;	
		totalCancelado 			= 	parseInt(totalCancelado);
		var totalCancelado		=	totalCancelado-parseInt(montoEliminacion);
		var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
		totalPendiente 			= 	parseInt(totalPendiente);
		var totalPendiente		=	totalPendiente+parseInt(montoEliminacion);

		document.getElementById('totalCancelado').innerHTML = totalCancelado;
		document.getElementById('totalPendiente').innerHTML = totalPendiente;
		/*******************************MONTO CANCELADO**********************************/
		var montoEliminacion	=	$('#ProductoReceta'+ item_eliminar +'propina').val();
		var totalPropinas		= 	document.getElementById('totalPropinas').innerHTML;	
		totalPropinas 			= 	parseInt(totalPropinas);	
		var totalPropinas		=	totalPropinas-montoEliminacion;
		document.getElementById('totalPropinas').innerHTML = totalPropinas;
		/*******************************MONTO CANCELADO**********************************/
		var montoEliminacion	=	$('#ProductoReceta'+ item_eliminar +'vuelto').val();
		var vuelto				= 	document.getElementById('vuelto').innerHTML;	
		vuelto 					= 	parseInt(vuelto);	
		var vuelto				=	vuelto-montoEliminacion;
		document.getElementById('vuelto').innerHTML = vuelto;
		/*******************************MONTO CANCELADO**********************************/
		var montoEliminacion	=	$('#ProductoReceta'+ item_eliminar +'vueltoTBK').val();	
		var vueltoTBK			= 	document.getElementById('vueltoTBK').innerHTML;	
		vueltoTBK 				= 	parseInt(vueltoTBK);
		var vueltoTBK			=	vueltoTBK-montoEliminacion;
		document.getElementById('vueltoTBK').innerHTML = vueltoTBK;
		
		var totalPedido		= 	document.getElementById('totalPedido').innerHTML;
		totalPedido 		= 	parseInt(totalPedido);
		var totalCancelado		= 	document.getElementById('totalCancelado').innerHTML;	
		totalCancelado 			= 	parseInt(totalCancelado);
		
		if(parseInt(totalPedido)>parseInt(totalPendiente)){
			document.getElementById('finalizarPosExpress').style.display = 'none';
		}
		


		$('.item_pago_'+ item_eliminar).remove();
		$('.insumo_select_'+ id_item_eliminar).show();

	});

	$('.insumo-agregado').on('click', '.pago', function(event){
		event.preventDefault();

		var item_eliminar		=	$(this).attr('item_insumo');
		var id_item_eliminar	=	$(this).attr('insumo_id_item');
		var montoEliminacion	=	$('#ProductoReceta'+ item_eliminar +'Total').val();	
		var totalPedidoCobro	= 	document.getElementById('totalPedido').innerHTML;	
		totalPedidoCobro 		= 	parseInt(totalPedidoCobro);				
		var totalPedidoCobro	=	totalPedidoCobro-montoEliminacion;
		document.getElementById('totalPedido').innerHTML = totalPedidoCobro;
		//alert(montoEliminacion);

		$('.item_insumo_'+ item_eliminar).remove();
		$('.insumo_select_'+ id_item_eliminar).show();

	});

	$('.insumo-agregado').on('click', '.eliminar_item_insumo', function(event){
		event.preventDefault();
		var item_eliminar		=	$(this).attr('item_insumo');
		var id_item_eliminar	=	$(this).attr('insumo_id_item');

		$('.item_insumo_'+ item_eliminar).remove();
		$('.insumo_select_'+ id_item_eliminar).show();

	});

		$('.agregar_medio_pago2').on('click', function(){

		var debitoMonto 		= $('#debitoMonto').val();
		var debitoOperacion 	= $('#debitoOperacion').val();
		var debitoAutorizacion 	= $('#debitoAutorizacion').val();
		var debitoPropina 		= $('#debitoPropina').val();
		var debitoMonto 		= debitoMonto.replace('.', '');
		var debitoPropina 		= debitoPropina.replace('.', '');
		
		var totalPedidoCobro		= 	document.getElementById('totalPedido').innerHTML;


		if(debitoPropina==''){
			var debitoPropina 	= 0;
		}

		var debitoMonto 			= parseInt(debitoMonto);
		var debitoPropina 			= parseInt(debitoPropina);

		if ( debitoMonto != '' && debitoMonto != null && debitoMonto != 0 && totalPedidoCobro != 0 ){
			var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
			totalPendiente 			= 	parseInt(totalPendiente);
			if ( totalPendiente < debitoMonto ){
				var diferencia=debitoMonto-totalPendiente;
				alert('El monto ingresado es mayor al saldo pendiente de la cuenta en $'+diferencia);
				$("#debitoMonto").val(totalPendiente);
				$("#debitoPropina").val(debitoPropina);
			}else{
				if(debitoMonto>=0 && debitoPropina>=0 ){
				$('.insumo_select_'+ insumo_id_seleccionado).hide();
				insumo_agregado_receta2 ++;
				var vueltoEfectivo=0;
				
				var detallePago = '<tr class="insumo_agregado item_pago_' + insumo_agregado_receta2 + '">' +
								'<td>Débito</td> ' +
								'<td>$' + debitoMonto +'  </td>'+ 
								'<td>$' + debitoPropina + '</td>'+
								'<td>0</td>'+
								'<td>0</td>'+
								'<td><span class="icon eliminar_item_pago" item_pago="'+ insumo_agregado_receta2 +'" insumo_id_item="'+ insumo_agregado_receta2 +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][tipoPago]" class="form-control" value="2" id="ProductoReceta'+ insumo_agregado_receta2 +'tipoPago"></td>'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][monto]" class="form-control" value="' + debitoMonto +'" id="ProductoReceta'+ insumo_agregado_receta2 +'monto">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][debitoOperacion]" class="form-control" value="' + debitoOperacion +'" id="ProductoReceta'+ insumo_agregado_receta2 +'efectivo">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][debitoAutorizacion]" class="form-control" value="' + debitoAutorizacion +'" id="ProductoReceta'+ insumo_agregado_receta2 +'efectivo">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][propina]" class="form-control" value="' + debitoPropina +'" id="ProductoReceta'+ insumo_agregado_receta2 +'propina">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vuelto]" class="form-control" value="0" id="ProductoReceta'+ insumo_agregado_receta2 +'vuelto">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vueltoTBK]" class="form-control" value="0" id="ProductoReceta'+ insumo_agregado_receta2 +'vueltoTBK">'+
							'</tr> ';
				/*****************************MONTO CANCELADO************************************************/
				var totalCancelado		= 	document.getElementById('totalCancelado').innerHTML;	
				var totalCancelado 		= 	parseInt(totalCancelado);				
				var totalCancelado		=	totalCancelado+parseInt(debitoMonto);
				document.getElementById('totalCancelado').innerHTML = totalCancelado;
				var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
				totalPendiente 			= 	parseInt(totalPendiente);
				var totalPendiente		=	totalPendiente-parseInt(debitoMonto);
				document.getElementById('totalPendiente').innerHTML = totalPendiente;
				/*****************************MONTO PROPINAS************************************************/
				var totalPropinas		= 	document.getElementById('totalPropinas').innerHTML;	
				var totalPropinas 		= 	parseInt(totalPropinas);				
				var totalPropinas		=	totalPropinas+parseInt(debitoPropina);
				document.getElementById('totalPropinas').innerHTML = totalPropinas;
				/*****************************MONTO VUELTO************************************************/
				var vuelto				= 	document.getElementById('vuelto').innerHTML;	
				var vuelto 				= 	parseInt(vuelto);				
				var vuelto				=	vuelto+parseInt(vueltoEfectivo);
				document.getElementById('vuelto').innerHTML = vuelto;
				
				

				$('.pago-agregado').append(detallePago);
				$("#debitoMonto").val('default');
				$("#debitoOperacion").val('default');
				$("#debitoAutorizacion").val('default');
				$("#debitoPropina").val('default');
				if(totalCancelado>=totalPendiente){
						document.getElementById('finalizarPosExpress').style.display = 'block';
					}
				}else{
					alert ('Hay uno o mas valores en negativo');
				}
			}			
		}else{
			alert ('Faltan valores o hay montos mal ingresados');
		}		
	});

	$('.agregar_medio_pago3').on('click', function(){

		var creditoMonto 		= $('#creditoMonto').val();
		var creditoOperacion 	= $('#creditoOperacion').val();
		var creditoAutorizacion 	= $('#creditoAutorizacion').val();
		var creditoPropina 		= $('#creditoPropina').val();
		var creditoMonto 		= creditoMonto.replace('.', '');
		var creditoPropina 		= creditoPropina.replace('.', '');
		var totalPedidoCobro		= 	document.getElementById('totalPedido').innerHTML;

		if(creditoPropina==''){
			var creditoPropina 	= 0;
		}

		var creditoMonto 			= parseInt(creditoMonto);
		var creditoPropina 			= parseInt(creditoPropina);

		if ( creditoMonto != '' && creditoMonto != null && creditoMonto != 0 && totalPedidoCobro != 0 ){
			var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
			totalPendiente 			= 	parseInt(totalPendiente);
			if ( totalPendiente < creditoMonto ){
				var diferencia=creditoMonto-totalPendiente;
				alert('El monto ingresado es mayor al saldo pendiente de la cuenta en $'+diferencia);
				$("#creditoMonto").val(totalPendiente);
				$("#creditoPropina").val(debitoPropina);
			}else{
				if(creditoMonto>=0 && creditoPropina>=0 ){
				$('.insumo_select_'+ insumo_id_seleccionado).hide();
				insumo_agregado_receta2 ++;
				var vueltoEfectivo=0;
				
				var detallePago = '<tr class="insumo_agregado item_pago_' + insumo_agregado_receta2 + '">' +
								'<td>Débito</td> ' +
								'<td>$' + creditoMonto +'  </td>'+ 
								'<td>$' + creditoPropina + '</td>'+
								'<td>0</td>'+
								'<td>0</td>'+
								'<td><span class="icon eliminar_item_pago" item_pago="'+ insumo_agregado_receta2 +'" insumo_id_item="'+ insumo_agregado_receta2 +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][tipoPago]" class="form-control" value="3" id="ProductoReceta'+ insumo_agregado_receta2 +'tipoPago"></td>'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][monto]" class="form-control" value="' + creditoMonto +'" id="ProductoReceta'+ insumo_agregado_receta2 +'monto">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][creditoOperacion]" class="form-control" value="' + creditoOperacion +'" id="ProductoReceta'+ insumo_agregado_receta2 +'efectivo">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][creditoAutorizacion]" class="form-control" value="' + creditoAutorizacion +'" id="ProductoReceta'+ insumo_agregado_receta2 +'efectivo">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][propina]" class="form-control" value="' + creditoPropina +'" id="ProductoReceta'+ insumo_agregado_receta2 +'propina">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vuelto]" class="form-control" value="0" id="ProductoReceta'+ insumo_agregado_receta2 +'vuelto">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vueltoTBK]" class="form-control" value="0" id="ProductoReceta'+ insumo_agregado_receta2 +'vueltoTBK">'+
							'</tr> ';
				/*****************************MONTO CANCELADO************************************************/
				var totalCancelado		= 	document.getElementById('totalCancelado').innerHTML;	
				var totalCancelado 		= 	parseInt(totalCancelado);				
				var totalCancelado		=	totalCancelado+parseInt(creditoMonto);
				document.getElementById('totalCancelado').innerHTML = totalCancelado;
				var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
				totalPendiente 			= 	parseInt(totalPendiente);
				var totalPendiente		=	totalPendiente-parseInt(creditoMonto);
				document.getElementById('totalPendiente').innerHTML = totalPendiente;
				/*****************************MONTO PROPINAS************************************************/
				var totalPropinas		= 	document.getElementById('totalPropinas').innerHTML;	
				var totalPropinas 		= 	parseInt(totalPropinas);				
				var totalPropinas		=	totalPropinas+parseInt(creditoPropina);
				document.getElementById('totalPropinas').innerHTML = totalPropinas;
				/*****************************MONTO VUELTO************************************************/
				var vuelto				= 	document.getElementById('vuelto').innerHTML;	
				var vuelto 				= 	parseInt(vuelto);				
				var vuelto				=	vuelto+parseInt(vueltoEfectivo);
				document.getElementById('vuelto').innerHTML = vuelto;
				
				

				$('.pago-agregado').append(detallePago);
				$("#creditoMonto").val('default');
				$("#creditoOperacion").val('default');
				$("#creditoAutorizacion").val('default');
				$("#creditoPropina").val('default');
				if(totalCancelado>=totalPendiente){
						document.getElementById('finalizarPosExpress').style.display = 'block';
					}

				}else{
					alert ('Hay uno o mas valores en negativo');
				}

			}			
		}else{
			alert ('Faltan valores o hay montos mal ingresados');
		}		
	});

	$('.agregar_medio_pago4').on('click', function(){

		var debitoVueltoMonto 		= $('#debitoVueltoMonto').val();
		var debitoVueltoVuelto 		= $('#debitoVueltoVuelto').val();
		var debitoVueltoOperacion 	= $('#debitoVueltoOperacion').val();
		var debitoVueltoAutorizacion 	= $('#debitoVueltoAutorizacion').val();
		var debitoVueltoPropina 		= $('#debitoVueltoPropina').val();
		var debitoVueltoMonto 		= debitoVueltoMonto.replace('.', '');
		var debitoVueltoVuelto 		= debitoVueltoVuelto.replace('.', '');
		var debitoVueltoPropina 		= debitoVueltoPropina.replace('.', '');
		var totalPedidoCobro		= 	document.getElementById('totalPedido').innerHTML;

		if(debitoVueltoPropina==''){
			var debitoVueltoPropina 	= 0;
		}
		if(debitoVueltoVuelto==''){
			var debitoVueltoVuelto 	= 0;
		}

		var debitoVueltoMonto 			= parseInt(debitoVueltoMonto);
		var debitoVueltoPropina 		= parseInt(debitoVueltoPropina);
		var debitoVueltoVuelto 			= parseInt(debitoVueltoVuelto);

		if ( debitoVueltoMonto != '' && debitoVueltoMonto != null && debitoVueltoMonto != 0 && totalPedidoCobro != 0 ){
			var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
			totalPendiente 			= 	parseInt(totalPendiente);
			if ( totalPendiente < debitoVueltoMonto ){
				var diferencia=debitoVueltoMonto-totalPendiente;
				alert('El monto ingresado es mayor al saldo pendiente de la cuenta en $'+diferencia);
				$("#debitoVueltoMonto").val(totalPendiente);
				$("#debitoVueltoPropina").val(debitoPropina);
			}else{
				if(debitoVueltoMonto>=0 && debitoVueltoVuelto>=0 && debitoVueltoPropina>=0){
				$('.insumo_select_'+ insumo_id_seleccionado).hide();
				insumo_agregado_receta2 ++;
				var vueltoEfectivo=0;
				
				var detallePago = '<tr class="insumo_agregado item_pago_' + insumo_agregado_receta2 + '">' +
								'<td>Débito C/ vuelto</td> ' +
								'<td>$' + debitoVueltoMonto +'  </td>'+ 
								'<td>$' + debitoVueltoPropina + '</td>'+
								'<td>0</td>'+
								'<td>'+debitoVueltoVuelto+'</td>'+
								'<td><span class="icon eliminar_item_pago" item_pago="'+ insumo_agregado_receta2 +'" insumo_id_item="'+ insumo_agregado_receta2 +'" ><i class="fa fa-minus-circle"></i> Eliminar</span></td>' +
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][tipoPago]" class="form-control" value="4" id="ProductoReceta'+ insumo_agregado_receta2 +'tipoPago"></td>'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][monto]" class="form-control" value="' + debitoVueltoMonto +'" id="ProductoReceta'+ insumo_agregado_receta2 +'monto">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][debitoVueltoOperacion]" class="form-control" value="' + debitoVueltoOperacion +'" id="ProductoReceta'+ insumo_agregado_receta2 +'efectivo">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][debitoVueltoAutorizacion]" class="form-control" value="' + debitoVueltoAutorizacion +'" id="ProductoReceta'+ insumo_agregado_receta2 +'efectivo">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][propina]" class="form-control" value="' + debitoVueltoPropina +'" id="ProductoReceta'+ insumo_agregado_receta2 +'propina">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vuelto]" class="form-control" value="0" id="ProductoReceta'+ insumo_agregado_receta2 +'vuelto">'+
								'<input type="hidden" name="data[pagos]['+ insumo_agregado_receta2 +'][vueltoTBK]" class="form-control" value="' + debitoVueltoVuelto +'" id="ProductoReceta'+ insumo_agregado_receta2 +'vueltoTBK">'+
							'</tr> ';
				/*****************************MONTO CANCELADO************************************************/
				var totalCancelado		= 	document.getElementById('totalCancelado').innerHTML;	
				var totalCancelado 		= 	parseInt(totalCancelado);				
				var totalCancelado		=	totalCancelado+parseInt(debitoVueltoMonto);
				document.getElementById('totalCancelado').innerHTML = totalCancelado;
				var totalPendiente		= 	document.getElementById('totalPendiente').innerHTML;
				totalPendiente 			= 	parseInt(totalPendiente);
				var totalPendiente		=	totalPendiente-parseInt(debitoVueltoMonto);
				document.getElementById('totalPendiente').innerHTML = totalPendiente;
				/*****************************MONTO PROPINAS************************************************/
				var totalPropinas		= 	document.getElementById('totalPropinas').innerHTML;	
				var totalPropinas 		= 	parseInt(totalPropinas);				
				var totalPropinas		=	totalPropinas+parseInt(debitoVueltoPropina);
				document.getElementById('totalPropinas').innerHTML = totalPropinas;
				/*****************************MONTO VUELTO************************************************/
				var vuelto				= 	document.getElementById('vuelto').innerHTML;	
				var vuelto 				= 	parseInt(vuelto);				
				var vuelto				=	vuelto+parseInt(vueltoEfectivo);
				document.getElementById('vuelto').innerHTML = vuelto;
				/*****************************MONTO VUELTO************************************************/
				var vueltoDebito				= 	document.getElementById('vueltoTBK').innerHTML;	
				var vueltoDebito 				= 	parseInt(vueltoDebito);				
				var vueltoDebito				=	vueltoDebito+parseInt(debitoVueltoVuelto);
				document.getElementById('vueltoTBK').innerHTML = vueltoDebito;
				
				$('.pago-agregado').append(detallePago);
				$("#debitoVueltoMonto").val('default');
				$("#debitoVueltoVuelto").val('default');
				$("#debitoVueltoOperacion").val('default');
				$("#debitoVueltoAutorizacion").val('default');
				$("#debitoVueltoPropina").val('default');
				if(totalCancelado>=totalPendiente){
						document.getElementById('finalizarPosExpress').style.display = 'block';
					}
				}else{
					alert ('Hay uno o mas valores en negativo');
				}
			}			
		}else{
			alert ('Faltan valores o hay montos mal ingresados');
		}		
	});

});


