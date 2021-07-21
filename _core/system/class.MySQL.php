<?php
if(!defined("_hannet_included")) exit;
###################################################################################################
/*
  * 파일명 : class.MySQL.php
  * 기능   : MySQL 컬트롤 클래스
  * create : 2012-05-09
*/
###################################################################################################

if(defined("_mysql_included")) return;
	define("_mysql_included",true);

Class MySQL {
	var $dbconn;
	var $var = "";
	var $result = "";
	var $results = "";


	// 데이터베이스 연결
	function MySQL($mysql = ''){
		Global $config, $mysql1;
    if(!$mysql) $mysql = $mysql1;
		$this->config = $config;
		$this->dbconn = mysql_connect($mysql['db_host'], $mysql['db_user'], $mysql['db_pass']) or die('Could not connect: ' . $this->Error()) ;
		if (is_resource($this->dbconn == false))die('Could not connect: ' . $this->Error());
		$status = @mysql_select_db($mysql['db_name'] , $this->dbconn)  or die('Could not connect: ' . $this->Error());
		if(is_resource($status)){return $this->Error();}
		mysql_query("set names utf8");
		return $this->dbconn;
	}

	// 데이터베이스 연결 종료
	function Disconnect(){
		if (is_resource($this->dbconn == false)) {
			die('Could not connect: ' . $this->Error());
		}else{
			mysql_close();		
		}
	}

	// 에러
	function Error($SQL = NULL){
		$message = null;
		$errNO = mysql_errno();
		$errMSG = mysql_error();
		//$caller = next(debug_backtrace());

//		return trigger_error($message.' in <strong>'.$caller['function'].'</strong> called from <strong>'.$caller['file'].'</strong> on line <strong>'.$caller['line'].'</strong>'."\n<br />");

//		return(trigger_error ($caller['line']."<b>MySQL 에러!</b><br><br><b>$errNO : $errMSG</b><br><br><small>$SQL</small><br><br>", E_USER_ERROR).exit);
		return (print_r("<b>MySQL 에러!</b><br><br><b>$errNO : $errMSG</b><br><br><small>$SQL</small><br><br>").exit);
	}
	
	// 데이터의 갯수를 
	function Total($Query){
		$result = mysql_query($Query);
		if(!is_resource($result)){return $this->Error($Query);}
		$var = mysql_fetch_array($result);
    mysql_free_result($result);
		return $var[0];
	}

	// 데이터의 갯수를 
	function Count($Query){
		$result = mysql_query($Query);
		if(!is_resource($result)){return $this->Error($Query);}
		$var = mysql_fetch_array($result);
    mysql_free_result($result);
		return $var[0];
	}

	// Select 문
	function SelectList($Query){
		$this->results  = mysql_query($Query);
		if(!is_resource($this->results)){return $this->Error($Query);}
		while($row = mysql_fetch_assoc($this->results)) {
			$var[] = $row; 
		}
    mysql_free_result($this->results);
		if(!isset($var))$var = null;
		return $var;
	}

	// Select 문
	function SelectRow($Query){
		$this->results  = mysql_query($Query);
		if(!is_resource($this->results)){return $this->Error($Query);}
		while($row = mysql_fetch_row($this->results)) {
			$var[] = $row; 
		}
    mysql_free_result($this->results);
		if(!isset($var))$var = null;
		return $var;
	}

	// Select 문
	function SelectArray($Query){
		$this->results  = mysql_query($Query);
		if(!is_resource($this->results)){return $this->Error($Query);}
		while($row = mysql_fetch_assoc($this->results)) {
			$var[] = $row; 
		}
    mysql_free_result($this->results);
		if(!isset($var))$var = null;
		return $var;
	}

	// 하나의 데이터만 가져가는 쿼리
	function SelectOne($Query){
		$result = mysql_query($Query);
		if(!is_resource($result)){return $this->Error($Query);}
		$var = mysql_fetch_assoc($result);
    mysql_free_result($result);
		return $var;
	}

	// 하나의 데이터만 가져가는 쿼리
	function Value($Query){
		$result = mysql_query($Query);
		if(!is_resource($result)){return $this->Error($Query);}
		$var = mysql_fetch_row($result);
    mysql_free_result($result);
		return $var[0];
	}

	// 	 db 에서 insert, delect, update 쿼리를 실행하는 함수 return : 적용된 rows 수, 에러가 있다면, -1를 반환 
	function ExecQuery($Query){
		$result = mysql_query($Query,$this->dbconn);
		if($result) return mysql_affected_rows($this->dbconn);  
		return -1; 
	}

	function CheckTable($table) {
		Global $config, $mysql1;
    if(!$mysql) $mysql = $mysql1;
		$exists = mysql_query('SHOW TABLES FROM `'.$mysql['db_name'].'` LIKE \''.$table.'\'', $this->dbconn);
		return mysql_num_rows($exists) == 1;

	}

}
?>