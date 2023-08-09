<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
class ComandasTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('comandas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Salons', [
            'foreignKey' => 'salon_id',
        ]);
        $this->belongsTo('Tables', [
            'foreignKey' => 'table_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'comanda_id',
        ]);
        $this->hasMany('FolioCashes', [
            'foreignKey' => 'comanda_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->integer('folio')
            ->allowEmptyString('folio');
        $validator
            ->decimal('total')
            ->allowEmptyString('total');
        $validator
            ->decimal('pagado')
            ->allowEmptyString('pagado');
        $validator
            ->scalar('clientes')
            ->maxLength('clientes', 4294967295)
            ->allowEmptyString('clientes');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['salon_id'], 'Salons'), ['errorField' => 'salon_id']);
        $rules->add($rules->existsIn(['table_id'], 'Tables'), ['errorField' => 'table_id']);
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'), ['errorField' => 'usuario_id']);
        return $rules;
    }
    public function obtieneComandas($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Comandas.id', 'Comandas.salon_id', 'Comandas.table_id', 'Comandas.usuario_id', 'Comandas.folio', 'Comandas.total', 'Comandas.pagado', 'Comandas.clientes', 'Comandas.created'])
            ->where(['Comandas.user_id'=>$localId])
            ->contain([
                'Usuarios'=>['fields'=>['Usuarios.nombres']],
                'Salons'=>['fields'=>['Salons.nombre']],
                'Tables'=>['fields'=>['Tables.nombre', 'Tables.numero']]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneComanda($localId=null, $comandaId=null){
        if(isset($localId)&&isset($comandaId)){
            $query=$this->find()
            ->select(['Comandas.id', 'Comandas.salon_id', 'Comandas.table_id', 'Comandas.usuario_id', 'Comandas.folio', 'Comandas.total', 'Comandas.pagado', 'Comandas.clientes', 'Comandas.created'])
            ->where(['Comandas.user_id'=>$localId, 'Comandas.id'=>$comandaId])
            ->contain([
                'Usuarios'=>['fields'=>['Usuarios.nombres']],
                'Salons'=>['fields'=>['Salons.nombre']],
                'Tables'=>['fields'=>['Tables.nombre', 'Tables.numero', 'Tables.id']],
                'Orders'=>['fields'=>['Orders.cliente', 'Orders.cantidad', 'Orders.comentario', 'Orders.product_id', 'Orders.comanda_id', 'Orders.bool_pagado', 'Orders.id', 'Orders.pagado', 'Orders.precio', 'Orders.total', 'Orders.bool_pagado']],
                'Orders.Products'=>['fields'=>['Products.nombre', 'Products.id', 'Products.divisible']]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function obtieneClientes($localId=null, $comandaId=null){
        if(isset($localId)&&isset($comandaId)){
            $query=$this->find()
            ->select(['Comandas.clientes', 'Comandas.total'])
            ->where(['Comandas.user_id'=>$localId, 'Comandas.id'=>$comandaId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function validaComanda($comandaId){
        $query=$this->find()
        ->select(['id'])
        ->where(['id'=>$comandaId]);
        $query->enableHydration(false);
        $data = $query->toArray();
        if(empty($data)){
            return false;
        }else{
            return true;
        }
    }
    public function obtieneDetalleComanda($localId=null, $comandaId=null){
        if(isset($localId)&&isset($comandaId)){
            $query=$this->find()
            ->select(['Comandas.id', 'Comandas.salon_id', 'Comandas.table_id', 'Comandas.usuario_id', 'Comandas.folio', 'Comandas.total', 'Comandas.clientes', 'Comandas.created'])
            ->where(['Comandas.user_id'=>$localId, 'Comandas.id'=>$comandaId])
            ->contain([
                'Usuarios'=>['fields'=>['Usuarios.nombres']],
                'Salons'=>['fields'=>['Salons.nombre']],
                'Tables'=>['fields'=>['Tables.nombre', 'Tables.numero', 'Tables.id']]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function infoDashboard($localId=null){
        if(isset($localId)){
            $query=$this->find()
            ->select(['Comandas.id', 'Comandas.total', 'Comandas.pagado'])
            ->where(['Comandas.user_id'=>$localId]);
            $query->enableHydration(false);
            $data = $query->toArray();
            if(count($data)>0){
                $data2['comandas']=count($data);
                $data2['pendiente']=array();
                foreach ($data as $key => $value) {
                    array_push($data2['pendiente'], $value['total']-$value['pagado']);
                }
                $data2['pendiente']=array_sum($data2['pendiente']);
            }else{
                $data2['comandas']=0;
                $data2['pendiente']=0;
            }
            return $data2;
        }else{
            $data['comandas']=0;
            $data['pendiente']=0;
            return $data;
        }
    }
    public function procesaEdicion($localId=null, $tupla=null, $cantidad=null, $precio=null, $cantOriginal=null, $comandaId=null){
        if(isset($localId)&&isset($tupla)&&isset($cantidad)&&isset($precio)&&isset($cantOriginal)&&isset($comandaId)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $nuevoTotal=$cantidad*$precio;
            $montoDescontar=$precio*($cantOriginal-$cantidad);
            $update1=$connection->execute('UPDATE orders SET cantidad='.$cantidad.', total='.$nuevoTotal.' WHERE id='.$tupla.' AND user_id='.$localId.'');
            $update2=$connection->execute('UPDATE comandas SET total=total-'.$montoDescontar.' WHERE id='.$comandaId.' AND user_id='.$localId.'');
            if($update1&&$update2){
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
    public function procesaDcto($localId=null, $tupla=null, $comandaId=null, $monto=null, $total=null){
        if(isset($localId)&&isset($tupla)&&isset($comandaId)&&isset($monto)&&isset($total)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $nuevoTotal=$total-$monto;
            $update1=$connection->execute('UPDATE orders SET total=total-'.$monto.', precio='.$nuevoTotal.'/cantidad WHERE id='.$tupla.' AND user_id='.$localId.'');
            $update2=$connection->execute('UPDATE comandas SET total=total-'.$monto.' WHERE id='.$comandaId.' AND user_id='.$localId.'');
            if($update1&&$update2){
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
}
