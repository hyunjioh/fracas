<?
include "../_lib.php";
include "../system/class.MySQL.php";
$db = new MySQL;
if(mysql_get_server_info() > 5) {
	header("Location:mysql1");
}else{
	header("Location:mysql2");
}
?>