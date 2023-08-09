<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-cutlery"></span> Insumos</h2></div>
                        <div class="col-md-6"> <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addInsumo"><i class="fa fa-plus-circle"></i> Agregar Insumo</button></div>
                    </div>  
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="productos" class="table table-bordered table-striped dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Insumo</th>
                                    <th>Costo</th>
                                    <th>Unidad</th>
                                    <th>Stock</th>
                                    <th>Stock valorizado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($data as $key => $value) {?> 
                                    <tr>
                                        <td><?=$key+1?></td>
                                        <td><?= $value['nombre'] ?></td>
                                        <td>$<?= number_format($value['precio_anterior'],0, ',', '.') ?></td>
                                        <td><?= $unidadesMedida[$value['data_combo']] ?></td>
                                        <td><?= $value['precio_actual'] ?></td>
                                        <td>$<?= number_format($value['precio_actual']*$value['precio_anterior'],0, ',', '.') ?></td>
                                    </tr>
                                <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="addInsumo">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class='fa fa-plus-circle'></span> Agregar Insumo</h5>
            </div>
            <?= $this->Form->create(null, array('url' => array( 'controller' => 'Products', 'action' => 'addInsumo'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td>Nombre</td>
                                    <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text','required')); ?></td>
                                </tr>
                                <tr>
                                    <td>Código EAN</td>
                                    <td><?= $this->Form->input('ean', array('class' => 'form-control', 'type'=>'text','required')); ?></td>
                                </tr>
                                <tr>
                                    <td>Unidad de compra</td>
                                    <td>
                                        <select class="form-control select" name="unidadesMedida">
                                            <option selected="" disabled="">--Seleccione</option>
                                            <? foreach ($unidadesMedida as $key => $value) {?>
                                                <option value="<?=$key?>"><?=$value?></option>
                                            <?}?>
                                        </select> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Afecto a I.V.A</td>
                                    <td align="center"><?= $this->Form->input('iva', array('type'=>'checkbox', 'checked')); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td>Costo Unitario</td>
                                    <td><?= $this->Form->input('costo', array('class' => 'form-control', 'type'=>'text','required')); ?></td>
                                </tr>
                                <tr>
                                    <td>Stock actual</td>
                                    <td><?= $this->Form->input('stock', array('class' => 'form-control', 'type'=>'text','required')); ?></td>
                                </tr>
                                <tr>
                                    <td>Impuestos Adicionales</td>
                                    <td>
                                        <select name="impuestos" class="form-control select">
                                            <option value="0" disabled="" selected="">-- Seleccione</option>
                                            <? foreach ($impuestos as $key => $value) {?>
                                                <option value="<?=$key?>-<?=$value?>"><?=$key?>(<?=$value?>)</option>
                                            <?} ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success pull-right"  autocomplete="off" data-loading-text="Espera un momento..." value="Guardar">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#productos").dataTable();
    });
</script>