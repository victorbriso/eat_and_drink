<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PlaceElaboration $placeElaboration
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Place Elaboration'), ['action' => 'edit', $placeElaboration->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Place Elaboration'), ['action' => 'delete', $placeElaboration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $placeElaboration->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Place Elaborations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Place Elaboration'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="placeElaborations view content">
            <h3><?= h($placeElaboration->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $placeElaboration->has('user') ? $this->Html->link($placeElaboration->user->id, ['controller' => 'Users', 'action' => 'view', $placeElaboration->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($placeElaboration->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Impresora') ?></th>
                    <td><?= h($placeElaboration->impresora) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($placeElaboration->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Products') ?></h4>
                <?php if (!empty($placeElaboration->products)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Category Id') ?></th>
                            <th><?= __('Nombre') ?></th>
                            <th><?= __('Estado') ?></th>
                            <th><?= __('Tipo') ?></th>
                            <th><?= __('Precio Anterior') ?></th>
                            <th><?= __('Precio Actual') ?></th>
                            <th><?= __('Proximo Precio') ?></th>
                            <th><?= __('Data Combo') ?></th>
                            <th><?= __('Divisible') ?></th>
                            <th><?= __('Receta') ?></th>
                            <th><?= __('Desc Es') ?></th>
                            <th><?= __('Descripciones') ?></th>
                            <th><?= __('Nombres') ?></th>
                            <th><?= __('Place Elaboration Id') ?></th>
                            <th><?= __('Precio Base') ?></th>
                            <th><?= __('Extension') ?></th>
                            <th><?= __('Agotado') ?></th>
                            <th><?= __('Req Receta') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($placeElaboration->products as $products) : ?>
                        <tr>
                            <td><?= h($products->id) ?></td>
                            <td><?= h($products->user_id) ?></td>
                            <td><?= h($products->category_id) ?></td>
                            <td><?= h($products->nombre) ?></td>
                            <td><?= h($products->estado) ?></td>
                            <td><?= h($products->tipo) ?></td>
                            <td><?= h($products->precio_anterior) ?></td>
                            <td><?= h($products->precio_actual) ?></td>
                            <td><?= h($products->proximo_precio) ?></td>
                            <td><?= h($products->data_combo) ?></td>
                            <td><?= h($products->divisible) ?></td>
                            <td><?= h($products->receta) ?></td>
                            <td><?= h($products->desc_es) ?></td>
                            <td><?= h($products->descripciones) ?></td>
                            <td><?= h($products->nombres) ?></td>
                            <td><?= h($products->place_elaboration_id) ?></td>
                            <td><?= h($products->precio_base) ?></td>
                            <td><?= h($products->extension) ?></td>
                            <td><?= h($products->agotado) ?></td>
                            <td><?= h($products->req_receta) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Products', 'action' => 'view', $products->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Products', 'action' => 'edit', $products->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Products', 'action' => 'delete', $products->id], ['confirm' => __('Are you sure you want to delete # {0}?', $products->id)]) ?>
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
