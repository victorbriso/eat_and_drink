<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PlaceElaborations Controller
 *
 * @property \App\Model\Table\PlaceElaborationsTable $PlaceElaborations
 * @method \App\Model\Entity\PlaceElaboration[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlaceElaborationsController extends AppController
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
        $placeElaborations = $this->paginate($this->PlaceElaborations);

        $this->set(compact('placeElaborations'));
    }

    /**
     * View method
     *
     * @param string|null $id Place Elaboration id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $placeElaboration = $this->PlaceElaborations->get($id, [
            'contain' => ['Users', 'Products'],
        ]);

        $this->set(compact('placeElaboration'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $placeElaboration = $this->PlaceElaborations->newEmptyEntity();
        if ($this->request->is('post')) {
            $placeElaboration = $this->PlaceElaborations->patchEntity($placeElaboration, $this->request->getData());
            if ($this->PlaceElaborations->save($placeElaboration)) {
                $this->Flash->success(__('The place elaboration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The place elaboration could not be saved. Please, try again.'));
        }
        $users = $this->PlaceElaborations->Users->find('list', ['limit' => 200]);
        $this->set(compact('placeElaboration', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Place Elaboration id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $placeElaboration = $this->PlaceElaborations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $placeElaboration = $this->PlaceElaborations->patchEntity($placeElaboration, $this->request->getData());
            if ($this->PlaceElaborations->save($placeElaboration)) {
                $this->Flash->success(__('The place elaboration has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The place elaboration could not be saved. Please, try again.'));
        }
        $users = $this->PlaceElaborations->Users->find('list', ['limit' => 200]);
        $this->set(compact('placeElaboration', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Place Elaboration id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $placeElaboration = $this->PlaceElaborations->get($id);
        if ($this->PlaceElaborations->delete($placeElaboration)) {
            $this->Flash->success(__('The place elaboration has been deleted.'));
        } else {
            $this->Flash->error(__('The place elaboration could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
