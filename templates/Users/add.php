<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('nombre');
                    echo $this->Form->control('razon_social');
                    echo $this->Form->control('latitud');
                    echo $this->Form->control('longitud');
                    echo $this->Form->control('direccion');
                    echo $this->Form->control('cabecera_direccion');
                    echo $this->Form->control('impresoras');
                    echo $this->Form->control('hash_impresion');
                    echo $this->Form->control('venta_web');
                    echo $this->Form->control('delivery');
                    echo $this->Form->control('plan');
                    echo $this->Form->control('monto_mensual');
                    echo $this->Form->control('estension');
                    echo $this->Form->control('version');
                    echo $this->Form->control('max_mesas');
                    echo $this->Form->control('pais');
                    echo $this->Form->control('region');
                    echo $this->Form->control('comuna');
                    echo $this->Form->control('sector');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
