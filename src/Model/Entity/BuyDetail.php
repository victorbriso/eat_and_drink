<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BuyDetail Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $buy_summary_id
 * @property int|null $product_id
 * @property string|null $cantidad
 * @property string|null $neto
 * @property string|null $bruto
 * @property string|null $impuestos
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\BuySummary $buy_summary
 * @property \App\Model\Entity\Product $product
 */
class BuyDetail extends Entity
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
        'buy_summary_id' => true,
        'product_id' => true,
        'cantidad' => true,
        'neto' => true,
        'bruto' => true,
        'impuestos' => true,
        'user' => true,
        'buy_summary' => true,
        'product' => true,
    ];
}
