<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Booking Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $table_id
 * @property int|null $costomer_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $hora_entrada
 * @property \Cake\I18n\FrozenTime|null $hora_salida
 * @property string|null $abono
 * @property int|null $estado
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Table $table
 * @property \App\Model\Entity\Customer $customer
 */
class Booking extends Entity
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
        'table_id' => true,
        'costomer_id' => true,
        'created' => true,
        'modified' => true,
        'hora_entrada' => true,
        'hora_salida' => true,
        'abono' => true,
        'estado' => true,
        'user' => true,
        'table' => true,
        'customer' => true,
    ];
}
