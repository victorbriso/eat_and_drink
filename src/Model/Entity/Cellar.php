<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Cellar extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'nombre' => true,
        'user' => true,
        'inventory_movements' => true,
    ];
}
