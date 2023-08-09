<div class="page-sidebar">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="logo">
            <a href="#"><?= $this->Html->image('logo_menu.png'); ?></a>
            <a href="#" class="x-navigation-control"><?= $this->Html->image('logo_menu.png'); ?></a>
        </li>
        <li class="<?= ($this->Menu->menuActivo('Users', 'dashboard', $dondeEstoy))?'active':'' ?>">
			<?= $this->Html->link(
				'<span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span>',
				array('controller' => 'Users', 'action' => 'dashboard'),
				array('escape' => false)
			); ?>
		</li> 
        <li class="xn-openable
			<?= ($this->Menu->menuActivo('Products', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Categories', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Categories', 'add', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Categories', 'edit', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'listasPrecio', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'editListaPrecio', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'addListaPrecio', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'add', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'edit', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'insumos', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'configDelivery', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'configWeb', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Products', 'publicacion', $dondeEstoy))?'active':'' ?>
		">
			<a href="#">
				<i class="fa fa-share"></i> <span>Carta</span>
			</a>
			<ul>
				<li class="<?= ($this->Menu->menuActivo('Products', 'index', $dondeEstoy))?'active':'' ?> <?= ($this->Menu->menuActivo('Products', 'add', $dondeEstoy))?'active':'' ?> <?= ($this->Menu->menuActivo('Products', 'edit', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-archive"></i> Productos', ['controller'=>'Products', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Categories', 'index', $dondeEstoy))?'active':'' ?> <?= ($this->Menu->menuActivo('Categories', 'edit', $dondeEstoy))?'active':'' ?> ">
					<?= $this->html->link('<i class="fa fa-bars"></i> Categorias', ['controller'=>'Categories', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Products', 'listasPrecio', $dondeEstoy))?'active':'' ?><?= ($this->Menu->menuActivo('Products', 'editListaPrecio', $dondeEstoy))?'active':'' ?><?= ($this->Menu->menuActivo('Products', 'addListaPrecio', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-list"></i> Listas de precios', ['controller'=>'Products', 'action'=>'listasPrecio'], ['escape'=>false]) ?>
				</li>
				<? if($this->request->getSession()->read('local.0.delivery')){?>
					<li class="<?= ($this->Menu->menuActivo('Products', 'configDelivery', $dondeEstoy))?'active':'' ?>">
						<?= $this->html->link('<i class="fa fa-bolt"></i> Delivery', ['controller'=>'Products', 'action'=>'configDelivery'], ['escape'=>false]) ?>
					</li>
				<?} ?>
				<? if($this->request->getSession()->read('local.0.venta_web')){?>
					<li class="<?= ($this->Menu->menuActivo('Products', 'configWeb', $dondeEstoy))?'active':'' ?>">
						<?= $this->html->link('<i class="fa fa-desktop"></i> Venta web', ['controller'=>'Products', 'action'=>'configWeb'], ['escape'=>false]) ?>
					</li>
				<?} ?>
				<li class="<?= ($this->Menu->menuActivo('Products', 'publicacion', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-coffee"></i> Publicacion carta', ['controller'=>'Products', 'action'=>'publicacion'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
        <li class="xn-openable
			<?= ($this->Menu->menuActivo('Tables', 'index', $dondeEstoy))?'active':'' ?>
			<?= ($this->Menu->menuActivo('Salons', 'index', $dondeEstoy))?'active':'' ?>
		">
			<a href="#">
				<i class="fa fa-share"></i> <span>Mesas</span>
			</a>
			<ul class="treeview-menu">
				<li class="<?= ($this->Menu->menuActivo('Tables', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-th"></i> Mesas', ['controller'=>'Tables', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
				<li class="<?= ($this->Menu->menuActivo('Salons', 'index', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-columns"></i> Salones', ['controller'=>'Salons', 'action'=>'index'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
		<li class="xn-openable
			<?= ($this->Menu->menuActivo('Users', 'sistema', $dondeEstoy))?'active':'' ?>
		">
			<a href="#">
				<i class="fa fa-gears"></i> <span>Configuración</span>
			</a>
			<ul class="treeview-menu">
				<li class="<?= ($this->Menu->menuActivo('Users', 'sistema', $dondeEstoy))?'active':'' ?>">
					<?= $this->html->link('<i class="fa fa-gears"></i> Sistema', ['controller'=>'Users', 'action'=>'sistema'], ['escape'=>false]) ?>
				</li>
			</ul>
		</li>
		<li>
			<li class="<?= ($this->Menu->menuActivo('Locales', 'contacto', $dondeEstoy))?'active':'' ?>">
				<?= $this->html->link('<i class="fa fa-pencil-square-o"></i> Contacto', ['controller'=>'Users', 'action'=>'contacto'], ['escape'=>false]) ?>
			</li>
		</li>
		<li>
			<li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-power-off"></span>Salir</a></li>
		</li>       
    </ul>
</div>
