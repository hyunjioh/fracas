<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."'  ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."' order by fid desc, thread  limit ".$Q['Limit'] ."");
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
		if($LIST){
			foreach($LIST as $key => $value){
				$Re = null;
				if(strlen($value['thread']) > 1){
					for($i=0; $i < strlen($value['thread']); $i++) {$Re = "&nbsp;".$Re;}
					$Re = ($Re)? $Re. "<img src='"._ADMIN_."/images/board/icon_re.gif' align='middle' />":"";
				}
				$RE 
	?>
	<tr>
		<td class="tabletd center"><a href="<?=$Board['Link']?>?at=view&idx=<?=$value['idx']?>&<?=$parameter?>"><?=$NUMBER--?></a></td>
		<td class="tabletd left"><?=$Re?><a href="<?=$href?>&at=view&idx=<?=$value['idx']?>"><?=$value[Subject]?></a></td>
		<td class="tabletd center"><?=CheckAttach($value['idx'])?></td>
		<td class="tabletd center"><?=substr($value[RegDate],0,10)?></td>
		<td class="tabletd center"><?=$value[Hit]?></td>
	</tr>
	<?
			}
		}else{	
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