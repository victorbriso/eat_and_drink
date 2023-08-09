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
            <?= $this->Html->link(__('Edit Cancellation'), ['action' => 'edit', $cancellation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cancellation'), ['action' => 'delete', $cancellation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cancellation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cancellations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cancellation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cancellations view content">
            <h3><?= h($cancellation->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cancellation->has('user') ? $this->Html->link($cancellation->user->id, ['controller' => 'Users', 'action' => 'view', $cancellation->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Usuario') ?></th>
                    <td><?= $cancellation->has('usuario') ? $this->Html->link($cancellation->usuario->id, ['controller' => 'Usuarios', 'action' => 'view', $cancellation->usuario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Comentario') ?></th>
                    <td><?= h($cancellation->comentario) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cancellation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivo') ?></th>
                    <td><?= $this->Number->format($cancellation->motivo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($cancellation->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
