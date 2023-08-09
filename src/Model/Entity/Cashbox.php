<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cashbox Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $salon_id
 * @property string|null $nombre
 * @property int|null $estado
 * @property string|null $total
 * @property string|null $efectivo
 * @property int|null $usuario_id
 * @property string|null $monto_apertura
 * @property \Cake\I18n\FrozenTime|null $fecha_apertura
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Salon $salon
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\CashboxMovement[] $cashbox_movements
 */
class Cashbox extends Entity
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
        'salon_id' => true,
        'nombre' => true,
        'estado' => true,
        'total' => true,
        'efectivo' => true,
        'usuario_id' => true,
        'monto_apertura' => true,
        'fecha_apertura' => true,
        'user' => true,
        'salon' => true,
        'usuario' => true,
        'cashbox_movements' => true,
    ];
}
