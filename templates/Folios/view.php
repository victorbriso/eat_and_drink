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
            <?= $this->Html->link(__('Edit Folio'), ['action' => 'edit', $folio->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Folio'), ['action' => 'delete', $folio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folio->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Folios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Folio'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="folios view content">
            <h3><?= h($folio->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $folio->has('user') ? $this->Html->link($folio->user->id, ['controller' => 'Users', 'action' => 'view', $folio->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($folio->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= $this->Number->format($folio->tipo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Folio') ?></th>
                    <td><?= $this->Number->format($folio->folio) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
