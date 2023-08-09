<?php
declare(strict_types=1);
namespace App\Controller;
class FixedCostsController extends AppController{
    public function index(){
        $frecuencias[1]='Diario';
        $frecuencias[2]='Semanal';
        $frecuencias[3]='Quincenal';
        $frecuencias[4]='Mensual';
        $frecuencias[5]='Trimestral';
        $frecuencias[6]='Semestral';
        $frecuencias[7]='Anual';
        $factor[1]=1;
        $factor[2]=7;
        $factor[3]=15;
        $factor[4]=30;
        $factor[5]=90;
        $factor[6]=180;
        $factor[7]=360;
        $costosFijos = $this->FixedCosts->obtieneCostos($this->request->getSession()->read('local.0.id'));
        $dataGraf=array();
        foreach ($costosFijos as $key => $value) {
            $costosFijos[$key]['equiv']=$value['monto']/$factor[$value['freciencia']];
            $varGraf['label']=$value['concepto'];
            $varGraf['value']=$value['monto']/$factor[$value['freciencia']];
            array_push($dataGraf, $varGraf);
        }
        $this->set(compact('costosFijos', 'frecuencias', 'dataGraf'));
    }
    public function add(){
        if($this->request->getData()['frecuencia']==1){
            $factor=1;
        }elseif ($this->request->getData()['frecuencia']==2) {
            $factor=7;
        }elseif ($this->request->getData()['frecuencia']==3) {
            $factor=15;
        }elseif ($this->request->getData()['frecuencia']==4) {
            $factor=30;
        }elseif ($this->request->getData()['frecuencia']==5) {
            $factor=90;
        }elseif ($this->request->getData()['frecuencia']==6) {
            $factor=180;
        }elseif ($this->request->getData()['frecuencia']==7) {
            $factor=360;
        }
        
        $costosFijosTable = $this->getTableLocator()->get('FixedCosts');  
        $insert = $costosFijosTable->newEmptyEntity();
        $insert->user_id=$this->request->getSession()->read('local.0.id');
        $insert->concepto=$this->request->getData()['concepto'];
        $insert->freciencia=$this->request->getData()['frecuencia'];
        $insert->monto=$this->request->getData()['monto'];
        $insert->diario=ceil($this->request->getData()['monto']/$factor);
        if($costosFijosTable->save($insert)){
            $mensaje['tipo']='success';
            $mensaje['titulo']='Costo Fijo agregado con exito';
            $mensaje['texto']='';           
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Error al agregar la informacion';
            $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
        }
        $this->request->getSession()->write('mensajeAlerta', $mensaje);
        return $this->redirect(['controller'=>'FixedCosts', 'action' => 'index']);
    }
}
