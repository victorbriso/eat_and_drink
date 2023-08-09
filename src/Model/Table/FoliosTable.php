<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class FoliosTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('folios');
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
            ->integer('tipo')
            ->allowEmptyString('tipo');
        $validator
            ->integer('folio')
            ->allowEmptyString('folio');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtieneFolio($local=null, $tipo=null){
        if(isset($local)&&isset($tipo)){
            $query=$this->find()
            ->select(['id', 'folio'])
            ->where(['user_id'=>$local, 'tipo'=>$tipo]);
            $query->enableHydration(false);
            $data = $query->toArray();
            if(empty($data)){
                $query=$this->query();
                $query->insert(['user_id', 'tipo', 'folio'])
                    ->values([
                        'user_id'=>$local, 
                        'tipo'=>$tipo, 
                        'folio'=>1])
                    ->execute();
                return 1;
            }else{
                $folio=$data[0]['folio']+1;
                $query = $this->query();
                $query->update()
                    ->set(['folio' => $folio])
                    ->where(['id' => $data[0]['id']])
                    ->execute();
                return $folio;
            }            
        }else{
            return false;
        }
    }
}
