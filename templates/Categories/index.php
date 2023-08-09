<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-list"></span> Categorias</h2></div>
                        <div class="col-md-6"><button class="btn btn-info pull-right openModal" modal="modalAddCategoria" modalAjax="0"><i class="fa fa-plus"></i> Agregar categoría</button></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-8 col-md-offset-2">
                        <table id="productos" class="table table-bordered table-striped dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Categoria</th>
                                    <th>Cant. Productos</th>
                                    <th>Imgane</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? $catSinCat=$categories[0]['id']; ?>
                                <? foreach ($categories as $key => $value) {?>
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center;"><?=$key+1?></td>
                                        <td style="vertical-align: middle; text-align: center;"><?= $value['nombre'] ?></td>
                                        <td style="vertical-align: middle; text-align: center;"><?= number_format(count($value['products']), 0, ',', '.') ?></td>
                                        <?= $disabled=($value['tipo'])?'':'disabled'; ?>
                                        <? $img=(file_exists(ROOT.'/webroot/img/img_cat/'.$localId.'/'.$value['id'].'.'.$value['extension']))?'img_cat/'.$localId.'/'.$value['id'].'.'.$value['extension']:'404-error.jpg'; ?>
                                        <td><?= $this->Html->image($img, ['style'=>'max-width:100px;','max-height:50px;']) ?></td>
                                        <td  style="vertical-align: middle; text-align: center;"> 
                                            <?= $this->html->link('<i class="fa fa-ban"></i> Eliminar', ['controller'=>'Categories', 'action'=>'eliminaCategoria', $value['id'], $catSinCat], ['escape'=>false, 'class'=>'btn btn-danger', $disabled]) ?>
                                            <?= $this->html->link('<i class="fa fa-edit"></i> Editar', ['controller'=>'Categories', 'action'=>'edit', $value['id']], ['escape'=>false, 'class'=>'btn btn-warning', $disabled]) ?>
                                        </td>
                                    </tr>
                                <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalAddCategoria" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-plus'></span> Agregar Categoría" style="z-index: 9999 !important;">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->create(null, ['url'=>['controller'=>'Categories', 'action'=>'add']]); ?>
                        <table class="table">
                            <tr>
                                <td colspan="2" align="center">Agregar Categoría</td>
                            </tr>
                            <tr>
                                <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required', 'placeholder'=>'Nombre')); ?></td>
                                <td><input type="submit" class="btn btn-success"  autocomplete="off" data-loading-text="Espera un momento..." value="Agregar Categoría"></td>
                            </tr>
                        </table>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#productos").dataTable();
    });
</script>