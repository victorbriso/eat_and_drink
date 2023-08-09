<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-search"></span> Detalle de caja <strong><?= $dataCaja[0]['nombre'] ?></strong></h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Fecha apertura</h4>
                            <h4 style="text-align: center;"><?= $dataCaja[0]['fecha_apertura'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Monto apertura</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['monto_apertura'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Usuario</h4>
                            <h4 style="text-align: center;"><?= $dataCaja[0]['usuario']['nombres'] ?> <?= $dataCaja[0]['usuario']['apellidos'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Ubicación</h4>
                            <h4 style="text-align: center;"><?= $dataCaja[0]['salon']['nombre'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Saldo Efectivo</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['efectivo'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Total Ingresos</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['total']-$dataCaja[0]['monto_apertura'],0, ',', '.')  ?></h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 style="text-align: center;">Detalle movimientos</h3>
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Folio</th>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th>Comentario</th>
                                    <th>Detalle</th>
                                </tr>
                                <? foreach ($dataCaja[0]['cashbox_movements'] as $key => $value) { $fecha=(array)$value['created'];
                                    if(isset($value['data'])){
                                        $dataPago=json_decode($value['data'], true);
                                    }                                
                                    ?>
                                    <tr>
                                        <td><?= $key+1 ?></td>
                                        <td><?= date('d-m-Y h:i:s', strtotime($fecha['date'])) ?></td>
                                        <td><?=  $value['numero_folio_cash'] ?></td>
                                        <td><?= $tiposMovimientosCaja[$value['tipo_pago']] ?></td>
                                        <td>$<?= number_format($value['monto'],0, ',', '.')  ?></td>
                                        <td><?= $value['comentario'] ?></td>
                                        <td>
                                            <? if(isset($dataPago)){?>
                                                <button type="button" class="btn btn-warning btn-block openModal detalleModal" recibido="<?=$dataPago['cancelado']?>" cancelado="<?=$value['monto']?>" oper="<?=$dataPago['operacion']?>" auth="<?=$dataPago['autorizacion']?>" vuelttbk="<?=$dataPago['vueltoTBK']?>" vuelto="<?=$dataPago['vuelto']?>" modal="modalAddCaja" modalAjax="0"><i class="fa fa-search"></i> Ver detalle</button>
                                            <?} ?>
                                        </td>
                                    </tr>
                                <?}?>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->create(null, array('url' => array( 'controller' => 'Cashboxes', 'action' => 'procesaCierre'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
                                <table class="table">
                                    <tr>
                                        <td>Efectivo Sistema</td>
                                        <td>Efectivo Caja</td>
                                    </tr>
                                    <tr>
                                        <td>$<?= number_format($dataCaja[0]['efectivo'],0, ',', '.')  ?></td>
                                        <td><?= $this->Form->input('efecCaja', array('type' => 'number', 'class' => 'form-control', 'value'=>$dataCaja[0]['efectivo'], 'min'=>0, 'step'=>1)); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?= $this->Form->input('cajaId', array('type' => 'hidden', 'value'=>$dataCaja[0]['id'])); ?>
                                            <input type="submit" value="Procesar" class="btn btn-success btn-block">
                                        </td>
                                    </tr>
                                </table>
                            <?= $this->Form->end(); ?>
                        </div> 
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
<div id="modalAddCaja" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Detalle Pago">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Monto cancelado</th>
                        <th>Monto Recibido</th>
                        <th>Cód. Operación</th>
                        <th>Cód. Autorización</th>
                        <th>Vuelto Débito</th>
                        <th>Vuelto</th>
                    </tr>
                    <tbody id="detallePago"></tbody>
                </table>
            </div>
        </div>
    </div>
 </div>
 <script type="text/javascript">
    $( document ).ready(function() { 
        $('.detalleModal').on('click', function () {
            $('#detallePago').html('');
            var recibido = $(this).attr('recibido');
            var cancelado = $(this).attr('cancelado');
            var oper = $(this).attr('oper');
            var auth = $(this).attr('auth');
            var vuelttbk = $(this).attr('vuelttbk');
            var vuelto = $(this).attr('vuelto');
            var trAgregado = '<tr>'+
                                '<td>'+'$'+new Intl.NumberFormat("de-DE").format(parseInt(cancelado))+'.-</td>'+
                                '<td>'+'$'+new Intl.NumberFormat("de-DE").format(parseInt(recibido))+'.-</td>'+
                                '<td>'+oper+'</td>'+
                                '<td>'+auth+'</td>'+
                                '<td>'+'$'+new Intl.NumberFormat("de-DE").format(parseInt(vuelttbk))+'.-</td>'+
                                '<td>'+'$'+new Intl.NumberFormat("de-DE").format(parseInt(vuelto))+'.-</td></tr>';
            $('#detallePago').append(trAgregado);
        });
    });
</script>
 