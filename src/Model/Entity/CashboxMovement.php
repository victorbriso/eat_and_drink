<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class CashboxMovement extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'cashbox_id' => true,
        'numero_folio_cash' => true,
        'tipo_pago' => true,
        'monto' => true,
        'created' => true,
        'comentario'=>true,
        'data'=>true,
        'comanda_id'=>true,
        'usuario_id'=>true,
        'propina'=>true,
        'usuario'=>true,
        'user' => true,
        'cashbox' => true,
        'comanda'=>true,
    ];
}
