<?
define("_administrators_",true);
require_once "../_core/_lib.php";
require_once "include/manager.inc.php";

unset($_SESSION['_MANAGER_']['ID']);
unset($_SESSION['_MANAGER_']['NAME']);
unset($_SESSION['_MANAGER_']['Auth_R']);
unset($_SESSION['_MANAGER_']['Auth_W']);
unset($_SESSION['_MANAGER_']['Auth_D']);

if(count($_SESSION)){ 
	foreach($_SESSION as $key => $value){ 
		unset($_SESSION['$key']);
		if(is_array($value)){
			foreach($value as $key2 => $value2){
				unset($_SESSION['$key']['$key2']);			
			}
		}
	} 
}
@session_destroy();
toplocationHref( _ADMIN_);
?>