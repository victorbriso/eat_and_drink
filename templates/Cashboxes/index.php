<div class="page-title">
    <h2><span class="fa fa-list"></span> Cajas</h2>
</div>
<div class="page-content-wrap modulo-cajas">    
    <? if(isset($roles['cajas']['add'])){?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-4 center col-md-offset-4">
                             <button class="btn btn-success btn-block openModal" modal="modalAddCaja" modalAjax="0" style="z-index: 9999 !important;"><i class="fa fa-plus"></i> Nueva Caja</button>
                        </div>                             
                    </div>
                </div>
                
            </div>
        </div>
    <? } ?>
    <div class="row">
        <?php foreach ($cajas as $key => $caja) { ?>
            <div class="col-md-3 contenedor-caja">
                <div class="widget widget-default widget-item-icon">
                    <div class="widget-item-right">                                
                        <?php if (  $caja['estado']==1 ) { ?>
                            <button style="z-index: 998 !important;" class="btn btn-xs btn-success openModal apertura-caja" modal="modalAperturaCaja" modalAjax="0" id_registro="<?= $caja['id']; ?>" usuario=<?= $caja['usuario_id'] ?>>Apertura</button>
                        <?php } elseif($caja['estado']==2) {  ?>
                             <?= $this->Html->link('Cierre', array('controller' => 'Cashboxes','action' => 'cierre',$caja['id']), array('class' => 'btn btn-xs btn-danger', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Cerrar Caja', 'escape' => false)); ?>
                        <?php } ?>                               
                        <?php if (  $caja['estado']==2 ) { ?>
                            <?= $this->Html->link('Estado', array('controller' => 'Cashboxes','action' => 'cajas_estado',$caja['id']), array('class' => 'btn btn-xs btn-warning', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Cerrar Caja', 'escape' => false)); ?>
                        <?php } ?>
                        <?php if (  $caja['estado']==2 ) { ?>
                            <button style="z-index: 998 !important;" class="btn btn-xs btn-ed openModal btn-pago-cuenta" modal="modalPagarCuenta" id_registro="<?= $caja['id']; ?>" cajero="<?= $caja['usuario_id'];?>">Pago</button>
                        <?php } ?>
                    </div>                             
                    <div class="widget-data-left">
                        <div class="widget-int num-count total-caja center"><?= $caja['nombre']; ?></div>
                        <? if ( $caja['estado']==1||$caja['estado']==2 ){ ?>
                            <div class="widget-title center"><?= $caja['usuario']['nombres'] ?> <?= $caja['usuario']['apellidos'] ?></div>
                        <?}?>
                        <?php if ( $caja['estado']==0 ) { ?>
                            <div class="widget-title center">
                                <select name="usuario_id" class="form-control select_usuario <?=$caja['id']?>" caja="<?=$caja['id']?>" data-live-search>
                                    <option disabled="" selected="">--Seleccione</option>
                                    <? foreach ($cajeros as $key => $value) {
                                        if($value['caja_activa']){?>
                                            <option disabled=""><?= $value['nombres'].' '.$value['apellidos'] ?></option>
                                        <?}else{?>
                                            <option id="<?=$value['id']?>"><?= $value['nombres'].' '.$value['apellidos'] ?></option>
                                        <?}
                                    }?>
                                </select>
                            </div>
                            <div class="widget-title center">
                                 <?= $this->Html->link('Asignar', array('controller' => 'Cashboxes','action' => 'asignarUsuarioCaja', $caja['id']), array('class' => 'btn btn-xs btn-ed btn_asginar_caja_'.$caja['id'].'', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Asignar Usuario', 'escape' => false)); ?>
                            </div>
                        <?}?>
                    </div>                                      
                </div>
                <div class="col-md-12" style="display: inline-block;">
                    <?php if (  $caja['estado']==2 ) { ?> 
                        <div class="col-md-6" style="display: inline-block;">
                            <button class="btn btn-block btn-success openModal generar-ingreso" id_registro="<?= $caja['id']; ?>" modal="modalAddIngreso" modalAjax="0"><i class="fa fa-plus"></i>Ingreso</button>                                  
                        </div> 
                        <div class="col-md-6" style="display: inline-block;">
                            <button class="btn btn-block btn-danger openModal generar-egreso" id_registro="<?= $caja['id']; ?>" efectivo="<?= $caja['efectivo']; ?>" modal="modalAddEgreso" modalAjax="0"><i class="fa fa-minus"></i>Egreso</button>                                     
                        </div> 
                    <? } ?>
                </div> 
            </div>
        <?php } ?> 
    </div>
</div>
<div id="modalPagarCuenta" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-dollar'></span> PAGAR CUENTA">
     <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Cashboxes', 'action' => 'pagoCuenta'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
                    <?= $this->Form->input('caja_id_modal_pago', array('type' => 'hidden', 'value' => '', 'id'=>'ComandaCajaIdModalPago')); ?>
                    <?= $this->Form->input('cajero_id', array('type' => 'hidden', 'value' => '', 'id'=>'modalPagoCajeroId')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-dollar"></span><strong> Pago</strong> Cuenta </h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body form-group-separated">                                                                        
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Ingrese el folio</label>
                                        <div class="col-md-6 col-xs-12 div_campo_js campo_requerido_ComandaFolio">    
                                            <?= $this->Form->input('folio', array('type' => 'number', 'class' => 'form-control obligatorio_js', 'mensaje_requerido' => 'Se requiere el número del folio.', 'required')); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <input type="submit" class="btn btn-success esperar-carga btn-form-submit" autocomplete="off" data-loading-text="Espera un momento..." value="PAGAR CUENTA" idform="ComandaPagoCuentaForm" editForm="0" campoForm="folio">
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
* * * * * * * * * * * * * * * * * * * * * * MODAL ADD  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * -->
<div id="modalAddCaja" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Cajas">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Cajas', 'action' => 'add'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-mail-forward"></span><strong> Nueva</strong> Caja </h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body form-group-separated">                                                                        
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if ( ! empty($salones) ) { ?>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Salón</label>
                                            <div class="col-md-6 col-xs-12">    
                                                <?= $this->Form->input('salon_id', array('class' => 'form-control', 'options' => $salones)); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Nombre / Numeración</label>
                                        <div class="col-md-6 col-xs-12 div_campo_js campo_requerido_CajaNombre">    
                                            <?= $this->Form->input('nombre', array('class' => 'form-control verifica_campo_addCaja obligatorio_js verificarbbdd', 'campo' => 'nombre', 'controlador' => 'Caja', 'mensaje_requerido' => 'Se requiere el nombre / numeración de la caja.', 'required')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <input type="button" style="z-index: 998 !important;" class="btn btn-primary esperar-carga form-validacion btn-form-submit" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios" idform="CajaAddForm" editForm="0" campoForm="addCaja">
                                <button style="z-index: 998 !important;" data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                            </div>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
 </div>

 <!--******************************************************************************************************************
* * * * * * * * * * * * * * * * * * * * * * MODAL APERTURA CAJA  * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * -->
<div id="modalAperturaCaja" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa  fa-check-square-o'></span> Apertura Caja" style="z-index: 9999 !important;">
    <div class="page-content-wrap contenedor-iziModal-apertura-caja">
         <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Cashboxes', 'action' => 'apertura'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
                     <?= $this->Form->input('usuario_id', array('type' => 'hidden')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-mail-forward"></span><strong> Apertura</strong> Caja </h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body form-group-separated">                                                                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Monto de apertura ($)</label>
                                        <div class="col-md-6 col-xs-12">    
                                            <?= $this->Form->input('monto', array('class' => 'form-control input-number campo_modena right')); ?>
                                            <?= $this->Form->input('apertura_caja_id', array('type' => 'hidden', 'id'=>'CajaAperturaCajaId')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <input type="submit" class="btn btn-primary esperar-carga btn-form-submit" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios" idform="CajaAperturaForm" editForm="0" campoForm="apertura">
                                <button style="z-index: 998 !important;" data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                            </div>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<!--******************************************************************************************************************
* * * * * * * * * * * * * * * * * * * * * * MODAL INGRESO ADD  * * * * * * * * * * * * * * * * * * * * * * * * * * * * -->
<div id="modalAddIngreso" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Ingresos" style="z-index: 9999 !important;">
    <div class="page-content-wrap"> 
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Cashboxes', 'action' => 'ingresoRetiro'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-mail-forward"></span><strong> Nuevo</strong> Ingreso </h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body form-group-separated">                                                                
                            <div class="row">
                                <div class="col-md-12">                                    
                                        <?= $this->Form->input('caja_id', array('type' => 'hidden', 'id'=>'IngresoCajaId')); ?>
                                        <?= $this->Form->input('tipo', array('type' => 'hidden', 'value'=>2)); ?>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">monto</label>
                                        <div class="col-md-6 col-xs-12 div_campo_js campo_requerido_IngresoMonto">
                                            <?= $this->Form->input('monto', array('class' => 'form-control input-number campo_modena right', 'type'=>'text', 'min'=>0, 'step'=>1, 'label'=>false, 'id'=>'efectivoMontoIngreso', 'onkeyup'=>'validaIngreso();')); ?>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Motivo</label>
                                        <div class="col-md-6 col-xs-12">   
                                         <?= $this->Form->input('motivo', array('class' => 'form-control', 'maxlength'=>'250')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <input type="submit" class="btn btn-primary" autocomplete="off" data-loading-text="Espera un momento..." value="Procesar" idform="IngresoAddForm" editForm="0" campoForm="addIngreso" id="bttnEnviaIngreso">
                                 <button style="z-index: 998 !important;" data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                            </div>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<!--******************************************************************************************************************
* * * * * * * * * * * * * * * * * * * * * * MODAL EGRESO ADD  * * * * * * * * * * * * * * * * * * * * * * * * * * * * -->
<div id="modalAddEgreso" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Egresos" style="z-index: 9999 !important;">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Cashboxes', 'action' => 'ingresoRetiro'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'), 'id'=>'formRetiro')); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-mail-forward"></span><strong> Nuevo</strong> Egreso </h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body form-group-separated">                                                                        
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $this->Form->input('caja_id', array('type' => 'hidden', 'id'=>'EgresoCajaId')); ?>
                                    <?= $this->Form->input('tipo', array('type' => 'hidden', 'value'=>3)); ?>
                                    <?= $this->Form->input('maxRetiro', array('type' => 'hidden', 'value'=>0, 'id'=>'maxRetiro')); ?>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">monto</label>
                                        <div class="col-md-6 col-xs-12 div_campo_js campo_requerido_EgresoMonto">    
                                            <?= $this->Form->input('monto', array('class' => 'form-control input-number campo_modena right', 'type'=>'text', 'min'=>0, 'step'=>1, 'label'=>false, 'id'=>'efectivoMontoEgreso')); ?>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Motivo</label>
                                        <div class="col-md-6 col-xs-12">   
                                         <?= $this->Form->input('motivo', array('class' => 'form-control', 'maxlength'=>'250')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary validaEgreso">Procesar</button>
                                <button style="z-index: 998 !important;" data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                            </div>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $( document ).ready(function() { 
        $('.apertura-caja').on('click', function (event) {
            event.preventDefault();
            var id_caja =   $(this).attr('id_registro');
            $('#CajaAperturaCajaId').val(id_caja);
        });
        $('.btn-pago-cuenta').on('click', function(event){
            event.preventDefault();
            var id_caja =   $(this).attr('id_registro');
            var cajero = $(this).attr('cajero');
            $('#ComandaCajaIdModalPago').val(id_caja);
            $('#modalPagoCajeroId').val(cajero);
        });
        $('.generar-ingreso').on('click', function (event) {
            event.preventDefault();
            var id_caja =   $(this).attr('id_registro');
            $('#IngresoCajaId').val(id_caja);
        });
        $('.generar-egreso').on('click', function (event) {
            event.preventDefault();
            var id_caja =   $(this).attr('id_registro');
            var efectivo =   $(this).attr('efectivo');
            $('#EgresoCajaId').val(id_caja);
            $('#maxRetiro').val(efectivo);
        });
        $('#modalAddEgreso').on('click', '.validaEgreso', function () {
            var retiroUsuario=$('#efectivoMontoEgreso').val();
            var retiroSistema = parseInt(replaceAll(retiroUsuario, ".", ""));
            if(retiroSistema>parseInt($('#maxRetiro').val())){
                alert('El monto a retirar debe ser menor al saldo de efectivo en caja');
            }else{
                var formulario = document.getElementById("formRetiro");
                formulario.submit();
            }
        });
    });
    function replaceAll(text, busca, reemplaza ){
      while (text.toString().indexOf(busca) != -1)
          text = text.toString().replace(busca,reemplaza);
      return text;
    }
</script>

