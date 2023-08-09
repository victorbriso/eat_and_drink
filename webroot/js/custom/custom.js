
$( document ).ready(function() { 

	if ( $('#ProductoCartaEditForm').length ){
		if ( insumos_receta_js == 1 ){
			esconderInsumo();
		}
	}

	/**	
	 * [if description]
	 * @param  {[type]} $('.editar-receta').length [description]
	 * @return {[type]}                            [description]
	 */
	if ( $('.editar-receta').length ){
		if ( insumos_receta_js == 1 ){
			 esconderInsumo();
		}

		if( $('.asignar_receta').prop('checked') ) {
			$('.div_select_asignar_receta').removeClass('ocultar');
			$('.div_select_asignar_receta').removeClass('fadeOutDown');
			$('.div_select_asignar_receta').addClass('fadeInUp');
		}
	}


	/**
	 * [description]
	 * 
	 */
	$('.asignar_receta').on('click', function(){
		if( $('.asignar_receta').prop('checked') ) {
			$('.div_select_asignar_receta').removeClass('ocultar');
			$('.div_select_asignar_receta').removeClass('fadeOutDown');
			$('.div_select_asignar_receta').addClass('fadeInUp');
		}else{
			$('.div_select_asignar_receta').removeClass('fadeInUp');
			$('.div_select_asignar_receta').addClass('fadeOutDown');
			$('.select_asignar_receta').val('');
			$('.select_asignar_receta').selectpicker("refresh");
		}

	});
	

	if ($('.select_usuario').length){

		$('.select_usuario').on('change', function(){

			var usuario_id 	= $('option:selected', this).val();
			var caja_id 	=	$(this).attr('caja');

			$('.btn_asginar_caja_'+caja_id).attr('href', '/Cajas/asignarUsuarioCaja/'+caja_id+'/'+usuario_id);
			
		});
	}

	if ( $('.apertura-caja').length ){

		$('body').on('click', '.apertura-caja', function(){
			var usuario_id_caja = $(this).attr('usuario');
			$('#CajaUsuarioId').val(usuario_id_caja);

		});

	}


	$('.open1').on('click',function(){
	    $('.modal-body').load('content.html',function(){
	        $('#ayuda1').modal({show:true});
	    });
	});

	$(".hg-button-escape").on("click", function (){
            cerrarTeclado();
        });

        $(document).keyup(function(e) {
            //Cerrar teclado al presionar tecla escape
            if (e.key === "Escape") {// escape key maps to keycode `27`
               cerrarTeclado();
            }
        });

        //Cerrar teclado al hacer clic en el boton X del teclado
        $('#btn-cerrar-teclado').click(function () {
            cerrarTeclado();
        });
        //Escucha el focus del campo para la busqueda
        $('#abre-teclado').on("click", function(){
            $('#div-keyboard').show();
            ///document.getElementById('div-keyboard').style.display = 'block';
        });
        //Escucha el botón de cierre (LA X) en el teclado
        $('#btn-cerrar-teclado').click(function(){
            //Limpia el campo de búsqueda y oculta la lista de productos y el teclado
            $('#div-keyboard').hide();
        });
        $('#search').focus(function(){
			//Cuando hay focus en el campo de búsqueda muestra la lista de productos y el teclado
			
			$('#div-keyboard').show();
		})


} );

	function cerrarTeclado(){        
        $('#div-keyboard').hide();
    }

function esconderInsumo()
{
	$('input.insumo_asignado_receta').each(function(){
	 	var id_campo = $(this).val();
	 	$('.insumo_select_'+ id_campo).hide();
	 });
}

function guardaCategoriaCombo(){ 
	$.ajax({
			type		: 'POST',
			url			: webroot + 'CategoriasCombos/guardaCatgoria',
			data			: {
				datos			: $('#nombre').val()
			},
			success		: function(msg){
				$('#pago_select_nuevo').prepend(msg);
				$('.gif-espere').addClass('ocultar');
				$('.nuevo_tipo_pago').removeClass('ocultar');
			}

		 });
}



