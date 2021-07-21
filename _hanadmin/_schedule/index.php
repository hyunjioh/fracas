<?php
	$pagecode = "A00211";
	define("_administrators_",true);
	define("_g_board_include_",true);
	include "../../_core/_lib.php";
	require_once _CORE_PATH_."/system/class.MySQL.php";

	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;


	/*-------------------------------------------------------------------------------------------------
	▶ 게시판 정보 */	
	$Board['board_id'] = "Schedule";
	$Board['table_board'] = "G_Schedule";
	$Board['table_attach'] = "G_Schedule_Attach";
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

	$parameter .= "&orderby=".$req['orderby'];
	$parameter .= "&sort=".$req['sort'];


	/*-------------------------------------------------------------------------------------------------
	▶ 페이지 호출 */
	$req['at'] = Request('at');
	$req['at'] = (isset($_GET['at']))? $_GET['at'] : "";

	$include_page = null;
	switch($req['at']){
		case "json": 
			$include_page = "json-events.php"; break;
		case "info": 
			$include_page = "schedule_info.php"; break;
		case "dataprocess": 
			$include_page = "schedule_action.php"; break;
		default:
			$include_page = "schedule.php"; break;
	}
	if($include_page && file_exists($include_page)) include $include_page;


?>