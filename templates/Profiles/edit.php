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
                                    <td align="right">
                                        <?= $this->Form->input('nombre', array('class' => 'form-control col-md-8', 'type'=>'text', 'required', 'value'=>$perfilEdit[0]['nombre'])); ?>
                                        <?= $this->Form->input('id', array('type'=>'hidden', 'value'=>$perfilEdit[0]['id'])); ?>
                                    </td>
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
                                <?foreach ($value as $key2 => $value2) {$chekPermiso=(isset($perfilEdit[0]['roles'][$key1][$key2]))?'checked':'unchecked';?>
                                    <div class="col-md-3">
                                        <h4><?= $value2 ?></h4>
                                        <label class="switch">
                                            <?= $this->Form->input('data['.$key1.']['.$key2.']['.$key2.']', array('class' => 'form-control validaPermiso', 'type'=>'checkbox', 'controlador'=>$key1, 'accion'=>$key2, $chekPermiso)); ?>
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
<div id="modalAperturaCaja" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa  fa-desktop'></span>" style="z-index: 9999 !important;">
    <div class="page-content-wrap contenedor-iziModal-apertura-caja">
         <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="fa fa-mail-forward"></span> Pantalla de inicio</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="row">
                                <? foreach ($inicios as $key3 => $value3) {
                                    foreach ($value3['data'] as $key4 => $value4) {?>
                                        <div class="col-md-3">
                                            <div class="radio">
                                                <label>
                                                    <input class="radioInicio" type="radio" name="optionsRadios" id="optionsRadios1" value="<?= $key3.'-'.$key4 ?>">
                                                    <?=$value3['seccion']?>-<?=$value4?>
                                                </label>
                                            </div>
                                        </div>
                                    <?}
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <button style="z-index: 998 !important;" class="btn btn-primary btn-form-submit enviaForm">Guardar</button>
                            <button style="z-index: 998 !important;" data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    console.log(paginasInicio);
    $(document).ready(function(){
        $('.validaPermiso').on('click', function () {
            var controlador = $(this).attr('controlador');
            var accion = $(this).attr('accion');
            if ($(this).prop('checked') ){
                if(paginasInicio[controlador][accion].length>1){
                    var optionPantalla='<option id="'+controlador+accion+'">'+paginasInicio[controlador][accion]+'</option>';
                    $('#pantallasInicio').prepend(optionPantalla);
                }
            }else{
                if(paginasInicio[controlador][accion].length>1){
                    var optionPantalla='<option id="'+controlador+accion+'">'+paginasInicio[controlador][accion]+'</option>';
                    $('#pantallasInicio').remove(controlador+accion);
                }
            }
        });
        $('#modalAperturaCaja').on('click', '.radioInicio', function () {
            var varSelect = $(this).val();
            var varSelect=varSelect.split('-');
            $('#controller').val(varSelect[0]);
            $('#action').val(varSelect[1]);
        });
        $('#modalAperturaCaja').on('click', '.enviaForm', function () {
            if($('#controller').val()!=''&&$('#action').val()!=''){
                document.formAdd.submit();
            }else{
                alert('Debe seleccionar una pantalla de inicio para el perfil');
            }            
        });
    });
</script>