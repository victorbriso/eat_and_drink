<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">  
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="center"><strong>Folio</strong></th>                                
                                <th class="center"><strong>Total consumo:</strong></th>
                                <th class="center"><strong>Propina sugerida (10%):</strong></th>
                                <input type="hidden" id="totalCobroFolio" value="<?=$dataFolio[0]['monto']?>">
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="center"><strong># <?= $dataFolio[0]['folio'] ?></strong></td>
                                <td class="center">$ <?= number_format($dataFolio[0]['monto'],0,',','.') ?></td>
                                <td class="center">$ <?= number_format($dataFolio[0]['propina'],0,',','.') ?></td>
                            </tr> 
                            <tr>
                                <td colspan="4" class="center">
                                    <div class="col-md-12 center">
                                        <button class="btn btn-warning btn-block openModal" modal="modalIngresarPagoCuenta"><span class="fa fa-credit-card"></span> Ver detalle consumo</button>
                                    </div>
                                </td>
                            </tr>                           
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">  
                    <div class="col-md-12">                        
                        <div class="panel panel-default tabs">    
                            <ul class="nav nav-tabs nav-justified">
                              <li class="active"><a data-toggle="tab" href="#medioEfectivo"><button class="btn btn-primary btn-rounded">Efectivo</button></a></li>
                              <li><a data-toggle="tab" href="#debito"><button class="btn btn-primary btn-rounded">Débito</button></a></li>
                              <li><a data-toggle="tab" href="#credito"><button class="btn btn-primary btn-rounded">Crédito</button></a></li>
                              <li><a data-toggle="tab" href="#debitoCVuelto"><button class="btn btn-primary btn-rounded">Débito con vuelto</button></a></li>
                            </ul>
                            <div class="panel-body tab-content">                                    
                                <div id="medioEfectivo" class="tab-pane fade in active">                                        
                                    <div class="row"> 
                                        <table class="table">                                                
                                            <tr>
                                                <td>Monto</td>
                                                <td>Efectivo</td>
                                                <td colspan="2">Propina</td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" id="monto" value="0" class="form-control"></td>
                                                <td><input type="number" id="efectivo" value="0" class="form-control"></td>
                                                <td><input type="number" id="propina" value="0" class="form-control"></td>
                                                <td><button type="button" class="btn btn-success agregarPago" tipo="4">Agregar</button></td>
                                            </tr>                                                
                                        </table>                                     
                                    </div>
                                </div>                                    
                                <div id="debito" class="tab-pane fade">                                       
                                    <div class="row"> 
                                        <table class="table">                                               
                                            <tr>
                                                <td>Monto</td>
                                                <td>Cód. Operación</td>
                                                <td>Cód. Autorización</td>
                                                <td colspan="2">Propina</td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" id="montoDebito" value="0" class="form-control"></td>
                                                <td><input type="number" id="operacion" value="0" class="form-control"></td>
                                                <td><input type="number" id="autorizacion" value="0" class="form-control"></td>
                                                <td><input type="number" id="propinaDebito" value="0" class="form-control"></td>
                                                <td><button type="button" class="btn btn-success agregarPago" tipo="5">Agregar</button></td>
                                            </tr>                                                
                                        </table>                                     
                                    </div>
                                </div>                                   
                                <div id="credito" class="tab-pane fade">                                        
                                    <div class="row"> 
                                        <table class="table">                                                
                                            <tr>
                                                <td>Monto</td>
                                                <td>Cód. Operación</td>
                                                <td>Cód. Autorización</td>
                                                <td colspan="2">Propina</td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" id="montoCredito" value="0" class="form-control"></td>
                                                <td><input type="number" id="operacionCR" value="0" class="form-control"></td>
                                                <td><input type="number" id="autorizacionCR" value="0" class="form-control"></td>
                                                <td><input type="number" id="propinaCredito" value="0" class="form-control"></td>
                                                <td><button type="button" class="btn btn-success agregarPago" tipo="6">Agregar</button></td>
                                            </tr>                                                
                                        </table>                                     
                                    </div>
                                </div>                                    
                                <div id="debitoCVuelto" class="tab-pane fade">
                                    <div class="row"> 
                                        <table class="table">                                              
                                            <tr>
                                                <td>Monto</td>
                                                <td>Vuelto</td>
                                                <td>Cód. Operación</td>
                                                <td>Cód. Autorización</td>
                                                <td colspan="2">Propina</td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" id="montoTBKVuelto" value="0" class="form-control"></td>
                                                <td><input type="number" id="vueltoTBKVuelto" value="0" class="form-control"></td>
                                                <td><input type="number" id="operacionDB" value="0" class="form-control"></td>
                                                <td><input type="number" id="autorizacionDB" value="0" class="form-control"></td>
                                                <td><input type="number" id="propinaTBKVuelto" value="0" class="form-control"></td>
                                                <td><button type="button" class="btn btn-success agregarPago" tipo="7">Agregar</button></td>
                                            </tr>                                               
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <?= $this->Form->create(null, ['url' => array('controller' => 'Cashboxes', 'action' => 'generarPagoCuenta')]); ?>
                <div class="panel-body">  
                    <div class="col-md-12">
                        <div class="col-md-12 table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="7" class="center">Medios de pago agregados</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Medio de pago</th>
                                        <th>cobro</th>
                                        <th>Cancelado</th>
                                        <th>Cód. Operación</th>
                                        <th>Cód. Autorización</th>
                                        <th>Propina</th>
                                        <th>Vuelto TBK</th>
                                        <th>Quitar</th>
                                    </tr>
                                </thead>
                                
                                    <?= $this->Form->input('voucher_id', array('type' => 'hidden', 'value' => $dataFolio[0]['id']));?>
                                    <?= $this->Form->input('folio', array('type' => 'hidden', 'value' => $dataFolio[0]['folio']));?>
                                    <?= $this->Form->input('comanda_id', array('type' => 'hidden', 'value' => $dataFolio[0]['comanda_id']));?>
                                    <?= $this->Form->input('pedido', array('type' => 'hidden', 'value' => $dataFolio[0]['productos']));?>
                                    <?= $this->Form->input('caja_id', array('type' => 'hidden', 'value' => $cajaId));?>
                                    <?= $this->Form->input('valor_voucher', array('type' => 'hidden', 'value' => $dataFolio[0]['monto']));?>
                                    <?= $this->Form->input('mesa_id', array('type' => 'hidden', 'value' => $dataFolio[0]['table_id']));?>
                                    <?= $this->Form->input('cajero_id', array('type' => 'hidden', 'value' => $cajero));?>
                                    

                                <tbody id="detallePagos"></tbody>                          
                            </table>
                        </div>
                    </div>  
                </div>
                <div class="panel-footer">
                    <div class="pull-left">
                        <table class="table">
                            <tr>
                                <td>Pendiente</td>
                                <td>Total Cancelado</td>
                                <td>Vuelto Efectivo</td>
                                <td>Vuelto TBK</td>
                                <td>Total vuelto</td>
                            </tr>
                            <tr>
                                <td id="pendienteGeneral">$ <?= number_format($dataFolio[0]['monto'],0,',','.') ?>.-</td>
                                <td id="totalCancelado">$0.-</td>
                                <td id="totalEfectivo">$0.-</td>
                                <td id="vueltoTBK">$0.-</td>
                                <td id="totalVuelto">$0.-</td>
                            </tr>
                        </table>          
                    </div>
                    <div class="pull-right">
                        <table>
                            <tr>
                                <td>Imprime cuenta</td>
                                <td>&nbsp;</td>
                                <td>
                                    <label class="switch"><?= $this->Form->input('imprime', array('type'=>'checkbox', 'checked' )); ?><span></span></label>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="submit" class="btn btn-success hidden"  autocomplete="off" data-loading-text="Espera un momento..." value="Finalizar Pago" id="btnFinalizaPago">
                                    
                                </td>
                                <td>&nbsp;</td>
                                <td><?= $this->Html->link('Cancelar', array('action' => 'cancelarPago'), array('class' => 'btn-form-submit btn btn-danger')); ?></td>
                            </tr>
                        </table>          
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>    
</div>
<div id="modalIngresarPagoCuenta" class="modalFormularios ocultar" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="GENERAR PAGO" style="z-index: 998 !important">
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="invoice">

                    <div class="table-invoice">
                        <table class="table">
                            <tr>
                                <th>Item productos</th>
                                <th class="text-center">Valor unitario</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Total</th>
                            </tr>
                            <? foreach ($pedidosPorId as $key_pedido => $pedido) { ?>
                                 <tr>
                                    <td>
                                        <strong><?= $pedido['product']['nombre'] ?></strong>
                                        <p><?= $pedido['comentario'] ?></p>
                                    </td>
                                    <td class="text-center">$ <?= number_format($pedido['precio'],0,',','.') ?></td>
                                    <? if( ! $pedido['product']['divisible'] ){ ?>
                                        <td class="text-center"><?= $pedido['cantidad'] ?></td>
                                        <td class="text-center">$ <?= number_format($pedido['total'],0,',','.') ?></td>
                                    <?}else{?>
                                        <td colspan="2" class="text-center">Dividido</td>
                                    <?}?>
                                </tr>
                            <? } ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        var totalEfectivo = 0;
        var totalVuelto = 0;
        var totalCancelado = 0;
        var totalVueltoTBK = 0;
        var totalVueltoEfectivo = 0;
        var iteralPago=1;
        var medioPago='';
        var cobro=0;
        var cancelado=0;
        var codOperacion=0;
        var codAuth=0;
        var propina=0;
        var vueltoTBK=0;
        var vuelto=0;
        var pendienteGeneral=parseInt(<?=$dataFolio[0]['monto']?>);
        $('.agregarPago').on('click', function (){
            var tipoPago=$(this).attr('tipo');
            if(tipoPago==4){
                if(parseInt($('#efectivo').val())>=(parseInt($('#monto').val())+parseInt($('#propina').val()))){
                    medioPago       ='Efectivo';
                    cobro           =parseInt($('#monto').val());
                    cancelado       =parseInt($('#efectivo').val());
                    codOperacion    =0;
                    codAuth         =0;
                    propina         =parseInt($('#propina').val());
                    vueltoTBK       =0;
                    vuelto          =cancelado-(cobro+propina);
                    var sigue = true;
                }else{
                    alert('El efectivo ingresado no puede ser menor al monto cobrado con la propina');
                    var sigue = false;
                }
                
            }
            if(tipoPago==5){
                medioPago       ='Débito';
                cobro           =parseInt($('#montoDebito').val());
                cancelado       =parseInt($('#montoDebito').val());
                codOperacion    =$('#operacion').val();
                codAuth         =$('#autorizacion').val();
                propina         =parseInt($('#propinaDebito').val());
                vueltoTBK       =0;
                vuelto          =0;
                var sigue = true;
            }
            if(tipoPago==6){
                medioPago       ='Crédito';
                cobro           =parseInt($('#montoCredito').val());
                cancelado       =parseInt($('#montoCredito').val());
                codOperacion    =$('#operacionCR').val();
                codAuth         =$('#autorizacionCR').val();
                propina         =parseInt($('#propinaCredito').val());
                vueltoTBK       =0;
                vuelto          =0;
                var sigue = true;
            }
            if(tipoPago==7){
                medioPago       ='Débito c/ vuelto';
                cobro           =parseInt($('#montoTBKVuelto').val());
                cancelado       =parseInt($('#montoTBKVuelto').val());
                codOperacion    =$('#operacionDB').val();
                codAuth         =$('#autorizacionDB').val();
                propina         =parseInt($('#propinaTBKVuelto').val());
                vueltoTBK       =parseInt($('#vueltoTBKVuelto').val());
                vuelto          =0;
                var sigue = true;
            }
            if(sigue){
                var trPago='<tr id="lineaPago'+iteralPago+'">'+
                            '<td>'+iteralPago+'</td>'+
                            '<td>'+medioPago+'</td>'+
                            '<td>$'+new Intl.NumberFormat("de-DE").format(cobro)+'</td>'+
                            '<td>$'+new Intl.NumberFormat("de-DE").format(cancelado)+'</td>'+
                            '<td>'+codOperacion+'</td>'+
                            '<td>'+codAuth+'</td>'+
                            '<td>$'+new Intl.NumberFormat("de-DE").format(propina)+'</td>'+
                            '<td>$'+new Intl.NumberFormat("de-DE").format(vueltoTBK)+'</td>'+
                            '<td><button class="btn btn-danger quitarPago" iteralPago="'+iteralPago+'" cancelado="'+cobro+'" vueltoEfectivo="'+vuelto+'" vueltoTBK="'+vueltoTBK+'"><i class="fa fa-ban"></i></button></td>'+
                            '<input type="hidden" name="data['+iteralPago+'][tipo]" value="'+tipoPago+'">'+
                            '<input type="hidden" name="data['+iteralPago+'][cobro]" value="'+cobro+'">'+
                            '<input type="hidden" name="data['+iteralPago+'][cancelado]" value="'+cancelado+'">'+
                            '<input type="hidden" name="data['+iteralPago+'][codOperacion]" value="'+codOperacion+'">'+
                            '<input type="hidden" name="data['+iteralPago+'][codAuth]" value="'+codAuth+'">'+
                            '<input type="hidden" name="data['+iteralPago+'][propina]" value="'+propina+'">'+
                            '<input type="hidden" name="data['+iteralPago+'][vueltoTBK]" value="'+vueltoTBK+'">'+
                            '<input type="hidden" name="data['+iteralPago+'][vuelto]" value="'+vuelto+'">'+
                        '</tr>';
                iteralPago++;
                $('#detallePagos').append(trPago);
                totalCancelado=totalCancelado+cobro;
                totalVueltoEfectivo=totalVueltoEfectivo+vuelto;
                totalVueltoTBK=totalVueltoTBK+vueltoTBK;
                totalVuelto=totalVueltoTBK+totalVueltoEfectivo;
                if(parseInt($('#totalCobroFolio').val())<=totalCancelado){
                    $('#btnFinalizaPago').removeClass('hidden');
                }
                pendienteGeneral = pendienteGeneral-cobro;
                $('#pendienteGeneral').html('$'+new Intl.NumberFormat("de-DE").format(pendienteGeneral));
                $('#totalCancelado').html('$'+totalCancelado);
                $('#totalEfectivo').html('$'+totalVueltoEfectivo);
                $('#vueltoTBK').html('$'+totalVueltoTBK);
                $('#totalVuelto').html('$'+totalVuelto);
                $('#efectivo').val(0);
                $('#monto').val(0);
                $('#propina').val(0);
                $('#montoDebito').val(0);
                $('#montoDebito').val(0);
                $('#operacion').val(0);
                $('#autorizacion').val(0);
                $('#propinaDebito').val(0);
                $('#montoCredito').val(0);
                $('#operacionCR').val(0);
                $('#autorizacionCR').val(0);
                $('#propinaCredito').val(0);
                $('#montoTBKVuelto').val(0);
                $('#operacionDB').val(0);
                $('#autorizacionDB').val(0);
                $('#propinaTBKVuelto').val(0);
                $('#vueltoTBKVuelto').val(0);    
            }
            
        });
        $('#detallePagos').on('click', '.quitarPago', function (){
            iteralBorrar=$(this).attr('iteralPago');
            cobroBorro=parseInt($(this).attr('cancelado'));
            vueltoBorro=parseInt($(this).attr('vueltoEfectivo'));
            vueltoTBKBorro=parseInt($(this).attr('vueltoTBK'));
            totalCancelado=totalCancelado-cobroBorro;
            totalVueltoEfectivo=totalVueltoEfectivo-vueltoBorro;
            totalVueltoTBK=totalVueltoTBK-vueltoTBKBorro;
            totalVuelto=totalVueltoTBK+totalVueltoEfectivo;
            if(parseInt($('#totalCobroFolio').val())>totalCancelado){
                $('#btnFinalizaPago').addClass('hidden');
            }
            pendienteGeneral=pendienteGeneral+cobroBorro;
            $('#pendienteGeneral').html('$'+new Intl.NumberFormat("de-DE").format(pendienteGeneral));
            $('#pendienteGeneral').html('$'+pendienteGeneral);
            $('#totalCancelado').html('$'+totalCancelado);
            $('#totalEfectivo').html('$'+totalVueltoEfectivo);
            $('#vueltoTBK').html('$'+totalVueltoTBK);
            $('#totalVuelto').html('$'+totalVuelto);
            $('#lineaPago'+iteralBorrar).remove();
        });
    });
</script>