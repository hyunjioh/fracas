<?
	include "../../_core/_lib.php";
	require_once _CORE_PATH_."/system/class.MySQL.php";
	require_once _CORE_PATH_."/system/function.board.php";
	require_once _CORE_PATH_."/lang/ko.php";
	require_once "../include/check_admin.php";

	$set['id'] = "Member";
	$PageTitle = "회원관리";

	$Board['board_id'] = "Member";
	$Board['table_board'] = "G_Member";
	$Board['page_limit'] = 20;
	$Board['page_block'] = 10;

	$req['st']        = Request('stext');
	$req['pagenumber'] = Request('pagenumber');
	$req['pagenumber'] = SetValue($req['pagenumber'],'digit', 1);
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	if($req['st'] != "") {
		if($req['sn'] == "") $WhereQuery .= " (h_email like '%".$req['st']."%' or h_id like '%".$req['st']."%' or h_nick like '%".$req['st']."%' )";
	}

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where $WhereQuery ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where $WhereQuery order by h_wdate desc limit ".$Q['Limit'] ."");
?>
<?
	if($LIST){
		foreach($LIST as $key => $value){
?>
	<p><code style="cursor:pointer" onclick="searchResult('<?=$value['h_id']?>','(닉네임 : <?=$value['h_nick']?>)');"><?=$value['h_nick']?> (<?=$value['h_id']?>) , <?=$value['h_email']?></code></p>
<?
		}	
	}else{
		echo "	<p><code>검색 결과가 존재하지 않습니다.</code></p>	";
	}
	$db -> Disconnect();
?>