<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Xeon | OnePage Responsive Theme</title>
    <?= $this->Html->css('/landing/css/bootstrap.min.css') ?>
    <?= $this->Html->css('/landing/css/font-awesome.min.css') ?>
    <?= $this->Html->css('/landing/css/fontawesome.css') ?>
    <?= $this->Html->css('/landing/css/fontawesome.min.css') ?>
    <?= $this->Html->css('/landing/css/prettyPhoto.css') ?>
    <?= $this->Html->css('/landing/css/main.css') ?>
    <?= $this->fetch('css'); ?>
    <?= $this->Html->script('/landing/js/jquery.js') ?>
    <?= $this->Html->script('/landing/js/bootstrap.min.js') ?>
    <?= $this->Html->script('/landing/js/jquery.isotope.min.js') ?>
    <?= $this->Html->script('/landing/js/jquery.prettyPhoto.js') ?>
    <?= $this->Html->script('/landing/js/main.js') ?>
    <?= $this->fetch('script'); ?>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="landing/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="landing/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="landing/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="landing/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
    <body data-spy="scroll" data-target="#navbar" data-offset="0">
        <?= $this->fetch('content'); ?>
    </body>
</html>