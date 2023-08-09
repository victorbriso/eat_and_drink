var pago_tarjeta_uso = false;
var validar_pago = false;
var iteral_metodo_pago = 0;
var total_propina_pago = 0;

$( document ).ready(function() { 

	$('#total_pago_voucher_modal').html(formatMoney(monto_voucher_total_js,0,',','.'));
	$('.monto_restante_js').html(formatMoney(monto_voucher_total_js,0,',','.'));

	//Actualiza el porcentaje de la propina sugerida y el total de la propina a pagar
	$('body').on('keyup', '#ComandaMontoPropina', function (){
		var valor_ingresado_propina		=	$(this).val();
		valor_ingresado_propina 		= 	valor_ingresado_propina.replace(/\./g,'');
		var valor_total_pagar 			=  	parseFloat(valor_ingresado_propina) + parseFloat(monto_voucher);
		var proncentaje_propina 		=	(( parseFloat(valor_ingresado_propina) * 100 ) / parseFloat(monto_voucher)) ;
		$('.vista_total_pago_voucher').html('$ ' + formatMoney(valor_total_pagar,0,',','.'));
		$('#ComandaPorcentajePropina').val(formatMoney(proncentaje_propina,0,',','.'));
                
	});

	//Actualiza el monto de la propina sugerida y el total de la propina a pagar
	$('body').on('keyup', '#ComandaPorcentajePropina', function (){
		var valor_ingresado_propina		=	$(this).val();

		var valor_total_pagar 			=  	parseFloat(monto_voucher) * parseFloat( ( valor_ingresado_propina / 100 ) + 1 );
		var valor_propina 				= 	parseFloat(monto_voucher) * parseFloat( ( valor_ingresado_propina / 100 ) );

		$('.vista_total_pago_voucher').html('$ ' + formatMoney(valor_total_pagar,0,',','.'));
		$('#ComandaMontoPropina').val(formatMoney(valor_propina,0,',','.'));
	});

        //CAMPOS MONTO
	$('body').on('keyup', '.campo_monto_js', function (){
            //Pongo el borde de color gris (normal)
            $(this).css('border', '1px solid #D5D5D5');

            var id_campo_monto = $(this).attr('id');
            operarMontosPagos(id_campo_monto);
	});
        
        //CAMPOS PROPINA
	$('body').on('click', '.campo_propina_js', function (){
            $(this).select();
	});
	$('body').on('keyup', '.campo_propina_js', function (){
            var valor_propina_keyup = $(this).val();
            var id_campo_propina = $(this).attr('id');

            if ( valor_propina_keyup == '' ){
                $(this).val("");
            } 
            operarMontosPagos(id_campo_propina);
	});
        
        //CAMPOS VUELTO (DEBITO CON VUELTO)
        $('body').on('keyup', '.campo_vuelto_js', function (){
            calculaMontoRestante();
	});
        
        //CAMPOS EFECTIVO (EFECTIVO)
        $('body').on('keyup', '.campo_efectivo_js', function (){
            calculaMontoRestante();
	});
        
	$('body').on('click', '.form-pago-cuenta', function(){

		var enviar_pago = validar_pago;

		if ( $('.campo_monto_js').length ){

			$('.campo_propina_js').css('border', '1px solid #D5D5D5');
			$('.campo_obligatorio').css('border', '1px solid #D5D5D5');

			$('.campo_obligatorio').each(function(){
				var valor_campo_obligatorio = 	$(this).val();
				var id_campo_obligatorio 	=	$(this).attr('id');
				if ( valor_campo_obligatorio == '' ){
					$('#'+id_campo_obligatorio).css('border', '1px dashed #b64645');
					$('.texto-alerta-js').html('Por favor ingresar los campos requeridos');
					$('#alerta_monto_pago_superior').addClass('open');
					enviar_pago = false;
					return;
				}

			});

			var monto_total_propina 	=	$('#ComandaMontoPropina').val();
			monto_total_propina			=	monto_total_propina.replace(/\./g,'');
			var suma_montos_propina		=	0;
			
			/*$('.campo_propina_js').each(function(){
				var monto_campo_propina = $(this).val();
				monto_campo_propina = monto_campo_propina.replace(/\./g,'');
				if (monto_campo_propina < 1){
					$('.campo_propina_js').css('border', '1px dashed #b64645');
					enviar_pago = false;
					return;
				}else{
					suma_montos_propina += parseFloat(monto_campo_propina);
				}
			});

			if ( suma_montos_propina != monto_total_propina){
				//$('.form-pago-cuenta').addClass('opacity_5');
				$('.texto-alerta-js').html('La suma montos ingresados en los campos de propina deben ser igual a la propina sugerida');
				$('#alerta_monto_pago_superior').addClass('open');
				enviar_pago = false;
				return;
			}*/

			$('.btn-form-submit').hide();
			$('.gif-cargando').show();

			if ( enviar_pago ){

				$('.pago_campo').each(function(){

					var valor_campo 	= $(this).val();
					var iteral_pago 	= $(this).attr('iteral_pago');
					var iteral_campo 	= $(this).attr('iteral_campo');
					var nombre_campo 	= $(this).attr('nombre_campo');

					$('#Pago'+iteral_pago+'ValorCampoPago'+iteral_campo+'').val(valor_campo);
					$('#Pago'+iteral_pago+'NombreCampoPago'+iteral_campo+'').val(nombre_campo);

				});

				$('#ComandaGenerarPagoCuentaForm').submit();
			}else{
				$('.btn-form-submit').show();
				$('.gif-cargando').hide();
			}

		}
		
	});

        //Nuevo metodo de pago
	$('body').on('click', '.nuevo_tipo_pago', function(){
            iteral_metodo_pago ++;
            $('.gif-espere').removeClass('ocultar');
            $('.nuevo_tipo_pago').addClass('ocultar');
            $.ajax({
                type: 'POST',
                url : webroot + 'Cajas/ajax_obtenerCamposTipoPago',
                data:{
                    id_tipo_pago      : 0,
                    iteral_metodo_pago: iteral_metodo_pago,
                    tipo              : 1,
                    excede_pago       : 1
                },
                success: function(msg){
                    $('#pago_select_nuevo').append(msg);
                    $('.gif-espere').addClass('ocultar');
                    $('.nuevo_tipo_pago').removeClass('ocultar');
                }
            });
	});

        //Cambiar metodo de pago
	$('body').on('change', '.asignar_metodo_pago', function(){
            var id_tipo_pago  = $(this).val();
            var iteral_metodo = $('option:selected', this).attr('iteral_pago');
            var repetible     = $('option:selected', this).attr('repetible');
            var excede_pago   = $('option:selected', this).attr('excede_pago');

            $.ajax({
                type: 'POST',
                url : webroot + 'Cajas/ajax_obtenerCamposTipoPago',
                data:{
                    id_tipo_pago: id_tipo_pago,
                    iteral_metodo_pago: iteral_metodo,
                    tipo: 2,
                    excede_pago: excede_pago
                },
                success: function(msg){
                    $('#metodo_pago_'+iteral_metodo).html(msg);
                    if ( excede_pago == 1 ){
                        redondearMontos();
                    }
                    actualizarMontos();
                }
            });
	});

	$('body').on('click', '.btn_borrar_metodo', function(){

		var iteral_metodo = $(this).attr('item');
		$('#metodo_pago_'+iteral_metodo).remove();
		operarMontosPagos();
	});


});

