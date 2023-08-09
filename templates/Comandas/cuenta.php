<? $id_pedido = ''; $fecha=(array)$comanda[0]['created'];?>
<?= $this->Html->scriptBlock(sprintf("var token                 = %s;", json_encode($token))); ?>
<?= $this->Html->scriptBlock(sprintf("var monto_original_comanda = %s;", $comanda[0]['total'] )); ?>
<?= $this->Html->script(array('/backend/js/plugins/owl/owl.carousel.min', 'custom/custom_comandas', 'custom/custom_general')); ?>
<?= $this->fetch('script'); ?>

<div class="page-title">
	<h2><span class="fa fa-file-text"></span> Cuenta de la Comanda</h2>
</div>
<div class="page-content-wrap" id="contenedor-cuenta-comandas">
    <div class="contenedor-detalle-tipo-cuenta">
        <div class="page-content-wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">                            
                            <h2>Detalle de la cuenta Mesa: <?= $comanda[0]['table']['nombre'] ?> (Nro. <?= $comanda[0]['table']['numero'] ?>)</h2>
                            <hr>
                            <!-- INVOICE -->
                            <div class="invoice">
                                <div class="row">
                                    
                                    <div class="col-md-3">

                                        <div class="widget widget-default widget-carousel">
                                            <div class="owl-carousel" id="owl-example">
                                                <div>                                    
                                                    <div class="widget-title">Cantidad de clientes</div>                                                                         
                                                    <div class="widget-int"><?= count(json_decode($comanda[0]['clientes'],true)) ?></div>
                                                </div>
                                                <div>                                    
                                                    <div class="widget-title">Cantidad de productos</div>
                                                    <div class="widget-int"><?= $pedidos ?></div>
                                                </div>
                                            </div>                            
                                        </div>

                                    </div>

                                     <div class="col-md-3">

                                        <div class="widget widget-default widget-item-icon">
                                            <div class="widget-item-left">
                                                <span class="fa fa-clock-o"></span>
                                            </div>
                                            <div class="widget-data">
                                                <div class="widget-int num-count"><span fecha="<?= $fecha['date'] ?>" class="fecha_cronometro campo_fecha_<?= $comanda[0]['id'] ?>" id="<?= $comanda[0]['id'] ?>"></span></div>
                                                <div class="widget-title"><?//= formatoFecha($comanda[0]['created'], 'dmy', true) ?><?= $comanda[0]['created'] ?></div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="div-generar-cuenta">
                                            <h5 class="center">GENERAR CUENTA COMPLETA</h5>
                                            <table class="table table-striped">
                                                <tr>
                                                    <td class="right"><strong>Total Comanda:</strong></td>
                                                    <td class="text-right"><strong>$ <?= number_format($comanda[0]['total'],0,',','.') ?></strong></td>
                                                    <td class="right"><strong>Total Restante:</strong></td>
                                                    <td class="text-right"><strong>$ <?= number_format($comanda[0]['total']-$comanda[0]['pagado'],0,',','.') ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="center" colspan="4">
                                                        <button class="btn btn-success btn-block js-generar-cuenta" tipo_cuenta="1"><span class="fa fa-credit-card"></span> Generar cuenta completa</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div> 
                                        <div class="div-generar-cuenta-producto ocultar">
                                            <h5 class="center">GENERAR CUENTA POR PRODUCTO</h5>
                                            <table class="table table-striped">
                                                <tr>
                                                    <td><strong>Total:</strong></td><td class="text-right"><strong>$ <span class="total-cuenta-producto"></span></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="center" colspan="2">
                                                        <button class="btn btn-success btn-block js-generar-cuenta" tipo_cuenta="3"><span class="fa fa-credit-card"></span> Generar Cuenta por producto</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group"> </div>
                                    <div class="col-md-12 col-mx-12 opciones-cuenta">
                                        <div class="form-group">
                                            <label class="radio-material">
                                                <input type="radio" name="radio_tipo_cuenta" checked value="1">
                                                <span class="outer"><span class="inner"></span></span> Cuenta completa
                                            </label>                                            
                                            <label class="radio-material">
                                                <input type="radio" name="radio_tipo_cuenta" value="2">
                                                <span class="outer"><span class="inner"></span></span> Cuenta por usuario
                                            </label>
                                             <label class="radio-material">
                                                <input type="radio" name="radio_tipo_cuenta" value="3">
                                                <span class="outer"><span class="inner"></span></span> Cuenta por productos
                                            </label>
                                        </div>     
                                    </div>
                                </div>
                                <!-- Detalle de la comanda -->
                                <div class="row">
                                    <div class="detalle-invoice grid">
                                        <? $iteral_producto = 0; ?>
                                        <? foreach ($clientes as $key_pedido => $pedido) { ?>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="panel panel-default article grid-item">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title"><span class="fa fa-user"> </span> <?= truncate(ucwords(strtolower($pedido)), 20) ?></h3>
                                                        <div class="pull-right">
                                                           <button class="btn btn-default btn_select_producto ocultar" cliente_id="<?= $key_pedido ?>"> Seleccionar todos</button>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <tbody>
                                                                    <? 
                                                                    $pidido_sin_pagar = 0;
                                                                    $monto_pago_usuario = 0;
                                                                     foreach ($comanda[0]['orders'] as $key_pedido_cliente => $pedido_cliente) { if($pedido_cliente['cliente']!=$key_pedido){continue;} ?>

                                                                        <? 
                                                                            if(! $pedido_cliente['bool_pagado']){
                                                                                $id_pedido .= ($iteral_producto == 0 ? '' : ',').''.$pedido_cliente['id']; 
                                                                                 $iteral_producto ++;
                                                                            }
                                                                        ?>
                                                                        <tr>
                                                                            <!-- Datos de los productos -->
                                                                            <? if (   !$pedido_cliente['bool_pagado'] ) { 
                                                                                if ( $pedido_cliente['product']['divisible'] ){
                                                                                     if (  $pedido_cliente['pagado'] ){
                                                                                        $pidido_sin_pagar ++; 
                                                                                        $monto_pago_usuario += $pedido_cliente['total']; ?>
                                                                                    <input 
                                                                                        type="hidden" 
                                                                                        class="producto_pedido data_producto_cliente_<?= $pedido_cliente['cliente'] ?>" 
                                                                                        pedido="<?= $pedido_cliente['id'] ?>" producto="<?= $pedido_cliente['product']['nombre'] ?>" 
                                                                                        producto_id="<?= $pedido_cliente['product']['id'] ?>" 
                                                                                        usuario_id="<?= $pedido_cliente['cliente'] ?>" 
                                                                                        producto_divisible="<?= $pedido_cliente['product']['divisible'] ?>" 
                                                                                        precio_producto="<?= $pedido_cliente['precio'] ?>" 
                                                                                        cant_producto="<?= $pedido_cliente['cantidad'] ?>" 
                                                                                        total_producto="<?= $pedido_cliente['total'] ?>">
                                                                                    <? }?>
                                                                                <? }else{
                                                                                     $pidido_sin_pagar ++; 
                                                                                     $monto_pago_usuario += $pedido_cliente['total'];
                                                                                     ?>
                                                                                    <input 
                                                                                        type="hidden" 
                                                                                        class="producto_pedido data_producto_cliente_<?= $pedido_cliente['cliente'] ?>" 
                                                                                        pedido="<?= $pedido_cliente['id'] ?>" producto="<?= $pedido_cliente['product']['nombre'] ?>" 
                                                                                        producto_id="<?= $pedido_cliente['product']['id'] ?>" 
                                                                                        usuario_id="<?= $pedido_cliente['cliente'] ?>" 
                                                                                        producto_divisible="<?= $pedido_cliente['product']['divisible'] ?>" 
                                                                                        precio_producto="<?= $pedido_cliente['precio'] ?>" 
                                                                                        cant_producto="<?= $pedido_cliente['cantidad'] ?>" 
                                                                                        total_producto="<?= $pedido_cliente['total'] ?>">
                                                                                <? }?>
                                                                            <? }?>
                                                                            <td width="2%">
                                                                                <? if (   !$pedido_cliente['bool_pagado'] ) { 
                                                                                    if ( $pedido_cliente['product']['divisible'] ){ 
                                                                                        if ( ! $pedido_cliente['bool_pagado'] ){ ?>
                                                                                        <div class="checkbox_select_producto ocultar">
                                                                                          <input 
                                                                                            type="checkbox" 
                                                                                            tipo_cuenta="3" 
                                                                                            class="checkbox_producto_select checkbox_cliente_<?= $pedido_cliente['cliente'] ?>" 
                                                                                            pedido="<?= $pedido_cliente['id'] ?>"
                                                                                            producto="<?= $pedido_cliente['product']['nombre'] ?>" 
                                                                                            producto_id="<?= $pedido_cliente['product']['id'] ?>" 
                                                                                            usuario_id="<?= $pedido_cliente['cliente'] ?>" 
                                                                                            producto_divisible="<?= $pedido_cliente['product']['divisible']?>" 
                                                                                            precio_producto="<?= $pedido_cliente['precio'] ?>" 
                                                                                            cant_producto="<?= $pedido_cliente['cantidad'] ?>" 
                                                                                            total_producto="<?= $pedido_cliente['total'] ?>">
                                                                                          <span class="checkmark"></span>
                                                                                        </div>
                                                                                        <?}?>
                                                                                    <?}else{?>
                                                                                        <div class="checkbox_select_producto ocultar">
                                                                                          <input 
                                                                                            type="checkbox" 
                                                                                            tipo_cuenta="3" 
                                                                                            class="checkbox_producto_select checkbox_cliente_<?= $pedido_cliente['cliente'] ?>" 
                                                                                            pedido="<?= $pedido_cliente['id'] ?>"
                                                                                            producto="<?= $pedido_cliente['product']['nombre'] ?>" 
                                                                                            producto_id="<?= $pedido_cliente['product']['id'] ?>" 
                                                                                            usuario_id="<?= $pedido_cliente['cliente'] ?>" 
                                                                                            producto_divisible="<?= $pedido_cliente['product']['divisible'] ?>" 
                                                                                            precio_producto="<?= $pedido_cliente['precio'] ?>" 
                                                                                            cant_producto="<?= $pedido_cliente['cantidad'] ?>" 
                                                                                            total_producto="<?= $pedido_cliente['total'] ?>">
                                                                                          <span class="checkmark"></span>
                                                                                        </div>
                                                                                    <?}?>
                                                                                <?}?>
                                                                            </td>
                                                                            <td width="50%">
                                                                                <span class="nombre-producto"><?= $pedido_cliente['product']['nombre'] ?></span>
                                                                                <p class="comentario-producto"><?= $pedido_cliente['comentario'] ?></p>    
                                                                            </td>
                                                                            <? if (   !$pedido_cliente['bool_pagado'] ) { ?>

                                                                                <? if (  ! $pedido_cliente['product']['divisible'] ) { ?>

                                                                                    <td width="20%" class="right">$ <?= number_format($pedido_cliente['precio'],0,',','.') ?></td>
                                                                                    <td class="center"><?= $pedido_cliente['cantidad'] ?></td>
                                                                                    <td width="20%" class="right">$ <?= number_format($pedido_cliente['total'],0,',','.') ?></td>

                                                                                <? }else{ ?>

                                                                                    <? if($pedido_cliente['bool_pagado']) {?>
                                                                                        <td colspan="3" class="center">Pagado</td>
                                                                                    <? }else{ ?>
                                                                                        <td width="20%" class="right">$ <?= number_format($pedido_cliente['precio'],0,',','.') ?></td>

                                                                                        <td class="center">Dividido</td>
                                                                                        <td width="20%" class="right">$ <?= number_format($pedido_cliente['total'],0,',','.') ?></td>
                                                                                    <? } ?>
                                                                                    

                                                                               <? } ?> 

                                                                            <? }else{ ?>
                                                                                <td colspan="3" class="center">Pagado</td>
                                                                            <? } ?>
                                                                        </tr>
                                                                   <?}?>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="panel-heading center ">
                                                        <? if( $pidido_sin_pagar > 0 ){?>
                                                            <button 
                                                            class="btn btn-success btn-genera-cuenta-usuaurio ocultar js-generar-cuenta" 
                                                            tipo_cuenta="2" 
                                                            cliente="<?= $pedido ?>" 
                                                            cliente_id="<?= $key_pedido ?>"
                                                            id="genera_cuenta_usuaurio_<?php echo $key_pedido; ?>">
                                                                <span class="fa fa-credit-card"></span>
                                                                Generar Cuenta
                                                            </button>
                                                        <?}?>
                                                        <div class="pull-right">
                                                            <span class="label label-primary">$ <?= number_format($monto_pago_usuario,0,',','.') ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?}?>
                                    </div> 
                                </div>
                            </div>
                            <!-- END INVOICE -->

                        </div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
    

