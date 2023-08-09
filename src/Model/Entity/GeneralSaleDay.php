<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GeneralSaleDay Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenDate|null $dia
 * @property string|null $monto
 *
 * @property \App\Model\Entity\User $user
 */
class GeneralSaleDay extends Entity
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
        'dia' => true,
        'monto' => true,
        'user' => true,
    ];
}
