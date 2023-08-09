<?= $this->Html->scriptBlock(sprintf("var impuestos                 = %s;", json_encode($impuestos))); ?>
<?= $this->Html->scriptBlock(sprintf("var listaProductos            = %s;", json_encode($listaProductos))); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><span class="fa fa-shopping-cart"></span> Agregar Compra</h2>
    </div>
    <div class="panel-body">
        <?= $this->Form->create(null, ['name'=>'formCompra']); ?>
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <td>Nombre Proveedor</td>
                    <td>R.U.T. Proveedor</td>
                    <td>Folio</td>
                    <td>Fecha</td>
                    <td>Días crédito</td>
                    <td>Vencimiento</td>
                    <td>¿Pagado?</td>
                </tr>
                <tr>
                    <td>
                        <?= $this->Form->input('proveedorNombre', array('class' => 'form-control', 'type'=>'text', 'required', 'id'=>'nombreProv')); ?>
                    </td>
                    <td>
                        <?= $this->Form->input('proveedor', array('class' => 'form-control', 'type'=>'text', 'required', 'oninput'=>'checkRut(this)')); ?>
                    </td>
                    <td><?= $this->Form->input('folio', array('class' => 'form-control', 'type'=>'number', 'min'=>0, 'step'=>1, 'required', 'id'=>'folioDocumento')); ?></td>
                    <td>
                        <input type='date' class="form-control" id='fechaCompra' name="fechaCompra" />
                    </td>
                    <td><?= $this->Form->input('dias', array('class' => 'form-control', 'type'=>'number', 'min'=>0, 'step'=>1, 'required', 'onkeyup'=>'sumaFecha()', 'id'=>'diasFactura', 'value'=>0)); ?></td>
                    <td><input type='hidden' class="form-control" id='fechaVto' disabled name="fechaPago" /><h4 id="fechaVto2"></h4></td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" checked="" value="0" id="checkPago" name="estado">
                            <span></span>
                        </label>
                    </td>
                </tr>
            </table>
            <div class="col-md-8 col-md-offset-2">
                <table class="table">
                    <tr>
                        <td align="center">Código de barras</td>
                        <td align="center">Producto</td>
                        <td align="center">Cantidad</td>
                        <td align="center">Valor unitario</td>
                    </tr>
                    <tr>
                        <td><?= $this->Form->input('codigo', array('class' => 'form-control buscadorCodigo', 'type'=>'number', 'step'=>1, 'required')); ?></td>
                        <td>
                            <select name="proveedor" class="form-control select buscadorSelect" data-live-search="true" onfocus="">
                                <option disabled selected>--Seleccione</option>
                                <? foreach ($productos as $key => $value) {?>
                                    <option value="<?=$value['id']?>" impuestos="<?=$value['impuestos']?>"><?=$value['nombre']?></option>
                                <?} ?>
                            </select>
                        </td>
                        <td><?= $this->Form->input('cantidad', array('class' => 'form-control cantidadProducto', 'type'=>'number', 'min'=>0, 'step'=>0.01, 'required')); ?></td>
                        <td><?= $this->Form->input('costo', array('class' => 'form-control costoProducto', 'type'=>'number', 'min'=>0, 'step'=>1, 'required')); ?></td>
                        <td><?= $this->Html->image('add.png', array('class' => 'agregarInsumoCompra icon')); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="6" style="text-align: center;">Detalle compra</th>
                                </tr>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Neto</th>
                                    <th>Impuestos</th>
                                    <th>Bruto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="contenido"></tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table">
                            <thead>
                               <tr>
                                    <th>Neto</th>
                                    <td id="totalNeto"></td>
                                </tr>
                                <tr>
                                    <th>Impuestos</th>
                                    <td id="totalImpuestos"></td>
                                </tr>
                                <tr>
                                    <th>Bruto</th>
                                    <td id="totalBruto"></td>
                                    <?= $this->Form->input('netoDocumento', array('type'=>'hidden', 'id'=>'netoDocumento')); ?>
                                    <?= $this->Form->input('impuestosDocumento', array('type'=>'hidden', 'id'=>'impuestosDocumento')); ?>
                                    <?= $this->Form->input('brutoDocumento', array('type'=>'hidden', 'id'=>'brutoDocumento')); ?>
                                </tr> 
                            </thead>                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="pull-right">
                <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                <button type="button" class="btn btn-success continuar openModal" modal="modalcompraDetalle">Continuar</button>
            </div>  
        </div>      
    </div>
    <?= $this->Form->end(); ?>
