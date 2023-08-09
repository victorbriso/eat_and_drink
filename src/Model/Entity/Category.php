<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $nombre
 * @property int|null $estado
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool|null $tipo
 * @property string|null $extension
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product[] $products
 */
class Category extends Entity
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
        'modified' => true,
        'tipo' => true,
        'extension' => true,
        'user' => true,
        'products' => true,
    ];
}
