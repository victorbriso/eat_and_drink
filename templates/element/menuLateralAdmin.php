<div class="page-sidebar">
	<ul class="x-navigation x-navigation-custom">
        <li class="nombre-local-menu">
        	<h3 style="font-size: 18px;color: #FF7529;">CEOrestobar</h3 style="color: ">
        </li>
        <hr style="width: 100%;">
		<li class="<?= ($this->Menu->menuActivo('Users', 'dashboard', $dondeEstoy))?'active':'' ?>">
			<?= $this->Html->link(
				'<span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span>',
				array('controller' => 'Users', 'action' => 'dashboard'),
				array('escape' => false)
			); ?>
		</li>
		<li class="<?= ($this->Menu->menuActivo('Comandas', 'mesasComandaNueva', $dondeEstoy))?'active':'' ?>">
			<?= $this->Html->link(
				'<i class="fa fa-check-circle"></i> <span class="xn-text">Comanda Nueva</span>',
				array('controller' => 'Comandas', 'action' => 'mesasComandaNueva'),
				array('escape' => false)
			); ?>
		</li>
		<li class="<?= ($this->Menu->menuActivo('Comandas', 'index', $dondeEstoy))?'active':'' ?>">
			<?= $this->Html->link(
				'<i class="fa fa-book"></i> <span class="xn-text">Comandas</span>',
				array('controller' => 'Comandas', 'action' => 'index'),
				array('escape' => false)
			); ?>
		</li>
		<hr style="width: 100%;">	
		<li class="treeview
			<?= ($this->Menu->menuActivo('Products', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Categories', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Categories', 'add', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Categories', 'edit', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'listasPrecio', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'editListaPrecio', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'addListaPrecio', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'add', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'edit', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'lugaresElaboracion', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'insumos', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'publicacion', $dondeEstoy))?'active':'' ?>
		">
			<a href="#">
				<i class="fa fa-share"></i> <span>Carta</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li class="<?= ($this->Menu->menuActivo('Products', 'index', $dondeEstoy))?'active':'' ?> <?= ($this->Menu->menuActivo('Products', 'add', $dondeEstoy))?'active':'' ?> <?= ($this->Menu->menuActivo('Products', 'edit', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-archive"></i> Productos', ['controller'=>'Products', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Categories', 'index', $dondeEstoy))?'active':'' ?> <?= ($this->Menu->menuActivo('Categories', 'edit', $dondeEstoy))?'active':'' ?> ">
					<?= $this->html->link('<i class="fa fa-bars"></i> Categorias', ['controller'=>'Categories', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Products', 'lugaresElaboracion', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-cog"></i> Lugares de produccion', ['controller'=>'Products', 'action'=>'lugaresElaboracion'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Products', 'listasPrecio', $dondeEstoy))?'active':'' ?><?= ($this->Menu->menuActivo('Products', 'editListaPrecio', $dondeEstoy))?'active':'' ?><?= ($this->Menu->menuActivo('Products', 'addListaPrecio', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-list"></i> Listas de precios', ['controller'=>'Products', 'action'=>'listasPrecio'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Products', 'publicacion', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-coffee"></i> Publicacion carta', ['controller'=>'Products', 'action'=>'publicacion'], ['escape'=>false]) ?>
				</li>
				<hr style="width: 100%;">
				<li class="<?= ($this->Menu->menuActivo('Products', 'insumos', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-cog"></i> Insumos', ['controller'=>'Products', 'action'=>'insumos'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
		<li class="treeview
			<?= ($this->Menu->menuActivo('Tables', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Salons', 'index', $dondeEstoy))?'active':'' ?>
		">
			<a href="#">
				<i class="fa fa-share"></i> <span>Mesas</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li class="<?= ($this->Menu->menuActivo('Tables', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-th"></i> Mesas', ['controller'=>'Tables', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Salons', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-columns"></i> Salones', ['controller'=>'Salons', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Salons', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-columns"></i> Cambio de mesas', ['controller'=>'Salons', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Salons', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-columns"></i> Anulaciones', ['controller'=>'Salons', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Salons', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-columns"></i> Descuentos', ['controller'=>'Salons', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
		<li class="treeview
			<?= ($this->Menu->menuActivo('Cashboxes', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Cashboxes', 'historicoCaja', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Cashboxes', 'detalleHistoricoCaja', $dondeEstoy))?'active':'' ?>
			">

			<a href="#">
				<i class="fa fa-dollar"></i> <span>Caja</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li class="<?= ($this->Menu->menuActivo('Cashboxes', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-dollar"></i> Cajas', ['controller'=>'Cashboxes', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Cashboxes', 'historicoCaja', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-cogs"></i> Historico', ['controller'=>'Cashboxes', 'action'=>'historicoCaja'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
		<li class="treeview
			<?= ($this->Menu->menuActivo('Vendors', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Vendors', 'edit', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('BuySummaries', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('BuySummaries', 'add', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('BuyDetails', 'detalle', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Cellars', 'index', $dondeEstoy))?'active':'' ?>
			">

			<a href="#">
				<i class="fa fa-shopping-cart"></i> <span>Compras</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li class="<?= ($this->Menu->menuActivo('BuySummaries', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-dollar"></i> Compras', ['controller'=>'BuySummaries', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Vendors', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-truck"></i> Proveedores', ['controller'=>'Vendors', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Cellars', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-archive"></i> Bodegas', ['controller'=>'Cellars', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
		<li class="treeview
			<?= ($this->Menu->menuActivo('Users', 'sistema', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('FixedCosts', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Usuarios', 'index', $dondeEstoy))?'active':'' ?>
		">
			<a href="#">
				<i class="fa fa-gears"></i> <span>Configuración</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li class="<?= ($this->Menu->menuActivo('Users', 'sistema', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-gears"></i> Sistema', ['controller'=>'Users', 'action'=>'sistema'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('FixedCosts', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-book"></i> Costos fijos', ['controller'=>'FixedCosts', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Usuarios', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-users"></i> Usuarios', ['controller'=>'Usuarios', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
		<li>
			<li class="<?= ($this->Menu->menuActivo('Locales', 'contacto', $dondeEstoy))?'active':'' ?>">
				<?= $this->html->link('<i class="fa fa-pencil-square-o"></i> Contacto', ['controller'=>'Users', 'action'=>'contacto'], ['escape'=>false]) ?>
			</li>
		</li>
		<li>
			<li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-power-off"></span> Salir</a></li>
		</li>      
	</ul>
</div>
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span><strong>Salir</strong> ?</div>
            <div class="mb-content">
                <p>Estas seguro de salir</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <?= $this->Html->link('Si', array('controller' => 'Users', 'action' => 'logout'), array('class' => 'btn btn-success btn-lg')); ?>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