</div>
<div id="modalcompraDetalle" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="<span class='fa fa-list'></span> Detalle de compra">
    <div class="page-content-wrap">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Revisar la información de la compra, posteriormente no podrá ser modificada</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <th colspan="5" style="text-align: center;">Detalle Proveedor</th>
                                    </tr>
                                    <tr>
                                        <th>Proveedor</th>
                                        <th>Folio Documento</th>
                                        <th>Fecha Compra</th>
                                        <th>Días Crédito</th>
                                        <th>Fecha Pago</th>
                                    </tr>
                                    <tr>
                                        <td id="resumenProv"></td>
                                        <td id="resumenFolio"></td>
                                        <td id="resumenFechaComp"></td>
                                        <td id="resumenDias"></td>
                                        <td id="resumenFechaPago"></td>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th colspan="5" style="text-align: center;">Detalle Productos</th>
                                    </tr>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Neto</th>
                                        <th>Impuestos</th>
                                        <th>Bruto</th>
                                    </tr>
                                    <tbody id="resumenDetalleCompra"></tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table">
                                    <tr>
                                        <th colspan="2" style="text-align: center;">Resumen Montos</th>
                                    </tr>
                                    <tr>
                                        <th>Neto Documento</th>
                                        <td id="resumenNeto"></td>
                                    </tr>
                                    <tr>
                                        <th>Impuestos</th>
                                        <td id="resumenImp"></td>
                                    </tr>
                                    <tr>
                                        <th>Total Documento</th>
                                        <td id="resumenBruto"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <button type="button" class="btn btn-success finalizaCompra">Finalizar</button>
                        </div>  
                    </div>      
                </div>
            </div>
        </div>
    </div>
 </div>
