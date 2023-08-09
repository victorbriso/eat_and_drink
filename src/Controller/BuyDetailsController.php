<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BuyDetails Controller
 *
 * @property \App\Model\Table\BuyDetailsTable $BuyDetails
 * @method \App\Model\Entity\BuyDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BuyDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'BuySummaries', 'Products'],
        ];
        $buyDetails = $this->paginate($this->BuyDetails);

        $this->set(compact('buyDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Buy Detail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $buyDetail = $this->BuyDetails->get($id, [
            'contain' => ['Users', 'BuySummaries', 'Products'],
        ]);

        $this->set(compact('buyDetail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $buyDetail = $this->BuyDetails->newEmptyEntity();
        if ($this->request->is('post')) {
            $buyDetail = $this->BuyDetails->patchEntity($buyDetail, $this->request->getData());
            if ($this->BuyDetails->save($buyDetail)) {
                $this->Flash->success(__('The buy detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The buy detail could not be saved. Please, try again.'));
        }
        $users = $this->BuyDetails->Users->find('list', ['limit' => 200]);
        $buySummaries = $this->BuyDetails->BuySummaries->find('list', ['limit' => 200]);
        $products = $this->BuyDetails->Products->find('list', ['limit' => 200]);
        $this->set(compact('buyDetail', 'users', 'buySummaries', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Buy Detail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $buyDetail = $this->BuyDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $buyDetail = $this->BuyDetails->patchEntity($buyDetail, $this->request->getData());
            if ($this->BuyDetails->save($buyDetail)) {
                $this->Flash->success(__('The buy detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The buy detail could not be saved. Please, try again.'));
        }
        $users = $this->BuyDetails->Users->find('list', ['limit' => 200]);
        $buySummaries = $this->BuyDetails->BuySummaries->find('list', ['limit' => 200]);
        $products = $this->BuyDetails->Products->find('list', ['limit' => 200]);
        $this->set(compact('buyDetail', 'users', 'buySummaries', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Buy Detail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $buyDetail = $this->BuyDetails->get($id);
        if ($this->BuyDetails->delete($buyDetail)) {
            $this->Flash->success(__('The buy detail has been deleted.'));
        } else {
            $this->Flash->error(__('The buy detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
