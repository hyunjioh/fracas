<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."'  ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."' order by RegDate desc, idx desc limit ".$Q['Limit'] ."");
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
	<col width="150"></col>
	<col width="100"></col>
	<col width="*"></col>
	<col width="100"></col>
	<col width="60"></col>
	<tr>
		<th class="tableth">번호</th>
		<th class="tableth">아이디</th>
		<th class="tableth">포인트</th>
		<th class="tableth">내용</th>
		<th class="tableth">지급일</th>
		<th class="tableth">수정</th>
	</tr>
	<?
		if($LIST){
			foreach($LIST as $key => $value){
	?>
	<tr>
		<td class="tabletd center"><a href="<?=$Board['Link']?>?at=modify&idx=<?=$value['idx']?>&<?=$parameter?>"><?=$NUMBER--?></a></td>
		<td class="tabletd center"><?=$value[MemberID]?></td>
		<td class="tabletd center"><?=number_format($value[Point])?></td>
		<td class="tabletd center"><?=$value[Comment]?></td>
		<td class="tabletd center"><?=substr($value[PointDate],0,10)?></td>
		<td class="tabletd center"><a href="<?=$href?>&at=modify&idx=<?=$value['idx']?>"><img src="../images/icon/edit.gif"></a></td>
	</tr>
	<?
			}
		}else{	
	?>
	<tr>
		<td colspan="6" class="tabletd center"><?=$msg['no_data']?></td>
	</tr>
	<?
		}	
		$db -> Disconnect();
	?>
	<tfoot>
		<tr>
		<td colspan="6" class="tfoottd_R"><a href="<?=$href?>&at=write"><img src="<?=_ADMIN_?>/images/board/btn_write.gif" align="middle"></a></td>
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