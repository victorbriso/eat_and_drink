<?php
declare(strict_types=1);
namespace App\Controller;
class BuySummariesController extends AppController{
    public function index(){
        $fin = date('Y-m-d');
        $inicio = date('Y-m-d', strtotime ( '-15 day',strtotime($fin)));
        $conditions=['BuySummaries.user_id'=>$this->request->getSession()->read('local.0.id'), 'BuySummaries.fecha_compra BETWEEN :start AND :end'];
        if($this->request->is('post')){
            //prx($this->request->getData());
            if($this->request->getData()['proveedor']==0){
                $conditions=['BuySummaries.user_id'=>$this->request->getSession()->read('local.0.id'), 'BuySummaries.fecha_compra BETWEEN :start AND :end'];
            }else{
                $conditions=['BuySummaries.user_id'=>$this->request->getSession()->read('local.0.id'), 'proveedor_id'=>$this->request->getData()['proveedor'], 'BuySummaries.fecha_compra BETWEEN :start AND :end'];
            }
            $fin = date('Y-m-d', strtotime($this->request->getData()['fin']));
            $inicio = date('Y-m-d', strtotime($this->request->getData()['inicio']));
        }
        $this->loadModel('Vendors');
        $listaProveedores=$this->Vendors->listaProveedores($this->request->getSession()->read('local.0.id'));
        $dataInforme=$this->BuySummaries->dataCompraResumen($conditions, $inicio, $fin);
        //prx($dataInforme);
        $nombresProductos=array();
        $detalleCompra=array();
        if(!empty($dataInforme)){
            $idsProductos=array();
            foreach ($dataInforme as $key1 => $value1) {
                $detalleCompra[$value1['id']]=$value1['buy_details'];
                foreach ($value1['buy_details'] as $key2 => $value2) {
                    array_push($idsProductos, $value2['product_id']);
                }
            }
            $idsProductos=array_unique($idsProductos);
            $this->loadModel('Products');
            $nombresProductos=$this->Products->listaProductosPorIds($this->request->getSession()->read('local.0.id'), $idsProductos);    
        }
        $codigos=file_get_contents('../webroot/files/sistema/codigosDocumentosSii.json');
        $codigos=json_decode($codigos, true);
        unset($codigos[40]);
        unset($codigos[43]);
        unset($codigos[48]);
        unset($codigos[103]);
        unset($codigos[110]);
        unset($codigos[111]);
        unset($codigos[112]);
        $this->set(compact('nombresProductos', 'detalleCompra', 'dataInforme', 'codigos', 'listaProveedores'));   
    }
    public function add(){
        $localId=$this->request->getSession()->read('local.0.id');
        if($this->request->is('post')){
            //prx($this->request->getData());
            if(isset($this->request->getData()['estado'])){
                $estado=3;
                $vtoDoc=$this->request->getData()['fechaCompra'];
            }else{
                $estado=1;
                $vtoDoc=date('Y-m-d',strtotime($this->request->getData()['fechaCompra'].'+ '.$this->request->getData()['dias'].' days'));
            }
            foreach ($this->request->getData()['data'] as $key1 => $value1) {
                foreach ($value1['detalleImpuestos'] as $key2 => $value2) {
                    if(isset($generalImpuestos[$value2['impuesto']])){
                        array_push($generalImpuestos[$value2['impuesto']], $value2['monto']);
                    }else{
                        $generalImpuestos[$value2['impuesto']][0]=$value2['monto'];
                    }
                }
            }
            foreach ($generalImpuestos as $key => $value) {
                $generalImpuestos[$key]=array_sum($value);
            }
            $insert['user_id']=$this->request->getSession()->read('local.0.id'); 
            $insert['vendor_id']=$this->request->getData()['proveedor'];
            $insert['fecha_compra']=$this->request->getData()['fechaCompra']; 
            $insert['dias']=$this->request->getData()['dias'];
            $insert['vencimiento']=$vtoDoc;
            $insert['neto']=$this->request->getData()['netoDocumento'];
            $insert['impuestos']=json_encode($generalImpuestos);
            $insert['estado']=$estado;
            $insert['documento']=$this->request->getData()['folio'];
            $insert['bruto']=$this->request->getData()['brutoDocumento'];
            $insert['tipo_documento']=33;
            $dataSaveDetalle=array();
            $dataSaveInventario=array();
            foreach ($this->request->getData()['data'] as $key1 => $value1) {
                $totalImpuestos=array();
                foreach ($value1['detalleImpuestos'] as $key2 => $value2) {
                    array_push($totalImpuestos, $value2['monto']);
                }
                $dataProducto=array(
                    'user_id'=>$this->request->getSession()->read('local.0.id'),
                    'product_id'=>$value1['prodId'],
                    'cantidad'=>$value1['cant'],
                    'neto'=>$value1['neto'],
                    'bruto'=>array_sum($totalImpuestos),
                    'impuestos'=>json_encode($value1['detalleImpuestos'])
                );
                $dataInventario=array(
                    'user_id'=>$this->request->getSession()->read('local.0.id'),
                    'product_id'=>$value1['prodId'],
                    'tipo_movimiento'=>1,
                    'cellar_id'=>$value1['bodega'],
                    'cantidad'=>$value1['cant'],
                    'valor'=>$value1['neto']/$value1['cant']
                );
                array_push($dataSaveDetalle, $dataProducto); 
                array_push($dataSaveInventario, $dataInventario);                    
            }
            $estadoTransaccion=$this->BuySummaries->ingresaCompra($insert, $dataSaveDetalle, $dataSaveInventario);
            if($estadoTransaccion){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Compra procesada con exito';
                $mensaje['texto']='El stock de esta compra esta actualizado';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Error al guardar la compra';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['action' => 'add']);
        }
        $this->loadModel('Vendors');
        $this->loadModel('Products');
        $this->loadModel('Cellars');
        $proveedores=$this->Vendors->listaProveedores($localId);
        $productos=$this->Products->listaProductosCompra($localId);
        $bodegas=$this->Cellars->obtieneBodegas($localId);
        $codigos=file_get_contents('../webroot/files/sistema/codigosDocumentosSii.json');
        $codigos=json_decode($codigos, true);
        $impuestos=file_get_contents('../webroot/files/sistema/impuestos.json');
        $impuestos=json_decode($impuestos, true);
        unset($codigos[40]);
        unset($codigos[43]);
        unset($codigos[48]);
        unset($codigos[103]);
        unset($codigos[110]);
        unset($codigos[111]);
        unset($codigos[112]);
        $listaProductos=array();
        foreach ($productos as $key => $value) {
            $listaProductos[$value['codigo_ean']]=$value;
        }//prx($listaProductos);
        $this->set(compact('proveedores', 'productos', 'codigos', 'impuestos', 'listaProductos', 'bodegas'));
    }
    public function addExtra(){
        $localId=$this->request->getSession()->read('local.0.id');
        if($this->request->is('post')){
            if(isset($this->request->getData()['estado'])){
                $estado=3;
            }else{
                $estado=1;
            }
            $dataProveedor['rut']=$this->request->getData()['proveedor'];
            $dataProveedor['nombre']=$this->request->getData()['proveedorNombre'];
            $dataProveedor['local_id']=$localId;
            $provTable = $this->getTableLocator()->get('Proveedores');
            $insertProv = $provTable->newEntity($dataProveedor);
            $provTable->save($insertProv);
            $data['local_id']=$localId;
            $data['proveedor_id']=$insertProv->id;
            $data['documento']=$this->request->getData()['folio'];
            $data['fecha']=$this->request->getData()['fechaCompra'];
            $data['neto']=$this->request->getData()['netoDocumento'];
            $data['bruto']=$this->request->getData()['brutoDocumento'];
            $data['estado']=$estado;
            $data['tipo_documento']=33;
            $data['dias']=(int)$this->request->getData()['dias'];
            $generalImpuestos=array();
            foreach ($this->request->getData()['data'] as $key1 => $value1) {
                foreach ($value1['detalleImpuestos'] as $key2 => $value2) {
                    if(isset($generalImpuestos[$value2['impuesto']])){
                        array_push($generalImpuestos[$value2['impuesto']], $value2['monto']);
                    }else{
                        $generalImpuestos[$value2['impuesto']][0]=$value2['monto'];
                    }
                }
            }
            foreach ($generalImpuestos as $key => $value) {
                $generalImpuestos[$key]=array_sum($value);
            }
            $data['impuestos']=json_encode($generalImpuestos);
            $productos = $this->getTableLocator()->get('CompraResumenes');
            $insert = $productos->newEntity($data);
            if($productos->save($insert)){
                $dataSaveDetalle=array();
                foreach ($this->request->getData()['data'] as $key1 => $value1) {
                    $dataProducto=array(
                        'compra_resumen_id'=>$insert->id,
                        'producto_id'=>$value1['prodId'],
                        'cantidad'=>$value1['cant'],
                        'neto'=>$value1['neto'],
                        'impuestos'=>json_encode($value1['detalleImpuestos'])
                    );
                    array_push($dataSaveDetalle, $dataProducto);                    
                }
                $productosDetalle = $this->getTableLocator()->get('CompraDetalles');
                $insert2 = $productosDetalle->newEntities($dataSaveDetalle);
                if($productosDetalle->saveMany($insert2)){
                    $this->loadModel('InventarioResumenes');
                    $estadoStock=$this->InventarioResumenes->procesaCompraDetalle($localId, $dataSaveDetalle, $insert->id);
                    if($estadoStock){
                        $mensaje['tipo']='success';
                        $mensaje['titulo']='Compra procesada con exito';
                        $mensaje['texto']='El stock de esta compra esta actualizado';
                    }else{
                        $mensaje['tipo']='error';
                        $mensaje['titulo']='Compra ingresada, stock no actualizado';
                        $mensaje['texto']='El stock de esta compra será ingresado en los proximos 5 minutos';
                    }
                }else{
                    $this->CompraResumenes->delete($this->CompraResumenes->get($insert->id));
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Error al guardar el producto';
                    $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                }
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Error al guardar el producto';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'CompraResumenes', 'action' => 'addExtra']);
        }
        $this->loadModel('Productos');
        $productos=$this->Productos->listaProductosCompra($localId);
        $codigos=file_get_contents('../webroot/files/sistema/codigosDocumentosSii.json');
        $codigos=json_decode($codigos, true);
        $impuestos=file_get_contents('../webroot/files/sistema/impuestos.json');
        $impuestos=json_decode($impuestos, true);
        unset($codigos[40]);
        unset($codigos[43]);
        unset($codigos[48]);
        unset($codigos[103]);
        unset($codigos[110]);
        unset($codigos[111]);
        unset($codigos[112]);
        foreach ($productos as $key => $value) {
            $listaProductos[$value['codigo_ean']]=$value;
        }
        $this->set(compact('productos', 'codigos', 'impuestos', 'listaProductos'));
    }
    public function compraBoleta(){
        $localId=$this->request->getSession()->read('local.0.id');
        if($this->request->is('post')){
            if(isset($this->request->getData()['estado'])){
                $estado=3;
            }else{
                $estado=1;
            }
            $dataProveedor['rut']=$this->request->getData()['proveedor'];
            $dataProveedor['nombre']=$this->request->getData()['proveedorNombre'];
            $docRel['doc']=array();
            $docRel['extra']=$dataProveedor;
            $data['local_id']=$localId;
            $data['proveedor_id']=4;
            $data['documento']=$this->request->getData()['folio'];
            $data['fecha']=$this->request->getData()['fechaCompra'];
            $data['neto']=$this->request->getData()['netoDocumento'];
            $data['bruto']=$this->request->getData()['brutoDocumento'];
            $data['estado']=$estado;
            $data['tipo_documento']=33;
            $data['dias']=(int)$this->request->getData()['dias'];
            $data['documentos_relacionados']=json_encode($docRel);
            $generalImpuestos=array();
            foreach ($this->request->getData()['data'] as $key1 => $value1) {
                foreach ($value1['detalleImpuestos'] as $key2 => $value2) {
                    if(isset($generalImpuestos[$value2['impuesto']])){
                        array_push($generalImpuestos[$value2['impuesto']], $value2['monto']);
                    }else{
                        $generalImpuestos[$value2['impuesto']][0]=$value2['monto'];
                    }
                }
            }
            foreach ($generalImpuestos as $key => $value) {
                $generalImpuestos[$key]=array_sum($value);
            }
            $data['impuestos']=json_encode($generalImpuestos);
            $productos = $this->getTableLocator()->get('CompraResumenes');
            $insert = $productos->newEntity($data);
            if($productos->save($insert)){
                $dataSaveDetalle=array();
                foreach ($this->request->getData()['data'] as $key1 => $value1) {
                    $dataProducto=array(
                        'compra_resumen_id'=>$insert->id,
                        'producto_id'=>$value1['prodId'],
                        'cantidad'=>$value1['cant'],
                        'neto'=>$value1['neto'],
                        'impuestos'=>json_encode($value1['detalleImpuestos'])
                    );
                    array_push($dataSaveDetalle, $dataProducto);                    
                }
                $productosDetalle = $this->getTableLocator()->get('CompraDetalles');
                $insert2 = $productosDetalle->newEntities($dataSaveDetalle);
                if($productosDetalle->saveMany($insert2)){
                    $this->loadModel('InventarioResumenes');
                    $estadoStock=$this->InventarioResumenes->procesaCompraDetalle($localId, $dataSaveDetalle, $insert->id);
                    if($estadoStock){
                        $mensaje['tipo']='success';
                        $mensaje['titulo']='Compra procesada con exito';
                        $mensaje['texto']='El stock de esta compra esta actualizado';
                    }else{
                        $mensaje['tipo']='error';
                        $mensaje['titulo']='Compra ingresada, stock no actualizado';
                        $mensaje['texto']='El stock de esta compra será ingresado en los proximos 5 minutos';
                    }
                }else{
                    $this->CompraResumenes->delete($this->CompraResumenes->get($insert->id));
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Error al guardar el producto';
                    $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                }
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Error al guardar el producto';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'CompraResumenes', 'action' => 'compraBoleta']);
        }
        $this->loadModel('Productos');
        $productos=$this->Productos->listaProductosCompra($localId);
        $codigos=file_get_contents('../webroot/files/sistema/codigosDocumentosSii.json');
        $codigos=json_decode($codigos, true);
        $impuestos=file_get_contents('../webroot/files/sistema/impuestos.json');
        $impuestos=json_decode($impuestos, true);
        unset($codigos[40]);
        unset($codigos[43]);
        unset($codigos[48]);
        unset($codigos[103]);
        unset($codigos[110]);
        unset($codigos[111]);
        unset($codigos[112]);
        foreach ($productos as $key => $value) {
            $listaProductos[$value['codigo_ean']]=$value;
        }
        $this->set(compact('productos', 'codigos', 'impuestos', 'listaProductos'));
    }
}
