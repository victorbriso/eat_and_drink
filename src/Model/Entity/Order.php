<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property int|null $folio_cash_id
 * @property int|null $cantidad
 * @property string|null $precio
 * @property string|null $total
 * @property string|null $pagado
 * @property int|null $tipo
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $agregados
 * @property string|null $quetados
 * @property bool|null $impreso
 * @property bool|null $despachado
 * @property string|null $cliente
 * @property string|null $descuento
 * @property string|null $data_dcto
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\FolioCash $folio_cash
 */
class Order extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'product_id' => true,
        'folio_cash_id' => true,
        'comanda_id' => true,
        'cantidad' => true,
        'precio' => true,
        'total' => true,
        'pagado' => true,
        'tipo' => true,
        'created' => true,
        'agregados' => true,
        'quetados' => true,
        'impreso' => true,
        'despachado' => true,
        'cliente' => true,
        'descuento' => true,
        'data_dcto' => true,
        'bool_pagado' => true,
        'user' => true,
        'product' => true,
        'folio_cash' => true,
        'comanda' => true,
    ];
}
