<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class HistoricalCashboxed extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'usuario_id' => true,
        'apertura' => true,
        'termino' => true,
        'monto_apertura' => true,
        'monto_cierre' => true,
        'ventas' => true,
        'ingresos' => true,
        'retiros' => true,
        'movimientos' => true,
        'descuadre'=>true,
        'efectivo_caja'=>true,
        'efectivo_sistema'=>true,
        'cashbox_id'=>true,
        'user' => true,
        'usuario' => true,
        'cashbox'=>true,
    ];
}
