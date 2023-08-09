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
            <?= $this->Html->link(__('List Cashbox Movements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cashboxMovements form content">
            <?= $this->Form->create($cashboxMovement) ?>
            <fieldset>
                <legend><?= __('Add Cashbox Movement') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('cashbox_id', ['options' => $cashboxes, 'empty' => true]);
                    echo $this->Form->control('folio_cash_id', ['options' => $folioCashes, 'empty' => true]);
                    echo $this->Form->control('tipo_pago');
                    echo $this->Form->control('monto');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
