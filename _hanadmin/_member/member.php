<?php
	$pagecode = "E00111";
  define("_administrators_",true);
  define("_g_board_include_",true);
  include "../../_core/_lib.php";

	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	/*-------------------------------------------------------------------------------------------------
	▶ 게시판 정보 */	
	$Board['board_id'] = "member";
	$Board['board_name'] = "회원관리";
	$Board['table_board'] = "G_Member";
	$Board['table_attach'] = "";

  $Board['page_limit'] = 10;
  $Board['page_block'] = 10;
  $Board['use_file'] = 10;
  $Board['use_reply'] = "N";
  $Board['use_comment'] = "Y";
  $Board['use_category'] = "N";

  $Board['file_max_size'] = "20M";
  $Board['file_check_type'] = "deny";
  $Board['file_check_ext'] = "php|phps|html|htm|exe|bat|sql";


	/*-------------------------------------------------------------------------------------------------
	▶ 변수 체크 */
	// 기본 변수
	$req['idx']        = Request('idx');
	$req['mid']        = Request('mid');
	$req['pagenumber'] = Request('pagenumber');
	$req['pagenumber'] = SetValue($req['pagenumber'],'digit', 1);

	// 검색변수
	$req['sn'] = Request('sn');
	$req['st'] = Request('st');	
	$req['sc'] = Request('sc');	
	$req['sp'] = Request('sp');	
	$req['se'] = Request('se');	
	$req['sa'] = Request('sa');	
	$req['ss'] = Request('ss');	
	$req['so'] = Request('so');	
	$req['sr'] = Request('sr');	
	$req['sm'] = Request('sm');	

	$req['sdate'] = Request('sdate');
	$req['edate'] = Request('edate');

	$req['sdate02'] = Request('sdate02');
	$req['edate02'] = Request('edate02');

	// 정렬
	$req['orderby'] = Request('orderby');	
	$req['sort']    = Request('sort');	

  if(!$req['ss']) $req['ss'] = array("s0");
  if(!$req['so']) $req['so'] = array("s0");
  if(!$req['sr']) $req['sr'] = array("0","1","2","3","4","5");
  if(!$req['sm']) $req['sm'] = array("s1","s2");

	$Board['Link'] = $_SERVER['SCRIPT_NAME'];

  $UrlQuery = array(
    "pagenumber" => $req['pagenumber'],
    "sn" => $req['sn'],
    "st" => $req['st'],
    "sc" => $req['sc'],
    "sp" => $req['sp'],
    "se" => $req['se'],
    "sa" => $req['sa'],
    "sdate" => $req['sdate'],
    "edate" => $req['edate'],
    "sdate02" => $req['sdate02'],
    "edate02" => $req['edate02'],
    "orderby" => $req['orderby'],
    "sort" => $req['sort'],
  );
  $href = $Board['Link']."?".http_build_query($UrlQuery); 
  foreach($req['ss'] as $ssk => $ssv)	$href .= "&ss[]=".$ssv;
  foreach($req['so'] as $sok => $sov)	$href .= "&so[]=".$sov;
  foreach($req['sr'] as $srk => $srv)	$href .= "&sr[]=".$srv;


	/*-------------------------------------------------------------------------------------------------
	▶ 페이지 호출 */
	$req['at'] = Request('at');
	$include_page = null;
	switch($_GET['at']){
		case "view": 
			$include_page = "member_view.php"; break;
		case "write": 
		case "modify": 
		case "reply": 
			$include_page = "member_form.php"; break;
		case "dataprocess": 
			$include_page = "member_action.php"; break;
		case "excel": 
			$include_page = "member_excel.php"; break;
		case "download": 
			download();		break;
		default:
			$include_page = "member_list.php"; break;
	}

	if($include_page && file_exists($include_page)) include $include_page;


?>