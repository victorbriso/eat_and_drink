<div class="panel panel-default">
    <div class="panel-heading">
        <table class="table">
            <tr>
                <td><h2><span class="fa fa-truck"></span> Proveedores</h2></td>
                <td><?= $this->Html->link('<i class="fa fa-plus-square"></i> Agregar Proveedor', ['controller'=>'Vendors', 'action'=>'add'], ['escape'=>false, 'class'=>'btn btn-info pull-right']) ?></td>
            </tr>
        </table>      
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <table id="proveedores" class="table table-bordered table-striped dataTable" style="text-align: center;">
                <thead>
                    <tr style="text-align: center;">
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Razón Social</th>
                        <th style="text-align: center;">R.U.T.:</th>
                        <th style="text-align: center;">Dirección</th>
                        <th style="text-align: center;">Vencido</th>
                        <th style="text-align: center;">Por Vencer</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($proveedores as $key => $value) {?>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?=$value['nombre']?></td>
                            <td><?=$value['razon_social']?></td>
                            <td><?=$value['rut']?></td>
                            <td><?=$value['direccion']?></td>
                            <td>$<?= number_format($value['vencido'],0, ',', '.')?></td>
                            <td>$<?=number_format($value['xVencer'],0, ',', '.')?></td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-plus-square"></i> Ver detalle', ['controller'=>'Vendors', 'action'=>'ctacte', $value['id']], ['escape'=>false, 'class'=>'btn btn-info']) ?>
                                <?= $this->Html->link('<i class="fa fa-edit"></i> Editar', ['controller'=>'Vendors', 'action'=>'edit', $value['id']], ['escape'=>false, 'class'=>'btn btn-warning']) ?>
                            </td>
                        </tr>
                    <?} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#proveedores").dataTable();
    });
</script>