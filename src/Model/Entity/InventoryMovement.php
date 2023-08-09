<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryMovement Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property int|null $tipo_movimiento
 * @property int|null $cellar_id
 * @property string|null $cantidad
 * @property string|null $valor
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Cellar $cellar
 */
class InventoryMovement extends Entity
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
        'tipo_movimiento' => true,
        'cellar_id' => true,
        'cantidad' => true,
        'valor' => true,
        'user' => true,
        'product' => true,
        'cellar' => true,
    ];
}
