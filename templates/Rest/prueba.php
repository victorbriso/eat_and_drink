<script type="text/javascript">
	$(document).ready(function(){
		var token=0;
		var formRetiro = {
            '_Token[fields]':token
        };
		$.ajax({
            type: 'GET',
            url: 'http://localhost/impresion/socket.php',
            data: formRetiro,
            success: function (result) {
                console.log(result);
            },
            error: function (result){
                alert('error al comunicarse con el servidor');
            }
        });
	});
</script>