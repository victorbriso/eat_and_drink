/**
 * Archivos con las funciones generales del sitio
 */

$( document ).ready(function() { 

	$('.campo_modena').attr('maxlength','18');
	$('.sorting').addClass('center');

	$('body').on('keyup', '.quitarespacio', function(e){
		let contenido = e.target.value;
  		e.target.value = contenido.replace(" ", "");	
	});

	/******************************************************************************************************************/
	/* * Permite solo ingresar numeros  * */
	$('body').on('input', '.input-number', function () { 
	    this.value			= 	this.value.replace(/[^0-9]/g,'');
	    this.value			= 	this.value.replace('-','');
		this.value			= 	this.value.replace('+','');
		this.value			= 	this.value.replace('*','');
		this.value			= 	this.value.replace('/','');
		this.value			= 	this.value.replace('#','');
	});
	/******************************************************************************************************************/
	/******************************************************************************************************************/
	/* * Permite solo ingresar numeros  * */
	$('body').on('input', '.input-number-receta', function () { 
	    this.value			= 	this.value.replace('-','');
		this.value			= 	this.value.replace('+','');
		this.value			= 	this.value.replace('*','');
		this.value			= 	this.value.replace('/','');
		this.value			= 	this.value.replace('#','');
		this.value			= 	this.value.replace(',','.');
	});
	/******************************************************************************************************************/
	/* * Proceso que permite dar puntos de mil aquellos campos tipo moneda * */
	$('body').on('keyup', '.campo_modena', function(){
		var valor_ingresado		=	$(this).val();
		var id_campo 			=	$(this).attr('id');
		valor_ingresado			= 	valor_ingresado.replace('-','');
		valor_ingresado			= 	valor_ingresado.replace('+','');
		valor_ingresado			= 	valor_ingresado.replace('*','');
		valor_ingresado			= 	valor_ingresado.replace('/','');
		valor_ingresado			= 	valor_ingresado.replace('#','');
		valor_ingresado 		= 	valor_ingresado.replace('.', '');
		$('#' + id_campo).val(formatoNumero(valor_ingresado));
	});
	/******************************************************************************************************************/

	/******************************************************************************************************************/
	/* * Validar RUT Chileno * */
	if ($('.input_rut').length){
		$('.input_rut').rut({
			on_error: function(){ alert('Rut incorrecto'); }
		});
	}
	/******************************************************************************************************************/

	if ( $('.fecha_cronometro').length ){ 
		setInterval('diferenciaFecha()',1000);
	}

	if ($('.option_vista_garzon').length){
		$('#UsuarioTipoVistaGarzon').on('click', function(){
			if ($('#UsuarioTipoVistaGarzon').prop('checked')){
				$('.option_vista_garzon').removeClass('ocultar');
			}else{
				$('.option_vista_garzon').addClass('ocultar');
			}
		});
	}


	$('.file-caption').remove();
	$('.kv-fileinput-upload').remove();
	$('form').attr('autocomplete', 'off');

	$('.fileinput-remove').on('click', function(){
		$('.file-preview').css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
	});

	/**
	 * Open modal 
	 */
	$('.openModal').on('click', function (event) {
	    event.preventDefault();
	    var id_modal	=	$(this).attr('modal');
	    var ajax		=	$(this).attr('modalAjax');
	    /**
		 * Edit/ajax
		 */
		if ( ajax == 1 ){
			var controlador_ajax_modal	=	$(this).attr('controlador');
			var accion_ajax_modal		=	$(this).attr('accion');
			var id_registro_ajax_modal	=	$(this).attr('id_registro');
			$.ajax({
				type		: 'POST',
				url			: webroot + controlador_ajax_modal + '/' + accion_ajax_modal,
				data			: {
					id_registro_ajax_modal			: id_registro_ajax_modal,
				},
				success		: function(msg){
					$('#' + id_modal).html(msg);
					$('#' + id_modal).removeClass('ocultar');
					inicializarIziModal( id_modal );
					$('#' + id_modal).iziModal('open');
				}

			 });
		}else{
			$('#' + id_modal).removeClass('ocultar');
			if (id_modal == 'modalIngresarPagoCuenta'){
				$('.metodo_pago_contenedor').remove();
			}
			inicializarIziModal( id_modal );
			$('#' + id_modal).iziModal('open');
		}
	    
	});
	/**
	 * Close Modal
	 */
	$('.modalFormularios').on('closing', function (e) {
		$('.modalFormularios').each(function(){
			var modal 		=	$(this).attr('id');
			$('#' + modal).hide();
			$('#' + modal).iziModal('destroy');	
		});
		
	});


	/**
	 * [description]
	 * @param  {[type]} ) {		var       id_checkbox [description]
	 * @return {[type]}   [description]
	 */
	if ( $('.tipo_proveedor').length ){
		$( '.select_proveedor' ).on( 'click', function() {
			var id_checkbox = $(this).attr('id');
			var tipo_checkbox = $(this).attr('tipo'); // 1: Mis proveedores - 2: Proveedor Sistema


			if ( tipo_checkbox == 1 ){

				$('.proveedores_sistema_js').prop('checked', false);
				$('.select_proveedor_privado').selectpicker("refresh");
				$('.select_proveedor_privado').val('');

				$('.select_proveedores_sistema').removeClass('fadeInUp');
				$('.select_proveedores_sistema').addClass('fadeOutDown');
				$('.select_proveedores_sistema').addClass('ocultar');

				if( !$('.mis_proveedores_js').prop('checked') ) {
					$('.select_mis_proveedores').removeClass('fadeInUp');
					$('.select_mis_proveedores').addClass('fadeOutDown');
					$('.select_mis_proveedores').addClass('ocultar');
					$('.tipo_proveedor_select').val('');
				}else{
					$('.select_mis_proveedores').removeClass('ocultar');
					$('.select_mis_proveedores').removeClass('fadeOutDown');
					$('.select_mis_proveedores').addClass('fadeInUp');
					$('.tipo_proveedor_select').val(tipo_checkbox);
				}
				
			}else{
				$('.mis_proveedores_js').prop('checked', false);
				$('.select_proveedor_cliente').selectpicker("refresh");
				$('.select_proveedor_cliente').val('');

				$('.select_mis_proveedores').removeClass('fadeInUp');
				$('.select_mis_proveedores').addClass('fadeOutDown');
				$('.select_mis_proveedores').addClass('ocultar');

				if( !$('.proveedores_sistema_js').prop('checked') ) {
					$('.select_proveedores_sistema').removeClass('fadeInUp');
					$('.select_proveedores_sistema').addClass('fadeOutDown');
					$('.select_proveedores_sistema').addClass('ocultar');
					$('.tipo_proveedor_select').val('');
				}else{
					$('.select_proveedores_sistema').removeClass('ocultar');
					$('.select_proveedores_sistema').removeClass('fadeOutDown');
					$('.select_proveedores_sistema').addClass('fadeInUp');
					$('.tipo_proveedor_select').val(tipo_checkbox);
				}

			}
		});
	}

	/**
	 * Direcciones
	 * @param  {[type]} $('.lista_direcciones').length [description]
	 * @return {[type]}                                [description]
	 */
	if ( $('.lista_direcciones').length ){

		for(var iteral = 2; iteral <= cant_direcciones; iteral++){
			$('.direccion_'+iteral).attr('disabled',true);
		}

		$('.select_direccion').on('change', function(){

			var id_select_direccion			=	$(this).attr('id');
			var id_select 					=	$(this).val();
			var select_iteral 				=	$(this).attr('select_iteral');
			var text_select					=	$('#'+id_select_direccion+' option:selected').text();
			
			$('.campo_direccion_'+select_iteral).val($.trim(text_select));

			if ( select_iteral < cant_direcciones){
				var hijo = parseInt(select_iteral) + 1;
				$('.direccion_iteral_'+hijo).hide();
				$('.direccion_'+hijo+'_padre_'+id_select).show();
				$('.direccion_'+hijo).attr("disabled", false);
			}

		});

	}

	/**
	 * Función que permite obtener el envío del información de aquellos formularios donde se desea validar
	 * lo ingresado en el campo nombre (por defecto), con la base de datos.
	 * 
	 * @param  {[type]} event )             {	  event.preventDefault();	  	} [description]
	 * @return {[type]}       [description]
	 */
	$( "body" ).on('click', '.form-validacion', function( event ) {

	  event.preventDefault();

	  $('.btn-form-submit').hide();
	  $('.gif-cargando').show();

	  var mostrar_alerta 	= false;
	  var enviar_form 		= true;
	  var campos_vacios 	= false;

	  var id_formulario 	=	$(this).attr('idform'); // ID formulario (Variable para el submit)
	  var id_editForm		=	$(this).attr('editForm'); // ID del registro (Cuando se edita el campo)
	  var campoForm			=	$(this).attr('campoForm'); // ID del registro (Cuando se edita el campo)
	  $('input.verifica_campo_'+campoForm).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
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

	  /**
	   * Verificacion de los campos email
	   */
	  if ( $('.validar_campo_email').length){
	  		$( '.validar_campo_email' ).each(function(index) {
	  			var valor_campo		=	$(this).val();
	  			if ( valor_campo != '' ){
	  				if (!validarEmail(valor_campo)){
	  					campos_vacios 		= true;
	  					$('.campo_requerido_' + $(this).attr('id')).append('<p class="msn_campo_requerido">Debe ingresar un email valido</p>');
	  				}
	  			}
	  		});
	  }


	  /**
	   * Verificacion producto carta
	   */
	  if ( $('.modulo-producto-carta').length ){

	  	if ( $('#ProductoCartaCategoriaId').val() == 0 || $('#ProductoCartaCategoriaId').val() == null || $('#ProductoCartaCategoriaId').val() == ''){
	  		$('.campo_requerido_ProductoCartaCategoriaId').append('<p class="msn_campo_requerido">Debe asignar una categoría al producto</p>');
	  		campos_vacios 		= true;
	  	}

	  	if ( $('#ProductoCartaElaboracionCartaId').val() == 0 || $('#ProductoCartaElaboracionCartaId').val() == null || $('#ProductoCartaElaboracionCartaId').val() == ''){
	  		$('.campo_requerido_ProductoCartaElaboracionCartaId').append('<p class="msn_campo_requerido">Debe asignar el lugar de elaboración del producto</p>');
	  		campos_vacios 		= true;
	  	}

	  	$('.seleccionar_insumo_receta').children("p").remove();
	  	if ($('.insumo_agregado').length == 0 && $('.definir_receta_producto').prop('checked')){
	  		$('.seleccionar_insumo_receta').append('<p class="msn_campo_requerido">Debe asignar una categoría al producto.</p>');
	  		campos_vacios 		= true;
	  	}

	  }
	  /**
	   * Varificacion del rol en add usuario
	   */
	  if ( $('#UsuarioSistemaDatoUsuarioSistemaRolId').length ){
	  	if ( $('#UsuarioSistemaDatoUsuarioSistemaRolId').val() == 0 || $('#UsuarioSistemaDatoUsuarioSistemaRolId').val() == null || $('#UsuarioSistemaDatoUsuarioSistemaRolId').val() == ''){
	  		$('.campo_requerido_UsuarioPerfil').append('<p class="msn_campo_requerido">Debe ingresar un rol al usuario.</p>');
	  		campos_vacios 		= true;
	  	}
	  }

	  /**
	   * Validación del tamaño de la imagen 
	   */
	  if ( $('.imagen_form').length ){
	  	if ( $('.imagen_form').val() != ''){
	  		if (!(/\.(jpg|png|jpeg|gif)$/i).test(uploadFile.name)) {
		  		$('.file-preview').css('border', '1px dashed #b64645');
		  		$('.div_campoImagen').append('<p class="msn_campo_requerido">El archivo a adjuntar no es una imagen, puede usar .jpg / .png / .jpeg / .gif</p>');
		  		campos_vacios 		= true;
		    }else{
		    	// Peso permitido 1Mb
			    if (uploadFile.size > 1000000){
	                $('.file-preview').css('border', '1px dashed #b64645');
			  		$('.div_campoImagen').append('<p class="msn_campo_requerido">El peso de la imagen no puede exceder los 300kb</p>');
			  		campos_vacios 		= true;
	            }
		    }
	  	}
	  	
	  }
	  
	  /**
	   * Validacion de asigacion de receta a producto carta
	   * @param  {[type]} $('.modulo_receta').length [description]
	   * @return {[type]}                            [description]
	   */
	  if ( $('.modulo_receta').length ){
	  	if ( $('#ProductoRecetaProductoCartaId').val() == 0 || $('#ProductoRecetaProductoCartaId').val() == null || $('#ProductoRecetaProductoCartaId').val() == ''){
	  		$('.campo_requerido_ProductoRecetaNombre').append('<p class="msn_campo_requerido">Debe asignar un producto carta a la receta.</p>');
	  		campos_vacios 		= true;
	  	}
	  }
	  	setTimeout(function(){

		  	if ( campos_vacios == false ){

		  		/**
		  		 * Verificacion de los campos, con la base de datos
		  		 */
		  		
		  		if ( $( ".verifica_campo_"+campoForm ).length ){
		  			var iteral_campos_verificar = 0;
		  			$( ".verifica_campo_"+campoForm ).each(function(index) {

					  	var campo 			=	$(this).attr('campo'); // Nombre del campo a validar
					  	var valor_campo 	=	$(this).val(); // Valor de campo a validar
					  	var controlador 	=	$(this).attr('controlador'); // Instancia a consultar
					  	var id_campo		=	$(this).attr('id');

					  	if ( controlador != '' && controlador != 0 && controlador != null && (typeof controlador) != "undefined"){

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
						  					$('.btn-form-submit').show();
				  							$('.gif-cargando').hide();
				  							return;
										}
									}
								}
							});
							iteral_campos_verificar ++;
					  	}
				 	});

		  			setTimeout(function(){
					 	var cant_campos_verifiar = $( ".verificarbbdd" ).length;
						enviarFormulario(id_formulario,cant_campos_verifiar,iteral_campos_verificar,enviar_form);
					}, 2000);

		  		}else{
		  			setTimeout(function(){
					 	enviarFormulario(id_formulario,0,0,enviar_form);
					}, 2000);
		  		}
		  	}else{
		  		$('.btn-form-submit').show();
		  		$('.gif-cargando').hide();
		  	}
	  	}, 500);
	});
});
/**
 * Funcion que permite enviar la informacion de un formulario determinado
 * @param  {[type]} formularioId        [identificador del formulario]
 * @param  {[type]} camposVerificarAjax [cantidad de campos a verificar en bbdd]
 * @param  {[type]} iteralCampo         [iteral del ciclo]
 * @param  {[type]} enviar              [true/false]
 */
