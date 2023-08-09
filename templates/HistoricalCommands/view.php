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
            <?= $this->Html->link(__('Edit Historical Command'), ['action' => 'edit', $historicalCommand->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Historical Command'), ['action' => 'delete', $historicalCommand->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicalCommand->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Historical Commands'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Historical Command'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="historicalCommands view content">
            <h3><?= h($historicalCommand->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $historicalCommand->has('user') ? $this->Html->link($historicalCommand->user->id, ['controller' => 'Users', 'action' => 'view', $historicalCommand->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Usuario') ?></th>
                    <td><?= $historicalCommand->has('usuario') ? $this->Html->link($historicalCommand->usuario->id, ['controller' => 'Usuarios', 'action' => 'view', $historicalCommand->usuario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($historicalCommand->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Folio Comanda') ?></th>
                    <td><?= $this->Number->format($historicalCommand->folio_comanda) ?></td>
                </tr>
                <tr>
                    <th><?= __('Productos') ?></th>
                    <td><?= $this->Number->format($historicalCommand->productos) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($historicalCommand->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inicio') ?></th>
                    <td><?= h($historicalCommand->inicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Termino') ?></th>
                    <td><?= h($historicalCommand->termino) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Data Comanda') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalCommand->data_comanda)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Data Pedidos') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalCommand->data_pedidos)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Data Pago') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($historicalCommand->data_pago)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
