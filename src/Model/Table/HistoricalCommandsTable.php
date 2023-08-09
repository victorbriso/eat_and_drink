<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class HistoricalCommandsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('historical_commands');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->integer('folio_comanda')
            ->allowEmptyString('folio_comanda');
        $validator
            ->dateTime('inicio')
            ->allowEmptyDateTime('inicio');
        $validator
            ->dateTime('termino')
            ->allowEmptyDateTime('termino');
        $validator
            ->integer('productos')
            ->allowEmptyString('productos');
        $validator
            ->decimal('total')
            ->allowEmptyString('total');
        $validator
            ->scalar('data_comanda')
            ->maxLength('data_comanda', 4294967295)
            ->allowEmptyString('data_comanda');
        $validator
            ->scalar('data_pedidos')
            ->maxLength('data_pedidos', 4294967295)
            ->allowEmptyString('data_pedidos');
        $validator
            ->scalar('data_pago')
            ->maxLength('data_pago', 4294967295)
            ->allowEmptyString('data_pago');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'), ['errorField' => 'usuario_id']);
        return $rules;
    }
}
