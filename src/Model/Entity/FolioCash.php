<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FolioCash Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $folio
 * @property string|null $monto
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $pagado
 * @property \Cake\I18n\FrozenTime|null $fecha_pago
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\CashboxMovement[] $cashbox_movements
 * @property \App\Model\Entity\Order[] $orders
 */
class FolioCash extends Entity
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
        'folio' => true,
        'monto' => true,
        'created' => true,
        'pagado' => true,
        'fecha_pago' => true,
        'user' => true,
        'cashbox_movements' => true,
        'orders' => true,
    ];
}
