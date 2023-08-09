<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class OrdersTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
        ]);
        $this->belongsTo('FolioCashes', [
            'foreignKey' => 'folio_cash_id',
        ]);
        $this->belongsTo('FolioCashes', [
            'foreignKey' => 'folio_cash_id',
        ]);
        $this->belongsTo('Comandas', [
            'foreignKey' => 'comanda_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->integer('cantidad')
            ->allowEmptyString('cantidad');
        $validator
            ->decimal('precio')
            ->allowEmptyString('precio');
        $validator
            ->decimal('total')
            ->allowEmptyString('total');
        $validator
            ->decimal('pagado')
            ->allowEmptyString('pagado');
        $validator
            ->allowEmptyString('tipo');
        $validator
            ->scalar('agregados')
            ->maxLength('agregados', 4294967295)
            ->allowEmptyString('agregados');
        $validator
            ->scalar('quetados')
            ->maxLength('quetados', 4294967295)
            ->allowEmptyString('quetados');
        $validator
            ->boolean('impreso')
            ->allowEmptyString('impreso');
        $validator
            ->boolean('bool_pagado')
            ->allowEmptyString('bool_pagado');
        $validator
            ->boolean('despachado')
            ->allowEmptyString('despachado');
        $validator
            ->scalar('cliente')
            ->maxLength('cliente', 255)
            ->allowEmptyString('cliente');
        $validator
            ->decimal('descuento')
            ->allowEmptyString('descuento');
        $validator
            ->scalar('data_dcto')
            ->maxLength('data_dcto', 4294967295)
            ->allowEmptyString('data_dcto');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn(['folio_cash_id'], 'FolioCashes'), ['errorField' => 'folio_cash_id']);
        return $rules;
    }
    public function pedidosPorId($localId=null, $productos=array()){
        if(isset($localId)&& !empty($productos)){
            $query=$this->find()
            ->select(['Orders.id', 'Orders.product_id', 'Orders.cantidad', 'Orders.precio', 'Orders.total', 'Orders.comentario'])
            ->where(['Orders.user_id'=>$localId, 'Orders.id IN'=>$productos])
            ->contain([
                'Products'=>['fields'=>['Products.nombre', 'Products.divisible']]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function pedidosPendientesPago($localId=null, $comandaId=null){
        if(isset($localId)&&isset($comandaId)){
            $query=$this->find()
            ->select(['Orders.id'])
            ->where(['Orders.user_id'=>$localId, 'Orders.comanda_id'=>$comandaId, 'Orders.bool_pagado'=>0]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return false;
        }
    }
    public function pedidosPorComanda($localId=null, $comandaId=null){
        if(isset($localId)&&isset($comandaId)){
            $query=$this->find()
            ->select(['Orders.id', 'Orders.product_id', 'Orders.cantidad', 'Orders.precio', 'Orders.total', 'Orders.created', 'Orders.agregados', 'Orders.quetados', 'Orders.descuento', 'Orders.data_dcto', 'Orders.comentario', 'Orders.cliente'])
            ->where(['Orders.user_id'=>$localId, 'Orders.comanda_id'=>$comandaId])
            ->contain([
                'Products'=>['fields'=>['Products.nombre', 'Products.divisible']]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return false;
        }
    }
}
