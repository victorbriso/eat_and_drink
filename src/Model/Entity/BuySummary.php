<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class BuySummary extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'vendor_id' => true,
        'created' => true,
        'fecha_compra' => true,
        'dias' => true,
        'vencimiento' => true,
        'neto' => true,
        'impuestos' => true,
        'estado' => true,
        'documento'=>true,
        'bruto'=>true,
        'tipo_documento'=>true,
        'user' => true,
        'vendor' => true,
        'buy_details' => true,
    ];
}
