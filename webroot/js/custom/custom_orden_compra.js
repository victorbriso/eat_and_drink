
/** VARIABLES GLOBALES */
var cantidadInsumoInsert    =   0;
var itemInsumoIsnert        =   0;

$( document ).ready(function() { 
    /**
     * [description]
     * @param  {[type]} ){                 } [description]
     * @return {[type]}     [description]
     */
    $('.modulo-orden-de-compra').on('change', '#insumoSelect', function(){

        $("#OrdenCompraResumenesCantidadSelect").css('border', '1px solid #D5D5D5');
        $('#OrdenCompraResumenesCantidadSelect').val('');
        $('#OrdenCompraResumenesCantidadSelect').focus();
    });
    /**
     * [description]
     * @param  {[type]} e) {                           var code [description]
     * @return {[type]}    [description]
     */
    $("#OrdenCompraResumenesCantidadSelect").keypress(function(e) {
        $(this).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
        var code = (e.keyCode ? e.keyCode : e.which);
        var cantidadSelect  =   $(this).val();

        if(code == 13){ // code 13 = enter
            if ( cantidadSelect == '' ){
                $(this).css('border', '1px dashed #b64645');
            }else{
                var insumo_id                  =   $('#insumoSelect option:selected').attr('insumo_id'); // ID del insumo
                var insumo                     =   $('#insumoSelect option:selected').attr('insumo');// nombre del insumo
                var insumo_impuesto_monto      =   $('#insumoSelect option:selected').attr('impuesto_monto');// monto del impuesto a calcular
                var insumo_impuesto_nombre     =   $('#insumoSelect option:selected').attr('impuesto_nombre');// nombre del impuesto
                var insumo_precio              =   $('#insumoSelect option:selected').attr('precio');// precio del insumo

                $('.insumo_select_'+insumo_id).hide();

                var html_insumo =   '<tr class="tr_insumo_'+itemInsumoIsnert+' tr_insert_insumo" item="'+itemInsumoIsnert+'">'+
                                        '<td>'+
                                            '<label></label> <label>'+insumo+'</label>'+
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][insumo_id]" value="'+insumo_id+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'InsumoId" item="'+itemInsumoIsnert+'">'+   
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][insumo]" value="'+insumo+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'Insumo" item="'+itemInsumoIsnert+'">'+   
                                        '</td>'+
                                        '<td>'+
                                            '<input name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][precio]" class="form-control input-number campo_modena right precio_insumo_op precio_insumo_'+itemInsumoIsnert+'" value="'+formatMoney(insumo_precio,0,',','.')+'" type="text" id="OrdenCompraDetalle'+itemInsumoIsnert+'Precio" maxlength="18" item="'+itemInsumoIsnert+'">'+  
                                        '</td>'+
                                        '<td>'+
                                            '<input name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][cantidad]" class="form-control input-number right cantidad_insumo_op cantidad_insumo_'+itemInsumoIsnert+'" value="'+cantidadSelect+'" type="text" id="OrdenCompraDetalle'+itemInsumoIsnert+'Cantidad" item="'+itemInsumoIsnert+'" maxlength="18">'+                                          
                                        '</td>'+
                                        '<td class="center">'+
                                            '<label></label> <label class="monto_impuesto_insumo_'+itemInsumoIsnert+'"></label>'+
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][impuestoNombre]" value="'+insumo_impuesto_nombre+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'ImpuestoNombre" item="'+itemInsumoIsnert+'">'+   
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][impuesto]" value="'+insumo_impuesto_monto+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'Impuesto" item="'+itemInsumoIsnert+'">'+   
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][monto_impuesto]" value="'+insumo_impuesto_monto+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'MontoImpuesto" item="'+itemInsumoIsnert+'">'+   
                                        '</td>'+
                                        '<td class="right">'+
                                            '<label class="neto_insumo_'+itemInsumoIsnert+'"></label>'+
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][neto]" value="0" id="OrdenCompraDetalle'+itemInsumoIsnert+'Neto" item="'+itemInsumoIsnert+'">'+
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][iva]" value="0" id="OrdenCompraDetalle'+itemInsumoIsnert+'Iva" item="'+itemInsumoIsnert+'">'+
                                            '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][bruto]" value="0" id="OrdenCompraDetalle'+itemInsumoIsnert+'Bruto" item="'+itemInsumoIsnert+'">'+
                                        '</td>'+
                                        '<td class="center icon eliminar_tr_insumo" item="'+itemInsumoIsnert+'" insumo_id="'+insumo_id+'"><i class="fa fa-remove"></i> Eliminar</td>'+
                                    '</tr>';

                $('.lista_insumo_insert').append(html_insumo);
                itemInsumoIsnert ++;
                cantidadInsumoInsert ++;
                $('#insumoSelect').val('');
                $('#insumoSelect').selectpicker("refresh");
                $('#OrdenCompraResumenesCantidadSelect').val('');

                // Se abre el menu
                $( ".btn-default" ).trigger( "click" );
                calcularValores();
                muestraBoton(cantidadInsumoInsert);
            }
        }
    });

        $('.agregaWea').on('click', function(){
        $(this).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
        var cantidadSelect  =   parseInt($('.cantidadInsumoSelect').val());   
        if ( cantidadSelect == '' ){
            $(this).css('border', '1px dashed #b64645');
        }else{
            var insumo_id                  =   $('#insumoSelect option:selected').attr('insumo_id'); // ID del insumo
            var insumo                     =   $('#insumoSelect option:selected').attr('insumo');// nombre del insumo
            var insumo_impuesto_monto      =   $('#insumoSelect option:selected').attr('impuesto_monto');// monto del impuesto a calcular
            var insumo_impuesto_nombre     =   $('#insumoSelect option:selected').attr('impuesto_nombre');// nombre del impuesto
            var insumo_precio              =   $('#insumoSelect option:selected').attr('precio');// precio del insumo

            $('.insumo_select_'+insumo_id).hide();

            var html_insumo =   '<tr class="tr_insumo_'+itemInsumoIsnert+' tr_insert_insumo" item="'+itemInsumoIsnert+'">'+
                                    '<td>'+
                                        '<label></label> <label>'+insumo+'</label>'+
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][insumo_id]" value="'+insumo_id+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'InsumoId" item="'+itemInsumoIsnert+'">'+   
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][insumo]" value="'+insumo+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'Insumo" item="'+itemInsumoIsnert+'">'+   
                                    '</td>'+
                                    '<td>'+
                                        '<input name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][precio]" class="form-control input-number campo_modena right precio_insumo_op precio_insumo_'+itemInsumoIsnert+'" value="'+formatMoney(insumo_precio,0,',','.')+'" type="text" id="OrdenCompraDetalle'+itemInsumoIsnert+'Precio" maxlength="18" item="'+itemInsumoIsnert+'">'+  
                                    '</td>'+
                                    '<td>'+
                                        '<input name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][cantidad]" class="form-control input-number right cantidad_insumo_op cantidad_insumo_'+itemInsumoIsnert+'" value="'+cantidadSelect+'" type="text" id="OrdenCompraDetalle'+itemInsumoIsnert+'Cantidad" item="'+itemInsumoIsnert+'" maxlength="18">'+                                          
                                    '</td>'+
                                    '<td class="center">'+
                                        '<label></label> <label class="monto_impuesto_insumo_'+itemInsumoIsnert+'"></label>'+
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][impuestoNombre]" value="'+insumo_impuesto_nombre+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'ImpuestoNombre" item="'+itemInsumoIsnert+'">'+   
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][impuesto]" value="'+insumo_impuesto_monto+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'Impuesto" item="'+itemInsumoIsnert+'">'+   
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][monto_impuesto]" value="'+insumo_impuesto_monto+'" id="OrdenCompraDetalle'+itemInsumoIsnert+'MontoImpuesto" item="'+itemInsumoIsnert+'">'+   
                                    '</td>'+
                                    '<td class="right">'+
                                        '<label class="neto_insumo_'+itemInsumoIsnert+'"></label>'+
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][neto]" value="0" id="OrdenCompraDetalle'+itemInsumoIsnert+'Neto" item="'+itemInsumoIsnert+'">'+
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][iva]" value="0" id="OrdenCompraDetalle'+itemInsumoIsnert+'Iva" item="'+itemInsumoIsnert+'">'+
                                        '<input type="hidden" name="data[OrdenCompraDetalle]['+itemInsumoIsnert+'][bruto]" value="0" id="OrdenCompraDetalle'+itemInsumoIsnert+'Bruto" item="'+itemInsumoIsnert+'">'+
                                    '</td>'+
                                    '<td class="center icon eliminar_tr_insumo" item="'+itemInsumoIsnert+'" insumo_id="'+insumo_id+'"><i class="fa fa-remove"></i> Eliminar</td>'+
                                '</tr>';

            $('.lista_insumo_insert').append(html_insumo);
            itemInsumoIsnert ++;
            cantidadInsumoInsert ++;
            $('#insumoSelect').val('');
            $('#insumoSelect').selectpicker("refresh");
            $('#OrdenCompraResumenesCantidadSelect').val('');

            // Se abre el menu
            $( ".btn-default" ).trigger( "click" );
            calcularValores();
            muestraBoton(cantidadInsumoInsert);
        }        
    });
    /**
     * [description]
     * @param  {[type]} ){                     calcularValores();    } [description]
     * @return {[type]}     [description]
     */
    $('body').on('keyup','.precio_insumo_op', function(){
        calcularValores();
    });
    /**
     * [description]
     * @param  {[type]} ){                     calcularValores();    } [description]
     * @return {[type]}     [description]
     */
    $('body').on('keyup','.cantidad_insumo_op', function(){
        calcularValores();
    });
    /**
     * [description]
     * @param  {[type]} ){                     var iteral_insumo [description]
     * @return {[type]}     [description]
     */
    $('body').on('click','.eliminar_tr_insumo', function(){
        var iteral_insumo       =   $(this).attr('item');
        var insumo_id       =   $(this).attr('insumo_id');
        $('.tr_insumo_'+iteral_insumo).remove();
        $('.insumo_select_'+insumo_id).show();
        cantidadInsumoInsert --;
        muestraBoton(cantidadInsumoInsert);
    });
    

});
/**
 * [calcularValores description]
 * @return {[type]} [description]
 */
