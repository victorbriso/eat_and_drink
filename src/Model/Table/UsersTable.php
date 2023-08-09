<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class UsersTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->hasMany('Bookings', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('BuyDetails', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('BuySummaries', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Cancellations', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CashboxMovements', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Cashboxes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Categories', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Cellars', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Comandas', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('FixedCosts', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('FolioCashes', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Folios', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('HistoricalCommands', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('InventoryMovements', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('PlaceElaborations', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('PriceListControls', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('PriceLists', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('SaleForDays', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Salons', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Tables', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Usuarios', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Vendors', [
            'foreignKey' => 'user_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->allowEmptyString('username');
        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');
        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 45)
            ->allowEmptyString('nombre');
        $validator
            ->scalar('razon_social')
            ->maxLength('razon_social', 100)
            ->allowEmptyString('razon_social');
        $validator
            ->decimal('latitud')
            ->allowEmptyString('latitud');
        $validator
            ->decimal('longitud')
            ->allowEmptyString('longitud');
        $validator
            ->scalar('direccion')
            ->maxLength('direccion', 255)
            ->allowEmptyString('direccion');
        $validator
            ->scalar('cabecera_direccion')
            ->maxLength('cabecera_direccion', 45)
            ->allowEmptyString('cabecera_direccion');
        $validator
            ->scalar('impresoras')
            ->maxLength('impresoras', 4294967295)
            ->allowEmptyString('impresoras');
        $validator
            ->scalar('hash_impresion')
            ->maxLength('hash_impresion', 15)
            ->allowEmptyString('hash_impresion');
        $validator
            ->allowEmptyString('venta_web');
        $validator
            ->allowEmptyString('delivery');
        $validator
            ->integer('plan')
            ->allowEmptyString('plan');
        $validator
            ->integer('monto_mensual')
            ->allowEmptyString('monto_mensual');
        $validator
            ->scalar('estension')
            ->maxLength('estension', 5)
            ->allowEmptyString('estension');
        $validator
            ->integer('version')
            ->allowEmptyString('version');
        $validator
            ->integer('max_mesas')
            ->allowEmptyString('max_mesas');
        $validator
            ->allowEmptyString('pais');
        $validator
            ->allowEmptyString('region');
        $validator
            ->allowEmptyString('comuna');
        $validator
            ->allowEmptyString('sector');
        $validator
            ->scalar('config_reservas')
            ->maxLength('config_reservas', 4294967295)
            ->allowEmptyString('config_reservas');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        return $rules;
    }
    public function datosLocal($id=null){
        if(isset($id)){
            $query=$this->find()
            ->select(['id', 'username', 'nombre', 'razon_social', 'venta_web', 'delivery', 'plan', 'max_mesas', 'cargador', 'inventario'])
            ->where(['id'=>$id]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;        
        }else{
            return false;
        }
    }
    public function obtieneCodigoLocal($id=null){
        if(isset($id)){
            $query=$this->find()
            ->select(['id', 'codigo_local'])
            ->where(['id'=>$id]);
            $query->enableHydration(false);
            $data = $query->toArray();
            $connection = ConnectionManager::get('default');
            $update=$connection->execute('UPDATE users SET version=version+1 WHERE id='.$id.'');
            return $data;        
        }else{
            return false;
        }
    }
    public function validaVersionCarta($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['version'])
            ->where(['id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;      
        }else{
            return false;
        }
    }
    public function datosLocalEdit($id=null){
        if(isset($id)){
            $query=$this->find()
            ->select(['id', 'username', 'nombre', 'razon_social', 'venta_web', 'delivery', 'plan', 'config_reservas', 'direccion', 'venta_web', 'estension', 'inventario'])
            ->where(['id'=>$id]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;        
        }else{
            return false;
        }
    }
    public function dataLocalCarta($id=null){
        if(isset($id)){
            $query=$this->find()
            ->select(['id', 'nombre', 'estension', 'fono_comercial', 'plan'])
            ->where(['id'=>$id]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;        
        }else{
            return false;
        }
    }
    public function validacionHashImpresion($id=null, $hash=null){
        if(isset($id)&&isset($hash)){
            $query=$this->find()
            ->select(['id'])
            ->where(['id'=>$id, 'hash_impresion'=>$hash]);
            $query->enableHydration(false);
            $data = $query->toArray();
            if(!empty($data)){
                return $data[0]['id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
