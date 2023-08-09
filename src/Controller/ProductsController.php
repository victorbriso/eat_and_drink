<?php
declare(strict_types=1);
namespace App\Controller;
class ProductsController extends AppController{
    public function index(){
        $data=$this->Products->obtieneProductosSimples($this->request->getSession()->read('local.0.id'));
        $this->set(compact('data'));
    }
    public function add(){
        if($this->request->is('post')){
            if(isset($this->request->getData()['activo'])){$estado=1;}else{$estado=0;}
            if(isset($this->request->getData()['divisible'])){$divisible=1;}else{$divisible=0;}
            if(isset($this->request->getData()['req_receta'])){$receta=1;}else{$receta=0;}
            if(isset($this->request->getData()['data'])){$dataReceta=json_encode($this->request->getData()['data']['receta']);}else{$dataReceta=json_encode(array());}
            $productoTable = $this->getTableLocator()->get('Products'); 
            $insert = $productoTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->category_id=$this->request->getData()['categoria'];
            $insert->nombre=$this->request->getData()['nombre'];
            $insert->estado=$estado;
            $insert->req_receta=$receta;
            $insert->receta=$dataReceta;
            $insert->tipo=1;
            $insert->precio_anterior=$this->request->getData()['precio'];
            $insert->precio_actual=$this->request->getData()['precio'];
            $insert->proximo_precio=$this->request->getData()['precio'];
            $insert->precio_base=$this->request->getData()['precio'];
            $insert->place_elaboration_id=$this->request->getData()['elaboracion'];
            $insert->divisible=$divisible;
            $insert->desc_es=$this->request->getData()['desc'];
            if($productoTable->save($insert)){
                $idProducto=$insert->id;
                $this->normalizaListasPrecio($idProducto, $this->request->getData()['precio']);
                if(!$receta){
                    $this->normalizaProdSinReceta($idProducto);
                }
                $fileobject = $this->request->getData('image');
                if($fileobject->getClientFilename()!=''){
                    ini_set('memory_limit', '30M');
                    $extension=explode('.', $fileobject->getClientFilename());
                    $extValidas=['jpg', 'jpeg', 'gif', 'png'];                    
                    if(in_array($extension[1], $extValidas)){
                        $destination = ROOT.'/webroot/img/img_carta/'.$this->request->getSession()->read('local.0.id').'/'.$idProducto.'.'.$extension[1];
                        $fileobject->moveTo($destination);
                        unset($fileobject);
                        //prx(memory_get_usage(true));
                        if($extension[1]=='jpg'||$extension[1]=='jpeg'){
                            $imgOriginal = imagecreatefromjpeg($destination);
                        }
                        if($extension[1]=='gif'){
                            $imgOriginal = imagecreatefromgif($destination);
                        }
                        if($extension[1]=='png'){
                            $imgOriginal = imagecreatefrompng($destination);
                        }
                        $lienzo=imagecreatetruecolor(400, 300);
                        $lienzoNegro=imagecolorallocate($lienzo, 0, 0, 0);
                        $ancho=imagesx($imgOriginal);
                        $alto=imagesy($imgOriginal);
                        if($ancho<=400&&$alto<=300){
                            $nuevoAlto=$alto;
                            $nuevoAncho=$ancho;
                        }else{
                            if($ancho<$alto){
                                $nuevoAlto=300;
                                $proporsion=30000/$alto;
                                $nuevoAncho=($ancho*$proporsion)/100;
                            }elseif ($alto<$ancho) {
                                $nuevoAncho=400;
                                $proporsion=40000/$ancho;
                                $nuevoAlto=($alto*$proporsion)/100;
                            }elseif ($alto==$ancho) {
                                $nuevoAncho=400;
                                $proporsion=40000/$ancho;
                                $nuevoAlto=($alto*$proporsion)/100;
                            }else{
                                $nuevoAncho=400;
                                $proporsion=40000/$ancho;
                                $nuevoAlto=($alto*$proporsion)/100;
                            }
                        }
                        $nuevoAncho=floor($nuevoAncho);
                        $nuevoAlto=floor($nuevoAlto);
                        $imgRecortada=imagescale($imgOriginal, (int)$nuevoAncho, (int)$nuevoAlto);
                        $posX=(400-$nuevoAncho)/2;
                        $posY=(300-$nuevoAlto)/2;
                        imagecopy($lienzo, $imgRecortada, (int)$posX, (int)$posY, 0, 0, 400, 300);
                        imagepng($lienzo,$destination);                            
                    }else{
                        $mensaje['tipo']='error';
                        $mensaje['titulo']='Formato no soportado';
                        $mensaje['texto']='Los formatos de imagen soportados son: JPG, JPEG, GIF y PNG';
                        $this->request->getSession()->write('mensajeAlerta', $mensaje);
                        return $this->redirect(['controller'=>'Products', 'action' => 'edit', $this->request->getData()['id']]);
                    }                 
                }                
                $mensaje['tipo']='success';
                $mensaje['titulo']='Producto agregado con exito';
                $mensaje['texto']='';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Products', 'action' => 'edit', $idProducto]);
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al agregar el producto';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Products', 'action' => 'index']);
            }
            
        }
        $this->loadModel('PlaceElaborations');
        $this->loadModel('Categories');
        $insumos=$this->Products->obtieneInsumosReceta($this->request->getSession()->read('local.0.id'));
        $insumos2=array();
        foreach ($insumos as $key => $value) {
            $insumos2[$value['id']]=$value;
        }
        $insumos=$insumos2;
        $categorias=$this->Categories->obtieneCategorias($this->request->getSession()->read('local.0.id'));
        if(empty($categorias)){
            $mensaje['tipo']='error';
            $mensaje['titulo']='Antes de crear productos debe crear categorias';
            $mensaje['texto']='';
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Categories', 'action' => 'index']);
        }
        $lugares=$this->PlaceElaborations->obtienePLaceElav($this->request->getSession()->read('local.0.id'));
        $unidadesMedida=$this->obtieneUnidadesMedida();
        $plan=$this->request->getSession()->read('local.0.plan');
        $this->set(compact('categorias', 'lugares', 'insumos', 'unidadesMedida', 'plan'));
    }
    public function edit($id = null){
        if(isset($id)){
            if($this->request->is('post')){
                //prx($this->request->getData());
                if(isset($this->request->getData()['activo'])){$estado=1;}else{$estado=0;}
                if(isset($this->request->getData()['divisible'])){$divisible=1;}else{$divisible=0;}
                if(isset($this->request->getData()['req_receta'])){$receta=1;}else{$receta=0;}
                if(isset($this->request->getData()['data'])){$dataReceta=json_encode($this->request->getData()['data']['receta']);}else{$dataReceta=json_encode(array());}
                $productoTable = $this->getTableLocator()->get('Products');
                $update=$productoTable->get($this->request->getData()['id']);
                $update->category_id=$this->request->getData()['categoria'];
                $update->nombre=$this->request->getData()['nombre'];
                $update->estado=$estado;
                $update->req_receta=$receta;
                $update->receta=$dataReceta;
                $update->precio_base=$this->request->getData()['precio'];
                $update->place_elaboration_id=$this->request->getData()['elaboracion'];
                $update->divisible=$divisible;
                $update->desc_es=$this->request->getData()['desc'];
                $fileobject = $this->request->getData('image');
                if($fileobject->getClientFilename()!=''){
                    ini_set('memory_limit', '512M');
                    $extension=explode('.', $fileobject->getClientFilename());
                    $extValidas=['jpg', 'jpeg', 'gif', 'png'];                    
                    if(in_array($extension[1], $extValidas)){
                        $destination = ROOT.'/webroot/img/img_carta/'.$this->request->getSession()->read('local.0.id').'/'.$this->request->getData()['id'].'.'.$extension[1];
                        $fileobject->moveTo($destination);
                        unset($fileobject);
                        if($extension[1]=='jpg'||$extension[1]=='jpeg'){
                            $imgOriginal = imagecreatefromjpeg($destination);
                        }
                        if($extension[1]=='gif'){
                            $imgOriginal = imagecreatefromgif($destination);
                        }
                        if($extension[1]=='png'){
                            $imgOriginal = imagecreatefrompng($destination);
                        }
                        $lienzo=imagecreatetruecolor(400, 300);
                        $lienzoNegro=imagecolorallocate($lienzo, 0, 0, 0);
                        $ancho=imagesx($imgOriginal);
                        $alto=imagesy($imgOriginal);
                        if($ancho<=400&&$alto<=300){
                            $nuevoAlto=$alto;
                            $nuevoAncho=$ancho;
                        }else{
                            if($ancho<$alto){
                                $nuevoAlto=300;
                                $proporsion=30000/$alto;
                                $nuevoAncho=($ancho*$proporsion)/100;
                            }elseif ($alto<$ancho) {
                                $nuevoAncho=400;
                                $proporsion=40000/$ancho;
                                $nuevoAlto=($alto*$proporsion)/100;
                            }elseif ($alto==$ancho) {
                                $nuevoAncho=400;
                                $proporsion=40000/$ancho;
                                $nuevoAlto=($alto*$proporsion)/100;
                            }else{
                                $nuevoAncho=400;
                                $proporsion=40000/$ancho;
                                $nuevoAlto=($alto*$proporsion)/100;
                            }
                        }
                        $nuevoAncho=floor($nuevoAncho);
                        $nuevoAlto=floor($nuevoAlto);
                        $imgRecortada=imagescale($imgOriginal, (int)$nuevoAncho, (int)$nuevoAlto);
                        $posX=(400-$nuevoAncho)/2;
                        $posY=(300-$nuevoAlto)/2;
                        imagecopy($lienzo, $imgRecortada, (int)$posX, (int)$posY, 0, 0, 400, 300);
                        imagepng($lienzo,$destination);
                        $update->extension='png';                          
                    }else{
                        $mensaje['tipo']='error';
                        $mensaje['titulo']='Formato no soportado';
                        $mensaje['texto']='Los formatos de imagen soportados son: JPEG, GIF y PNG';
                        $this->request->getSession()->write('mensajeAlerta', $mensaje);
                        return $this->redirect(['controller'=>'Products', 'action' => 'edit', $this->request->getData()['id']]);
                    }                 
                }
                if(!$receta&&isset($this->request->getData()['data_combo'])){
                    $this->normalizaProdSinReceta($this->request->getData()['id']);
                }
                if($productoTable->save($update)){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Producto editado con exito';
                    $mensaje['texto']='';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Ocurrio un error al editar el producto';
                    $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                }
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Products', 'action' => 'edit', $this->request->getData()['id']]);
            }
            $this->loadModel('PlaceElaborations');
            $this->loadModel('Categories');
            $categorias=$this->Categories->obtieneCategorias($this->request->getSession()->read('local.0.id'));
            $lugares=$this->PlaceElaborations->obtienePLaceElav($this->request->getSession()->read('local.0.id'));
            $data=$this->Products->detalleProductoSimple($this->request->getSession()->read('local.0.id'), $id);
            $insumos=$this->Products->obtieneInsumosReceta($this->request->getSession()->read('local.0.id'));
            foreach ($insumos as $key => $value) {
                $insumos2[$value['id']]=$value;
            }
            if(!isset($insumos2)){$insumos2=array();}
            $insumos=$insumos2;
            if(!empty($data[0]['receta'])){$data[0]['receta']=json_decode($data[0]['receta'], true);}
            $localId=$this->request->getSession()->read('local.0.id');
            $plan=$this->request->getSession()->read('local.0.plan');
            $unidadesMedida=$this->obtieneUnidadesMedida();
            $this->set(compact('categorias', 'lugares', 'data', 'localId', 'unidadesMedida', 'insumos', 'plan'));
        }else{
            return $this->redirect(['controller'=>'Products', 'action' => 'index']);
        }        
    }
    public function lugaresElaboracion(){
        $this->loadModel('PlaceElaborations');
        $lugares=$this->PlaceElaborations->obtienePLaceElav($this->request->getSession()->read('local.0.id'));
        $this->set(compact('lugares'));
    }
    public function listasPrecio(){
        $this->loadModel('PriceListControls');
        $listaPrecios=$this->PriceListControls->obtieneListas($this->request->getSession()->read('local.0.id'));
        $listaPreciosProductos=$this->Products->obtieneProductosPreciosListas($this->request->getSession()->read('local.0.id'));
        $this->set(compact('listaPrecios', 'listaPreciosProductos'));
    }
    public function eliminarLista($id=null){
        if(isset($id)){
            $this->loadModel('PriceListControls');
            if($this->PriceListControls->eliminaLista($this->request->getSession()->read('local.0.id'), $id)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='PLista de precio eliminada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al eliminar la lista de precios';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Products', 'action' => 'listasPrecio']);
        }else{
            return $this->redirect(['controller'=>'Products', 'action' => 'listasPrecio']);
        }
    }
    public function addListaPrecio(){
        if($this->request->is('post')){
            $listaPrecioControlTable = $this->getTableLocator()->get('PriceListControls'); 
            $insert = $listaPrecioControlTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->nombre=$this->request->getData()['nombre'];
            $insert->estado=0;
            if($listaPrecioControlTable->save($insert)){
                $idNuevaLista=$insert->id;
                $dataSave=array();
                foreach ($this->request->getData()['data'] as $key => $value) {
                    $data['user_id']=$this->request->getSession()->read('local.0.id');
                    $data['price_lists_control_id']=$idNuevaLista;
                    $data['product_id']=$key;
                    $data['precio']=$value;
                    array_push($dataSave, $data);
                }
                $PriceListsTable = $this->getTableLocator()->get('PriceLists');
                $entities = $PriceListsTable->newEntities($dataSave);
                if($PriceListsTable->saveMany($entities)){
                    $mensaje['tipo']='success';
                    $mensaje['titulo']='Lista de precios creada con exito';
                    $mensaje['texto']='';
                }else{
                    $mensaje['tipo']='error';
                    $mensaje['titulo']='Ocurrio un error al crear la lista de precios';
                    $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
                    $entity = $this->$listaPrecioControlTable->get($idNuevaLista);
                    $this->$listaPrecioControlTable->delete($entity);
                }
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al crear la lista de precios';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Products', 'action' => 'listasPrecio']);
        }else{
            $productos=$this->Products->productosParaListaNueva($this->request->getSession()->read('local.0.id'));
            $this->set(compact('productos'));
        }
    }
    private function normalizaListasPrecio($prodId=null, $precio=null){
        $this->loadModel('PriceListControls');
        $idsListas=$this->PriceListControls->obtieneIdsListas($this->request->getSession()->read('local.0.id'));
        $dataSave=array();
        foreach ($idsListas as $key => $value) {
            $data['user_id']=$this->request->getSession()->read('local.0.id');
            $data['price_lists_control_id']=$value['id'];
            $data['product_id']=$prodId;
            $data['precio']=$precio;
            array_push($dataSave, $data);
        }
        $PriceListsTable = $this->getTableLocator()->get('PriceLists');
        $entities = $PriceListsTable->newEntities($dataSave);
        if($PriceListsTable->saveMany($entities)){
            return true;
        }else{
            return false;
        }
    }
    public function editListaPrecio($id=null, $nombre=null){
        if($this->request->is('post')){
            $productoTable = $this->getTableLocator()->get('PriceLists');
            foreach ($this->request->getData()['data'] as $key => $value) {
                $update=$productoTable->get($key);
                $update->precio=$value;
                $productoTable->save($update);
            }
            $mensaje['tipo']='success';
            $mensaje['titulo']='Lista de precios actualizada';
            $mensaje['texto']='';
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Products', 'action' => 'editListaPrecio', $id]);
        }
        if(isset($id)){
            $listaPreciosProductos=$this->Products->obtieneProductosPreciosListaEdit($this->request->getSession()->read('local.0.id'), $id);
            $this->set(compact('listaPreciosProductos', 'nombre'));
        }else{
            return $this->redirect(['controller'=>'Products', 'action' => 'listasPrecio']);
        }
    }
    public function addLugarElab(){
        if($this->request->is('post')){
            $listaPrecioControlTable = $this->getTableLocator()->get('PlaceElaborations'); 
            $insert = $listaPrecioControlTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->nombre=$this->request->getData()['nombre'];
            if($listaPrecioControlTable->save($insert)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Lugar de elaboración agregado con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al agregar el lugar de elaboración';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Products', 'action' => 'lugaresElaboracion']);
        }else{
            return $this->redirect(['controller'=>'Products', 'action' => 'lugaresElaboracion', $id]);
        }
    }
    public function publicacion(){
        $this->loadModel('PriceListControls');
        $productos=$this->Products->obtieneProdPublicacion($this->request->getSession()->read('local.0.id'));
        $listaPrecioActiva=$this->PriceListControls->obtieneListaActiva($this->request->getSession()->read('local.0.id'));
        $this->set(compact('productos', 'listaPrecioActiva'));
    }
    public function publicacionCarta(){
        $this->loadModel('PriceListControls');
        $this->loadModel('Categories');
        $categorias=$this->Categories->obtieneCategoriasPublicacion($this->request->getSession()->read('local.0.id'));
        $productos=$this->Products->obtieneProdPublicacion($this->request->getSession()->read('local.0.id'));
        $listaPrecioActiva=$this->PriceListControls->obtieneListaActiva($this->request->getSession()->read('local.0.id'));
        $actualizaCartaBd=$this->Products->actualizaCartaBd($this->request->getSession()->read('local.0.id'));
        foreach ($categorias as $key1 => $value1) {
            if(!$value1['tipo']){$sinCat=$value1['id']; continue;}
            $carta[$value1['id']]['nombre']=$value1['nombre'];
            $carta[$value1['id']]['extension']=$value1['extension'];
            $carta[$value1['id']]['cat_padre']=$value1['cat_padre'];
            $carta[$value1['id']]['productos']=array();
        }
        foreach ($productos as $key2 => $value2) {
            if($value2['category_id']==$sinCat){continue;}
            if(!$value2['estado']){continue;}
            array_push($carta[$value2['category_id']]['productos'], $value2);
        }
        $fp=fopen(ROOT.'/webroot/files/cartas/'.$this->request->getSession()->read('local.0.id').'.json', 'w+');
        if(fwrite($fp, json_encode($carta))){
            $mensaje['tipo']='success';
            $mensaje['titulo']='Carta publicada con exito';
            $mensaje['texto']='';
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Ocurrio un error al publicar la carta';
            $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
        }
        $this->request->getSession()->write('mensajeAlerta', $mensaje);
        return $this->redirect(['controller'=>'Products', 'action' => 'publicacion']);
    }
    public function insumos(){
        $impuestos=file_get_contents('../webroot/files/sistema/impuestos.json');
        $impuestos=json_decode($impuestos, true);
        $unidadesMedida=file_get_contents('../webroot/files/sistema/unidadesMedida.json');
        $unidadesMedida=json_decode($unidadesMedida, true);
        $data=$this->Products->obtieneInsumos($this->request->getSession()->read('local.0.id'));
        $this->set(compact('data', 'unidadesMedida', 'impuestos'));
    }
    public function addInsumo(){
        if($this->request->is('post')){
            $impuestos=file_get_contents('../webroot/files/sistema/impuestos.json');
            $impuestos=json_decode($impuestos, true);
            if(isset($this->request->getData()['iva'])){
                $iva='I.V.A';
            }else{
                $iva='';
            }
            $dataImpuestos['I.V.A']=$iva;
            if(isset($this->request->getData()['impuestos'])){
                $nombreImpuesto=explode('-', $this->request->getData()['impuestos']);
                $dataImpuestos[$nombreImpuesto[0]]=$nombreImpuesto[1];
            }
            $productoTable = $this->getTableLocator()->get('Products'); 
            $insert = $productoTable->newEmptyEntity();
            $insert->user_id=$this->request->getSession()->read('local.0.id');
            $insert->category_id=1;
            $insert->nombre=$this->request->getData()['nombre'];
            $insert->estado=1;
            $insert->tipo=3;
            $insert->precio_anterior=$this->request->getData()['costo'];
            $insert->precio_actual=$this->request->getData()['stock'];
            $insert->data_combo=$this->request->getData()['unidadesMedida'];
            $insert->impuestos=implode('/', array_keys($dataImpuestos));
            $insert->codigo_ean=$this->request->getData()['ean'];
            if($productoTable->save($insert)){             
                $mensaje['tipo']='success';
                $mensaje['titulo']='Insumo agregado con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al agregar el insumo';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Products', 'action' => 'insumos']);
        }else{
            return $this->redirect(['controller'=>'Products', 'action' => 'insumos']);
        }
    }
    public function configDelivery(){
        if($this->request->is('post')){
            $productoTable = $this->getTableLocator()->get('Products');
            $prodPorActualizar=array();
            $prodActualizados=array();
            foreach ($this->request->getData()['data'] as $key => $value) {
                if(isset($value['delivery'])){
                    $update=$productoTable->get($key);
                    $update->delivery=1;
                    $update->precio_delivery=$value['precio'];
                    array_push($prodPorActualizar, 1);
                    if($productoTable->save($update)){
                        array_push($prodActualizados, 1);
                    }else{
                        array_push($prodActualizados, 0);
                    }
                }else{
                    continue;
                }
            }
            if(array_sum($prodPorActualizar)==array_sum($prodActualizados)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Productos actualizados con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Uno o más productos no se actualizaron';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Products', 'action' => 'configDelivery']);
        }
        $this->loadModel('Products');
        $dataProductos=$this->Products->obtieneProdDelivery($this->request->getSession()->read('local.0.id'));//prx($dataProductos);
        $this->set(compact('dataProductos'));
    }
    public function configWeb(){
        if($this->request->is('post')){
            $productoTable = $this->getTableLocator()->get('Products');
            $prodPorActualizar=array();
            $prodActualizados=array();
            foreach ($this->request->getData()['data'] as $key => $value) {
                if(isset($value['vta_web'])){
                    $update=$productoTable->get($key);
                    $update->vta_web=1;
                    $update->precio_web=$value['precio'];
                    array_push($prodPorActualizar, 1);
                    if($productoTable->save($update)){
                        array_push($prodActualizados, 1);
                    }else{
                        array_push($prodActualizados, 0);
                    }
                }else{
                    continue;
                }
            }
            if(array_sum($prodPorActualizar)==array_sum($prodActualizados)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Productos actualizados con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Uno o más productos no se actualizaron';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Products', 'action' => 'configWeb']);
        }
        $this->loadModel('Products');
        $dataProductos=$this->Products->obtieneProdVtaWeb($this->request->getSession()->read('local.0.id'));//prx($dataProductos);
        $this->set(compact('dataProductos'));
    }
    public function publicacionWeb(){
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $categorias=$this->Categories->obtieneCategoriasPublicacion($this->request->getSession()->read('local.0.id'));
        $productos=$this->Products->obtieneProdPublicacionWeb($this->request->getSession()->read('local.0.id'));
        $dataLocal=$this->Users->dataLocalCarta($this->request->getSession()->read('local.0.id'));
        foreach ($categorias as $key1 => $value1) {
            if(!$value1['tipo']){$sinCat=$value1['id']; continue;}
            $carta[$value1['id']]['nombre']=$value1['nombre'];
            $carta[$value1['id']]['extension']=$value1['extension'];
            $carta[$value1['id']]['cat_padre']=$value1['cat_padre'];
            $carta[$value1['id']]['productos']=array();
        }
        foreach ($productos as $key2 => $value2) {
            if($value2['category_id']==$sinCat){continue;}
            if(!$value2['estado']){continue;}
            array_push($carta[$value2['category_id']]['productos'], $value2);
        }
        foreach ($carta as $key => $value) {
            if(empty($value['productos'])){
                unset($carta[$key]);
            }
        }
        $carta2['local']=$dataLocal[0];
        $carta2['carta']=$carta;
        $fp=fopen(ROOT.'/webroot/files/cartas/cartaweb_'.$this->request->getSession()->read('local.0.id').'.json', 'w+');
        if(fwrite($fp, json_encode($carta))){
            $mensaje['tipo']='success';
            $mensaje['titulo']='Carta publicada con exito';
            $mensaje['texto']='';
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Ocurrio un error al publicar la carta';
            $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
        }
        $this->request->getSession()->write('mensajeAlerta', $mensaje);
        return $this->redirect(['controller'=>'Products', 'action' => 'configWeb']);
    }
    public function publicacionDelivery(){
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $categorias=$this->Categories->obtieneCategoriasPublicacion($this->request->getSession()->read('local.0.id'));
        $productos=$this->Products->obtieneProdPublicacionDelivery($this->request->getSession()->read('local.0.id'));
        $dataLocal=$this->Users->dataLocalCarta($this->request->getSession()->read('local.0.id'));
        foreach ($categorias as $key1 => $value1) {
            if(!$value1['tipo']){$sinCat=$value1['id']; continue;}
            $carta[$value1['id']]['nombre']=$value1['nombre'];
            $carta[$value1['id']]['extension']=$value1['extension'];
            $carta[$value1['id']]['cat_padre']=$value1['cat_padre'];
            $carta[$value1['id']]['productos']=array();
        }
        foreach ($productos as $key2 => $value2) {
            if($value2['category_id']==$sinCat){continue;}
            if(!$value2['estado']){continue;}
            array_push($carta[$value2['category_id']]['productos'], $value2);
        }
        foreach ($carta as $key => $value) {
            if(empty($value['productos'])){
                unset($carta[$key]);
            }
        }
        $carta2['local']=$dataLocal[0];
        $carta2['carta']=$carta;
        $fp=fopen(ROOT.'/webroot/files/cartas/cartadelivery_'.$this->request->getSession()->read('local.0.id').'.json', 'w+');
        if(fwrite($fp, json_encode($carta))){
            $mensaje['tipo']='success';
            $mensaje['titulo']='Carta publicada con exito';
            $mensaje['texto']='';
        }else{
            $mensaje['tipo']='error';
            $mensaje['titulo']='Ocurrio un error al publicar la carta';
            $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
        }
        $this->request->getSession()->write('mensajeAlerta', $mensaje);
        return $this->redirect(['controller'=>'Products', 'action' => 'configDelivery']);
    }
    public function cortaImagen($id=null){
        if($this->request->is('post')){
            prx($this->request->getData());
        }
        if(isset($id)){
            $data=$this->Products->detalleImagen($this->request->getSession()->read('local.0.id'), $id);
            $localId=$this->request->getSession()->read('local.0.id');
            $this->set(compact('data', 'localId')); 
        }else{
            return $this->redirect(['controller'=>'Products', 'action' => 'index']);
        }
    }
    public function cambiaEstado(){
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender=false;
        $productoTable = $this->getTableLocator()->get('Products');
        $update=$productoTable->get($this->request->getData()['prodId']);
        $update->estado=$this->request->getData()['valor'];
        if($productoTable->save($update)){
            $respuesta=1;
        }else{
            $respuesta=0;
        }
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($respuesta));
    }
    public function normalizaProdSinReceta($prodId){
        $productoTable = $this->getTableLocator()->get('Products'); 
        $insert = $productoTable->newEmptyEntity();
        $insert->user_id=$this->request->getSession()->read('local.0.id');
        $insert->tipo=3;
        $insert->data_combo=1;
        $insert->precio_anterior=0;
        $insert->precio_actual=0;
        if($productoTable->save($insert)){
            $prodIdNuevo=$insert->id;
            $productoTable2 = $this->getTableLocator()->get('Products');
            $update=$productoTable2->get($prodId);
            $update->data_combo=$prodIdNuevo;
            $productoTable2->save($update);
        }
        return true;
    }
    public function obtieneUnidadesMedida(){
        $unidadesMedida=file_get_contents('../webroot/files/sistema/unidadesMedida.json');
        $unidadesMedida=json_decode($unidadesMedida, true);//prx($unidadesMedida);
        unset($unidadesMedida[4]);
        unset($unidadesMedida[5]);
        unset($unidadesMedida[6]);
        unset($unidadesMedida[9]);
        return $unidadesMedida;
    }
}
