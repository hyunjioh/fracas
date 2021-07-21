<? 
define("_administrators_",true);
require_once "../_core/_lib.php";
require_once "include/manager.inc.php";

$req['at'] = $_GET['at'];

if(defined("_is_manager_") && $req['at'] != "logout" ){
	toplocationHref( _ADMIN_."/board/schedule.php" );
}else{
	/*-------------------------------------------------------------------------------------------------
	▶ 페이지 호출 */
	$include_page = null;
	switch($req['at']){
		case "login": 
			$include_page = _ADMIN_PATH_."/Login.Form.php"; break;
		case "loginprocess": 
			$include_page = _ADMIN_PATH_."/Login.Check.php"; break;
		case "logout": 
			$include_page = _ADMIN_PATH_."/LogOut.php"; break;
		default:
			$include_page = _ADMIN_PATH_."/Login.Form.php"; break;
	}

	if($include_page && file_exists($include_page)) include $include_page;
}
?>