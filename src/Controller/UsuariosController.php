<?php
declare(strict_types=1);
namespace App\Controller;
class UsuariosController extends AppController{
    public function index(){
        $this->loadModel('Usuarios');
        $data=$this->Usuarios->obtieneUsuarios($this->request->getSession()->read('local.0.id'));//prx($data);
        $this->set(compact('data'));
    }
    public function add(){
        
    }
    public function edit($id = null){
        $usuario = $this->Usuarios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('The usuario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usuario could not be saved. Please, try again.'));
        }
        $users = $this->Usuarios->Users->find('list', ['limit' => 200]);
        $profiles = $this->Usuarios->Profiles->find('list', ['limit' => 200]);
        $this->set(compact('usuario', 'users', 'profiles'));
    }
}
