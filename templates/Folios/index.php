<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folio[]|\Cake\Collection\CollectionInterface $folios
 */
?>
<div class="folios index content">
    <?= $this->Html->link(__('New Folio'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Folios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('folio') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($folios as $folio): ?>
                <tr>
                    <td><?= $this->Number->format($folio->id) ?></td>
                    <td><?= $folio->has('user') ? $this->Html->link($folio->user->id, ['controller' => 'Users', 'action' => 'view', $folio->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($folio->tipo) ?></td>
                    <td><?= $this->Number->format($folio->folio) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $folio->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $folio->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $folio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folio->id)]) ?>
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
