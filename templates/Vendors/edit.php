<div class="panel panel-default">
    <div class="panel-heading">
        <h2><span class="fa fa-edit"></span> Edición <?= $data[0]['nombre'] ?> / <?= $data[0]['razon_social'] ?></h2>
    </div>

    <div class="panel-body">
        <div class="col-md-12">
            <?= $this->Form->create(); ?>
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td>Nombre</td>
                            <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['nombre'], 'required')); ?>
                                <?= $this->Form->input('id', array( 'type'=>'hidden', 'value'=>$data[0]['id'], 'required')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Razón Social</td>
                            <td><?= $this->Form->input('rasonSocial', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['razon_social'], 'required')); ?></td>
                        </tr>
                        <tr>
                            <td>R.U.T.:</td>
                            <td>
                                <table>
                                    <tr>
                                        <td width="68%"><?= $this->Form->input('rut', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$data[0]['rut'])); ?></td>
                                        <td width="4%"></td>
                                        <td width="28%"><?= $this->Form->input('rut_dv', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$data[0]['rut_dv'])); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>Direccion</td>
                            <td><?= $this->Form->input('direccion', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['direccion'], 'required')); ?></td>
                        </tr>
                        <tr>
                            <td>Mail DTE</td>
                            <td><?= $this->Form->input('mail', array('class' => 'form-control', 'type'=>'email', 'value'=>$data[0]['mail_dte'], 'required')); ?></td>
                        </tr>                        
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td colspan="3" align="center">Pedidos</td>
                        </tr>
                        <tr>
                            <td align="center">Nombre</td>
                            <td align="center">Fono</td>
                            <td align="center">Mail</td>
                        </tr>
                        <tr>
                            <td><?= $this->Form->input('comercialnombre', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['data_pedido']['nombre'])); ?></td>
                            <td><?= $this->Form->input('comercialfono', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['data_pedido']['fono'])); ?></td>
                            <td><?= $this->Form->input('comercialmail', array('class' => 'form-control', 'type'=>'email', 'value'=>$data[0]['data_pedido']['mail'])); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">Facturación</td>
                        </tr>
                        <tr>
                            <td align="center">Nombre</td>
                            <td align="center">Fono</td>
                            <td align="center">Mail</td>
                        </tr>
                        <tr>
                            <td><?= $this->Form->input('facturacionnombre', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['data_facturacion']['nombre'])); ?></td>
                            <td><?= $this->Form->input('facturacionfono', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['data_facturacion']['fono'])); ?></td>
                            <td><?= $this->Form->input('facturacionmail', array('class' => 'form-control', 'type'=>'email', 'value'=>$data[0]['data_facturacion']['mail'])); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">Cobranza</td>
                        </tr>
                        <tr>
                            <td align="center">Nombre</td>
                            <td align="center">Fono</td>
                            <td align="center">Mail</td>
                        </tr>
                        <tr>
                            <td><?= $this->Form->input('cobranzanombre', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['data_cobranza']['nombre'])); ?></td>
                            <td><?= $this->Form->input('cobranzafono', array('class' => 'form-control', 'type'=>'text', 'value'=>$data[0]['data_cobranza']['fono'])); ?></td>
                            <td><?= $this->Form->input('cobranzamail', array('class' => 'form-control', 'type'=>'email', 'value'=>$data[0]['data_cobranza']['mail'])); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="pull-right">
                <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                <input type="submit" class="btn btn-success"  autocomplete="off" data-loading-text="Espera un momento..." value="Guardar">
            </div>  
        </div>      
    </div>
    <?= $this->Form->end(); ?>
</div>
