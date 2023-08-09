<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SaleForDays Controller
 *
 * @property \App\Model\Table\SaleForDaysTable $SaleForDays
 * @method \App\Model\Entity\SaleForDay[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SaleForDaysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Products'],
        ];
        $saleForDays = $this->paginate($this->SaleForDays);

        $this->set(compact('saleForDays'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale For Day id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleForDay = $this->SaleForDays->get($id, [
            'contain' => ['Users', 'Products'],
        ]);

        $this->set(compact('saleForDay'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $saleForDay = $this->SaleForDays->newEmptyEntity();
        if ($this->request->is('post')) {
            $saleForDay = $this->SaleForDays->patchEntity($saleForDay, $this->request->getData());
            if ($this->SaleForDays->save($saleForDay)) {
                $this->Flash->success(__('The sale for day has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale for day could not be saved. Please, try again.'));
        }
        $users = $this->SaleForDays->Users->find('list', ['limit' => 200]);
        $products = $this->SaleForDays->Products->find('list', ['limit' => 200]);
        $this->set(compact('saleForDay', 'users', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale For Day id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $saleForDay = $this->SaleForDays->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleForDay = $this->SaleForDays->patchEntity($saleForDay, $this->request->getData());
            if ($this->SaleForDays->save($saleForDay)) {
                $this->Flash->success(__('The sale for day has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale for day could not be saved. Please, try again.'));
        }
        $users = $this->SaleForDays->Users->find('list', ['limit' => 200]);
        $products = $this->SaleForDays->Products->find('list', ['limit' => 200]);
        $this->set(compact('saleForDay', 'users', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale For Day id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $saleForDay = $this->SaleForDays->get($id);
        if ($this->SaleForDays->delete($saleForDay)) {
            $this->Flash->success(__('The sale for day has been deleted.'));
        } else {
            $this->Flash->error(__('The sale for day could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
