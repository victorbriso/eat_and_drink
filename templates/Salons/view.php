<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salon $salon
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Salon'), ['action' => 'edit', $salon->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Salon'), ['action' => 'delete', $salon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salon->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Salons'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Salon'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salons view content">
            <h3><?= h($salon->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $salon->has('user') ? $this->Html->link($salon->user->id, ['controller' => 'Users', 'action' => 'view', $salon->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($salon->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($salon->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $this->Number->format($salon->estado) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cashboxes') ?></h4>
                <?php if (!empty($salon->cashboxes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Salon Id') ?></th>
                            <th><?= __('Nombre') ?></th>
                            <th><?= __('Estado') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Efectivo') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Monto Apertura') ?></th>
                            <th><?= __('Fecha Apertura') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($salon->cashboxes as $cashboxes) : ?>
                        <tr>
                            <td><?= h($cashboxes->id) ?></td>
                            <td><?= h($cashboxes->user_id) ?></td>
                            <td><?= h($cashboxes->salon_id) ?></td>
                            <td><?= h($cashboxes->nombre) ?></td>
                            <td><?= h($cashboxes->estado) ?></td>
                            <td><?= h($cashboxes->total) ?></td>
                            <td><?= h($cashboxes->efectivo) ?></td>
                            <td><?= h($cashboxes->usuario_id) ?></td>
                            <td><?= h($cashboxes->monto_apertura) ?></td>
                            <td><?= h($cashboxes->fecha_apertura) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Cashboxes', 'action' => 'view', $cashboxes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Cashboxes', 'action' => 'edit', $cashboxes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cashboxes', 'action' => 'delete', $cashboxes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cashboxes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Comandas') ?></h4>
                <?php if (!empty($salon->comandas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Salon Id') ?></th>
                            <th><?= __('Table Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Folio') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Pagado') ?></th>
                            <th><?= __('Clientes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($salon->comandas as $comandas) : ?>
                        <tr>
                            <td><?= h($comandas->id) ?></td>
                            <td><?= h($comandas->user_id) ?></td>
                            <td><?= h($comandas->salon_id) ?></td>
                            <td><?= h($comandas->table_id) ?></td>
                            <td><?= h($comandas->usuario_id) ?></td>
                            <td><?= h($comandas->folio) ?></td>
                            <td><?= h($comandas->total) ?></td>
                            <td><?= h($comandas->pagado) ?></td>
                            <td><?= h($comandas->clientes) ?></td>
                            <td><?= h($comandas->created) ?></td>
                            <td><?= h($comandas->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Comandas', 'action' => 'view', $comandas->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Comandas', 'action' => 'edit', $comandas->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comandas', 'action' => 'delete', $comandas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comandas->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tables') ?></h4>
                <?php if (!empty($salon->tables)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Salon Id') ?></th>
                            <th><?= __('Numero') ?></th>
                            <th><?= __('Nombre') ?></th>
                            <th><?= __('Ocupado') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Notificacion') ?></th>
                            <th><?= __('Codigo') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($salon->tables as $tables) : ?>
                        <tr>
                            <td><?= h($tables->id) ?></td>
                            <td><?= h($tables->user_id) ?></td>
                            <td><?= h($tables->salon_id) ?></td>
                            <td><?= h($tables->numero) ?></td>
                            <td><?= h($tables->nombre) ?></td>
                            <td><?= h($tables->ocupado) ?></td>
                            <td><?= h($tables->modified) ?></td>
                            <td><?= h($tables->notificacion) ?></td>
                            <td><?= h($tables->codigo) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tables', 'action' => 'view', $tables->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tables', 'action' => 'edit', $tables->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tables', 'action' => 'delete', $tables->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tables->id)]) ?>
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
