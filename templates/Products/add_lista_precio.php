<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-list"></span> Nueva Listas de Precios</h2>
                </div>
                <div class="panel-body">
                    <?= $this->Form->create(); ?>
                    <div class="col-md-6 col-md-offset-3">
                        <table class="table">
                            <tr>
                                <th>Nombre lista</th>
                                <th colspan="2"><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required')); ?></th>
                            </tr>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Base</th>
                                <th>Precio lista nueva</th>
                            </tr>
                            <? foreach ($productos as $key => $value) {?>
                                <tr>
                                    <td>
                                        <?= $this->Form->input('data['.$value['id'].']id', array('type'=>'hidden', 'value'=>$value['id'])); ?>
                                        <strong><?= $value['nombre'] ?></strong>
                                    </td>
                                    <td><strong>$<?= number_format($value['precio_base'],0, ',', '.') ?></strong></td>
                                    <td><?= $this->Form->input('data['.$value['id'].']precio', array('class' => 'form-control', 'type'=>'number', 'required', 'value'=>$value['precio_base'])); ?></td>
                                </tr>
                            <?}?>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Cancelar', array('action' => 'listasPrecio'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                            <input type="submit" class="btn btn-success"  autocomplete="off" data-loading-text="Espera un momento..." value="Guardar">
                        </div>  
                    </div>      
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>            