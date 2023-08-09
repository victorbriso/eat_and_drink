<?php
declare(strict_types=1);
namespace App\Controller;
class CategoriesController extends AppController{
    public function index(){
        $categories=$this->Categories->obtieneCategorias($this->request->getSession()->read('local.0.id'));
        $localId=$this->request->getSession()->read('local.0.id');
        $this->set(compact('categories', 'localId'));
    }
    public function add(){
        if($this->request->is('post')){
            $productoTable = $this->getTableLocator()->get('Categories'); 
            $insert = $productoTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->nombre=$this->request->getData()['nombre'];
            $insert->estado=1;
            if($productoTable->save($insert)){              
                $mensaje['tipo']='success';
                $mensaje['titulo']='Categoría agregada con exito';
                $mensaje['texto']='Ahora solo falta agregar la imagen';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al agregar la categoría';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            if($insert->id){
                return $this->redirect(['controller'=>'Categories', 'action' => 'edit', $insert->id]);
            }else{
                return $this->redirect(['controller'=>'Categories', 'action' => 'index']);
            }
        }else{
            return $this->redirect(['controller'=>'Categories', 'action' => 'index']);
        }
    }
    public function eliminaCategoria($id=null, $catSinCat=null){
        if(isset($id)&&isset($catSinCat)){
            $this->loadModel('Products');
            if($this->Products->actualizaCategorias($this->request->getSession()->read('local.0.id'), $id, $catSinCat)){
                $this->Categories->delete($this->Categories->get($id));
                $mensaje['tipo']='success';
                $mensaje['titulo']='Categoría eliminada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al eliminar la categoría';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Categories', 'action' => 'index']);
        }else{
            return $this->redirect(['controller'=>'Categories', 'action' => 'index']);
        }
    }
    public function edit($id=null){
        if($this->request->is('post')){
            $productoTable = $this->getTableLocator()->get('Categories');
            $update=$productoTable->get($this->request->getData()['id']);
            $update->nombre=$this->request->getData()['nombre'];
            $fileobject = $this->request->getData('image');
            if($fileobject->getClientFilename()!=''){
                $extension=explode('.', $fileobject->getClientFilename());
                $destination = ROOT.'/webroot/img/img_cat/'.$this->request->getSession()->read('local.0.id').'/'.$this->request->getData()['id'].'.'.$extension[1];
                $fileobject->moveTo($destination);
                $update->extension=$extension[1];
                $maxAncho = 800;
                $maxAlto = 600;
                $medidasimagen= getimagesize(ROOT.'/webroot/img/img_cat/'.$this->request->getSession()->read('local.0.id').'/'.$this->request->getData()['id'].'.'.$extension[1]);
                $nombrearchivo=$this->request->getData()['id'].'.'.$extension[1];
                if($extension[1]=='jpg'||$extension[1]=='jpeg'){
                    $original = imagecreatefromjpeg(ROOT.'/webroot/img/img_cat/'.$this->request->getSession()->read('local.0.id').'/'.$this->request->getData()['id'].'.'.$extension[1]);
                }
                if($extension[1]=='gif'){
                    $original = imagecreatefromgif(ROOT.'/webroot/img/img_cat/'.$this->request->getSession()->read('local.0.id').'/'.$this->request->getData()['id'].'.'.$extension[1]);
                }
                if($extension[1]=='png'){
                    $original = imagecreatefrompng(ROOT.'/webroot/img/img_cat/'.$this->request->getSession()->read('local.0.id').'/'.$this->request->getData()['id'].'.'.$extension[1]);
                }
                list($ancho,$alto)=getimagesize(ROOT.'/webroot/img/img_cat/'.$this->request->getSession()->read('local.0.id').'/'.$this->request->getData()['id'].'.'.$extension[1]);
                $x_ratio = $maxAncho / $ancho;
                $y_ratio = $maxAlto / $alto;
                if( ($ancho <= $maxAncho) && ($alto <= $maxAlto) ){
                    $ancho_final = $ancho;
                    $alto_final = $alto;
                }
                elseif (($x_ratio * $alto) < $maxAlto){
                    $alto_final = ceil($x_ratio * $alto);
                    $ancho_final = $maxAncho;
                }
                else{
                    $ancho_final = ceil($y_ratio * $ancho);
                    $alto_final = $maxAlto;
                }
                $ancho_final=(int)$ancho_final;
                $alto_final=(int)$alto_final;
                $patch=ROOT.'/webroot/img/img_cat/'.$this->request->getSession()->read('local.0.id');
                $lienzo=imagecreatetruecolor($ancho_final,$alto_final); 
                imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
                if($extension[1]=='jpg'||$extension[1]=='jpeg'){
                imagejpeg($lienzo,$patch."/".$nombrearchivo);
                }
                if($extension[1]=='png'){
                imagepng($lienzo,$patch."/".$nombrearchivo);
                }
                if($extension[1]=='gif'){
                imagegif($lienzo,$patch."/".$nombrearchivo);
                }
            }
            if($productoTable->save($update)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Categoría editada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al editar la categoría';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Categories', 'action' => 'edit', $this->request->getData()['id']]);
        }
        if(isset($id)){
            $dataCat=$this->Categories->detalleCategoria($this->request->getSession()->read('local.0.id'), $id);
            $localId=$this->request->getSession()->read('local.0.id');
            $this->set(compact('dataCat', 'localId'));
        }else{
            return $this->redirect(['controller'=>'Categories', 'action' => 'index']);
        }
    }
}
