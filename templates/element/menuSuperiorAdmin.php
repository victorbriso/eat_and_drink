<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
    </li>
    <li class="xn-icon-button pull-right last">
        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-power-off"></span></a>                   
    </li>
</ul>
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