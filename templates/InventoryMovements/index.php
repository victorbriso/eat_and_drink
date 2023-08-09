<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryMovement[]|\Cake\Collection\CollectionInterface $inventoryMovements
 */
?>
<div class="inventoryMovements index content">
    <?= $this->Html->link(__('New Inventory Movement'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inventory Movements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo_movimiento') ?></th>
                    <th><?= $this->Paginator->sort('cellar_id') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('valor') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventoryMovements as $inventoryMovement): ?>
                <tr>
                    <td><?= $this->Number->format($inventoryMovement->id) ?></td>
                    <td><?= $inventoryMovement->has('user') ? $this->Html->link($inventoryMovement->user->id, ['controller' => 'Users', 'action' => 'view', $inventoryMovement->user->id]) : '' ?></td>
                    <td><?= $inventoryMovement->has('product') ? $this->Html->link($inventoryMovement->product->id, ['controller' => 'Products', 'action' => 'view', $inventoryMovement->product->id]) : '' ?></td>
                    <td><?= $this->Number->format($inventoryMovement->tipo_movimiento) ?></td>
                    <td><?= $inventoryMovement->has('cellar') ? $this->Html->link($inventoryMovement->cellar->id, ['controller' => 'Cellars', 'action' => 'view', $inventoryMovement->cellar->id]) : '' ?></td>
                    <td><?= $this->Number->format($inventoryMovement->cantidad) ?></td>
                    <td><?= $this->Number->format($inventoryMovement->valor) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $inventoryMovement->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inventoryMovement->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $inventoryMovement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryMovement->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
