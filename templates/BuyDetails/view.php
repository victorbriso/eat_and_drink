<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BuyDetail $buyDetail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Buy Detail'), ['action' => 'edit', $buyDetail->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Buy Detail'), ['action' => 'delete', $buyDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $buyDetail->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Buy Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Buy Detail'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="buyDetails view content">
            <h3><?= h($buyDetail->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $buyDetail->has('user') ? $this->Html->link($buyDetail->user->id, ['controller' => 'Users', 'action' => 'view', $buyDetail->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Buy Summary') ?></th>
                    <td><?= $buyDetail->has('buy_summary') ? $this->Html->link($buyDetail->buy_summary->id, ['controller' => 'BuySummaries', 'action' => 'view', $buyDetail->buy_summary->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $buyDetail->has('product') ? $this->Html->link($buyDetail->product->id, ['controller' => 'Products', 'action' => 'view', $buyDetail->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($buyDetail->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($buyDetail->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Neto') ?></th>
                    <td><?= $this->Number->format($buyDetail->neto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bruto') ?></th>
                    <td><?= $this->Number->format($buyDetail->bruto) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Impuestos') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($buyDetail->impuestos)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
