<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $profile_id
 * @property string|null $nombres
 * @property string|null $apellidos
 * @property string|null $password
 * @property string|null $mail
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Profile $profile
 * @property \App\Model\Entity\Cancellation[] $cancellations
 * @property \App\Model\Entity\Cashbox[] $cashboxes
 * @property \App\Model\Entity\Comanda[] $comandas
 * @property \App\Model\Entity\HistoricalCommand[] $historical_commands
 */
class Usuario extends Entity
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
        'profile_id' => true,
        'nombres' => true,
        'apellidos' => true,
        'password' => true,
        'mail' => true,
        'user' => true,
        'profile' => true,
        'cancellations' => true,
        'cashboxes' => true,
        'comandas' => true,
        'historical_commands' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}
