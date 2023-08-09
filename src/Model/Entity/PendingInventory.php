<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class PendingInventory extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'product_id' => true,
        'cantidad' => true,
        'total' => true,
        'user' => true,
        'product' => true,
    ];
}
