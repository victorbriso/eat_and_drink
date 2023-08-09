<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
class ProductsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
        ]);
        $this->belongsTo('PlaceElaborations', [
            'foreignKey' => 'place_elaboration_id',
        ]);
        $this->hasMany('BuyDetails', [
            'foreignKey' => 'product_id',
        ]);
        $this->hasMany('Cellars', [
            'foreignKey' => 'product_id',
        ]);
        $this->hasMany('InventoryMovements', [
            'foreignKey' => 'product_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'product_id',
        ]);
        $this->hasMany('PriceLists', [
            'foreignKey' => 'product_id',
        ]);
        $this->hasMany('SaleForDays', [
            'foreignKey' => 'product_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 255)
            ->allowEmptyString('nombre');
        $validator
            ->allowEmptyString('estado');
        $validator
            ->allowEmptyString('tipo');
        $validator
            ->decimal('precio_anterior')
            ->allowEmptyString('precio_anterior');
        $validator
            ->decimal('precio_actual')
            ->allowEmptyString('precio_actual');
        $validator
            ->decimal('proximo_precio')
            ->allowEmptyString('proximo_precio');
        $validator
            ->scalar('data_combo')
            ->maxLength('data_combo', 4294967295)
            ->allowEmptyString('data_combo');
        $validator
            ->allowEmptyString('divisible');
        $validator
            ->scalar('receta')
            ->maxLength('receta', 4294967295)
            ->allowEmptyString('receta');
        $validator
            ->scalar('desc_es')
            ->allowEmptyString('desc_es');
        $validator
            ->scalar('descripciones')
            ->maxLength('descripciones', 4294967295)
            ->allowEmptyString('descripciones');
        $validator
            ->scalar('nombres')
            ->maxLength('nombres', 4294967295)
            ->allowEmptyString('nombres');
        $validator
            ->decimal('precio_base')
            ->allowEmptyString('precio_base');
        $validator
            ->scalar('extension')
            ->maxLength('extension', 5)
            ->allowEmptyString('extension');
        $validator
            ->allowEmptyString('agotado');
        $validator
            ->boolean('req_receta')
            ->allowEmptyString('req_receta');
        $validator
            ->decimal('pmp')
            ->allowEmptyString('pmp');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);
        $rules->add($rules->existsIn(['place_elaboration_id'], 'PlaceElaborations'), ['errorField' => 'place_elaboration_id']);
        return $rules;
    }
     public function obtieneProductosSimples($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'estado', 'tipo', 'divisible', 'precio_actual', 'precio_base'])
            ->where(['user_id'=>$localId, 'tipo'=>1])
            ->order(['nombre'=>'ASC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function detalleProductoSimple($localId=null, $prodId=null){
        if(isset($localId)&&isset($prodId)){
            $query=$this->find()
            ->select(['id', 'category_id', 'nombre', 'estado', 'tipo', 'divisible', 'precio_base', 'desc_es', 'place_elaboration_id', 'req_receta', 'receta', 'extension', 'data_combo'])
            ->where(['user_id'=>$localId, 'tipo'=>1, 'id'=>$prodId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function detalleImagen($localId=null, $prodId=null){
        if(isset($localId)&&isset($prodId)){
            $query=$this->find()
            ->select(['id', 'extension'])
            ->where(['user_id'=>$localId, 'id'=>$prodId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function actualizaCategorias($localId=null, $catAntigua=null, $catNueva=null){
        if(isset($localId)&&isset($catAntigua)&&isset($catNueva)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $update=$connection->execute('UPDATE products SET category_id='.$catNueva.' WHERE category_id='.$catAntigua.' AND user_id='.$localId.'');
            if($update){
                $connection->commit();
                return true;
            }else{
                $connection->rollback();
                return false;
            }
        }else{
            return false;
        }
    }
    public function obtieneProductosPreciosListas($localId=null){
        if(isset($localId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_base'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos])
            ->contain(['PriceLists'=> ['sort'=>['price_lists_control_id'=>'ASC', 'product_id'=>'ASC']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function productosParaListaNueva($localId=null){
        if(isset($localId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_base'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneProductosPreciosListaEdit($localId=null, $listaId=null){
        if(isset($localId)&&isset($listaId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_base'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos])
            ->contain(['PriceLists'=> ['conditions'=>['price_lists_control_id'=>$listaId], 'sort'=>['price_lists_control_id'=>'ASC', 'product_id'=>'ASC']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneProdPublicacion($localId=null){
        if(isset($localId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_anterior', 'precio_actual', 'agotado', 'estado', 'extension', 'category_id', 'desc_es', 'place_elaboration_id', 'divisible'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function actualizaCartaBd($localId=null){
        if(isset($localId)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $update=$connection->execute('UPDATE products SET precio_anterior=precio_actual, precio_actual=proximo_precio WHERE user_id='.$localId.'');
            $update2=$connection->execute('UPDATE users SET version=version+1 WHERE id='.$localId.'');
            if($update&&$update2){
                $connection->commit();
                return true;
            }else{
                $connection->rollback();
                return false;
            }
        }else{
            return false;
        }
    }
    public function obtieneInsumos($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'data_combo', 'precio_anterior', 'precio_actual'])
            ->where(['user_id'=>$localId, 'tipo'=>3]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneInsumosReceta($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'data_combo'])
            ->where(['user_id'=>$localId, 'tipo'=>3]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneProdDelivery($localId=null){
        if(isset($localId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_base', 'delivery', 'precio_delivery'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos])
            ->order(['delivery DESC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneProdVtaWeb($localId=null){
        if(isset($localId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_base', 'vta_web', 'precio_web'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos])
            ->order(['vta_web DESC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneProdPublicacionWeb($localId=null){
        if(isset($localId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_anterior', 'precio_actual', 'agotado', 'estado', 'extension', 'category_id', 'desc_es', 'place_elaboration_id', 'divisible'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos, 'vta_web'=>1]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneProdPublicacionDelivery($localId=null){
        if(isset($localId)){
            $tipos=[1, 2];
            $query=$this->find()
            ->select(['id', 'nombre', 'precio_anterior', 'precio_actual', 'agotado', 'estado', 'extension', 'category_id', 'desc_es', 'place_elaboration_id', 'divisible'])
            ->where(['user_id'=>$localId, 'tipo IN'=>$tipos, 'delivery'=>1]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function listaProductosCompra($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'impuestos', 'codigo_ean'])
            ->where(['user_id'=>$localId, 'tipo IN'=>[3]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }        
    }
    public function datosPMP($prodId=null, $localId=null){
        if(isset($prodId)&&isset($localId)){
            $query=$this->find()
            ->select(['precio_anterior', 'precio_actual'])
            ->where(['user_id'=>$localId, 'id'=>$prodId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return false;
        }
    }
    public function listaProductosPorIds($localId=null, $ids=null){
        if(isset($ids)&&isset($localId)){
            $query=$this->find()
            ->select(['nombre', 'id'])
            ->where(['id IN'=>$ids, 'user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            foreach ($data as $key => $value) {
                $data2[$value['id']]=$value['nombre'];
            }
            return $data2;
        }else{
            return array();
        }
    }
    public function obtieneInfoInsumos($prodIds){
        $query=$this->find()
        ->select(['id', 'data_combo', 'precio_anterior'])
        ->where(['id IN'=>$prodIds]);
        $query->enableHydration(false);
        $data = $query->toArray();
        $data2=array();
        foreach ($data as $key => $value) {
            $id=$value['id'];
            $data2[$id]=$value;
        }
        return $data2;
    }
}
