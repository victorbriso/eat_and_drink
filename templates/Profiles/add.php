<?= $this->Html->scriptBlock(sprintf("var paginasInicio                 = %s;", json_encode($inicios))); ?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <?= $this->Form->create(null, ['enctype' => 'multipart/form-data', 'name'=>'formAdd']); ?>           
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-plus"></span> Agregar Perfil de perfiles</h2></div>
                        <div class="col-md-6">
                            <table width="100%">
                                <tr>
                                    <td>Nombre de perfil</td>
                                    <td align="right"><?= $this->Form->input('nombre', array('class' => 'form-control col-md-8', 'type'=>'text', 'required', 'placeholder'=>'nombre')); ?>  </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>  
                </div>
                <div class="panel-body">                    
                    <? foreach ($perfilesSistema as $key1 => $value) {?>
                        <div class="col-md-12">
                            <h3 style="text-align: center;"><?=$key1?></h3>
                            <div class="row">                                
                                <?foreach ($value as $key2 => $value2) {?>
                                    <div class="col-md-3">
                                        <h4><?= $value2 ?></h4>
                                        <label class="switch">
                                            <?= $this->Form->input('data['.$key1.']['.$key2.']['.$key2.']', array('class' => 'form-control validaPermiso', 'type'=>'checkbox', 'controlador'=>$key1, 'accion'=>$key2)); ?>
                                            <span></span>
                                        </label>
                                    </div>                                    
                                <?}?>
                            </div>
                        </div>
                    <?}?>                    
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                            <?= $this->Form->input('controller', array('type' => 'hidden', 'id'=>'controller')); ?>
                            <?= $this->Form->input('action', array('type' => 'hidden', 'id'=>'action')); ?>
                            <button style="z-index: 998 !important;" class="btn btn-success openModal" modal="modalAperturaCaja" modalAjax="0" >Continuar</button>
                        </div>  
                    </div> 
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<div id="modalAperturaCaja" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa  fa-check-square-o'></span> Apertura Caja" style="z-index: 9999 !important;">
    <div class="page-content-wrap contenedor-iziModal-apertura-caja">
         <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="fa fa-mail-forward"></span> Pantalla de inicio</h3>
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
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.validaPermiso').on('click', function () {
            var controlador = $(this).attr('controlador');
            var accion = $(this).attr('accion');
            alert(controlador+' '+accion);
            if ($('#receta').prop('checked') ){
                $('#tablaReceta').show();
            }else{
                $('#tablaReceta').hide();
            }
        });
    });
</script>