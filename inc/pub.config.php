<?php
define('DIR','');
define('PATH',$_SERVER['DOCUMENT_ROOT'].DIR);

require_once "../_core/_lib.php";

function pubGnb($str){
	global $_dep;
	$exp = explode(',',$str);
	$exp_count = count($exp);
	$act = 0;
	for($i=0;$i<count($exp);$i++){
		if($_dep[$i] == $exp[$i]){
			$act ++;
		}
	}
	if($act==$exp_count){
		echo 'active';
	}
}

if(!isset($_SERVER["HTTPS"])) {  

	header('Location: https://fracas.cafe24.com');

}

?>