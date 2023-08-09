<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Profile extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'nombre' => true,
        'roles' => true,
        'inicio'=>true,
        'user' => true,
        'usuarios' => true,
    ];
}
