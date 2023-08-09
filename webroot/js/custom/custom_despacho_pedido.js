$( document ).ready(function() { 

   // setInterval(obtenerNuevosPedidos(), 3000);
   var myVar = setInterval(obtenerNuevosPedidos, 30000);

   $('body').on('change', '#lugarElaboracionPedido', function(){

        var id_lugar_elaboracion = $(this).val();
        var url_pedido_lugar =  webroot + 'Mesas/estadoPedidoElaboracion/'+id_lugar_elaboracion
        window.open(url_pedido_lugar);

   });
   /**
    * [if description]
    * @param  {[type]} $('.contenedor-estado-pedido-elaboracion').length [description]
    * @return {[type]}                                                   [description]
    */
   if ($('.contenedor-estado-pedido-elaboracion').length ){

        $('.titulo_mesas_pendientes').html(cant_mesas);
        $('.titulo_pedidos_pendientes').html(cant_pedidos);

        /**  */
        $('.contenedor-mesa-pedido').each(function(){

            var mesa_itera          =    $(this).attr('item_contenedor');
            var can_pedidos_mesa    =    $('.pedido_mesa_visual_'+mesa_itera).length;
            
        });

        $('.grid').masonry({});
       }

       $('body').on('click', '.btn-despachar-pedido', function(){

            var pedido              = $(this).attr(pedido);
            var cantidad            = $(this).attr(cantidad);
            var time                = $(this).attr(time);
            var producto_carta_id   = $(this).attr(producto_carta_id);

            $.ajax({
                type        : 'POST',
                url         : webroot + 'Pedidos/termina_pedido',
                data            : {
                    pedido                      : pedido,
                    cantidad                    : cantidad,
                    time                        : time,
                    producto_carta_id           : producto_carta_id,
                },
                success     : function(msg){
                    
                }

             });

       });

       $('body').on('click', '.btn-anular-pedido' , function(){

            var pedido              = $(this).attr(pedido);

            $.ajax({
                type        : 'POST',
                url         : webroot + 'Pedidos/anular_pedido',
                data            : {
                    pedido                      : pedido,
                },
                success     : function(msg){
                    
                }

             });
       });
   /**
    * [description]
    * @param  {[type]} ){                } [description]
    * @return {[type]}     [description]
    */
   $('body').on('keyup', '.campo-buscar-pedido-pendiente', function(){

        var valor_buscar    =   $(this).val();
        console.log(valor_buscar); 

   });

});
/**
 * [obtenerNuevosPedidos description]
 * @return {[type]} [description]
 */
function obtenerNuevosPedidos()
{
   /** $.ajax({
        type        : 'POST',
        url         : webroot + 'Pedidos/ajax_obtenerNuevoPedido',
        data            : {
            ultimo_id_pedido          : ultimo_id_pedido,
        },
        success     : function(msg){
            if (msg != 1){
               $.each(JSON.parse(msg), function(idx, obj) {

                    var html_pedido = '<tr>'+
                                            '<td><span fecha="'+obj.Pedido.created+'" class="fecha_cronometro campo_fecha_'+obj.Pedido.id+'" id="'+obj.Pedido.id+'"></span></td>'+
                                            '<td>'+obj.Pedido.producto+'</td>'+
                                            '<td>'+obj.Pedido.cantidad+'</td>'+
                                            '<td>'+obj.Pedido.comentario+'</td>'+
                                            '<td>'+obj.Pedido.nombre+'</td>'+
                                            '<td>'+
                                                '<a href="/Pedidos/termina_pedido/20324/1/1564672898/503" class="btn btn-success"><i class="fa fa-check-square-o"></i> Despachar</a>'+
                                            '</td>'+
                                        '</tr>';

                    $('.tr_pedido_mesa_'+obj.Pedido.comanda_id).append(html_pedido);
                    ultimo_id_pedido = obj.Pedido.id;

                });
               // Envio a impirmir
               $.post(webroot + 'Pages/ajax_imprimir', {data: msg}, function(htmlexterno){});
            }
            
        }

     });*/

     location.reload();
}