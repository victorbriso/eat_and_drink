<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">                    
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-users"></span> Mantención de perfiles</h2></div>
                        <div class="col-md-6">
                            <?= $this->Html->link('<i class="fa fa-plus"></i> Agregar Perfil', ['controller'=>'Profiles', 'action'=>'add'], ['escape'=>false, 'class'=>'btn btn-info pull-right']) ?>
                        </div>
                    </div>  
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="productos" class="table table-bordered table-striped dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Inicio Login</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($data as $key => $value) { $inicio=json_decode($value['inicio'], true); ?>
                                    <tr>
                                        <td><?=$key+1?></td>
                                        <td><?= $value['nombre'] ?></td>
                                        <td><?= $inicios[$inicio['controller']]['seccion'].'-'.$inicios[$inicio['controller']]['data'][$inicio['action']] ?></td>
                                        <td align="center"><?= $this->Html->link('<i class="fa fa-edit"></i> Editar', ['controller'=>'Profiles', 'action'=>'edit', $value['id']], ['escape'=>false, 'class'=>'btn btn-warning']) ?></td>
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
<script type="text/javascript">
    $(function () {
        $("#productos").dataTable();
    });
</script>