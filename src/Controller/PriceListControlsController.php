<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PriceListControls Controller
 *
 * @property \App\Model\Table\PriceListControlsTable $PriceListControls
 * @method \App\Model\Entity\PriceListControl[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PriceListControlsController extends AppController
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
        $priceListControls = $this->paginate($this->PriceListControls);

        $this->set(compact('priceListControls'));
    }

    /**
     * View method
     *
     * @param string|null $id Price List Control id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $priceListControl = $this->PriceListControls->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('priceListControl'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $priceListControl = $this->PriceListControls->newEmptyEntity();
        if ($this->request->is('post')) {
            $priceListControl = $this->PriceListControls->patchEntity($priceListControl, $this->request->getData());
            if ($this->PriceListControls->save($priceListControl)) {
                $this->Flash->success(__('The price list control has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price list control could not be saved. Please, try again.'));
        }
        $users = $this->PriceListControls->Users->find('list', ['limit' => 200]);
        $this->set(compact('priceListControl', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Price List Control id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $priceListControl = $this->PriceListControls->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $priceListControl = $this->PriceListControls->patchEntity($priceListControl, $this->request->getData());
            if ($this->PriceListControls->save($priceListControl)) {
                $this->Flash->success(__('The price list control has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The price list control could not be saved. Please, try again.'));
        }
        $users = $this->PriceListControls->Users->find('list', ['limit' => 200]);
        $this->set(compact('priceListControl', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Price List Control id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $priceListControl = $this->PriceListControls->get($id);
        if ($this->PriceListControls->delete($priceListControl)) {
            $this->Flash->success(__('The price list control has been deleted.'));
        } else {
            $this->Flash->error(__('The price list control could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
