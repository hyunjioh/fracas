<?php
	$pagecode = "A00112";
	define("_administrators_",true);
	define("_g_board_include_",true);
	include "../../_core/_lib.php";
	require_once _CORE_PATH_."/system/class.MySQL.php";
	require_once _CORE_PATH_."/system/function.board.php";

	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	/*-------------------------------------------------------------------------------------------------
	▶ 게시판 정보 */	
	$Board['board_id'] = "A00112";
	$Board['board_name'] = "아이템사용내역관리";
	$Board['table_board'] = "G_Item";
	$Board['table_attach'] = "G_Board_Attach";
	$Board['page_limit'] = 20;
	$Board['page_block'] = 10;
	$Board['use_file'] = 10;
	$Board['use_reply'] = "N";

	$Board[use_comment] = "N";
	$Board[use_category] = "N";
	$Board[subject_length_main] = 30;
	$Board[subject_length_board] = 60;
	$Board[content_length] = 200;
	$Board[thumb_s_size] = 133;
	$Board[thumb_m_size] = 500;
	$Board[thumb_b_size] = 650;
	$Board[file_max_size] = "20M";
	$Board[file_check_type] = "deny";
	$Board[file_check_ext] = "php|phps|html|htm|exe|bat|sql";
	$Board[level_list] = 0;
	$Board[level_view] = 0;
	$Board[level_write] = 1;
	$Board[level_modify] = 1;
	$Board[level_reply] = 1;
	$Board[level_download] = 0;
	$Board[level_delete] = 1;
	$Board[level_comment] = 1;

	/*-------------------------------------------------------------------------------------------------
	▶ 변수 체크 */
	// 기본 변수
//	$req['idx']        = Request('idx');
	$req['OrderNum']   = Request('OrderNum');
	$req['pagenumber'] = Request('pagenumber');
	$req['pagenumber'] = SetValue($req['pagenumber'],'digit', 1);
	if($req['pagenumber'] < 1) $req['pagenumber'] = 1;

	// 검색변수
	$req['sn'] = Request('sn');
	$req['st'] = Request('st');	
	$req['sc'] = Request('sc');	

	$req['sdate'] = Request('sdate');
	$req['edate'] = Request('edate');

	$req['PCategory1'] = Request('PCategory1');
	$req['PCategory2'] = Request('PCategory2');
	$req['PCategory3'] = Request('PCategory3');
	$req['PCategory4'] = Request('PCategory4');
	$req['PCategory5'] = Request('PCategory5');
	$req['PCategory6'] = Request('PCategory6');

	// 정렬
	$req['orderby'] = Request('orderby');	
	$req['sort']    = Request('sort');	


	$Board['Link'] = $_SERVER['SCRIPT_NAME'];
	$href  = $Board['Link']."?";
	$href .= "pagenumber=".$req['pagenumber'];
	$href .= "&sn=".$req['sn'];
	$href .= "&st=".$req['st'];
	$href .= "&sc=".$req['sc'];
	$href .= "&sdate=".$req['sdate'];
	$href .= "&edate=".$req['edate'];
	$href .= "&PCategory1=".$req['PCategory1'];
	$href .= "&PCategory2=".$req['PCategory2'];
	$href .= "&PCategory3=".$req['PCategory3'];
	$href .= "&PCategory4=".$req['PCategory4'];
	$href .= "&PCategory5=".$req['PCategory5'];
	$href .= "&PCategory6=".$req['PCategory6'];
	$href .= "&orderby=".$req['orderby'];
	$href .= "&sort=".$req['sort'];


	/*-------------------------------------------------------------------------------------------------
	▶ 페이지 호출 */
	$req['at'] = Request('at');
	$include_page = null;
	switch($_GET['at']){
		case "view": 
			$include_page = "item_view.php"; break;
		case "write": 
		case "modify": 
		case "reply": 
			$include_page = "item_form.php"; break;
		case "dataprocess": 
			$include_page = "item_action.php"; break;
		case "download": 
			download();		break;
		default:
			$include_page = "item_list.php"; break;
	}

	if($include_page && file_exists($include_page)) include $include_page;


?>