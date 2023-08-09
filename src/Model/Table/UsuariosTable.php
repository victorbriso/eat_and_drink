<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class UsuariosTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('usuarios');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Profiles', [
            'foreignKey' => 'profile_id',
        ]);
        $this->hasMany('Cancellations', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('Cashboxes', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('Comandas', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('HistoricalCommands', [
            'foreignKey' => 'usuario_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->scalar('nombres')
            ->maxLength('nombres', 45)
            ->allowEmptyString('nombres');
        $validator
            ->scalar('apellidos')
            ->maxLength('apellidos', 45)
            ->allowEmptyString('apellidos');
        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');
        $validator
            ->scalar('mail')
            ->maxLength('mail', 45)
            ->allowEmptyString('mail');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['profile_id'], 'Profiles'), ['errorField' => 'profile_id']);
        return $rules;
    }
    public function obtieneCajeros($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'profile_id', 'nombres', 'apellidos', 'caja_activa'])
            ->where(['user_id'=>$localId, 'cajero'=>1]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneUsuarios($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Usuarios.id', 'Usuarios.profile_id', 'Usuarios.nombres', 'Usuarios.apellidos', 'Usuarios.mail'])
            ->where(['Usuarios.user_id'=>$localId])
            ->contain(['Profiles'=>['fields'=>['Profiles.nombre']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneUsuariosSimple($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Usuarios.id', 'Usuarios.nombres', 'Usuarios.apellidos'])
            ->where(['Usuarios.user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneUsuarioLogin($localId=null, $usuarioId=null){
        if(isset($localId)&&isset($usuarioId)){
            $query=$this->find()
            ->select(['Usuarios.id', 'Usuarios.profile_id', 'Usuarios.nombres', 'Usuarios.apellidos', 'Usuarios.mail', 'Usuarios.password'])
            ->where(['Usuarios.user_id'=>$localId, 'Usuarios.id'=>$usuarioId])
            ->contain(['Profiles'=>['fields'=>['Profiles.roles', 'Profiles.inicio']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
