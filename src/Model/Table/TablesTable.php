<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class TablesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);

        $this->setTable('tables');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Salons', [
            'foreignKey' => 'salon_id',
        ]);
        $this->hasMany('Bookings', [
            'foreignKey' => 'table_id',
        ]);
        $this->hasMany('Comandas', [
            'foreignKey' => 'table_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->integer('numero')
            ->allowEmptyString('numero');
        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 45)
            ->allowEmptyString('nombre');
        $validator
            ->allowEmptyString('ocupado');
        $validator
            ->allowEmptyString('notificacion');
        $validator
            ->nonNegativeInteger('codigo')
            ->allowEmptyString('codigo')
            ->add('codigo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->isUnique(['codigo']), ['errorField' => 'codigo']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['salon_id'], 'Salons'), ['errorField' => 'salon_id']);
        return $rules;
    }
    public function obtieneMesas($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Tables.id', 'Tables.salon_id', 'Tables.nombre', 'Tables.numero', 'Tables.ocupado'])
            ->where(['Tables.user_id'=>$localId])
            ->order(['Tables.salon_id ASC', 'Tables.numero ASC'])
            ->contain(['Salons'=>['fields'=>['Salons.id', 'Salons.nombre']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneTotalMesas($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Tables.id'])
            ->where(['Tables.user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return count($data);
        }else{
            return 0;
        }
    }
    public function obtieneMesasOcupadas($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Tables.id', 'Tables.salon_id', 'Tables.numero', 'Tables.ocupado', 'Tables.modified'])
            ->where(['Tables.user_id'=>$localId, 'Tables.ocupado'=>1])
            ->order(['Tables.salon_id ASC'])
            ->contain(['Salons'=>['fields'=>['Salons.id', 'Salons.nombre']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneUltimaMesa($localId=null, $salonId=null){
        if(isset($localId)&&isset($salonId)){
            $query=$this->find()
            ->select(['numero'])
            ->where(['user_id'=>$localId, 'salon_id'=>$salonId])
            ->limit(1)
            ->order(['id DESC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            if(!empty($data)){
                $data=$data[0]['numero']+1;
            }else{
                $data=1;
            }
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneNotificaciones($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'notificacion'])
            ->where(['user_id'=>$localId, 'ocupado '=>1]);
            $query->enableHydration(false);
            $data = $query->toArray();
            foreach ($data as $key => $value) {
                $data2[$value['id']]=$value['notificacion'];
            }
            return $data2;
        }else{
            return array();
        }
    }
    public function actualizaNotificaionCliente($mesa=null, $tipo=null){
        if(isset($mesa)&&$tipo){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $update=$connection->execute('UPDATE tables SET notificacion='.$tipo.' WHERE numero='.$mesa.'');
            if($update){
                $connection->commit();
                return true;
            }else{
                $connection->rollback();
                return true;
            }
        }else{
            return false;
        }
    }
    public function mesasLibresPorSalon($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Tables.id', 'Tables.salon_id', 'Tables.numero'])
            ->where(['Tables.user_id'=>$localId, 'Tables.ocupado '=>0])
            ->contain(['Salons'=>['fields'=>['Salons.id', 'Salons.nombre']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneMesasLibres($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Tables.id', 'Tables.salon_id', 'Tables.numero', 'Tables.nombre'])
            ->where(['Tables.user_id'=>$localId, 'Tables.ocupado '=>0]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function mesaDisponible($localId=null, $mesaId=null){
        if(isset($localId)&&isset($mesaId)){
            $query=$this->find()
            ->select(['Tables.id', 'Tables.numero', 'Tables.nombre', 'Tables.salon_id'])
            ->where(['Tables.user_id'=>$localId, 'Tables.ocupado '=>0, 'Tables.id '=>$mesaId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            if(!empty($data)){
                return $data;
            }else{
                return array();
            }
        }else{
            return array();
        }
    }
    public function infoLocalMesa($codigoLocal=null){
        if(isset($codigoLocal)){
            $query=$this->find()
            ->select(['Tables.id', 'Tables.numero', 'Tables.nombre', 'Tables.user_id'])
            ->where(['Tables.codigo'=>$codigoLocal])
            ->contain([
                'Users'=>['fields'=>['Users.id','Users.version']]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            if(!empty($data)){
                $query = $this->query();
                $query->update()
                    ->set(['notificacion' => 3, 'ocupado'=>1])
                    ->where(['id' => $data[0]['id']])
                    ->execute();
            }
            return $data;
        }else{
            return array();
        }
    }
}
