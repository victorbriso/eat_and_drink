<?php if ( $this->request->getSession()->check('mensajeAlerta') ) { 
    $mensaje        = $this->request->getSession()->consume('mensajeAlerta');

    $ventana        = array(
        'error' =>  '',
        'success'   =>  'message-box-success'
    );

    $icon_ventana   =   array(
        'error'     =>  'fa fa-times',
        'success'   =>  'fa fa-check'
    );
?>
    <!-- Message Boxes -->
    <div class="message-box message-box-<?= $mensaje['tipo'] ?> animated fadeIn open" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="<?= $icon_ventana[$mensaje['tipo']] ?>"></span><?= $mensaje['titulo'] ?></div>
                <div class="mb-content">
                    <p><?= $mensaje['texto'] ?></p>
                </div>
                <div class="mb-footer">
                    <button class="btn btn-default btn-lg pull-right mb-control-close">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Message Boxes -->
<?php } ?>


<!-- Message Boxes -->
<div class="message-box  animated fadeIn" id="alerta_datos_registrados">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-times"></span>Importante</div>
            <div class="mb-content">
                <p>La informaci&oacute;n que se est&aacute; ingresando ya está registrada</p>
            </div>
            <div class="mb-footer">
                <button class="btn btn-default btn-lg pull-right mb-control-close">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<!-- Message Boxes -->


<!-- Message Boxes -->
<div class="message-box  animated fadeIn" id="alerta_js">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-times"></span>Importante</div>
            <div class="mb-content">
                <p class="texto-alerta-js"></p>
            </div>
            <div class="mb-footer">
                <button class="btn btn-default btn-lg pull-right mb-control-close">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<!-- Message Boxes -->

<!-- Message Boxes -->
<div class="message-box  animated fadeIn" id="alerta_monto_pago_superior">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-times"></span>Importante</div>
            <div class="mb-content">
                <p class="texto-alerta-js"></p>
            </div>
            <div class="mb-footer">
                <button class="btn btn-default btn-lg pull-right mb-control-close">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<!-- Message Boxes -->