/**
 * [operarMontosPagos description]
 * Funcion que permite obtener los montos ingresados para el pago de la cuenta
 * @return {[type]} [description]
 */

//idCampo corresponde al ID del ultimo input que se modifico (accionado por el onkeyup)
function operarMontosPagos(idCampo){
    $('.campo_no_excede_monto').css('border', '1px solid #D5D5D5');
    
    //Se obtiene los montos ingresados en los campos asigandos
    //Ademas se valida que la suma de los montos ingresados no supere el total a pagar de la cuenta
    //Ningun campo monto puede superar el total a pagar de la cuenta
    var montosOperados   = operaMontos(idCampo);
    var suma_montos      = montosOperados[0];
    var montoCampoExceso = montosOperados[1];
    
    //Obtiene el total ingresado en los campos de propina
    var total_propina_voucher = operaPropinas();
    
    
    //Si se agrega propina se actualiza el monto total del voucher (Monto voucher + propina ingresada)
    if ( total_propina_voucher >= 0 ) {
        //var valor_total_pagar = parseFloat(total_propina_voucher) + parseFloat(monto_voucher);
        var valor_total_pagar = parseFloat(total_propina_voucher) + parseFloat(monto_voucher_total_js);
        //monto_voucher_total_js = valor_total_pagar;

        $('#ComandaValor').val(valor_total_pagar);
        $('.total_pago_propina_voucher_modal').html(formatMoney(total_propina_voucher,0,',','.'));
        $('#total_pago_voucher_modal').html(formatMoney(valor_total_pagar,0,',','.'));
        
        calculaMontoRestante();
        //redondearMontos();
    }

    //Calcular la diferencia que hay que pagar
    var diferencia_pago = (monto_voucher_total_js - (suma_montos+ total_propina_voucher));
    console.log("Diferencia Pago: " + diferencia_pago + " (" + monto_voucher_total_js + " - " + (suma_montos+ total_propina_voucher)+ ")");
    if(diferencia_pago < 0){
        diferencia_pago = diferencia_pago * -1;
        if(montoCampoExceso >= diferencia_pago){
            diferencia_pago = montoCampoExceso - diferencia_pago;
        }
    }
    
    if(diferencia_pago > 0 ){
        $('.pago_restante_div').removeClass('ocultar');
        $('.pago_sobrante_div').addClass('ocultar');
        calculaMontoRestante();
        validar_pago = false;
    }
    else{
        validar_pago = true;
        $('.pago_restante_div').addClass('ocultar');
        $('.pago_sobrante_div').removeClass('ocultar');
        calculaMontoRestante();
        $('#ComandaVuelto').val(diferencia_pago * (-1));
    }
}
function operaMontos(idCampo){
    var suma_montos  = 0;
    var montoCampoExceso = 0;
    $('.campo_monto_js').each(function(){
        var monto_campo = $(this).val();
        
        //Obtenemos el tipo de pago del row que estamos recorriendo
        var numeroPago = $(this).attr("iteral_pago");
        var tipoPago = $("#metodoPagoAppend_"+numeroPago).val();
        
        //Sumatoria acumulada de los valores ingresados en los campos de monto
        monto_campo = monto_campo.replace(/\./g,'');
        if(monto_campo != ''){
            suma_montos += parseInt(monto_campo);
        }

        //Si la suma de montos supera el total a pagar de la cuenta
        if(parseFloat(suma_montos) > parseFloat(monto_voucher_total_js)){

            //Pongo el borde segmentado rojo (error)
            $('#' + idCampo).css('border', '1px dashed #b64645');
            $('#' + idCampo).val("");

            //Mensaje de alerta al usuario
            $('.texto-alerta-js').html('El monto ingresado no puede superar el total de la cuenta.');
            $('#alerta_monto_pago_superior').addClass('open');

            montoCampoExceso = monto_campo;
            validar_pago = false;
            return false;
        }
        
        //Si el tipo de pago es efectivo, y este es igual al monto a pagar entonces aplicare redondeo
        if(tipoPago == 1){
            var montoRestante = calculaMontoRestante();
            if(montoRestante == 0){
                monto_voucher_total_js = parseFloat(monto_voucher);
                
                $('#ComandaValor').val(monto_voucher_total_js);
                $('#total_pago_voucher_modal').html(formatMoney(monto_voucher_total_js,0,',','.'));

                calculaMontoRestante();
                redondearMontos();
                
                var montoRedondeado = redondearNumero(monto_campo);
                $(this).val(montoRedondeado);
            }
        }
    });
    
    return [suma_montos, montoCampoExceso];
}
function actualizarMontos(){
    var total_propina_voucher = operaPropinas();
    
    //Si se agrega propina se actualiza el monto total del voucher (Monto voucher + propina ingresada)
    if ( total_propina_voucher >= 0 ) {
        var valor_total_pagar = parseFloat(total_propina_voucher) + parseFloat(monto_voucher);
        monto_voucher_total_js = valor_total_pagar;

        $('#ComandaValor').val(monto_voucher_total_js);
        $('.total_pago_propina_voucher_modal').html(formatMoney(total_propina_voucher,0,',','.'));
        $('#total_pago_voucher_modal').html(formatMoney(monto_voucher_total_js,0,',','.'));
        
        calculaMontoRestante();
        //redondearMontos();
    }
}
function operaPropinas(){
    var total_propina_voucher = 0;
    $('.campo_propina_js').each(function(){
        $('.campo_propina_js').css('border', '1px solid #D5D5D5');
        var pago_propina = $(this).val();
        pago_propina = pago_propina.replace(/\./g,'');

        if($.isNumeric(pago_propina)){
            total_propina_voucher = parseFloat(pago_propina) + parseFloat(total_propina_voucher);
            //calculaMontoRestante();
        }
    });
    monto_voucher_total_js = parseInt(monto_voucher) + parseInt(total_propina_voucher);
    
    return total_propina_voucher;
}
function redondearMontos(){
    var montoTotal = monto_voucher_total_js;
    montoTotal = montoTotal.toString();
    ultimo_digito = montoTotal.charAt(montoTotal.length-1);

    if ( ultimo_digito < 5 ){
        monto_voucher_total_js = parseFloat(monto_voucher_total_js) - parseFloat(ultimo_digito);
        $('#ComandaTipoRedondeo').val(1);
        $('#ComandaMontoRedondeo').val(ultimo_digito);
    }else{
        var monto_suma = parseInt(10 - ultimo_digito);
        monto_voucher_total_js = parseFloat(monto_voucher_total_js) + parseFloat(monto_suma);
        $('#ComandaTipoRedondeo').val(2);
        $('#ComandaMontoRedondeo').val(monto_suma);
    }
    
    $('#total_pago_voucher_modal').html(formatMoney(monto_voucher_total_js,0,',','.'));
    $('.monto_restante_js').html(formatMoney(monto_voucher_total_js,0,',','.'));
}
function redondearNumero(numero){
    numero = numero.toString();
    var ultimoDigito = numero.charAt(numero.length-1);

    if ( ultimoDigito < 5 ){
        numero = parseFloat(numero) - parseFloat(ultimoDigito);
    }
    else{
        var monto_suma = parseInt(10 - ultimoDigito);
        numero = parseFloat(numero) + parseFloat(monto_suma);
    }
    
    return numero;
}
function calculaMontoRestante(){
    var montoTotal  = monto_voucher_total_js;
    var sumaMontos  = 0;
    var sumaVueltos = 0;
    $(".campo_monto_js").each(function(){
        var montoPagar = 0;
        
        //Identificador input
        var iteralpago  = $(this).attr('iteral_pago');
        
        //Obtener el valor ingresado
        var monto_campo = $(this).val();
        monto_campo = monto_campo.replace(/\./g,'');
        if(monto_campo != '' && monto_campo >= 0){
            sumaMontos += parseInt(monto_campo);
            montoPagar = parseInt(monto_campo);
        }
        
        //Velto o Efectivo
        var vuelto = 0;
        if($("#Pago"+iteralpago+"Vuelto").length){
            if(parseInt($("#Pago"+iteralpago+"Vuelto").val()) > 0){
                vuelto = parseInt($("#Pago"+iteralpago+"Vuelto").val());
            }
        }
        else if($("#Pago"+iteralpago+"Efectivo").length){
            if(parseInt($("#Pago"+iteralpago+"Efectivo").val()) > 0){
                var montoEfectivo = parseInt($("#Pago"+iteralpago+"Efectivo").val());
                var vueltoEfectivo = montoEfectivo - montoPagar;
                vuelto = vueltoEfectivo;
            }
        }
        sumaVueltos = sumaVueltos + vuelto;
        
    });
    
    //Sumo las propinas
    var sumaPropinas = operaPropinas();
    sumaMontos = sumaMontos + sumaPropinas;
    
    var montoRestante = 0;
    //Si aun tengo monto que pagar...
    if(sumaMontos < montoTotal){
        montoRestante = parseInt(montoTotal - sumaMontos);
    }
    //Si lo que voy a pagar es igual al total a pagar
    else if(sumaMontos == montoTotal){
        //Si debo entregar vuelto
        if(sumaVueltos > 0){
            montoRestante = sumaVueltos;
        }
    }
    else if(sumaMontos > montoTotal){
        montoRestante = parseInt(sumaMontos - montoTotal);
    }
    console.log("montoRestante: "+montoRestante);
    $(".monto_restante_js").html(formatMoney(montoRestante, 0, ',', '.'));
    return montoRestante;
}