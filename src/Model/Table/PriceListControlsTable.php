<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
class PriceListControlsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('price_list_controls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('PriceLists', [
            'foreignKey' => 'price_lists_control_id',
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
    public function obtieneListas($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id', 'nombre', 'estado'])
            ->where(['user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneIdsListas($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id'])
            ->where(['user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function eliminaLista($localId=null, $listaId=null){
        if(isset($localId)&&isset($listaId)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $delete1=$connection->execute('DELETE FROM price_lists WHERE user_id='.$localId.' AND price_lists_control_id='.$listaId.'');
            $delete2=$connection->execute('DELETE FROM price_list_controls WHERE user_id='.$localId.' AND id='.$listaId.'');
            if($delete1&&$delete2){
                $connection->commit();
                return true;
            }else{
                $connection->rollback();
                return false;
            }
        }else{
            return false;
        }
    }
    public function obtieneListaActiva($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['id'])
            ->where(['PriceListControls.user_id'=>$localId, 'estado'=>1])
            ->contain(['PriceLists'=>['fields'=>['product_id', 'precio', 'price_lists_control_id']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            $data2=array();
            if(!empty($data)){
                foreach ($data[0]['price_lists'] as $key => $value) {
                    $data2[$value['product_id']]=$value['precio'];
                }    
            }            
            return $data2;
        }else{
            return array();
        }
    }
}
