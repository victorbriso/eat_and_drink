<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
class BuySummariesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('buy_summaries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
        ]);
        $this->hasMany('BuyDetails', [
            'foreignKey' => 'buy_summary_id',
        ]);
    }
    public function validationDefault(Validator $validator): Validator{
        $validator
            ->allowEmptyString('id', null, 'create');
        $validator
            ->date('fecha_compra')
            ->allowEmptyDate('fecha_compra');
        $validator
            ->integer('dias')
            ->allowEmptyString('dias');
        $validator
            ->date('vencimiento')
            ->allowEmptyDate('vencimiento');
        $validator
            ->decimal('neto')
            ->allowEmptyString('neto');
        $validator
            ->scalar('impuestos')
            ->maxLength('impuestos', 4294967295)
            ->allowEmptyString('impuestos');
        $validator
            ->allowEmptyString('estado');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'), ['errorField' => 'vendor_id']);
        return $rules;
    }
    public function dataCompraResumen($conditions=null, $inicio=null, $termino=null){
        if(isset($conditions)&&isset($inicio)&&isset($termino)){
            $query=$this->find()
            ->select(['BuySummaries.id', 'BuySummaries.vendor_id', 'BuySummaries.documento', 'BuySummaries.fecha_compra', 'BuySummaries.neto', 'BuySummaries.bruto', 'BuySummaries.impuestos', 'BuySummaries.tipo_documento', 'BuySummaries.dias'])
            ->where($conditions)
            ->bind(':start', $inicio,'date')
            ->bind(':end', $termino,'date')
            ->contain(
                [
                    'BuyDetails'=>['fields'=>[
                    'BuyDetails.buy_summary_id', 'BuyDetails.product_id', 'BuyDetails.cantidad', 'BuyDetails.neto', 'BuyDetails.impuestos'
                    ]
                ], 
                    'Vendors'=>['fields'=>['Vendors.nombre', 'Vendors.razon_social']]
                ]
            );
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function comprasPendientes($localId=null, $proveedorId=null){
        if(isset($localId)&&isset($proveedorId)){
            $estados=array(1,2);
            $query=$this->find()
            ->select(['id', 'vendor_id', 'documento', 'fecha_compra', 'neto', 'bruto', 'estado', 'tipo_documento', 'documentos_relacionados', 'dias'])
            ->where(['BuySummaries.user_id'=>$localId, 'BuySummaries.vendor_id'=>$proveedorId, 'BuySummaries.estado IN'=>$estados])
            ->contain(['Vendors'=>['fields'=>['Vendors.nombre', 'Vendors.razon_social']]])
            ->order(['BuySummaries.estado'=>'ASC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function documentosVdosXVencer($localId=null){
        if(isset($localId)){
            $estados=array(1,2);
            $query=$this->find()
            ->select(['id', 'vendor_id', 'documento', 'fecha_compra', 'neto', 'bruto', 'estado', 'tipo_documento', 'dias'])
            ->where(['BuySummaries.user_id'=>$localId, 'BuySummaries.estado IN'=>$estados])
            ->contain([
                'Vendors'=>['fields'=>['Vendors.nombre', 'Vendors.razon_social']],
                'BuyDetails'
            ])
            ->order(['BuySummaries.estado'=>'DESC']);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function ResdocumentosVdosXVencer($localId=null){
        if(isset($localId)){
            $estados=array(1,2);
            $query=$this->find()
            ->select(['id', 'vendor_id', 'documento', 'fecha_compra', 'neto', 'bruto', 'estado', 'tipo_documento', 'dias'])
            ->where(['BuySummaries.user_id'=>$localId, 'BuySummaries.estado IN'=>$estados])
            ->contain([
                'Vendors'=>['fields'=>['Vendors.nombre', 'Vendors.razon_social']]
            ]);
            $query->enableHydration(false);
            $data = $query->toArray();
            return $data;
        }else{
            return array();
        }
    }
    public function ingresaCompra($general=null, $productos=null, $inventario=null){
        if(isset($general)&&isset($productos)&&isset($inventario)&&is_array($general)&&is_array($productos)&&is_array($inventario)){
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $fecha=date('Y-m-d H:i:s', time());
            $fecha2=date('Y-m-d', time());
           //$detalleCompra = new BuyDetailsTable;
            $saveGeneral=$this->newEntity($general);
            if($this->save($saveGeneral)){
                $idGeneral=$saveGeneral->id;
                //prx($productos);
                foreach ($productos as $key => $value) {
                    $productos[$key]['buy_summary_id']=$idGeneral;
                }
                $detalleCompra = new BuyDetailsTable;
                $inventarioTable = new InventoryMovementsTable;
                $entities = $detalleCompra->newEntities($productos);
                $entities2 = $inventarioTable->newEntities($inventario);
                $productoTable=new ProductsTable;
                if($detalleCompra->saveManyOrFail($entities)&&$inventarioTable->saveManyOrFail($entities2)){
                    $estadoTransaccion=array();
                    foreach ($productos as $key => $value) {
                        $prodId=$value['product_id'];
                        $precio=$value['neto'];
                        $cantidad=$value['cantidad'];
                        $dataProducto=$productoTable->datosPMP($prodId, $general['user_id']);
                        if(is_array($dataProducto)&&!empty($dataProducto)){
                            $nuevoCosto=($precio+$dataProducto[0]['precio_anterior'])/($cantidad+$dataProducto[0]['precio_actual']);
                            $actualizaCosto=$connection->execute('UPDATE products SET precio_anterior='.$nuevoCosto.', precio_actual=precio_actual+'.$cantidad.' WHERE id='.$prodId.' AND user_id='.$general['user_id'].'');
                            if($actualizaCosto){
                                array_push($estadoTransaccion, 1);
                            }else{
                                array_push($estadoTransaccion, 0);
                            }
                        }                        
                    }
                    if(count($productos)==array_sum($estadoTransaccion)){
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
            }else{
                $connection->rollback();
                return false;
            }
        }else{
            return false;
        }
    }
}
