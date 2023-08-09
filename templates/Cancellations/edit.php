<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cancellation $cancellation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cancellation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cancellation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cancellations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cancellations form content">
            <?= $this->Form->create($cancellation) ?>
            <fieldset>
                <legend><?= __('Edit Cancellation') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('usuario_id', ['options' => $usuarios, 'empty' => true]);
                    echo $this->Form->control('motivo');
                    echo $this->Form->control('comentario');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
