<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<div class="orders index content">
    <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Orders') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('folio_cash_id') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('precio') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('pagado') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('impreso') ?></th>
                    <th><?= $this->Paginator->sort('despachado') ?></th>
                    <th><?= $this->Paginator->sort('cliente') ?></th>
                    <th><?= $this->Paginator->sort('descuento') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $this->Number->format($order->id) ?></td>
                    <td><?= $order->has('user') ? $this->Html->link($order->user->id, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                    <td><?= $order->has('product') ? $this->Html->link($order->product->id, ['controller' => 'Products', 'action' => 'view', $order->product->id]) : '' ?></td>
                    <td><?= $order->has('folio_cash') ? $this->Html->link($order->folio_cash->id, ['controller' => 'FolioCashes', 'action' => 'view', $order->folio_cash->id]) : '' ?></td>
                    <td><?= $this->Number->format($order->cantidad) ?></td>
                    <td><?= $this->Number->format($order->precio) ?></td>
                    <td><?= $this->Number->format($order->total) ?></td>
                    <td><?= $this->Number->format($order->pagado) ?></td>
                    <td><?= $this->Number->format($order->tipo) ?></td>
                    <td><?= h($order->created) ?></td>
                    <td><?= h($order->impreso) ?></td>
                    <td><?= h($order->despachado) ?></td>
                    <td><?= h($order->cliente) ?></td>
                    <td><?= $this->Number->format($order->descuento) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $order->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $order->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]) ?>
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
