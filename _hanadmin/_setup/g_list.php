<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']."   ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']."  order by  table_board, idx asc ");
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
<div class="black">  
<ul id="top-menu" class="mega-menu" style="display:none; left:-2px; ">
	<li><a href="#" style="margin-left:-200px">게시판설정</a></li>
</ul>
</div>
<div id="body-content">
<h3 class="page-title"><span>게시판 목록</span></h3>
<form name="sform" method="get">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
</form>
<table width="100%" cellspacing="0" cellpadding="0" class="listtable">
	<col width="60"></col>
	<col width=""></col>
	<col width="150"></col>
	<col width="100"></col>
	<col width="100"></col>
	<col width="100"></col>
	<tr>
		<th class="tableth">번호</th>
		<th class="tableth">게시판 이름</th>
		<th class="tableth">게시판 아이디</th>
		<th class="tableth">게시물 수</th>
		<th class="tableth">파일첨부</th>
		<th class="tableth">답변형</th>
		<th class="tableth">코멘트</th>
	</tr>
	<?
		if($LIST){
			foreach($LIST as $key => $value){
	?>
	<tr>
		<td class="tabletd center"><a href="<?=$Board['Link']?>?at=view&idx=<?=$value['idx']?>&<?=$parameter?>"><?=$NUMBER--?></a></td>
		<td class="tabletd center"><a href="<?=$href?>&at=view&idx=<?=$value['idx']?>"><?=$value[board_name]?></a></td>
		<td class="tabletd center"><a href="<?=$href?>&at=view&idx=<?=$value['idx']?>"><?=$value[board_id]?></a></td>
		<td class="tabletd center"><?=($db->Total("Select count(*) from ".$value['table_board']." where BoardID='".$value[board_id]."'" ))?></td>
		<td class="tabletd center"><?=$value[use_file]?></td>
		<td class="tabletd center"><?=$value[use_reply]?></td>
		<td class="tabletd center"><?=$value[use_comment]?></td>
	</tr>
	<?
			}
		}else{	
	?>
	<tr>
		<td colspan="7" class="tabletd center"><?=$msg['no_data']?></td>
	</tr>
	<?
		}	
		$db -> Disconnect();
	?>
	<tfoot>
		<tr>
		<td colspan="7" class="tfoottd_R"><a href="<?=$href?>&at=write"><img src="<?=_ADMIN_?>/images/board/btn_write.gif" align="middle"></a></td>
		</tr>
	</tfoot>
</table>



</div>
<div id="copyright"></div>












</div>
<? include "../include/_footer.inc.php"; ?>