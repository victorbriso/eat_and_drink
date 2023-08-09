<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cancellation[]|\Cake\Collection\CollectionInterface $cancellations
 */
?>
<div class="cancellations index content">
    <?= $this->Html->link(__('New Cancellation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cancellations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('usuario_id') ?></th>
                    <th><?= $this->Paginator->sort('motivo') ?></th>
                    <th><?= $this->Paginator->sort('comentario') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cancellations as $cancellation): ?>
                <tr>
                    <td><?= $this->Number->format($cancellation->id) ?></td>
                    <td><?= $cancellation->has('user') ? $this->Html->link($cancellation->user->id, ['controller' => 'Users', 'action' => 'view', $cancellation->user->id]) : '' ?></td>
                    <td><?= $cancellation->has('usuario') ? $this->Html->link($cancellation->usuario->id, ['controller' => 'Usuarios', 'action' => 'view', $cancellation->usuario->id]) : '' ?></td>
                    <td><?= $this->Number->format($cancellation->motivo) ?></td>
                    <td><?= h($cancellation->comentario) ?></td>
                    <td><?= h($cancellation->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cancellation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cancellation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cancellation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cancellation->id)]) ?>
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
