<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FolioCash $folioCash
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Folio Cashes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="folioCashes form content">
            <?= $this->Form->create($folioCash) ?>
            <fieldset>
                <legend><?= __('Add Folio Cash') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('folio');
                    echo $this->Form->control('monto');
                    echo $this->Form->control('pagado');
                    echo $this->Form->control('fecha_pago', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
