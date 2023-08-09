<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class ProfilesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('profiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Usuarios', [
            'foreignKey' => 'profile_id',
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
            ->scalar('roles')
            ->maxLength('roles', 4294967295)
            ->allowEmptyString('roles');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtienePerfiles($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'inicio'])
            ->where(['user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtienePerfil($localId=null, $perfilId=null){
        if(isset($localId)&&isset($perfilId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'inicio', 'roles'])
            ->where(['user_id'=>$localId, 'id'=>$perfilId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
