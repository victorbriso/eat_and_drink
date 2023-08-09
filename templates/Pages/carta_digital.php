<?= $this->Html->scriptBlock(sprintf("var token                 = %s;", json_encode($token))); ?>
<header id="header" role="banner">
    <div class="container">
        <div id="navbar" class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#main-slider"><i class="icon-home"></i></a></li>
                    <li><a href="#services">Caracteriscicas</a></li>
                    <li><a href="#pricing">Precio</a></li>
                    <li><a href="#about-us">Nosotros</a></li>
                    <li><a href="#contact">Contacto</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<section id="main-slider" class="carousel">
    <div class="carousel-inner">
        <div class="item active">
            <div class="container">
                <div class="carousel-content">
                    <h1>Prueba 30 días gratis</h1>
                    <p class="lead">Prueba el servicio durante 30 días, si te gusta podras continuar usandolo con un valor muy reducido.</p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-content">
                    <h1>Carta digital a un QR de distancia</h1>
                    <p class="lead">Pon un código QR en cada mesa, y listo!!<br>Al escanear el código se visualiza la carta, el comensal puede llamar al garzón<br>y hasta pedir la cuenta!</p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-content">
                    <h1>Sin limite de productos</h1>
                    <p class="lead">Paga un solo cargo fijo, sin cobros sorpresa <br>sin límite de productos ni categorias</p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-content">
                    <h1>Cambios de precios a un click</h1>
                    <p class="lead">Define tus listas de precios <br>y activalas según tus necesidades</p>
                </div>
            </div>
        </div>
    </div>
    <a class="prev" href="#main-slider" data-slide="prev"><i class="icon-angle-left"></i></a>
    <a class="next" href="#main-slider" data-slide="next"><i class="icon-angle-right"></i></a>
</section>
<section id="services">
    <div class="container">
        <div class="box first">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="center">
                        <i class="icon-align-justify icon-md icon-color1"></i>
                        <h4>Carta Virtual</h4>
                        <p>La carta virtual disponible con código QR, siempre actualizada</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="center">
                        <i class="fas fa-dollar-sign icon-md icon-color2"></i>
                        <h4>¿Cambios de precios?</h4>
                        <p>Ilimitadas listas de precios para actualizar los valores de venta a un solo click</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="center">
                        <i class="fas fa-cog icon-md icon-color3"></i>
                        <h4>Control por salones</h4>
                        <p>Ordena las mesas por salones, sin límites</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="center">
                        <i class="fas fa-ban icon-md icon-color4"></i>
                        <h4>¿Se acabo algo?</h4>
                        <p>Activa o desactiva productos facilmente</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="center">
                        <i class="icon-thumbs-up icon-md icon-color5"></i>
                        <h4>Clientes conectados</h4>
                        <p>Desde la vista de la carta, tus clientes pueden a un solo click llamar al garzón o pedir la cuenta</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="center">
                        <i class="fas fa-cogs icon-md icon-color6"></i>
                        <h4>Sencillo pero potente</h4>
                        <p>Panel de administración sencillo e intuitivo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="pricing">
    <div class="container">
        <div class="box">
            <div class="center">
                <h2>Un solo plan</h2>
                <p class="lead">Obten el manejo de la carta, con un pago <strong>fijo mensual</strong></p>
            </div> 
            <div class="big-gap"></div>
            <div id="pricing-table" class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <ul class="plan featured">
                        <li class="plan-price">$9.900 iva inc</li>
                        <li>30 días gratis</li>
                        <li>Sin límite de productos</li>
                        <li>Ilimitadas listas de precio</li>
                        <li>Sin límite de categorías</li>
                        <li>Sin límite de actualizaciones</li>
                        <li>Todos tus productos con imagenes</li>
                        <li class="plan-action"><a href="#" class="btn btn-primary btn-lg">Comienza</a></li>
                    </ul>
                </div>
            </div> 
        </div> 
    </div>
</section>
<section id="about-us">
    <div class="container">
        <div class="box">
            <div class="center">
                <h2>CEO<strong>restobar</strong></h2>
                <p class="lead">La carta digital es una versión básica de la plataforma completa de CEO<strong>restobar</strong>, creando un servicio para el control eficiente de una carta virtual.<br>¿Necesitas control de caja, inventario, comandas y más?<br> <a href="#contact" class="btn btn-primary btn-lg">Ingresa acá</a></p>
            </div>
        </div>
    </div>
