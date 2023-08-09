<?= $this->Html->scriptBlock(sprintf("var unidadesMedida                 = %s;", json_encode($unidadesMedida))); ?>
<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-plus"></span> Agregar Producto</h2>
                </div>
                <?= $this->Form->create(null, ['enctype' => 'multipart/form-data', 'name'=>'formAdd']); ?>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td>Nombre</td>
                                        <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required')); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Categoria</td>
                                        <td>
                                            <select name="categoria" class="form-control select" id="selectCategoria">
                                                <option value="0" disabled="" selected="">-- Seleccione</option>
                                                <? foreach ($categorias as $key => $value) {?>
                                                    <option value="<?=$value['id']?>"><?=$value['nombre']?></option>
                                                <?} ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Precio</td>
                                        <td><?= $this->Form->input('precio', array('class' => 'form-control', 'type'=>'number','min'=>0, 'required')); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Descripcion</td>
                                        <td><?= $this->Form->input('desc', array('class' => 'form-control', 'type'=>'textarea','rows'=>3, 'required')); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Imagen <span class="help-block">formato 4:3 max. 18 MB</span></td>
                                        <td style="max-width: 300px; max-height: 200px;">
                                            <?= $this->Form->input('image', array('type' => 'file', 'class'=>'file input_imagen imagen_form', 'data-preview-file-type' => 'any', 'multiple', 'onchange' => 'ValidarImagen(this)')); ?>
                                        </td>
                                    </tr>
                                </table>             
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td align="center">Activo</td>
                                        <td align="center">Divisible</td>
                                        <td align="center">Requiere Receta?</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><?= $this->Form->input('activo', array('type'=>'checkbox', 'checked')); ?></td>
                                        <td align="center"><?= $this->Form->input('divisible', array('type'=>'checkbox', 'unchecked')); ?></td>
                                        <? $chekRecetaDis=($plan==1)?'disabled':''; ?>
                                        <td align="center"><?= $this->Form->input('req_receta', array('type'=>'checkbox', 'id'=>'receta', $chekRecetaDis)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lugar de elaboración</td>
                                        <td colspan="2">
                                            <select name="elaboracion" class="form-control select" id="selectElaboracion">
                                                <option value="0" disabled="" selected="">-- Seleccione</option>
                                                <? foreach ($lugares as $key => $value) {?>
                                                    <option value="<?=$value['id']?>"><?=$value['nombre']?></option>
                                                <?} ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <table class="table" style="display: none;" id="tablaReceta">
                                    <tr>
                                        <td>Insumo</td>
                                        <td>Unidad de salida</td>
                                        <td>Cantidad</td>
                                        <td>Agregar</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select class="form-control select" id="insumos">
                                                <option selected="" disabled="">--Seleccione</option>
                                                <? foreach ($insumos as $key => $value) {?>
                                                    <option value="<?=$value['id']?>" medida="<?=$value['data_combo']?>"><?=$value['nombre']?></option>
                                                <?}?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" id="unidadesMedida" disabled=>
                                                <option selected="" disabled="">--Seleccione</option>
                                            </select>
                                        </td>
                                        <td><input type="number" id="cantidad" step="0.01" min="0.01"></td>
                                        <td><button type="button" class="btn btn-success btn-block agregarInsumo"><i class="fa fa-plus"></i> Agregar</button></td>
                                    </tr>
                                    <tbody id="detalleReceta"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="pull-right">
                            <?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn-form-submit btn btn-danger')); ?>
                            <button type="button" class="btn btn-success validaform">Guardar</button>
                        </div>  
                    </div>      
                </div>
                <?= $this->Form->end(); ?>
            </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    function ValidarImagen(obj){
        uploadFile = obj.files[0];
    }
    $(document).ready(function(){
        var nombreInsumo = '';
        var nombreUnSalida = '';
        var insumoId=0;
        var tipoMedida = 0;
        var unidadSalida = 0;
        var iteral=0;
        $('#receta').on('click', function(){
            if ($('#receta').prop('checked') ){
                $('#tablaReceta').show();
            }else{
                $('#tablaReceta').hide();
            }
        });
        $('#insumos').change(function(){
            $('#unidadesMedida').html('<option disabled selected>--Seleccione</option>');
            nombreInsumo       =   $('#insumos option:selected').text();
            tipoMedida        =   $('option:selected', this).attr('medida');
            insumoId=$('option:selected', this).val();
            if(tipoMedida==2||tipoMedida==3||tipoMedida==4||tipoMedida==5||tipoMedida==6){
                $.each(unidadesMedida, function( index, value ){
                    if(index==7||index==8||index==9||index==1){return;}
                    var option = '<option value="'+index+'">'+value+'</option>';
                    $('#unidadesMedida').append(option);
                });
                $('#unidadesMedida').prop('disabled', false);
            }
            if(tipoMedida==7||tipoMedida==8||tipoMedida==9){
                $.each(unidadesMedida, function( index, value ){
                    if(index==1||index==2||index==3||index==4||index==5||index==6){return;}
                    var option = '<option value="'+index+'">'+value+'</option>';
                    $('#unidadesMedida').append(option);
                });
                $('#unidadesMedida').prop('disabled', false);
            }
            if(tipoMedida==1){
                $('#unidadesMedida').html('<option disabled selected value="1">Unidad</option>');
                unidadSalida=1;
                nombreUnSalida='Unidad';
            }     
        });
        $('#unidadesMedida').change(function(){
            unidadSalida=$('option:selected', this).val();
            nombreUnSalida=$('#unidadesMedida option:selected').text();
        });
        $('#tablaReceta').on('click', '.agregarInsumo', function(){
            if(unidadSalida==0){
                alert('Debe seleccionar el insumo y la unidad de salida');
            }else{
                if($('#cantidad').val()==0||$('#cantidad').val()==''){
                    alert('Debe ingresar la cantidad');
                }else{
                    var tdInsumo = '<tr id=insumo'+iteral+'><td>'+nombreInsumo+'</td>'+
                                '<td>'+nombreUnSalida+'</td>'+
                                '<td>'+$('#cantidad').val()+'</td>'+
                                '<td><button type="button" class="btn btn-danger btn-block eliminar" reglon="'+iteral+'"><i class="fa fa-trash-o"></i></button></td>'+
                                '<input type="hidden" name="data[receta]['+iteral+'][insumoId]" value="'+insumoId+'">'+
                                '<input type="hidden" name="data[receta]['+iteral+'][unidadSalida]" value="'+unidadSalida+'">'+
                                '<input type="hidden" name="data[receta]['+iteral+'][cantidad]" value="'+$('#cantidad').val()+'">'+
                                '</tr>';
                    nombreInsumo = '';
                    nombreUnSalida = '';
                    insumoId=0;
                    tipoMedida = 0;
                    unidadSalida = 0;
                    $('#detalleReceta').append(tdInsumo);
                    $('#unidadesMedida').html('<option disabled selected>--Seleccione</option>');
                    $("#insumos").val('default');
                    $("#insumos").selectpicker("refresh");
                    $('#cantidad').val('default');
                    iteral++;    
                }                    
            }            
        });
        $('#tablaReceta').on('click', '.eliminar', function(){
            iteralBorrar=$(this).attr('reglon');
            $('#insumo'+iteralBorrar).remove();
        });
        $('.validaform').on('click', function(){
            idCategoria       =   $('#selectCategoria option:selected').val();
            idElaboracion       =   $('#selectElaboracion option:selected').val();
            if(idCategoria!=0&&idElaboracion!=0){
                document.formAdd.submit()
            }else{
                alert('Debe seleccionar categoría y lugar de elaboración');
            }
        });
    });
</script>

