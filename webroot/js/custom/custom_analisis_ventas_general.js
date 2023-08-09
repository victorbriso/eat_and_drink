$( document ).ready(function() {
	var inicio = '<?php echo $fecha_inicio_filtro; ?>';
	$('#fecha_inicio_filtro').datepicker({
	    format: "dd-mm-yyyy",
	    todayBtn: "linked",
	    language: "es",
	    todayHighlight: true,
	    setDate: inicio,
	    autoclose: true
	});

	var termino = '<?php echo $fecha_termino_filtro; ?>';
	$('#fecha_termino_filtro').datepicker({
	    format: "dd-mm-yyyy",
	    todayBtn: "linked",
	    language: "es",
	    todayHighlight: true,
	    setDate: termino,
	    autoclose: true
	});
});
function verDetalle(fecha){
	$.ajax({
		type: 'POST',
		url : webroot + 'Informes/ajaxDetalleVentasDia',
		data: {
			fecha: fecha,
		},
		success: function(data){
			$("#contenedorDetalle").html(data);
			$("#modalDetalleDia").modal("show");
		}
 	});
}
function filtrar(){
	//Validar que los campos tengan las fechas
	var fecha_inicio  = $("#fecha_inicio_filtro").val().trim();
	var fecha_termino = $("#fecha_termino_filtro").val().trim();

	if(fecha_inicio != "" && fecha_termino != ""){
		//Saber que fecha es mayor
		valuesStart = fecha_inicio.split("-");
	    valuesEnd   = fecha_termino.split("-");

	    // Verificamos que la fecha no sea posterior a la actual
	    var dateStart = new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
	    var dateEnd   = new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);

	    if(dateStart <= dateEnd){
	        $("#BusquedaVentasPorDiaForm").submit();
	    }
	    else{
	    	$('.texto-alerta-js').html('La fecha de termino debe ser mayor o igual a la fecha de inicio de la busqueda.');
			$('#alerta_monto_pago_superior').addClass('open');
	    }
	}
	else{
		$('.texto-alerta-js').html('Debes seleccionar una fecha de inicio y una fecha de termino.');
		$('#alerta_monto_pago_superior').addClass('open');
	}
}