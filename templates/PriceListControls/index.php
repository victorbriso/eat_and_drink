<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceListControl[]|\Cake\Collection\CollectionInterface $priceListControls
 */
?>
<div class="priceListControls index content">
    <?= $this->Html->link(__('New Price List Control'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Price List Controls') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('nombre') ?></th>
                    <th><?= $this->Paginator->sort('estado') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($priceListControls as $priceListControl): ?>
                <tr>
                    <td><?= $this->Number->format($priceListControl->id) ?></td>
                    <td><?= $priceListControl->has('user') ? $this->Html->link($priceListControl->user->id, ['controller' => 'Users', 'action' => 'view', $priceListControl->user->id]) : '' ?></td>
                    <td><?= h($priceListControl->nombre) ?></td>
                    <td><?= $this->Number->format($priceListControl->estado) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $priceListControl->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $priceListControl->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $priceListControl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $priceListControl->id)]) ?>
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
