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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $priceListControl->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $priceListControl->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Price List Controls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="priceListControls form content">
            <?= $this->Form->create($priceListControl) ?>
            <fieldset>
                <legend><?= __('Edit Price List Control') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('nombre');
                    echo $this->Form->control('estado');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
