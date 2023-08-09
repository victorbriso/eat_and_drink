<div class="container-fluid">
    <div class="contenedor-general">
        <div class="container">
            <div class="row">
                <div class="contenedor">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-heading">                    
                                        <h3 style="text-align: center;">Panel</h3>
                                    </div>
                                    <div class="panel-body">
                                        <h3 style="text-align: center; color: #000;">Garzón Express</h3>
                                    </div>
                                    <div class="panel-footer">
                                        <?= $this->Html->link('Ingresar', ['controller'=>'Comandas', 'action'=>'garzonExpress'], ['escape'=>false, 'class'=>'btn btn-warning btn-block']) ?>
                                    </div>
                                </div>
                            </div>
                            <? foreach ($listaUsuarios as $key => $value) {?>
                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">                    
                                            <h3 style="text-align: center;"><?= $value['nombres'] ?></h3>
                                        </div>
                                        <div class="panel-body">
                                            <h3 style="text-align: center; color: #000;"><?= $value['apellidos'] ?></h3>
                                        </div>
                                        <div class="panel-footer">
                                            <button type="button" class="btn btn-warning btn-block password" usuario="<?= $value['id'] ?>" data-toggle="modal" data-target="#addInsumo">Ingresar</button>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="addInsumo">
    <div class="modal-dialog modal-xs" role="document" style="z-index: 999;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class='fa fa-plus-circle'></span> Ingresar Contraseña</h5>
            </div>
            <?= $this->Form->create(null, array('url' => array( 'controller' => 'Users', 'action' => 'validaLoginUsuario'), 'class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
            <div class="modal-body">
                <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <?= $this->Form->input('password', array('class' => 'form-control', 'type'=>'password','required', 'id'=>'passUser')); ?>
                        <?= $this->Form->input('usuarioId', array('class' => 'form-control', 'type'=>'hidden','id'=>'usuario', 'value'=>0)); ?>
                    </div>
                </div>    
                </div>
                
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success pull-right"  autocomplete="off" data-loading-text="Espera un momento..." value="Ingresar">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Cerrar</button>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.password').on('click', function(){
            var usuarioId = $(this).attr('usuario');
            $('#usuario').val(usuarioId);
            $('#passUser').focus();
        });
    });
</script>