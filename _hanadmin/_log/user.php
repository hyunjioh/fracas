<?php
 	$pagecode = "A00315";
	define("_administrators_",true);
	define("_g_board_include_",true);
  require_once str_replace("/_hanadmin/_log","",dirname(__FILE__))."/_core/_lib.php";
	require_once _CORE_PATH_."/system/class.MySQL.php";

  ini_set("allow_url_fopen",1);
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */
	unset($db);
	$db = new MySQL;

  $req['at'] = "user";
  include "inc/_log.common.php";
  include "log_user.php";
?>