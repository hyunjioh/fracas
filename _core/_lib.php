<?php
define("_hannet_included",true);
###################################################################################################
/*

- include 되었는지를 검사

*/
###################################################################################################
if(defined("_lib_included")) return;
	define("_lib_included",true);


###################################################################################################
/*

- 변수 처리 ,register_globals_on일때 변수 재 정의

*/
###################################################################################################
unset($req);
unset($set);
unset($cfg);
unset($msg);

// 짧은 환경변수를 지원하지 않는다면
if (isset($HTTP_POST_VARS) && !isset($_POST)) {
	$_POST   = &$HTTP_POST_VARS;
	$_GET    = &$HTTP_GET_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_ENV    = &$HTTP_ENV_VARS;
	$_FILES  = &$HTTP_POST_FILES;
	if (!isset($_SESSION))$_SESSION = &$HTTP_SESSION_VARS;
}


###################################################################################################
/*

- 공통 상수/변수 설정

*/
###################################################################################################
if(file_exists(dirname(__FILE__)."/_config.php")){
	include(dirname(__FILE__)."/_config.php");
}else{
	echo "Error : _config.php file does not exist.";
	exit;
}

if(!isset($ROOT) || !$ROOT) $ROOT = $_SERVER['DOCUMENT_ROOT'];
$basename = basename(dirname($_SERVER['SCRIPT_NAME']));

$date     = date("Y-m-d");
$dateTime = date("Y-m-d H:i:s");
$subDir   = date("Y/m/d");
$req['ref'] = (isset($_GET['_referer_']) && $_GET['_referer_'])?  $_GET['_referer_']: $_SERVER['REQUEST_URI'] ;

###################################################################################################
/*

- php header

*/
###################################################################################################
// W3C P3P 규약설정
header("P3P : CP=\"ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC\"");
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Cache-Control: public, must-revalidate");
header("Pragma: hack");


###################################################################################################
/*

- timezone

*/
###################################################################################################
//	$phpversion = phpversion();
if(PHP_VERSION > 5)		date_default_timezone_set('Asia/Seoul');
if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
@date_default_timezone_set(@date_default_timezone_get());

###################################################################################################
/*

- php.ini config

*/
###################################################################################################
@ini_set("session.use_trans_sid", 0);
@ini_set("memory_limit","512M");
//@ini_set("session.auto_start",1);
###################################################################################################
/*

- ERROR REPORTING

*/
###################################################################################################
if(_ERROR_REPORTING == "on"){
	error_reporting(E_ALL ^ E_NOTICE);
	//error_reporting(E_ALL);
	//ini_set('error_reporting', E_ALL | E_STRICT);
	ini_set('display_error','on');
}elseif(_ERROR_REPORTING == "log"){
	/*-------------------------------------------------------------------------------------------------
	▶ 디버깅 설정 */
	//에러 리포팅 설정 (on은 개발시 에러코드를 화면에 찍고 오픈하면 log로 설정하여 로그로만 기록한다. 기록을 원하지 않을 때는 off로 설정한다.)

	define("_ERROR_LOG_FILE","error_log_".date("Ymd").".txt");     //로그파일명 (절대경로로 설정할 것)
	if(!file_exists( _ERROR_LOG_PATH."/"._ERROR_LOG_FILE )){
		if(!is_writable(_ERROR_LOG_PATH)){
			umask(0);
			if(file_exists(_ERROR_LOG_PATH)) chmod( _ERROR_LOG_PATH, 0777);

			else	mkdir( _ERROR_LOG_PATH , 0777);

			if(!file_exists(_ERROR_LOG_PATH)) {
				echo "저장 폴더가 존재하지 않습니다. ";
				exit;
			}
			if(!is_writable(_ERROR_LOG_PATH)) {
				 "저장 폴더에 쓰기권한이 없습니다.";
				 exit;
			}
		}

		if(touch( _ERROR_LOG_PATH."/"._ERROR_LOG_FILE )){

		}else{
			echo "error_log.txt file does not exist";
			exit;
		}
	}
	ini_set('error_reporting', E_ALL | E_STRICT);
	ini_set('log_error','on');
	ini_set('error_log', _ERROR_LOG_PATH."/"._ERROR_LOG_FILE);
	set_error_handler('myErrorHandler');
}elseif(_ERROR_REPORTING == "off"){
	error_reporting(E_ERROR | E_PARSE);
}


// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline){
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
				$error = "---------------------------------------------------------------\n Fatal error [".date("Y-m-d H:i:s")."]\n";
        $error .= " : errorno [$errno] $errstr";
        $error .= ", line $errline in file $errfile PHP " . PHP_VERSION . " (" . PHP_OS . ")\n";
				$error .= "\n\n";
				error_log($error, 3, _ERROR_LOG_PATH."/"._ERROR_LOG_FILE);
        exit(1);
        break;

    case E_USER_WARNING:
				$error = "---------------------------------------------------------------\n WARNING [".date("Y-m-d H:i:s")."]\n";
        $error .= " : errorno [$errno] $errstr";
        $error .= ", line $errline in file $errfile \n";
				$error .= "\n\n";
        break;

    case E_USER_NOTICE:
				$error = "---------------------------------------------------------------\n NOTICE [".date("Y-m-d H:i:s")."]\n";
        $error .= " : errorno [$errno] $errstr";
        $error .= ", line $errline in file $errfile \n";
				$error .= "\n\n";
        break;

    default:
				$error = "---------------------------------------------------------------\n Unknown error [".date("Y-m-d H:i:s")."]\n";
        $error .= " : errorno [$errno] $errstr";
        $error .= ", line $errline in file $errfile \n";
				$error .= "\n\n";
        break;
    }

		error_log($error, 3, _ERROR_LOG_PATH."/"._ERROR_LOG_FILE);

    /* Don't execute PHP internal error handler */
    return true;
}


