<? header('Content-type: text/html; charset=UTF-8');  ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CEOrestobar</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <?= $this->Html->meta('favicon.ico', '/favicon.ico', array('type' => 'icon')); ?>
        <!-- Variables Globales JS -->
        <!-- Call CSS -->
        <?= $this->Html->css(array(
            'bootstrap.min.css', 'home_plataforma.css', 'mobile_plataforma.css'
        )); ?>

        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>
        <?= $this->Html->script(array(
            'jquery.min.js', 'bootstrap.min.js'
        )); ?>
        <?= $this->fetch('script'); ?>
</head>
<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130819740-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-130819740-3');
    </script>
<body>
    <?php echo $this->fetch('content'); ?>
    <?= $this->element('mensajeAlerta'); ?>
</body>    
        <script type="text/javascript">
            $(".mb-control-close").on("click",function(){
               $(this).parents(".message-box").removeClass("open");
               return false;
            });
        </script>
</html>