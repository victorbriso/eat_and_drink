<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PriceList Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $price_lists_control_id
 * @property int|null $product_id
 * @property string|null $precio
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\PriceListControl $price_list_control
 * @property \App\Model\Entity\Product $product
 */
class PriceList extends Entity
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
        'price_lists_control_id' => true,
        'product_id' => true,
        'precio' => true,
        'user' => true,
        'price_list_control' => true,
        'product' => true,
    ];
}
