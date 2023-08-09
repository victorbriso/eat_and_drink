<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-list"></span> Listas de Precios</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                     <div class="col-md-4 col-md-offset-4">
                                        <?= $this->Html->link('<i class="fa fa-plus"></i> Crear Nueva Lista', array('action' => 'addListaPrecio'), array('class' => 'btn btn-success btn-block', 'escape' => false)); ?>
                                    </div>                          
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    <table class="table table-striped table-actions">
                        <thead>
                        <tr>
                          <th class="static statict-th td-resaltado" scope="col">Nombre Producto</th>
                          <th class="static statict-th td-resaltado" scope="col">Precio Base</th>
                         <? foreach ($listaPrecios as $key_lista_precio => $lista_precio) { ?>
                                <th scope="col" class="center">
                                    Precio <?= $lista_precio['nombre'] ?>
                                    <br>
                                    <?php if ( $lista_precio['estado'] ) { ?>
                                        <?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'editListaPrecio', $lista_precio['id'], $lista_precio['nombre'], true), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
                                        <span style="font-size: 12px">Lista Activa</span>
                                     <?php } else { ?>
                                        <?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'editListaPrecio', $lista_precio['id'], $lista_precio['nombre'], false), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
                                        <!-- ACTIVAR -->
                                         <?= $this->Html->link('<i class="fa fa-check-square-o"></i> Activar', array('controller' => 'ListaPrecioControles', 'action' => 'activar', $lista_precio['id']), array('class' => 'btn btn-xs btn-success ', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title' => 'Activar', 'escape' => false)); ?>
                                          <!-- ELIMINAR -->
                                         <a href="#" class="mb-control btn btn-xs btn-danger a-eliminar-lista" id="<?= $lista_precio['id']?>" data-box="#mb-eliminar-lista"><i class="fa fa-trash-o"></i></a>

                                 <?php } ?>
                                </th> 
                            <? } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                           <? foreach ($listaPreciosProductos as $key_lista_producto => $lista_producto) { ?>
                                <tr class="tr-lista-producto" style="height: 100%;">
                                    <td class="td-resaltado static" scope="row" style="width: 140px; z-index: 9;"><?= $lista_producto['nombre'] ?></td>
                                    <td class="center td-resaltado first-col">$ <?= number_format($lista_producto['precio_base'],0,',','.') ?></td>

                                    <?
                                        $iteral_lista_precios = 0;
                                        $iteral_precios_producto = 0;

                                        foreach ($listaPrecios as $key_lista_precio => $lista_precio) {
                                            $campo_lista = false; 
                                            foreach ( $lista_producto['price_lists'] as $key_lista => $lista) {
                                                if ( $lista_precio['id'] == $lista['price_lists_control_id']) {  
                                                    $campo_lista = true;  ?>
                                                    <td columna="<?= $key_lista_precio ?>" fila="<?= $key_lista_producto ?>" class="center filaColumna filaColumaHover_<?= sprintf('%d%d',$key_lista_precio,$key_lista_producto) ?> columna_<?= $key_lista_precio ?> fila_<?= $key_lista_producto ?>">$ <?= number_format($lista['precio'],0,',','.') ?></td>
                                                <? } ?>
                                           <? } ?>
                                           <? if ( ! $campo_lista ) { ?>
                                                <td columna="<?= $key_lista_precio ?>" fila="<?= $key_lista_producto ?>"  class="center filaColumna"> -- </td>
                                           <? } ?>
                                        <? } ?>
                                </tr>
                            <? } ?>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="message-box animated fadeIn" data-sound="alert" id="mb-eliminar-lista">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-trash-o"></span>¿Eliminar <strong>lista de precios</strong>?</div>
            <div class="mb-content">
                <p>¿Seguro que quieres eliminar la lista de precios?</p>
                <p>Presiona NO para continuar trabajando y SI para eliminar.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <?= $this->Html->link('Si', array('controller' => 'Products', 'action' => 'eliminarLista'), array('class' => 'btn btn-success btn-lg link-eliminar-lista')); ?>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">    
    $('.a-eliminar-lista').on('click', function(){
        var id_lista = $(this).attr('id');
        $('.link-eliminar-lista').attr('href', 'eliminarLista/'+id_lista);
    });
    $('.filaColumna').hover(function() {
        $('.filaColumna').removeClass('fila-columna-hover');
        $('.filaColumna').removeClass('fila-columna-hover-position');
        var fila    = $(this).attr('fila');
        var columna = $(this).attr('columna');
        $('.fila_'+fila).addClass('fila-columna-hover');
        $('.columna_'+columna).addClass('fila-columna-hover');
        $(this).removeClass('fila-columna-hover');
        $(this).addClass('fila-columna-hover-position');
    });
</script>