<?= $this->Html->script('/backend/js/plugins/nvd3/lib/d3.v3.js') ?>
<?= $this->Html->script('/backend/js/plugins/nvd3/nv.d3.min.js') ?>
<?= $this->fetch('script'); ?>
<?= $this->Html->scriptBlock(sprintf("var dataGraf                 = %s;", json_encode($dataGraf))); ?>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-default">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Control costos fijos</h4>
                        </div>
                        <div class="col-md-12">
                            <?= $this->Form->create(null, ['url'=>['controller'=>'FixedCosts', 'action'=>'add'], 'name'=>'formAddCosto']) ?>
                            <table class="table">
                                <tr>
                                    <td>Concepto</td>
                                    <td>Frecuencia</td>
                                    <td colspan="2">Monto</td>
                                </tr>
                                <tr>
                                    <td><?= $this->Form->input('concepto', array('class' => 'form-control', 'type'=>'text', 'id'=>'formConcepto')); ?></td>
                                    <td>
                                        <select class="form-control select" name="frecuencia" id="frecuencia">
                                            <option disabled="" selected="" value="0">--Seleccione</option>
                                            <? foreach ($frecuencias as $key => $value) {?>
                                                <option value="<?=$key?>"><?=$value?></option>
                                            <?} ?>
                                        </select>
                                    </td>
                                    <td><?= $this->Form->input('monto', array('class' => 'form-control', 'type'=>'number', 'min'=>0, 'id'=>'formMonto')); ?></td>
                                    <td><button type="button" class="btn btn-success btn-block validaForm">Agregar</button></td>
                                </tr>
                            </table>
                            <?= $this->Form->end() ?>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td>Concepto</td>
                                    <td>Frecuencia</td>
                                    <td>Monto</td>
                                    <td colspan="2">Equiv. X Día</td>
                                </tr>
                                <? if(empty($costosFijos)){?>
                                    <tr>
                                        <td colspan="4" align="center">Aún no hay costos fijos registrados</td>
                                    </tr>
                                <?}else{
                                    foreach ($costosFijos as $key => $value) {?>
                                        <tr>
                                            <td><?= $value['concepto'] ?></td>
                                            <td><?= $frecuencias[$value['freciencia']] ?></td>
                                            <td>$<?= number_format($value['monto'], 0, ',', '.') ?>.-</td>
                                            <td>$<?= number_format($value['equiv'], 0, ',', '.') ?>.-</td>
                                            <td><button class="btn btn-warning"><i class="fa fa-edit"></i> Editar</button>&nbsp;<button class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button></td>
                                        </tr>
                                    <?}
                                } ?>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Distribución diaria de costos</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="chart-10" style="height: 300px;"><svg></svg></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var nvd3Charts = function() {    
            var myColors = ["#33414E","#8DCA35","#00BFDD","#FF702A","#DA3610",
                            "#80CDC2","#A6D969","#D9EF8B","#FFFF99","#F7EC37","#F46D43",
                            "#E08215","#D73026","#A12235","#8C510A","#14514B","#4D9220",
                            "#542688", "#4575B4", "#74ACD1", "#B8E1DE", "#FEE0B6","#FDB863",                                                
                            "#C51B7D","#DE77AE","#EDD3F2"];
            d3.scale.myColors = function() {
                return d3.scale.ordinal().range(myColors);
            };        
        var startChart9 = function() {
            //Donut chart example
            nv.addGraph(function() {
                var chart = nv.models.pieChart().x(function(d) {
                    return d.label;
                }).y(function(d) {
                    return d.value;
                }).showLabels(true)//Display pie labels
                .labelThreshold(.05)//Configure the minimum slice size for labels to show up
                .labelType("percent")//Configure what type of data to show in the label. Can be "key", "value" or "percent"
                .donut(true)//Turn on Donut mode. Makes pie chart look tasty!
                .donutRatio(0.35)//Configure how big you want the donut hole size to be.
                .color(d3.scale.myColors().range());;
                d3.select("#chart-10 svg").datum(dataGraf).transition().duration(350).call(chart);
                return chart;
            });
        };
        return {        
            init : function() {
                startChart9();
            }
        };
    }();
    nvd3Charts.init();
    $(document).ready(function(){
        $('.validaForm').on('click', function(){
            var nfrecuencia       =   $('#frecuencia option:selected').val();
            var concepto=$('#formConcepto').val();
            var monto=$('#formMonto').val();
            if(concepto!=''&&monto!=''&&monto!=0&&nfrecuencia!=0){
                document.formAddCosto.submit()
            }else{
                alert('Debe ingresar concepto, freciencia y monto');
            }
        });
    });
</script>
