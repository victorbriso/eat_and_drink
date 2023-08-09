<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cashbox $cashbox
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cashbox'), ['action' => 'edit', $cashbox->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cashbox'), ['action' => 'delete', $cashbox->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cashbox->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cashboxes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cashbox'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cashboxes view content">
            <h3><?= h($cashbox->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cashbox->has('user') ? $this->Html->link($cashbox->user->id, ['controller' => 'Users', 'action' => 'view', $cashbox->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Salon') ?></th>
                    <td><?= $cashbox->has('salon') ? $this->Html->link($cashbox->salon->id, ['controller' => 'Salons', 'action' => 'view', $cashbox->salon->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($cashbox->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Usuario') ?></th>
                    <td><?= $cashbox->has('usuario') ? $this->Html->link($cashbox->usuario->id, ['controller' => 'Usuarios', 'action' => 'view', $cashbox->usuario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cashbox->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $this->Number->format($cashbox->estado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($cashbox->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Efectivo') ?></th>
                    <td><?= $this->Number->format($cashbox->efectivo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monto Apertura') ?></th>
                    <td><?= $this->Number->format($cashbox->monto_apertura) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Apertura') ?></th>
                    <td><?= h($cashbox->fecha_apertura) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cashbox Movements') ?></h4>
                <?php if (!empty($cashbox->cashbox_movements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Cashbox Id') ?></th>
                            <th><?= __('Folio Cash Id') ?></th>
                            <th><?= __('Tipo Pago') ?></th>
                            <th><?= __('Monto') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($cashbox->cashbox_movements as $cashboxMovements) : ?>
                        <tr>
                            <td><?= h($cashboxMovements->id) ?></td>
                            <td><?= h($cashboxMovements->user_id) ?></td>
                            <td><?= h($cashboxMovements->cashbox_id) ?></td>
                            <td><?= h($cashboxMovements->folio_cash_id) ?></td>
                            <td><?= h($cashboxMovements->tipo_pago) ?></td>
                            <td><?= h($cashboxMovements->monto) ?></td>
                            <td><?= h($cashboxMovements->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CashboxMovements', 'action' => 'view', $cashboxMovements->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CashboxMovements', 'action' => 'edit', $cashboxMovements->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CashboxMovements', 'action' => 'delete', $cashboxMovements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cashboxMovements->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
