<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalCommand[]|\Cake\Collection\CollectionInterface $historicalCommands
 */
?>
<div class="historicalCommands index content">
    <?= $this->Html->link(__('New Historical Command'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Historical Commands') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('usuario_id') ?></th>
                    <th><?= $this->Paginator->sort('folio_comanda') ?></th>
                    <th><?= $this->Paginator->sort('inicio') ?></th>
                    <th><?= $this->Paginator->sort('termino') ?></th>
                    <th><?= $this->Paginator->sort('productos') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historicalCommands as $historicalCommand): ?>
                <tr>
                    <td><?= $this->Number->format($historicalCommand->id) ?></td>
                    <td><?= $historicalCommand->has('user') ? $this->Html->link($historicalCommand->user->id, ['controller' => 'Users', 'action' => 'view', $historicalCommand->user->id]) : '' ?></td>
                    <td><?= $historicalCommand->has('usuario') ? $this->Html->link($historicalCommand->usuario->id, ['controller' => 'Usuarios', 'action' => 'view', $historicalCommand->usuario->id]) : '' ?></td>
                    <td><?= $this->Number->format($historicalCommand->folio_comanda) ?></td>
                    <td><?= h($historicalCommand->inicio) ?></td>
                    <td><?= h($historicalCommand->termino) ?></td>
                    <td><?= $this->Number->format($historicalCommand->productos) ?></td>
                    <td><?= $this->Number->format($historicalCommand->total) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $historicalCommand->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $historicalCommand->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $historicalCommand->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicalCommand->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
