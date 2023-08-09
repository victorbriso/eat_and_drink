<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">                    
                    <div class="row">
                        <div class="col-md-10"><h2><span class="fa fa-bolt"></span> Configuración productos y precios para venta en línea</h2></div>
                        <div class="col-md-2"><?= $this->Html->link('<i class="fa fa-plus"></i> Publicar', ['controller'=>'Products', 'action'=>'publicacionWeb'], ['escape'=>false, 'class'=>'btn btn-success pull-right']) ?></div>
                    </div>
                </div>
                <?= $this->Form->create(null, ['enctype' => 'multipart/form-data', 'name'=>'formAdd']); ?>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td>#</td>
                                <td>Producto</td>
                                <td>Precio base</td>
                                <td>Disp. vta web?</td>
                                <td>Precio web</td>
                            </tr>
                            <? foreach ($dataProductos as $key => $value) { $chekDelivery=($value['vta_web'])?'checked':'unchecked';?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?=$value['nombre']?></td>
                                    <td><?=$value['precio_base']?></td>
                                    <td>
                                        <label class="switch">
                                            <?= $this->Form->input('data['.$value['id'].'][vta_web]', array('class' => 'form-control', 'type'=>'checkbox', $chekDelivery)); ?>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?= $this->Form->input('data['.$value['id'].'][precio]', array('class' => 'form-control', 'type'=>'number','min'=>0, 'required', 'value'=>(int)$value['precio_web'])); ?></td>
                                </tr>
                            <?}?>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                            <input type="submit" value="Guardar" class="btn btn-success">
                        </div>  
                    </div>      
                </div>
                <?= $this->Form->end(); ?>
            </div>
            </div>
        </div>
    </div>
</div>