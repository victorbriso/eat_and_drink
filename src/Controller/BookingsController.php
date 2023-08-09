<?php
declare(strict_types=1);
namespace App\Controller;
class BookingsController extends AppController{
    public function index($id=null){
        $this->paginate = [
            'contain' => ['Users', 'Tables', 'Customers'],
        ];
        $bookings = $this->paginate($this->Bookings);

        $this->set(compact('bookings'));
    }
    public function view($id = null){
        $booking = $this->Bookings->get($id, [
            'contain' => ['Users', 'Tables', 'Customers'],
        ]);

        $this->set(compact('booking'));
    }
    public function add(){
        $booking = $this->Bookings->newEmptyEntity();
        if ($this->request->is('post')) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->getData());
            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The booking could not be saved. Please, try again.'));
        }
        $users = $this->Bookings->Users->find('list', ['limit' => 200]);
        $tables = $this->Bookings->Tables->find('list', ['limit' => 200]);
        $customers = $this->Bookings->Customers->find('list', ['limit' => 200]);
        $this->set(compact('booking', 'users', 'tables', 'customers'));
    }
}
