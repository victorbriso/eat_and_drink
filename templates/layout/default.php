<?php
$cakeDescription = 'CEOrestobar';
?>
<!DOCTYPE html>
<html lang="es" style="height: 100%;">
    <head>
        <?= $this->Html->charset() ?>
        <title>
            <?= $cakeDescription ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta Last-Modified: Tue, 04 Feb 2020 07:28:00 GMT />
        <?= $this->Html->meta('icon'); ?>
        <?= $this->Html->css('/backend/css/theme-default.css') ?>
        <?= $this->Html->css('/backend/css/custom.css') ?>
        <?= $this->Html->css('animate.min.css') ?>
        <?= $this->Html->css('iziModal.min.css') ?>
        <?= $this->Html->css('custom.css') ?>
        <?= $this->Html->css('mobile.css') ?>
        <?= $this->fetch('css'); ?>        
        <?= $this->Html->script('/backend/js/plugins/jquery/jquery.min.js') ?>
        <?= $this->Html->script('/backend/js/plugins/jquery/jquery-ui.min.js') ?>
        <?= $this->Html->script('/backend/js/plugins/bootstrap/bootstrap.min.js') ?>
        <?= $this->Html->script('/backend/js/plugins/bootstrap/bootstrap-select.js') ?>
        <?= $this->Html->script('/backend/js/plugins/noty/jquery.noty.js') ?>
        <?= $this->Html->script('/backend/js/plugins/noty/layouts/topCenter.js') ?>
        <?= $this->Html->script('/backend/js/plugins/noty/layouts/topLeft.js') ?>
        <?= $this->Html->script('/backend/js/plugins/noty/layouts/topRight.js') ?>
        <?= $this->Html->script('/backend/js/plugins/noty/themes/default.js') ?>        
        <?= $this->Html->script('/backend/js/plugins.js') ?>
        <?= $this->Html->script('/backend/js/actions.js') ?>
        <?= $this->Html->script('/backend/js/plugins/datatables/jquery.dataTables.min.js') ?>
        <?= $this->Html->script('/backend/js/plugins/icheck/icheck.min.js') ?>
        <?= $this->Html->script('/backend/js/plugins/fileinput/fileinput.min.js') ?>
        <?= $this->Html->script('/backend/js/plugins/bootstrap/bootstrap-datepicker.js') ?>
        <?= $this->Html->script('/backend/js/plugins/slidingmenu/jquery-sliding-menu.js') ?>
        <?= $this->Html->script('/backend/js/plugins/icheck/icheck.min.js') ?>
        <?= $this->Html->script('/backend/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') ?>
        <?= $this->Html->script('jquery.inputmask.bundle.js') ?>
        <?= $this->Html->script('accounting.min.js') ?>
        <?= $this->Html->script('iziModal.min.js') ?>
        <?= $this->Html->script('masonry.js') ?>
        <?= $this->Html->script('jquery.rut.chileno.min.js') ?>
        <?= $this->Html->script('custom_general.js') ?>
        <?= $this->Html->script('custom.js') ?>
        <?= $this->Html->script('/backend/js/actions.js') ?> 
        <?= $this->Html->script('/backend/js/plugins.js') ?>  
        <?= $this->Html->script('/backend/js/settings.js') ?>  
        <?= $this->fetch('script'); ?>
    </head>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-130819740-3');
      //document.oncontextmenu=inhabilitar;
      function inhabilitar(){
        alert ("Funcion no habilitada.")
        return false
    }
    </script>
    <body style="height: 100%;">
        <script type="text/javascript">
            $(".mb-control-close").on("click",function(){
               $(this).parents(".message-box").removeClass("open");
               return false;
            });
        </script>
        <div class="page-container">
            <?= $this->element($menuAdmin); ?>
            <div class="page-content">
                <?= $this->element('menuSuperiorAdmin'); ?>
                <?= $this->fetch('content'); ?>
            </div>
            <?= $this->element('mensajeAlerta'); ?>     
        </div>        
    </body>
</html>

