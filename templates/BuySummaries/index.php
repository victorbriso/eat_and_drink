<?= $this->Html->scriptBlock(sprintf("var detalleCompra                 = %s;", json_encode($detalleCompra))); ?>
<?= $this->Html->scriptBlock(sprintf("var nombresProductos              = %s;", json_encode($nombresProductos))); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <table class="table">
            <tr>
                <td><h2><span class="fa fa-list"></span> Registro de compras</h2></td>
                <td>
                    <div class="pull-right">
                        <button type="button" class="btn btn-success openModal" modal="modalcompra" modalAjax="0"><i class="fa fa-plus"></i> Agregar Compra</button>
                    </div>  
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="50%">Seleccionar Proveedor</td>
                <td width="25%">Desde</td>
                <td width="25%">Hasta</td>
            </tr>
            <tr>
                <?= $this->Form->create(null, ['name'=>'consultaPersonalizada']); ?>
                    <td>
                        <select class="form-control select" data-live-search="true" name="proveedor">
                            <option value="0" selected="">Todos los proveedores</option>
                            <? foreach ($listaProveedores as $key => $value) {?>
                                <option value="<?= $value['id'] ?>"><?= $value['nombre'] ?></option>
                            <?}?>
                        </select>
                    </td>
                    <td><input type="date" name="inicio" max="<?= date('Y-m-d') ?>" class="form-control" id="inicio" /><input type="hidden" name="_Token[fields]" id="token" value="<?=$token?>"></td>
                    <td><input type="date" name="fin" max="<?= date('Y-m-d') ?>" class="form-control" value="<?= date('Y-m-d') ?>" id="fin" /></td>
                <?= $this->Form->end(); ?>               
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <button type="button" class="btn btn-success consultaPersonalizada"><i class="fa fa-info"></i> Buscar</button>
                </td>
            </tr>
        </table>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <table id="compras" class="table table-bordered table-striped dataTable" style="text-align: center;">
                <thead>
                    <tr style="text-align: center;">
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Proveedor</th>
                        <th style="text-align: center;">Documento</th>
                        <th style="text-align: center;">Folio</th>
                        <th style="text-align: center;">Fecha</th>
                        <th style="text-align: center;">Neto</th>
                        <th style="text-align: center;">Impuestos</th>
                        <th style="text-align: center;">Bruto</th>
                        <th style="text-align: center;">Dias</th>
                        <th style="text-align: center;">Vencimiento</th>
                        <th style="text-align: center;">Estado</th>
                        <th style="text-align: center;">Detalle</th>
                    </tr>
                </thead>
                <tbody id="detalleTabla">
                    <? foreach ($dataInforme as $key => $value) {
                        $vencimiento= new \Datetime(date('Y-m-d', strtotime( '+'.$value['dias'].' day',strtotime($value['fecha_compra']))));
                        $hoy= new \Datetime(date('Y-m-d'));
                        $diff=$hoy->diff($vencimiento);            
                        $dias=$diff->days;
                        $tipo=$diff->invert;
                        $color=($tipo)?'red':'green';
                        ?>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?=$value['vendor']['nombre']?> | <?=$value['vendor']['razon_social']?></td>
                            <td><?= $codigos[$value['tipo_documento']]?></td>
                            <td><?=$value['documento']?></td>
                            <td><?= date('d-m-y', strtotime($value['fecha_compra']))?></td>
                            <td>$<?= number_format($value['neto'],0, ',', '.')?></td>
                            <td>$<?=number_format($value['bruto']-$value['neto'],0, ',', '.')?></td>
                            <td>$<?=number_format($value['bruto'],0, ',', '.')?></td>
                            <td><?=$value['dias']?></td>
                            <td><?= date('d-m-y', strtotime ( '+'.$value['dias'].' day',strtotime($value['fecha_compra']))) ?></td>
                            <td style="color: <?=$color?>;"><?= ($tipo)?'Vencido hace '.$dias.' días':'Vence en '.$dias.' días'; ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-block openModal detalleCompra" id="<?=$value['id']?>" modal="detalleCompras" modalAjax="0"><i class="fa fa-search-plus"></i> Ver Detalle</button>
                            </td>
                        </tr>
                    <?} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="detalleCompras" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Compras">
    <div class="page-content-wrap">
        <table class="table">
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Valor Unitario</th>
                <th>Total</th>
            </tr>
            <tbody id="detalleCompra"></tbody>
        </table>
    </div>
</div>
<div id="modalcompra" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-truck'></span> Compras">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td align="center">
                            <?= $this->Html->link('<i class="fa fa-group"></i> Proveedor Registrado', ['controller'=>'BuySummaries', 'action'=>'add'], ['escape'=>false, 'class'=>'btn btn-success']) ?>
                        </td>
                        <td align="center">
                            <?= $this->Html->link('<i class="fa fa-edit"></i> Nuevo proveedor', ['controller'=>'BuySummaries', 'action'=>'addExtra'], ['escape'=>false, 'class'=>'btn btn-info']) ?>
                        </td>
                        <td align="center">
                            <?= $this->Html->link('<i class="fa fa-frown-o"></i> Compra con boleta', ['controller'=>'BuySummaries', 'action'=>'compraBoleta'], ['escape'=>false, 'class'=>'btn btn-warning']) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#compras").dataTable();
    });
    $(document).ready(function(){
        $('#compras').on('click', '.detalleCompra', function(){
            id=$(this).attr('id');
            $('#detalleCompra').html('');
            $.each(detalleCompra[id], function( index, value ){
                var prodId = value['product_id'];
                var nombre = nombresProductos[prodId];
                var iteral = index+1;
                var total = parseFloat(value['neto'])*parseFloat(value['cantidad']);
                var tr = '<tr><td>'+iteral+'</td>'+
                            '<td>'+nombre+'</td>'+
                            '<td>'+value['cantidad']+'</td>'+
                            '<td>'+new Intl.NumberFormat("de-DE").format(value['neto'])+'</td>'+
                            '<td>'+new Intl.NumberFormat("de-DE").format(total)+'</td></tr>';
                $('#detalleCompra').append(tr);
            });
        });
        $('.consultaPersonalizada').on('click', function(){
            var token = $('#token').val();
            var ajaxdata = $("#ajaxForm").serializeArray();
            var fechaInicio = $('#inicio').val();
            var fechaFin = $('#fin').val();
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
                    document.consultaPersonalizada.submit();
                }
            }else{
                alert('Debe seleccionar fechas para generar la consulta');
            }            
        });
    });
</script>