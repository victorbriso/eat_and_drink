<div class="page-title">
   <div class="row">
      <div class="col-md-8  col-xs-12">
         <h2><span class="fa fa-list"></span> Lista comandas</h2>
      </div>
   </div>
</div>
<div class="page-content-wrap" id="contenedor-lista-comandas">
   <div class="row">
      <? foreach ($salones as $key => $salon) { ?>
         <div class="panel-body">    
            <div class="panel-heading mesas-salon-activo titulo-salon-activo">
               <h3 class="panel-title"><span class="fa fa-check"></span>  <?= $salon['nombre'] ?></h3>
            </div>
            <?php foreach ( $comandas as $mesa ) {$fecha=(array)$mesa['created']; ?>
               <div class="col-md-3 col-xs-6 contenedor-salones">                        
                  <div class="caja-rol">
                     <a href="<?= 'Comandas/edit/'.$mesa['id'] ?>" class="tile tile-default">
                        <div class="center">
                           <? $encabezado=($mesa['table']['numero']==$mesa['table']['numero']) ? "# ".$mesa['table']['numero'] : "# ".$mesa['table']['numero']." | " .$mesa['table']['nombre'];?>
                           <span class="correlativo-mesa"><?= $encabezado ?></span>
                           <span class="help-block nombre-mesa"><?= $mesa['usuario']['nombres']; ?></span>
                        </div>
                        <div class="center">
                           <p class="monto-comanda-lista"><span class="fa fa-dollar"> </span> <?= number_format($mesa['total'],0,',','.') ?></p>
                           <p><?= number_format($mesa['pagado'],0,',','.') ?> <span class="fa fa-money"></span> |
                           <?= number_format($mesa['total']-$mesa['pagado'],0,',','.') ?> <span class="fa fa-search"></span> </p> 
                        </div>
                        <div> 
                           <p><?= count(json_decode($mesa['clientes'], true)) ?> <span class="fa fa-users"></span> | <span fecha="<?= $fecha['date'] ?>" class="fecha_cronometro campo_fecha_<?= $mesa['id'] ?>" id="<?= $mesa['id'] ?>"></span> <span class="fa fa-clock-o"></span></p> 
                        </div>
                     </a> 
                  </div>
                  <div class="btn-opciones center">
                     <div class="row">
                        <div class="col-md-12">
                           <? echo $this->Html->link('CUENTA', array('controller' => 'Comandas','action' => 'cuenta', $mesa['id']), array('class' => 'btn btn-success btn-cuenta-comanda', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Generar Cuenta', 'escape' => false));?>
                        </div>
                     </div>
                  <?
                  if($authDcto==1&&$authEdit==1){?>
                     <div class="col-md-12"><br>
                        <div class="row">
                           <div class="col-md-6">
                              <? echo $this->Html->link('DCTO', array('controller' => 'Comandas','action' => 'descuento', $mesa['id']), array('class' => 'btn btn-warning btn-cuenta-comanda', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Descuentos', 'escape' => false));?>
                           </div> 
                           <div class="col-md-6">
                              <? echo $this->Html->link('EDITAR', array('controller' => 'Comandas','action' => 'editar', $mesa['id']), array('class' => 'btn btn-danger btn-cuenta-comanda', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Descuentos', 'escape' => false));?>
                           </div>
                        </div>
                        <br>                        
                     </div>                                          
                     <? 
                     } elseif ($authDcto==1) {?>
                        <div class="col-md-12"><br>
                           <? echo $this->Html->link('DCTO', array('controller' => 'Comandas','action' => 'descuento', $mesa['id']), array('class' => 'btn btn-warning btn-cuenta-comanda', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Descuentos', 'escape' => false));?>
                        </div> 
                     <?}elseif(($authEdit==1)){?>
                        <div class="col-md-12"><br>
                           <? echo $this->Html->link('EDITAR', array('controller' => 'Comandas','action' => 'editar', $mesa['id']), array('class' => 'btn btn-danger btn-cuenta-comanda', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Descuentos', 'escape' => false));?>
                        </div>
                     <?}?> 
                  </div>
               </div>
            <?php }?>
         </div>
      <?php } ?>
   </div>
</div>