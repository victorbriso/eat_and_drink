<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Salon Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $nombre
 * @property int|null $estado
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Cashbox[] $cashboxes
 * @property \App\Model\Entity\Comanda[] $comandas
 * @property \App\Model\Entity\Table[] $tables
 */
class Salon extends Entity
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
        'nombre' => true,
        'estado' => true,
        'user' => true,
        'cashboxes' => true,
        'comandas' => true,
        'tables' => true,
    ];
}
