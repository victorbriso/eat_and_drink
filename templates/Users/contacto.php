<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">
        	<div class="panel panel-default">
			    <div class="panel-heading">
			        <h2><span class="fa fa-edit"></span> Contacto</h2>
			    </div>
			    <div class="panel-body">
			        <?= $this->Form->create(); ?>
			        <div class="col-md-12">
			            <div class="col-md-6 col-md-offset-3">
			                <table class="table">
			                    <tr>
			                        <td>Asunto</td>
			                        <td>
			                            <select class="form-control select" name="asunto">
			                                <option disabled="" selected="">--Seleccione</option>
			                                <? foreach ($asuntos as $key => $value) {?>
			                                    <option value="<?=$value?>"><?=$value?></option>
			                                <?} ?>
			                            </select>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td colspan="2" align="center">Mensaje</td>
			                    </tr>
			                    <tr>
			                        <td colspan="2">
			                            <textarea rows="5" name="mensaje" class="form-control"></textarea>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td colspan="2">
			                            <input type="submit" value="Enviar" class="btn btn-success btn-block">
			                        </td>
			                    </tr>
			                </table>
			            </div>
			        </div>
			    </div>
			    <?= $this->Form->end(); ?>
			</div>
        </div>
    </div>
</div>