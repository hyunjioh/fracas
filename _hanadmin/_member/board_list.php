<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$Board['page_limit'] = 20;
	$Board['page_block'] = 10;

	if($req['st'] != "") {
		if($req['sn'] == "") $WhereQuery .= " and (h_name like '%".$req['st']."%' or h_id like '%".$req['st']."%' or h_nick like '%".$req['st']."%' )";
		if($req['sn'] == "s1") $WhereQuery .= " and (h_name like '%".$req['st']."%' )";
		if($req['sn'] == "s2") $WhereQuery .= " and (h_id like '%".$req['st']."%' )";
		if($req['sn'] == "s3") $WhereQuery .= " and (h_nick like '%".$req['st']."%' )";
	}

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where h_level <  100 $WhereQuery ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where h_level <  100 $WhereQuery order by h_wdate desc limit ".$Q['Limit'] ."");
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
<h3 class="page-title"><?=$PageTitle?></h3>
<!-- 검색 & 버튼 -->
<form name="sform" method="">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<table class="search" >
	<tr height="40" bgcolor="#F2F2F2">
		<td style="padding-left:10px">
		<select name="sn">
		<option value="" <?=Selected("",$req['sn'])?>>전체</option>
		<option value="s1" <?=Selected("s1",$req['sn'])?>>이름</option>
		<option value="s2" <?=Selected("s2",$req['sn'])?>>아이디</option>
		<option value="s3" <?=Selected("s3",$req['sn'])?>>닉네임</option>
		</select>
		
		<input type="text" name="st" class="input-blur"  value="<?=$req['st']?>">
		<input type="image" src="<?=_ADMIN_?>/images/board/btn_search.gif" onclick="goSearch();"  alt="search" align="middle">
		</td>
	</tr>
</table>
</form>

<div style="height:10px"></div>
<div class="clear" style="height:3px"></div>


<table width="100%" cellspacing="0" cellpadding="0" class="listtable">
	<col width="60"></col>
	<col width="120"></col>
	<col width=""></col>
	<col width="200"></col>
	<col width="120"></col>
	<col width="100"></col>
	<col width="100"></col>
	<tr>
		<th class="tableth">번호</th>
		<th class="tableth">아이디</th>
		<th class="tableth">닉네임</th>
		<th class="tableth">이메일</th>
		<th class="tableth">연락처</th>
		<th class="tableth">포인트</th>
		<th class="tableth">가입일</th>
	</tr>
	<?
		if($LIST){
			foreach($LIST as $key => $value){
	?>
	<tr>
		<td class="tabletd center"><a href="<?=$Board['Link']?>?at=view&idx=<?=$value['h_idx']?>&<?=$parameter?>"><?=$NUMBER--?></a></td>
		<td class="tabletd center"><?=$value[h_id]?></td>
		<td class="tabletd center"><a href="<?=$Board['Link']?>?at=view&idx=<?=$value['h_idx']?>&<?=$parameter?>"><?=$value[h_nick]?></a></td>
		<td class="tabletd center"><?=$value[h_email]?></td>
		<td class="tabletd center"><?=$value[h_hp]?></td>
		<td class="tabletd center"><?=number_format($value[h_point])?></td>
		<td class="tabletd center"><?=($value[h_wdate]) ? date("Y-m-d",$value[h_wdate]) : ""; ?></td>
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
		<td colspan="7" class="tfoottd_R"><a href="./?at=write&<?=$parameter?>"><img src="<?=_ADMIN_?>/images/board/btn_write.gif" align="middle"></a></td>
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