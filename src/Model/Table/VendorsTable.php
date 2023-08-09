<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class VendorsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('vendors');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('BuySummaries', [
            'foreignKey' => 'vendor_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 45)
            ->allowEmptyString('nombre');
        $validator
            ->scalar('razon_social')
            ->maxLength('razon_social', 45)
            ->allowEmptyString('razon_social');
        $validator
            ->integer('rut')
            ->allowEmptyString('rut');
        $validator
            ->allowEmptyString('rut_dv');
        $validator
            ->scalar('data_pedido')
            ->maxLength('data_pedido', 4294967295)
            ->allowEmptyString('data_pedido');
        $validator
            ->scalar('data_facturacion')
            ->maxLength('data_facturacion', 4294967295)
            ->allowEmptyString('data_facturacion');
        $validator
            ->scalar('data_cobranza')
            ->maxLength('data_cobranza', 4294967295)
            ->allowEmptyString('data_cobranza');
        $validator
            ->scalar('mail_dte')
            ->maxLength('mail_dte', 45)
            ->allowEmptyString('mail_dte');
        $validator
            ->scalar('direccion')
            ->maxLength('direccion', 255)
            ->allowEmptyString('direccion');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtieneProveedores($localId=null){
        if(isset($localId)){
            $estados=array(1,2);
            $query=$this->find()
            ->select(['Vendors.id', 'Vendors.nombre', 'Vendors.razon_social', 'Vendors.data_pedido', 'Vendors.rut', 'Vendors.rut_dv', 'Vendors.data_facturacion', 'Vendors.data_cobranza', 'Vendors.mail_dte', 'Vendors.direccion'])
            ->where(['Vendors.user_id'=>$localId])
            ->contain(['BuySummaries'=>['conditions'=>['BuySummaries.estado IN'=>$estados], 'fields'=>['BuySummaries.vendor_id', 'BuySummaries.neto', 'BuySummaries.estado']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            foreach ($data as $key1 => $value1) {
                $data[$key1]['vencido']=array();
                $data[$key1]['xVencer']=array();
                foreach ($value1['buy_summaries'] as $key2 => $value2) {
                    if($value2['estado']==1){
                        array_push($data[$key1]['xVencer'], $value2['neto']);
                    }elseif ($value2['estado']==2) {
                        array_push($data[$key1]['vencido'], $value2['neto']);
                    }else{
                        continue;
                    }
                }
                unset($data[$key1]['BuySummaries']);
                $data[$key1]['vencido']=array_sum($data[$key1]['vencido']);
                $data[$key1]['xVencer']=array_sum($data[$key1]['xVencer']);
            }
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneProveedor($localId=null, $proveedorId=null){
        if(isset($localId)&&isset($proveedorId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'razon_social', 'direccion', 'data_facturacion', 'rut', 'mail_dte', 'Vendors.rut_dv', 'Vendors.data_cobranza', 'Vendors.data_pedido'])
            ->where(['user_id'=>$localId, 'id'=>$proveedorId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function listaProveedores($localId=null){
        if(isset($localId)){
            $estados=array(1,2);
            $query=$this->find()
            ->select(['id', 'nombre'])
            ->where(['user_id'=>$localId, 'id !='=>4]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
