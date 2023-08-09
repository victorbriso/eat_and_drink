<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlaceElaboration $placeElaboration
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Place Elaborations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="placeElaborations form content">
            <?= $this->Form->create($placeElaboration) ?>
            <fieldset>
                <legend><?= __('Add Place Elaboration') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('nombre');
                    echo $this->Form->control('impresora');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
