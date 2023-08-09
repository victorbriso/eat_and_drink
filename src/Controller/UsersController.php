<?php
declare(strict_types=1);
namespace App\Controller;
class UsersController extends AppController{
    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }
    public function login(){ 
        $this->viewBuilder()->setLayout('loginPlataforma');
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->request->getSession()->write('local', $this->Users->datosLocal($this->Authentication->getIdentity()->getIdentifier()));
            if($this->request->getSession()->read('local.0.cargador')){
                return $this->redirect(['controller'=>'Users','action'=>'loginUsuario']);
            }else{
                return $this->redirect(['controller'=>'Users','action'=>'cargador']);
            }         
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }
    public function login2(){ 
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    public function logout(){
        $result = $this->Authentication->getResult();
        $this->request->getSession()->delete('local');
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
    public function dashboard(){
        $this->loadModel('Tables');
        $this->loadModel('GeneralSaleDays');
        $this->loadModel('Comandas');
        $this->loadModel('FixedCosts');
        $mesas=$this->Tables->obtieneMesasOcupadas($this->request->getSession()->read('local.0.id'));
        $totalMesas=$this->Tables->obtieneTotalMesas($this->request->getSession()->read('local.0.id'));
        $totalVentas=$this->GeneralSaleDays->totalVentas($this->request->getSession()->read('local.0.id'),date('Y-m-d', time()));
        $dataComandas=$this->Comandas->infoDashboard($this->request->getSession()->read('local.0.id'));
        $costosDiarios=$this->FixedCosts->obtieneCostosDiarios($this->request->getSession()->read('local.0.id'));//prx($costosDiarios);
        $salones=array();
        foreach ($mesas as $key => $value) {
            $salones[$value['salon']['id']]=$value['salon']['nombre'];
        }//prx($dataComandas);
        $this->set(compact('mesas', 'salones', 'totalMesas', 'totalVentas', 'dataComandas', 'costosDiarios'));
    }
    public function contacto(){
        if($this->request->is('post')){
            $mailer = new Mailer('default');
            $mailer->setFrom(['plataforma@ceoalmacen.cl' => 'CEOalmacen'])
                ->setTo('plataforma@ceoalmacen.cl')
                ->setCc($this->request->getSession()->read('local.0.mail'))
                ->setSubject('->'.$this->request->getData()['asunto'])
                ->setReplyTo($this->request->getSession()->read('local.0.mail'));
            if($mailer->deliver($this->request->getData()['mensaje'])){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Mensaje enviado';
                $mensaje['texto']='Pronto nos pondremos en contacto contigo';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al enviar el mensaje';
                $mensaje['texto']='favor intentar nuevamente, o escribir al whatsapp';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Users', 'action' => 'contacto']);
        }
        $asuntos[1]='Consultas';
        $asuntos[2]='Felicitaciones';
        $asuntos[3]='Reclamos';
        $asuntos[4]='Otro';
        $this->set(compact('asuntos'));
    }
    public function consultaNotificaciones(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $this->loadModel('Tables');
        $data=$this->Tables->obtieneNotificaciones($this->request->getSession()->read('local.0.id'));
        $respuesta=$data;
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function finalizaNotificacion(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $productoTable = $this->getTableLocator()->get('Tables');
        $update=$productoTable->get($this->request->getData()['id']);
        $update->notificacion=0;
        if($productoTable->save($update)){
            $respuesta=1;
        }else{
            $respuesta=0;
        }
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function add(){
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    public function sistema(){
        if($this->request->is('post')){
            $dataReservas['admite']=(isset($this->request->getData()['reservas']))?1:0;
            $dataReservas['anticipacion']=0;
            $dataReservas['futuro']=0;
            $dataReservas['atraso']=0;
            $dataReservas['abono']=0;
            $userTable = $this->getTableLocator()->get('Users');
            $update=$userTable->get($this->request->getSession()->read('local.0.id'));
            $update->username=$this->request->getData()['usuario'];
            $update->nombre=$this->request->getData()['nombre'];
            $update->razon_social=$this->request->getData()['razonSocial'];
            $update->direccion=$this->request->getData()['direccion'];
            $update->venta_web=(isset($this->request->getData()['vta_web']))?1:0;
            $update->delivery=(isset($this->request->getData()['delivery']))?1:0;
            $update->inventario=(isset($this->request->getData()['inventario']))?1:0;
            $update->config_reservas=json_encode($dataReservas);
            if($userTable->save($update)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Información actualizada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al actualizar la información';
                $mensaje['texto']='favor intentar nuevamente, si el error continúa, comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Users', 'action' => 'sistema']);
        }
        $data=$this->Users->datosLocalEdit($this->request->getSession()->read('local.0.id'));
        $data[0]['config_reservas']=json_decode($data[0]['config_reservas'], true);
        $this->set(compact('data'));
    }
    public function cambioContrasenha(){
        if($this->request->is('post')){
            $userTable = $this->getTableLocator()->get('Users');
            $update=$userTable->get($this->request->getSession()->read('local.0.id'));
            $update->password=$this->request->getData()['pass1'];
            if($userTable->save($update)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Contraseña actualizada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al actualizar la contraseña';
                $mensaje['texto']='favor intentar nuevamente, si el error continúa, comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Users', 'action' => 'sistema']);
        }else{
            return $this->redirect(['controller'=>'Users', 'action' => 'cambioContrasenha']);
        }
    }
    public function configReserva(){
        if($this->request->is('post')){
            $userTable = $this->getTableLocator()->get('Users');
            $update=$userTable->get($this->request->getSession()->read('local.0.id'));
            $dataReservas['admite']=1;
            $dataReservas['anticipacion']=$this->request->getData()['anticipacion'];
            $dataReservas['futuro']=$this->request->getData()['futuro'];
            $dataReservas['atraso']=$this->request->getData()['atraso'];
            $dataReservas['abono']=$this->request->getData()['abono'];
            $update->config_reservas=json_encode($dataReservas);
            if($userTable->save($update)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Reservas configuradas correctamente';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al actualizar la información';
                $mensaje['texto']='favor intentar nuevamente, si el error continúa, comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Users', 'action' => 'sistema']);
        }else{
            return $this->redirect(['controller'=>'Users', 'action' => 'cambioContrasenha']);
        }
    }
    public function cargador(){
        $this->viewBuilder()->setLayout('cargador');
    }
    public function loginUsuario(){
        $this->viewBuilder()->setLayout('loginPlataforma');
        $this->loadModel('Usuarios');
        $listaUsuarios=$this->Usuarios->obtieneUsuariosSimple($this->request->getSession()->read('local.0.id'));//prx($listaUsuarios);
        $this->set(compact('listaUsuarios'));
    }
    public function validaLoginUsuario(){
        if($this->request->is('post')){
            $this->loadModel('Usuarios');
            $passUsuario=$this->Usuarios->obtieneUsuarioLogin($this->request->getSession()->read('local.0.id'), $this->request->getData()['usuarioId']);//prx($passUsuario);
            if(!empty($passUsuario)){
                if(password_verify($this->request->getData()['password'], $passUsuario[0]['password'])){
                    $passUsuario[0]['profile']['roles']=json_decode($passUsuario[0]['profile']['roles'], true);
                    $passUsuario[0]['profile']['inicio']=json_decode($passUsuario[0]['profile']['inicio'], true);
                    unset($passUsuario[0]['password']);
                    $dataUser=$passUsuario[0];
                    $this->request->getSession()->write('usuario', $dataUser);
                    return $this->redirect(['controller' =>$dataUser['profile']['inicio']['controller'], 'action' =>$dataUser['profile']['inicio']['action']]);
                }else{
                    return $this->redirect(['controller' => 'Users', 'action' => 'validaLoginUsuario']);
                }
            }else{
                return $this->redirect(['controller' => 'Users', 'action' => 'validaLoginUsuario']);
            }
        }else{
            return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
        }
    }
    public function configImpresoras(){
        if($this->request->is('post')){

        }else{
            $this->loadModel('Users');
            $impresorasDisponibles=$this->Users->obtieneImpresoras($this->request->getSession()->read('local.0.id'));
            
        }
    }
    public function pruebaInventario(){
        $this->loadModel('OkInventories');
        prx($this->OkInventories->procesaInventario());
    }
}
