<div class="panel panel-default">
    <div class="panel-heading">
        <h2><span class="fa fa-archive"></span> Documentos pendientes proveedor <?= $documentos[0]['proveedore']['nombre'] ?> / <?= $documentos[0]['proveedore']['razon_social'] ?></h2>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
           <table id="documentos" class="table table-bordered table-striped dataTable" style="text-align: center;">
                <thead>
                    <tr style="text-align: center;">
                        <th style="text-align: center;">#</th>
                        <th style="text-align: center;">Documento</th>
                        <th style="text-align: center;">Folio</th>
                        <th style="text-align: center;">Neto</th>
                        <th style="text-align: center;">Bruto</th>
                        <th style="text-align: center;">Fecha Emisión</th>
                        <th style="text-align: center;">Fecha vencimiento</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($documentos as $key => $value) {?>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?=$value['tipo_documento']?></td>
                            <td><?=$value['documento']?></td>                            
                            <td>$<?= number_format($value['neto'],0, ',', '.')?></td>
                            <td>$<?=number_format($value['bruto'],0, ',', '.')?></td>
                            <td><?=$value['emision']?></td>
                            <td><?=$value['vencimiento']?></td>
                            <td>
                                <button class="btn btn-info openModal" modal="modalAddCaja" modalAjax="0" onclick="detalleDocumento(this)" id="<?= $value['id'] ?>" token=<?=$token?>>Ver detalle</button>
                            </td>
                        </tr>
                    <?} ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="pull-right">
                <?= $this->Html->link('Volver a proveedores', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-info')); ?>
            </div>  
        </div>      
    </div>
</div>
<div id="modalAddCaja" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Detalle Factura">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Neto</th>
                            <th>Impuestos</th>
                            <th>Bruto</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 </div>
 <div class="d-none">
    <form id="ajaxForm">
        <input type="hidden" name="_Token[fields]" autocomplete="off" value="<?=$token?>">
        <input type="hidden" name="id" autocomplete="off" value="es" id="documento">
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $("#documentos").dataTable();
    });
    function detalleDocumento(data){     
        var docId=data.id;
        $('#documento').val(docId);
        var token= $(data).attr('token');
        var ajaxdata = $("#ajaxForm").serializeArray(); 
        $.ajax({
            type: 'POST',
            url: '/Vendors/detalleDocumentoAjax',
            headers: { 'X-XSRF-TOKEN' : token },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', token);
            },
                data: ajaxdata,
            success: function (result) {
                console.log(result);                
                respuesta=JSON.parse(result);                
            },
            error: function (result){
                console.log(result);
                alert('error');
            }
        }); 
        
    }
</script>