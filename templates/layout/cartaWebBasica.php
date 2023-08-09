<?php
$cakeDescription = 'CEOrestobar';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>    
    <?= $this->Html->script('carta/jquery.js') ?>
    <?= $this->Html->script('carta/jquery.min.js') ?>
    <?= $this->Html->script('carta/bootstrap.bundle.js') ?>
    <?= $this->Html->script('carta/bootstrap.bundle.min.js') ?>
    <?= $this->Html->script('carta/bootstrap.js') ?>
    <?= $this->Html->script('carta/bootstrap.min.js') ?>
    <?= $this->Html->css('carta/bootstrap-grid.css') ?>
    <?= $this->Html->css('carta/bootstrap-grid.min.css') ?>
    <?= $this->Html->css('carta/bootstrap-reboot.css') ?>
    <?= $this->Html->css('carta/bootstrap-reboot.min.css') ?>
    <?= $this->Html->css('carta/bootstrap.css') ?>
    <?= $this->Html->css('carta/bootstrap.min.css') ?>
    <?= $this->Html->css('carta/style.css') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="container-fluid">
        <div class="col-12 col-md-12">
            <div class="row">
                <div class="col-md-12"><h3>contenido header</h3></div>
                <div class="col-12 col-md-3">
                    <?= $this->element('menuWebBasico'); ?>                 
                </div>
                <div class="col-md-9">
                    <?= $this->fetch('content'); ?>
                </div>
            </div>          
        </div>
        <?= $this->element('footerCartaWeb'); ?>
    </div>
</body>
</html>