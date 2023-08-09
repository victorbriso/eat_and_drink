<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HistoricalCommand Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $usuario_id
 * @property int|null $folio_comanda
 * @property \Cake\I18n\FrozenTime|null $inicio
 * @property \Cake\I18n\FrozenTime|null $termino
 * @property int|null $productos
 * @property string|null $total
 * @property string|null $data_comanda
 * @property string|null $data_pedidos
 * @property string|null $data_pago
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Usuario $usuario
 */
class HistoricalCommand extends Entity
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
        'folio_comanda' => true,
        'inicio' => true,
        'termino' => true,
        'productos' => true,
        'total' => true,
        'data_comanda' => true,
        'data_pedidos' => true,
        'data_pago' => true,
        'user' => true,
        'usuario' => true,
    ];
}
