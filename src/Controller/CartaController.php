<?php
declare(strict_types=1);
namespace App\Controller;
class CartaController extends AppController{
	public function beforeFilter(\Cake\Event\EventInterface $event){
        $this->Authentication->addUnauthenticatedActions(['carta', 'contacto', 'contrato', 'notificacionCarta', 'versionCarta', 'cartaWeb', 'cartaDelivery']);
    }
    public function carta($codigoLocalMesa=null){
        $this->viewBuilder()->setLayout('carta');
        /*if(isset($this->request->getSession()->read('local.0.id'))){
            return $this->redirect(['controller'=>'Comandas', 'action' => 'addMobile']);
        }*/
        if(isset($codigoLocalMesa)){
            if(strlen($codigoLocalMesa)==11){
                $token = $this->request->getAttribute('csrfToken');
                $this->loadModel('Tables');
                $dataLocal=$this->Tables->infoLocalMesa($codigoLocalMesa);//prx($dataLocal);
                if(!empty($dataLocal)){
                    $mesa=$dataLocal[0]['id'];
                    $version=$dataLocal[0]['user']['version'];
                    $localId=$dataLocal[0]['user']['id'];
                    $this->request->getSession()->write('cliente.codigoLocal', $codigoLocalMesa);
                    $this->request->getSession()->write('cliente.localId', $localId);
                    $this->request->getSession()->write('cliente.mesa', $mesa);
                    $carta=ROOT.'/webroot/files/cartas/'.$localId.'.json';
                    $carta=json_decode(file_get_contents($carta), true);
                    $this->set(compact('carta', 'localId', 'version', 'mesa', 'token'));
                }else{
                    return $this->redirect(['controller'=>'Pages', 'action' => 'index']);
                }               
            }else{
                return $this->redirect(['controller'=>'Pages', 'action' => 'index']);
            }           
        }else{
            return $this->redirect(['controller'=>'Pages', 'action' => 'index']);
        }
    }
    public function notificacionCarta(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $this->loadModel('Tables');
        $data=$this->Tables->actualizaNotificaionCliente($this->request->getData()['mesa'],$this->request->getData()['tipo']);
        $respuesta=$data;
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function versionCarta(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $this->loadModel('Users');
        $data=$this->Users->validaVersionCarta($this->request->getData()['local']);
        if($data[0]['version']==$this->request->getData()['version']){
            $respuesta=0;
        }else{
            $respuesta=1;
        }
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function cartaWeb($localId=null){
        if(isset($localId)){
            $this->loadModel('Users');
            $dataLocal=$this->Users->dataLocalCarta($localId);
            $carta=ROOT.'/webroot/files/cartas/cartaweb_'.$localId.'.json';
            $carta=json_decode(file_get_contents($carta), true);
            if($dataLocal[0]['plan']==1){
                $this->viewBuilder()->setLayout('cartaWebBasica');
            }else{
                $this->viewBuilder()->setLayout('cartaWebCompleta');
            }//prx($dataLocal);
            $this->set(compact('carta', 'dataLocal', 'localId'));
        }else{
            return $this->redirect(['controller'=>'Pages', 'action' => 'index']);
        }
    }
    public function cartaDelivery($localId=null){
        
    }
}