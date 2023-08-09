/* jshint bitwise:true, browser:true, eqeqeq:true, forin:true, globalstrict:true, indent:4, jquery:true,
   loopfunc:true, maxerr:3, noarg:true, node:true, noempty:true, onevar: true, quotmark:single,
   strict:true, undef:true, white:false */
/* global FB, webroot, fullwebroot */

/*!
 * Books & Bits | Backend
 */

//<![CDATA[
'use strict';

/**
 * jQuery
 */
jQuery(document).ready(function($)
{
	$('.file-caption').remove();
	$('.kv-fileinput-upload').remove();
	$('form').attr('autocomplete', 'off');

	/**
	 * Select estados
	 */
	if ( $('.selectpicker').length )
	{
		$('.selectpicker').selectpicker();
	}

	/** Quitar espacion input */
	$('.quitarespacio').on('keyup', function(e){
		let contenido = e.target.value;
  		e.target.value = contenido.replace(" ", "");	
	});

	/**
	 * Validación de formularios
	 */
	
	/**
	 * Función que permite obtener el envío del información de aquellos formularios donde se desea validar
	 * lo ingresado en el campo nombre (por defecto), con la base de datos.
	 * 
	 * @param  {[type]} event )             {	  event.preventDefault();	  	} [description]
	 * @return {[type]}       [description]
	 */
	$( ".form-validacion-backend" ).on('click', function( event ) {

	  event.preventDefault();
	  $('.btn-form-submit').hide();
	  $('.gif-cargando').show();

	  var mostrar_alerta 	= false;
	  var enviar_form 		= true;
	  var campos_vacios 	= false;

	  var id_formulario 	=	$(this).attr('idform'); // ID formulario (Variable para el submit)
	  var id_editForm		=	$(this).attr('editForm'); // ID del registro (Cuando se edita el campo)
	  $( '.verifica_campo' ).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
	  $( '.div_campo_js').children("p").remove(); // Se quitan los mensajes de campo requerido

	  /**
	   * Verificación de lo campos obligatorios
	   */
	  $('input.verifica_campo').each(function(){
	  	if ( $(this).val() == '' || $(this).val() == null ){
	  		$(this).css('border', '1px dashed #b64645');
	  		$('.campo_requerido_' + $(this).attr('id')).append('<p class="msn_campo_requerido">' + $(this).attr('mensaje_requerido') + '</p>');
	  		campos_vacios 		= true;
	  		$('.btn-form-submit').show();
	  		$('.gif-cargando').hide();
	  	}
	  });

	  $('.verifica_campo').find("option:selected").each(function(){
			if ($(this).val().trim() == '') {
				$(this).css('border', '1px dashed #b64645');
				$('.campo_requerido_' + $(this).attr('id')).append('<p class="msn_campo_requerido">' + $(this).attr('mensaje_requerido') + '</p>');
				$('.btn-form-submit').show();
	  			$('.gif-cargando').hide();
	  			campos_vacios 		= true;
			}
		});

	   setTimeout(function(){

	  	if ( campos_vacios == false ){
	  		/**
	  		 * Verificacion de los campos, con la base de datos
	  		 */
	  		$( ".verifica_campo" ).each(function(index) {

			  	var campo 			=	$(this).attr('campo'); // Nombre del campo a validar
			  	var valor_campo 	=	$(this).val(); // Valor de campo a validar
			  	var controlador 	=	$(this).attr('controlador'); // Instancia a consultar
			  	var id_campo		=	$(this).attr('id');
			  	var id_local		=	$('.id_local').val();

			  	if ( controlador != '' && controlador != null && typeof(controlador) != 'undefined'){

			  		$.ajax({
					type		: 'POST',
						url			: webroot + 'admin/administradores/ajax_validarCampo',
						data			: {
							campo			: campo,
							valor_campo		: valor_campo,
							controlador		: controlador,
							id_editForm		: id_editForm,
							id_local		: id_local
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
								}
							}
						}

					  });
			  	}

			 });

	  		 setTimeout(function(){
	  		 	if ( enviar_form ){
	  		 		$( "#" + id_formulario ).submit();
	  		 	}
	  		 }, 500);
	  	}
	  }, 200);




	});

	

});
//]]>
