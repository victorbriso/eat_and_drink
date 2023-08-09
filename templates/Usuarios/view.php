<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usuario $usuario
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Usuario'), ['action' => 'edit', $usuario->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Usuario'), ['action' => 'delete', $usuario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usuario->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Usuarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Usuario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usuarios view content">
            <h3><?= h($usuario->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $usuario->has('user') ? $this->Html->link($usuario->user->id, ['controller' => 'Users', 'action' => 'view', $usuario->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Profile') ?></th>
                    <td><?= $usuario->has('profile') ? $this->Html->link($usuario->profile->id, ['controller' => 'Profiles', 'action' => 'view', $usuario->profile->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombres') ?></th>
                    <td><?= h($usuario->nombres) ?></td>
                </tr>
                <tr>
                    <th><?= __('Apellidos') ?></th>
                    <td><?= h($usuario->apellidos) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($usuario->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mail') ?></th>
                    <td><?= h($usuario->mail) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($usuario->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cancellations') ?></h4>
                <?php if (!empty($usuario->cancellations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Motivo') ?></th>
                            <th><?= __('Comentario') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->cancellations as $cancellations) : ?>
                        <tr>
                            <td><?= h($cancellations->id) ?></td>
                            <td><?= h($cancellations->user_id) ?></td>
                            <td><?= h($cancellations->usuario_id) ?></td>
                            <td><?= h($cancellations->motivo) ?></td>
                            <td><?= h($cancellations->comentario) ?></td>
                            <td><?= h($cancellations->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Cancellations', 'action' => 'view', $cancellations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Cancellations', 'action' => 'edit', $cancellations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cancellations', 'action' => 'delete', $cancellations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cancellations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Cashboxes') ?></h4>
                <?php if (!empty($usuario->cashboxes)) : ?>
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
                        <?php foreach ($usuario->cashboxes as $cashboxes) : ?>
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
                <?php if (!empty($usuario->comandas)) : ?>
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
                        <?php foreach ($usuario->comandas as $comandas) : ?>
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
                <h4><?= __('Related Historical Commands') ?></h4>
                <?php if (!empty($usuario->historical_commands)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Folio Comanda') ?></th>
                            <th><?= __('Inicio') ?></th>
                            <th><?= __('Termino') ?></th>
                            <th><?= __('Productos') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Data Comanda') ?></th>
                            <th><?= __('Data Pedidos') ?></th>
                            <th><?= __('Data Pago') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($usuario->historical_commands as $historicalCommands) : ?>
                        <tr>
                            <td><?= h($historicalCommands->id) ?></td>
                            <td><?= h($historicalCommands->user_id) ?></td>
                            <td><?= h($historicalCommands->usuario_id) ?></td>
                            <td><?= h($historicalCommands->folio_comanda) ?></td>
                            <td><?= h($historicalCommands->inicio) ?></td>
                            <td><?= h($historicalCommands->termino) ?></td>
                            <td><?= h($historicalCommands->productos) ?></td>
                            <td><?= h($historicalCommands->total) ?></td>
                            <td><?= h($historicalCommands->data_comanda) ?></td>
                            <td><?= h($historicalCommands->data_pedidos) ?></td>
                            <td><?= h($historicalCommands->data_pago) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'HistoricalCommands', 'action' => 'view', $historicalCommands->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'HistoricalCommands', 'action' => 'edit', $historicalCommands->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'HistoricalCommands', 'action' => 'delete', $historicalCommands->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicalCommands->id)]) ?>
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
