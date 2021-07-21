<?php
	define("_g_board_include_",true);
	include "../../_core/_lib.php";
	require_once _CORE_PATH_."/system/class.MySQL.php";
	require_once _CORE_PATH_."/system/function.board.php";
	require_once _CORE_PATH_."/lang/ko.php";

	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	/*-------------------------------------------------------------------------------------------------
	▶ 게시판 정보 */	
	$PageTitle = "관리자게시판";
	$set['id'] = "Manager";
	$Board = $db -> SelectOne("Select * from G__Config where board_id = '".$set['id']."' ");
	if(!$Board)	locationReplace("/",$msg['board_does_not_exist']);	
	$db -> Disconnect();
	$Board['Link'] = "./";


	/*-------------------------------------------------------------------------------------------------
	▶ 변수 체크 */
	// 기본 변수
	$req['idx']        = Request('idx');
	$req['pagenumber'] = Request('pagenumber');
	$req['pagenumber'] = SetValue($req['pagenumber'],'digit', 1);

	// 검색변수
	$req['sn'] = Request('sn');
	$req['st'] = Request('st');	
	$req['sc'] = Request('sc');	

	// 정렬
	$req['orderby'] = Request('orderby');	
	$req['sort']    = Request('sort');	

	$parameter  = "pagenumber=".$req['pagenumber'];
	$parameter .= "&sn=".$req['sn'];
	$parameter .= "&st=".$req['st'];
	$parameter .= "&sc=".$req['sc'];
	$parameter .= "&bt=".$req['bt'];
	$parameter .= "&orderby=".$req['orderby'];
	$parameter .= "&sort=".$req['sort'];


	/*-------------------------------------------------------------------------------------------------
	▶ 페이지 호출 */
	$req['at'] = Request('at');
	$include_page = null;
	switch($_GET['at']){
		case "view": 
			$include_page = "board_view.php"; break;
		case "write": 
			$include_page = "board_form.php"; break;
		case "modify": 
			$include_page = "board_form.php"; break;
		case "dataprocess": 
			$include_page = "board_action.php"; break;
		case "download": 
			$include_page = "board_download.php"; break;
		case "comment_list": 
			$include_page = "comment_list.php"; break;
		default:
			$include_page = "board_list.php"; break;
	}
	if($include_page && file_exists($include_page)) include $include_page;


?>