<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleForDay[]|\Cake\Collection\CollectionInterface $saleForDays
 */
?>
<div class="saleForDays index content">
    <?= $this->Html->link(__('New Sale For Day'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sale For Days') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('valor') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('dia') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($saleForDays as $saleForDay): ?>
                <tr>
                    <td><?= $this->Number->format($saleForDay->id) ?></td>
                    <td><?= $saleForDay->has('user') ? $this->Html->link($saleForDay->user->id, ['controller' => 'Users', 'action' => 'view', $saleForDay->user->id]) : '' ?></td>
                    <td><?= $saleForDay->has('product') ? $this->Html->link($saleForDay->product->id, ['controller' => 'Products', 'action' => 'view', $saleForDay->product->id]) : '' ?></td>
                    <td><?= $this->Number->format($saleForDay->cantidad) ?></td>
                    <td><?= $this->Number->format($saleForDay->valor) ?></td>
                    <td><?= $this->Number->format($saleForDay->total) ?></td>
                    <td><?= h($saleForDay->dia) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $saleForDay->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $saleForDay->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $saleForDay->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleForDay->id)]) ?>
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
