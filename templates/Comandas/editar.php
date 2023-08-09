<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-edit"></span> Editar en comanda</h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Comanda</h4>
                            <h4 style="text-align: center;"><?= $dataComanda[0]['folio'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Mesa</h4>
                            <h4 style="text-align: center;"><?= $dataComanda[0]['table']['numero'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Salon</h4>
                            <h4 style="text-align: center;"><?= $dataComanda[0]['salon']['nombre'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Usuario</h4>
                            <h4 style="text-align: center;"><?= $dataComanda[0]['usuario']['nombres'] ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Cancelado / Total</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataComanda[0]['pagado'],0, ',', '.')  ?> / $<?= number_format($dataComanda[0]['total'],0, ',', '.')  ?></h4>
                        </div>
                        <div class="col-md-2">
                            <h4 style="text-align: center;">Pendiente</h4>
                            <h4 style="text-align: center;">$<?= number_format($dataComanda[0]['total']-$dataComanda[0]['pagado'],0, ',', '.')  ?></h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td colspan="7"><h4 style="text-align: center;">Detalle Comanda</h4></td>
                        </tr>
                        <tr>
                            <td>#</td>
                            <td>Producto</td>
                            <td>Precio</td>
                            <td>Cantidad</td>
                            <td colspan="2">Total</td>
                        </tr>
                        <? foreach ($dataComanda[0]['orders'] as $key => $value) { if($value['bool_pagado']){continue;} ?>
                            <tr>
                                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Comandas', 'action' => 'editar'))); ?>
                                <td><?=$key+1?></td>
                                <td><?= $value['product']['nombre'] ?></td>
                                <td>$<?= number_format($value['precio'],0, ',', '.')  ?></td>
                                <td><?= $value['cantidad'] ?></td>
                                <td>$<?= number_format($value['total'],0, ',', '.')  ?></td>
                                <td><?= $this->Form->input('cantidad', array('type' => 'number', 'class' => 'form-control', 'required', 'max'=>$value['cantidad'], 'min'=>1, 'step'=>1)); ?></td>
                                <td>
                                    <?= $this->Form->input('tupla', array('type' => 'hidden', 'value'=>$value['id'])); ?>
                                    <?= $this->Form->input('precio', array('type' => 'hidden', 'value'=>$value['precio'])); ?>
                                    <?= $this->Form->input('cantOriginal', array('type' => 'hidden', 'value'=>$value['cantidad'])); ?>
                                    <?= $this->Form->input('comandaId', array('type' => 'hidden', 'value'=>$dataComanda[0]['id'])); ?>
                                    <input type="submit" class="btn btn-success" autocomplete="off" data-loading-text="Espera un momento..." value="Procesar">
                                </td>
                                <?= $this->Form->end(); ?>
                            </tr>
                        <?}?>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                        </div>  
                    </div>      
                </div>
            </div>       
        </div>
    </div>
</div>