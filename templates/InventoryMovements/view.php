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
            <?= $this->Html->link(__('Edit Inventory Movement'), ['action' => 'edit', $inventoryMovement->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inventory Movement'), ['action' => 'delete', $inventoryMovement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryMovement->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inventory Movements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inventory Movement'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="inventoryMovements view content">
            <h3><?= h($inventoryMovement->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $inventoryMovement->has('user') ? $this->Html->link($inventoryMovement->user->id, ['controller' => 'Users', 'action' => 'view', $inventoryMovement->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $inventoryMovement->has('product') ? $this->Html->link($inventoryMovement->product->id, ['controller' => 'Products', 'action' => 'view', $inventoryMovement->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Cellar') ?></th>
                    <td><?= $inventoryMovement->has('cellar') ? $this->Html->link($inventoryMovement->cellar->id, ['controller' => 'Cellars', 'action' => 'view', $inventoryMovement->cellar->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inventoryMovement->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Movimiento') ?></th>
                    <td><?= $this->Number->format($inventoryMovement->tipo_movimiento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($inventoryMovement->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Valor') ?></th>
                    <td><?= $this->Number->format($inventoryMovement->valor) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
