<?php
declare(strict_types=1);
namespace App\Controller;
class CashboxesController extends AppController{
    public function index(){
        $roles['cajas']['add']=1;
        $cajas=$this->Cashboxes->obtieneCajas($this->request->getSession()->read('local.0.id'));//prx($cajas);
        $this->loadModel('Usuarios');
        $cajeros=$this->Usuarios->obtieneCajeros($this->request->getSession()->read('local.0.id'));
        $this->set(compact('roles', 'cajas', 'cajeros'));
    }
    public function view($id = null){
    }
    public function add(){
    }
    public function asignarUsuarioCaja($cajaId=null, $usuarioId=null){
        if(isset($cajaId)&&isset($usuarioId)){
            $cashboxesTable = $this->getTableLocator()->get('Cashboxes');
            $updateCaja=$cashboxesTable->get($cajaId);
            $updateCaja->usuario_id=$usuarioId;
            $updateCaja->estado=1;
            if($cashboxesTable->save($updateCaja)){
                $usuarioTable = $this->getTableLocator()->get('Usuarios');
                $updateUsuario=$usuarioTable->get($usuarioId);
                $updateUsuario->caja_activa=1;
                if($usuarioTable->save($updateUsuario)){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Usuario asignado correctamente';
                    $mensaje['texto']='';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Error al actualizar el usuario';
                    $mensaje['texto']='Si el error continua comunicarse con soporte';
                }
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Error al asignar el usuario';
                $mensaje['texto']='Si el error continua comunicarse con soporte';
            }
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Error de seguridad';
            $mensaje['texto']='Si el error continua comunicarse con soporte';
        }
        $this->request->getSession()->write('mensajeAlerta', $mensaje);
        return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
    }
    public function apertura(){
        if($this->request->is('post')){
            $cashboxesTable = $this->getTableLocator()->get('Cashboxes');
            $updateCaja=$cashboxesTable->get($this->request->getData()['apertura_caja_id']);
            $updateCaja->efectivo=$this->request->getData()['monto'];
            $updateCaja->total=$this->request->getData()['monto'];
            $updateCaja->monto_apertura=$this->request->getData()['monto'];
            $updateCaja->fecha_apertura=date('Y-m-d H:i:s', time());
            $updateCaja->estado=2;
            if($cashboxesTable->save($updateCaja)){
                $cashboxesMovTable = $this->getTableLocator()->get('CashboxMovements'); 
                $insert = $cashboxesMovTable->newEmptyEntity();
                $insert->user_id =$this->request->getSession()->read('local.0.id');
                $insert->cashbox_id =$this->request->getData()['apertura_caja_id'];
                $insert->tipo_pago =1;
                $insert->monto=$this->request->getData()['monto'];
                if($cashboxesMovTable->save($insert)){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Caja abierta con exito';
                    $mensaje['texto']='';
                }else{
                    $updateCaja->estado=2;
                    $cashboxesTable->save($updateCaja);
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Error al abrir la caja';
                    $mensaje['texto']='Si el error continua comunicarse con soporte';
                }
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Error al abrir la caja';
                $mensaje['texto']='Si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }
    }
    public function ingresoRetiro(){
        if($this->request->is('post')){
            if($this->request->getData()['tipo']==2 || $this->request->getData()['tipo']==3){
                $this->loadModel('Cashboxes');
                $data=$this->request->getData();
                $data['monto']=str_replace(".", "", $this->request->getData()['monto']);
                $usuarioId=1;
                $resultado=$this->Cashboxes->realizaRetiroIngreso($data, $this->request->getSession()->read('local.0.id'), $usuarioId);
                if($resultado){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Operación realizada con exito';
                    $mensaje['texto']='';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Ocurrió un error al realizar la operación';
                    $mensaje['texto']='Si el error continua comunicarse con soporte';
                }
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
            }else{
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
            }
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }
    }
    public function pagoCuenta(){
        if($this->request->is('post')){
            $this->loadModel('FolioCashes');
            $dataFolio=$this->FolioCashes->obtieneFolio($this->request->getData()['folio'], $this->request->getSession()->read('local.0.id'));
            if(!empty($dataFolio)){
                $productos=explode(',', $dataFolio[0]['productos']);
                $this->loadModel('Orders');
                $pedidosPorId=$this->Orders->pedidosPorId($this->request->getSession()->read('local.0.id'), $productos);
                $cajaId=$this->request->getData()['caja_id_modal_pago'];
                $folio=$this->request->getData()['folio'];
                $cajero=$this->request->getData()['cajero_id'];
                $this->set(compact('pedidosPorId', 'dataFolio', 'cajaId', 'folio', 'cajero'));
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Folio no disponible';
                $mensaje['texto']='Se debe generar un nuevo folio de cobro';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
            }
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }
    }
    public function generarPagoCuenta(){
        if($this->request->is('post')){
            $inventario=$this->request->getSession()->read('local.0.inventario');
            $this->loadModel('GeneralSaleDays');
            $fecha=date('Y-m-d', time());
            $idVentaGeneral=$this->GeneralSaleDays->obtieneIdVentaGeneral($this->request->getSession()->read('local.0.id'), $fecha);
            if(is_array($idVentaGeneral)){
                if(isset($idVentaGeneral[0]['id'])){
                    $idVentaGeneral2=$idVentaGeneral[0]['id'];
                }else{
                    $GeneralSaleDaysTable = $this->getTableLocator()->get('GeneralSaleDays');
                    $insert = $GeneralSaleDaysTable->newEmptyEntity();
                    $insert->user_id=$this->request->getSession()->read('local.0.id');
                    $insert->dia=$fecha;
                    $insert->monto=0;
                    if ($GeneralSaleDaysTable->save($insert)) {
                        $idVentaGeneral2 = $insert->id;
                    }else{
                        $mensaje['tipo']='error';
                        $mensaje['titulo']='Ocurrio un error al generar el total de ventas';
                        $mensaje['texto']='Se debe generar un nuevo folio de cobro';
                        $this->request->getSession()->write('mensajeAlerta', $mensaje);
                        return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
                    }
                }
                $resultadoPago=$this->Cashboxes->procesaPagos($this->request->getSession()->read('local.0.id'), $inventario, $this->request->getData(), $idVentaGeneral2);
                if($resultadoPago){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Pago procesado con exito';
                    $mensaje['texto']='';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Ocurrio un error en el proceso de pago, si continúa, favor comunicarse con soporte';
                    $mensaje['texto']='Se debe generar un nuevo folio de cobro';
                }
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio al obtener el total de venta';
                $mensaje['texto']='Se debe generar un nuevo folio de cobro';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
            }            
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }
    }
    public function cajasEstado($id=null){
        if(isset($id)){
            $dataCaja=$this->Cashboxes->detalleCaja($this->request->getSession()->read('local.0.id'), $id);//prx($dataCaja);
            if(!empty($dataCaja)){
                $tiposMovimientosCaja=$this->tiposMovimientosCaja();
                $this->set(compact('dataCaja', 'tiposMovimientosCaja'));
            }else{
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
            }
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }
    }
    public function tiposMovimientosCaja(){
        $tiposMovimientosCaja=file_get_contents('../webroot/files/sistema/tiposMovimientosCaja.json');
        $tiposMovimientosCaja=json_decode($tiposMovimientosCaja, true);
        return $tiposMovimientosCaja;
    }
    public function cierre($id=null){
        if(isset($id)){
            $dataCaja=$this->Cashboxes->detalleCaja($this->request->getSession()->read('local.0.id'), $id);//prx($dataCaja);
            if(!empty($dataCaja)){
                $tiposMovimientosCaja=$this->tiposMovimientosCaja();
                $this->set(compact('dataCaja', 'tiposMovimientosCaja'));
            }else{
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
            }
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }
    }
    public function procesaCierre(){
        if($this->request->is('post')){
            $efectivoCaja=$this->request->getData()['efecCaja'];
            $cajaId=$this->request->getData()['cajaId'];
            $dataCaja=$this->Cashboxes->detalleCajaCierre($this->request->getSession()->read('local.0.id'), $cajaId);
            $retiros=array();
            $ingresos=array();
            foreach ($dataCaja[0]['cashbox_movements'] as $key => $value) {
                if($value['tipo_pago']==2){
                    array_push($ingresos, $value['monto']);
                }elseif ($value['tipo_pago']==3) {
                    array_push($retiros, $value['monto']);
                }else{
                    continue;
                }
            }
            $retiros=array_sum($retiros);
            $ingresos=array_sum($ingresos);
            if($efectivoCaja>$dataCaja[0]['efectivo']){
                $descuadre=$efectivoCaja-$dataCaja[0]['efectivo'];
            }elseif ($efectivoCaja<$dataCaja[0]['efectivo']) {
                $descuadre=$efectivoCaja-$dataCaja[0]['efectivo'];
            }elseif ($efectivoCaja==$dataCaja[0]['efectivo']) {
                $descuadre=0;
            }
            $resultadoCierre=$this->Cashboxes->procesaCierreModel($this->request->getSession()->read('local.0.id'), $dataCaja, $efectivoCaja, $ingresos, $retiros, $descuadre, $cajaId);
            if($resultadoCierre){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Cierre procesado con exito';
                $mensaje['texto']='';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'detalleHistoricoCaja', $resultadoCierre]);
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error en el proceso de cierre';
                $mensaje['texto']='Intentar de nuevo, si continúa, favor comunicarse con soporte';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'cierre', $cajaId]);
            }
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'index']);
        }
    }
    public function detalleHistoricoCaja($id=null){
        if(isset($id)){
            $this->loadModel('HistoricalCashboxed');
            $dataCaja=$this->HistoricalCashboxed->obtieneHistoricoCaja($this->request->getSession()->read('local.0.id'), $id);//prx($dataCaja);
            if(!empty($dataCaja)){
                $tiposMovimientosCaja=$this->tiposMovimientosCaja();
                $this->set(compact('dataCaja', 'tiposMovimientosCaja'));
            }else{
                return $this->redirect(['controller'=>'Cashboxes', 'action' => 'historicoCaja']);
            }
        }else{
            return $this->redirect(['controller'=>'Cashboxes', 'action' => 'historicoCaja']);
        }
    }
    public function historicoCaja(){
        $this->loadModel('HistoricalCashboxed');
        $ultimosCierres=$this->HistoricalCashboxed->obtieneUltimosCierres($this->request->getSession()->read('local.0.id'));//prx($ultimosCierres);
        $this->set(compact('ultimosCierres'));
    }
    public function consultaHistoricoFecha(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $this->loadModel('HistoricalCashboxed');
        $data=$this->HistoricalCashboxed->obtieneHistoricoCajaRango($this->request->getSession()->read('local.0.id'), $this->request->getData()['desde'], $this->request->getData()['termino']);
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($data));
    }
}
