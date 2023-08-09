<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Categorías</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <? foreach ($carta as $key1 => $value1) {?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value1['nombre']; ?></a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <? foreach ($value1['productos'] as $key2 => $value2) {?>
                            <a class="dropdown-item" href="#">
                                <table width="100%" border="0">
                                    <tr><td width="70%"><?= $value2['nombre']; ?></td><td width="30%">$ <?= number_format($value2['precio_actual'], 0, ',', '.') ?></td></tr>        
                                </table>
                            </a>
                        <?}?>
                    </div>
                </li>
            <?}?>
        </ul>
    </div>
</nav>