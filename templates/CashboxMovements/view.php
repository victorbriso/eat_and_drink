<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashboxMovement $cashboxMovement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cashbox Movement'), ['action' => 'edit', $cashboxMovement->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cashbox Movement'), ['action' => 'delete', $cashboxMovement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cashboxMovement->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cashbox Movements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cashbox Movement'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cashboxMovements view content">
            <h3><?= h($cashboxMovement->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cashboxMovement->has('user') ? $this->Html->link($cashboxMovement->user->id, ['controller' => 'Users', 'action' => 'view', $cashboxMovement->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Cashbox') ?></th>
                    <td><?= $cashboxMovement->has('cashbox') ? $this->Html->link($cashboxMovement->cashbox->id, ['controller' => 'Cashboxes', 'action' => 'view', $cashboxMovement->cashbox->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Folio Cash') ?></th>
                    <td><?= $cashboxMovement->has('folio_cash') ? $this->Html->link($cashboxMovement->folio_cash->id, ['controller' => 'FolioCashes', 'action' => 'view', $cashboxMovement->folio_cash->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cashboxMovement->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Pago') ?></th>
                    <td><?= $this->Number->format($cashboxMovement->tipo_pago) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monto') ?></th>
                    <td><?= $this->Number->format($cashboxMovement->monto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($cashboxMovement->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
