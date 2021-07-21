<?php
define("_administrators_",true);
define("_g_board_include_",true);
include "../../../_core/_lib.php";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

// Checking whether all input variables are in place:
if(!is_numeric($_POST['zindex']) || !isset($_POST['author']) || !isset($_POST['body']) || !in_array($_POST['color'],array('yellow','green','blue')))
die("0");

if(ini_get('magic_quotes_gpc'))
{
	// If magic_quotes setting is on, strip the leading slashes that are automatically added to the string:
	$_POST['author']=stripslashes($_POST['author']);
	$_POST['body']=stripslashes($_POST['body']);
}

// Escaping the input data:

$author = mysql_real_escape_string(strip_tags($_POST['author']));
$body = mysql_real_escape_string(strip_tags($_POST['body']));
$color = mysql_real_escape_string($_POST['color']);
$zindex = (int)$_POST['zindex'];


/* Inserting a new record in the notes DB: */
$db -> ExecQuery('	INSERT INTO notes (text,name,color,xyz)
				VALUES ("'.$body.'","'.$author.'","'.$color.'","10x50x'.$zindex.'")');
$Pidx = LAST_INSERT_ID();
if($Pidx)
{
	// Return the id of the inserted row:
	echo $Pidx;
}
else echo '0';

?>