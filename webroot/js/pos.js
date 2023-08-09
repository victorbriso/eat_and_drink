    var cantidadCodigosUsados = 0;
    var vueltoAcumulado = 0;
    var cantidadPagos = 0;
    var metodoPagoSeleccionado = 0;
    var comboSeleccionado = null;
    var comboSeleccionadoNombre = null;
    var comboSeleccionadoPrecio = 0;
    var comboSeleccionadoCantidad = 0;
    
    var total_productos = 0;
    var modal_activo;
    var input= '';
    
    $(document).ready(function(){
        //Cerrar teclado con tecla esc
        $(".hg-button-escape").on("click", function (){
            cerrarTeclado();
        });

        $(document).keyup(function(e) {
            //Cerrar teclado al presionar tecla escape
            if (e.key === "Escape") {// escape key maps to keycode `27`
               cerrarTeclado();
            }

            //Si la tecla ALT+C esta presionada entonces muestra el efectivo 
            if (e.altKey && String.fromCharCode(e.keyCode) == 'C'){
                $('#boton-efectivo').show();
                //En 1 segundo oculta el efectivo
                setTimeout(function() {
                    $("#boton-efectivo").hide();
                }, 1000);
            }
        });

        //Cerrar teclado al hacer clic en el boton X del teclado
        $('#btn-cerrar-teclado').click(function () {
            cerrarTeclado();
        });
        
        //Escucha el focus del campo para la busqueda
        $('#search').focus(function(){
            //Cuando hay focus en el campo de búsqueda muestra la lista de productos y el teclado
            $('#result-search').show();
            $('#result-search2').hide();
            $('#div-keyboard').show();
        });
        $('#search2').focus(function(){
            //Cuando hay focus en el campo de búsqueda muestra la lista de combos y el teclado
            $('#result-search2').show();
            $('#result-search').hide();
            $('#div-keyboard').show();
        });
        
        //Escucha el botón de cierre (LA X) en el teclado
        $('#btn-cerrar-teclado').click(function(){
            //Limpia el campo de búsqueda y oculta la lista de productos y el teclado
            $('#search').val('');
            $('#search2').val('');
            $('#result-search').hide();
            $('#result-search2').hide();
            $('#div-keyboard').hide();
        });
                
        //Escucha la presión de tecla en el campo de búsqueda para filtrar y mostrar la lista de productos
        $('#search').keyup(function(){	
            var current_query = $('#search').val();
            if (current_query !== "") {
                $(".list-group li").hide();
                $(".list-group li").each(function(){
                    var current_keyword = $(this).text();
                    if (current_keyword.indexOf(current_query) >=0) {
                        $(this).show();    	 	
                    };
                });    	
            } else {
                $(".list-group li").show();
            };
        });
        
        //Escucha la presión de tecla en el campo de búsqueda para filtrar y mostrar la lista de combos
        $('#search2').keyup(function(){	
            var current_query = $('#search2').val();
            if (current_query !== "") {
                $(".list-group li").hide();
                $(".list-group li").each(function(){
                    var current_keyword = $(this).text();
                    if (current_keyword.indexOf(current_query) >=0) {
                        $(this).show();    	 	
                    };
                });    	
            } else {
                $(".list-group li").show();
            };
        });
        
        //Escucha el botón del nombre del producto para que al hacer click se añada a la tabla
        $('.btn-add').bind('click', function(e){
            e.preventDefault();

            // Variables que nos ayudaran a cargar en la tabla
            var cantidad = parseInt($(this).parent().next().children().next().val());
            if(cantidad > 0){
                var idProducto      = $(this).attr("producto_id");
                var valor_neto      = parseFloat($(this).parent().next().next().children().text().replace(/[$\. ,:-]+/g, ''));
                var nombre_producto = $(this).text();
                var cantidad        = $(this).parent().next().children().next().val();
                
                agregarAlPedido(idProducto, cantidad, nombre_producto, valor_neto, false, idProducto, nombre_producto);
                
                metodoPagoSeleccionado = 0;
                
                calculaTotales();
            }
            else{
                alert("La cantidad debe ser mayor a 1.");
            }
        });
        
        //Escucha el botón mas para sumar la cantidad de cada producto
        $(document).delegate('.btn-mas', 'click', function(){
            var esto = $(this).prev();

            //Si el valor actual mas uno, es menor o igual a cero, reseteo el value a uno.
            var cantidad = parseInt(esto.val());
            var nueva_cantidad = cantidad + 1;

            if(nueva_cantidad <= 0){
                esto.val(1);
                nueva_cantidad = 1;
            }
            else if(esto.val() == ''){
                esto.val(1);
                nueva_cantidad = 1;
            }
            else{
                esto.val(parseInt(nueva_cantidad));
            }

            //Tr
            var $row = $(this).closest("tr"); // Find the row

            //Total producto
            var $total_producto = parseFloat($row.find(".precio").data('precio'));
            var total_este_producto = parseFloat($total_producto * nueva_cantidad);

            //Valor
            var $valor = parseFloat($row.find(".total-unidad").text());

            //Setear valor + total_producto
            $row.find(".total-unidad").text(total_este_producto);

            //Setear data-total
            $row.find(".precio").attr('data-total', total_este_producto);
            
            //Reset Descuento
            var contador_productos = $(this).attr("contador_productos");
            $("#campo_descuento_"+contador_productos).val("");
            $("#pedido_"+contador_productos+"_monto_descuento").val(0);
            actualizaDctoProducto($("#campo_descuento_"+contador_productos), 0);
            
            //Recalcula el total
            var sum = 0;
            $('.total-unidad').each(function() {
                sum += parseFloat($(this).text());  
            }); 

            $('#total-productos').text(sum.toFixed(2));
            $('#historial_total').text(sum.toFixed(2));
            
            //Actualizar campos hidden del formulario
            $("#pedido_"+contador_productos+"_cantidad").val(nueva_cantidad);
            $("#pedido_"+contador_productos+"_total").val(total_este_producto);
            
            metodoPagoSeleccionado = 0;
            
            calculaTotales();
        });

        //Escucha el botón menos para restar la cantidad de cada producto
        $(document).delegate('.btn-menos', 'click', function(){
            var esto = $(this).next();

            //Si el valor actual mas uno, es menor o igual a cero, reseteo el value a uno.
            var cantidad = parseInt(esto.val());
            var nueva_cantidad = cantidad - 1;
            
            var $row = $(this).closest("tr"); // Find the row
            
            var $valor = parseFloat($row.find(".total-unidad").text());
            
            //Si el valor actual menos uno, es menor o igual a cero, reseteo el value a uno.
            if(nueva_cantidad <= 0){
                esto.val(1);
                nueva_cantidad = 1;
            }
            else if(esto.val() == ''){
                esto.val(1);
                nueva_cantidad = 1;
            }
            else{
                esto.val(nueva_cantidad);
                //Total producto
                var $total_producto = parseFloat($row.find(".precio").data('precio'));
                var total_este_producto = parseFloat($total_producto * nueva_cantidad);
            
                $row.find(".total-unidad").text($valor-$total_producto);
                $row.find(".precio").attr('data-total', $valor-$total_producto);
            }
            
            //Total producto
            var $total_producto = parseFloat($row.find(".precio").data('precio'));
            var total_este_producto = parseFloat($total_producto * nueva_cantidad);
            
            //Reset Descuento
            var contador_productos = $(this).attr("contador_productos");
            $("#campo_descuento_"+contador_productos).val("");
            $("#pedido_"+contador_productos+"_monto_descuento").val(0);
            actualizaDctoProducto($("#campo_descuento_"+contador_productos), 0);

            //Recalcula el total
            var sum=0;
            $('.total-unidad').each(function() {  
                sum += parseFloat($(this).text());  
            }); 

            $('#total-productos').text(sum.toFixed(2));
            $('#historial_total').text(sum.toFixed(2));
            
            //Actualizar campos hidden del formulario
            
            $("#pedido_"+contador_productos+"_cantidad").val(nueva_cantidad);
            $("#pedido_"+contador_productos+"_total").val(total_este_producto);
            
            metodoPagoSeleccionado = 0;
            
            calculaTotales();
        });
        
        //Escucha el botón de comentario para mostrar el modal correspondiente a cada producto
        $(document).delegate('.comentario', 'click', function(){
            var modal_id = $(this).attr('data-modal');
            
            //Ejecutar ajax para ir a buscar los agregados y la receta del producto.
            //Si es combo, por ahora solo agregare el comentario escrito
            //Si es un producto carta, podre quitar ingredientes y agregar agregados, ademas de un comentario adicional a mano por teclado
            var id = $(this).attr('id_producto');
            var esCombo = $(this).attr('combo');
            var contador_productos = $(this).attr('contador_productos');
            buscarReceta(id, esCombo, modal_id, contador_productos);
        });
        
        //Escucha el botón de ingredientes para remover algun ingrediente del producto y mostrarlo en la lista 
        $(document).delegate('.boton-ingrediente', 'click', function(){
            if($(this).hasClass('active')) {
                var contador_productos = $(this).attr('contador_productos');
                $(this).removeClass('active');
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-default');
                $(this).children().removeClass('glyphicon glyphicon-check');
                $(this).children().addClass('glyphicon glyphicon-unchecked');
                $('#'+modal_activo+' #panel-comentario-'+contador_productos+' .panel-body').append('<span style ="display:block; font-size:0.8rem;" class="'+$.trim($(this).text()).replace(/ /g, '').toLowerCase()+'">SIN: '+$(this).text().trim()+'</span>');
            }
            else {
                $(this).removeClass('btn-default')
                $(this).addClass('active')
                $(this).addClass('btn-primary')
                $(this).children().removeClass('glyphicon glyphicon-unchecked');
                $(this).children().addClass('glyphicon glyphicon-check');
                ingrediente = $.trim('.')+$.trim($(this).text());
                ingrediente = ingrediente.replace(/ /g, '').toLowerCase()
                $('#'+modal_activo+' #panel-comentario-'+contador_productos+' .panel-body').find(ingrediente).remove();
            }
        });

        //Escucha el botón de agregado para agregar algun ingrediente adicional del producto y mostrarlo en la lista 
        $(document).delegate('.boton-agregado', 'click', function(){
            var contador_productos = $(this).attr('contador_productos');
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-default');
                $(this).children().removeClass('glyphicon glyphicon-check');
                $(this).children().addClass('glyphicon glyphicon-unchecked');
                ingrediente = $.trim('.')+$.trim($(this).text());
                ingrediente = ingrediente.replace(/ /g, '').toLowerCase()
                $('#'+modal_activo+' #panel-comentario-'+contador_productos+' .panel-body').find(ingrediente).remove();

            }else {
                $(this).removeClass('btn-default');
                $(this).addClass('active');
                $(this).addClass('btn-primary');
                $(this).children().removeClass('glyphicon glyphicon-unchecked');
                $(this).children().addClass('glyphicon glyphicon-check');
                $('#'+modal_activo+' #panel-comentario-'+contador_productos+' .panel-body').append('<span style ="display:block;font-size:0.8rem;" class="'+$.trim($(this).text()).replace(/ /g, '').toLowerCase()+'">CON: '+$(this).text().trim()+'</span>');
            }
        });
        
        //Escucha el botón de pago de efectivo (BILLETE) donde toma el monto correspondiente y lo añade al historial de pagos de efectivo
        $(document).delegate('.pago_efectivo', 'click', function(){
            pagandoConEfectivo($(this));
        });
                
        //Escucha el botón de finalizar que limpia todo y reinicia el proceso
        $(document).delegate('#boton-finalizar', 'click', function(){
            //Validar que hay pedido
            if($(".total-unidad").length > 0){
                //Validar metodo de pago
                if(metodoPagoSeleccionado != 0){
                    //Validar que no hay monto restante
                    var restante = parseInt($("#historial_restante").text());
                    if(restante == 0){
                        //Submit formulario
                        $("#PosForm").submit();
                    }
                    else{
                        metodoPagoSeleccionado = 0;
                        alert("El monto pendiente por pagar es de $"+restante+".");
                    }
                }
                else{
                    metodoPagoSeleccionado = 0;
                    alert("Selecciona un método de pago e ingresa los datos solicitados.");
                }
            }
            else{
                metodoPagoSeleccionado = 0;
                alert("Ingresa al menos un producto al pedido");
            }
        });
        
        //Escucha el botón para remover el producto de la tabla
        $(document).delegate('.btn-remove','click',function(){
            //remueve el producto de la tabla
            $(this).parent().parent().remove();

            // recalcula el total
            var sum=0;
            $('.total-unidad').each(function() {  
                sum += parseFloat($(this).text());  
            }); 
            $('#total-productos').text(sum.toFixed(2));
            $('#historial_total').text(sum.toFixed(2));

            //Eliminar contenido del formulario
            var i = $(this).attr("contador_productos");
            $("#contenedorPedido"+i).remove();

            $("#historial_pagos").html("");
            $("#pagoPos").html("");
            metodoPagoSeleccionado = 0;
            calculaTotales();
        });
        
        //Escucha el botón para el tipo de descuento si es por monto o por descuento
        $(document).delegate('.tipo_descuento', 'click', function(){
            //Obtenemos el tipo de descuentp que usaremos
            var tipo_descuento = $(this).attr('tipo_descuento');
            var contador_productos = $(this).attr('contador_productos');

            //Actualizar formulario
            $("#pedido_"+contador_productos+"_tipo_descuento").val(tipo_descuento);
            $("#pedido_"+contador_productos+"_monto_descuento").val(0);

            //Habilitar input descuento de producto
            $(this).parent().find('.descuento').attr('disabled', false);

            //Actualizamos el campo de descuento, lo dejamos vacio
            //Restablecemos el total del prodcuto (Precio x Cantidad)
            var total_unidad = $("#campo_descuento_"+contador_productos).attr("data-precio");
            var cantidad_producto = $("#cantidad_producto_"+contador_productos).val();
            var total_producto = parseInt(total_unidad) * parseInt(cantidad_producto);
            $("#campo_descuento_"+contador_productos).val("");
            $("#total-unidad-"+contador_productos).text(parseInt(total_producto));

            //Recalcula el total
            var sum=0;
            $('.total-unidad').each(function() {  
                sum += parseFloat($(this).text());  
            }); 
            $('#total-productos').text(sum.toFixed(2));
            $('#historial_total').text(sum.toFixed(2));

            metodoPagoSeleccionado = 0;
            $("#historial_pagos").html("");
            $("#pagoPos").html("");
            calculaTotales();
        });

        //Escucha la presión de la tecla en el campo de descuento para calcular el total a pagar del producto
        $(document).delegate('.descuento', 'keyup', function(){
            actualizaDctoProducto(this, $(this).val());
            $("#historial_pagos").html("");
            $("#pagoPos").html("");
            calculaTotales();
            metodoPagoSeleccionado = 0;
        });
        
        //Escucha la presión de teclas del codigo descuento hasta que presione enter para buscar en la lista de codigos y ejecutar el descuento
        $(document).delegate('#cod_dcto', 'keyup', function(e){
            var input = $(this);
            var valor = $(this).val();
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if(code==13){
                e.preventDefault();
            };
            if(code==32||code==13||code==188||code==186){
                //Ajax para buscar el codigo de descuento ingresado y aplicarlo
                aplicarCodigoDescuento(input, valor);
            }
        });
                
        //Escucha la presión de teclas del descuento global por monto hasta que presione enter para ejecutar el descuento
        $(document).delegate('#cod_dcto_cash', 'keyup', function(e){
            var input = $(this)
            var valor = $(this).val();
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if(code==13){
                e.preventDefault();
            }
            
            if(code==32||code==13||code==188||code==186){
                if(parseInt(valor) > 0){
                    var total = parseFloat($('#total-productos').text()).toFixed(2);
                    $('#total-productos').text(parseFloat(total-valor).toFixed(2));
                    $('#historial_total').text(parseFloat(total-valor).toFixed(2));

                    var total_dcto_general = parseFloat($('#total_dcto_general').text());
                    total_dcto_general += parseFloat(valor);
                    actualizaDescuentoGeneral(total_dcto_general, 1, valor);

                    var total_dcto_general = parseFloat($('#total_dcto_general').text())
                    var total_dcto_particular = parseFloat($('#total_dcto_particular').text());
                    actualizaDescuentoTotal(total_dcto_general+total_dcto_particular);
                    input.val('');

                    $("#historial_pagos").html("");
                    $("#pagoPos").html("");
                    metodoPagoSeleccionado = 0;
                    calculaTotales();
                }
                else{
                    alert("Este campo solo acepta valores positivos");
                }
            }
        });
        
        //Escucha la presión de teclas del descuento global por porcentaje hasta que presione enter para ejecutar el descuento
        $(document).delegate('#dcto_global', 'keyup', function(e){
            var input = $(this)
            var valor = $(this).val();
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if(code==13)e.preventDefault();
            if(code==32||code==13||code==188||code==186){
                if(parseInt(valor) > 0){
                    var descuento_valor = valor;
                    var total = parseFloat($('#total-productos').text()).toFixed(2);
                    valor = valor/100;
                    var descuento_aplicar = total * valor;
                    $('#total-productos').text(parseFloat(total-descuento_aplicar).toFixed(2));
                    $('#historial_total').text(parseFloat(total-descuento_aplicar).toFixed(2));

                    var total_dcto_general = parseFloat($('#total_dcto_general').text());
                    total_dcto_general += parseFloat(descuento_aplicar);
                    actualizaDescuentoGeneral(total_dcto_general, 2, descuento_valor);

                    var total_dcto_general = parseFloat($('#total_dcto_general').text());
                    var total_dcto_particular = parseFloat($('#total_dcto_particular').text());
                    actualizaDescuentoTotal(total_dcto_general+total_dcto_particular);
                    input.val('');

                    $("#historial_pagos").html("");
                    $("#pagoPos").html("");
                    metodoPagoSeleccionado = 0;
                    calculaTotales();
                }
                else{
                    alert("Este campo solo acepta valores positivos");
                }
            }
        });
        
// ######################################################################################################################## //
        
                    let Keyboard = window.SimpleKeyboard.default;
                    let commonKeyboardOptions = {
                      onChange: input => onChange(input),
                      onKeyPress: button => onKeyPress(button),
                      theme: "simple-keyboard hg-theme-default hg-layout-default",
                      physicalKeyboardHighlight: true,
                      syncInstanceInputs: true,
                      mergeDisplay: true,
                      // debug: true
                    };

                    let keyboard = new Keyboard(".simple-keyboard-main", {
                      ...commonKeyboardOptions,
                      /**
                       * Layout by:
                       * Sterling Butters (https://github.com/SterlingButters)
                       */
                      layout: {
                        default: [
                          "{escape} {f1} {f2} {f3} {f4} {f5} {f6} {f7} {f8} {f9} {f10} {f11} {f12}",
                          "` 1 2 3 4 5 6 7 8 9 0 - = {backspace}",
                          "{tab} q w e r t y u i o p [ ] \\",
                          "{capslock} a s d f g h j k l ; ' {enter}",
                          "{shiftleft} z x c v b n m , . / {shiftright}",
                          "{controlleft} {altleft} {metaleft} {space} {metaright} {altright}"
                        ],
                        shift: [
                          "{escape} {f1} {f2} {f3} {f4} {f5} {f6} {f7} {f8} {f9} {f10} {f11} {f12}",
                          "~ ! @ # $ % ^ & * ( ) _ + {backspace}",
                          "{tab} Q W E R T Y U I O P { } |",
                          '{capslock} A S D F G H J K L : " {enter}',
                          "{shiftleft} Z X C V B N M < > ? {shiftright}",
                          "{controlleft} {altleft} {metaleft} {space} {metaright} {altright}"
                        ]
                      },
                      display: {
                        "{escape}": "esc ⎋",
                        "{tab}": "tab ⇥",
                        "{backspace}": "backspace ⌫",
                        "{enter}": "enter ↵",
                        "{capslock}": "caps lock ⇪",
                        "{shiftleft}": "shift ⇧",
                        "{shiftright}": "shift ⇧",
                        "{controlleft}": "ctrl ⌃",
                        "{controlright}": "ctrl ⌃",
                        "{altleft}": "alt ⌥",
                        "{altright}": "alt ⌥",
                        "{metaleft}": "cmd ⌘",
                        "{metaright}": "cmd ⌘"
                      }
                    });

                    // let keyboardControlPad = new Keyboard(".simple-keyboard-control", {
                    //   ...commonKeyboardOptions,
                    //   layout: {
                    //     default: [
                    //       "{prtscr} {scrolllock} {pause}",
                    //       "{insert} {home} {pageup}",
                    //       "{delete} {end} {pagedown}"
                    //     ]
                    //   }
                    // });

                    // let keyboardArrows = new Keyboard(".simple-keyboard-arrows", {
                    //   ...commonKeyboardOptions,
                    //   layout: {
                    //     default: ["{arrowup}", "{arrowleft} {arrowdown} {arrowright}"]
                    //   }
                    // });

                    let keyboardNumPad = new Keyboard(".simple-keyboard-numpad", {
                      ...commonKeyboardOptions,
                      layout: {
                        default: [
                          "{numlock} {numpaddivide} {numpadmultiply}",
                          "{numpad7} {numpad8} {numpad9}",
                          "{numpad4} {numpad5} {numpad6}",
                          "{numpad1} {numpad2} {numpad3}",
                          "{numpad0} {numpaddecimal}"
                        ]
                      }
                    });

                    let keyboardNumPadEnd = new Keyboard(".simple-keyboard-numpadEnd", {
                      ...commonKeyboardOptions,
                      layout: {
                        default: ["{numpadsubtract}", "{numpadadd}", "{numpadenter}"]
                      }
                    });

                    /**
                     * Physical Keyboard support
                     * Whenever the input is changed with the keyboard, updating SimpleKeyboard's internal input
                     */
                    /*document.addEventListener("keydown", event => {
                      // Disabling keyboard input, as some keys (like F5) make the browser lose focus.
                      // If you're like to re-enable it, comment the next line and uncomment the following ones
                      event.preventDefault();
                    });*/

                    document.querySelector(".input").addEventListener("input", event => {
                      let input = document.querySelector(".input").value;
                      keyboard.setInput(input);
                    });


                    function onChange(input) {
                      document.querySelector(".input").value = input;
                      keyboard.setInput(input);

                      console.log("Input changed", input);
                    }

                    function onKeyPress(button) {
                      console.log("Button pressed", button);
                      var current_query = $('#search').val().toUpperCase();
                            if (current_query !== "") {
                                    $(".list-group li").hide();
                                    $(".list-group li").each(function(){
                                            var current_keyword = $(this).text().toUpperCase();
                                            if (current_keyword.indexOf(current_query) >=0) {
                                                    $(this).show();    	 	
                                            };
                                    });    	
                            } else {
                                    $(".list-group li").show();
                            };
                      /**
                       * If you want to handle the shift and caps lock buttons
                       */
                      if (
                        button === "{shift}" ||
                        button === "{shiftleft}" ||
                        button === "{shiftright}" ||
                        button === "{capslock}"
                      )
                        handleShift();
                    }

                    function handleShift() {
                      let currentLayout = keyboard.options.layoutName;
                      let shiftToggle = currentLayout === "default" ? "shift" : "default";

                      keyboard.setOptions({
                        layoutName: shiftToggle
                      });
                    }
                    document.addEventListener("keyup", event => {});
                    
                // escucha el focus de precio y descuento para poder ingresar el valor o descuento de cada producto por el teclado númerico
                $(document).delegate('.precio, .descuento', 'focus', function(){
                        var input = $(this)
                        var input_val = input.val().toString().trim();
                        //escucha el click del teclado numérico
                        $(".tecla_num").click(function(){
                                var number_valor = $(this).val().toString().trim();
                                input.val(input_val+number_valor)
                                input.focus()
                                if (input.attr('class').split(' ')[0] == 'precio'){
                                        var $row = input.closest("tr");    // Find the row
                                        var $total_producto = parseFloat($row.find(".precio").data('precio'));
                                        var $valor = parseFloat($row.find(".total-unidad").text());
                                        $row.find(".total-unidad").text($total_producto*parseInt(input.val()))
                                }
                                //Recalcula el total
                                var sum=0;
                                $('.total-unidad').each(function() {  
                                        sum += parseFloat($(this).text());  
                                }); 
                                $('#total-productos').text(sum.toFixed(2));
                                $('#historial_total').text(sum.toFixed(2));
                                
                                $("#historial_pagos").html("");
                                $("#pagoPos").html("");
                                calculaTotales();
                        });
                });
                
                
                
                //Escucha el botón pago de efectivo para mostrar el modal correspondiente
                $(document).delegate('#modal_efectivo', 'click', function(){
                        $('#modal_billetes').modal('show');
                });
                //Escucha el botón de todos los tipos de pagos diferentes para mostrar el modal correspondiente
                $(document).delegate('.modal_forma_pago', 'click', function(){
                        $('#modal_forma_pago').modal('show');
                });
                //Escucha el botón de cierre para mostrar el modal correspondiente
                $(document).delegate('#boton_cierre', 'click', function(){
                        $('#modal_cierre').modal('show');
                });
                //Escucha el botón de cuadratura para mostrar el modal correspondiente
                $(document).delegate('#boton_cuadratura', 'click', function(){
                        $('#modal_cuadratura').modal('show');
                });
                
        //Escucha el botón de retiro para mostrar el modal correspondiente
        $(document).delegate('#boton_retiro', 'click', function(){
            //Ir a buscar el saldo de la caja...
            saldoCaja();
            $('#retiro').modal('show');
        });
        
                //Escucha el botón de reimpresión para mostrar el modal correspondiente
                $(document).delegate('#boton_reimpresion', 'click', function(){
                        $('#reimpresion').modal('show');
                });
                
        //Escucha el cierre del modal de comentario para que el teclado se cierre
        $(document).delegate('.modal_comentario', 'hidden.bs.modal', function(){
            $('#div-keyboard').hide();
        });
                
        //Escucha el cierre del modal de comentario para que el teclado se cierre
        $(document).delegate('#retiro', 'shown.bs.modal', function(){
            $('#saldo_efectivo').val(parseFloat($('#boton-efectivo').text()))
            $(document).delegate('#monto_retiro', 'keyup', function(){
                if (parseFloat($('#monto_retiro').val()) > parseFloat($('#saldo_efectivo').val())){
                    alert('No puede superar el monto del saldo en efectivo');
                    $('#monto_retiro').val($('#saldo_efectivo').val());
                }
            });
        });
                
        //Escucha el botón de confirmación del modal de retiro
        $(document).delegate('#confirmacion', 'shown.bs.modal', function(){
            $('#monto_confirmado').text($('#monto_retiro').val());
        });
    });
    
    //Limpia el campo de búsqueda y oculta la lista de productos y el teclado
    function cerrarTeclado(){
        $('#search').val('');
        $('#search2').val('');
        $('#result-search').hide();
        $('#result-search2').hide();
        $('#div-keyboard').hide();
        $("#search").blur();
        $("#search2").blur();
    }
    
    //Funcion que envia HTML para insertar a tabla de pedido
    function getTextoTabla(id_producto, total_productos, nombre_producto, valor_neto, total, cantidad, combo){
        var textoTabla = '\
        <tr>\n\
            <td>\n\
                <button class="btn-remove btn btn-danger" onclick="return false;" contador_productos="'+total_productos+'">\n\
                    <i class="fa fa-close" style="margin-right: 0"></i>\n\
                </button>\n\
            </td>\n\
            <td>\n\
                <a class="comentario" data-modal= "comentario'+total_productos+'" href="#" id_producto="'+id_producto+'" combo="'+combo+'" contador_productos="'+total_productos+'">\n\
                    <i class = "fa fa-comment"></i>\n\
                </a>\n\
            </td>\n\
            <td style ="text-align:center;">\n\
                '+nombre_producto+'\
            </td>\n\
            <td style="text-align:center;">\n\
                <button contador_productos="'+total_productos+'" class="btn-menos btn btn-danger" style="border-radius: 100%; padding:0.1rem 0.5rem 0.1rem; display:inline-block;" onclick="return false;"> \n\
                    <i class="fa fa-minus" style="margin-right: 0;font-size:1rem;"></i>\n\
                </button>\n\
                <input style="display:inline-block; width:70px; height:20px; text-align:center;" data-precio = "'+valor_neto+'" data-total = "'+total+'" type="number" step="any" min="1" value="'+cantidad+'"" id="cantidad_producto_'+total_productos+'" class="precio form-control"/>\n\
                <button contador_productos="'+total_productos+'" class="btn-mas btn btn-success" style="border-radius: 100%; padding:0.1rem 0.5rem 0.1rem; display:inline-block;" onclick="return false;"> \n\
                    <i class="fa fa-plus" style="margin-right: 0"></i>\n\
                </button>\n\
            </td>\n\
            <td style="text-align:center;">\n\
                <input type="radio" class="descuento_monto tipo_descuento" name="dcto'+total_productos+'" tipo_descuento="Monto" contador_productos="'+total_productos+'"> \n\
                <label style="color:#000000;">$</label>\n\
                <input type="radio" class="descuento_porcentaje tipo_descuento" name="dcto'+total_productos+'" tipo_descuento="Porcentaje" contador_productos="'+total_productos+'"> \n\
                <label style="color:#000000;">%</label>\n\
                <input style=" height:20px; width:100px; margin:0 auto;" type="number" step="any" min="0" contador_productos="'+total_productos+'" data-precio="'+valor_neto+'" id="campo_descuento_'+total_productos+'" class="descuento form-control" disabled/>\n\
            </td>\n\
            <td style = "color:#5e2129; text-align:center;">\n\
                $ <span class="total-unidad" id="total-unidad-'+total_productos+'">'+total+'</span>\n\
            </td>\n\
        </tr>';
    
        return textoTabla;
    }
    
    //Funcion que agrega un modal para gestionar los ingredientes y los agregados
    function getTextoContainer(total_productos, nombre_producto){
        var textoContainer = '\
        <div class="modal fade modal_comentario" id="comentario'+total_productos+'" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">\n\
            <div class="modal-dialog" role="document" style ="z-index:9999;">\n\
                <div class="modal-dialog">\n\
                    <div class="modal-content">\n\
                        <div class="modal-header">\n\
                            <button type="button " class="close" data-dismiss="modal" aria-label="Close">\n\
                                <span class="button btn btn-danger" >&times;</span>\n\
                            </button>\n\
                            <h4 class="modal-title" id="modalLabel">\n\
                                <span style = "color:green;">COMENTARIO: '+ nombre_producto +'</span>\n\
                            </h4>\n\
                        </div>\n\
                        <div class="modal-body" id="modal-body-comentario-'+total_productos+'"></div>\n\
                        <div class="modal-footer">\n\
                            <center>\n\
                                <button type="button" class="btn btn-success" onclick="guardarComentarioProducto('+total_productos+')">Aceptar</button>\n\
                                <button type="button" class="btn btn-danger" data-dismiss="modal" style="padding: 4px 15px;">Cancelar</button>\n\
                            </center>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
            </div>\n\
        </div>';
                                                    
        return textoContainer;
    }

    //Funcion que mostrará el detalle del combo, sus categorias y los productos en cada una de ellas
    function detalleCombo(id, nombre, precio){
        //Verificar si la cantidad e smayor a cero
        var cantidad = parseInt($("#btn_cantidad_combo_"+id).val().trim());
        if(cantidad > 0){
            cerrarTeclado();
            comboSeleccionado = id;
            comboSeleccionadoNombre = nombre;
            comboSeleccionadoPrecio = precio;
            comboSeleccionadoCantidad = cantidad;
            
            $("#modalCombo"+id).modal("show");
        }
        else{
            alert("La cantidad debe ser mayor a 1.");
        }
    }
    
    //Funcion que ira mostrando las selecciones de los productos en las distintas categorias del combo
    function detalleArmadoCombo(keyProducto, idCombo, idProducto, tipoCategoria, precioCombo){
        var seleccionado    = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).is(":checked");
        var categoriaId     = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("categoria_id");
        var categoriaNombre = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("nombre_categoria");
        var productoNombre  = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("nombre_producto");
        var agregado        = $("#productoCombo_"+keyProducto+"_"+idCombo+"_"+idProducto).attr("valor_agregado");
        var valor_agregado  = parseFloat(agregado);
        var totalCombo      = parseFloat(precioCombo);
        var idContenedorDetalleProductoCombo = 'infoProducto'+keyProducto+'Categoria'+categoriaId+'Combo'+idCombo;

        if(seleccionado){
            //Existe el contenedor de la categoria actual? Si no existe, lo creo
            if(!$("#contenedorCombo"+idCombo+"Categoria"+categoriaId).length){
                var contenedorComboCategoria = '\
                <div class="col-md-12" style="margin-bottom: 10px;" id="contenedorCombo'+idCombo+'Categoria'+categoriaId+'">\n\
                    <div class="col-md-12">\n\
                        <center><label>'+categoriaNombre+'</label></center>\n\
                    </div>\n\
                    <div class="row" id="contenedorProductosCombo'+idCombo+'Categoria'+categoriaId+'"></div>\n\
                </div>';
                $("#detalleArmadoCombo"+idCombo).append(contenedorComboCategoria);
            }

            var contenidoAgregado = '';
            if(valor_agregado > 0){
                var agregado_money = formatMoney(valor_agregado,0,',','.');
                contenidoAgregado = '$ <span style="float: right" class="valorAdicionalCombo'+idCombo+'">'+agregado_money+'</span>';
            }

            //Si el prodcuto seleccionado no esta agregado al detalle del combo, lo agrego
            if(!$("#"+idContenedorDetalleProductoCombo).length){
                var detalleProdcuto = '\
                <div class="row" id="infoProducto'+keyProducto+'Categoria'+categoriaId+'Combo'+idCombo+'">\n\
                    <div class="col-md-8">\n\
                        <li>'+productoNombre+'</li>\n\
                    </div>\n\
                    <div class="col-md-4">'+contenidoAgregado+'</div>\n\
                </div>';

                //Si es radiobutton quito el otro radiobutton seleccionado previamente (si es que existe)
                if(!tipoCategoria){
                    $("#contenedorProductosCombo"+idCombo+"Categoria"+categoriaId).html("");
                }

                $("#contenedorProductosCombo"+idCombo+"Categoria"+categoriaId).append(detalleProdcuto);
            }
        }
        else{
            if($("#"+idContenedorDetalleProductoCombo).length){
                $("#"+idContenedorDetalleProductoCombo).remove();

                //Quitar categoria si esta vacia
                var productosAgregados = $("#contenedorProductosCombo"+idCombo+"Categoria"+categoriaId).children().length;
                if(!productosAgregados){
                    $("#contenedorCombo"+idCombo+"Categoria"+categoriaId).remove();
                }
            }
        }

        //Recorro los productos agregados y sumo los valores adicionales al total del combo
        var totalComboAdicional = obtenerTotalCombo(idCombo, totalCombo);
        var total_combo_money = formatMoney(totalComboAdicional,0,',','.');
        $("#detalleTotalCombo"+idCombo).html('$ <span style="float: right;">'+total_combo_money+'</span>');
    }
    
    //Funcion que retorna el valor final de un combo, sumando los extras por productos que tengan un costo adicional asociado
    function obtenerTotalCombo(idCombo, totalCombo){
        var total_adicional = 0;
        if($(".valorAdicionalCombo"+idCombo).length){
            var totalComboAdicional = 0;
            $(".valorAdicionalCombo"+idCombo).each(function(){
                var adicional = parseFloat($(this).html());
                total_adicional += adicional;
            });
        }

        var totalComboAdicional = totalCombo + total_adicional;
        return totalComboAdicional;
    }
    
    //Funcion que retorna un valor numerico en formato de moneda chilena
    function formatMoney(n, c, d, t) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
    
    //Funcion que restablece y borra los datos ingresados en el modal del combo seleccionado
    function resetModalCombos(id){
        $(".inputCombo").removeAttr("checked");
        $("#detalleArmadoCombo"+id).html("");
        $("#detalleTotalCombo"+id).html("");
        
        comboSeleccionado = null;
        comboSeleccionadoNombre = null;
        comboSeleccionadoPrecio = 0;
        comboSeleccionadoCantidad = 0;
    }
    
    //Funcion que valida que exista un combo seleccionado para agregarlo al pedido, si esta seleccionado se agregará
    function agregarComboPedido(){
        var indice = comboSeleccionado;
        if(indice != null){
            configurarCombo(indice);
        }
        else{
            alert("Debes seleccionar un combo.");
        }
    }
    
    //Funcion que recorre los diferentes productos seleccionados en las categorias de un combo seleccionado y arma el html para agregarlo al pedido
    function configurarCombo(idCombo){
        if(comboSeleccionado != null){
            if(validaSeleccionProductosCategorias(comboSeleccionado)){
                var productosIds = '';
                var productosNombres = '';
                var nombresProductos = '';
                var reccoriendo = 0;
                var totalInputs = $(".inputCombo"+idCombo+":checked").length;
                $(".inputCombo"+idCombo+":checked").each(function(k, v){
                    var seleccionado = $(v).is(':checked');
                    if(seleccionado){
                        productosIds += $(v).val();
                        nombresProductos += $(v).attr("nombre_producto");
                        productosNombres += $(v).attr("nombre_producto");
                        if( (reccoriendo + 1) != totalInputs){
                            productosIds += '|';
                            nombresProductos += '|';
                            productosNombres += ', ';
                        }
                        reccoriendo++;
                    }
                });

                if(productosIds != ''){
                    agregarAlPedido(idCombo, comboSeleccionadoCantidad, comboSeleccionadoNombre, comboSeleccionadoPrecio, true, productosIds, productosNombres);
                    $("#modalCombo"+comboSeleccionado).modal("hide");
                    resetModalCombos(comboSeleccionado);
                    
                    calculaTotales();
                }
                else{
                    alert("Por favor selecciona los productos que tendra el combo");
                }
            }
        }
        else{
            resetModalCombos();
            alert("Por favor selecciona un combo.");
        }
    }
    
    //Funcion que valida que esten seleccionado al menos un producto de cada categoria en los combos seleccionados
    function validaSeleccionProductosCategorias(comboSeleccionado){
	var resultado = true;
	//Recorro las categorias del combo seleccionado
	var categoriasRecorridas = new Array();
	$(".categoriaCombo"+comboSeleccionado).each(function(){
            var categoriaId = $(this).attr("categoria_id");
            var categoriaNombre = $(this).attr("nombre_categoria");
            if($.inArray(categoriaId, categoriasRecorridas) < 0){
                //Agrego el ID de la categoria para no recorrerlo denuevo
                categoriasRecorridas.push(categoriaId);

                //Verifico que al menos uno de los productos de esa categoria este seleccionado
                var productosCategoriaSeleccionados = $(".categoriaCombo"+comboSeleccionado+'Id'+categoriaId+':checked').length;

                if(productosCategoriaSeleccionados == 0){
                    alert('Por favor selecciona al menos un producto de la categoria "'+categoriaNombre+'".');
                    resultado = false;
                    return false;
                }
            }
	});

	return resultado;
    }
    
    //Funcion final que agrega el combo seleccionado al pedido
    function agregarAlPedido(id, cantidad, nombre, valor_unitario, combo, productosIds, productosNombres){
        /*
         * id             = ProductoCarta ID o Combo ID
         * cantidad       = cantidad ingresada en el input
         * nombre         = Nombre del ProdcutoCarta o Nombre del Combo
         * valor_unitario = Valor por unidad del ProductoCarta o Valor por unidad del Combo + adicionales por categoria
         * combo          = True o False dependiendo si es Combo o no
         * productosIds   = ID de los productos cartas seleccionados del combo
         * productosNombres = Nombres de los productos cartas seleccionados en el combo
         */
        
        var detalle_combo = '';
        if(combo){
            valor_unitario = parseFloat(obtenerTotalCombo(id, valor_unitario));
            detalle_combo = '<input type="hidden" name="data[Pedido]['+total_productos+'][detalle_combo]" value="'+productosIds+'" id="pedido_'+total_productos+'_detalle_combo">';
        }
        
        var total = parseFloat(valor_unitario * cantidad);
        
        var textoTabla = getTextoTabla(id, total_productos, nombre, valor_unitario, total, cantidad, combo);
        $('#tablaProveedores tbody').append(textoTabla);

        //Inicializa la variable sum
        var sum = 0;

        //recorre todos los totales y los suma
        $('.total-unidad').each(function(){
            var total = $(this).text();
            var totalUnidad = parseFloat(total);
            sum += totalUnidad;
        });

        //Imprime el resultado en el total
        $('#total-productos').text(sum.toFixed(2));
        $('#historial_total').text(sum.toFixed(2));

        //Se agrega a la página el modal de comentario para cada uno de los productos agregados en la tabla
        var textoPageContainer = getTextoContainer(total_productos, nombre);
        $('.page-container').append(textoPageContainer);

        //Agregar contenido al formulario
        var formulario = '\
            <div id="contenedorPedido'+total_productos+'">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][detalle_combo_nombres]" value="'+productosNombres+'" id="pedido_'+total_productos+'_detalle_combo_nombres">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][cantidad]" value="'+cantidad+'" id="pedido_'+total_productos+'_cantidad">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][comentario]" value="" id="pedido_'+total_productos+'_comentario">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][registro_local_id]" value="<?php echo $registro_local_id; ?>" id="pedido_'+total_productos+'_registro_local_id">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][tipo]" value="1" id="pedido_'+total_productos+'_tipo">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][nombre]" value="Venta Rapida" id="pedido_'+total_productos+'_nombre">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][id_cliente]" value="1" id="pedido_'+total_productos+'_id_cliente">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][usuario_id]" value="<?php echo $usuario_id; ?>" id="pedido_'+total_productos+'_usuario_id">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][producto_carta_id]" value="'+id+'" id="pedido_'+total_productos+'_producto_carta_id">\n\
                '+detalle_combo+'\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][producto_combo_id]" value="'+id+'" id="pedido_'+total_productos+'_producto_combo_id">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][producto]" value="'+nombre+'" id="pedido_'+total_productos+'_producto">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][precio]" value="'+valor_unitario+'" id="pedido_'+total_productos+'_precio">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][divisible]" value="0" id="pedido_'+total_productos+'_divisible">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][total]" value="'+total+'" id="pedido_'+total_productos+'_total">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][tipo_descuento]" value="" id="pedido_'+total_productos+'_tipo_descuento">\n\
                <input type="hidden" name="data[Pedido]['+total_productos+'][monto_descuento]" value="0" id="pedido_'+total_productos+'_monto_descuento">\n\
            <div>\n\
        ';
                
        $("#formularioPos").append(formulario);
        
        total_productos++;
    }
    
    //Funcion que traera los ingredientes y los agregados para personalizar el pedido de un producto o combo
    function buscarReceta(id, esCombo, modal_id, contador_productos){
        //Si es un producto carta, buscamos los ingredientes
        //Por ahora los combos no los tomaremos en cuenta
        $.ajax({
            type: 'POST',
            url : webroot + 'Cajas/obtenerReceta',
            data: {
                id: id,
                esCombo: esCombo,
                contador_productos: contador_productos
            },
            beforeSend:function(){
                cerrarTeclado();
                $("#modalCargando").modal("show");
            },
            success: function(resultado){
                //Agregar el contenido al modal
                $("#modal-body-comentario-"+contador_productos).html(resultado);

                //Setear valor de modal activo
                modal_activo = $.trim($('#'+modal_id).attr('id'));

                //Ocultamos el modal cargando
                $("#modalCargando").modal("hide");

                //Mostrar modal
                $('#'+modal_id).modal('show');

                //Muestra el teclado
                $('#div-keyboard').show();
            },
            error: function(){
                $("#modalCargando").modal("hide");
                alert("Ocurrio un error en la operación.");
            }
        });
    }
    
    //Funcion que formatea el comentario de un producto, concatena los ingredientes o agregados y el comentario opcional del vendedor
    function guardarComentarioProducto(id){
        //Obtenemos la personalizacion de los ingredientes y agregados
        var comentario_ingredientes = '';
        $("#panel-comentario-"+id+" div.panel-body span").each(function(){
            var comentario = $(this).html().trim();
            comentario = comentario.replace("CON: ", "Con ");
            comentario = comentario.replace("SIN: ", "Sin ");
            comentario_ingredientes += comentario + ', ';
        });
        
        //Quitar la ultima coma
        if(comentario_ingredientes != ''){
            comentario_ingredientes = comentario_ingredientes.trim().slice(0, -1);
            comentario_ingredientes += ". ";
        }
        
        //Obtenemos el comentario ingresado por el vendedor
        var comentario_vendedor = $("#comentario_vendedor_"+id).val().trim();
        
        //Tenemos el nuevo comentario
        var comentario_final = comentario_ingredientes + comentario_vendedor;
        
        //Actualizamos el formulario
        $("#pedido_"+id+"_comentario").val(comentario_final);
        
        //Cerramos el modal
        $("#comentario"+id).modal("hide");
        
        metodoPagoSeleccionado = 0;
    }
    
    //Funcion que actualiza el valor del descuento y el precio final de un producto agregado al pedido
    function actualizaDctoProducto(input, nuevo_valor){
        var descuento = parseFloat(nuevo_valor);
        var $row = $(input).closest("tr");    // Find the row
        var valor = parseFloat($row.find(".precio").data('precio'));
        var cantidad = parseInt($row.find(".precio").val());
        valor = valor * cantidad;

        if(isNaN(descuento)){
            $row.find(".total-unidad").text($row.find(".precio").attr('data-total'));
        }
        else{
            if ($(input).parent().find('.descuento_monto').is(':checked')) {
                if (parseInt(nuevo_valor) > parseInt($row.find(".precio").attr('data-total'))) {
                    alert('No puede superar al monto total');
                    $(input).val($row.find(".precio").attr('data-total'));
                    descuento = parseFloat(nuevo_valor);
                }
                if (parseInt(nuevo_valor) < 0 ) {
                    alert('No puede ser un monto negativo');
                    $(input).val(0);
                    descuento = parseFloat(nuevo_valor);
                }

                $row.find(".total-unidad").text(valor-descuento);
            }
            else {
                if (nuevo_valor > 100 ){
                    alert('No puede ser un monto mayor al 100%');
                    $(input).val(100)
                    descuento = parseFloat(nuevo_valor);
                }
                if (nuevo_valor < 0) {
                    alert('No puede ser un monto negativo');
                    $(input).val(0)
                    descuento = parseFloat(nuevo_valor);
                }

                descuento = descuento/100;
                var descuento_aplicar = valor * descuento;
                $row.find(".total-unidad").text(valor-descuento_aplicar);
            }
        }

        //Recalcula el total
        var sum=0;
        $('.total-unidad').each(function() {  
            sum += parseFloat($(this).text());  
        }); 

        $('#total-productos').text(sum.toFixed(2));
        $('#historial_total').text(sum.toFixed(2));

        //Calcula el total de descuento realizado a los productos
        var total_descuento_producto_mostrar = 0;
        $('.descuento').each(function( i, val){
            if ($(val).parent().find('.descuento_monto').is(':checked')) {
                if ($(val).val() == ''){
                    valor = 0;
                }
                else {
                    valor = parseFloat($(val).val());
                }

                total_descuento_producto_mostrar += valor;
            }
            else {
                if ($(val).val() == ''){
                    valor = 0;
                }
                else {
                    var cantidad = parseInt($row.find(".precio").val())
                    var valor = parseFloat($row.find(".precio").data('precio'));
                    var valor = cantidad * valor;
                    var descuento = parseFloat($(val).val())/100;
                    valor = valor * descuento;
                    total_descuento_producto_mostrar += valor;
                }
            }
        });
        
        actualizaDescuentoParticular(total_descuento_producto_mostrar);
        var total_dcto_general = parseFloat($('#total_dcto_general').text());
        var total_dcto_particular = parseFloat(total_descuento_producto_mostrar);
        actualizaDescuentoTotal(total_dcto_general+total_dcto_particular);

        //Obtenemos el tipo de descuentp que usaremos
        var contador_productos = $(input).attr('contador_productos');

        //Actualizar formulario
        $("#pedido_"+contador_productos+"_monto_descuento").val(parseInt(nuevo_valor));
    }
    
    //Funcion que actualiza el valor mostrado en el descuento particular y el valor del descuento particular del formulario
    function actualizaDescuentoParticular(dcto){
        $('#total_dcto_particular').text(dcto);
        $("#descuento_particular").val(parseInt(dcto));
    }
    
    //Funcion que actualiza el valor mostrado en el descuento general y el valor del descuento general del formulario
    function actualizaDescuentoGeneral(dcto, tipo, valor_input){
        $('#total_dcto_general').text(dcto);
        $("#descuento_general").val(parseInt(dcto));
        
        //actualizar campos de dcto
        if(tipo == 1){
            var total_montos = parseInt($("#descuento_total_montos").val().trim());
            total_montos += parseInt(valor_input);
            
            $("#descuento_total_montos").val(total_montos);
        }
        else if(tipo == 2){
            var total_porcentajes = parseInt($("#descuento_total_porcentajes").val().trim());
            console.log("DESCUENTO ACTUAL : "+ total_porcentajes);
            total_porcentajes += parseInt(valor_input);
            console.log("CDTO APLICADO    : "+ parseInt(valor_input));
            console.log("NUEVO CDTO ACTUAL: "+ total_porcentajes);
            
            $("#descuento_total_porcentajes").val(total_porcentajes);
        }
    }
    
    //Funcion que actualiza el valor mostrado en el descuento total y el valor del descuento total del formulario
    function actualizaDescuentoTotal(dcto){
        $('#total_dcto_mostrar').text(dcto);
        $("#descuento_total").val(parseInt(dcto));
    }
    
    //Funcion que recive el codigo de descuento ingresao e intenta aplicarlo al pedido actual
    function aplicarCodigoDescuento(input, valor){
        //Solo aplicar si hay pedidos
        if($(".total-unidad").length > 0){
            //Forma 1 = Monto
            //Forma 2 = Porcentaje
            $.ajax({
                type: 'POST',
                url : webroot + 'Cajas/obtenerCodigosDescuentos',
                data: {
                    codigo: valor
                },
                beforeSend:function(){
                    cerrarTeclado();
                    $("#modalCargando").modal("show");
                },
                complete: function(){
                    $("#modalCargando").modal("hide");
                },
                success: function(respuesta){
                    respuesta = jQuery.parseJSON(respuesta);

                    var bandera = parseInt(respuesta[0]);
                    if (bandera == 1){
                        var codigo_usado    = parseInt(respuesta['id']);
                        var monto_descuento = parseFloat(respuesta['monto']);
                        var tipo_descuento  = parseInt(respuesta['tipo']);
                        var total           = parseInt($('#total-productos').text());
                        
                        var dctoAplicadoPlata = monto_descuento;
                        var dctoAplicado = monto_descuento;
                        
                        //Calcular descuento
                        var nuevo_total_productos = 0;
                        if(tipo_descuento == 1){
                            dctoAplicadoPlata = parseFloat(monto_descuento).toFixed(2);
                            dctoAplicado = parseFloat(monto_descuento).toFixed(2);
                            
                            nuevo_total_productos = parseFloat(total-monto_descuento).toFixed(2);
                            var total_dcto_general = parseFloat($('#total_dcto_general').text());
                            total_dcto_general += parseFloat(monto_descuento);
                        }
                        else{
                            dctoAplicado = parseFloat(monto_descuento).toFixed(2);
                            
                            monto_descuento = monto_descuento/100;
                            var descuento_aplicar = total * monto_descuento;
                            
                            dctoAplicadoPlata = parseFloat(descuento_aplicar).toFixed(2);
                            
                            nuevo_total_productos = parseFloat(total-descuento_aplicar).toFixed(2);
                            
                            var total_dcto_general = parseFloat($('#total_dcto_general').text());
                            total_dcto_general += parseFloat(descuento_aplicar);
                        }
                        
                        //Aplicar descuento general
                        if(nuevo_total_productos < 0){
                            //Cuanndo el dcto es mayor al total del pedido, se setea 0 pero no mostrar un numero negativo
                            nuevo_total_productos = 0;
                        }
                        $('#total-productos').text(nuevo_total_productos);
                        $('#historial_total').text(nuevo_total_productos);
                        actualizaDescuentoGeneral(total_dcto_general, 3, valor);
                        
                        //Actualizar descuento total
                        var total_dcto_general = parseFloat($('#total_dcto_general').text());
                        var total_dcto_particular = parseFloat($('#total_dcto_particular').text());
                        actualizaDescuentoTotal(total_dcto_general+total_dcto_particular);

                        //Actualizamos los codigos usados al formulario
                        var appendCodigos = '<input type="hidden" name="data[Codigos]['+cantidadCodigosUsados+'][codigo]" value="'+valor+'" id="codigos_codigo_'+cantidadCodigosUsados+'_'+codigo_usado+'">';
                        appendCodigos += '<input type="hidden" name="data[Codigos]['+cantidadCodigosUsados+'][id]" value="'+codigo_usado+'" id="codigos_id_'+cantidadCodigosUsados+'_'+codigo_usado+'">';
                        appendCodigos += '<input type="hidden" name="data[Codigos]['+cantidadCodigosUsados+'][monto_dtco]" value="'+dctoAplicado+'" id="codigos_monto_'+cantidadCodigosUsados+'_'+codigo_usado+'">';
                        appendCodigos += '<input type="hidden" name="data[Codigos]['+cantidadCodigosUsados+'][dcto_aplicado]" value="'+dctoAplicadoPlata+'" id="codigos_plata_'+cantidadCodigosUsados+'_'+codigo_usado+'">';
                        appendCodigos += '<input type="hidden" name="data[Codigos]['+cantidadCodigosUsados+'][tipo]" value="'+tipo_descuento+'" id="codigos_tipo_'+cantidadCodigosUsados+'_'+codigo_usado+'">';
                        $("#codigosPos").append(appendCodigos);
                        cantidadCodigosUsados++;

                        //Codigo usado correctamente
                        alert(respuesta[1]);
                        $("#historial_pagos").html("");
                        $("#pagoPos").html("");
                        metodoPagoSeleccionado = 0;
                        calculaTotales();
                    }
                    else {
                        alert(respuesta[1]);
                        return false;
                    }

                    input.val('');
                },
                error: function(){
                    $("#modalCargando").modal("hide");
                    input.val('');
                    alert("Ocurrio un error en la operación.");
                }
            });
        }
        else{
            input.val('');
            alert("No se puede aplicar el descuento si no hay productos en el pedido");
        }
    }
    
    //Funcion que abrira el modal para ingresar el pago segun el metodo seleccionado
    function mostrarMetodoPago(id){
        //Solo aplicar si hay pedidos
        if($(".total-unidad").length > 0){
            //Si el monto a pagar restante es 0 entonces no podemos seguir pagando...
            var total_restante = parseInt($("#historial_restante").text());
            if(total_restante > 0){
                //Seteamos el valor del metodo de pago que seleccionamos
                metodoPagoSeleccionado = id;

                //Obtengo el valor total del pedido y lo seteamos al modal
                //var totalPedido = parseInt($("#total-productos").text().trim());

                //Mostraremos por defecto el valor restante a pagar
                //$(".campo_monto_js").val(totalPedido);
                $(".campo_monto_js").val(total_restante);

                //Aplica solo si es pago en efectivo
                if(id == 1){
                    //Calculamos el monto ingresao, el monto restante y el posible vuelto
                    calculaMontosPagoEfectivo();
                }

                //Abrimos el modal
                $("#modal_metodo_pago_"+id).modal("show");
            }
            else{
                alert("No hay mas monto por pagar.");
            }
        }
        else{
            alert("No existen productos en el pedido.");
        }
    }
    
    //Funcion que agregar el detalle de los billetes o monedas que voy seleccionando y ademas va calculando el vuelto y monto restante por pagar
    function pagandoConEfectivo(input){
        var appendHistorial = '\
        <span style="display:block;" data-pago="'+input.attr('data-pago')+'" class="detalleHistorialPagoEfectivo detallePago">\n\
            EFECTIVO: $'+input.attr('data-pago')+'.-\n\
        </span>';
            
        $("#historialPagoEfectivo").append(appendHistorial);
        
        calculaMontosPagoEfectivo();
    }
    
    //Funcion que calcula el monto total a pagar, el monto restante y el vuelto a dar cuando el pago es en efectivo
    function calculaMontosPagoEfectivo(){
        var totalPedido = parseInt($("#total-productos").text().trim());
        var totalPagadoEfectivo = 0;
        
        if($(".detalleHistorialPagoEfectivo").length == 0){
            $("#historialPagoEfectivo").hide();
        }
        else{
            $("#historialPagoEfectivo").show();
        }
        
        //Obtener el efectivo que se esta pagando
        $(".detalleHistorialPagoEfectivo").each(function(){
            totalPagadoEfectivo += parseInt($(this).attr("data-pago"));
        });

        var total_pagar = totalPedido;
        var total_restante = totalPedido - totalPagadoEfectivo;
        var total_vuelto = 0;
        if(total_restante < 0){
            total_vuelto = parseInt(total_restante * -1);
            total_restante = 0;
        }

        $("#totalPagarPagoEfectivo").text(total_pagar);
        $("#totalRestantePagoEfectivo").text(total_restante);
        $("#totalVueltoPagoEfectivo").text(total_vuelto);
    }
    
    function guardarPago(id){
        //ID es el id del modal que debemos tomar en cuenta para obtener los datos
        
        //Validamos que el pago este correcto
        if(id == 1){
            var total_pagar = parseInt($("#totalPagarPagoEfectivo").text().trim());
            var total_restante = parseInt($("#totalRestantePagoEfectivo").text().trim());
            var total_vuelto = parseInt($("#totalVueltoPagoEfectivo").text().trim());
            
            //Validamos que exista un monto a pagar
            if(total_pagar <= 0 || isNaN(total_pagar)){
                alert('El monto a pagar es: "' +total_pagar+'". Imposible procesar.');
            }
            //Validamos que el monto restante esea cero
//            else if(total_restante != 0){
//                alert('El monto por pagar restante es: "' +total_restante+'". Imposible procesar.');
//            }
            //Validamos que el vuelto no sea negativo
            else if(isNaN(total_vuelto) || total_vuelto < 0){
                alert('El monto del vuelto es: "' +total_vuelto+'". Imposible procesar.');
            }
            //Todo correcto
            else{
                //Obtenemos el total ingresado en efectivo
                var total_efectivo = 0;
                $(".detalleHistorialPagoEfectivo").each(function(){
                    var efectivo = parseInt($(this).attr("data-pago"));
                    
                    total_efectivo += efectivo;
                });
                
                //Obtenemos el HTML del historial de pagos en efectivos
                var pagosEfeectivo = $("#historialPagoEfectivo").html() + '<hr style="margin-top: 5px; margin-bottom: 5px;">';
                
                //Lo agregamos al resumen para mostrarlo antes de finalizar
                $("#historial_pagos").append(pagosEfeectivo);
                
                //Seteamos el vuelto
                vueltoAcumulado = vueltoAcumulado + total_vuelto;
                $("#historial_vuelto").text(vueltoAcumulado);
                
                //Agregamos campos hidden al formulario
                var contenido_hidden = '';
                contenido_hidden += '<input type="hidden" value="'+id+'" name="data[Pago]['+cantidadPagos+'][tipo_pago_id]">';
                contenido_hidden += '<input type="hidden" value="'+total_pagar+'" name="data[Pago]['+cantidadPagos+'][monto]">';
                contenido_hidden += '<input type="hidden" value="'+total_vuelto+'" name="data[Pago]['+cantidadPagos+'][vuelto]">';
                contenido_hidden += '<input type="hidden" value="'+total_efectivo+'" name="data[Pago]['+cantidadPagos+'][efectivo]">';
                
                //Agregar campos id_campo, valor_campo, nombre_campo
                contenido_hidden += '<input type="hidden" value="1|2" name="data[Pago]['+cantidadPagos+'][id_campo]">';
                contenido_hidden += '<input type="hidden" value="Monto|Efectivo" name="data[Pago]['+cantidadPagos+'][nombre_campo]">';
                contenido_hidden += '<input type="hidden" value="'+total_pagar+'|'+total_efectivo+'" name="data[Pago]['+cantidadPagos+'][valor_campo]">';
                
                $("#pagoPos").append(contenido_hidden);
                
                $("#modal_metodo_pago_"+id).modal("hide");
                
                cantidadPagos++;
                
                $('#historialPagoEfectivo').html('');
                calculaMontosPagoEfectivo();
                
                calculaTotales();
            }
        }
        else{
            //Validar campos
            if(parseInt($("#pago_monto_"+id).val().trim()) <= 0 || isNaN(parseInt($("#pago_monto_"+id).val().trim()))){
                alert('El monto a pagar es: "' +$("#pago_monto_"+id).val().trim()+'". Imposible procesar.');
            }
            //Validamos que el monto a pagar no sea superior al monto restante
            else if(parseInt($("#pago_monto_"+id).val().trim()) > parseInt($("#historial_restante").text())){
                alert('El monto ingresado no puede superar el monto restante por pagar.');
                $("#pago_monto_"+id).val(parseInt($("#historial_restante").text()));
            }
            else if($("#pago_codigo_autorizacion_"+id).val().trim() == ""){
                alert('Ingresa el código de autorización.');
            }
            else if($("#pago_codigo_operacion_"+id).val().trim() == ""){
                alert('Ingresa el código de operación.');
            }
            else if(id == 5 && parseInt($("#pago_vuelto_"+id).val().trim()) < 0){
                alert('El vuelto ingresado es: "' +$("#pago_vuelto_"+id).val().trim()+'". Imposible procesar.');
            }
            else{
                //Obtengo los datos ingresados en el modal
                //Solo el metodo de pago debito con vuelto tendra un campo adicional, el vuelto
                var monto = parseInt($("#pago_monto_"+id).val().trim());
                var codigo_autorizacion = parseInt($("#pago_codigo_autorizacion_"+id).val().trim());
                var codigo_operacion = parseInt($("#pago_codigo_operacion_"+id).val().trim());
                var vuelto = 0;

                //Agregamos campos hidden al formulario
                var contenido_hidden = '';
                contenido_hidden += '<input type="hidden" value="'+id+'" name="data[Pago]['+cantidadPagos+'][tipo_pago_id]">';
                contenido_hidden += '<input type="hidden" value="'+codigo_autorizacion+'" name="data[Pago]['+cantidadPagos+'][codigo_autorizacion]">';
                contenido_hidden += '<input type="hidden" value="'+codigo_operacion+'" name="data[Pago]['+cantidadPagos+'][codigo_operacion]">';
                contenido_hidden += '<input type="hidden" value="'+monto+'" name="data[Pago]['+cantidadPagos+'][monto]">';
                if(id == 5){
                    vuelto = parseInt($("#pago_vuelto_"+id).val().trim());
                    contenido_hidden += '<input type="hidden" value="'+vuelto+'" name="data[Pago]['+cantidadPagos+'][vuelto]">';
                }
                vueltoAcumulado = vueltoAcumulado + vuelto;
                
                //Agregar campos id_campo, valor_campo, nombre_campo
                var id_campo = $("#id_campo_"+id).val();
                var nombre_campo = $("#nombre_campo_"+id).val();
                var valor_campo = '';
                //Recorrer campos
                $(".campo_monto_"+id).each(function(){
                    valor_campo += $(this).val().trim() + "|";
                });
                valor_campo = valor_campo.slice(0, -1);
                
                //Agregar
                contenido_hidden += '<input type="hidden" value="'+id_campo+'" name="data[Pago]['+cantidadPagos+'][id_campo]">';
                contenido_hidden += '<input type="hidden" value="'+nombre_campo+'" name="data[Pago]['+cantidadPagos+'][nombre_campo]">';
                contenido_hidden += '<input type="hidden" value="'+valor_campo+'" name="data[Pago]['+cantidadPagos+'][valor_campo]">';
                
                $("#pagoPos").append(contenido_hidden);

                //Lo agregamos al resumen para mostrarlo antes de finalizar
                var appendHistorial = '\
                <span style="display:block;" data-pago="'+monto+'" class="detalle_historial_pagos detallePago">\n\
                    TARJETA: $'+monto+'.-\n\
                </span>';
                    appendHistorial += '\
                <span style="display:block;" data-pago="'+codigo_autorizacion+'" class="detalle_historial_pagos">\n\
                    CÓDIGO AUTORIZACIÓN: '+codigo_autorizacion+'.-\n\
                </span>';
                    appendHistorial += '\
                <span style="display:block;" data-pago="'+codigo_operacion+'" class="detalle_historial_pagos">\n\
                    CÓDIGO OPERACIÓN: '+codigo_operacion+'.-\n\
                </span>';
                if(id == 5){
                     appendHistorial += '\
                <span style="display:block;" data-pago="'+vuelto+'" class="detalle_historial_pagos detalleVuelto">\n\
                    VUELTO SOLICITADO: $'+vuelto+'.-\n\
                </span>';
                }
                appendHistorial += '<hr style="margin-top: 5px; margin-bottom: 5px;">';
                $("#historial_pagos").append(appendHistorial);

                //Seteamos el vuelto
                $("#historial_vuelto").text(vueltoAcumulado);
                
                $("#modal_metodo_pago_"+id).modal("hide");
                
                cantidadPagos++;
                
                calculaTotales();
            }
        }
    }
    
    //Funcion que resetea el modal de los pagos
    function cancelarPago(id){
        //ID es el id del modal que debemos tomar en cuenta para obtener los datos
        if(id == 1){
            $("#historialPagoEfectivo").html("");
            calculaMontosPagoEfectivo();
        }
        else{
            $(".pago_campo").val("");
        }
        
        metodoPagoSeleccionado = 0;
    }
    
    
    function calculaTotales(){
        var total_a_pagar = parseInt($("#historial_total").text());
        var totalPagado   = 0;
        var totalVuelto   = 0;
        var totalRestante = 0;
        
        //Montos pagadas
        $("div#historial_pagos span.detallePago").each(function(){
            var pagado = parseInt($(this).attr("data-pago"));
            totalPagado += pagado;
        });
        
        if(totalPagado > total_a_pagar){
            totalVuelto   = parseInt(totalPagado - total_a_pagar);
            totalRestante = 0;
            totalPagado   = total_a_pagar;
        }
        else if(totalPagado <= total_a_pagar){
            totalVuelto = 0;
            totalRestante = parseInt(total_a_pagar - totalPagado);
        }
        
        //Vueltos
        $("div#historial_pagos span.detalleVuelto").each(function(){
            var vuelto = parseInt($(this).attr("data-pago"));
            totalVuelto += vuelto;
        });
        
        $("#historial_restante").text(totalRestante);
        $("#historial_vuelto").text(totalVuelto);
    }
    
    //Funcion que se ejecuta cuando se realiza un retiro de efectivo de la caja actual
    function retirarEfectivoCaja(){
        var monto_confirmado = parseInt($("#monto_retiro").val().trim());
        
        //Ejecutar ajax
        $.ajax({
            type: 'POST',
            url : webroot + 'Cajas/retirarEfectivoCaja',
            data: {
                monto: monto_confirmado
            },
            beforeSend:function(){
                cerrarTeclado();
                $("#modalCargando").modal("show");
            },
            complete: function(){
                $("#modalCargando").modal("hide");
            },
            success: function(respuesta){
                if(respuesta){
                    alert("Efectivo retirado correcetamente.");
                }
                else{
                    alert('Ocurrió un error al retirar el efectivo de la caja ('+monto_confirmado+').');
                }
            },
            error: function(){
                $("#modalCargando").modal("hide");
                alert("Ocurrio un error en la operación.");
            }
        });
    }
    
    //Funcion que va  abuscar el saldo actual de la caja
    function saldoCaja(){
        $.ajax({
            type: 'POST',
            url : webroot + 'Cajas/saberSaldoCaja',
            data: {},
            beforeSend:function(){
                cerrarTeclado();
                $("#modalCargando").modal("show");
            },
            complete: function(){
                $("#modalCargando").modal("hide");
            },
            success: function(respuesta){
                $("#boton-efectivo").text(parseInt(respuesta));
                $("#saldo_efectivo").val(parseInt(respuesta));
            },
            error: function(){
                $("#modalCargando").modal("hide");
                alert("Ocurrio un error en la operación.");
            }
        });
    }
    
    //Funcion que re imprime el folio ingresado
    function reimpresionFolio(){
        var folio = $("#folio_reimpresion").val().trim();
        
        $.ajax({
            type: 'POST',
            url : webroot + 'Cajas/reimpresionFolio',
            data: {
                folio: folio
            },
            beforeSend:function(){
                cerrarTeclado();
                $("#modalCargando").modal("show");
            },
            complete: function(){
                $("#modalCargando").modal("hide");
            },
            success: function(respuesta){
                if(respuesta){
                    alert("Folio re imprimido correcetamente.");
                }
                else{
                    alert('Ocurrió un error al re imprimir el folio: "'+folio+'".');
                }
            },
            error: function(){
                $("#modalCargando").modal("hide");
                alert("Ocurrio un error en la operación.");
            }
        });
    }