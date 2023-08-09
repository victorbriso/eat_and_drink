<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-edit"></span> Editar Categoria</h2>
                </div>
                <?= $this->Form->create(null, ['enctype' => 'multipart/form-data']); ?>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                        <table class="table">
                            <tr>
                                <td>Nombre</td>
                                <td>
                                    <?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$dataCat[0]['nombre'])); ?>
                                    <?= $this->Form->input('id', array('type'=>'hidden', 'required', 'value'=>$dataCat[0]['id'])); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Imagen <span class="help-block">360px x 200px max.</span></td>
                                <? $img=(file_exists(ROOT.'/webroot/img/img_cat/'.$localId.'/'.$dataCat[0]['id'].'.'.$dataCat[0]['extension']))?'img_cat/'.$localId.'/'.$dataCat[0]['id'].'.'.$dataCat[0]['extension']:'404-error.jpg'; ?>
                                <td style="max-width: 300px; max-height: 200px;">
                                    <?= $this->Html->image($img, ['style'=>'max-width:300px;','max-height:200px;']) ?>
                                    <?= $this->Form->input('image', array('type' => 'file', 'class'=>'file input_imagen imagen_form', 'data-preview-file-type' => 'any', 'multiple', 'onchange' => 'ValidarImagen(this)')); ?>
                                </td>
                            </tr>
                        </table>             
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