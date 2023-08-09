<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class GeneralSaleDaysTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('general_sale_days');
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
            ->date('dia')
            ->allowEmptyDate('dia');
        $validator
            ->decimal('monto')
            ->allowEmptyString('monto');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function totalVentas($localId=null, $fecha=null){
        if(isset($localId)&&isset($fecha)){
            $query=$this->find()
            ->select(['monto'])
            ->where(['user_id'=>$localId, 'dia IN'=>$fecha]);
            $query->enableHydration(false);
            $data = $query->toArray();
            
            if(count($data)>0){
                $montos=$data[0]['monto'];
            }else{
                $montos=0;
            }
            return $montos;
        }else{
            return 0;
        }
    }
    public function obtieneIdVentaGeneral($localId=null, $fecha=null){
        if(isset($localId)&&isset($fecha)){
            $query=$this->find()
            ->select(['id'])
            ->where(['user_id'=>$localId, 'dia'=>$fecha]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return false;
        }
    }
}
