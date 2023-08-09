<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Controller\Controller;
class AppController extends Controller{
    public function initialize(): void{
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
    public function beforeFilter(\Cake\Event\EventInterface $event){
        $token = $this->request->getAttribute('csrfToken');
        $controllerName = $this->request->getParam('controller');
        $actionName = $this->request->getParam('action');
        $passAction=null;
        if(isset($this->request->getParam('pass')[0])){
            $passAction =$this->request->getParam('pass')[0];
        }        
        if($controllerName!='Pages'&&$controllerName!='Users'&&$controllerName!='Rest'){
            if(!$this->request->getSession()->check('local')){  
                return $this->redirect(['controller'=>'Users', 'action' => 'login']);
            }
        }
        if($this->request->getSession()->check('local.0.plan')){
            $menuAdmin=($this->request->getSession()->read('local.0.plan')==1)?'menuAdminSimple':'menuLateralAdmin';
            $planCliente=$this->request->getSession()->read('local.0.plan');
        }else{
            $menuAdmin='menuAdminSimple';
            $planCliente=0;
        }
        $dondeEstoy['controller']=$controllerName;
        $dondeEstoy['action']=$actionName;
        $dondeEstoy['parametro']=$passAction;
        if($this->request->getSession()->check('local.0.id')&&$this->request->getSession()->check('usuario')){
            if($this->request->getSession()->read('local.0.id')!=1){
                if(!$this->generalValidaPermisos($controllerName, $actionName)){
                    if(!$this->generalObtieneAccionesSinPermisos($controllerName, $actionName)){
                        $mensaje['tipo']='error';
                        $mensaje['titulo']='Acceso denegado';
                        $mensaje['texto']='Su perfil no esta autorizado a realizar esta acción';
                        $this->request->getSession()->write('mensajeAlerta', $mensaje);
                        return $this->redirect(['controller'=>$this->request->getSession()->read('usuario.profile.inicio.controller'), 'action' => $this->request->getSession()->read('usuario.profile.inicio.action')]);   
                    }    
                }    
            }                                 
        }
        $this->set([
            'token' => $token,
            'dondeEstoy'=>$dondeEstoy,
            'menuAdmin'=>$menuAdmin,
            'planCliente'=>$planCliente,
        ]); 
    }
    public function generalObtienePerfiles(){
        $data=array(
            'Users'=>array(
                'dashboard'=>'Dashboard', 
                'sistema'=>'Sistema',
                'impresoras'=>'Configurar Impresoras',
                'cambioContrasenha'=>'Cambiar Contraseña general',
            ),
            'Comandas'=>array(
                'index'=>'Inicio',
                'add'=>'Crear Comanda',
                'edit'=>'Agregar Productos',
                'cuenta'=>'Cuenta',
                'editar'=>'Editar',
                'descuento'=>'Descuentos'
            ),
            'Products'=>array(
                'index'=>'Ver productos',
                'add'=>'Agregar Productos',
                'edit'=>'Editar Productos',
                'publicacion'=>'Publicar Carta',
                'insumos'=>'Ver Insumos',
                'addInsumo'=>'Agregar Insumos',
                'lugaresElaboracion'=>'Ver lugares de elaboración',
                'addLugarElab'=>'Agregar lugares de elaboración',
                'listasPrecio'=>'Ver listas de Precios',
                'addListaPrecio'=>'Agregar listas de precios',
                'eliminarLista'=>'Eliminar listas de precios'
            ),
            'Tables'=>array(
                'index'=>'Ver Mesas',
                'add'=>'Agregar Mesas',
                'cambioMesa'=>'Cambiar Mesas',
                'anulacion'=>'Anular productos',
            ),
            'Cashboxes'=>array(
                'index'=>'Ver cajas',
                'add'=>'Agregar Cajas',
                'asignarUsuarioCaja'=>'Asignar usuario a caja',
                'apertura'=>'Abrir Caja',
                'ingresoRetiro'=>'Ingresos y retiros',
                'pagoCuenta'=>'Pago de cuentas',
                'cajasEstado'=>'Ver estado de caja',
                'cierre'=>'Cerrar caja'
            ),
            'BuySummaries'=>array(
                'index'=>'Ver Compras',
                'add'=>'Registrar Compras',
            ),
            'Vendors'=>array(
                'index'=>'Ver Proveedores',
                'add'=>'Agregar Proveedores',
                'edit'=>'Editar Proveedor'
            ),
            'Profiles'=>array(
                'index'=>'Ver perfiles del sistema',
                'add'=>'Agregar perfiles',
                'edit'=>'Editar Perfiles'
            ),
            'Usuarios'=>array(
                'index'=>'Ver Usuarios',
                'add'=>'Agregar Usuarios',
                'edit'=>'Editar Usuarios'
            )
        );
        return $data;
    }
    public function generalObtienePagInicio(){
        $data=array(
            'Users'=>array(
                'seccion'=>'general',
                'data'=>array(
                    'dashboard'=>'Dashboard', 
                    'sistema'=>'Sistema'
                )                
            ),
            'Comandas'=>array(
                'seccion'=>'Comandas',
                'data'=>array(
                    'index'=>'Inicio',
                    'add'=>'Crear Comanda'
                )                
            ),
            'Products'=>array(
                'seccion'=>'Productos',
                'data'=>array(
                    'index'=>'Ver productos',
                    'publicacion'=>'Publicar Carta',
                    'insumos'=>'Ver Insumos'
                )                
            ),
            'Tables'=>array(
                'seccion'=>'Mesas',
                'data'=>array(
                    'index'=>'Ver Mesas',
                )                
            ),
            'Cashboxes'=>array(
                'seccion'=>'Cajas',
                'data'=>array(
                    'index'=>'Ver cajas'
                )                
            ),
            'BuySummaries'=>array(
                'seccion'=>'Compras',
                'data'=>array(
                    'index'=>'Ver Compras'
                )                
            ),
            'Vendors'=>array(
                'seccion'=>'Proveedores',
                'data'=>array(
                    'index'=>'Ver Proveedores'
                )                 
            )
        );
        return $data;
    }
    public function generalValidaPermisos($controlador=null, $accion=null){
        $permisosUsuarios=$this->request->getSession()->read('usuario.profile.roles');
        if(isset($permisosUsuarios[$controlador][$accion])){
            return true;
        }else{
            return false;
        }
    }
    public function generalObtieneAccionesSinPermisos($controlador=null, $accion=null){
        if(isset($controlador)&&isset($accion)){
            $data=$this->generalAccionesSinPermiso();
            //prx($data);
            if(isset($data[$controlador][$accion])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function generalAccionesSinPermiso(){
        $data=array(
            'Users'=>array(
                'login'=>1, 
                'login2'=>1, 
                'logout'=>1, 
                'loginUsuario'=>1, 
                'validaLoginUsuario'=>1,
                'finalizaNotificacion'=>1,
                'consultaNotificaciones'=>1,
            ),
            'Rest'=>array(
                'prueba'=>1
            ),
            'Products'=>array(
                'obtieneUnidadesMedida'=>1,
                'normalizaListasPrecio'=>1,
            ),
            'Comandas'=>array(
                'mesasComandaNueva'=>1,
            )
        );
        return $data;
    }
}
