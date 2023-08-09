<?php
declare(strict_types=1);

namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class CategoriesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'category_id',
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
        $validator
            ->boolean('tipo')
            ->allowEmptyString('tipo');
        $validator
            ->scalar('extension')
            ->maxLength('extension', 5)
            ->allowEmptyString('extension');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtieneCategorias($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Categories.id', 'Categories.nombre', 'Categories.tipo', 'Categories.extension'])
            ->where(['Categories.user_id'=>$localId])
            ->contain(['Products'=>['fields'=>['Products.category_id']]])
            ->order(['Categories.tipo'=>'ASC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function detalleCategoria($localId=null, $id=null){
        if(isset($localId)&&isset($id)){
            $query=$this->find()
            ->select(['Categories.id', 'Categories.nombre', 'Categories.tipo', 'Categories.extension'])
            ->where(['Categories.user_id'=>$localId, 'Categories.id'=>$id]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneCategoriasPublicacion($localId=null, $id=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Categories.id', 'Categories.nombre', 'Categories.tipo', 'Categories.extension', 'Categories.cat_padre'])
            ->where(['Categories.user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
