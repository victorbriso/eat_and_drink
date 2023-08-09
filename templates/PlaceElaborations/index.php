<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlaceElaboration[]|\Cake\Collection\CollectionInterface $placeElaborations
 */
?>
<div class="placeElaborations index content">
    <?= $this->Html->link(__('New Place Elaboration'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Place Elaborations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('nombre') ?></th>
                    <th><?= $this->Paginator->sort('impresora') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($placeElaborations as $placeElaboration): ?>
                <tr>
                    <td><?= $this->Number->format($placeElaboration->id) ?></td>
                    <td><?= $placeElaboration->has('user') ? $this->Html->link($placeElaboration->user->id, ['controller' => 'Users', 'action' => 'view', $placeElaboration->user->id]) : '' ?></td>
                    <td><?= h($placeElaboration->nombre) ?></td>
                    <td><?= h($placeElaboration->impresora) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $placeElaboration->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $placeElaboration->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $placeElaboration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $placeElaboration->id)]) ?>
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
