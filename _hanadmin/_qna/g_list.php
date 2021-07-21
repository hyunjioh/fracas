<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$Where = null;
	if($req['st']){
		if($req['sn'] == "s1") $Where[] = " Subject like '%".$req['st']."%'";
		if($req['sn'] == "s2") $Where[] = " Content like '%".$req['st']."%'";
		if($req['sn'] == "")   $Where[] = " Subject like '%".$req['st']."%' or Content like '%".$req['st']."%'";
	}
	$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."'  and Notice <> 'Y' $WhereQuery ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."' $WhereQuery and Notice <> 'Y' order by RegDate desc, idx desc limit ".$Q['Limit'] ."");
	$Notice = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."' $WhereQuery and Notice = 'Y' order by RegDate desc, idx desc limit ".$Q['Limit'] ."");
	$NoData = (!$Notice && !$LIST)? true:false;
?>

<? include "../include/_header.inc.php"; ?>
<script type="text/javascript">
function goPage(i){
	var f = document.sform;
	f.pagenumber.value = i;
	f.submit();
}
</script>
</head>
<body>

<div id="wrapper">	
<? @include "../include/top_menu.php"; ?>
<? @include "../include/left_menu.php"; ?>
<div id="body-content">
<h3 class="page-title"><span><?=$PageTitle?></span></h3>
<form name="sform" method="get">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
</form>
<table width="100%" cellspacing="0" cellpadding="0" class="listtable">
	<col width="60"></col>
	<col width=""></col>
	<col width="80"></col>
	<col width="100"></col>
	<col width="60"></col>
	<tr>
		<th class="tableth">번호</th>
		<th class="tableth">제목</th>
		<th class="tableth">첨부</th>
		<th class="tableth">작성일</th>
		<th class="tableth">조회수</th>
	</tr>
	<?
		if($Notice){
			foreach($Notice as $Key => $Value){
	?>
	<tr>
		<td class="tabletd center"><a href="<?=$Board['Link']?>?at=view&idx=<?=$Value['idx']?>&<?=$parameter?>"><img src="../images/board/icon_notice.gif"></a></td>
		<td class="tabletd left"><a href="<?=$href?>&at=view&idx=<?=$Value['idx']?>"><?=$Value[Subject]?></a></td>
		<td class="tabletd center"><?=CheckAttach($Value['idx'])?></td>
		<td class="tabletd center"><?=substr($Value[RegDate],0,10)?></td>
		<td class="tabletd center"><?=$Value[Hit]?></td>
	</tr>
	<?
			}
		}
		unset($Key, $Value);
	?>
	<?
		if($LIST){
			foreach($LIST as $Key => $Value){
	?>
	<tr>
		<td class="tabletd center"><a href="<?=$Board['Link']?>?at=view&idx=<?=$Value['idx']?>&<?=$parameter?>"><?=$NUMBER--?></a></td>
		<td class="tabletd left"><a href="<?=$href?>&at=view&idx=<?=$Value['idx']?>"><?=$Value[Subject]?></a></td>
		<td class="tabletd center"><?=CheckAttach($Value['idx'])?></td>
		<td class="tabletd center"><?=substr($Value[RegDate],0,10)?></td>
		<td class="tabletd center"><?=$Value[Hit]?></td>
	</tr>
	<?
			}
		}
		if($NoData){
	?>
	<tr>
		<td colspan="5" class="tabletd center"><?=$msg['no_data']?></td>
	</tr>
	<?
		}	
		$db -> Disconnect();
	?>
	<tfoot>
		<tr>
		<td colspan="5" class="tfoottd_R"><a href="<?=$href?>&at=write"><img src="<?=_ADMIN_?>/images/board/btn_write.gif" align="middle"></a></td>
		</tr>
	</tfoot>
</table>

<div class="page" style="text-align:center"> 
		<?
		$cfg['btn_first'] = "<img src='"._ADMIN_."/images/board/btn_first.gif' align='middle' alt='".$msg['btn_first']."'/>";
		$cfg['btn_prev']  = "<img src='"._ADMIN_."/images/board/btn_prev.gif' align='middle'  alt='".$msg['btn_prev']."'/>";
		$cfg['btn_next']  = "<img src='"._ADMIN_."/images/board/btn_next.gif' align='middle'  alt='".$msg['btn_next']."'/>";
		$cfg['btn_last']  = "<img src='"._ADMIN_."/images/board/btn_last.gif' align='middle'  alt='".$msg['btn_last']."'/>";
		include _CORE_PATH_."/system/inc.page.php";
		?>
</div>

</div>
<div id="copyright"></div>












</div>
<? include "../include/_footer.inc.php"; ?>