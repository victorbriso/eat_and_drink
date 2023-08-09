<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comanda Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $salon_id
 * @property int|null $table_id
 * @property int|null $usuario_id
 * @property int|null $folio
 * @property string|null $total
 * @property string|null $pagado
 * @property string|null $clientes
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Salon $salon
 * @property \App\Model\Entity\Table $table
 * @property \App\Model\Entity\Usuario $usuario
 */
class Comanda extends Entity
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
        'table_id' => true,
        'usuario_id' => true,
        'folio' => true,
        'total' => true,
        'pagado' => true,
        'clientes' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'salon' => true,
        'table' => true,
        'usuario' => true,
    ];
}
