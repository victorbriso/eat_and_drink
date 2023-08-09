<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Vendor extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'nombre' => true,
        'razon_social' => true,
        'rut' => true,
        'rut_dv' => true,
        'data_pedido' => true,
        'data_facturacion' => true,
        'data_cobranza' => true,
        'mail_dte' => true,
        'direccion'=>true,
        'user' => true,
        'buy_summaries' => true,
    ];
}
