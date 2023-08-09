<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FolioCash[]|\Cake\Collection\CollectionInterface $folioCashes
 */
?>
<div class="folioCashes index content">
    <?= $this->Html->link(__('New Folio Cash'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Folio Cashes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('folio') ?></th>
                    <th><?= $this->Paginator->sort('monto') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('pagado') ?></th>
                    <th><?= $this->Paginator->sort('fecha_pago') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($folioCashes as $folioCash): ?>
                <tr>
                    <td><?= $this->Number->format($folioCash->id) ?></td>
                    <td><?= $folioCash->has('user') ? $this->Html->link($folioCash->user->id, ['controller' => 'Users', 'action' => 'view', $folioCash->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($folioCash->folio) ?></td>
                    <td><?= $this->Number->format($folioCash->monto) ?></td>
                    <td><?= h($folioCash->created) ?></td>
                    <td><?= $this->Number->format($folioCash->pagado) ?></td>
                    <td><?= h($folioCash->fecha_pago) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $folioCash->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $folioCash->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $folioCash->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folioCash->id)]) ?>
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
