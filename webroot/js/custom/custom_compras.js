/**
 * Custom Compras
 */

 var compra_con_iva              =   true; 


$('.tr_impuestos').hide();
$('.tr_monto_total_iva').hide();

$( document ).ready(function() { 

    var cantidad_insumos_agregados  =   0;

    $('#documentoTributario').change(function(){
        var idDocumento                   = $(this).val();
        idDocumento2=idDocumento;
    });
   
    /**
     * INCIO ENVIAR FACTURA
     */
    $('.enviar-compra').on('click', function( event ){
        event.preventDefault();
        $('#modalValidacionCompra').modal('hide');
        $('.btn-form-submit').hide();
        $('.gif-cargando').show();
        $('.msn-alert-distribucion').addClass('ocultar');

        $('.msn_campo_requerido').remove();
        $( '#CompraFolio' ).css('border', '1px solid #D5D5D5');

        // Se validan campos 
        var enviar          =   true;
        var enviar_form     =   true;

        // Validacion de proveedor
        if ( $('#CompraProveedorClienteId').val() == 0 || $('#CompraProveedorClienteId').val() == null || $('#CompraProveedorClienteId').val() == ""){
            enviar  = false;
            $('.msn_lista_proveedores').append('<p class="msn_campo_requerido">* Seleccionar un proveedor</p>');
        }else{
            var proveedor_id                = $('#CompraProveedorClienteId').val();
            var unidad_rut                  = $('option:selected', '#CompraProveedorClienteId').attr('rut');
            var unidad_nombre               = $('option:selected', '#CompraProveedorClienteId').attr('nombre');

            $('#CompraProveedorId').val(proveedor_id);
            $('#CompraProveedorNombre').val(unidad_nombre);
            $('#CompraProveedorRutDni').val(unidad_rut);
        }


        // Validacion de numero de folio
        if ( $('#CompraFolio').val() == '' ){
            enviar  = false;
            $( '#CompraFolio' ).css('border', '1px dashed #b64645');
            $('.campo_folio').append('<p class="msn_campo_requerido">* Ingresar el folio del proveedor</p>');
        }

        // Validacion de insumos agregados
        if ( cantidad_insumos_agregados == 0 ){
            enviar  = false;
            $('.div-agregar-insumos').append('<p class="msn_campo_requerido">* Ingresar al menos 1 insumo</p>');
        }

        // Validacion de distribucion de insumos en bodegas
        if ( $('.distribucionBodegasModal').length ){
            $('.distribucionBodegasModal').each(function(){
                var aceptacion_asignacion = $(this).val();
                var iteral = $(this).attr('iteral');

                if (aceptacion_asignacion == 0){
                    enviar  = false;
                    $('.msn-alert-distribucion').removeClass('ocultar');
                    $('.text_bodega_'+iteral).addClass('color-resaltado')
                }
            });
        }

        if ( enviar ){

             setTimeout(function(){

                var numero_folio    =   $('#CompraFolio').val();
                var id_proveedor    =   $('#CompraProveedorClienteId').val();

                
                $.ajax({
                    type        : 'POST',
                    url         : webroot + 'Compras/ajax_validarFolio',
                    data            : {
                        numero_folio        : numero_folio,
                        tipo_proveedor      : 1,
                        id_proveedor        : id_proveedor,
                        tipoDocumento       : idDocumento2
                    },
                    success     : function(msg){
                        if ( msg == 1 ){
                            $('#alerta_datos_registrados').addClass('open');
                            $('#CompraFolio').css('border', '1px dashed #b64645');
                            $('.btn-form-submit').show();
                            $('.gif-cargando').hide();
                        }else{
                            $( "#CompraAddForm" ).submit();
                        }
                    }

                  });
                  

             }, 1000);

        }else{
            $('.btn-form-submit').show();
            $('.gif-cargando').hide();
        }

        
    });

    /**
     * FIN ENVIAR FACTURA
     */
    $( '.select_mi_proveedor' ).on( 'click', function() {
        $('.proveedores_sistema_js').prop('checked', false);
        if( $('.mis_proveedores_js').prop('checked') ) {
            accionSelectProveedor('select_mis_proveedores', 'select_proveedores_sistema', 'select_proveedor_privado');
        }else{
            resetSelect('select_mis_proveedores');
            ocultarSelectProveedor('select_mis_proveedores','select_proveedor_privado');
        }

    });

    $( '.select_sistema_proveedor' ).on( 'click', function() {
        $('.mis_proveedores_js').prop('checked', false);
        if( $('.select_sistema_proveedor').prop('checked') ) {
            accionSelectProveedor( 'select_proveedores_sistema', 'select_mis_proveedores', 'select_proveedor_cliente');
        }else{
            resetSelect('select_proveedores_sistema');
            ocultarSelectProveedor('select_proveedores_sistema','select_proveedor_cliente');
        }

    });

    /**
     * Se organiza los arreglos con los impuestos establecidos
     * @type {Array}
     */
    impuesto_especifico_monto   =   new Array(); // arreglo con lo montos 
    impuesto_especifico_nombre  =   new Array(); // aarreglo con los nombre
    
    impuestos.forEach(function(imp_especifico) {
      impuesto_especifico_monto[imp_especifico.Impuesto.id] = imp_especifico.Impuesto.monto;
    });
    
    impuestos.forEach(function(imp_especifico) {
      impuesto_especifico_nombre[imp_especifico.Impuesto.id]    = imp_especifico.Impuesto.nombre;
    });

    /**
     * [if description]
     * @param  {[type]} $('.compras-insumos').length [description]
     * @return {[type]}                              [description]
     */
    if ( $('.compras-insumos').length ){

        var insumo_text_seleccionado    = '';
        var unidad_text_seleccionado    = '';
        var insumo_id_seleccionado      = '';
        var insumo_precio_seleccionado  = '';
        var insumo_stock_seleccionado   = '';
        var insumo_imp_seleccionado     = '';
        var insumo_iva_seleccionado     = '';
        var total_compra_insumo         = 0;

        /**
         * Se coloca la unidad de salida del insumo, al seleccionarlo
         */
        $('#compraInsumo').change(function(){
            var unidad_compra               = $('option:selected', this).attr('unidad');
            var precio_insumo               = $('option:selected', this).attr('precio');
            var stock_insumo                = $('option:selected', this).attr('stock');
            var imp_insumo                  = $('option:selected', this).attr('impuesto');
            var iva_insumo                  = $('option:selected', this).attr('con_iva');
            var id_insumo                   = $(this).val();
            var insumo_seleccionado_select  = $('option:selected', this).text();
            
            insumo_seleccionado         =   insumo_seleccionado_select;
            insumo_id_seleccionado      =   id_insumo;
            unidad_text_seleccionado    =   unidad_compra;
            insumo_imp_seleccionado     =   imp_insumo;
            insumo_iva_seleccionado     =   iva_insumo;
            insumo_precio_seleccionado  =   (( precio_insumo != '' && precio_insumo != null ) ? precio_insumo : 0);
            insumo_stock_seleccionado   =   stock_insumo;

            $('.unidad-isumo-compra').html(unidad_compra);


            $('#CompraCantidadInsumoSelect').focus();
        });


         $("#CompraCantidadInsumoSelect").keypress(function(e) {
            $(this).css('border', '1px solid #D5D5D5'); // Se resetea el borde de los campos
            var code = (e.keyCode ? e.keyCode : e.which);
            var cantidadSelect  =   $(this).val();

            if(code == 13){ // code 13 = enter
                if ( cantidadSelect == '' ){
                    $(this).css('border', '1px dashed #b64645');
                }else{
                    $('.agregar_insumo_compra').trigger('click');
                    // Se abre el menu
                    $( ".btn-default" ).trigger( "click" );
                }
            }
        });

        /**
         * [description]
         * @param  {[type]} ){          var id_insumo     [description]
         * @return {[type]}           [description]
         */
        $('.agregar_insumo_compra').on('click', function(){ 

            var id_insumo               = $('#compraInsumo').val();
            var insumo_nombre           = $('option:selected', '#compraInsumo').attr('insumo_nombre');
            var insumo_unidad           = $('option:selected', '#compraInsumo').attr('unidad');
            var impuesto_insumo         = $('option:selected', '#compraInsumo').attr('impuesto');
            var nombre_impuesto_insumo     = $('option:selected', '#compraInsumo').attr('impuesto_nombre');
            var monto_impuesto_insumo      = $('option:selected', '#compraInsumo').attr('impuesto_monto');
            var cantidad    = $('.cantidadInsumoSelect').val();
            cantidad        = cantidad.replace(",",".");

            $('.insumo_select_'+ insumo_id_seleccionado).hide();
            total_compra_insumo         = parseFloat( insumo_precio_seleccionado * cantidad);
            

            if ( id_insumo != '' && id_insumo != null ){

                if ( ! cantidad > 0){
                    $('.cantidadInsumoSelect').css('border', '1px dashed red');
                    return;
                }
                
                var insumo = '<tr class="tr_insumo_agregado item_insumo_'+ insumo_agregado_compra +'" iteral_tr="'+insumo_agregado_compra+'">' +
                                 // id insumo
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][insumos_id]" class="form-control" value="'+id_insumo+'" id="Detalle'+insumo_agregado_compra+'InsumosId">' +
                                 // insumo
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][insumo]" class="form-control" value="'+insumo_nombre+'" id="Detalle'+insumo_agregado_compra+'Insumo">' +
                                 // cantidad insumo
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][cantidad]" class="form-control cantidad_insumo" value="'+ cantidad +'" id="Detalle'+insumo_agregado_compra+'Cantidad">' +
                                 // precio Insumo
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][precio]" class="form-control precio_total_insumo" value="0" id="Detalle'+insumo_agregado_compra+'Precio">' +
                                  // neto Insumo
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][neto]" class="form-control campo_total_insumo" value="0" id="Detalle'+insumo_agregado_compra+'Neto">' +
                                  // subneto Insumo
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][subneto]" class="form-control" value="0" id="Detalle'+insumo_agregado_compra+'SubNeto">' +
                                // Iva
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][iva]" class="form-control" value="0" id="Detalle'+insumo_agregado_compra+'Iva">' +
                                 // Detalle Iva
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][detalle_iva]" class="form-control" value="0" id="Detalle'+insumo_agregado_compra+'DetalleIva">' +
                                 // Impuesto espeficio
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][impuesto]" class="form-control" value="'+ impuesto_insumo +'" id="Detalle'+insumo_agregado_compra+'Impuesto">' +
                                 // Monto impuesto espeficio
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][monto_impuesto]" class="form-control" value="'+ (monto_impuesto_insumo == '' ? 0 : monto_impuesto_insumo) +'" id="Detalle'+insumo_agregado_compra+'MontoImpuesto">' +
                                 // Nombre impuesto espeficio
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][nombre_impuesto]" class="form-control" value="'+ nombre_impuesto_insumo +'" id="Detalle'+insumo_agregado_compra+'NombreImpuesto">' +
                                 // calculo impuesto espeficio
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][calculo_impuesto]" class="form-control campo_impuesto_especifico_insumo" value="0" id="Detalle'+insumo_agregado_compra+'CalculoImpuesto">' +
                                  // Registro Local ID
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][registro_local_id]" class="form-control" value="'+registro_local_id+'" id="Detalle'+insumo_agregado_compra+'RegistroLocalId">' +
                                 // tipo descuento
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][tipo_descuento]" class="form-control" value="" id="Detalle'+insumo_agregado_compra+'TipoDescuento" >'+ 
                                 // Monto_descuento porcentual
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][decuento_porcentual]" class="form-control" value="0" id="Detalle'+insumo_agregado_compra+'DescuentoPorcentual" >'+ 
                                 // Monto descuento dinero
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][descuento_monto]" class="form-control" value="0" id="Detalle'+insumo_agregado_compra+'DescuentoMonto" >'+ 
                                 // Monto Total descuento
                                 '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][descuento_insumo]" class="form-control campo_total_descuento_insumo" value="0" id="Detalle'+insumo_agregado_compra+'DescuentoInsumo" >';
                                 // ingresos a bodegas
                                 if ( cant_bodegas > 1 ){
                                    for (var i = 0; i < cant_bodegas; i++) {
                                       insumo += '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][bodega]['+i+'][bodega_id]" value="" id="DetalleBodega'+insumo_agregado_compra+''+i+'BodegaId" >'+ 
                                        '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][bodega]['+i+'][cantidad]" value="0" id="DetalleBodega'+insumo_agregado_compra+''+i+'BodegaCantidad" >'+ 
                                        '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][bodega]['+i+'][tipo]" value="1" id="DetalleBodega'+insumo_agregado_compra+''+i+'BodegaTipo" >';
                                    }
                                    insumo += '<input type="hidden" class="distribucionBodegasModal" iteral="'+insumo_agregado_compra+'" name="data[Detalle]['+insumo_agregado_compra+'][bodega_asignado]" value="0" id="DetalleBodega'+insumo_agregado_compra+'BodegaAsignado" >';
                                 }else{
                                     insumo += '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][bodega][0][bodega_id]" value="'+solo_una_bodega+'" id="DetalleBodega'+insumo_agregado_compra+'0BodegaId" >'+ 
                                        '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][bodega][0][cantidad]" value="'+ cantidad +'" id="DetalleBodega'+insumo_agregado_compra+'0BodegaCantidad" >'+ 
                                        '<input type="hidden" name="data[Detalle]['+insumo_agregado_compra+'][bodega][0][tipo]" value="1" id="DetalleBodega'+insumo_agregado_compra+'0BodegaTipo" >'+
                                        '<input type="hidden" class="distribucionBodegasModal" iteral="'+insumo_agregado_compra+'" name="data[Detalle]['+insumo_agregado_compra+'][bodega_asignado]" value="1" id="DetalleBodega'+insumo_agregado_compra+'BodegaAsignado" >';
                                 }   
                                // Columna con el nombre y detalle del insumo
                                insumo += '<td width="20%">' +
                                      '<strong>'+ insumo_seleccionado +'</strong>' +
                                            '<p>Stock: '+ insumo_stock_seleccionado +' '+ insumo_unidad +'</p>' +
                                '</td>' +
                                // Columna con el valor del insumo, el cual puede ser modificado
                                '<td class="text-center">' +
                                    '<input name="data[DetalleCompra]['+insumo_agregado_compra+'][neto]" class="form-control input-number campo_modena right campo_valor_insumo insumo_valor_'+insumo_agregado_compra+'" item_insumo="'+ insumo_agregado_compra +'" type="text" id="DetalleCompra'+insumo_agregado_compra+'Neto" value="">'+
                                '</td>'+
                                // Columna descuento
                                '<td class="icheckbox center">'+
                                        ' % <label class="check"><input type="radio" value="1" class="iradio radio_tipo_descuento_insumo" item="'+insumo_agregado_compra+'" name="data[Detalle]['+insumo_agregado_compra+'][tipo_descuento]" /></label>'+
                                        ' $ <label class="check"><input type="radio" value="2" class="iradio radio_tipo_descuento_insumo" item="'+insumo_agregado_compra+'" name="data[Detalle]['+insumo_agregado_compra+'][tipo_descuento]" checked /></label>'+
                                '</td>' +   
                                '<td class="text-center">' +
                                    '<input name="data[DetalleCompra]['+insumo_agregado_compra+'][descuento]" class="form-control campo_decuento_insumo input-number campo_modena right" item_insumo="'+ insumo_agregado_compra +'" type="text" id="DetalleCompra'+insumo_agregado_compra+'Descuento" value="">'+
                                    '<span class="msn_campo_requerido ocultar mensaje_alert_costo_'+insumo_agregado_compra+'">Debe ingresar el costo</span>'+
                                '</td>'+
                                // Columna con la cantidad del insumo
                                '<td class="text-center" width="10%">'+ cantidad +' - ' + insumo_unidad + ''+
                                '</td>';
                                if ( cant_bodegas > 1 ){
                                    // Columna distribucion de bodegas 
                                    insumo += '<td class="text-center"><button type="button" class="btn btn-danger btn-block openModal distribucion-bodegas icon openModalDistribucion text_bodega_'+insumo_agregado_compra+'" modal="modalDistribucionBodegas" item_insumo="'+ insumo_agregado_compra +'"><i class="fa fa-plus"></i> Bodegas</button></td>';
                                }
                                // Columna con el total de insumo
                                insumo += '<td class="text-center">$ <span class="total_precio_insumo_'+insumo_agregado_compra+'"></span>' +
                                '</td>' +
                                
                                // Columna para la accion de eliminar insumo
                                '<td>'+
                                    '<i class="fa fa-trash-o fa-lg icon eliminar_item_insumo" item_insumo="'+ insumo_agregado_compra +'" insumo_id_item="'+ insumo_id_seleccionado +'"></i>'+
                                '</td>'+
                            '</tr>';

                var modalInsumo = '<tr class="tr_insumo_agregado_modal item_modal_'+ insumo_agregado_compra +'" iteral_tr_modal="'+insumo_agregado_compra+'">' +
                                    '<td>'+ insumo_nombre +'</td>'+
                                    '<td>'+ cantidad +'</td>'+
                                    '<td id="modalDetalle'+insumo_agregado_compra+'Precio">Detalle'+insumo_agregado_compra+'Precio</td>'+
                                    '<td id="modalDetalle'+insumo_agregado_compra+'Neto">Detalle'+insumo_agregado_compra+'Neto</td>'+
                                    '<td id="modalDetalle'+insumo_agregado_compra+'DescuentoInsumo">Detalle'+insumo_agregado_compra+'DescuentoInsumo</td>'+
                                    '<td id="modalDetalle'+insumo_agregado_compra+'SubNeto">Detalle'+insumo_agregado_compra+'SubNeto</td>'+
                                   '</tr>'
                                 
                                 
                $('#modalDetalleCompra').append(modalInsumo);                 
                $('.table-items-compra').append(insumo);
                $(".icheckbox,.iradio").iCheck({checkboxClass: 'icheckbox_minimal-grey',radioClass: 'iradio_minimal-grey'});
                $('.cantidadInsumoSelect').css('border', '1px solid #D5D5D5');
                $('.cantidadInsumoSelect').val('');
                $("#compraInsumo").val('default');
                $("#compraInsumo").selectpicker("refresh");
                $('.campo_modena').attr('maxlength','18');

                insumo_seleccionado     =   '';
                insumo_id_seleccionado  =   '';
                cantidad_insumos_agregados ++;
                insumo_agregado_compra ++;
            }
        });

        $('.table-items-compra').on('click', '.eliminar_item_insumo', function(event){
            event.preventDefault();
            var item_eliminar       =   $(this).attr('item_insumo');
            var id_item_eliminar    =   $(this).attr('insumo_id_item');

            $('.item_insumo_'+ item_eliminar).remove();
            $('.item_modal_'+ item_eliminar).remove();
            $('.insumo_select_'+ id_item_eliminar).show();
            cantidad_insumos_agregados --;
            calcularTotalesFactura();

        });

        /**
         * Se calcula el total neto
         */
        $('.table-items-compra').on('keyup', '.campo_valor_insumo', function(){
            var item_ingresado          =   $(this).attr('item_insumo');
            // Monto ingresado
            var valor_ingresado_costo   =   $(this).val();
            valor_ingresado_costo       =   valor_ingresado_costo.replace(/\./g,'');
            valor_ingresado_costo       =   parseInt(valor_ingresado_costo);
            // Cantidad ingresada
            var cantidad_insumo         =   $('#Detalle'+item_ingresado+'Cantidad').val();
            // calculo total            
            var total_insumo            =   valor_ingresado_costo * cantidad_insumo;
            $('.total_precio_insumo_'+item_ingresado).html(new Intl.NumberFormat("de-DE").format(total_insumo));
            
            $('#Detalle'+item_ingresado+'Precio').val(valor_ingresado_costo);
            $('#Detalle'+item_ingresado+'Neto').val(total_insumo);
            $('#Detalle'+item_ingresado+'SubNeto').val(total_insumo);
            
            // calculo del impuesto espeficifo, si este lo tiene
            var impuesto_especifico =   $('#Detalle'+item_ingresado+'Impuesto').val();
            if ( impuesto_especifico > 0 && valor_ingresado_costo >= 0){
                var monto_impuesto_especifico = $('#Detalle'+item_ingresado+'MontoImpuesto').val();
                monto_impuesto_especifico = parseFloat(monto_impuesto_especifico) / 100;
                var impuesto_efectuado  =   parseFloat(valor_ingresado_costo) * monto_impuesto_especifico;
                $('#Detalle'+item_ingresado+'CalculoImpuesto').val(impuesto_efectuado * cantidad_insumo);
            }else{
                $('#Detalle'+item_ingresado+'CalculoImpuesto').val(0);
            }

            calcularTotalesFactura();
        });

        
        $('#CompraValorDescuentoGeneral').on('keyup', function(){
            calcularTotalesFactura();
        });

        /**
         * Se calcula el descuento descuento del insumo
         */
        $('.table-items-compra').on('keyup', '.campo_decuento_insumo', function(){

            var descuento_monto_insumo      =   0;
            var descuento_efectuado         =   0;
            var item_ingresado              =   $(this).attr('item_insumo');
            var valor_costo_insumo          =   $('#Detalle'+item_ingresado+'Neto').val();
            var valor_ingresado_descuento   =   $(this).val();
            var cantidad_insumo_ingresado   =   $('#Detalle'+item_ingresado+'Cantidad').val();
            var descuento_porcentual        =   0;
            var descuento_monto             =   0;
            valor_ingresado_descuento       =   valor_ingresado_descuento.replace(/\./g,'');

            $('.mensaje_alert_costo_'+item_ingresado).addClass('ocultar');
           
            // Monto ingresado como precio neto del insumo
            if ( valor_costo_insumo != '' && valor_costo_insumo != null && valor_costo_insumo >= 0 ){
                // tipo_descuento_insumo. 1: % -  2: $
                var tipo_descuento_insumo      =   $("input[name='data[Detalle]["+item_ingresado+"][tipo_descuento]']:checked").val();

                if ( tipo_descuento_insumo == 1 ){

                    if ( valor_ingresado_descuento  == '' ){
                        valor_ingresado_descuento       =   0;
                    }
                    if (valor_ingresado_descuento > 100){
                        valor_ingresado_descuento       =   0;
                        $(this).val(0);
                    }
                        
                        descuento_porcentual        =   valor_ingresado_descuento;
                        descuento_monto_insumo      =   parseInt(valor_ingresado_descuento) / 100;
                        descuento_efectuado         =   parseFloat(valor_costo_insumo) * parseFloat(descuento_monto_insumo);
                        valor_costo_insumo          =   parseFloat(valor_costo_insumo) - parseFloat(descuento_efectuado);
                        $('.total_precio_insumo_'+item_ingresado).html(new Intl.NumberFormat("de-DE").format(valor_costo_insumo));
                        $('#Detalle'+item_ingresado+'DescuentoInsumo').val(descuento_efectuado);
                    

                } else if ( tipo_descuento_insumo == 2 ){
                    
                    if ( valor_ingresado_descuento  == '' ){
                        valor_ingresado_descuento       =   0;
                    }

                    descuento_monto = valor_ingresado_descuento;
                    if(parseFloat(valor_ingresado_descuento) <= parseFloat(valor_costo_insumo)){
                        descuento_efectuado = valor_ingresado_descuento;
                        valor_costo_insumo = parseFloat(valor_costo_insumo) - parseFloat(descuento_efectuado * cantidad_insumo_ingresado);
                        $('.total_precio_insumo_'+item_ingresado).html(new Intl.NumberFormat("de-DE").format(valor_costo_insumo));
                    }else{
                        descuento_monto_insumo       =   0;
                        $(this).val('');
                    }

                    $('#Detalle'+item_ingresado+'SubNeto').val(valor_costo_insumo);
                    $('#Detalle'+item_ingresado+'DescuentoInsumo').val(descuento_efectuado * cantidad_insumo_ingresado);
                    
                }
                /** Recalculo del impuesto en relacion al descuento */
                var impuesto_especifico =   $('#Detalle'+item_ingresado+'Impuesto').val();
                if ( impuesto_especifico > 0 && valor_costo_insumo >= 0){
                    var monto_impuesto_especifico = $('#Detalle'+item_ingresado+'MontoImpuesto').val();
                    monto_impuesto_especifico = parseFloat(monto_impuesto_especifico) / 100;
                    var impuesto_efectuado  =   parseFloat(valor_costo_insumo) * monto_impuesto_especifico;
                    $('#Detalle'+item_ingresado+'CalculoImpuesto').val(impuesto_efectuado * cantidad_insumo_ingresado);
                }else{
                    $('#Detalle'+item_ingresado+'CalculoImpuesto').val(0);
                }

                $('#Detalle'+item_ingresado+'TipoDescuento').val(tipo_descuento_insumo);
                $('#Detalle'+item_ingresado+'DescuentoPorcentual').val(descuento_porcentual);
                $('#Detalle'+item_ingresado+'DescuentoMonto').val(descuento_monto);
                

            }else{
                $('.mensaje_alert_costo_'+item_ingresado).removeClass('ocultar');
                $(this).val('');
            }

            calcularTotalesFactura();

        });

        $('.table-items-compra').on('keyup', '.campo_modena', function(){

            this.value          =   this.value.replace(/[^0-9]/g,'');
            this.value          =   this.value.replace('-','');
            this.value          =   this.value.replace('+','');
            this.value          =   this.value.replace('*','');
            this.value          =   this.value.replace('/','');
            this.value          =   this.value.replace('#','');
            
            var valor_ingresado     =   $(this).val();
            var id_campo            =   $(this).attr('id');
            var item_insumo         =   $(this).attr('item_insumo');
            valor_ingresado         =   valor_ingresado.replace('-','');
            valor_ingresado         =   valor_ingresado.replace('+','');
            valor_ingresado         =   valor_ingresado.replace('*','');
            valor_ingresado         =   valor_ingresado.replace('/','');
            valor_ingresado         =   valor_ingresado.replace('#','');
            valor_ingresado         =   valor_ingresado.replace('.', '');
            var valor_insumo_ingresado = valor_ingresado;
            
            $('#' + id_campo).val(formatoNumero(valor_ingresado));

        });

        $('body').on('click', '.openModalDistribucion', function(event){
            event.preventDefault();
            var itera_insumo    =   $(this).attr('item_insumo');
            var insumo          =   $('#Detalle'+itera_insumo+'Insumo').val();
            var cantidad_insumo =   $('#Detalle'+itera_insumo+'Cantidad').val();

            $('#modalIteralInsumo').val(itera_insumo);
            $('.insumoDistribucion').html(insumo);
            $('.insumoCantidadDistribucion').html(cantidad_insumo);
            $('.insumoCantidadFaltanteDistribucion').html(cantidad_insumo);
            $('.insumoCantidadAsignadaDistribucion').html(0);
            $('.asignarCantidadBodegas').attr('iteral_insumo', itera_insumo);

            $('#modalDistribucionBodegas').removeClass('ocultar');
            inicializarIziModal( 'modalDistribucionBodegas' );
            $('#modalDistribucionBodegas').iziModal('open');
        });

        $('body').on('keyup', '.cantidadAsigandaBodega', function(){
             var cantidad_total_bodegas = 0;
             var modalIteralInsumo      = $('#modalIteralInsumo').val();
             var cantidaInsumoIngresa   = $('#Detalle'+modalIteralInsumo+'Cantidad').val();

             $('.cantidadAsigandaBodega').each(function(){
                var cantidad_bodega    =   $(this).val();
                if ( cantidad_bodega != '' && cantidad_bodega != null && cantidad_bodega >= 0 ){
                    cantidad_total_bodegas   =   parseFloat(cantidad_total_bodegas) + parseFloat(cantidad_bodega);
                }
            });

            if (cantidad_total_bodegas > cantidaInsumoIngresa){
                $('.msn_alerta_cantidad_insumos').removeClass('ocultar');
                cantidad_total_bodegas = 0;
                $('.btn-modal-asignar').removeClass('asignarCantidadBodegas');
            }else{
                $('.msn_alerta_cantidad_insumos').addClass('ocultar');
                
            }
            if (parseFloat(cantidaInsumoIngresa - cantidad_total_bodegas) == 0){
                $('.btn-modal-asignar').addClass('asignarCantidadBodegas');
            }

            $('.insumoCantidadAsignadaDistribucion').html(cantidad_total_bodegas);
            $('.insumoCantidadFaltanteDistribucion').html(parseFloat(cantidaInsumoIngresa - cantidad_total_bodegas));

        });

        $('body').on('click', '.asignarCantidadBodegas', function(){

            var modalIteralInsumo      = $('#modalIteralInsumo').val();
            $('.cantidadAsigandaBodega').each(function(){

                var cantidad_bodega     =   $(this).val();
                var iteral_campo        =   $(this).attr('iteralCampo');
                var idCampo             =   $(this).attr('idCampo');
                if ( cantidad_bodega == '' || cantidad_bodega == null  ){
                    cantidad_bodega   =   0;
                }
                $('#DetalleBodega'+modalIteralInsumo+''+iteral_campo+'BodegaId').val(idCampo);
                $('#DetalleBodega'+modalIteralInsumo+''+iteral_campo+'BodegaCantidad').val(cantidad_bodega);
                $('#DetalleBodega'+modalIteralInsumo+'BodegaAsignado').val(1);
            });

            $('#modalDistribucionBodegas').hide();
            $('#modalDistribucionBodegas').iziModal('destroy'); 

        });

    }

});

