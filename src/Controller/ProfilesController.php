<?php
declare(strict_types=1);
namespace App\Controller;
class ProfilesController extends AppController{
    public function index(){
        $this->loadModel('Profiles');
        $data=$this->Profiles->obtienePerfiles($this->request->getSession()->read('local.0.id'));//prx($data);
        $inicios=$this->generalObtienePagInicio();//prx($inicios);
        $this->set(compact('data', 'inicios'));
    }
    public function add(){
        if($this->request->is('post')){
            //prx($this->request->getData());
            if(!empty($this->request->getData()['data'])){
                foreach ($this->request->getData()['data'] as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        $permisos[$key][$key2]=1;
                    }
                }
                $productoTable = $this->getTableLocator()->get('Profiles'); 
                $insert = $productoTable->newEmptyEntity();
                $insert->user_id=$this->request->getSession()->read('local.0.id');
                $insert->nombre=$this->request->getData()['nombre'];
                $insert->roles=json_encode($permisos);
                if($productoTable->save($insert)){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Perfil creado con exito';
                    $mensaje['texto']='';
                    $retorno='index';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Ocurrio un error al crear el perfil';
                    $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                    $retorno='add';
                }
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Debe seleccionar al menos un permiso';
                $mensaje['texto']='';
                $retorno='add';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Profiles', 'action' => $retorno]);            
        }
        $perfilesSistema=$this->generalObtienePerfiles();
        $inicios=$this->generalObtienePagInicio();
        $this->set(compact('perfilesSistema', 'inicios'));
    }
    public function edit($id = null){
        if($this->request->is('post')){//prx($this->request->getData());
            if(!empty($this->request->getData()['data'])){
                foreach ($this->request->getData()['data'] as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        $permisos[$key][$key2]=1;
                    }
                }
                $inicio['controller']=$this->request->getData()['controller'];
                $inicio['action']=$this->request->getData()['action'];
                $productoTable = $this->getTableLocator()->get('Profiles'); 
                $update=$productoTable->get($this->request->getData()['id']);
                $update->nombre=$this->request->getData()['nombre'];
                $update->roles=json_encode($permisos);
                $update->inicio=json_encode($inicio);
                if($productoTable->save($update)){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Perfil actualizado con exito';
                    $mensaje['texto']='';
                    $retorno='index';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Ocurrio un error al actualizar el perfil';
                    $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                    $retorno='edit, '.$this->request->getData()['id'];
                }
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Debe seleccionar al menos un permiso';
                $mensaje['texto']='';
                $retorno='edit, '.$this->request->getData()['id'];
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Profiles', 'action' => $retorno]);            
        }
        if(isset($id)){
            $perfilEdit=$this->Profiles->obtienePerfil($this->request->getSession()->read('local.0.id'), $id);
            if(!empty($perfilEdit)){
                $perfilEdit[0]['roles']=json_decode($perfilEdit[0]['roles'], true);
                $perfilesSistema=$this->generalObtienePerfiles();
                $inicios=$this->generalObtienePagInicio();//prx($perfilesSistema);
                $this->set(compact('perfilesSistema', 'inicios', 'perfilEdit'));
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='El perfil no existe';
                $mensaje['texto']='NO INGRESAR COSAS POR URL, EL USUARIO PODRÍA SER BLOQUEADO';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Profiles', 'action' => 'index']);
            }            
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='El perfil no existe';
            $mensaje['texto']='NO INGRESAR COSAS POR URL, EL USUARIO PODRÍA SER BLOQUEADO';
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Profiles', 'action' => 'index']); 
        }        
    }
    public function pruebas(){
        //prx(json_encode($this->generalObtienePerfiles()));
        $data['controller']='Users';
        $data['action']='dashboard';
        prx(json_encode($data));
    }
}
