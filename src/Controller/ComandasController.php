<?php
declare(strict_types=1);
namespace App\Controller;
class ComandasController extends AppController{
    public function index(){
        $this->loadModel('Tables');
        $authDcto=1;
        $authEdit=1;
        $this->loadModel('Salons');
        $salones=$this->Salons->obtieneSalones($this->request->getSession()->read('local.0.id'));
        $comandas=$this->Comandas->obtieneComandas($this->request->getSession()->read('local.0.id'));
        //prx($comandas);
        $this->set(compact('salones', 'comandas', 'authDcto', 'authEdit'));
    }
    public function comandaNueva($mesaId=null){
        if(isset($mesaId)){
            $this->loadModel('Tables');
            $infoMesa=$this->Tables->mesaDisponible($this->request->getSession()->read('local.0.id'), $mesaId);
            if(!empty($infoMesa)){
                $userId=1;
                $carta=json_decode(file_get_contents('../webroot/files/cartas/'.$this->request->getSession()->read('local.0.id').'.json'), true);
                $localId=$this->request->getSession()->read('local.0.id');
                //prx($carta);
                $this->set(compact('userId', 'mesaId', 'carta', 'infoMesa', 'localId'));
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='La mesa ya esta ocupada';
                $mensaje['texto']='';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(array('action' => 'mesasComandaNueva'));
            }
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Error de seguridad';
            $mensaje['texto']='';
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(array('action' => 'mesasComandaNueva'));
        }
    }
    public function mesasComandaNueva(){
        $this->loadModel('Salons');
        $this->loadModel('Tables');
        $salones=$this->Salons->obtieneSalones($this->request->getSession()->read('local.0.id'));
        $mesas=$this->Tables->obtieneMesasLibres($this->request->getSession()->read('local.0.id'));
        if(!empty($mesas)){          
            $this->set(compact('mesas', 'salones')); 
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='No hay mesas disponibles';
            $mensaje['texto']='';
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(array('action' => 'index'));
        }
    }
    public function add(){
        if($this->request->is('post')){
            $this->loadModel('Folios');
            $folioComanda=$this->Folios->obtieneFolio($this->request->getSession()->read('local.0.id'), 1);
            $totalComanda=array();
            $dataSavePedido=array();
            foreach ($this->request->getData()['Pedido'] as $key => $value) {
                array_push($totalComanda, $value['total']);
                $clientes[$value['id_cliente']]=$value['nombre'];
                $data=array(
                    'user_id'=>$this->request->getSession()->read('local.0.id'),
                    'product_id'=>$value['producto_carta_id'],
                    'cantidad'=>$value['cantidad'],
                    'precio'=>$value['precio'],
                    'total'=>$value['total'],
                    'pagado'=>0,
                    'divisible'=>$value['divisible'],
                    'cliente'=>$value['id_cliente'],
                );
                array_push($dataSavePedido, $data);
            }
            $comandaTable = $this->getTableLocator()->get('Comandas');
            $insert = $comandaTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->salon_id=$this->request->getData()['Comanda']['salon_id'];
            $insert->table_id=$this->request->getData()['Comanda']['mesa_id'];
            $insert->usuario_id=$this->request->getData()['Comanda']['usuario_id'];
            $insert->folio=$folioComanda;
            $insert->total=array_sum($totalComanda);
            $insert->pagado=0;
            $insert->clientes=json_encode($clientes);
            if($comandaTable->save($insert)){
                $comandaId=$insert->id;
                foreach ($dataSavePedido as $key => $value) {
                    $dataSavePedido[$key]['comanda_id']=$comandaId;
                }
                $ordersTable = $this->getTableLocator()->get('Orders');
                $entities = $ordersTable->newEntities($dataSavePedido);
                if($ordersTable->saveMany($entities)){
                    $tableTable = $this->getTableLocator()->get('Tables');
                    $update = $tableTable->get($this->request->getData()['Comanda']['mesa_id']);
                    $update->ocupado=1;
                    $tableTable->save($update);
                    $this->impresionComanda($this->request->getData()['Pedido']);
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Comanda creada con exito';
                    $mensaje['texto']='';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Ocurrio un error al crear la comanda';
                    $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                    $entity = $this->$comandaTable->get($comandaId);
                    $this->$comandaTable->delete($entity);
                }
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(array('action' => 'index'));
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Error al ingresar la comanda';
                $mensaje['texto']='Si el error continúa, comunicarse con soporte';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(array('action' => 'index'));
            }
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Error de seguridad';
            $mensaje['texto']='';
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(array('action' => 'index'));
        }
    }
    public function edit($comandaId=null){
        if(isset($comandaId)){
            $this->loadModel('Tables');
            $userId=1;
            $carta=json_decode(file_get_contents('../webroot/files/cartas/'.$this->request->getSession()->read('local.0.id').'.json'), true);
            $dataComanda=$this->Comandas->obtieneComanda($this->request->getSession()->read('local.0.id'),$comandaId);//prx($dataComanda);
            $infoMesa=$this->Tables->mesaDisponible($this->request->getSession()->read('local.0.id'), $dataComanda[0]['table_id']);
            $localId=$this->request->getSession()->read('local.0.id');
            $totalProductos=array();
            foreach ($dataComanda[0]['orders'] as $key => $value) {
                array_push($totalProductos, $value['cantidad']);
            }
            $totalProductos=array_sum($totalProductos);
            $this->set(compact('comandaId', 'userId', 'carta', 'infoMesa', 'dataComanda', 'localId', 'totalProductos'));
        }else{
            return $this->redirect(array('action' => 'index'));
        }
    }
    private function impresionComanda($data){
        return true;
    }
    private function impresionCuenta($data){
        return true;
    }
    public function addExistente(){
        $dataSavePedido=array();
        $infoMesa=$this->Comandas->obtieneClientes($this->request->getSession()->read('local.0.id'),$this->request->getData()['Comanda']['id']);
        $clientesMesa=json_decode($infoMesa[0]['clientes'], true);
        $totalPedido=array();
        foreach ($this->request->getData()['Pedido'] as $key => $value) {
            if(!array_key_exists($value['id_cliente'], $clientesMesa)){
                $clientesMesa[$value['id_cliente']]=$value['nombre'];
            }
            $data=array(
                'user_id'=>$this->request->getSession()->read('local.0.id'),
                'product_id'=>$value['producto_carta_id'],
                'cantidad'=>$value['cantidad'],
                'precio'=>$value['precio'],
                'total'=>$value['total'],
                'pagado'=>0,
                'divisible'=>$value['divisible'],
                'cliente'=>$value['id_cliente'],
                'comanda_id'=>$this->request->getData()['Comanda']['id']
            );
            array_push($dataSavePedido, $data);
            array_push($totalPedido, $value['total']);
        }
        $comandasTable = $this->getTableLocator()->get('Comandas');
        $update = $comandasTable->get($this->request->getData()['Comanda']['id']);
        $update->clientes=json_encode($clientesMesa);
        $update->total=$infoMesa[0]['total']+array_sum($totalPedido);
        $comandasTable->save($update);
        $ordersTable = $this->getTableLocator()->get('Orders');
        $entities = $ordersTable->newEntities($dataSavePedido);
        if($ordersTable->saveMany($entities)){
            $this->impresionComanda($this->request->getData()['Pedido']);
            $mensaje['tipo']='success';
            $mensaje['titulo']='Comanda creada con exito';
            $mensaje['texto']='';
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Ocurrio un error al crear la comanda';
            $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
        }
        $this->request->getSession()->write('mensajeAlerta', $mensaje);
        return $this->redirect(array('action' => 'index'));
    }
    public function cuenta($comandaId=null){
        if(isset($comandaId)){
            $comanda=$this->Comandas->obtieneComanda($this->request->getSession()->read('local.0.id'), $comandaId);//prx($comanda);
            if(!empty($comanda)){
                $pedidos=array();
                foreach ($comanda[0]['orders'] as $key => $value) {
                    array_push($pedidos, $value['cantidad']);
                }
                $pedidos=array_sum($pedidos);
                $clientes=json_decode($comanda[0]['clientes'] , true);
                $this->set(compact('comanda', 'pedidos', 'clientes'));
            }else{
                return $this->redirect(array('action' => 'index'));
            }            
        }else{
            return $this->redirect(array('action' => 'index'));
        }
    }
    public function ajaxFolioDisponible(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $this->loadModel('Folios');
        $data=$this->Folios->obtieneFolio($this->request->getSession()->read('local.0.id'), 2);
        $respuesta=$data;
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function generarCuenta(){
        if ($this->request->is('post')){
            if(isset($this->request->getData()['VoucherGeneral'])){
                $idComanda=$this->request->getData()['VoucherGeneral']['comanda_id'];
            }elseif(isset($this->request->getData()['VoucherEspecifico'])){
                $idComanda=$this->request->getData()['VoucherEspecifico']['comanda_id'];
            }
            if($this->Comandas->validaComanda($idComanda)){
                $folioCashesTable = $this->getTableLocator()->get('FolioCashes');
                $insert = $folioCashesTable->newEmptyEntity();
                if (isset($this->request->getData()['VoucherGeneral'])){
                    $insert->user_id          = $this->request->getSession()->read('local.0.id');
                    $insert->comanda_id       = $this->request->getData()['VoucherGeneral']['comanda_id'];
                    $insert->table_id         = $this->request->getData()['VoucherGeneral']['mesa_id'];
                    $insert->productos        = $this->request->getData()['VoucherGeneral']['id_pedido'];
                    $insert->folio            = $this->request->getData()['VoucherGeneral']['folio'];
                    $insert->monto            = $this->request->getData()['VoucherGeneral']['monto_VoucherGeneral']; 
                    $insert->propina          = $this->request->getData()['VoucherGeneral']['propina'];
                    $folio=$this->request->getData()['VoucherGeneral']['folio'];
                }
                elseif( isset($this->request->getData()['VoucherEspecifico'])){
                    $insert->user_id          = $this->request->getSession()->read('local.0.id');
                    $insert->comanda_id       = $this->request->getData()['VoucherEspecifico']['comanda_id'];
                    $insert->table_id         = $this->request->getData()['VoucherEspecifico']['mesa_id'];
                    $insert->productos        = $this->request->getData()['VoucherEspecifico']['id_pedido'];
                    $insert->folio            = $this->request->getData()['VoucherEspecifico']['folio'];
                    $insert->monto            = $this->request->getData()['VoucherEspecifico']['monto_voucher']; 
                    $insert->propina          = $this->request->getData()['VoucherEspecifico']['propina'];
                    $folio=$this->request->getData()['VoucherGeneral']['folio'];
                }
                if($folioCashesTable->save($insert)){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Cuenta generada, Folio # '.$folio;
                    $mensaje['texto']='';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='No es posible registrar la cuenta de la comanda, por favor intentar mas tarde';
                    $mensaje['texto']='';
                }
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
            }
            /*if ( $this->Auth->user('usuario_vista_garzon') ){
                return $this->redirect('/vistaGarzon');
            }*/
            return $this->redirect(array('action' => 'index'));
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='No es posible registrar la cuenta de la comanda, por favor intentar mas tarde';
            $mensaje['texto']='';
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            /*if ( $this->Auth->user('usuario_vista_garzon') ){
                return $this->redirect('/vistaGarzon');
            }*/
            $this->redirect('index');
        }   
    }
    public function descuento($comandaId=null){
        if($this->request->is('post')){
            if($this->Comandas->procesaDcto($this->request->getSession()->read('local.0.id'), $this->request->getData()['tupla'], $this->request->getData()['comandaId'], $this->request->getData()['montoDcto'], $this->request->getData()['totalTupla'])){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Comanda editada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al procesar la información';
                $mensaje['texto']='Favor intentar nuevamente, si el error contiúa, comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(array('action' => 'index'));
        }
        if(isset($comandaId)){
            $dataComanda=$this->Comandas->obtieneComanda($this->request->getSession()->read('local.0.id'), $comandaId);//prx($dataComanda);
            $this->set(compact('dataComanda'));
        }else{
            return $this->redirect(array('action' => 'index'));
        }
    }
    public function editar($comandaId=null){
        if($this->request->is('post')){
            if($this->Comandas->procesaEdicion($this->request->getSession()->read('local.0.id'), $this->request->getData()['tupla'], $this->request->getData()['cantidad'], $this->request->getData()['precio'], $this->request->getData()['cantOriginal'], $this->request->getData()['comandaId'])){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Comanda editada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al procesar la información';
                $mensaje['texto']='Favor intentar nuevamente, si el error contiúa, comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(array('action' => 'index'));
        }
        if(isset($comandaId)){
            $dataComanda=$this->Comandas->obtieneComanda($this->request->getSession()->read('local.0.id'), $comandaId);//prx($dataComanda);
            $this->set(compact('dataComanda'));
        }else{
            return $this->redirect(array('action' => 'index'));
        }
    }
}
