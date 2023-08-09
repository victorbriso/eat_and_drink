<div class="x-hnavigation">
    <div class="x-hnavigation-logo">
    	<?= $this->Html->link(
            $this->Html->image('logoED.png'),
            '/admin',
            array(
                'escape'    =>  false
            )
        ); ?>
    </div>
    <ul>
        <li><?=  $this->Html->link(
                'Administradores</span>',
                array('controller' => 'Admin', 'action' => 'index'),
                array('escape' => false)
        ); ?>
        </li>
        <li class="xn-openable">
            <a href="#">Locales</a>
            <ul>
                <li>
                <?=  $this->Html->link(
						'<span class="fa fa-cube"></span> Agregar Local</span>',
						array('controller' => 'Admin', 'action' => 'add'),
						array('escape' => false)
				); ?></li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-life-ring"></span> Lista Locales</a>
                    <ul>
                        <li><?=  $this->Html->link(
                                '<span class="fa fa-cube"></span> Activos</span>',
                                array('controller' => 'RegistroLocales', 'action' => 'index', 1),
                                array('escape' => false)
                        ); ?></li>
                        <li><?=  $this->Html->link(
                                '<span class="fa fa-life-ring"></span> No Activos</a></li>',
                                array('controller' => 'RegistroLocales', 'action' => 'index', 2),
                                array('escape' => false)
                        ); ?></li>
                        <li><?=  $this->Html->link(
                                '<span class="fa fa-university"></span> Todos</a>',
                                array('controller' => 'RegistroLocales', 'action' => 'index'),
                                array('escape' => false)
                        ); ?></li>
                    </ul> 
                </li>
            </ul>                                
        </li>
        <li class="xn-openable">
            <a href="#">Usuarios</a>
            <ul>
               	<li><?=  $this->Html->link(
						'<span class="fa fa-user"></span> Administradores</span>',
						array('controller' => 'Usuarios', 'action' => 'index', 1),
						array('escape' => false)
				); ?></li>

                <li><?=  $this->Html->link(
                        '<span class="fa fa-life-ring"></span> Usuarios Sistema</a>',
                        array('controller' => 'Usuarios', 'action' => 'index', 2),
                        array('escape' => false)
                    ); ?>
                </li>
                <li><a href="#"><span class="fa fa-recycle"></span> Usuarios App</a></li>
            </ul>
        </li>
       
    </ul>
    
    <div class="x-features">
        <div class="x-features-nav-open">
            <span class="fa fa-bars"></span>
        </div>
        <div class="pull-right">
            <div class="x-features-search">
                <input type="text" name="search">
                <input type="submit">
            </div>
            <div class="x-features-profile">
                <img src="../img/avatar-admin.jpg">
                <ul class="xn-drop-left animated zoomIn">
                    <li><a href="pages-lock-screen.html"><span class="fa fa-lock"></span> Lock Screen</a></li>
                    <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>                        
</div>