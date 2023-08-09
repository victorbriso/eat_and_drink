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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $buyDetail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $buyDetail->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Buy Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="buyDetails form content">
            <?= $this->Form->create($buyDetail) ?>
            <fieldset>
                <legend><?= __('Edit Buy Detail') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('buy_summary_id', ['options' => $buySummaries, 'empty' => true]);
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('neto');
                    echo $this->Form->control('bruto');
                    echo $this->Form->control('impuestos');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
