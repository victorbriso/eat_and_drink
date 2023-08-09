<div class="page-content-wrap">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">                 
                <div class="row" style="margin-bottom: 10px">
                    <div class="pull-right">
                        <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
                    </div>
                    <div class="col-md-12">
                        <? foreach ($salones as $key1 => $value1) { ?>
                                <div class="panel-heading mesas-salon-activo titulo-salon-activo">
                                    <h3 class="panel-title"><span class="fa fa-check"></span>  <?= $value1['nombre'] ?> </span></h3>
                                </div>
                                <? foreach ($mesas as $key2 => $value2) { if($value2['salon_id']!=$value1['id']) ?>
                                    <div class="col-md-2 <?= $key1 ?>">                        
                                        <?= $this->Html->link('<i class="fa fa-pencil-square-o"></i> '.$value2['numero'] , array('action' => 'comandaNueva', $value2['id']), array('class' => 'tile tile-default', 'escape' => false)); ?>                     
                                    </div>
                               <? } ?>
                        <? } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>