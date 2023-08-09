<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-th"></span> Mesas</h2></div>
                        <div class="col-md-6"><button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modalAddMesa"><i class="fa fa-plus-circle"></i> Agregar mesas</button></div>
                    </div>
                    
                </div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-3">
                        <table class="table">
                            <tr>
                                <td>#</td>
                                <td>Número</td>
                                <td>Nombre</td>
                                <td>Salon</td>
                                <td colspan="2">Ocupado</td>
                            </tr>
                            <? foreach ($mesas as $key => $value) {?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?=$value['numero']?></td>
                                    <td><?=$value['nombre']?></td>
                                    <td><?=$value['salon']['nombre']?></td>
                                    <td><?=($value['ocupado'])?'Ocupada':'Libre';?></td>
                                    <td><?= $this->Html->link('<i class="fa fa-print"></i> Imprimir QR', array('controller' => 'Users', 'action' => 'dashboard'), array('escape' => false, 'class'=>'btn btn-info btn-block')); ?></td>
                                </tr>    
                            <?}?>
                        </table>             
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modalAddMesa">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class='fa fa-plus-circle'></span> Agregar mesas</h5>
            </div>
            <?= $this->Form->create(null, ['url'=>['controller'=>'Tables', 'action'=>'add']]); ?>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Cantidad</label>
                                <div class="col-md-9">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-info"></span></span>
                                        <?= $this->Form->input('cantidad', array('class' => 'form-control', 'type'=>'number','required', 'min'=>0, 'step'=>1)); ?>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Salon</label>
                                <div class="col-md-9">                                                                                            
                                    <select class="form-control select" name="salonId">
                                        <option selected="" disabled="">--Seleccione</option>
                                        <? foreach ($salones as $key => $value) {?>
                                            <option value="<?=$value['id']?>"><?=$value['nombre']?></option>
                                        <?}?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success pull-right"  autocomplete="off" data-loading-text="Espera un momento..." value="Guardar">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
