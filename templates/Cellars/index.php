<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-archive"></span> Bodegas</h2></div>
                        <div class="col-md-6">
                            <table class="table">
                                <?= $this->Form->create(null, ['url'=>['controller'=>'Cellars', 'action'=>'add']]); ?>
                                <tr>
                                    <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required')); ?></td>
                                    <td><input type="submit" class="btn btn-success validaform pull-right" name="Agregar bodega"></td>
                                </tr>
                                <?= $this->Form->end(); ?>
                            </table>
                        </div>
                    </div>  
                </div>
                <div class="panel-body">
                    <div class="col-md-4 col-md-offset-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($bodegas as $key => $value) {?>
                                    <tr>
                                        <td><?=$key+1?></td>
                                        <td><?= $value['nombre'] ?></td>
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