function calcularValores()
{
    var netoTotalOrden          =   0;
    var impuestoTotalOrden      =   0;
    var ivaTotalOrden           =   0;
    var brutoTotalOrden         =   0;
    /**
     *  Se recorre cada insumo, para cualcular:
     *  1. Monto impuesto, si este tiene asignado
     *  2. Neto
     *  3. Iva
     *
     * Por insumo y total orden
     */
    $('.tr_insert_insumo').each(function(){
        var iteral_insumo       =   $(this).attr('item');
        
        // obtenemos el precio del insumo
        var precio_insumo   =   $('#OrdenCompraDetalle'+iteral_insumo+'Precio').val();
        precio_insumo       =   precio_insumo.replace(/\./g,'');
        precio_insumo       =   parseInt(precio_insumo);
        // Obtenemos la cantidad
        var cantidad_insumo   =   $('#OrdenCompraDetalle'+iteral_insumo+'Cantidad').val();
        // Obtenemos el monto del impuesto asignado
        var impuesto_insumo   =   $('#OrdenCompraDetalle'+iteral_insumo+'Impuesto').val();
        var impuesto_insumo_asignado   =   $('#OrdenCompraDetalle'+iteral_insumo+'ImpuestoNombre').val();

        if ( impuesto_insumo != '' ){
            impuesto_insumo       =   parseFloat(impuesto_insumo) / 100;
            // Calculo el monto del impuesto
            var monto_impuesto_insumo  = (precio_insumo * impuesto_insumo ) * cantidad_insumo;
        }else{
            var monto_impuesto_insumo = 0;
        }

        // Calculo del  iva
        var neto_insummo         =   precio_insumo * 1.19;
        var iva_insumo           =   parseFloat(neto_insummo) - parseFloat(precio_insumo);
        var total_neto_insumo    =  ( parseInt(precio_insumo) ) * cantidad_insumo;
        var bruto_total_insumo   =  ( parseInt(precio_insumo) + parseInt(monto_impuesto_insumo) + parseInt(iva_insumo) ) * cantidad_insumo;
        var iva_total_insumo     =  bruto_total_insumo - total_neto_insumo;

        $('#OrdenCompraDetalle'+iteral_insumo+'Neto').val(total_neto_insumo);
        $('#OrdenCompraDetalle'+iteral_insumo+'Iva').val(iva_insumo);
        $('#OrdenCompraDetalle'+iteral_insumo+'Bruto').val(bruto_total_insumo);

        $('.monto_impuesto_insumo_'+iteral_insumo).html(impuesto_insumo_asignado+' $ '+formatMoney(monto_impuesto_insumo,0,',','.'));
        $('.neto_insumo_'+iteral_insumo).html(' $ '+formatMoney(total_neto_insumo,0,',','.'));
        $('#OrdenCompraDetalle'+iteral_insumo+'MontoImpuesto').val(monto_impuesto_insumo);

        // Calculo valores totales
        netoTotalOrden = parseInt(netoTotalOrden) + parseInt(total_neto_insumo);
        impuestoTotalOrden = parseInt(impuestoTotalOrden) + parseInt(monto_impuesto_insumo);
        ivaTotalOrden = parseInt(ivaTotalOrden) + parseInt(iva_insumo);
        brutoTotalOrden = parseInt(brutoTotalOrden) + parseInt(bruto_total_insumo);
        
    });

    $('.lable_neto_order_compra').html(' $ '+formatMoney(netoTotalOrden,0,',','.'));
    $('.label_impuesto_order_compra').html(' $ '+formatMoney(impuestoTotalOrden,0,',','.'));
    $('.lable_iva_order_compra').html(' $ '+formatMoney(ivaTotalOrden,0,',','.'));
    $('.label_bruto_order_compra').html(' $ '+formatMoney(brutoTotalOrden,0,',','.'));

    $('#OrdenCompraResumenesTotalOrdenNeto').val(netoTotalOrden);
    $('#OrdenCompraResumenesTotalOrdenMontoImpuesto').val(impuestoTotalOrden);
    $('#OrdenCompraResumenesTotalOrdenIva').val(ivaTotalOrden);
    $('#OrdenCompraResumenesTotalOrdenBruto').val(brutoTotalOrden);
}

function muestraBoton(iteral){
    if(iteral>0){
        document.getElementById('enviar').style.display = 'inline';
    }else{
        document.getElementById('enviar').style.display = 'none';
    }
}

window.onload = function(){
    document.getElementById('enviar').style.display = 'none';
}