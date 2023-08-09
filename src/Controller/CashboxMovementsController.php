<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CashboxMovements Controller
 *
 * @property \App\Model\Table\CashboxMovementsTable $CashboxMovements
 * @method \App\Model\Entity\CashboxMovement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CashboxMovementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Cashboxes', 'FolioCashes'],
        ];
        $cashboxMovements = $this->paginate($this->CashboxMovements);

        $this->set(compact('cashboxMovements'));
    }

    /**
     * View method
     *
     * @param string|null $id Cashbox Movement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cashboxMovement = $this->CashboxMovements->get($id, [
            'contain' => ['Users', 'Cashboxes', 'FolioCashes'],
        ]);

        $this->set(compact('cashboxMovement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cashboxMovement = $this->CashboxMovements->newEmptyEntity();
        if ($this->request->is('post')) {
            $cashboxMovement = $this->CashboxMovements->patchEntity($cashboxMovement, $this->request->getData());
            if ($this->CashboxMovements->save($cashboxMovement)) {
                $this->Flash->success(__('The cashbox movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cashbox movement could not be saved. Please, try again.'));
        }
        $users = $this->CashboxMovements->Users->find('list', ['limit' => 200]);
        $cashboxes = $this->CashboxMovements->Cashboxes->find('list', ['limit' => 200]);
        $folioCashes = $this->CashboxMovements->FolioCashes->find('list', ['limit' => 200]);
        $this->set(compact('cashboxMovement', 'users', 'cashboxes', 'folioCashes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cashbox Movement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cashboxMovement = $this->CashboxMovements->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cashboxMovement = $this->CashboxMovements->patchEntity($cashboxMovement, $this->request->getData());
            if ($this->CashboxMovements->save($cashboxMovement)) {
                $this->Flash->success(__('The cashbox movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cashbox movement could not be saved. Please, try again.'));
        }
        $users = $this->CashboxMovements->Users->find('list', ['limit' => 200]);
        $cashboxes = $this->CashboxMovements->Cashboxes->find('list', ['limit' => 200]);
        $folioCashes = $this->CashboxMovements->FolioCashes->find('list', ['limit' => 200]);
        $this->set(compact('cashboxMovement', 'users', 'cashboxes', 'folioCashes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cashbox Movement id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cashboxMovement = $this->CashboxMovements->get($id);
        if ($this->CashboxMovements->delete($cashboxMovement)) {
            $this->Flash->success(__('The cashbox movement has been deleted.'));
        } else {
            $this->Flash->error(__('The cashbox movement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
