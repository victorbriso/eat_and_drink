$( document ).ready(function() { 

	// ENVIO DEL FORMULARIO
	$('.form-validacion-caf').on('click', function (event) {
		event.preventDefault();

		var campos_vacios = false;

		/**
	   * Validación del tamaño de la imagen 
	   * @param  {[type]} $('.input_imagen').length [description]
	   * @return {[type]}                           [description]
	   */
	  if ( $('.xml_form').length ){

	  	if ( $('#CafDocumento').val() != ''){
	  			$('#CafAgregarCafForm').submit();
	  	}else{
	  		$('.file-preview').css('border', '1px dashed #b64645');
	  		$('.div_campoImagen').append('<p class="msn_campo_requerido">Es necesario el archivo no es un XML</p>');
	  		campos_vacios 		= true;
	  	}
	  	
	  }

	});

});