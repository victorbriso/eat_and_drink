<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-edit"></span> Salones</h2></div>
                        <div class="col-md-6"><button class="btn btn-info pull-right openModal" modal="modalAddSalon" modalAjax="0"><i class="fa fa-plus"></i> Agregar salon</button></div>
                    </div>
                    
                </div>
                <div class="panel-body">
                    <div class="col-md-6 col-md-offset-3">
                        <table class="table">
                            <tr>
                                <td>#</td>
                                <td>Nombre</td>
                                <td>Mesas libres</td>
                                <td>Mesas ocupadas</td>
                                <td>Total mesas</td>
                            </tr>
                            <? foreach ($mesas as $key => $value) {?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?=$value['nombre']?></td>
                                    <td><?=$value['libres']?></td>
                                    <td><?=$value['ocupadas']?></td>
                                    <td><?=$value['ocupadas']+$value['libres']?></td>
                                </tr>    
                            <?}?>
                        </table>             
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalAddSalon" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-plus'></span> Agregar Salon" style="z-index: 9999 !important;">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->create(null, ['url'=>['controller'=>'Salons', 'action'=>'add']]); ?>
                        <table class="table">
                            <tr>
                                <td colspan="2" align="center">Nombre del salon</td>
                            </tr>
                            <tr>
                                <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required', 'placeholder'=>'Nombre')); ?></td>
                                <td><input type="submit" class="btn btn-success"  autocomplete="off" data-loading-text="Espera un momento..." value="Agregar"></td>
                            </tr>
                        </table>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>