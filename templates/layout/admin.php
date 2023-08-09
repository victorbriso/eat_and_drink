<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Proyecto | Administración</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?= $this->Html->meta('icon'); ?>
		<?= $this->Html->css('/backend/css/theme-default.css') ?>
		<?= $this->Html->css('/backend/css/dashboard-dark.css') ?>
		<?= $this->Html->css('/backend/css/custom.css') ?>
		<?= $this->Html->css('animate.min.css') ?>
		<?= $this->fetch('css'); ?>
		<?= $this->Html->script('/backend/js/plugins/jquery/jquery.min.js') ?>
		<?= $this->Html->script('/backend/js/plugins/bootstrap/bootstrap.min.js') ?>
		<?= $this->Html->script('/backend/js/plugins/bootstrap/bootstrap-select.js') ?>
		<?= $this->Html->script('/backend/js/plugins.js') ?>
		<?= $this->Html->script('/backend/js/plugins/datatables/jquery.dataTables.min.js') ?>
		<?= $this->Html->script('/backend/js/plugins/icheck/icheck.min.js') ?>
		<?= $this->Html->script('/backend/js/plugins/fileinput/fileinput.min.js') ?>
		<?= $this->Html->script('/backend/js/plugins/bootstrap/bootstrap-datepicker.js') ?>
		<?= $this->Html->script('jquery.inputmask.bundle.js') ?>
		<?= $this->Html->script('accounting.min.js') ?>
		<?= $this->Html->script('/backend/js/custom.js') ?>
		<?= $this->fetch('script'); ?>
	</head>
	<body class="x-dashboard-dark">
        <div class="page-container">
            <div class="page-content">
            	<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                	<?= $this->element('menuAdminGeneral'); ?>
                	<div class="page-content-dark">
                		<?= $this->fetch('content'); ?>
                	</div>
					
				</div>
			</div>
			<?= $this->element('mensajeAlerta'); ?>
		</div>
        <audio id="audio-alert" src="<?= $this->Html->url('/backend/audio/alert.mp3'); ?>" preload="auto"></audio>
        <audio id="audio-fail" src="<?= $this->Html->url('/backend/audio/fail.mp3'); ?>" preload="auto"></audio>
		<?= $this->Html->script('/backend/js/actions'); ?>
    </body>
</html>