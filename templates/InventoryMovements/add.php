<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryMovement $inventoryMovement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inventory Movements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="inventoryMovements form content">
            <?= $this->Form->create($inventoryMovement) ?>
            <fieldset>
                <legend><?= __('Add Inventory Movement') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                    echo $this->Form->control('tipo_movimiento');
                    echo $this->Form->control('cellar_id', ['options' => $cellars, 'empty' => true]);
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('valor');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
