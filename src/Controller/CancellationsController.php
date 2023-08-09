<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Cancellations Controller
 *
 * @property \App\Model\Table\CancellationsTable $Cancellations
 * @method \App\Model\Entity\Cancellation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CancellationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Usuarios'],
        ];
        $cancellations = $this->paginate($this->Cancellations);

        $this->set(compact('cancellations'));
    }

    /**
     * View method
     *
     * @param string|null $id Cancellation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cancellation = $this->Cancellations->get($id, [
            'contain' => ['Users', 'Usuarios'],
        ]);

        $this->set(compact('cancellation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cancellation = $this->Cancellations->newEmptyEntity();
        if ($this->request->is('post')) {
            $cancellation = $this->Cancellations->patchEntity($cancellation, $this->request->getData());
            if ($this->Cancellations->save($cancellation)) {
                $this->Flash->success(__('The cancellation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cancellation could not be saved. Please, try again.'));
        }
        $users = $this->Cancellations->Users->find('list', ['limit' => 200]);
        $usuarios = $this->Cancellations->Usuarios->find('list', ['limit' => 200]);
        $this->set(compact('cancellation', 'users', 'usuarios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cancellation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cancellation = $this->Cancellations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cancellation = $this->Cancellations->patchEntity($cancellation, $this->request->getData());
            if ($this->Cancellations->save($cancellation)) {
                $this->Flash->success(__('The cancellation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cancellation could not be saved. Please, try again.'));
        }
        $users = $this->Cancellations->Users->find('list', ['limit' => 200]);
        $usuarios = $this->Cancellations->Usuarios->find('list', ['limit' => 200]);
        $this->set(compact('cancellation', 'users', 'usuarios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cancellation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cancellation = $this->Cancellations->get($id);
        if ($this->Cancellations->delete($cancellation)) {
            $this->Flash->success(__('The cancellation has been deleted.'));
        } else {
            $this->Flash->error(__('The cancellation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
