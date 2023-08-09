<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Mailer\Mailer;
class PagesController extends AppController{
    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'cartaDigital', 'contacto', 'contacto2']);
        $this->viewBuilder()->setLayout('publico');
    }
    public function index(){

    }
    public function cartaDigital(){
        $this->viewBuilder()->setLayout('landing');
    }
    public function contacto(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $mailer = new Mailer();
        $mailer->setFrom(['plataforma@ceorestobar.cl' => 'CEOrestobar'])
            ->setTo('contacto@ceorestobar.cl')
            ->setCc($this->request->getData()['mail'])
            ->setSubject('-> Contacto web')
            ->setReplyTo($this->request->getData()['mail'])
            ->setTransport('gmail');
        if($mailer->deliver('nombre: '.$this->request->getData()['nombre'].'<br>Mensaje: '.$this->request->getData()['message'])){
            $respuesta=1;
        }else{
            $respuesta=0;
        }
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function comienza(){
        $mailer = new Mailer();
        $mailer->setFrom(['plataforma@ceorestobar.cl' => 'CEOrestobar'])
            ->setTo('contacto@ceorestobar.cl')
            ->setCc('victor.briso@gmail.com')
            ->setSubject('-> Contacto web')
            ->setReplyTo('victor.briso@gmail.com')
            ->setTransport('gmail');
        if($mailer->deliver('nombre: victor<br>Mensaje: hola')){
            $respuesta=1;
        }else{
            $respuesta=0;
        }
        prx($respuesta);
    }
}
