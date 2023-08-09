<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
class User extends Entity{
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'nombre' => true,
        'razon_social' => true,
        'latitud' => true,
        'longitud' => true,
        'direccion' => true,
        'cabecera_direccion' => true,
        'impresoras' => true,
        'hash_impresion' => true,
        'venta_web' => true,
        'delivery' => true,
        'plan' => true,
        'monto_mensual' => true,
        'estension' => true,
        'version' => true,
        'max_mesas' => true,
        'pais' => true,
        'region' => true,
        'comuna' => true,
        'sector' => true,
        'config_reservas' => true,
        'inventario' => true,
        'bookings' => true,
        'buy_details' => true,
        'buy_summaries' => true,
        'cancellations' => true,
        'cashbox_movements' => true,
        'cashboxes' => true,
        'categories' => true,
        'cellars' => true,
        'comandas' => true,
        'fixed_costs' => true,
        'folio_cashes' => true,
        'folios' => true,
        'historical_commands' => true,
        'inventory_movements' => true,
        'orders' => true,
        'place_elaborations' => true,
        'price_list_controls' => true,
        'price_lists' => true,
        'products' => true,
        'profiles' => true,
        'sale_for_days' => true,
        'salons' => true,
        'tables' => true,
        'usuarios' => true,
        'vendors' => true,
    ];
    protected $_hidden = [
        'password',
    ];
    protected function _setPassword(string $password){
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}
