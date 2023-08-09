<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class FolioCashesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('folio_cashes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CashboxMovements', [
            'foreignKey' => 'folio_cash_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'folio_cash_id',
        ]);
        $this->hasOne('Comandas', [
            'foreignKey' => 'comanda_id',
        ]);
        $this->belongsTo('Tables', [
            'foreignKey' => 'table_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->allowEmptyString('folio');
        $validator
            ->decimal('monto')
            ->allowEmptyString('monto');
        $validator
            ->allowEmptyString('pagado');
        $validator
            ->dateTime('fecha_pago')
            ->allowEmptyDateTime('fecha_pago');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
    public function obtieneFolio($folio=null, $local=null){
        if(isset($folio)&&isset($local)){
            $query=$this->find()
            ->select(['FolioCashes.id', 'FolioCashes.folio', 'FolioCashes.monto', 'FolioCashes.table_id', 'FolioCashes.comanda_id', 'FolioCashes.productos', 'FolioCashes.propina'])
            ->where(['FolioCashes.user_id'=>$local, 'FolioCashes.folio'=>$folio])
            ->contain([
                'Tables'=>['fields'=>['Tables.numero', 'Tables.nombre']]]
            );
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
