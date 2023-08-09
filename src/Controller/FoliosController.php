<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Folios Controller
 *
 * @property \App\Model\Table\FoliosTable $Folios
 * @method \App\Model\Entity\Folio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoliosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $folios = $this->paginate($this->Folios);

        $this->set(compact('folios'));
    }

    /**
     * View method
     *
     * @param string|null $id Folio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $folio = $this->Folios->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('folio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $folio = $this->Folios->newEmptyEntity();
        if ($this->request->is('post')) {
            $folio = $this->Folios->patchEntity($folio, $this->request->getData());
            if ($this->Folios->save($folio)) {
                $this->Flash->success(__('The folio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folio could not be saved. Please, try again.'));
        }
        $users = $this->Folios->Users->find('list', ['limit' => 200]);
        $this->set(compact('folio', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $folio = $this->Folios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $folio = $this->Folios->patchEntity($folio, $this->request->getData());
            if ($this->Folios->save($folio)) {
                $this->Flash->success(__('The folio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folio could not be saved. Please, try again.'));
        }
        $users = $this->Folios->Users->find('list', ['limit' => 200]);
        $this->set(compact('folio', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $folio = $this->Folios->get($id);
        if ($this->Folios->delete($folio)) {
            $this->Flash->success(__('The folio has been deleted.'));
        } else {
            $this->Flash->error(__('The folio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
