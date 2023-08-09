<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PriceListControl $priceListControl
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Price List Control'), ['action' => 'edit', $priceListControl->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Price List Control'), ['action' => 'delete', $priceListControl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $priceListControl->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Price List Controls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Price List Control'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="priceListControls view content">
            <h3><?= h($priceListControl->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $priceListControl->has('user') ? $this->Html->link($priceListControl->user->id, ['controller' => 'Users', 'action' => 'view', $priceListControl->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($priceListControl->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($priceListControl->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $this->Number->format($priceListControl->estado) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
