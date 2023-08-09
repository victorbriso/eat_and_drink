<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BuyDetail[]|\Cake\Collection\CollectionInterface $buyDetails
 */
?>
<div class="buyDetails index content">
    <?= $this->Html->link(__('New Buy Detail'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Buy Details') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('buy_summary_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('neto') ?></th>
                    <th><?= $this->Paginator->sort('bruto') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buyDetails as $buyDetail): ?>
                <tr>
                    <td><?= $this->Number->format($buyDetail->id) ?></td>
                    <td><?= $buyDetail->has('user') ? $this->Html->link($buyDetail->user->id, ['controller' => 'Users', 'action' => 'view', $buyDetail->user->id]) : '' ?></td>
                    <td><?= $buyDetail->has('buy_summary') ? $this->Html->link($buyDetail->buy_summary->id, ['controller' => 'BuySummaries', 'action' => 'view', $buyDetail->buy_summary->id]) : '' ?></td>
                    <td><?= $buyDetail->has('product') ? $this->Html->link($buyDetail->product->id, ['controller' => 'Products', 'action' => 'view', $buyDetail->product->id]) : '' ?></td>
                    <td><?= $this->Number->format($buyDetail->cantidad) ?></td>
                    <td><?= $this->Number->format($buyDetail->neto) ?></td>
                    <td><?= $this->Number->format($buyDetail->bruto) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $buyDetail->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $buyDetail->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $buyDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $buyDetail->id)]) ?>
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
