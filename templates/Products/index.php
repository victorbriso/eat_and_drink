<?= $this->Html->scriptBlock(sprintf("var token                 = %s;", json_encode($token))); ?>
<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h2><span class="fa fa-cutlery"></span> Productos</h2></div>
                        <div class="col-md-6"><?= $this->Html->link('<i class="fa fa-plus"></i> Agregar producto', ['controller'=>'Products', 'action'=>'add'], ['escape'=>false, 'class'=>'btn btn-success pull-right']) ?></div>
                    </div>  
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="productos" class="table table-bordered table-striped dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Divisible</th>
                                    <th>Estado</th>
                                    <th>Precio base</th>
                                    <th>Precio actual</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($data as $key => $value) {?>
                                    <tr>
                                        <td><?=$key+1?></td>
                                        <td><?= $value['nombre'] ?></td>
                                        <td><?= ($value['divisible'])?'Si':'No'; ?></td>
                                        <td><?= ($value['estado'])?'Activo':'Inactivo'; ?></td>
                                        <td>$<?= number_format($value['precio_base'],0, ',', '.') ?></td>
                                        <td>$<?= number_format($value['precio_actual'],0, ',', '.') ?></td>
                                        <td align="center" >
                                            <?= ($value['estado'])?'<button class="btn btn-danger pull-left actualiza" valor="0" idProd="'.$value['id'].'" id="'.$key.'"><i class="fa fa-ban"></i> Desactivar</button>':'<button class="btn btn-success pull-left actualiza" valor="1" idProd="'.$value['id'].'" id="'.$key.'"><i class="fa fa-check"></i> Activar</button>'; ?>
                                            <?= $this->Html->link('<i class="fa fa-edit"></i> Editar', ['controller'=>'Products', 'action'=>'edit', $value['id']], ['escape'=>false, 'class'=>'btn btn-warning']) ?>
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
<script type="text/javascript">
    $(function () {
        $("#productos").dataTable();
    });
    $( document ).ready(function() { 
        $('.actualiza').on('click', function () {
            var update = $(this).attr('valor');
            var prodId = $(this).attr('idProd');
            var btnId = $(this).attr('id');
            var formRetiro = {
                '_Token[fields]':token,
                'prodId':prodId,
                'valor':update
            };
            $.ajax({
                type: 'POST',
                url: '/Products/cambiaEstado',
                headers: { 'X-XSRF-TOKEN' : token },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', token);
                },
                data: formRetiro,
                success: function (result) {
                    if(result==1){
                        if(update==1){
                            $('#'+btnId).removeClass('btn-success');
                            $('#'+btnId).addClass('btn-danger');
                            $('#'+btnId).attr({'valor':'0'});
                            $('#'+btnId).html('<i class="fa fa-ban"></i> Desactivar');
                        }else{
                            $('#'+btnId).removeClass('btn-danger');
                            $('#'+btnId).addClass('btn-success');
                            $('#'+btnId).attr({'valor':'1'});
                            $('#'+btnId).html('<i class="fa fa-check"></i> Activar');
                        }                        
                    }
                },
                error: function (result){
                    console.log(result);
                    alert('error al comunicarse con el servidor');
                }
            });
        });
    });
</script>