<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-search"></span> Detalle de caja <strong><?= $dataCaja[0]['cashbox']['nombre'] ?></strong></h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Fecha apertura</h4>
                            <? $fecha=(array)$dataCaja[0]['apertura']; ?>
                            <h4 style="text-align: center;"><?= date('d-m-Y h:i:s', strtotime($fecha['date'])) ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Monto apertura</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['monto_apertura'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Fecha Cierre</h4>
                            <? $fecha=(array)$dataCaja[0]['termino']; ?>
                            <h4 style="text-align: center;"><?= date('d-m-Y h:i:s', strtotime($fecha['date'])) ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Monto Cierre</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['monto_cierre'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Usuario</h4>
                            <h4 style="text-align: center;"><?= $dataCaja[0]['usuario']['nombres'] ?> <?= $dataCaja[0]['usuario']['apellidos'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Descuadre</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['descuadre'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-4">
                            <h4 style="text-align: center;">Ventas</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['ventas'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-4">
                            <h4 style="text-align: center;">Ingresos</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['ingresos'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-4">
                            <h4 style="text-align: center;">Egresos</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataCaja[0]['retiros'],0, ',', '.')  ?></h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
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
                            <? foreach (json_decode($dataCaja[0]['movimientos'], true) as $key => $value) {
                                if(isset($value['data'])){
                                    $dataPago=json_decode($value['data'], true);
                                }                                
                                ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $value['created'] ?></td>
                                    <td><?= $value['numero_folio_cash'] ?></td>
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
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Volver', array('action' => 'historicoCaja'), array('class' => 'btn-form-submit btn btn-danger')); ?>
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