<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FolioCash $folioCash
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Folio Cash'), ['action' => 'edit', $folioCash->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Folio Cash'), ['action' => 'delete', $folioCash->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folioCash->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Folio Cashes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Folio Cash'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="folioCashes view content">
            <h3><?= h($folioCash->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $folioCash->has('user') ? $this->Html->link($folioCash->user->id, ['controller' => 'Users', 'action' => 'view', $folioCash->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($folioCash->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Folio') ?></th>
                    <td><?= $this->Number->format($folioCash->folio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monto') ?></th>
                    <td><?= $this->Number->format($folioCash->monto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pagado') ?></th>
                    <td><?= $this->Number->format($folioCash->pagado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($folioCash->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Pago') ?></th>
                    <td><?= h($folioCash->fecha_pago) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cashbox Movements') ?></h4>
                <?php if (!empty($folioCash->cashbox_movements)) : ?>
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
                        <?php foreach ($folioCash->cashbox_movements as $cashboxMovements) : ?>
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
            <div class="related">
                <h4><?= __('Related Orders') ?></h4>
                <?php if (!empty($folioCash->orders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Folio Cash Id') ?></th>
                            <th><?= __('Cantidad') ?></th>
                            <th><?= __('Precio') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Pagado') ?></th>
                            <th><?= __('Tipo') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Agregados') ?></th>
                            <th><?= __('Quetados') ?></th>
                            <th><?= __('Impreso') ?></th>
                            <th><?= __('Despachado') ?></th>
                            <th><?= __('Cliente') ?></th>
                            <th><?= __('Descuento') ?></th>
                            <th><?= __('Data Dcto') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($folioCash->orders as $orders) : ?>
                        <tr>
                            <td><?= h($orders->id) ?></td>
                            <td><?= h($orders->user_id) ?></td>
                            <td><?= h($orders->product_id) ?></td>
                            <td><?= h($orders->folio_cash_id) ?></td>
                            <td><?= h($orders->cantidad) ?></td>
                            <td><?= h($orders->precio) ?></td>
                            <td><?= h($orders->total) ?></td>
                            <td><?= h($orders->pagado) ?></td>
                            <td><?= h($orders->tipo) ?></td>
                            <td><?= h($orders->created) ?></td>
                            <td><?= h($orders->agregados) ?></td>
                            <td><?= h($orders->quetados) ?></td>
                            <td><?= h($orders->impreso) ?></td>
                            <td><?= h($orders->despachado) ?></td>
                            <td><?= h($orders->cliente) ?></td>
                            <td><?= h($orders->descuento) ?></td>
                            <td><?= h($orders->data_dcto) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
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