</div>



<!--******************************************************************************************************************
* * * * * * * * * * * * * * * * * * * * * * MODAL GENERARACIÓN COMANDA  * * * * * * * * * * * * * * * ** * * * * *  -->
<div id="modalGenerarCuentaCompleta" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Generar Cuenta">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Comandas', 'action' => 'generarCuenta'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>

                    <!-- DATA COMANDA VOUCHER -->

                    <!-- Idenditicador Comanda -->
                    <?= $this->Form->input('VoucherGeneral.comanda_id', array('type' => 'hidden', 'value' => $comanda[0]['id'])); ?>
                    <?= $this->Form->input('VoucherGeneral.mesa_id', array('type' => 'hidden', 'value' => $comanda[0]['table']['id'])); ?>
                    <!-- Identificador Pedidos -->
                    <?= $this->Form->input('VoucherGeneral.id_pedido', array('type' => 'hidden', 'value' => $id_pedido)); ?>
                    <!-- Folio -->
                    <?= $this->Form->input('VoucherGeneral.folio', array('type' => 'hidden', 'value' => '', 'id'=>'VoucherGeneralFolio')); ?>
                    <!-- Monto Comanda -->
                    <?= $this->Form->input('VoucherGeneral.monto_comanda', array('type' => 'hidden', 'value' => $comanda[0]['total']-$comanda[0]['pagado'])); ?>
                    <!-- Monto VoucherGeneral -->
                    <?= $this->Form->input('VoucherGeneral.monto_VoucherGeneral', array('type' => 'hidden', 'value' => $comanda[0]['total']-$comanda[0]['pagado'])); ?>
                    <!-- Monto Propina -->
                    <?= $this->Form->input('VoucherGeneral.propina', array('type' => 'hidden', 'value' => ($comanda[0]['total']-$comanda[0]['pagado'] * 0.1))); ?>
                    <!-- Monto restante -->
                    <?= $this->Form->input('VoucherGeneral.monto_comanda_restante', array('type' => 'hidden', 'value' => '0')); ?>
                    <!-- Monto restante -->
                    <?= $this->Form->input('VoucherGeneral.tipo_cuenta', array('type' => 'hidden', 'value' => '1')); ?>
                    <!-- (Solo para divisibles) Voucher con producto divisible -->
                    <?= $this->Form->input('VoucherGeneral.producto_divisible', array('type' => 'hidden', 'value' => true )); ?>
                    <!-- (Solo para divisibles) id de lo(s) usuario(s) que pagan su producto divisible -->
                    <?= $this->Form->input('VoucherGeneral.id_usuario_divisible', array('type' => 'hidden', 'value' => 1 )); ?>
                    <!-- (Solo para divisibles) cantidad de lo(s) usuario(s) que pagan su producto divisible -->
                    <?= $this->Form->input('VoucherGeneral.cant_usuario_pago_divisible', array('type' => 'hidden', 'value' => 1 )); ?>
                    <!-- (Solo para divisibles) Lista de clientes con su productos divisibles correspondientes -->
                    <?= $this->Form->input('VoucherGeneral.usuario_producto_divisible', array('type' => 'hidden', 'value' => '' )); ?>

                    <div class="panel panel-default">
                        <div class="panel-body">   
                            <div class="row">
                                <div class="panel-body">
                                    <div class="col-md-4 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="center">Producto</th>
                                                        <th class="center">Cantidad</th>
                                                        <th class="center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach ($comanda[0]['orders'] as $key_pedido => $data_peido) { ?>
                                                        <? if( $key_pedido % 2 == 0) {?>
                                                            <tr>
                                                                <td><?= $data_peido['product']['nombre'] ?><br>$ <?= number_format($data_peido['precio'],0,',','.') ?></td>
                                                                <? if ( ! $data_peido['bool_pagado']) {?>
                                                                    <td class="center"><?= $data_peido['cantidad'] ?></td>
                                                                    <td class="right">$ <?= number_format($data_peido['total'],0,',','.') ?></td>
                                                                <?}else{?>
                                                                    <td class="center" colspan="3">Pagado</td>
                                                                <?}?>
                                                            </tr>
                                                        <?}    
                                                    }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="center">Producto</th>
                                                        <th class="center">Cantidad</th>
                                                        <th class="center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <? foreach ($comanda[0]['orders'] as $key_pedido_2 => $data_peido) { ?>
                                                            <? if( $key_pedido_2 % 2 != 0) {?>
                                                                <tr>
                                                                    <td><?= $data_peido['product']['nombre'] ?><br>$ <?= number_format($data_peido['precio'],0,',','.') ?></td>
                                                                    <? if ( ! $data_peido['bool_pagado']) {?>
                                                                        <td class="center"><?= $data_peido['cantidad'] ?></td>
                                                                        <td class="right">$ <?= number_format($data_peido['total'],0,',','.') ?></td>
                                                                    <?}else{?>
                                                                        <td class="center" colspan="3">Pagado</td>
                                                                    <?}?>
                                                                </tr>
                                                            <?}    
                                                        }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-xs-12 center  datos-totales">

                                        <div class="col-md-12 center">
                                            <h2 class="cliente-cuenta">CUENTA COMPLETA</h2>
                                        </div>

                                        <p>Folio <code><span class="correlativo_folio"></span></code> </p>
                                        <h4><strong>Total: </strong></td><td class="text-right"><strong>$ <?= number_format($comanda[0]['total']-$comanda[0]['pagado'],0,',','.') ?></strong></h4>
                                        <h5><strong>Propina (10%): </strong></td><td class="text-right"><strong>$ <?= number_format($comanda[0]['total']-$comanda[0]['pagado'] * 0.1,0,',','.') ?></strong></h5>
                                        <h3 class="pagar"><strong>Total a pagar: </strong></td><td class="text-right"><strong>$ <?= number_format($comanda[0]['total']-$comanda[0]['pagado'] * 1.1,0,',','.') ?></strong></h3>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <div class="center">
                                <?= $this->Html->image('enviar.gif', array('class' => 'ocultar gif-cargando')); ?>
                                <input type="submit" class="btn btn-success esperar-carga btn-form-submit btn-imprimir ocultar" autocomplete="off" data-loading-text="Espera un momento..." value="Imprimir" idform="TipoIngresoAddForm" >
                                <button data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                            </div>
                        </div>
                    </div>

                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>


