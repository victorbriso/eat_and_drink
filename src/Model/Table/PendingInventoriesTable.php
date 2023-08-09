<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class PendingInventoriesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('pending_inventories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->integer('cantidad')
            ->allowEmptyString('cantidad');
        $validator
            ->decimal('total')
            ->allowEmptyString('total');
        $validator
            ->allowEmptyString('estado');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        return $rules;
    }
    public function productosInventario(){
        $query=$this->find()
        ->select(['PendingInventories.id', 'PendingInventories.user_id', 'PendingInventories.product_id', 'PendingInventories.cantidad', 'PendingInventories.total'])
        ->contain([
            'Products'=>['fields'=>['Products.receta', 'Products.req_receta', 'Products.data_combo']]
        ]);
        $query->enableHydration(false);
        $data = $query->toArray();
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $data[$key]['product']['receta']=json_decode($value['product']['receta'], true);
            }
        }
        return $data;
    }
}
