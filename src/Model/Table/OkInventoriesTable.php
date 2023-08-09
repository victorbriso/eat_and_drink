<?php
declare(strict_types=1);
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
class OkInventoriesTable extends Table{
    public function initialize(array $config): void{
        parent::initialize($config);
        $this->setTable('ok_inventories');
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
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker{
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        return $rules;
    }
    public function procesaInventario(){
        $connection = ConnectionManager::get('default');
        $connection->begin();
        $inventarioPendienteTable= new PendingInventoriesTable;
        $productosTable= new ProductsTable;
        $bodegasTable= new CellarsTable;
        $inventarioOk= new OkInventoriesTable;
        $inventariMovimientos= new InventoryMovementsTable;
        $productos=$inventarioPendienteTable->productosInventario();
        $idsInsumos=array();
        foreach ($productos as $key => $value) {
            if($value['product']['req_receta']){
                foreach ($value['product']['receta'] as $key2 => $value2) {
                    array_push($idsInsumos, $value2['insumoId']);
                }
            }else{
                array_push($idsInsumos, $value['product']['data_combo']);
            }
            
        }
        $idsInsumos=array_unique($idsInsumos);
        $dataInsumos=$productosTable->obtieneInfoInsumos($idsInsumos);//prx($dataInsumos);
        $idsInvOk=array();
        $prodDescuentos2=array();
        foreach ($productos as $key => $value) {
            $bodegaPrincipal=$bodegasTable->obtieneBodegaPrincipal($value['user_id']);
            $prodDescuentos=array();
            if($value['product']['req_receta']){
                foreach ($value['product']['receta'] as $key2 => $value2) {
                    $cant=$value2['cantidad']*$value['cantidad'];
                    $cantSalida=$this->transformaUnidades($cant, $value2['unidadSalida'], $dataInsumos[$value2['insumoId']]['data_combo']);
                    $dataDCTO=array(
                        'user_id'=>$value['user_id'],
                        'product_id'=>$value2['insumoId'],
                        'tipo_movimiento'=>2,
                        'cellar_id'=>$bodegaPrincipal,
                        'cantidad'=>$cantSalida,
                        'valor'=>$cantSalida*$dataInsumos[$value2['insumoId']]['precio_anterior']
                    );
                    array_push($prodDescuentos, $dataDCTO);
                    array_push($prodDescuentos2, $dataDCTO);
                }    
            }else{
                $dataDCTO=array(
                    'user_id'=>$value['user_id'],
                    'product_id'=>$value['product']['data_combo'],
                    'tipo_movimiento'=>2,
                    'cellar_id'=>$bodegaPrincipal,
                    'cantidad'=>$value['cantidad'],
                    'valor'=>$value['cantidad']*$dataInsumos[$value['product']['data_combo']]['precio_anterior']
                );
                array_push($prodDescuentos, $dataDCTO);
                array_push($prodDescuentos2, $dataDCTO);
            }
            $dataInventarioGeneral[$value['id']]['user_id']=$value['user_id'];
            $dataInventarioGeneral[$value['id']]['product_id']=$value['product_id'];
            $dataInventarioGeneral[$value['id']]['cantidad']=$value['cantidad'];
            $dataInventarioGeneral[$value['id']]['total']=$value['total'];
            foreach ($prodDescuentos as $key3 => $value3) {
                $update=$connection->execute('UPDATE products SET precio_anterior=precio_anterior-'.$value3['valor'].', precio_actual=precio_actual-'.$value3['cantidad'].' WHERE id='.$value3['product_id'].'');
                if($update){
                    array_push($idsInvOk, $value['id']);
                }
            }
        }
        foreach ($dataInventarioGeneral as $key => $value) {
            if(!in_array($key, $idsInvOk)){
                unset($dataInventarioGeneral[$key]);
            }
        }
        $idsInvOk=array_unique($idsInvOk);
        $listaIdsOk=implode(',', $idsInvOk);
        $entities = $inventariMovimientos->newEntities($prodDescuentos2);
        $entities2 = $inventarioOk->newEntities($dataInventarioGeneral);
        if($inventariMovimientos->saveManyOrFail($entities)&&!empty($idsInvOk)&&$inventarioOk->saveManyOrFail($entities2)){
            try {
                $borrainventarioOk=$connection->execute('DELETE FROM pending_inventories WHERE id IN ('.$listaIdsOk.')');
            } catch (Exception $e) {
                $borrainventarioOk=0;
            }
            if($borrainventarioOk){
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
    public function transformaUnidades($cantidad, $unidadSalida, $unidadEntrada){
        if($unidadEntrada==1){
            return $cantidad;
        }elseif ($unidadEntrada==2) {
            if($unidadSalida==2){
                return $cantidad;
            }elseif ($unidadSalida==3) {
               return $cantidad*0.001;
            }
        }elseif ($unidadEntrada==3) {
            if($unidadSalida==2){
                return $cantidad*0.001;
            }elseif ($unidadSalida==3) {
               return $cantidad;
            }
        }elseif ($unidadEntrada==7) {
            if($unidadSalida==7){
                return $cantidad;
            }elseif ($unidadSalida==8) {
                return $cantidad*0.001;
            }
        }elseif ($unidadEntrada==8) {
            if($unidadSalida==7){
                return $cantidad*0.001;
            }elseif ($unidadSalida==8) {
                return $cantidad;
            }
        }
        return 0;
    }
}
