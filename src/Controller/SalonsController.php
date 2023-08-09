<?php
declare(strict_types=1);
namespace App\Controller;
class SalonsController extends AppController{
    public function index(){
        $mesas=$this->Salons->obtieneMesasPorSalon($this->request->getSession()->read('local.0.id'));
        foreach ($mesas as $key => $value) {
            foreach ($value['tables'] as $key2 => $value2) {
                if($value2['ocupado']){
                    array_push($mesas[$key]['ocupadas'], 1);
                }else{
                    array_push($mesas[$key]['libres'], 1);
                }
            }
            unset($mesas[$key]['tables']);
            $mesas[$key]['ocupadas']=array_sum($mesas[$key]['ocupadas']);
            $mesas[$key]['libres']=array_sum($mesas[$key]['libres']);
        }
        $this->set(compact('mesas'));
    }
    public function add(){
        if($this->request->is('post')){
            $salonsTable = $this->getTableLocator()->get('Salons'); 
            $insert=$salonsTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->nombre=$this->request->getData()['nombre'];
            $insert->estado=1;
            if($salonsTable->save($insert)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Salon creado con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al crear el salon';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Salons', 'action' => 'index']);
        }else{
            return $this->redirect(['action' => 'index']);
        }        
    }
    public function edit($id = null){
        
    }
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $salon = $this->Salons->get($id);
        if ($this->Salons->delete($salon)) {
            $this->Flash->success(__('The salon has been deleted.'));
        } else {
            $this->Flash->error(__('The salon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
