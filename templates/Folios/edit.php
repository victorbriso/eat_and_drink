<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folio $folio
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $folio->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $folio->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Folios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="folios form content">
            <?= $this->Form->create($folio) ?>
            <fieldset>
                <legend><?= __('Edit Folio') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('tipo');
                    echo $this->Form->control('folio');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