###################################################################################################
/*

- function/class/session

*/
###################################################################################################
require_once dirname(__FILE__)."/system/class.MySQL.php";
require_once dirname(__FILE__)."/system/function.common.php";
require_once dirname(__FILE__)."/system/function.mall.php";
require_once dirname(__FILE__)."/system/function.site.php";

/*-------------------------------------------------------------------------------------------------
▶ 세션 설정
-------------------------------------------------------------------------------------------------*/
$UserID = null;
if(!defined("_install_include")){
if(defined("_administrators_")){
	//require_once dirname(__FILE__)."/system/class.SessionAdmin.php";
  if(ini_get('session.auto_start') < 1)		if (session_id() == "") @session_start();
	if(isset($_SESSION['_MANAGER_']['ID']) && !empty($_SESSION['_MANAGER_']['ID'])){
    $MemberID   = decrypt_md5($_SESSION['_MANAGER_']['ID'],"sessionADMIN");
    $MemberName = decrypt_md5($_SESSION['_MANAGER_']['NAME'],"sessionADMIN");
  }
}else{
	require_once dirname(__FILE__)."/system/class.Session.php";
  if(ini_get('session.auto_start') < 1)		if (session_id() == "") @session_start();
	if(isset($_SESSION['_MEMBER_']['ID']) && !empty($_SESSION['_MEMBER_']['ID'])){
		define("USER_SESSION", $_SESSION['_MEMBER_']['ID']);
		$MemberID   = decrypt_md5($_SESSION['_MEMBER_']['ID'],"session");
		$MemberName = decrypt_md5($_SESSION['_MEMBER_']['NAME'],"session");
	}
	if(isset($_COOKIE['userid']) && !empty($_COOKIE['userid']) )      $UserID = decrypt_md5($_COOKIE['userid'],"cookie");
}

//if (!isset($_SERVER['HTTPS'])) {  	header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']); }
}


function HeadPrint($tag){
  global $HEAD_INCLUDE_1, $HEAD_INCLUDE_2, $HEAD_INCLUDE_3;
  $return = $HEAD_INCLUDE_1;
  if(isset($tag['title']) && !empty($tag['title'])){
    $return .= "<title>".$tag['title']."</title>\n";
  }else{
    $return .= "<title>"._HOMEPAGE_NAME_."</title>\n";  
  }
  if(isset($tag['meta_keywords']) && !empty($tag['meta_keywords'])) $return .= "<meta name=\"keywords\" content=\"".$tag['meta_keywords']."\">\n";
  if(isset($tag['meta_kescription']) && !empty($tag['meta_kescription'])) $return .= "<meta name=\"description\" content=\"".$tag['meta_kescription']."\">\n";

  $return .= $HEAD_INCLUDE_2.$HEAD_INCLUDE_3;
	echo $return;
}

if(!isset($PageNum) || empty($PageNum)) $PageNum = 0;
if(!isset($SubNum1) || empty($SubNum1)) $SubNum1 = 0;
if(!isset($SubNum2) || empty($SubNum2)) $SubNum2 = 0;

$page_title = _HOMEPAGE_NAME_;
$ALPHA = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
if($PageCode){
  $dd = explode("_",$PageCode);
  $d1 = $dd[0];
  $d2 = $dd[1];
  $d1_str = $d1;
  $d1 = (ctype_alpha($d1))? $d1 : 0;
	$page_title = ($d1 != "0")? $LINK[$d1."_"][$d2]['0']." - ".$LINK[$d1]['0']." | ".$page_title : $page_title ;
}else{
  $d1 = $d2 = 0;
}


if(!isset($MemberID) || empty($MemberID)){
  if(is_array($MemberOnly)){
    foreach($MemberOnly as $ReplaceMenuKey =>  $ReplaceMenuValue){
      $ReplaceMenuValueExplode = explode("_",$ReplaceMenuValue);
      if(count($ReplaceMenuValueExplode) > 1){
        $LINK[$ReplaceMenuValueExplode[0]."_"][$ReplaceMenuValueExplode[1]][1] = "javascript:RequireLogin('".$LINK[$ReplaceMenuValueExplode[0]."_"][$ReplaceMenuValueExplode[1]][1]."');";
      }else{
        $LINK[$ReplaceMenuValueExplode[0]][1] = "javascript:RequireLogin('".$LINK[$ReplaceMenuValueExplode[0]][1]."');";      
      } 
    }
  }
}


$deny_ip_list = "211.116";
$ip_check_rule = "allow";
if (ip_block($deny_ip_list, $ip_check_rule, $client_ip)) {
  header("HTTP/1.1 403 Forbidden"); 
  //header("HTTP/1.1 503 Service Unavailable");
 die(); 
}

###################################################################################################
/*

-

*/
###################################################################################################
?>