<?php
	$pagecode = "C00411";
	define("_administrators_",true);
	define("_g_board_include_",true);
	include "../../_core/_lib.php";


	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	/*-------------------------------------------------------------------------------------------------
	▶ 게시판 정보 */	
	$Board['board_id'] = "Coupon";
	$Board['board_name'] = "쿠폰발행";
	$Board['table_board'] = "G_Coupon";
	$Board['page_limit'] = 10;
	$Board['page_block'] = 10;

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
	$req['s1'] = Request('s1');	
	$req['s2'] = Request('s2');	
	$req['s3'] = Request('s3');	

	// 정렬
	$req['orderby'] = Request('orderby');	
	$req['sort']    = Request('sort');	

	$Board['Link'] = $_SERVER['SCRIPT_NAME'];
	$href  = $Board['Link']."?";
	$href .= "pagenumber=".$req['pagenumber'];
	$href .= "&sn=".$req['sn'];
	$href .= "&st=".$req['st'];
	$href .= "&sc=".$req['sc'];
	$href .= "&orderby=".$req['orderby'];
	$href .= "&sort=".$req['sort'];
	$href .= "&s1=".$req['s1'];
	$href .= "&s2=".$req['s2'];
	$href .= "&s3=".$req['s3'];


	/*-------------------------------------------------------------------------------------------------
	▶ 페이지 호출 */
	$req['at'] = Request('at');
	$req['at'] = (isset($_GET['at']))? $_GET['at'] : "";

	$include_page = null;
	switch($req['at']){
		case "view": 
			$include_page = "coupon_view.php"; break;
		case "write": 
		case "modify": 
			$include_page = "coupon_form.php"; break;
		case "dataprocess": 
			$include_page = "coupon_action.php"; break;
		case "download": 
			download();		break;
		default:
			$include_page = "coupon_form.php"; break;
	}

	if($include_page && file_exists($include_page)) include $include_page;


?>