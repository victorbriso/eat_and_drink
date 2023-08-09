<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * HistoricalCommands Controller
 *
 * @property \App\Model\Table\HistoricalCommandsTable $HistoricalCommands
 * @method \App\Model\Entity\HistoricalCommand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HistoricalCommandsController extends AppController
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
        $historicalCommands = $this->paginate($this->HistoricalCommands);

        $this->set(compact('historicalCommands'));
    }

    /**
     * View method
     *
     * @param string|null $id Historical Command id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $historicalCommand = $this->HistoricalCommands->get($id, [
            'contain' => ['Users', 'Usuarios'],
        ]);

        $this->set(compact('historicalCommand'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $historicalCommand = $this->HistoricalCommands->newEmptyEntity();
        if ($this->request->is('post')) {
            $historicalCommand = $this->HistoricalCommands->patchEntity($historicalCommand, $this->request->getData());
            if ($this->HistoricalCommands->save($historicalCommand)) {
                $this->Flash->success(__('The historical command has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The historical command could not be saved. Please, try again.'));
        }
        $users = $this->HistoricalCommands->Users->find('list', ['limit' => 200]);
        $usuarios = $this->HistoricalCommands->Usuarios->find('list', ['limit' => 200]);
        $this->set(compact('historicalCommand', 'users', 'usuarios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Historical Command id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $historicalCommand = $this->HistoricalCommands->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $historicalCommand = $this->HistoricalCommands->patchEntity($historicalCommand, $this->request->getData());
            if ($this->HistoricalCommands->save($historicalCommand)) {
                $this->Flash->success(__('The historical command has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The historical command could not be saved. Please, try again.'));
        }
        $users = $this->HistoricalCommands->Users->find('list', ['limit' => 200]);
        $usuarios = $this->HistoricalCommands->Usuarios->find('list', ['limit' => 200]);
        $this->set(compact('historicalCommand', 'users', 'usuarios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Historical Command id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $historicalCommand = $this->HistoricalCommands->get($id);
        if ($this->HistoricalCommands->delete($historicalCommand)) {
            $this->Flash->success(__('The historical command has been deleted.'));
        } else {
            $this->Flash->error(__('The historical command could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
