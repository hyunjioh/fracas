<?php
define("_administrators_",true);
define("_g_board_include_",true);
include "../../../_core/_lib.php";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;


// Validating the input data:
if(!is_numeric($_GET['id']) || !is_numeric($_GET['x']) || !is_numeric($_GET['y']) || !is_numeric($_GET['z']))
die("0");

// Escaping:
$id = (int)$_GET['id'];
$x = (int)$_GET['x'];
$y = (int)$_GET['y'];
$z = (int)$_GET['z'];

// Saving the position and z-index of the note:
$db -> ExecQuery("UPDATE notes SET xyz='".$x."x".$y."x".$z."' WHERE id=".$id);

echo "1";
?>