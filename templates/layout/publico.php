<?php
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?= $this->Html->charset() ?>
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta Last-Modified: Tue, 04 Feb 2020 07:28:00 GMT />
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">
        <?= $this->Html->meta('icon'); ?>
        <?= $this->Html->css('public/animate.css') ?>
        <?= $this->Html->css('public/icomoon.css') ?>
        <?= $this->Html->css('public/bootstrap.css') ?>
        <?= $this->Html->css('public/magnific-popup.css') ?>
        <?= $this->Html->css('public/owl.carousel.min.css') ?>
        <?= $this->Html->css('public/owl.theme.default.min.css') ?>
        <?= $this->Html->css('public/style.css') ?>
        <?= $this->fetch('css'); ?>        
        <?= $this->Html->script('public/modernizr-2.6.2.min.js') ?>
        <?= $this->Html->script('public/jquery.min.js') ?>
        <?= $this->Html->script('public/jquery.easing.1.3.js') ?>
        <?= $this->Html->script('public/bootstrap.min.js') ?>
        <?= $this->Html->script('public/jquery.waypoints.min.js') ?>
        <?= $this->Html->script('public/jquery.stellar.min.js') ?>
        <?= $this->Html->script('public/owl.carousel.min.js') ?>
        <?= $this->Html->script('public/jquery.countTo.js') ?>
        <?= $this->Html->script('public/jquery.magnific-popup.min.js') ?>
        <?= $this->Html->script('public/magnific-popup-options.js') ?>
        <?= $this->Html->script('public/main.js') ?>  
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
    <body>
        <script type="text/javascript">
            $(".mb-control-close").on("click",function(){
               $(this).parents(".message-box").removeClass("open");
               return false;
            });
        </script>
        <div class="fh5co-loader"></div>
        <div id="page">
            <?= $this->element('menuPublico'); ?>
            <?= $this->element('headerPublico'); ?>
            <?= $this->fetch('content'); ?>
            <?= $this->element('footerPublico'); ?>
        </div>
        <div class="gototop js-top">
            <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
        </div>    
    </body>
</html>