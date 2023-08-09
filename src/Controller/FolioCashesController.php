<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FolioCashes Controller
 *
 * @property \App\Model\Table\FolioCashesTable $FolioCashes
 * @method \App\Model\Entity\FolioCash[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FolioCashesController extends AppController
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
        $folioCashes = $this->paginate($this->FolioCashes);

        $this->set(compact('folioCashes'));
    }

    /**
     * View method
     *
     * @param string|null $id Folio Cash id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $folioCash = $this->FolioCashes->get($id, [
            'contain' => ['Users', 'CashboxMovements', 'Orders'],
        ]);

        $this->set(compact('folioCash'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $folioCash = $this->FolioCashes->newEmptyEntity();
        if ($this->request->is('post')) {
            $folioCash = $this->FolioCashes->patchEntity($folioCash, $this->request->getData());
            if ($this->FolioCashes->save($folioCash)) {
                $this->Flash->success(__('The folio cash has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folio cash could not be saved. Please, try again.'));
        }
        $users = $this->FolioCashes->Users->find('list', ['limit' => 200]);
        $this->set(compact('folioCash', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folio Cash id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $folioCash = $this->FolioCashes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $folioCash = $this->FolioCashes->patchEntity($folioCash, $this->request->getData());
            if ($this->FolioCashes->save($folioCash)) {
                $this->Flash->success(__('The folio cash has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The folio cash could not be saved. Please, try again.'));
        }
        $users = $this->FolioCashes->Users->find('list', ['limit' => 200]);
        $this->set(compact('folioCash', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folio Cash id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $folioCash = $this->FolioCashes->get($id);
        if ($this->FolioCashes->delete($folioCash)) {
            $this->Flash->success(__('The folio cash has been deleted.'));
        } else {
            $this->Flash->error(__('The folio cash could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
