<?php
declare(strict_types=1);
namespace App\Controller;
class TablesController extends AppController{
    public function index(){
        $mesas=$this->Tables->obtieneMesas($this->request->getSession()->read('local.0.id'));
        $this->loadModel('Salons');
        $salones=$this->Salons->obtieneSalones($this->request->getSession()->read('local.0.id'));
        $this->set(compact('mesas', 'salones'));
    }
    public function add(){
        if($this->request->is('post')){
            $this->loadModel('Users');
            $ultimaMesa=$this->Tables->obtieneUltimaMesa($this->request->getSession()->read('local.0.id'), $this->request->getData()['salonId']);
            $dataSave=array();
            for ($i = 1; $i <= $this->request->getData()['cantidad']; $i++) {
                $data2=array(
                    'user_id'=>$this->request->getSession()->read('local.0.id'),
                    'salon_id'=>$this->request->getData()['salonId'],
                    'numero'=>$ultimaMesa,
                    'nombre'=>$ultimaMesa,
                    'ocupado'=>0
                );
                $ultimaMesa++;
                array_push($dataSave, $data2);
            }
            $PriceListsTable = $this->getTableLocator()->get('Tables');
            $entities = $PriceListsTable->newEntities($dataSave);
            if($PriceListsTable->saveManyOrFail($entities)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Mesas agregadas con exito con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al agregar las mesas';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Tables', 'action' => 'index']);
        }else{
            return $this->redirect(['action' => 'index']);
        }
    }
}
