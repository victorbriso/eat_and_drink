<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceList[]|\Cake\Collection\CollectionInterface $priceLists
 */
?>
<div class="priceLists index content">
    <?= $this->Html->link(__('New Price List'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Price Lists') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('price_lists_control_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('precio') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($priceLists as $priceList): ?>
                <tr>
                    <td><?= $this->Number->format($priceList->id) ?></td>
                    <td><?= $priceList->has('user') ? $this->Html->link($priceList->user->id, ['controller' => 'Users', 'action' => 'view', $priceList->user->id]) : '' ?></td>
                    <td><?= $priceList->has('price_list_control') ? $this->Html->link($priceList->price_list_control->id, ['controller' => 'PriceListControls', 'action' => 'view', $priceList->price_list_control->id]) : '' ?></td>
                    <td><?= $priceList->has('product') ? $this->Html->link($priceList->product->id, ['controller' => 'Products', 'action' => 'view', $priceList->product->id]) : '' ?></td>
                    <td><?= $this->Number->format($priceList->precio) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $priceList->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $priceList->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $priceList->id], ['confirm' => __('Are you sure you want to delete # {0}?', $priceList->id)]) ?>
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