</section>
<section id="contact">
    <div class="container">
        <div class="box last">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Contacto</h1>
                    <p>Escribemos y pronto nos pondremos en contacto contigo</p>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" required="required" placeholder="Nombre" id="nombre" name="nombre">
                                    <p style="text-align: center; color: red;" class="hidden" id="verNombre">Campo obligatorio</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" required="required" placeholder="Email" id="mail" name="mail">
                                    <p style="text-align: center; color: red;" class="hidden" id="verMail">Campo obligatorio</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Mensaje"></textarea>
                                    <p style="text-align: center; color: red;" class="hidden" id="verMensaje">Campo obligatorio</p>
                                    <div id="respuestaMensaje"></div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" onclick="enviarMensaje();"><strong>Enviar</strong></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <h1>Teléfono</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <abbr title="Phone">P:</abbr> +56 9 7605 4659
                            </address>
                        </div>
                    </div>
                    <h1>Conectate con nosotros</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="social">
                                <li><a href="#"><i class="icon-facebook icon-social"></i> Facebook</a></li>
                                <li><a href="#"><i class="icon-linkedin icon-social"></i> Linkedin</a></li>
                                <li><a href="#"><i class="icon-youtube icon-social"></i> Youtube</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="inferior"><a href="https://api.whatsapp.com/send?phone=56976054659&text=hola" target="_blank" class="pull-right"><?= $this->Html->image('icowsp.png'); ?></a></div>
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                &copy; 2020 <a target="_blank" href="https://vbstechnology.cl/" title="VBSTechnology">VBSTechnology</a>. Todos los derechos reservados.
            </div>
            <div class="col-sm-6">
                <img class="pull-right" src="landing/images/logofooter.png" alt="VBSTechnology" title="VBSTechnology">
            </div>
        </div>
    </div>
</footer>
<style type="text/css">
    #inferior{
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>
<script type="text/javascript">
    function enviarMensaje(){
        var nombre = $('#nombre').val();
        var mail = $('#mail').val();
        var mensaje = $('#message').val();
        if(nombre.length>0 && nombre!='' && nombre!=null){
            validacionNombre = true;
            $('#verNombre').addClass('hidden');
        }else{
            validacionNombre = false;
            $('#verNombre').removeClass('hidden');
        }
        if(mail.length>0 && mail!='' && mail!=null){
            validacionMail = true;
            $('#verMail').addClass('hidden');
        }else{
            validacionMail = false;
            $('#verMail').removeClass('hidden');
        }
        if(mensaje.length>0 && mensaje!='' && mensaje!=null){
            validacionMensaje = true;
            $('#verMensaje').addClass('hidden');
        }else{
            validacionMensaje = false;
            $('#verMensaje').removeClass('hidden');
        }
        if(validacionNombre&&validacionMail&&validacionMensaje){
            var formRetiro = {
                '_Token[fields]':token,
                'nombre':nombre,
                'mail':mail,
                'message':mensaje
            };
            $.ajax({
                type: 'POST',
                url: '/Pages/contacto',
                headers: { 'X-XSRF-TOKEN' : token },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', token);
                },
                data: formRetiro,
                success: function (result) {
                    console.log(result);
                    if(result==1){
                        $('#nombre').val('');
                        $('#mail').val('');
                        $('#message').val('');
                        $('#respuestaMensaje').html('<p style="text-align: center; color: green;">Mensaje enviado con exito, pronto nos pondremos en contacto.</p>');
                        setTimeout(function(){ $('#respuestaMensaje').html(''); }, 3000);
                    }else{
                        $('#respuestaMensaje').html('<p style="text-align: center; color: red;">Ocurrio un error al enviar el mensaje.</p>');
                        setTimeout(function(){ $('#respuestaMensaje').html(''); }, 3000);
                    }
                    
                },
                error: function (result){
                    console.log(result);
                    $('#respuestaMensaje').html('<p style="text-align: center; color: red;">Error al comunicarse con el servidor.</p>');
                    setTimeout(function(){ $('#respuestaMensaje').html(''); }, 3000);
                }

            });
        }else{
            $('#respuestaMensaje').html('<p style="text-align: center; color: red;">Debe completar todos los campos.</p>');
            setTimeout(function(){ $('#respuestaMensaje').html(''); }, 3000);
        }
    }
</script>