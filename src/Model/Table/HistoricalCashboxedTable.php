<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class HistoricalCashboxedTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('historical_cashboxed');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->belongsTo('Cashboxes', [
            'foreignKey' => 'cashbox_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->dateTime('apertura')
            ->allowEmptyDateTime('apertura');
        $validator
            ->dateTime('termino')
            ->allowEmptyDateTime('termino');
        $validator
            ->decimal('monto_apertura')
            ->allowEmptyString('monto_apertura');
        $validator
            ->decimal('monto_cierre')
            ->allowEmptyString('monto_cierre');
        $validator
            ->decimal('ventas')
            ->allowEmptyString('ventas');
        $validator
            ->decimal('ingresos')
            ->allowEmptyString('ingresos');
        $validator
            ->decimal('retiros')
            ->allowEmptyString('retiros');
        $validator
            ->scalar('movimientos')
            ->maxLength('movimientos', 4294967295)
            ->allowEmptyString('movimientos');
        $validator
            ->decimal('descuadre')
            ->allowEmptyString('descuadre');    
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'), ['errorField' => 'usuario_id']);
        return $rules;
    }
    public function obtieneHistoricoCaja($localId=null, $cierreId=null){
        if(isset($localId)&&isset($cierreId)){
            $query=$this->find()
            ->select(['HistoricalCashboxed.user_id', 'HistoricalCashboxed.usuario_id', 'HistoricalCashboxed.apertura', 'HistoricalCashboxed.termino', 'HistoricalCashboxed.monto_apertura', 'HistoricalCashboxed.monto_cierre', 'HistoricalCashboxed.ventas', 'HistoricalCashboxed.ingresos', 'HistoricalCashboxed.retiros', 'HistoricalCashboxed.movimientos', 'HistoricalCashboxed.descuadre', 'HistoricalCashboxed.efectivo_caja', 'HistoricalCashboxed.efectivo_sistema', 'HistoricalCashboxed.cashbox_id'])
            ->where(['HistoricalCashboxed.user_id'=>$localId, 'HistoricalCashboxed.id'=>$cierreId])
            ->contain([
                'Cashboxes'=>['fields'=>['Cashboxes.id', 'Cashboxes.nombre']],
                'Usuarios'=>['fields'=>['Usuarios.nombres', 'Usuarios.apellidos']],
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneUltimosCierres($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['HistoricalCashboxed.id', 'HistoricalCashboxed.user_id', 'HistoricalCashboxed.usuario_id', 'HistoricalCashboxed.apertura', 'HistoricalCashboxed.termino', 'HistoricalCashboxed.descuadre', 'HistoricalCashboxed.cashbox_id'])
            ->where(['HistoricalCashboxed.user_id'=>$localId])
            ->contain([
                'Cashboxes'=>['fields'=>['Cashboxes.id', 'Cashboxes.nombre']],
                'Usuarios'=>['fields'=>['Usuarios.nombres', 'Usuarios.apellidos']],
            ])
            ->limit(10);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneHistoricoCajaRango($localId=null, $inicio=null, $termino=null){
        if(isset($localId)&&isset($inicio)&&isset($termino)){
            $query=$this->find()
            ->select(['HistoricalCashboxed.id', 'HistoricalCashboxed.user_id', 'HistoricalCashboxed.usuario_id', 'HistoricalCashboxed.apertura', 'HistoricalCashboxed.termino', 'HistoricalCashboxed.descuadre', 'HistoricalCashboxed.cashbox_id'])
            ->where(['HistoricalCashboxed.user_id'=>$localId, 'HistoricalCashboxed.apertura BETWEEN :start AND :end'])
            ->bind(':start', $inicio.' 00:00:00','date')
            ->bind(':end', $termino.' 23:59:59','date')
            ->contain([
                'Cashboxes'=>['fields'=>['Cashboxes.id', 'Cashboxes.nombre']],
                'Usuarios'=>['fields'=>['Usuarios.nombres', 'Usuarios.apellidos']],
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
}
