<?= $this->Html->scriptBlock(sprintf("var token                 = %s;", json_encode($token))); ?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <h3 style="text-align: center;">Mesas</h3>
                                <h3 style="text-align: center;"><?= count($mesas) ?>/<?= $totalMesas ?></h3>
                            </div>
                            <div class="col-md-3">
                                <h3 style="text-align: center;">Venta del día</h3>
                                <h3 style="text-align: center;">$<?= number_format($totalVentas,0, ',', '.') ?></h3>
                            </div>
                            <div class="col-md-3">
                                <h3 style="text-align: center;">Costos diarios</h3>
                                <h3 style="text-align: center;">$<?= number_format($costosDiarios,0, ',', '.') ?> <?= ($totalVentas<=$costosDiarios)?'<i class="fa fa-thumbs-down"></i>':'<i class="fa fa-thumbs-up"></i>'; ?> </h3>
                            </div>
                            <div class="col-md-3">
                                <h3 style="text-align: center;">Comandas</h3>
                                <h3 style="text-align: center;"><?=$dataComandas['comandas']?>/$<?= number_format($dataComandas['pendiente'],0, ',', '.') ?></h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                        <h4 class="center">Resumen Reservas</h4>
                        <table class="table">
                            <tr>
                                <td>Mesas ocupadas</td>
                                <td></td>
                                <td>Mesas libres</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>Mesa</td>
                                <td>tiempo</td>
                                <td>Notificaciones</td>
                                <td>Liberar</td>
                            </tr>
                            <tbody id="contenidoDashboardReservas">                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="center">Resumen Mesas</h4>
                        <table class="table">
                            <tr>
                                <td>Mesa</td>
                                <td>tiempo</td>
                                <td>Notificaciones</td>
                            </tr>
                            <tbody id="contenidoDashboard">
                                <? 
                                foreach ($salones as $key1 => $value1) {?>
                                    <tr>
                                        <td colspan="3"><h3 style="text-align: center;">Salon: <?=$value1?></h3></td>
                                    </tr>
                                    <?foreach ($mesas as $key => $value){$fecha=(array)$value['modified'];
                                        if($value['salon_id']==$key1){?>
                                        <tr>
                                            <td><?=$value['numero']?></td>
                                            <td><span fecha="<?= $fecha['date'] ?>" class="fecha_cronometro campo_fecha_<?= $value['id'] ?>" id="<?= $value['id'] ?>"></span></td>
                                            <td id="reglonDashboard<?=$value['id']?>"></td>
                                        </tr> 
                                        <?}                                            
                                    }
                                }?>                                
                            </tbody>
                        </table>
                    </div>                   
                </div>    
            </div>            
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = inicial;
    function inicial(){
        var minutos = 60000;
        var tiempoConsulta=5*minutos;
        setTimeout(function(){ consulta(); }, tiempoConsulta);
    }
    function consulta(){
        var formRetiro = {
            '_Token[fields]':token
        };
        $.ajax({
            type: 'POST',
            url: '/Users/consultaNotificaciones',
            headers: { 'X-XSRF-TOKEN' : token },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', token);
            },
            data: formRetiro,
            success: function (result) {
                $.each(result, function( index, value ) {
                    $('#reglonDashboard'+index).html('');
                    if (value==0) {
                        var mensaje='';
                    }
                    if(value==1){
                        var mensaje='Estan llamando al garzón <button class="btn btn-info" onclick="quitanotificacion('+index+')"><i class="fa fa-thumbs-up"></i> ok</button>';
                    }
                    if(value==2){
                        var mensaje='Estan pidiendo la cuenta <button class="btn btn-info" onclick="quitanotificacion('+index+')"><i class="fa fa-thumbs-up"></i> ok</button>';
                    }
                    if(value==3){
                        location.reload();
                    }
                    $('#reglonDashboard'+index).html(mensaje);
                });
            },
            error: function (result){
                alert('error al comunicarse con el servidor');
            }
        });
        var minutos = 60000;
        var tiempoConsulta=5*minutos;
        setTimeout(function(){ consulta(); }, tiempoConsulta);
    }
    function quitanotificacion(id){
        var formRetiro = {
            'id':id,
            '_Token[fields]':token
        };
        $.ajax({
            type: 'POST',
            url: '/Users/finalizaNotificacion',
            headers: { 'X-XSRF-TOKEN' : token },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', token);
            },
            data: formRetiro,
            success: function (result) {
                if(result==1){
                    $('#reglonDashboard'+id).html('');
                }else{
                    alert('Ocurrio un error al actualizar la información, si el error continúa comunicarse con soporte');
                }
            },
            error: function (result){
                alert('error al comunicarse con el servidor');
            }
        });
    }
</script>