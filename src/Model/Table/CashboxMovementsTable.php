<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class CashboxMovementsTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('cashbox_movements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Cashboxes', [
            'foreignKey' => 'cashbox_id',
        ]);
        $this->belongsTo('FolioCashes', [
            'foreignKey' => 'folio_cash_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->integer('tipo_pago')
            ->allowEmptyString('tipo_pago');
        $validator
            ->decimal('monto')
            ->allowEmptyString('monto');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['cashbox_id'], 'Cashboxes'), ['errorField' => 'cashbox_id']);
        $rules->add($rules->existsIn(['folio_cash_id'], 'FolioCashes'), ['errorField' => 'folio_cash_id']);
        return $rules;
    }
    public function detallePagosComanda($localId=null, $comandaId=null){
        if(isset($localId)&&isset($comandaId)){
            $query=$this->find()
            ->select(['CashboxMovements.id', 'CashboxMovements.user_id', 'CashboxMovements.cashbox_id', 'CashboxMovements.numero_folio_cash', 'CashboxMovements.tipo_pago', 'CashboxMovements.monto', 'CashboxMovements.created', 'CashboxMovements.comentario', 'CashboxMovements.usuario_id', 'CashboxMovements.data', 'CashboxMovements.propina', 'CashboxMovements.comanda_id'])
            ->where(['CashboxMovements.user_id'=>$localId, 'CashboxMovements.comanda_id'=>$comandaId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
