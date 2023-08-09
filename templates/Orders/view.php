<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orders view content">
            <h3><?= h($order->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $order->has('user') ? $this->Html->link($order->user->id, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $order->has('product') ? $this->Html->link($order->product->id, ['controller' => 'Products', 'action' => 'view', $order->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Folio Cash') ?></th>
                    <td><?= $order->has('folio_cash') ? $this->Html->link($order->folio_cash->id, ['controller' => 'FolioCashes', 'action' => 'view', $order->folio_cash->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Cliente') ?></th>
                    <td><?= h($order->cliente) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($order->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($order->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Precio') ?></th>
                    <td><?= $this->Number->format($order->precio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($order->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pagado') ?></th>
                    <td><?= $this->Number->format($order->pagado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= $this->Number->format($order->tipo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Descuento') ?></th>
                    <td><?= $this->Number->format($order->descuento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($order->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Impreso') ?></th>
                    <td><?= $order->impreso ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Despachado') ?></th>
                    <td><?= $order->despachado ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Agregados') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($order->agregados)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Quetados') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($order->quetados)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Data Dcto') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($order->data_dcto)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