/**
 * [calcularTotalesFactura description]
 * Funcion que permite calcular los totales de la factura de compra
 * @return {[type]} [description]
 */
function calcularTotalesFactura()
{
    // Generales
    var total_neto_compra           =   0;
    var total_neto_compra_op        =   0;
    var total_bruto_compra          =   0;
    var total_iva                   =   0;
    var total_descuento             =   0;
    var total_descuento_general     =   0;
    var total_descuento_procentual  =   0;
    var total_descuento_liquido     =   0;
    var total_impuesto_especifico   =   0;
    var escuento_general_tipo       =   2;
    var descuento_total_monto       =   0;
    var compra_con_impuesto         =   false; // variable que indica que hay insumo(s) que posee un impuesto especifico
    

    // calculo de neto total
    $('.campo_total_insumo').each(function(){
        var total_insumo    =   $(this).val();
        if ( total_insumo != '' && total_insumo != null && total_insumo >= 0 ){
            total_neto_compra   =   parseInt(total_neto_compra) + parseInt(total_insumo);
        }
    });
    
    total_neto_compra_op = total_neto_compra;

    // Calculo del descuento por insumos
    $('.campo_total_descuento_insumo').each(function(){
        var descuento_insumo    =   $(this).val();
        if( descuento_insumo >= 0){
            total_descuento         =   parseInt(total_descuento) + parseInt(descuento_insumo);
        }
    });

    total_neto_compra_op = parseInt(total_neto_compra_op) - parseInt(total_descuento);

    // Calculo del descuento general
    if ( $('#CompraValorDescuentoGeneral').val() >= 0 ){
        var descuento_ingresado         =   $('#CompraValorDescuentoGeneral').val();
        descuento_ingresado             =   ( descuento_ingresado == '' ? 0 : descuento_ingresado );
        var tipo_descuento_general      =   $("input[name='radio_descuento_general']:checked").val();
        escuento_general_tipo           = tipo_descuento_general;
        
        // 1: Porcentual - 2: liquido
        if (tipo_descuento_general == 1){
            var descuento_porcentual        =   descuento_ingresado;
            var descuento_monto_insumo      =   parseInt(descuento_porcentual) / 100;
            descuento_total_monto           =   descuento_ingresado;
            total_descuento_general         =   parseFloat(total_neto_compra_op) * parseFloat(descuento_monto_insumo);
            total_descuento_procentual      =   descuento_porcentual;
            total_descuento_liquido =   0;
        }else{
            total_descuento_general         =   descuento_ingresado;
            descuento_total_monto         =   descuento_ingresado;
            total_descuento_liquido      =   total_descuento_general;
            total_descuento_procentual  =   0;
        }
        total_neto_compra_op = parseInt(total_neto_compra_op) - parseInt(total_descuento_general);
        total_descuento = parseInt(total_descuento) + parseInt(total_descuento_general);
    }

    // calculo de impuestos especificos
    $('.tr_insumo_agregado').each(function(){
        var iteral     =   $(this).attr('iteral_tr');
        var impuesto_monto_insumo = $('#Detalle'+iteral+'CalculoImpuesto').val();
        if ( impuesto_monto_insumo != '' ){
           
            var valor_impuesto          = parseFloat(impuesto_monto_insumo);
            total_impuesto_especifico   = parseFloat(total_impuesto_especifico) + parseFloat(valor_impuesto);
            compra_con_impuesto = true;
        }
    });

    /** si compra con impuesto es verdadero y hay descuento general, se calculan los valores totales */
    if ( total_descuento_general > 0){

        var lista_insumos = [];
        $('.tr_insumo_agregado').each(function( index ){
            var iteral     =   $(this).attr('iteral_tr');
            var insumo_id  =   $('#Detalle'+iteral+'InsumosId').val();
            var neto       =   $('#Detalle'+iteral+'SubNeto').val();
            var impuesto   =   $('#Detalle'+iteral+'MontoImpuesto').val();
            
            lista_insumos[index] = { 
                 id: insumo_id, neto: neto, impuesto: impuesto
            }
        });

        var datos_compra    =   {

            tipo    :   escuento_general_tipo,
            monto   :   descuento_total_monto,
            insumo  :   lista_insumos
        }

        $.ajax({
            type        : 'POST',
            url         : webroot + 'Compras/ajax_calculoTotales',
            data            : {
                datos_compra        : datos_compra,
            },
            success     : function(msg){
               
            }

        });



    }else{
        if ( compra_con_iva ){
            total_bruto_compra  =   total_neto_compra_op * 1.19;
            total_bruto_compra  =   (Math.round(total_bruto_compra));
            total_iva           =   parseInt(total_bruto_compra) - parseInt(total_neto_compra_op);
        }

        total_bruto_compra = parseInt(total_bruto_compra) + parseInt(total_impuesto_especifico);


        // Asignacion de neto compra
        $('.neto_total_compra').html(new Intl.NumberFormat("de-DE").format(total_neto_compra));
        if ( total_descuento > 0 ){
            $('.tr_descuento_compra').removeClass('ocultar');
            $('.descuento_total_compra').html(new Intl.NumberFormat("de-DE").format(total_descuento));
            $('.subneto_total_compra').html(new Intl.NumberFormat("de-DE").format(total_neto_compra - total_descuento));
        }else{
            $('.tr_descuento_compra').addClass('ocultar');
        }
        if ( total_impuesto_especifico > 0 ){
            $('.tr_monto_total_impuesto').removeClass('ocultar');
            $('.impuesto_total_compra').html(new Intl.NumberFormat("de-DE").format(total_impuesto_especifico));
        }else{
            $('.tr_monto_total_impuesto').addClass('ocultar');
        }
        // Asignacion de iva compra
        $('.iva_total_compra').html(new Intl.NumberFormat("de-DE").format(total_iva));
        // Asignacion de bruto compra
        $('.bruto_total_compra').html(new Intl.NumberFormat("de-DE").format(total_bruto_compra));


        $('#CompraNetoCompra').val(total_neto_compra);
        $('#CompraSubNetoCompra').val(total_neto_compra_op);
        $('#CompraIvaCompra').val(total_iva);
        $('#CompraDescuentoCompra').val(total_descuento);
        $('#CompraBrutoCompra').val(total_bruto_compra);
        $('#CompraDescuentoPorcentual').val(total_descuento_procentual);
        $('#CompraDescuentoLiquido').val(total_descuento_liquido);
        $('#CompraImpEspecificoCompra').val(total_impuesto_especifico);
    }


}

function accionSelectProveedor(div_mostrar, div_ocultar, select_reset)
{
    $('.'+div_ocultar).addClass('ocultar');
    $('.'+div_ocultar).hide();

    $('.'+select_reset).val('');
    $('.'+select_reset).selectpicker("refresh");

    $('.'+div_mostrar).removeClass('ocultar');
    $('.'+div_mostrar).show();

}

function ocultarSelectProveedor(div_ocultar, select_reset)
{
    $('.'+div_ocultar).addClass('ocultar');
    $('.'+div_ocultar).hide();

    $('.'+select_reset).val('');
    $('.'+select_reset).selectpicker("refresh");
}

function resetSelect(select_reset)
{
    $('.'+select_reset).val('');
    $('.'+select_reset).selectpicker("refresh");
}