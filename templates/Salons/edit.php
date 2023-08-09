<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salon $salon
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $salon->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $salon->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Salons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salons form content">
            <?= $this->Form->create($salon) ?>
            <fieldset>
                <legend><?= __('Edit Salon') ?></legend>
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
