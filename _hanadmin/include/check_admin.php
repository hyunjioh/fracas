<?
require_once $_SERVER['DOCUMENT_ROOT']."/_core/_lib.php";
if((!isset($_SESSION['_MEMBER_']['LEVEL'])) || $_SESSION['_MEMBER_']['LEVEL'] < _MEMBER_C_){
	toplocationHref( _ADMIN_."/Login.Form.php" );
	exit;
}
?>