<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cancellation Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $usuario_id
 * @property int|null $motivo
 * @property string|null $comentario
 * @property \Cake\I18n\FrozenTime|null $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Usuario $usuario
 */
class Cancellation extends Entity
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
        'usuario_id' => true,
        'motivo' => true,
        'comentario' => true,
        'created' => true,
        'user' => true,
        'usuario' => true,
    ];
}
