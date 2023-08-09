<?php
declare(strict_types=1);
namespace App\Controller;
class AdminController extends AppController{
    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'add']);
        $this->viewBuilder()->setLayout('admin');
    }
    public function index(){

    }
    public function add(){
        if($this->request->is('post')){

        }

    }
}