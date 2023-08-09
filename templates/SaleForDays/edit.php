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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $saleForDay->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $saleForDay->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Sale For Days'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="saleForDays form content">
            <?= $this->Form->create($saleForDay) ?>
            <fieldset>
                <legend><?= __('Edit Sale For Day') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('valor');
                    echo $this->Form->control('total');
                    echo $this->Form->control('dia', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