<script type="text/javascript">
    function sumaFecha(){
        $('#fechaVto').val('');
        $('#fechaVto2').val('');
        var dias= parseInt($('#diasFactura').val());
        var fechaCompra = $('#fechaCompra').val();
        var fecha=fechaCompra.split('-');
        var mes=fecha[1]-1;
        var fecha2=new Date(fecha[0], mes, fecha[2]);
        fecha2.setDate(fecha2.getDate() + dias);
        var fechaFinal=fecha2.toISOString().split("T")[0];
        var dataFechaFinal=fechaFinal.split('-');
        $('#fechaVto').val(dataFechaFinal[2]+'-'+dataFechaFinal[1]+'-'+dataFechaFinal[0]);
        document.getElementById("fechaVto2").innerHTML = dataFechaFinal[2]+'-'+dataFechaFinal[1]+'-'+dataFechaFinal[0];
    }
    $(document).ready(function() {
        var iteral = 0;
        var totalNetoDocumento=0;
        var totalImpuestosDocumento=0;
        var totalBrutoDocumento=0;
        var pagado =1;
        $('.buscadorCodigo').keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13){ // code 13 = enter
                $('.cantidadProducto').focus();
            }
        });
        $('.buscadorSelect').keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13){ // code 13 = enter
                $('.cantidadProducto').focus();
            }
        });
        $('.cantidadProducto').keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13){ // code 13 = enter
                $('.costoProducto').focus();
            }
        });
        $('.costoProducto').keypress(function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13){ // code 13 = enter
                $('.agregarInsumoCompra').trigger('click');
            }
        });
        $('.agregarInsumoCompra').on('click', function(){ 
            var codigo = $('.buscadorCodigo').val();
            if(codigo.length>0){
                var producto = listaProductos[codigo];
                if (producto.length!='undefined'){
                    var cantidad = $('.cantidadProducto').val();
                    var costo = $('.costoProducto').val();
                    var total = cantidad*costo;
                    var impuestoProducto = producto['impuestos'].split('/');
                    var montoImpuestos=[];
                    $.each(impuestoProducto, function( index, value ) {
                        var monto = 1+(parseFloat(impuestos[value])/100);
                        var monto2 = (total*monto)-total;
                        montoImpuestos.push(monto2);
                    });

                    var totalImpuestos = 0;
                    $.each(montoImpuestos,function(){totalImpuestos+=parseFloat(this) || 0;});
                    totalImpuestos=Math.round(totalImpuestos);
                    var bruto = total+totalImpuestos;
                    var trAgregado = '<tr id=producto'+iteral+'>'+
                        '<td>'+producto.nombre+'</td>'+
                        '<td>'+cantidad+'</td>'+
                        '<td>$'+total+'</td>'+
                        '<td>$'+totalImpuestos+'</td>'+
                        '<td>$'+bruto+'</td>'+
                        '<td><button type="button" class="btn btn-danger eliminarItemInsumo" itemInsumo="'+ iteral +'" neto="'+total+'" imp="'+totalImpuestos+'" bruto="'+bruto+'"><i class="fa fa-trash-o fa-lg icon"></i></button></td>'+
                        '<input type="hidden" name="data['+iteral+'][prodId]" value="'+producto.id+'">'+
                        '<input type="hidden" name="data['+iteral+'][cant]" value="'+cantidad+'">'+
                        '<input type="hidden" name="data['+iteral+'][neto]" value="'+total+'">'+
                        '</tr>';
                    $.each(impuestoProducto, function( index, value ) {
                        var monto = 1+(parseFloat(impuestos[value])/100);
                        var monto2 = (total*monto)-total;
                        trAgregado = trAgregado+'<input type="hidden" name="data['+iteral+'][detalleImpuestos]['+index+'][impuesto]" value="'+value+'"><input type="hidden" name="data['+iteral+'][detalleImpuestos]['+index+'][monto]" value="'+monto2+'">';
                    });
                    var trAgregadoResumen = '<tr id=resumenDetalleCompra'+iteral+'>'+
                        '<td>'+producto.nombre+'</td>'+
                        '<td>'+cantidad+'</td>'+
                        '<td>$'+total+'</td>'+
                        '<td>$'+totalImpuestos+'</td>'+
                        '<td>$'+bruto+'</td>'+
                        '</tr>';
                    totalNetoDocumento+=total;
                    totalImpuestosDocumento+=totalImpuestos;
                    totalBrutoDocumento+=bruto;
                    $('#totalNeto').html('$'+ new Intl.NumberFormat("de-DE").format(totalNetoDocumento));
                    $('#totalImpuestos').html('$'+ new Intl.NumberFormat("de-DE").format(totalImpuestosDocumento));
                    $('#totalBruto').html('$'+ new Intl.NumberFormat("de-DE").format(totalBrutoDocumento));
                    $('#resumenNeto').html('$'+ new Intl.NumberFormat("de-DE").format(totalNetoDocumento));
                    $('#resumenImp').html('$'+ new Intl.NumberFormat("de-DE").format(totalImpuestosDocumento));
                    $('#resumenBruto').html('$'+ new Intl.NumberFormat("de-DE").format(totalBrutoDocumento));
                    $('#netoDocumento').val(totalNetoDocumento);
                    $('#impuestosDocumento').val(totalImpuestosDocumento);
                    $('#brutoDocumento').val(totalBrutoDocumento);
                    $('#contenido').append(trAgregado);
                    $('#resumenDetalleCompra').append(trAgregadoResumen);
                    $('.buscadorCodigo').val('');
                    $('.cantidadProducto').val('');
                    $('.costoProducto').val('');
                    $('.buscadorCodigo').focus();
                    iteral++;
                }else{
                    alert('Código no encontrado, debe registrar el producto antes de agregar una compra');
                } 
            }else{

            }
        });
        $('#contenido').on('click', '.eliminarItemInsumo', function(){ 
            var iteralEliminar = $(this).attr('itemInsumo');
            var montoNetoEliminar = parseInt($(this).attr('neto'));
            var montoImpEliminar = parseInt($(this).attr('imp'));
            var montoBrutoEliminar = parseInt($(this).attr('bruto'));
            totalNetoDocumento=totalNetoDocumento-montoNetoEliminar;
            totalImpuestosDocumento=totalImpuestosDocumento-montoImpEliminar;
            totalBrutoDocumento=totalBrutoDocumento-montoBrutoEliminar;
            $('#totalNeto').html('$'+ new Intl.NumberFormat("de-DE").format(totalNetoDocumento));
            $('#totalImpuestos').html('$'+ new Intl.NumberFormat("de-DE").format(totalImpuestosDocumento));
            $('#totalBruto').html('$'+ new Intl.NumberFormat("de-DE").format(totalBrutoDocumento));
            $('#resumenNeto').html('$'+ new Intl.NumberFormat("de-DE").format(totalNetoDocumento));
            $('#resumenImp').html('$'+ new Intl.NumberFormat("de-DE").format(totalImpuestosDocumento));
            $('#resumenBruto').html('$'+ new Intl.NumberFormat("de-DE").format(totalBrutoDocumento));
            $('#netoDocumento').val(totalNetoDocumento);
            $('#impuestosDocumento').val(totalImpuestosDocumento);
            $('#brutoDocumento').val(totalBrutoDocumento);
            $('#producto'+ iteralEliminar).remove();
            $('#resumenDetalleCompra'+ iteralEliminar).remove();
        });
        $('.continuar').on('click', function(){
            var proveedor=$('#nombreProv').val();
            var folio=$('#folioDocumento').val();
            var fechaCompra=$('#fechaCompra').val();
            var diasCredito=parseInt($('#diasFactura').val());
            var fechaVto=$('#fechaVto').val();
            $('#resumenProv').html(proveedor);
            $('#resumenFolio').html(folio);
            $('#resumenFechaComp').html(fechaCompra);
            $('#resumenDias').html(diasCredito);
            $('#resumenFechaPago').html(fechaVto);
        });
        $('#modalcompraDetalle').on('click', '.finalizaCompra', function(){
            document.formCompra.submit();
        });
    });
    function checkRut(rut) {
        // Despejar Puntos
        var valor = rut.value.replace('.','');
        // Despejar Guión
        valor = valor.replace('-','');
        
        // Aislar Cuerpo y Dígito Verificador
        cuerpo = valor.slice(0,-1);
        dv = valor.slice(-1).toUpperCase();
        
        // Formatear RUN
        rut.value = cuerpo + '-'+ dv
        
        // Si no cumple con el mínimo ej. (n.nnn.nnn)
        if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
        
        // Calcular Dígito Verificador
        suma = 0;
        multiplo = 2;
        
        // Para cada dígito del Cuerpo
        for(i=1;i<=cuerpo.length;i++) {
        
            // Obtener su Producto con el Múltiplo Correspondiente
            index = multiplo * valor.charAt(cuerpo.length - i);
            
            // Sumar al Contador General
            suma = suma + index;
            
            // Consolidar Múltiplo dentro del rango [2,7]
            if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
      
        }
        
        // Calcular Dígito Verificador en base al Módulo 11
        dvEsperado = 11 - (suma % 11);
        
        // Casos Especiales (0 y K)
        dv = (dv == 'K')?10:dv;
        dv = (dv == 0)?11:dv;
        
        // Validar que el Cuerpo coincide con su Dígito Verificador
        if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
        
        // Si todo sale bien, eliminar errores (decretar que es válido)
        rut.setCustomValidity('');
    }
</script>