<!--******************************************************************************************************************
* * * * * * * * * * * * * * * * * * * * * * MODAL GENERARACIÓN COMANDA  * * * * * * * * * * * * * * * ** * * * * *  -->
<div id="modalGenerarCuenta" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Generar Cuenta">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Comandas', 'action' => 'generarCuenta'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>

                <!-- DATA COMANDA VOUCHER -->

                    <!-- Idenditicador Comanda -->
                    <?= $this->Form->input('VoucherEspecifico.comanda_id', array('type' => 'hidden', 'value' => $comanda[0]['id'])); ?>
                    <?= $this->Form->input('VoucherEspecifico.mesa_id', array('type' => 'hidden', 'value' => $comanda[0]['table']['id'])); ?>
                    <!-- Identificador Pedidos -->
                    <?= $this->Form->input('VoucherEspecifico.id_pedido', array('type' => 'hidden', 'value' => '')); ?>
                    <!-- Folio -->
                    <?= $this->Form->input('VoucherEspecifico.folio', array('type' => 'hidden', 'value' => '', 'id'=>'VoucherEspecificoFolio')); ?>
                    <!-- Monto Comanda -->
                    <?= $this->Form->input('VoucherEspecifico.monto_comanda', array('type' => 'hidden', 'value' => $comanda[0]['total'])); ?>
                    <!-- Monto Voucher -->
                    <?= $this->Form->input('VoucherEspecifico.monto_voucher', array('type' => 'hidden', 'value' => '')); ?>
                    <!-- Monto Propina -->
                    <?= $this->Form->input('VoucherEspecifico.propina', array('type' => 'hidden', 'value' => '')); ?>
                    <!-- Monto restante -->
                    <?= $this->Form->input('VoucherEspecifico.monto_comanda_restante', array('type' => 'hidden', 'value' => '')); ?>
                    <!-- Monto restante -->
                    <?= $this->Form->input('VoucherEspecifico.tipo_cuenta', array('type' => 'hidden', 'value' => '')); ?>
                     <!-- (Solo para divisibles) Voucher con producto divisible -->
                    <?= $this->Form->input('VoucherEspecifico.producto_divisible', array('type' => 'hidden', 'value' => false )); ?>
                    <!-- (Solo para divisibles) id de lo(s) usuario(s) que pagan su producto divisible -->
                    <?= $this->Form->input('VoucherEspecifico.id_usuario_divisible', array('type' => 'hidden', 'value' => '' )); ?>
                    <!-- (Solo para divisibles) cantidad de lo(s) usuario(s) que pagan su producto divisible -->
                    <?= $this->Form->input('VoucherEspecifico.cant_usuario_pago_divisible', array('type' => 'hidden', 'value' => 0 )); ?>
                    <!-- (Solo para divisibles) Lista de clientes con su productos divisibles correspondientes -->
                    <?= $this->Form->input('VoucherEspecifico.usuario_producto_divisible', array('type' => 'hidden', 'value' => '' )); ?>

                    <div class="panel panel-default">
                        <div class="panel-body">   
                            <div class="row">
                                <div class="panel-body center">
                                    <div class="col-md-6 col-xs-12 ">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="center">Producto</th>
                                                        <th class="center">Valor</th>
                                                        <th class="center">Cantidad</th>
                                                        <th class="center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="producto_select_cuenta"> </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 datos-totales">
                                        <div class="col-md-12 center">
                                            <h2 class="cliente-cuenta"><span class="fa fa-user"> </span> <span class="nombre_cliente"></span></h2>
                                        </div>
                                        <p>Folio <code><span class="correlativo_folio"></span></code> </p>
                                        <h4><strong>Total: </strong></td><td class="text-right"><strong>$ <label class="cuenta_usuario"></label></strong></h4>
                                        <h5><strong>Propina (10%): </strong></td><td class="text-right"><strong>$ <label class="propina_usuario"></label></strong></h5>
                                        <h3 class="pagar"><strong>Total a pagar: </strong></td><td class="text-right"><strong>$ <label class="total_cuenta_usuario"></label></strong></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="center">
                                <?= $this->Html->image('cargando.gif', array('class' => 'ocultar gif-cargando')); ?>
                                <input type="submit" class="btn btn-success esperar-carga btn-form-submit btn-imprimir ocultar" autocomplete="off" data-loading-text="Espera un momento..." value="Imprimir" idform="TipoIngresoAddForm" >
                                <button data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                            </div>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.grid').masonry({});
    $(".owl-carousel").owlCarousel({mouseDrag: false, touchDrag: true, slideSpeed: 300, paginationSpeed: 400, singleItem: true, navigation: false,autoPlay: true});
</script>