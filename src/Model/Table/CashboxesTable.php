<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
class CashboxesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('cashboxes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Salons', [
            'foreignKey' => 'salon_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('CashboxMovements', [
            'foreignKey' => 'cashbox_id',
        ]);
        $this->hasMany('HistoricalCashboxed', [
            'foreignKey' => 'cashbox_id',
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
            ->decimal('total')
            ->allowEmptyString('total');
        $validator
            ->decimal('efectivo')
            ->allowEmptyString('efectivo');
        $validator
            ->decimal('monto_apertura')
            ->allowEmptyString('monto_apertura');
        $validator
            ->dateTime('fecha_apertura')
            ->allowEmptyDateTime('fecha_apertura');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['salon_id'], 'Salons'), ['errorField' => 'salon_id']);
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'), ['errorField' => 'usuario_id']);
        return $rules;
    }
    public function obtieneCajas($lcoalId=null){
        if(isset($lcoalId)){
            $query=$this->find()
            ->select(['Cashboxes.id', 'Cashboxes.user_id', 'Cashboxes.salon_id', 'Cashboxes.nombre', 'Cashboxes.estado', 'Cashboxes.total', 'Cashboxes.efectivo', 'Cashboxes.usuario_id'])
            ->where(['Cashboxes.user_id'=>$lcoalId])
            ->contain(['Usuarios'=>['fields'=>['Usuarios.id', 'Usuarios.nombres', 'Usuarios.apellidos']]]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function realizaRetiroIngreso($data=null, $local=null, $usuario=null){
        if(isset($data)&&is_array($data)&&isset($local)&&isset($usuario)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $fecha=date('Y-m-d H:i:s', time());
            if($data['tipo']==2){
                $comentario='ingreso '.$data['motivo'];
                $update=$connection->execute('UPDATE cashboxes SET efectivo=efectivo+'.$data['monto'].', total=total+'.$data['monto'].' WHERE id='.$data['caja_id'].'');
            }else{
                $comentario='retiro '.$data['motivo'];
                $update=$connection->execute('UPDATE cashboxes SET efectivo=efectivo-'.$data['monto'].', total=total+'.$data['monto'].' WHERE id='.$data['caja_id'].'');
            }
            $insert=$connection->execute('INSERT INTO cashbox_movements (user_id, cashbox_id, tipo_pago, monto, created, comentario, usuario_id) VALUES ('.$local.', '.$data['caja_id'].', '.$data['tipo'].', '.$data['monto'].', "'.$fecha.'", "'.$comentario.'", '.$usuario.')');
            if($insert&&$update){
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
    public function procesaPagos($localId=null, $inventario=null, $data=null, $idVentaGeneral=null){
        if(isset($localId)&&isset($inventario)&&isset($data)&&!empty($data)&&isset($idVentaGeneral)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $fecha=date('Y-m-d H:i:s', time());
            $fecha2=date('Y-m-d', time());
            $productos=explode(',', $data['pedido']);
            $Orders= new OrdersTable;
            $pedido=$Orders->pedidosPorId($localId, $productos);
            $vtaPorDia=array();
            $montoVenta=array();
            $dataSavePedido=array();
            foreach ($pedido as $key => $value) {
                $dataUpPedido=array(
                    'user_id'=>$localId, 
                    'product_id'=>$value['product_id'], 
                    'cantidad'=>$value['cantidad'], 
                    'total'=>$value['total']
                );
                $dataUpVta=array(
                    'user_id'=>$localId,
                    'product_id'=>$value['product_id'], 
                    'cantidad'=>$value['cantidad'], 
                    'valor'=>$value['total']/$value['cantidad'], 
                    'total'=>$value['total'], 
                    'dia'=>$fecha2
                );
                array_push($dataSavePedido, $dataUpPedido);
                array_push($vtaPorDia, $dataUpVta);
                array_push($montoVenta, $value['total']);
            }
            if($inventario){
                $invPendinteTable = new PendingInventoriesTable;
                $entities = $invPendinteTable->newEntities($dataSavePedido);
                if($invPendinteTable->saveMany($entities)){
                    $estadoInventario=true;
                }else{
                    $connection->rollback();
                    return false;
                }
            }
            $montoVenta=array_sum($montoVenta);
            if(!isset($estadoInventario)){$estadoInventario=true;}
            $dataSaveCaja=array();
            foreach ($data['data'] as $key => $value) {
                $dataJson=array(
                    'cancelado'=>$value['cancelado'],
                    'operacion'=>$value['codOperacion'],
                    'autorizacion'=>$value['codAuth'],
                    'vueltoTBK'=>$value['vueltoTBK'],
                    'vuelto'=>$value['vuelto']
                );
                $dataUpCaja=array(
                    'user_id'=>$localId,
                    'cashbox_id'=>$data['caja_id'],
                    'numero_folio_cash'=>$data['folio'],
                    'tipo_pago'=>$value['tipo'],
                    'monto'=>$value['cobro'],
                    'comentario'=>'pago',
                    'usuario_id'=>(int)$data['cajero_id'],
                    'data'=>json_encode($dataJson),
                    'propina'=>(int)$value['propina'],
                    'comanda_id'=>$data['comanda_id']
                );
                array_push($dataSaveCaja, $dataUpCaja);
            }
            $movCaja = new CashboxMovementsTable;
            $entities = $movCaja->newEntities($dataSaveCaja);
            $vtaDia = new SaleForDaysTable;
            $entities2 = $vtaDia->newEntities($vtaPorDia);
            if($movCaja->saveManyOrFail($entities)&&$vtaDia->saveManyOrFail($entities2)){
                $update=$connection->execute('UPDATE orders SET bool_pagado=1 WHERE id IN ('.$data['pedido'].')');
                if($update){
                    $pedidosComanda=$Orders->pedidosPendientesPago($localId, $data['comanda_id']);
                    if(is_array($pedidosComanda)){
                        if(count($pedidosComanda)>0){
                            $connection->commit();
                            return true;
                        }else{
                            $Comandas=new ComandasTable;
                            $pedidosComandaTotal=$Orders->pedidosPorComanda($localId, $data['comanda_id']);
                            $totalPedidos=array();
                            foreach ($pedidosComandaTotal as $key => $value) {
                                array_push($totalPedidos, $value['cantidad']);
                            }
                            $CashboxMovementsTable=new CashboxMovementsTable;
                            $detallePagosComanda=$CashboxMovementsTable->detallePagosComanda($localId, $data['comanda_id']);
                            $detalleComanda=$Comandas->obtieneDetalleComanda($localId, $data['comanda_id']);
                            $HistoricalCommandsTable = new HistoricalCommandsTable;
                            $insert = $HistoricalCommandsTable->newEmptyEntity();
                            $insert->user_id=$localId;
                            $insert->usuario_id=$data['cajero_id'];
                            $insert->folio_comanda=$detalleComanda[0]['folio'];
                            $insert->inicio=$detalleComanda[0]['created'];
                            $insert->termino=$fecha;
                            $insert->productos=array_sum($totalPedidos);
                            $insert->total=$detalleComanda[0]['total'];
                            $insert->data_comanda=json_encode($detalleComanda);
                            $insert->data_pedidos=json_encode($pedidosComandaTotal);
                            $insert->data_pago=json_encode($detallePagosComanda);
                            if($HistoricalCommandsTable->save($insert)){
                                $borraFolioPago=$connection->execute('DELETE FROM folio_cashes WHERE comanda_id='.$data['comanda_id'].' AND user_id='.$localId.'');
                                $borraPedidos=$connection->execute('DELETE FROM orders WHERE comanda_id='.$data['comanda_id'].' AND user_id='.$localId.'');
                                $borraComanda=$connection->execute('DELETE FROM comandas WHERE id='.$data['comanda_id'].' AND user_id='.$localId.'');
                                $liberaMesa=$connection->execute('UPDATE tables SET ocupado=0 WHERE id='.$data['mesa_id'].' AND user_id='.$localId.'');
                                $actualizaTotalVta=$connection->execute('UPDATE general_sale_days SET monto=monto+'.$montoVenta.' WHERE id='.$idVentaGeneral.' AND user_id='.$localId.'');
                                if($borraFolioPago&&$borraPedidos&&$borraComanda&&$liberaMesa&&$actualizaTotalVta){
                                    $connection->commit();
                                    return true;
                                }else{
                                    $connection->rollback();
                                    return false;
                                }
                            }else{
                                $connection->rollback();
                                return false;
                            }
                        }
                    }else{
                        $connection->rollback();
                        return false;
                    }
                }else{
                    $connection->rollback();
                    return false;
                }
            }else{
                $connection->rollback();
                return false;
            }
        }else{
            return false;
        }
    }
    public function detalleCaja($localId=null, $cajaId=null){
        if(isset($localId)&&isset($cajaId)){
            $query=$this->find()
            ->select(['Cashboxes.id', 'Cashboxes.user_id', 'Cashboxes.salon_id', 'Cashboxes.nombre', 'Cashboxes.estado', 'Cashboxes.total', 'Cashboxes.efectivo', 'Cashboxes.usuario_id', 'Cashboxes.monto_apertura', 'Cashboxes.fecha_apertura'])
            ->where(['Cashboxes.user_id'=>$localId, 'Cashboxes.id'=>$cajaId])
            ->contain([
                'Usuarios'=>['fields'=>['Usuarios.id', 'Usuarios.nombres', 'Usuarios.apellidos']],
                'Salons'=>['fields'=>['Salons.id', 'Salons.nombre']],
                'CashboxMovements'=>['conditions'=>['CashboxMovements.estado'=>0]]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function detalleCajaCierre($localId=null, $cajaId=null){
        if(isset($localId)&&isset($cajaId)){
            $query=$this->find()
            ->select(['Cashboxes.id', 'Cashboxes.user_id', 'Cashboxes.salon_id', 'Cashboxes.nombre', 'Cashboxes.estado', 'Cashboxes.total', 'Cashboxes.efectivo', 'Cashboxes.usuario_id', 'Cashboxes.monto_apertura', 'Cashboxes.fecha_apertura'])
            ->where(['Cashboxes.user_id'=>$localId, 'Cashboxes.id'=>$cajaId])
            ->contain([
                'Usuarios'=>['fields'=>['Usuarios.id', 'Usuarios.nombres', 'Usuarios.apellidos']],
                'Salons'=>['fields'=>['Salons.id', 'Salons.nombre']],
                'CashboxMovements'=>['conditions'=>['CashboxMovements.estado'=>0]]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function procesaCierreModel($localId=null, $dataCaja=null, $efectivo=null, $ingresos=null, $retiros=null, $descuadre=null, $cajaId=null){
        if(isset($localId)&&isset($dataCaja)&&isset($efectivo)&&isset($ingresos)&&isset($retiros)&&isset($descuadre)&&isset($cajaId)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $fecha=date('Y-m-d H:i:s', time()); 
            $HistoricalCashboxed= new HistoricalCashboxedTable;
            $insert = $HistoricalCashboxed->newEmptyEntity();           
            $insert->user_id=$localId;
            $insert->usuario_id=$dataCaja[0]['usuario_id'];
            $insert->apertura=$dataCaja[0]['fecha_apertura'];
            $insert->termino=$fecha;
            $insert->monto_apertura=$dataCaja[0]['monto_apertura'];
            $insert->monto_cierre=$dataCaja[0]['total'];
            $insert->ventas=$dataCaja[0]['monto_apertura'];
            $insert->ingresos=$ingresos;
            $insert->retiros=$retiros;
            $insert->movimientos=json_encode($dataCaja[0]['cashbox_movements']);
            $insert->descuadre=$descuadre;
            $insert->efectivo_caja=$efectivo; 
            $insert->efectivo_sistema=$dataCaja[0]['efectivo'];
            $insert->cashbox_id=$cajaId;         
            if($HistoricalCashboxed->save($insert)){
                $borraMovCaja=$connection->execute('DELETE FROM cashbox_movements WHERE cashbox_id='.$cajaId.' AND user_id='.$localId.'');
                $actualizaCaja=$connection->execute('UPDATE cashboxes SET estado=0, total=0, efectivo=0, monto_apertura=0 WHERE id='.$cajaId.' AND user_id='.$localId.'');
                if($borraMovCaja&&$actualizaCaja){
                    $connection->commit();
                    return $insert->id;
                }else{
                    $connection->rollback();
                    return false;
                }
            }else{
                $connection->rollback();
                return false;
            }
        }else{
            return false;
        }
    }
}
