<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class CellarsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('cellars');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('InventoryMovements', [
            'foreignKey' => 'cellar_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->decimal('cantidad')
            ->allowEmptyString('cantidad');
        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 45)
            ->allowEmptyString('nombre');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtieneBodegas($localId){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre'])
            ->where(['user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return false;
        }
    }
    public function obtieneBodegaPrincipal($localId){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre'])
            ->where(['user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data[0]['id'];
        }else{
            return false;
        }
    }
}
