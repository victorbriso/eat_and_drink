<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class PlaceElaborationsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('place_elaborations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'place_elaboration_id',
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
            ->scalar('impresora')
            ->maxLength('impresora', 255)
            ->allowEmptyString('impresora');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtienePLaceElav($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre'])
            ->where(['user_id'=>$localId])
            ->order(['nombre'=>'ASC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
