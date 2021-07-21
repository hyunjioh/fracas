<?php
$pagecode = "B00111";
define("_administrators_",true);
define("_g_board_include_",true);
include "../../_core/_lib.php";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

/*-------------------------------------------------------------------------------------------------
▶ 게시판 정보 */	
$Board['board_id'] = "notice";
$Board['board_name'] = "공지사항";
$Board['table_board'] = "G_Notice";
$Board['table_attach'] = "G_Notice_Attach";
$Board['comment_table'] = "G_Notice_Comment";

$Board['page_limit'] = 10;
$Board['page_block'] = 10;
$Board['use_file'] = 10;
$Board['use_reply'] = "N";
$Board['use_comment'] = "N";
$Board['use_category'] = "N";

$Board['file_max_size'] = "20M";
$Board['file_check_type'] = "deny";
$Board['file_check_ext'] = "php|phps|html|htm|exe|bat|sql";

//$_Category = BoardCategory($Board);


/*-------------------------------------------------------------------------------------------------
▶ 변수 체크 */
// 기본 변수
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
);
$href = $Board['Link']."?".http_build_query($UrlQuery); 


/*-------------------------------------------------------------------------------------------------
▶ 페이지 호출 */
$req['at'] = Request('at');
$req['at'] = (isset($_GET['at']))? $_GET['at'] : "";

$include_page = null;
switch($req['at']){
  case "view": 
    $include_page = "notice_view.php"; break;
  case "write": 
  case "modify": 
  case "reply": 
    $include_page = "notice_form.php"; break;
  case "dataprocess": 
    $include_page = "notice_action.php"; break;
  case "download": 
    download();		break;
  default:
    $include_page = "notice_list.php"; break;
}

if($include_page && file_exists($include_page)) include $include_page;

?>