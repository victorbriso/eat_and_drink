<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class SaleForDaysTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('sale_for_days');
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
            ->decimal('valor')
            ->allowEmptyString('valor');
        $validator
            ->decimal('total')
            ->allowEmptyString('total');
        $validator
            ->date('dia')
            ->allowEmptyDate('dia');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        return $rules;
    }
}
