$( document ).ready(function() { 

	/** Se reajusta el alto de los contendedores, segun alto del navegador */
	if ( $(".contenedor-info-comanda").length ){
		var alto_navegador = $( window ).height();
		var posicion_contenedor = $(".contenedor-info-comanda").offset().top;
		var dif_posiciones = parseInt(alto_navegador) - parseInt(posicion_contenedor);
		$(".contenedor-info-comanda").height( dif_posiciones - 80);
	}

	

	// Variables Globales
	var clave_usuario_bbdd = '';

	$('.icon-garzon').on('click', function(){

		var clave_usuario 	=	$(this).attr('clave');
		var id_usuario 		=	$(this).attr('id');
		var nombre 	 		=	$(this).attr('nombre_apellido');
		clave_usuario_bbdd 	= clave_usuario;
		$('#UsuarioId').val(id_usuario);
		$('#UsuarioNombre').val(nombre);

		inicializarIziModal( 'modalClaveUsuario' );
 		$('#modalClaveUsuario').removeClass('ocultar');
 		$('#modalClaveUsuario').iziModal('open');

	});

	/** REGISTRAR COMANDA */
	$( "body" ).on('click', '.btn-form-clave-user', function( event ) {

		var formSubmit = $(this).attr('idform');

		event.preventDefault();
		$('.btn-form-submit').hide();
 		$('.gif-cargando').show();
 		$('.pin_invalido').addClass('ocultar');
 		$('.ingrese-pin').addClass('ocultar');

		var clave_insert = $('#UsuarioClaveVistaGarzon').val();

		if ( clave_insert == '' ){
			$('.ingrese-pin').removeClass('ocultar');
		}else{
			if ( clave_usuario_bbdd == md5(clave_insert) ){
				$('#' + formSubmit).submit();
			}else{
				$('.pin_invalido').removeClass('ocultar');
			}
		}
		$('.btn-form-submit').show();
 		$('.gif-cargando').hide();
  		
 	});


 	$('.contenedor-lista-productos').on('click', '.categoria', function(){
 		var id_categoria = $(this).attr('id');
 		$('.categoria').removeClass('activo');
 		$('.item_categoria_'+id_categoria).addClass('activo');
 		$('.producto_carta').addClass('ocultar');
 		$('.producto_categoria_'+id_categoria).removeClass('ocultar');
 	});

});


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