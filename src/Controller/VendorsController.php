<?php
declare(strict_types=1);
namespace App\Controller;
class VendorsController extends AppController{
    public function index(){
        $proveedores=$this->Vendors->obtieneProveedores($this->request->getSession()->read('local.0.id'));
        $this->set(compact('proveedores'));
    }
    public function view($id = null){
        $vendor = $this->Vendors->get($id, [
            'contain' => ['Users', 'BuySummaries'],
        ]);

        $this->set(compact('vendor'));
    }
    public function add(){
        if($this->request->is('post')){
            $contactos['comercial']['nombre']=$this->request->getData()['comercialnombre'];
            $contactos['comercial']['fono']=$this->request->getData()['comercialfono'];
            $contactos['comercial']['mail']=$this->request->getData()['comercialmail'];
            $contactos['facturacion']['nombre']=$this->request->getData()['facturacionnombre'];
            $contactos['facturacion']['fono']=$this->request->getData()['facturacionfono'];
            $contactos['facturacion']['mail']=$this->request->getData()['facturacionmail'];
            $contactos['cobranza']['nombre']=$this->request->getData()['cobranzanombre'];
            $contactos['cobranza']['fono']=$this->request->getData()['cobranzafono'];
            $contactos['cobranza']['mail']=$this->request->getData()['cobranzamail'];
            $proveedorTable = $this->getTableLocator()->get('Vendors');
            $proveedor = $proveedorTable->newEmptyEntity();
            $proveedor->user_id=$this->request->getSession()->read('local.0.id');
            $proveedor->nombre= $this->request->getData()['nombre'];
            $proveedor->razon_social= $this->request->getData()['rasonSocial'];
            $proveedor->rut= $this->request->getData()['rut'];
            $proveedor->rut_dv= $this->request->getData()['rut_dv'];
            $proveedor->data_pedido= json_encode($contactos['comercial']);
            $proveedor->data_facturacion= json_encode($contactos['facturacion']);
            $proveedor->data_cobranza= json_encode($contactos['cobranza']);
            $proveedor->mail_dte= $this->request->getData()['mail'];
            $proveedor->direccion= $this->request->getData()['direccion'];
            if($proveedorTable->save($proveedor)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Proveedor agregado con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al guardar la información';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Vendors', 'action' => 'index']);
        }
    }
    public function edit($id = null){
        if($this->request->is('post')){
            $contactos['comercial']['nombre']=$this->request->getData()['comercialnombre'];
            $contactos['comercial']['fono']=$this->request->getData()['comercialfono'];
            $contactos['comercial']['mail']=$this->request->getData()['comercialmail'];
            $contactos['facturacion']['nombre']=$this->request->getData()['facturacionnombre'];
            $contactos['facturacion']['fono']=$this->request->getData()['facturacionfono'];
            $contactos['facturacion']['mail']=$this->request->getData()['facturacionmail'];
            $contactos['cobranza']['nombre']=$this->request->getData()['cobranzanombre'];
            $contactos['cobranza']['fono']=$this->request->getData()['cobranzafono'];
            $contactos['cobranza']['mail']=$this->request->getData()['cobranzamail'];
            $proveedorTable = $this->getTableLocator()->get('Vendors');
            $proveedor = $proveedorTable->get($this->request->getData()['id']);
            $proveedor->nombre= $this->request->getData()['nombre'];
            $proveedor->razon_social= $this->request->getData()['rasonSocial'];
            $proveedor->direccion= $this->request->getData()['direccion'];
            $proveedor->data_pedido= json_encode($contactos['comercial']);
            $proveedor->data_facturacion= json_encode($contactos['facturacion']);
            $proveedor->data_cobranza= json_encode($contactos['cobranza']);
            $proveedor->rut= $this->request->getData()['rut'];
            $proveedor->rut_dv= $this->request->getData()['rut_dv'];
            $proveedor->mail_dte= $this->request->getData()['mail'];
            if($proveedorTable->save($proveedor)){
                $mensaje['tipo']='success';
                $mensaje['titulo']='Información actualizada con exito';
                $mensaje['texto']='';
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='Ocurrio un error al actualizar la información';
                $mensaje['texto']='favor intentar nuevamente, si el error continua comunicarse con soporte';
            }
            $this->request->getSession()->write('mensajeAlerta', $mensaje);
            return $this->redirect(['controller'=>'Vendors', 'action' => 'edit', $this->request->getData()['id']]);
        }
        if(isset($id)){
            $data = $this->Vendors->obtieneProveedor($this->request->getSession()->read('local.0.id'), $id);
            $data[0]['data_facturacion']=json_decode($data[0]['data_facturacion'], true);
            $data[0]['data_cobranza']=json_decode($data[0]['data_cobranza'], true);
            $data[0]['data_pedido']=json_decode($data[0]['data_pedido'], true);
            $this->set(compact('data'));
        }else{
            return $this->redirect(['controller'=>'Vendors', 'action' => 'index']);
        }
    }
    public function ctacte($id=null){
        if(isset($id)){
            $this->LoadModel('CompraResumenes');
            $documentos=$this->CompraResumenes->comprasPendientes($this->request->getSession()->read('local.0.id'), $id);
            if(!empty($documentos)){
                $codigos=file_get_contents('../webroot/files/sistema/codigosDocumentosSii.json');
                $codigos=json_decode($codigos, true);
                foreach ($documentos as $key => $value) {
                    $fecha=(array)$value['fecha'];
                    $fecha2=date('d-m-Y', strtotime($fecha['date']));
                    $documentos[$key]['tipo_documento']=$codigos[$value['tipo_documento']];
                    $documentos[$key]['emision']=$fecha2;
                    $documentos[$key]['vencimiento']=date('d-m-Y', strtotime($fecha['date']."+ ".$value['dias']." days"));
                    unset($documentos[$key]['fecha']);
                }
                $this->set(compact('documentos'));
            }else{
                $mensaje['tipo']='error';
                $mensaje['titulo']='No hay documentos disponibles';
                $mensaje['texto']='';
                $this->request->getSession()->write('mensajeAlerta', $mensaje);
                return $this->redirect(['controller'=>'Proveedores', 'action' => 'index']);
            }            
        }else{
            return $this->redirect(['controller'=>'Proveedores', 'action' => 'index']);
        }
    }
    public function detalleDocumentoAjax($id=null){
        if($this->request->is('post')){
            $data=$this->request->getData();
            $id=(int)$data['id'];
            return $data;
        }else{
            return $this->redirect(['controller'=>'Proveedores', 'action' => 'index']);
        }
    }
}
