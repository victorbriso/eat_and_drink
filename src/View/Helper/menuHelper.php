<?
namespace App\View\Helper;
use Cake\View\Helper;
class MenuHelper extends Helper{
    public function menuActivo($controller=null, $action=null, $ubicacion=null, $parametro=null){ 
        $controllerName = $ubicacion['controller'];
        $actionName = $ubicacion['action'];
        if(!isset($parametro)){
        	if($controller==$controllerName&&$action==$actionName){
	        	return true;
	        }else{
	        	return false;
	        }
        }else{
        	$pasAction=$ubicacion['parametro'];
        	if($controller==$controllerName&&$action==$actionName&&$pasAction==$parametro){
	        	return true;
	        }else{
	        	return false;
	        }
        }
        
    }
}