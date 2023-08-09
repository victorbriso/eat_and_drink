<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">                    
                    <div class="row">
                        <div class="col-md-6"><h2><i class="fa fa-cutlery"></i> Publicacion de carta</h2></div>
                        <div class="col-md-6"><?= $this->Html->link('<i class="fa fa-plus"></i> Publicar', ['controller'=>'Products', 'action'=>'publicacionCarta'], ['escape'=>false, 'class'=>'btn btn-success pull-right']) ?></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <table id="productos" class="table table-bordered table-striped dataTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Estado actual</th>
                                            <th>Próximo estado</th>
                                            <th>Precio anterior</th>
                                            <th>Precio publicado</th>
                                            <th>Próximo precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach ($productos as $key => $value){?>
                                            <tr>
                                                <td><?=$key+1?></td>
                                                <td><?=$value['nombre']?></td>
                                                <td>
                                                    <? if($value['estado']){
                                                            if($value['agotado']){
                                                                echo 'Agotado';
                                                            }else{
                                                                echo 'Disponible';
                                                            }
                                                    }else{
                                                        echo 'Descontinuado';
                                                    } ?>
                                                </td>
                                                <td>
                                                    <? if($value['estado']){
                                                            if($value['agotado']){
                                                                echo 'Agotado';
                                                            }else{
                                                                echo 'Disponible';
                                                            }
                                                    }else{
                                                        echo 'Descontinuado';
                                                    } ?>
                                                </td>
                                                <td>$<?=number_format($value['precio_anterior'],0, ',', '.') ?></td>
                                                <td>$<?=number_format($value['precio_actual'],0, ',', '.') ?></td>
                                                <td>$<?=number_format($listaPrecioActiva[$value['id']],0, ',', '.') ?></td>
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
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#productos").dataTable();
    });
</script>