<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SaleForDay Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property int|null $cantidad
 * @property string|null $valor
 * @property string|null $total
 * @property \Cake\I18n\FrozenDate|null $dia
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 */
class SaleForDay extends Entity
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
        'cantidad' => true,
        'valor' => true,
        'total' => true,
        'dia' => true,
        'user' => true,
        'product' => true,
    ];
}
