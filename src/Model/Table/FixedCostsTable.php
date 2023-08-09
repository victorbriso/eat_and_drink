<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class FixedCostsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('fixed_costs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->integer('freciencia')
            ->allowEmptyString('freciencia');
        $validator
            ->scalar('concepto')
            ->maxLength('concepto', 45)
            ->allowEmptyString('concepto');
        $validator
            ->decimal('monto')
            ->allowEmptyString('monto');
        $validator
            ->decimal('diario')
            ->allowEmptyString('diario');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtieneCostos($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['concepto', 'freciencia', 'monto'])
            ->where(['user_id'=>$localId])
            ->order(['freciencia'=>'ASC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneCostosDiarios($localId){
        if(isset($localId)){
            $query = $this->find();
            $query->select(['sum' => $query->func()->sum('diario')])
            ->where(['user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            $return=($data[0]['sum']!='')?$data[0]['sum']:0;
            return $return;
        }else{
            return 0;
        }
    }
    public function obtieneAhorros($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['CostosFijos.concepto', 'CostosFijos.freciencia', 'CostosFijos.monto', 'CostosFijos.id'])
            ->where(['CostosFijos.user_id'=>$localId])
            ->order(['CostosFijos.freciencia'=>'ASC'])
            ->contain(['FrascoResumenes'=>['fields'=>['FrascoResumenes.saldo', 'FrascoResumenes.costos_fijo_id']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