function enviarFormulario(formularioId,camposVerificarAjax,iteralCampo,enviar_form)
{
	console.log(formularioId);
	console.log(camposVerificarAjax);
	console.log(iteralCampo);
	console.log(enviar_form);
	console.log('--');
	if ( enviar_form ){
		if ( camposVerificarAjax == iteralCampo){
			console.log('envio form');
			$( "#" + formularioId ).submit();
		}
	}
}


/**
 * Funcion que permite inicializar una instancia del modal IziModal
 * @param  {[type]} id_modal [description]
 */
function inicializarIziModal( id_modal )
{
	$("#"+id_modal).iziModal({
	  headerColor: '#FF7529',
	  width: '80%', 
	  overlayColor: 'rgba(0, 0, 0, 0.5)', 
	  fullscreen: false, 
	  transitionIn: 'fadeInUp', 
	  transitionOut: 'fadeOutDown',
	  radius: 10,
	  focusInput: false,
	  overlayClose: false,
	});
}

function formatoNumero(numero)
{
	var num 	= 	numero.replace(/\./g,'');
	num 		= 	num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
	num 		= 	num.split('').reverse().join('').replace(/^[\.]/,'');
	return num;
}

function formatMoney(n, c, d, t) {
  var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;

  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function diferenciaFecha()
{
	$('.fecha_cronometro').each(function(){

		var fecha = $(this).attr('fecha');
		var id = $(this).attr('id');

		var today = new Date();
		var endDate = new Date(fecha.replace(/\s/, 'T'));
		
		var days = parseInt((endDate - today) / (1000 * 60 * 60 * 24));
		var hours = parseInt(Math.abs(endDate - today) / (1000 * 60 * 60) % 24);
		var minutes = parseInt(Math.abs(endDate.getTime() - today.getTime()) / (1000 * 60) % 60);
		var seconds = parseInt(Math.abs(endDate.getTime() - today.getTime()) / (1000) % 60); 
		var htmlDif =  hours+':'+minutes+':'+seconds;

		$('.campo_fecha_'+id).html(htmlDif);


	});
	
	
}

/**
 * [verificarCampoFormulario description]
 * Funcion que permite verificar si los campos de un formulario determinado estan vacios
 * @param  {[type]} campoForm [identificador del formulario]
 * @return {[type]}           [true / false]
 */
function verificarCampoFormulario(campoForm)
{
	$('input.verifica_campo_'+campoForm).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
	$( '.div_campo_js').children("p").remove(); // Se quitan los mensajes de campo requerido
	var campos_vacios = false;
	 $('input.verifica_campo_'+campoForm).each(function(){
	  	if ( $(this).val() == '' || $(this).val() == null ){
	  		$(this).css('border', '1px dashed #b64645');
	  		$('.campo_requerido_' + $(this).attr('id')).append('<p class="msn_campo_requerido">' + $(this).attr('mensaje_requerido') + '</p>');
	  		campos_vacios 		= true;
	  	}
	  });

	 return campos_vacios; 
}

/**
 * Funcion que permite validar si un email esta correcto
 * @param  {[type]} email [description]
 * @return {[type]}       [description]
 */
function validarEmail(email)
{
	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (regex.test(email.trim())) {
        return true;
    } else {
        return false;
    }
}

