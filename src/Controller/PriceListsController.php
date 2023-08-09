<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PriceLists Controller
 *
 * @property \App\Model\Table\PriceListsTable $PriceLists
 * @method \App\Model\Entity\PriceList[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PriceListsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'PriceListControls', 'Products'],
        ];
        $priceLists = $this->paginate($this->PriceLists);

        $this->set(compact('priceLists'));
    }

    /**
     * View method
     *
     * @param string|null $id Price List id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $priceList = $this->PriceLists->get($id, [
            'contain' => ['Users', 'PriceListControls', 'Products'],
        ]);

        $this->set(compact('priceList'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $priceList = $this->PriceLists->newEmptyEntity();
        if ($this->request->is('post')) {
            $priceList = $this->PriceLists->patchEntity($priceList, $this->request->getData());
            if ($this->PriceLists->save($priceList)) {
                $this->Flash->success(__('The price list has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price list could not be saved. Please, try again.'));
        }
        $users = $this->PriceLists->Users->find('list', ['limit' => 200]);
        $priceListControls = $this->PriceLists->PriceListControls->find('list', ['limit' => 200]);
        $products = $this->PriceLists->Products->find('list', ['limit' => 200]);
        $this->set(compact('priceList', 'users', 'priceListControls', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Price List id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $priceList = $this->PriceLists->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $priceList = $this->PriceLists->patchEntity($priceList, $this->request->getData());
            if ($this->PriceLists->save($priceList)) {
                $this->Flash->success(__('The price list has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price list could not be saved. Please, try again.'));
        }
        $users = $this->PriceLists->Users->find('list', ['limit' => 200]);
        $priceListControls = $this->PriceLists->PriceListControls->find('list', ['limit' => 200]);
        $products = $this->PriceLists->Products->find('list', ['limit' => 200]);
        $this->set(compact('priceList', 'users', 'priceListControls', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Price List id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $priceList = $this->PriceLists->get($id);
        if ($this->PriceLists->delete($priceList)) {
            $this->Flash->success(__('The price list has been deleted.'));
        } else {
            $this->Flash->error(__('The price list could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
