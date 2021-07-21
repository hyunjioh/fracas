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
	$set['id'] = "Order";
	$Board = $db -> SelectOne("Select * from G__Config where board_id = '".$set['id']."' ");
	if(!$Board)	locationReplace("/",$msg['board_does_not_exist']);	
	$db -> Disconnect();
	$Board['Link'] = "./";
	$PageTitle = $Board['board_name']; 

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

	$href  = $Board['Link']."?";
	$href .= "pagenumber=".$req['pagenumber'];
	$href .= "&sn=".$req['sn'];
	$href .= "&st=".$req['st'];
	$href .= "&sc=".$req['sc'];
	$href .= "&bt=".$req['bt'];
	$href .= "&orderby=".$req['orderby'];
	$href .= "&sort=".$req['sort'];


	/*-------------------------------------------------------------------------------------------------
	▶ 페이지 호출 */
	$req['at'] = Request('at');
	$include_page = null;
	switch($_GET['at']){
		case "view": 
			$include_page = "g_view.php"; break;
		case "write": 
		case "modify": 
			$include_page = "g_form.php"; break;
		case "dataprocess": 
			$include_page = "g_action.php"; break;
		case "download": 
			download();		break;
		case "comment_list": 
			$include_page = "g_comment.php"; break;
		default:
			$include_page = "g_list.php"; break;
	}

	if($include_page && file_exists($include_page)) include $include_page;


?>