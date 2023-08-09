<?= $this->Html->scriptBlock(sprintf("var token                 = %s;", json_encode($token))); ?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">                    
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h2><span class="fa fa-list"></span>Historico de cajas <strong>últimos 10</strong></h2>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td><input type="date" name="inicio" class="form-control" id="inicio" max="<?= date('Y-m-d', time()); ?>"></td>
                                        <td><input type="date" name="termino" class="form-control" id="termino" max="<?= date('Y-m-d', time()); ?>"></td>
                                        <td><button type="button" class="btn btn-info" id="busqueda"><i class="fa fa-search"></i> Buscar</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <h3 style="text-align: center;">Detalles</h3>
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Apertura</th>
                                <th>Cierre</th>
                                <th>Usuario</th>
                                <th>Descuadre</th>
                                <th>Detalle</th>
                            </tr>
                            <tbody id="contenidoCierres">
                                <? foreach ($ultimosCierres as $key => $value) {?>
                                    <tr>
                                        <td><?= $key+1 ?></td>
                                        <? $fecha=(array)$ultimosCierres[0]['apertura']; ?>
                                        <td><?= date('d-m-Y h:i:s', strtotime($fecha['date'])) ?></td>
                                        <? $fecha=(array)$ultimosCierres[0]['termino']; ?>
                                        <td><?= date('d-m-Y h:i:s', strtotime($fecha['date'])) ?></td>
                                        <td><?= $value['usuario']['nombres'] ?> <?= $value['usuario']['apellidos'] ?></td>
                                        <td>$<?= number_format($value['descuadre'],0, ',', '.')  ?></td>
                                        <td><?= $this->Html->link('Ver detalle', array('action' => 'detalleHistoricoCaja', $value['id']), array('class' => 'btn-form-submit btn btn-success')); ?></td>
                                    </tr>
                                <?}?>    
                            </tbody>
                            
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Volver', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                        </div>  
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
 <script type="text/javascript">
    $( document ).ready(function() { 
        $('#busqueda').on('click', function () {
            var fechaInicio = $('#inicio').val();
            var fechaFin = $('#termino').val();
            var fechaInicio2 = $('#inicio').val();
            var fechaFin2 = $('#termino').val();
            if(fechaInicio!=''&&fechaFin!=''){
                var fechaInicio = fechaInicio.split('-');
                var fechaFin = fechaFin.split('-');
                var yearInicio = fechaInicio[0];
                var mesInicio = fechaInicio[1];
                var diaInicio = fechaInicio[2];
                var yearFin = fechaFin[0];
                var mesFin = fechaFin[1];
                var diaFin = fechaFin[2];
                var varFechaInicio = new Date(yearInicio, mesInicio, diaInicio);
                var varFechaFin = new Date(yearFin, mesFin, diaFin);
                if(fechaFin<fechaInicio){
                    alert('La fecha de consulta final debe ser posterior a la fecha de inicio de la consulta');
                }else{
                    var formRetiro = {
                        '_Token[fields]':token,
                        'desde':fechaInicio2,
                        'termino':fechaFin2
                    };
                    $.ajax({
                        type: 'POST',
                        url: '/Cashboxes/consultaHistoricoFecha',
                        headers: { 'X-XSRF-TOKEN' : token },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('X-CSRF-Token', token);
                        },
                        data: formRetiro,
                        success: function (result) {
                            $('#contenidoCierres').html('');
                            if(result.length>0){
                                $.each(result, function( index, value ) {
                                    var iteral=parseInt(index)+1;
                                    var dateApertura = new Date(value.apertura);
                                    var fechaApertura = dateApertura.getDate()+'-'+dateApertura.getMonth()+'-'+dateApertura.getFullYear()+' '+dateApertura.getHours()+':'+dateApertura.getMinutes()+':'+dateApertura.getSeconds();
                                    var dateCierre = new Date(value.termino);
                                    var fechaCierre = dateCierre.getDate()+'-'+dateCierre.getMonth()+'-'+dateCierre.getFullYear()+' '+dateCierre.getHours()+':'+dateCierre.getMinutes()+':'+dateCierre.getSeconds();
                                    var trAgregado='<tr>'+
                                                        '<td>'+iteral+'</td>'+
                                                        '<td>'+fechaApertura+'</td>'+
                                                        '<td>'+fechaCierre+'</td>'+
                                                        '<td>'+value.usuario['nombres']+' '+value.usuario['apellidos']+'</td>'+
                                                        '<td>$'+new Intl.NumberFormat("de-DE").format(parseInt(value.descuadre))+'.-</td>'+
                                                        '<td><a href="/cashboxes/detalle-historico-caja/'+value.id+'" class="btn-form-submit btn btn-success">Ver detalle</a></td>'+
                                                    '</tr>';
                                    $('#contenidoCierres').append(trAgregado);
                                });
                            }else{
                                $('#contenidoCierres').html('<tr><td colspan="8"><h3 style="text-align: center;">No hay resultados para el rango de fechas</h3></td></tr>');
                            }                            
                        },
                        error: function (result){
                            alert('error al comunicarse con el servidor');
                        }
                    });
                }
            }else{
                alert('Debe seleccionar fechas para generar la consulta');
            }
        });
    });
</script>