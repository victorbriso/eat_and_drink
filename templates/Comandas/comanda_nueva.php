<?= $this->Html->scriptBlock("var grilla_comanda = 'md';"); ?> 
<?= $this->Html->scriptBlock("var cant_cliente_linea = 2;"); ?>
<?= $this->Html->scriptBlock("var lista_cliente = 0;"); ?>
<?= $this->Html->scriptBlock("var cant_productos = 0;"); ?>
<?= $this->Html->scriptBlock("var monto_comanda = 0;"); ?>
<?= $this->Html->scriptBlock("var registro_local_id = ".$localId.";"); ?>
<?= $this->Html->scriptBlock("var usuario_session_id = ".$userId.";"); ?>
<? $mesa_definida = ( count($infoMesa) > 0 ? 1 : 2 ); ?>
<?= $this->Html->scriptBlock("var mesa_definida = '{$mesa_definida}';"); ?> 
<?= $this->Form->create(null, array('url' => array( 'controller' => 'Comandas', 'action' => 'add'), 'class' => 'formularioComanda form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
    
    <!-- Campos Generales de la comanda-->
    
    <?=  $this->Form->input('Comanda.tipo', array('type' => 'hidden', 'value' => 1)); ?> <!-- origen de la comanda -->
    <?=  $this->Form->input('Comanda.cant_productos', array('type' => 'hidden')); ?><!-- cantidad total de productos-->
    <?=  $this->Form->input('Comanda.cant_usuarios', array('type' => 'hidden')); ?><!-- cantidad total de usuarios-->
    <?=  $this->Form->input('Comanda.usuario', array('type' => 'hidden')); ?><!-- cadena total de usuarios-->
    <?=  $this->Form->input('Comanda.id_usuario', array('type' => 'hidden')); ?><!-- cadena total de usuarios-->
    <?=  $this->Form->input('Comanda.monto', array('type' => 'hidden')); ?><!-- Monto general del pedido-->
    <?=  $this->Form->input('Comanda.salon_id', array('type' => 'hidden', 'value'=>$infoMesa[0]['salon_id'])); ?><!-- Monto general del pedido-->
    <?=  $this->Form->input('Comanda.monto_nuevo', array('type' => 'hidden', 'value' => 0)); ?><!-- Monto nuevo general del pedido-->
    <?=  $this->Form->input('Comanda.comentario', array('type' => 'hidden')); ?><!-- Comentarios General sobre el pedido-->
    <?=  $this->Form->input('Comanda.usuario_id', array('type' => 'hidden', 'value' => $userId)); ?><!-- Comentarios General sobre el pedido-->
    <?=  $this->Form->input('Comanda.mesa_id', array('type' => 'hidden', 'value' => $mesaId)); ?><!-- Identificador de la mesa-->
    <?=  $this->Form->input('Mesa.id', array('type' => 'hidden', 'value' => $mesaId)); ?><!-- Identificador de la mesa-->
    <?=  $this->Form->input('Mesa.ocupada', array('type' => 'hidden', 'value' => 1)); ?><!-- Identificador de la mesa-->
    <?=  $this->Form->input('Comanda.vista_garzon', array('type' => 'hidden', 'value' => 0)); ?><!-- Identificador de vista garzon -->
    <?=  $this->Form->input('Comanda.con_divisible', array('type' => 'hidden', 'value' => 0)); ?><!-- Comanda con producto divisible -->
    <?=  $this->Form->input('Comanda.hora', array('type' => 'hidden', 'value' => time())); ?><!-- Identificador de vista garzon -->

    <?php if(count($carta) > 0 ){ ?>
        <div id="contenedor-comanda" class="comanda-layout-desktop">

    <div class="row">

        <div class="col-md-12">
            <div class="center gif-recibiendo-info">
                <?= $this->Html->image('cargando.gif'); ?>
            </div>
        </div>

        <div class="contendor_generar_comanda opacity_0"> 
            <!-- Buscador del productos -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-list-ul"></span>
                                    </div>
                                     <select name="selectProductoCarta" class="form-control select" data-live-search="true" id="selectProductoCarta">
                                        <option value="0" disabled selected>-- Productos</option>
                                            <? foreach ($carta as $key1 => $value1) {
                                                foreach ($value1['productos'] as $key2 => $value2) {?>
                                                    <option value="<?= $value2['id'] ?>" valor="<?= $value2['precio_actual'] ?>" divisible="<?= $value2['divisible'] ?>" impresion="<?= $value2['place_elaboration_id'] ?>"><?= $value2['nombre'] ?></option>
                                                <?}
                                            }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nombre de la mesa y agregar cliente -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-5 center">
                                <? $encabezado=($infoMesa[0]['numero']==$infoMesa[0]['nombre']) ? "# ".$infoMesa[0]['numero'] : "# ".$infoMesa[0]['numero']." | " .$infoMesa[0]['nombre'];?> 
                                <span class="titulo_mesa"><span class="nombre_mesa_comanda"> <?= $encabezado; ?></span> </span>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-user"></span>
                                    </div>
                                    <input type="text" class="form-control nombre_ciente_comanda" value="" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                 <button class="btn btn-success btn-block nuevo-user-comanda"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div> 

            <!-- Lista productos -->
            <div class="col-md-6 col-xs-12">                        
                <!-- START JUSTIFIED LISTA PRODUCTOS -->
                <div class="panel panel-default contenedor-lista-productos contenedor-info-comanda">
                    <div class="panel-body">
                        <div class="col-md-12 btn-categorias-padre">
                            <div class="col-md-4">
                                <span class="btn btn-default btn-block btn-lg btn-select-categoria-padre" padre="1">Comestibles</span>
                            </div>
                            <div class="col-md-4">
                                <span class="btn btn-default btn-block btn-lg btn-select-categoria-padre" padre="2">Bebestibles</span>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-default btn-block btn-lg btn-select-categoria-padre openModal" modal="modalAddMesa" modalAjax="0" onclick="resetModalCombos();">COMBOS</button>
                            </div>
                        </div>
                        <div class="col-md-12 msn-selecciones-categoria center">
                            <h3>Por favor selecione una categoria</h3>
                        </div>
                        <div class="col-md-6 contenedor-lista-categorias">
                            <ul class="list-group">
                              <? foreach ($carta as $key_categoria => $categoria) {?>
                                  <li class="list-group-item d-flex justify-content-between align-items-center item_categoria_<?= $key_categoria; ?> categoria ocultar categoria_hija_lista categoria_hija_<?= $categoria['cat_padre'] ?>" id="<?= $key_categoria ?>">
                                    <?= $categoria['nombre'] ?>
                                    <span class="badge badge-pill"><span class="fa fa-caret-right"></span></span>
                                  </li>
                                <?}?>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group lista-productos">
                                <? foreach ($carta as $key1 => $value1) {
                                    foreach ($value1['productos'] as $key2 => $value2) {?>
                                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start producto_categoria_<?= $value2['category_id'] ?> ocultar producto_carta img_add_producto_carta" id_producto_carta="<?= $value2['id'] ?>" nombre_producto_carta="<?= $value2['nombre'] ?>" valor_producto_carta="<?= $value2['precio_actual'] ?>" producto_divisible="<?= $value2['divisible'] ?>"  prod_impresion="<?= $value2['place_elaboration_id'] ?>">
                                            <div class="d-flex w-100 justify-content-between">
                                              <h3 class="mb-1"><?= $value2['nombre'] ?></h3>
                                              <p class="monto-comanda-lista"><span class="fa fa-dollar"> </span> <?= number_format($value2['precio_actual'],0,',','.') ?></p>
                                            </div>
                                            <p class="mb-1 descripcion_producto"><?= $value2['desc_es'] ?></p>
                                          </a>
                                    <?}
                                } ?>  
                            </div>
                        </div>
                    </div>
                </div>                                         
                <!-- END JUSTIFIED LISTA PRODUCTOS -->
            </div>
            <!-- Informacion detalle comanda -->
            <div class="col-md-6 col-xs-12">
                <!-- START STRIPED TABLE SAMPLE -->
                <div class="panel panel-default contenedor-lista-productos contenedor-info-comanda">
                <!--<div class="panel panel-default contenedor-lista-pedido contenedor-info-comanda">-->
                    <div class="panel-heading div-users-comanda">
                        <!--<h3 class="panel-title">Pedido</h3>-->
                          <!--<div class="col-md-3 center">
                              <img src="/proyectos/DRINK/img/user_comand.png" class="img_cliente_comanda center" alt="A generic square placeholder image with rounded corners in a figure."><figcaption class="figure-caption"><input class="activo_cliente_comanda campo_nombre_cliente_comanda" type="text" name="" value="Cliente Nro 1"></figcaption>
                          </div>-->
                    </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped items-pedido-desktop ocultar">
                                    <thead>
                                        <tr>
                                            <th class="center" style="width: 12%;">Cant.</th>
                                            <th class="center">Producto Carta</th>
                                            <th class="center">Agregados</th>
                                            <th class="center">Comentario</th>
                                            <th class="center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <!--<tbody class="">
                                        <tr>
                                            <td class="td_cliente_comanda" colspan="4"><code>Steven Salcedo</code></td>
                                            <td class="td_cliente_comanda">- Eliminar</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Lomo Saltado</td>
                                            <td>1</td>
                                            <td>Sin cebolla</td>
                                            <td class="icon_actions"><?= $this->Html->image('mas.png') ?>  <?= $this->Html->image('menos.png') ?> <?= $this->Html->image('delete_item.png') ?></td>
                                        </tr>
                                    </tbody>-->
                                </table>
                                <div class="col-md-12 center msn-ingresar-cliente">
                                    <h3>Por favor ingrese un cliente</h3>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- END STRIPED TABLE SAMPLE -->
            </div>

            <div class="col-md-6 col-md-offset-3 col-md-12 registar-comanda">
                <?= $this->Html->image('enviar_blanco.gif', array('class' => 'ocultar gif-cargando')); ?>
                <input type="button" class="btn btn-success btn-block esperar-carga form-validacion-comanda btn-form-submit btn-lg" autocomplete="off" data-loading-text="Espera un momento..." value="GENERAR PEDIDO" idform="ComandaAddForm" >
            </div>
        </div> 

    </div>

</div>





    <?php }else{?>
        <div class="row">
            <div class="col-md-6 center lista col-md-offset-3 col-xs-12" style="margin-top: 10%;">
                <h2><i class="fa fa-warning"></i> Para ingresar la comanda, se necesita que la carta esté activa o los productos de la carta estén activos.</h2>
            </div>
        </div>
    <?php }?> 
<!--******************************************************************************************************************
* * * * * * * * * * * * * * * * * * * * * * INICIO MODAL COMBOS * * * *  * * * * * * * * * * * * * * * ** * * * * * * * * * -->
<div id="modalAddMesa" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="Combos" data-izimodal-subtitle="Gestión de Combos">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px; margin-top: 10px;" id="btnReset">
                <?php echo $this->Form->button('Ver Combos', array(
                    'type' => 'button',
                    'class' => 'btn btn-ed btn-lg',
                    'onclick' => 'resetModalCombos()'
                )); ?>
            </div>
            <?php foreach ($cartaNueva['nombresCombos'] as /*$key1 =>*/ $value1) { 
                $key1 = $value1['id'];
            ?>
            <div class="contenedorCombo" id="contenedorCombo<?php echo $key1; ?>" style="margin-bottom: 10px">
                <div class="col-md-3">
                    <div class="panel panel-default imageLista">                            
                        <div class="panel-body panel-body-image">
                            <h3 class="center"><?= $value1['nombre'] ?></h3>
                        </div>
                        <div class="panel-body">        
                            <!--<div class="panel-body panel-body-image" href="#">
                                <?php if(empty($productoCarta['ProductoCarta']['image'])){
                                    echo $this->Html->image('imagen_no_disponible.jpg');
                                }else{
                                    echo $this->Html->image($productoCarta['ProductoCarta']['image']['lista']);
                                } ?>
                            </div>-->
                            <div class="col-md-12 center contenedorBtnDetalleCombo" id="contenedorBtnDetalleCombo<?php echo $key1; ?>">
                                <button class="btn btn-default btn-block btn-lg" onclick="detalleCombo(<?= $key1.", '".$value1['nombre']."', ". number_format($value1['precio'], 0, ',', '').", '".$value1['impresion']."'"; ?>)">Seleccionar</button>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <label class="col-md-12 center">$ <?= number_format($value1['precio'], 0, ',', '.') ?></label>
                        </div>
                    </div>    
                </div>
                <div id="detalleCombo<?php echo $key1; ?>" style="display: none" class="detalleCombo">
                    <?php
                    if(isset($cartaNueva['combos'][$key1])){
                        $value2 = $cartaNueva['combos'][$key1];
                        $key2 = $key1;
                        $detalleCombo = $value2['ProductoCombo']['data']['detalle'];
                        ?>
                        <div class="col-md-4">
                            <div class="col-md-12" id="<?php echo $key2; ?>">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="center">
                                                    COMBO SELECCIONADO <?= $value2['ProductoCombo']['nombre'] ?>
                                                </th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detalleCombo as $key3 => $value3) {
                                                $detalleCategoria = $value3['detalle'];
                                                $estadoCategoria  = 'Cerrada';
                                                if($value3['tipo']){
                                                    $estadoCategoria = 'Abierta';
                                                }
                                                $categoria_nombre = 'Categoría '.$value3['nombre'].' / '.$estadoCategoria;
                                                ?>
                                                 <tr>
                                                     <th style="background-color: #f8fafc; text-align: center;">
                                                         <?php echo $categoria_nombre; ?>
                                                     </th>
                                                 </tr>
                                                 <?php foreach ($detalleCategoria as $key4 => $value4) {
                                                    $agregado = '';
                                                    $tipo = 'radio';
                                                    if($value3['tipo']){
                                                        $tipo = 'checkbox';
                                                    }
                                                    if(isset($value4['agregado'])){
                                                       if($value4['agregado'] > 0){
                                                           $agregado = ' (+ $'. number_format($value4['agregado'], 0, ',', '').')';
                                                       }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input
                                                                type="<?= $tipo; ?>"
                                                                name="<?= $key3; ?>"
                                                                value="<?= $value4['id']; ?>"
                                                                class="<?php echo 'inputCombo'.$key1.' categoriaCombo'.$key1.' categoriaCombo'.$key1.'Id'.$key3; ?>"
                                                                onclick="detalleArmadoCombo(<?php echo $key4.', '.$key1.', '.$value4['id'].', '.$value3['tipo'].', '.$value1['precio']; ?>)"
                                                                nombre_producto="<?= $value4['producto']; ?>"
                                                                agregado="<?php echo $value4['producto'].$agregado; ?>"
                                                                valor_agregado="<?php echo $value4['agregado']; ?>"
                                                                nombre_categoria="<?php echo $categoria_nombre; ?>"
                                                                categoria_id="<?php echo $key3; ?>"
                                                                id="productoCombo_<?php echo $key4.'_'.$key1.'_'.$value4['id']; ?>"
                                                            >
                                                            <?= $value4['producto'].$agregado; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <center>
                                <h3>Detalle Combo</h3>
                            </center>
                            <hr>
                            <div class="row" id="detalleArmadoCombo<?php echo $key1; ?>">
                                
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <label style="">Total</label>
                                    </div>
                                    <div class="col-md-4" id="detalleTotalCombo<?php echo $key1; ?>"></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <center>
                <img src="/img/enviar.gif" class="ocultar gif-cargando" alt="">
                <div id="contenedorBtnsFinModalCombo">
                    <?php echo $this->Form->button('Aceptar', array(
                        'type' => 'button',
                        'class' => 'btn btn-success',
                        'onclick' => 'agregaCombo()'
                    )); ?>
                    <?php echo $this->Form->button('Cancelar', array(
                        'type' => 'button',
                        'class' => 'btn btn-danger',
                        'data-izimodal-close' => '',
                        'onclick' => 'resetModalCombos()'
                    )); ?>
                </div>
            </center>
        </div>
    </div>
</div>
<!--******************************************************************************************************************
* * * * * * * * * * * * * * * * * * * * * * FIN MODAL COMBO * * * *  * * * * * * * * * * * * * * * ** * * * * * * * * * -->

<!--* * * * * * * * * * * * * * * * * * INICIO MODAL AGREGADOS * * * *  * ** * ** * * * * * * * * * -->
<div id="agregaAgregados" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="Agregados" data-izimodal-subtitle="Gestión de agregados">
    <div class="page-content-wrap">
        <div class="row">  
        <input type="hidden" id="selectProducto" value="0">         
            <?php foreach ($cartaNueva['agregados'] as /*$key1 =>*/ $value1) { 
                
            ?>
            <div class="contenedorAgregados">
                <div class="col-md-3">
                    <div class="panel panel-default imageLista">                            
                        <div class="panel-body panel-body-image">
                            <h3 class="center"><?= $value1['ProductoCarta']['producto'] ?></h3>
                        </div>
                        <div class="panel-body">        
                            <div class="col-md-12 center">
                                <button class="btn btn-default btn-block btn-lg" onclick="insertaAgregado(<?= $value1['ProductoCarta']['id'].", '".$value1['ProductoCarta']['producto']."', ". number_format($value1['ProductoCarta']['valor_lista_actual'], 0, ',', ''); ?>)">Seleccionar</button>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <label class="col-md-12 center">$ <?= number_format($value1['ProductoCarta']['valor_lista_actual'], 0, ',', '.') ?></label>
                        </div>
                    </div>    
                </div>
                
            </div>
            <?php } ?>
           
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <center>
                <img src="/img/enviar.gif" class="ocultar gif-cargando" alt="">
                <div id="">                    
                    <?php echo $this->Form->button('Finalizar', array(
                        'type' => 'button',
                        'class' => 'btn btn-success',
                        'data-izimodal-close' => ''
                    )); ?>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- * * * * * * * * * * * * * * * * * FIN MODAL AGREGADOS * * ** * * * * * * * ** * * * * * * * * * -->

<!--* * * * * * * * * * * * * * * * * * INICIO MODAL AGREGADOS * * * *  * ** * ** * * * * * * * * * -->
<div id="detalleAgregados" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="Agregados" data-izimodal-subtitle="Gestión de agregados">
    <div class="page-content">
        <div class="row"> 
            <div class="col-md-3"></div>      
            <div class="col-md-6">                
                <table class=" table center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Agredado</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody class="detalleAgregados">
                        
                    </tbody>
                </table>  
            </div>               
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <center>
                <img src="/img/enviar.gif" class="ocultar gif-cargando" alt="">
                <div id="">                    
                    <?php echo $this->Form->button('Finalizar', array(
                        'type' => 'button',
                        'class' => 'btn btn-success',
                        'data-izimodal-close' => '',
                        'onclick'=>'finalizaAgregados();'
                    )); ?>
                </div>
            </center>
        </div>
    </div>
</div>
    
 
<?= $this->Form->end(); ?>
<?= $this->Html->script(array('custom/custom_comandas.js')); ?>
<?= $this->fetch('script'); ?>


<script>
    $(function(){
        $('#sliding_menu').menu();
        $('#sliding_menu_2').menu();
    });            
</script>
