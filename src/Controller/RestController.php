<?php
declare(strict_types=1);
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\EventInterface;
class RestController extends AppController{
    public function initialize(): void{
        parent::initialize();
        $this->loadComponent('Security');        
    }
    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['impresoras']);
        $this->Authentication->addUnauthenticatedActions(['prueba', 'impresoras']);
        $this->Security->setConfig('validatePost', false);
    }
	public function impresoras(){
        if($this->request->is('post')){
            if(isset($this->request->getData()['impresoras'])&&isset($this->request->getData()['local'])&&isset($this->request->getData()['hash'])){
                $this->loadModel('Users');
                $validacion=$this->Users->validacionHashImpresion($this->request->getData()['local'], $this->request->getData()['hash']);
                if($validacion){
                    $UsersTable = $this->getTableLocator()->get('Users');
                    $update=$UsersTable->get($validacion);
                    $update->impresoras=$this->request->getData()['impresoras'];
                    if($UsersTable->save($update)){
                        $respuesta['respuesta']='se guardo';
                    }else{
                        $respuesta['respuesta']='no se guardo';
                    }
                }else{
                    $respuesta['respuesta']='no';
                }                
            }else{
                $respuesta['respuesta']='falta info';
            }
        }else{
            $respuesta['respuesta']='error';
        }
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function prueba(){
        
    }
}