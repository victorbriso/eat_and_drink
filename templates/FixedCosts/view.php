<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FixedCost $fixedCost
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Fixed Cost'), ['action' => 'edit', $fixedCost->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Fixed Cost'), ['action' => 'delete', $fixedCost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fixedCost->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Fixed Costs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Fixed Cost'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="fixedCosts view content">
            <h3><?= h($fixedCost->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $fixedCost->has('user') ? $this->Html->link($fixedCost->user->id, ['controller' => 'Users', 'action' => 'view', $fixedCost->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Concepto') ?></th>
                    <td><?= h($fixedCost->concepto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($fixedCost->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Freciencia') ?></th>
                    <td><?= $this->Number->format($fixedCost->freciencia) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monto') ?></th>
                    <td><?= $this->Number->format($fixedCost->monto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Diario') ?></th>
                    <td><?= $this->Number->format($fixedCost->diario) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
