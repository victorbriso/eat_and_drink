<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceList $priceList
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Price List'), ['action' => 'edit', $priceList->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Price List'), ['action' => 'delete', $priceList->id], ['confirm' => __('Are you sure you want to delete # {0}?', $priceList->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Price Lists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Price List'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="priceLists view content">
            <h3><?= h($priceList->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $priceList->has('user') ? $this->Html->link($priceList->user->id, ['controller' => 'Users', 'action' => 'view', $priceList->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Price List Control') ?></th>
                    <td><?= $priceList->has('price_list_control') ? $this->Html->link($priceList->price_list_control->id, ['controller' => 'PriceListControls', 'action' => 'view', $priceList->price_list_control->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $priceList->has('product') ? $this->Html->link($priceList->product->id, ['controller' => 'Products', 'action' => 'view', $priceList->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($priceList->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Precio') ?></th>
                    <td><?= $this->Number->format($priceList->precio) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
