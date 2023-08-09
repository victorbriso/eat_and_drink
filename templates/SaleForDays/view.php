<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleForDay $saleForDay
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sale For Day'), ['action' => 'edit', $saleForDay->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sale For Day'), ['action' => 'delete', $saleForDay->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleForDay->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sale For Days'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sale For Day'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="saleForDays view content">
            <h3><?= h($saleForDay->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $saleForDay->has('user') ? $this->Html->link($saleForDay->user->id, ['controller' => 'Users', 'action' => 'view', $saleForDay->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $saleForDay->has('product') ? $this->Html->link($saleForDay->product->id, ['controller' => 'Products', 'action' => 'view', $saleForDay->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($saleForDay->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($saleForDay->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Valor') ?></th>
                    <td><?= $this->Number->format($saleForDay->valor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($saleForDay->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dia') ?></th>
                    <td><?= h($saleForDay->dia) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
