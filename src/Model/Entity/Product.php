<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Product extends Entity{
    protected $_accessible = [
        'user_id' => true,
        'category_id' => true,
        'nombre' => true,
        'estado' => true,
        'tipo' => true,
        'precio_anterior' => true,
        'precio_actual' => true,
        'proximo_precio' => true,
        'data_combo' => true,
        'divisible' => true,
        'receta' => true,
        'desc_es' => true,
        'descripciones' => true,
        'nombres' => true,
        'place_elaboration_id' => true,
        'precio_base' => true,
        'extension' => true,
        'agotado' => true,
        'req_receta' => true,
        'impuestos'=>true,
        'pmp'=>true,
        'codigo_ean'=>true,
        'user' => true,
        'category' => true,
        'place_elaboration' => true,
        'buy_details' => true,
        'cellars' => true,
        'inventory_movements' => true,
        'orders' => true,
        'price_lists' => true,
        'sale_for_days' => true,
    ];
}
