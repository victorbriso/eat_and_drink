<?= $this->Html->css('/backend/css/cropper/cropper.min.css') ?>
<?= $this->Html->css('/backend/css/jstree/jstree.min.css') ?>
<?= $this->fetch('css'); ?>  
<?= $this->Html->script(array('/backend/js/plugins/dropzone/dropzone.min.js')); ?>
<?= $this->Html->script(array('/backend/js/plugins/filetree/jqueryFileTree.js')); ?>
<?= $this->Html->script(array('/backend/js/plugins/cropper/cropper.min.js')); ?>
<?= $this->Html->script(array('/backend/js/plugins/jstree/jstree.min.js')); ?>
<?= $this->Html->script(array('/backend/js/demo_file_handling.js')); ?>
<?= $this->fetch('script'); ?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">             
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-plus"></span> Ajuste de imagen</h2>
                </div>
                <?= $this->Form->create(null, ['enctype' => 'multipart/form-data']); ?>
                <div class="panel-body">
                 	<div class="col-md-12">
                        <div class="panel panel-default">                                
                            <div class="panel-body">
                                <div class="row-fluid">                                        
                                    <div class="col-md-8">                                            
                                        <div class="cropping-image-wrap">
                                        	<?= $this->Html->image('img_carta/'.$localId.'/'.$data[0]['id'].'.'.$data[0]['extension'], ['class'=>'img-responsive']) ?>
                                        </div>                                                                                                                                    
                                    </div>
                                    <div class="col-md-4 form-horizontal">
                                        <div class="form-group">
                                            <div class="col-md-12">                                                                                                        
                                                <button id="crop_zoomIn" type="button" class="btn btn-primary">
                                                    <span class="fa fa-search-plus"></span> Zoom In
                                                </button>                                                        
                                                <button id="crop_zoomOut" type="button" class="btn btn-primary">
                                                    <span class="fa fa-search-minus"></span> Zoom Out
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button id="crop_rotateLeft" type="button" class="btn btn-primary">
                                                    <span class="fa fa-reply"></span> Rotate Left
                                                </button>                                                   
                                                <button id="crop_rotateRight" type="button" class="btn btn-primary">
                                                    <span class="fa fa-share"></span> Rotate Right
                                                </button>
                                            </div>
                                        </div>
                                                
                                        <div class="form-group push-down-30">
                                            <div class="col-md-12">
                                                <button id="crop_reset" type="button" class="btn btn-primary">
                                                    <span class="fa fa-eraser"></span> Reset
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="cropping-preview-wrap">
                                                    <div class="cropping-preview"></div>
                                                </div>                                                    
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">X</div>
                                                    <input type="text" class="form-control" name="imgX" id="dci_x"  />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Y</div>
                                                    <input type="text" class="form-control" name="imgY" id="dci_y"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">W</div>
                                                    <input type="text" class="form-control" name="imgW" id="dci_w"  />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">H</div>
                                                    <input type="text" class="form-control" name="imgH" id="dci_h"  />
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>                                                                                       
                                    
                                </div>
                                
                            </div>
                            <div class="panel-body">
                                <button type="submit" class="btn btn-success pull-right"><span class="fa fa-picture-o"></span> Crop Image</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                            <input type="submit" class="btn btn-success"  autocomplete="off" data-loading-text="Espera un momento..." value="Guardar">
                        </div>  
                    </div>      
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>