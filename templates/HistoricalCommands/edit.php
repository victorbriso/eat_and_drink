<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalCommand $historicalCommand
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $historicalCommand->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $historicalCommand->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Historical Commands'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="historicalCommands form content">
            <?= $this->Form->create($historicalCommand) ?>
            <fieldset>
                <legend><?= __('Edit Historical Command') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('usuario_id', ['options' => $usuarios, 'empty' => true]);
                    echo $this->Form->control('folio_comanda');
                    echo $this->Form->control('inicio', ['empty' => true]);
                    echo $this->Form->control('termino', ['empty' => true]);
                    echo $this->Form->control('productos');
                    echo $this->Form->control('total');
                    echo $this->Form->control('data_comanda');
                    echo $this->Form->control('data_pedidos');
                    echo $this->Form->control('data_pago');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
