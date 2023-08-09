<div class="col-md-12 d-none d-md-block position-fixed" style="max-width: inherit !important;">
    <? $totalProductos=array(); ?>
    <? foreach ($carta as $key1 => $value1) { array_push($totalProductos, count($value1['productos'])); ?>
        <button class="btn btn-info btn-block filtro" categoria="<?= $key1 ?>"><?= $value1['nombre']; ?> (<?= count($value1['productos']) ?>)</button>
    <?}?>
    <button class="btn btn-info btn-block filtro" categoria="0">Ver todos los productos (<?= array_sum($totalProductos) ?>)</button>
</div>
<div class="col-12 d-sm-none d-md-none d-lg-none d-xl-none position-fixed"  style="max-width: 80% !important; z-index: 999;">
    <div class="btn-group d-block">
        <button type="button" class="btn btn-info dropdown-toggle btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorías</button>
        <div class="dropdown-menu">
            <? foreach ($carta as $key1 => $value1) {?>
                <a class="dropdown-item filtro" href="#" categoria="<?= $key1 ?>"><?= $value1['nombre']; ?> (<?= count($value1['productos']) ?>)</a>
                <div class="dropdown-divider"></div>
            <?}?>
            <a class="dropdown-item filtro" href="#" categoria="0">Ver todos los productos (<?= array_sum($totalProductos) ?>)</a>
        </div>
    </div>
</div>