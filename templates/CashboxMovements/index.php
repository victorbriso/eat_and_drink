<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashboxMovement[]|\Cake\Collection\CollectionInterface $cashboxMovements
 */
?>
<div class="cashboxMovements index content">
    <?= $this->Html->link(__('New Cashbox Movement'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cashbox Movements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('cashbox_id') ?></th>
                    <th><?= $this->Paginator->sort('folio_cash_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo_pago') ?></th>
                    <th><?= $this->Paginator->sort('monto') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cashboxMovements as $cashboxMovement): ?>
                <tr>
                    <td><?= $this->Number->format($cashboxMovement->id) ?></td>
                    <td><?= $cashboxMovement->has('user') ? $this->Html->link($cashboxMovement->user->id, ['controller' => 'Users', 'action' => 'view', $cashboxMovement->user->id]) : '' ?></td>
                    <td><?= $cashboxMovement->has('cashbox') ? $this->Html->link($cashboxMovement->cashbox->id, ['controller' => 'Cashboxes', 'action' => 'view', $cashboxMovement->cashbox->id]) : '' ?></td>
                    <td><?= $cashboxMovement->has('folio_cash') ? $this->Html->link($cashboxMovement->folio_cash->id, ['controller' => 'FolioCashes', 'action' => 'view', $cashboxMovement->folio_cash->id]) : '' ?></td>
                    <td><?= $this->Number->format($cashboxMovement->tipo_pago) ?></td>
                    <td><?= $this->Number->format($cashboxMovement->monto) ?></td>
                    <td><?= h($cashboxMovement->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cashboxMovement->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cashboxMovement->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cashboxMovement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cashboxMovement->id)]) ?>
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
