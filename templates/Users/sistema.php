<? $chekDelivery=($data[0]['delivery'])?'checked':'unchecked'; $chekVtaWeb=($data[0]['venta_web'])?'checked':'unchecked'; $chekReservas=($data[0]['config_reservas']['admite'])?'checked':'unchecked'; $chekInventario=($data[0]['inventario'])?'checked':'unchecked'; ?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">                    
                    <div class="row">
                        <div class="col-md-6">
                            <h2><span class="fa fa-cogs"></span> Configuración Sistema</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <? if($data[0]['config_reservas']['admite']){?>
                                        <button type="button" class="btn btn-warning pull-right openModal"  modal="modalConfigReservas" modalAjax="0" style="z-index: 9999 !important;"><i class="fa fa-cog"></i> Configurar reservas</button>
                                    <?} ?>
                                    
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger pull-right openModal" modal="modalCambioPass" modalAjax="0" style="z-index: 9999 !important;"><i class="fa fa-pencil-square-o"></i> Cambiar contraseña</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->Form->create(); ?>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="center">Información del local</h3>
                                <table class="table">
                                    <tr>
                                        <td>Nombre de usuario</td>
                                        <td><?= $this->Form->input('usuario', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$data[0]['username'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nombre Local</td>
                                        <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$data[0]['nombre'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Razón Social</td>
                                        <td><?= $this->Form->input('razonSocial', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$data[0]['razon_social'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dirección</td>
                                        <td><?= $this->Form->input('direccion', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$data[0]['direccion'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Logo</td>
                                        <td>
                                            <? $img=(file_exists(ROOT.'/webroot/img/logos/'.$data[0]['id'].'.'.$data[0]['estension']))?'logos/'.$data[0]['id'].'.'.$data[0]['estension']:'404-error.jpg'; ?>
                                            <?= $this->Html->image($img, ['style'=>'max-width:150px;','max-height:100px;']) ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h3 class="center">Configuración del sistema</h3>
                                <table class="table">
                                    <tr>
                                        <td>Delivery</td>
                                        <td align="center">
                                            <label class="switch">
                                                <?= $this->Form->input('delivery', array('class' => 'form-control', 'type'=>'checkbox', $chekDelivery)); ?>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><button type="button" class="btn btn-info pull-right ayuda" tipo="1"><i class="fa fa-info-circle"></i></button></td>
                                    </tr>
                                    <tr id="ayuda1" style="display: none;">
                                        <td colspan="3" align="center">
                                            <p>Activa esta opción si tu local realiza delivery</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Venta web</td>
                                        <td align="center">
                                            <label class="switch">
                                                <?= $this->Form->input('vta_web', array('class' => 'form-control', 'type'=>'checkbox', $chekVtaWeb)); ?>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><button type="button" class="btn btn-info pull-right ayuda" tipo="2"><i class="fa fa-info-circle"></i></button></td>
                                    </tr>
                                    <tr id="ayuda2" style="display: none;">
                                        <td colspan="3" align="center">
                                            <p>Activa esta opción si vendes para que los clientes vayan a retirar</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Reservas</td>
                                        <td align="center">
                                            <label class="switch">
                                                <?= $this->Form->input('reservas', array('class' => 'form-control', 'type'=>'checkbox', $chekReservas)); ?>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><button type="button" class="btn btn-info pull-right ayuda" tipo="3"><i class="fa fa-info-circle"></i></button></td>
                                    </tr>
                                    <tr id="ayuda3" style="display: none;">
                                        <td colspan="3" align="center">
                                            <p>Activa esta opción si tu local maneja reserva de mesas</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Inventario</td>
                                        <td align="center">
                                            <label class="switch">
                                                <?= $this->Form->input('inventario', array('class' => 'form-control', 'type'=>'checkbox', $chekInventario)); ?>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><button type="button" class="btn btn-info pull-right ayuda" tipo="4"><i class="fa fa-info-circle"></i></button></td>
                                    </tr>
                                    <tr id="ayuda4" style="display: none;">
                                        <td colspan="3" align="center">
                                            <p>Activa esta opción si vas a llevar el inventario por el sistema</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <input type="submit" value="Guardar" class="btn btn-success">
                        </div>  
                    </div>      
                </div>
                <?= $this->Form->end(); ?>
            </div>
            </div>
        </div>
    </div>
</div>
<div id="modalCambioPass" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="Mantencion usuario">
     <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Users', 'action' => 'cambioContrasenha'), 'class' => 'form-horizontal', 'type' => 'file', 'name'=>'formCambioPass', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-pencil-square-o"></span><strong> Cambio</strong> Contraseña</h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body form-group-separated">                                                                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Ingrese contraseña</label>
                                        <div class="col-md-6 col-xs-12">    
                                            <?= $this->Form->input('pass1', array('type' => 'password', 'class' => 'form-control', 'id'=>'pass1')); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Re-ingrese la contraseña</label>
                                        <div class="col-md-6 col-xs-12">    
                                            <?= $this->Form->input('pass2', array('type' => 'password', 'class' => 'form-control', 'id'=>'pass2')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <button type="button" class="btn btn-success validaContrasenha">Actualizar</button>
                                <button data-izimodal-close="" class="btn btn-danger btn-form-submit">Cancelar</button>
                            </div>
                        </div>
                    </div>

                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<div id="modalConfigReservas" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<i class='fa fa-cogs'></i> Configuracion de reservas">
     <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, array('url' => array( 'controller' => 'Users', 'action' => 'configReserva'), 'class' => 'form-horizontal', 'type' => 'file', 'name'=>'formCambioPass', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-calendar"></span><strong> Reservas</strong></h3>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel-body form-group-separated">                                                                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Planificación</label>
                                        <div class="col-md-6 col-xs-12">    
                                            <?= $this->Form->input('futuro', array('type' => 'number', 'class' => 'form-control', 'value'=>$data[0]['config_reservas']['futuro'])); ?>
                                            <span class="help-block">Máximo de días a gestionar de reservas</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Mínimo para reservar</label>
                                        <div class="col-md-6 col-xs-12">    
                                            <?= $this->Form->input('anticipacion', array('type' => 'number', 'class' => 'form-control', 'value'=>$data[0]['config_reservas']['anticipacion'])); ?>
                                            <span class="help-block">Mínimo de horas a gestionar de reservas</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Plazo de atraso máximo</label>
                                        <div class="col-md-6 col-xs-12">    
                                            <?= $this->Form->input('atraso', array('type' => 'number', 'class' => 'form-control', 'value'=>$data[0]['config_reservas']['atraso'])); ?>
                                            <span class="help-block">Minutos que vas a esperar al clientes antes de anular la reserva</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Monto de abono para reserva</label>
                                        <div class="col-md-6 col-xs-12">    
                                            <?= $this->Form->input('abono', array('type' => 'number', 'class' => 'form-control', 'min'=>0, 'value'=>$data[0]['config_reservas']['abono'])); ?>
                                            <span class="help-block">Cobro anticipado, despues lo descuentas de la cuenta, y aseguras la llegada del cliente</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <input type="submit" value="Guardar" class="btn btn-success">
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
    $(document).ready(function(){
        var h1=0;
        var h2=0;
        var h3=0;
        var h4=0;
        $('.ayuda').on('click', function(){
            var numeroH=$(this).attr('tipo');
            if(numeroH==1){
                if(h1==0){
                    h1=1;
                    $('#ayuda'+numeroH).show();
                }else{
                    h1=0;
                    $('#ayuda'+numeroH).hide();
                }
            }
            if(numeroH==2){
                if(h2==0){
                    h2=1;
                    $('#ayuda'+numeroH).show();
                }else{
                    h2=0;
                    $('#ayuda'+numeroH).hide();
                }
            }
            if(numeroH==3){
                if(h3==0){
                    h3=1;
                    $('#ayuda'+numeroH).show();
                }else{
                    h3=0;
                    $('#ayuda'+numeroH).hide();
                }
            }
            if(numeroH==4){
                if(h4==0){
                    h4=1;
                    $('#ayuda'+numeroH).show();
                }else{
                    h4=0;
                    $('#ayuda'+numeroH).hide();
                }
            }
        });
        $('#modalCambioPass').on('click', '.validaContrasenha', function(){
            var pass1=$('#pass1').val();
            var pass2=$('#pass2').val();
            if(pass2==pass1){
                document.formCambioPass.submit()
            }else{
                alert('Las contraseñas ingresadas no coinciden');
            }
        });
    });
</script>