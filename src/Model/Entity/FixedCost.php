<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FixedCost Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $freciencia
 * @property string|null $concepto
 * @property string|null $monto
 * @property string|null $diario
 *
 * @property \App\Model\Entity\User $user
 */
class FixedCost extends Entity
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
        'freciencia' => true,
        'concepto' => true,
        'monto' => true,
        'diario' => true,
        'user' => true,
    ];
}
