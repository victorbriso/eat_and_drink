<?= $this->Html->scriptBlock(sprintf("var carta                 = %s;", json_encode($carta))); ?>
<div class="row mt-5">
	<? foreach ($carta as $key1 => $value1) {?>
		<div class="col-12 col-md-12" id="<?=$key1?>">
			<h4 style="text-align: center;"><?=$value1['nombre']?></h4>
			<div class="row">
				<?foreach ($value1['productos'] as $key2 => $value2) {?>
					<div class="col-12 col-md-4" style="margin-top:10px; margin-bottom: 5px; ">
						<div class="card" style="width: 18rem;">
							<? $img=(file_exists(ROOT.'/webroot/img/img_cat/'.$localId.'/'.$key1.'.'.$value1['extension']))?'img_cat/'.$localId.'/'.$key1.'.'.$value1['extension']:'404-error.jpg'; ?>
		                    <?= $this->Html->image($img, ['style'=>['width:100%;','height:150px;'], 'class'=>'card-img-top', 'alt'=>$value1['nombre']]) ?>
							<div class="card-body">
								<h5 class="card-title"><?=$value2['nombre']?></h5>
								<p class="card-text"><?= (!empty($value2['desc_es']))?$value2['desc_es']:'Sin descripción'; ?></p>
							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item center" style="text-align: center;">$<?= number_format($value2['precio_actual'], 0, ',', '.')?></li>
							</ul>
						</div>
					</div>
				<?}?>
			</div>	
		</div>	
	<?}?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.filtro').on('click', function(){
			var categoria = $(this).attr('categoria');
			if(categoria!=0){
				$.each(carta, function( index, value ) {
	            	if(categoria==index){
	            		$('#'+index).show();
	            	}else{
	            		$('#'+index).hide();
	            	}
	        	});
			}else{
				$.each(carta, function( index, value ) {
	            	$('#'+index).show();
	        	});
			}
			
		});
	});
</script>