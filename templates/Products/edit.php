<? $iteralReceta=count($data[0]['receta'])+1; ?>
<?= $this->Html->scriptBlock(sprintf("var unidadesMedida                 = %s;", json_encode($unidadesMedida))); ?>
<?= $this->Html->scriptBlock(sprintf("var iteral                         = %s;", json_encode($iteralReceta))); ?>
<div class="page-content-wrap modulo-proveedores">
    <div class="row">
        <div class="col-md-12">             
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="fa fa-plus"></span> Agregar Producto</h2>
                </div>
                <?= $this->Form->create(null, ['enctype' => 'multipart/form-data']); ?>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <td>Nombre</td>
                                        <?= $this->Form->input('id', array('type'=>'hidden', 'value'=>$data[0]['id'])); ?>
                                        <?= $this->Form->input('data_combo', array('type'=>'hidden', 'value'=>$data[0]['data_combo'])); ?>
                                        <td><?= $this->Form->input('nombre', array('class' => 'form-control', 'type'=>'text', 'required', 'value'=>$data[0]['nombre'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Categoria</td>
                                        <td>
                                            <select name="categoria" class="form-control select">
                                                <? foreach ($categorias as $key => $value) {
                                                    if($data[0]['category_id']==$value['id']){?>
                                                        <option value="<?=$value['id']?>" selected><?=$value['nombre']?></option>
                                                    <?}else{?>
                                                        <option value="<?=$value['id']?>"><?=$value['nombre']?></option>
                                                    <?}    
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Precio</td>
                                        <td><?= $this->Form->input('precio', array('class' => 'form-control', 'type'=>'number','min'=>0, 'required', 'value'=>$data[0]['precio_base'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Descripcion</td>
                                        <td><?= $this->Form->input('desc', array('class' => 'form-control', 'type'=>'textarea','rows'=>3, 'required', 'value'=>$data[0]['desc_es'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Imagen <span class="help-block">800px x 600px max.</span></td>
                                        <td style="max-width: 150px; max-height: 100px;">
                                            <? $img=(file_exists(ROOT.'/webroot/img/img_carta/'.$localId.'/'.$data[0]['id'].'.'.$data[0]['extension']))?'img_carta/'.$localId.'/'.$data[0]['id'].'.'.$data[0]['extension']:'404-error.jpg'; ?>
                                            <?= $this->Html->image($img, ['style'=>'max-width:150px;','max-height:100px;']) ?>
                                            <?= $this->Form->input('image', array('type' => 'file', 'class'=>'file input_imagen imagen_form', 'data-preview-file-type' => 'any', 'multiple', 'onchange' => 'ValidarImagen(this)', 'accept'=>['image/x-png,image/gif,image/jpeg'])); ?>
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
                                        <? $chekActivo=($data[0]['estado'])?'checked':'unchecked'; $chekDivisible=($data[0]['divisible'])?'checked':'unchecked'; $chekReceta=($data[0]['req_receta'])?'checked':'unchecked'; $chekRecetaDis=($plan==1)?'disabled':''; ?>
                                        <td align="center"><?= $this->Form->input('activo', array('type'=>'checkbox', $chekActivo)); ?></td>
                                        <td align="center"><?= $this->Form->input('divisible', array('type'=>'checkbox', $chekDivisible)); ?></td>
                                        <td align="center"><?= $this->Form->input('req_receta', array('type'=>'checkbox', $chekReceta, 'id'=>'receta', $chekRecetaDis)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lugar de elaboración</td>
                                        <td colspan="2">
                                            <select name="elaboracion" class="form-control select">
                                                <? foreach ($lugares as $key => $value) {
                                                    if($data[0]['place_elaboration_id']==$value['id']){?>
                                                        <option value="<?=$value['id']?>" selected><?=$value['nombre']?></option>
                                                    <?}else{?>
                                                        <option value="<?=$value['id']?>"><?=$value['nombre']?></option>
                                                    <?}    
                                                } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <? $tablaReceta=($data[0]['req_receta'])?'':'none'; ?>
                                <table class="table" style="display: <?= $tablaReceta; ?>" id="tablaReceta">
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
                                    <tbody id="detalleReceta">
                                        <? foreach ($data[0]['receta'] as $key => $value) {?>
                                            <tr id="insumo<?=$key?>">
                                                <td><?= $insumos[$value['insumoId']]['nombre']; ?></td>
                                                <td><?= $unidadesMedida[$value['unidadSalida']] ?></td>
                                                <td><?= $value['cantidad'] ?></td>
                                                <td><button type="button" class="btn btn-danger btn-block eliminar" reglon="<?=$key?>"><i class="fa fa-trash-o"></i></button></td>
                                                <input type="hidden" name="data[receta][<?=$key?>][insumoId]" value="<?= $value['insumoId'] ?>">
                                                <input type="hidden" name="data[receta][<?=$key?>][unidadSalida]" value="<?= $value['unidadSalida'] ?>">
                                                <input type="hidden" name="data[receta][<?=$key?>][cantidad]" value="<?= $value['cantidad'] ?>">
                                            </tr>
                                        <?}?>
                                    </tbody>
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
    });
</script>

