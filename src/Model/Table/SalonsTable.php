<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class SalonsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('salons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Cashboxes', [
            'foreignKey' => 'salon_id',
        ]);
        $this->hasMany('Comandas', [
            'foreignKey' => 'salon_id',
        ]);
        $this->hasMany('Tables', [
            'foreignKey' => 'salon_id',
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
            ->allowEmptyString('estado');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtieneMesasPorSalon($id=null){
        if(isset($id)){
            $query=$this->find()
            ->select(['id', 'nombre', 'estado'])
            ->where(['user_id'=>$id])
            ->contain(['Tables']);
            $query->enableHydration(false);
            $data = $query->toArray();
            foreach ($data as $key => $value) {
                $data[$key]['ocupadas']=array();
                $data[$key]['libres']=array();
            }
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneSalones($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre'])
            ->where(['user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
