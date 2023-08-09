<?php
declare(strict_types=1);
namespace App\Controller;
class CellarsController extends AppController{
    public function index(){
        $bodegas=$this->Cellars->ObtieneBodegas($this->request->getSession()->read('local.0.id'));
        $this->set(compact('bodegas'));
    }
    public function add(){
        if($this->request->is('post')){
            $cellarsTable = $this->getTableLocator()->get('Cellars'); 
            $insert = $cellarsTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->nombre=$this->request->getData()['nombre'];
            if($cellarsTable->save($insert)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Bodega Agregada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al crear la bodega';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Cellars', 'action' => 'index']);  
        }else{
            return $this->redirect(['controller'=>'Cellars', 'action' => 'index']);
        }
    }
}
