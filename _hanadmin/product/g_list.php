<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."'  ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where BoardID='".$Board['board_id']."' order by StartDate desc, EndDate desc limit ".$Q['Limit'] ."");
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
<div id="body-content-ext">
<h3 class="page-title"><span><?=$PageTitle?></span></h3>
<form name="sform" method="get">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
</form>
<table width="100%" cellspacing="0" cellpadding="0" class="listtable">
	<tr>
		<td class="tableth" width="40" style="border-bottom:1px solid #cccccc;">No.</td>
		<td class="tableth" width="80" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">이미지</td>
		<td class="tableth" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">고객사/상품명</td>
		<td class="tableth" width="60" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">원가</td>
		<td class="tableth" width="60" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">할인가</td>
		<td class="tableth" width="60" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">할인률</td>
		<td class="tableth" width="60" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">목표수량</td>
		<td class="tableth" width="60" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">최대수량</td>
		<td class="tableth" width="60" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">판매수량</td>
		<td class="tableth" width="50" style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc">노출</td>
	</tr>
	<?
		if($LIST){
			foreach($LIST as $key => $value){
	?>
		<tr style="background-color:<?=$cellcolor?>" id="<?=$value['idx']?>"  style="height:40px"> 
			<td class="center number" style="height:30px"><?=$NUMBER--?></td> 
			<td class="center number" width="80" rowspan="2" style="border-bottom:1px solid #dddddd; "><b style="font-family:arial; font-size:20px; color:red"><?=($value['ImageList'])? "<img src='"._UPLOAD_.$value['ImageList']."' width=80>":""?></b></td> 
			<td class="left number" style="padding-left:5px; border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><a href="<?=$href?>&at=modify&idx=<?=$value['idx']?>"><?=$value[ProdTitle]?></a> <font color="#ff6600"><?=$value['StartDate']?> ~ <?=$value['EndDate']?></font></td> 
			<td class="center number" style="border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><?=number_format($value['OrgPrice'])?></td> 
			<td class="center number" style="border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><?=number_format($value['SalePrice'])?></td> 
			<td class="center number" style="border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><?=$value['SaleRatio']?>%</td> 
			<td class="center number" style="border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><?=$error_cnt?><?=number_format($value['MaxCnt'])?></span></td> 
			<td class="center number" style="border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><?=$error_cnt?><?=number_format($value['DealCnt'])?></span></td> 
			<td class="center number" style="border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><?=number_format($value['SaleCnt'])?></td> 
			<td  class="center number" style="border-bottom:1px dashed #dddddd; border-left:1px dashed #dddddd"><a href="javascript:displaycheck(<?=$value['idx']?>);"><font color="#ff6600" style="font-weight:bold"><?=$value['Display']?></font></a></td> 
		</tr> 
		<tr style="background-color:<?=$cellcolor?>" id="<?=$Value['idx']?>"  style=""> 
			<td class="center number" style="height:40px; border-bottom:1px solid #DDDDDD"><!--<span  style="width:100%; height:100%; padding:3px 10px; border:1px solid #ff9900; color:#ff6600;font-weight:bold"></span>--></td> 
			<td style="padding-left:5px; border-bottom:1px solid #DDDDDD; border-left:1px dashed #dddddd" colspan="7">
			<a href="<?=$Board['Link']?>?at=modify&idx=<?=$Value['idx']?>&<?=$parameter?>"><b><?=$Value['Prod_Name']?></b></a><br> 
			<a href="javascript:void(0)" onclick="javascript:window.open('<?=$Value['Prod_Url']?>')"><?=$Value['Prod_Url']?></a>&nbsp;&nbsp;
			<font color="#ff6600">(<?=$value['ProdDivision']?>)</font>
			</td> 
			<td  class="center number" style="border-bottom:1px solid #dddddd; border-left:1px dashed #dddddd"><font color="#ff6600" style="font-weight:bold"><!--<img src="../images/trash.png" onclick="delcheck(<?=$Value['idx']?>);" style="cursor:pointer">--></font></td> 
		</tr> 
	<?
			}
		}else{	
	?>
	<tr>
		<td colspan="10" class="tabletd center"><?=$msg['no_data']?></td>
	</tr>
	<?
		}	
		$db -> Disconnect();
	?>
	<tfoot>
		<tr>
		<td colspan="10" class="tfoottd_R"><a href="<?=$href?>&at=write"><img src="<?=_ADMIN_?>/images/board/btn_write.gif" align="middle"></a></td>
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