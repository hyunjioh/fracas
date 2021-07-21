<?php

require_once str_replace("/class","",dirname(__FILE__))."/_core/_lib.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
	<meta name="description" content="예교원, 신경과학예술교육원, 임산부와 엄마를 위한 문화예술 교육공간" />
	<meta name="keywords" content="예교원, 신경과학예술교육원, 임산부와 엄마를 위한 문화예술 교육공간" />

	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />

<script type="text/javascript" src="/_core/js/jquery-ui-1.8.20.custom/js/jquery-1.7.2.min.js"></script><!-- jquery -->
<script type="text/javascript" src="/_core/js/jquery-ui-1.8.20.custom/js/jquery-ui-1.8.20.custom.min.js"></script><!-- jquery UI -->
<script type="text/javascript" src="/_core/js/jquery.tools.min.js"></script><!-- jquery Tools (overlay) -->

<script type="text/javascript" src="/js/overlay.js" ></script>

	<script language="javascript" src="../js/jquery.easing.1.3.js" type="text/javascript"></script>
	<script language="javascript" src="../js/gnb.js" type="text/javascript"></script>
	<!-- script language="javascript" src="../js/jquery.tools.min.js"></script -->
	<script language="javascript" src="../js/common.js" type="text/javascript"></script>
	<script language="javascript" src="../js/link.js" type="text/javascript"></script>
	
<!-- LOG -->
<script type="text/javascript">var _HANNET_LOG_ID = "hanygcenter.cafe24.com"</script>
<script type="text/javascript" src="/log.js"></script>

<?
	$PageNum1 = 4;
	$SubNum1 = 1;
	$SubNum2 = 0;
?>	

<?php
define("_g_board_include_",true);

/*-------------------------------------------------------------------------------------------------
▶ 게시판 정보 */
$Board['board_id'] = "schedule";
$Board['board_name'] = "주요일정";

$Board['table_board'] = "G_Info";
$Board['table_attach'] = "G_Info_Attach";
$Board['comment_table'] = "G_Info_Comment";

$Board['page_limit'] = 10;
$Board['page_block'] = 10;
$Board['use_file'] = 10;
$Board['use_reply'] = "N";
$Board['use_comment'] = "N";
$Board['use_category'] = "N";
$Board['page_skin']  = "type2";

$Board['file_max_size'] = "20M";
$Board['file_check_type'] = "deny";
$Board['file_check_ext'] = "php|phps|html|htm|exe|bat|sql";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */
unset($db);
$db = new MySQL($mysql1);

/*-------------------------------------------------------------------------------------------------
▶ 변수 체크 */
// 기본 변수
$req['sDate'] = Request('sDate');
$req['idx'] = Request('idx');
$req['idx'] = (is_numeric($req['idx']))? $req['idx']: null;
$req['pagenumber'] = Request('pagenumber');
$req['pagenumber'] = SetValue($req['pagenumber'],'digit', 1);
if($req['pagenumber'] < 1) $req['pagenumber'] = 1;

// 검색변수
$req['sn'] = Request('sn');
$req['st'] = Request('st');
$req['sc'] = Request('sc');
$req['st'] = strip_tags($req['st']);

$req['sdate'] = Request('sdate');
$req['edate'] = Request('edate');

// 정렬
$req['orderby'] = Request('orderby');
$req['sort']    = Request('sort');

// 빈값일 경우 변수값을 초기화
$req['sn'] = ($req['sn'] == "")? null : $req['sn'];
$req['st'] = ($req['st'] == "")? null : $req['st'];
$req['sc'] = ($req['sc'] == "")? null : $req['sc'];

$req['sdate'] = ($req['sdate'] == "")? null : $req['sdate'];
$req['edate'] = ($req['edate'] == "")? null : $req['edate'];

$req['orderby'] = ($req['orderby'] == "")? null : $req['orderby'];
$req['sort'] = ($req['sort'] == "")? null : $req['sort'];

/*-------------------------------------------------------------------------------------------------
▶ url query string */
$Board['Link'] = $_SERVER['SCRIPT_NAME'];
$UrlQuery = array(
  "pagenumber" => $req['pagenumber'],
  "sn" => $req['sn'],
  "st" => $req['st'],
  "sc" => $req['sc'],
  "sdate" => $req['sdate'],
  "edate" => $req['edate'],
  "orderby" => $req['orderby'],
  "sort" => $req['sort'],
  "sDate" => $req['sDate'],
);
$href = $Board['Link']."?".http_build_query($UrlQuery); 

/*-------------------------------------------------------------------------------------------------
▶ 페이지 호출 */
$req['at'] = Request('at');
$req['at'] = (isset($_GET['at']))? $_GET['at'] : "";

$include_page = null;
switch($req['at']){
	case "view":
		$include_page = "schedule_view.php"; break;
	case "download":
		download();		break;
	default:
		$include_page = "class_register_list.php"; break;
}

if(!defined("_get_config_")) if($include_page && file_exists($include_page)) include $include_page;

?>