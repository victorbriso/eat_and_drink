<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Table Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $salon_id
 * @property int|null $numero
 * @property string|null $nombre
 * @property int|null $ocupado
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $notificacion
 * @property int|null $codigo
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Salon $salon
 * @property \App\Model\Entity\Booking[] $bookings
 * @property \App\Model\Entity\Comanda[] $comandas
 */
class Table extends Entity
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
        'numero' => true,
        'nombre' => true,
        'ocupado' => true,
        'modified' => true,
        'notificacion' => true,
        'codigo' => true,
        'user' => true,
        'salon' => true,
        'bookings' => true,
        'comandas' => true,
    ];
}
