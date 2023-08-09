<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FixedCost $fixedCost
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Fixed Costs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="fixedCosts form content">
            <?= $this->Form->create($fixedCost) ?>
            <fieldset>
                <legend><?= __('Add Fixed Cost') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('freciencia');
                    echo $this->Form->control('concepto');
                    echo $this->Form->control('monto');
                    echo $this->Form->control('diario');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
