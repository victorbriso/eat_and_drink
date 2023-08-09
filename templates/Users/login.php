<div class="container-fluid">
    <div class="contenedor-general">
        <div class="container">
            <div class="row">
                <div class="contenedor">
                    <div class="col-md-6 col-xs-12 titulo">
                        <div class="titulo_1">Bienvenido a</div><br>
                        <div class="titulo_2">CEOrestobar</div><br>
                        <div class="titulo_3">Plataforma de administraci&oacute;n</div>
                    </div>
                    <div class="col-md-6 col-xs-12 login">
                        <div class="form-login center-block">
                            <div class="cabecera">
                            </div>
                            <div class="form">
                                 <?= $this->Form->create() ?>
                                        <h2>Datos de Empresa</h2>
                                        <!-- Campos empresa -->
                                        <div class="form-group">
                                            <label>E-mail</label>
                                           <?= $this->Form->control('username', ['required' => true, 'label'=>false, 'class' => 'form-control']) ?>
                                        </div> 
                                         <div class="form-group">
                                         <label>Contraseña</label>                                          
                                          <?= $this->Form->control('password', ['required' => true, 'label'=>false, 'class' => 'form-control']) ?>
                                          <?= $this->Form->control('_Token[fields]', ['required' => true, 'type'=>'hidden', 'value'=>$token]) ?>
                                          <?= $this->Form->control('Token', ['required' => true, 'type'=>'hidden', 'value'=>$token]) ?>
                                        </div>
                                        <hr class="hidden-xs">
                                        <div class="form-group btn-login">
                                            <label><?= $this->Flash->render() ?></label> 
                                            <button type="submit" class="btn btn-ed mb-2 btn-block">INGRESAR</button>
                                        </div>
                                  <?= $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>