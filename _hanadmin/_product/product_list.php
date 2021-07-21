<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	$Where = null;
	if($req['st']){
			if($req['sn'] == "s1") $Where[] = " ( ProdInfo01 like '%".$req['st']."%') ";
			if($req['sn'] == "s2") $Where[] = " ( ProdInfo02 like '%".$req['st']."%') ";
			if($req['sn'] == "s3") $Where[] = " ( ProdInfo03 like '%".$req['st']."%') ";
			if($req['sn'] == "")   $Where[] = " ( ProdInfo01 like '%".$req['st']."%' or ProdInfo02 like '%".$req['st']."%' or ProdInfo03 like '%".$req['st']."%') ";
	}

	if($req['sdate'] && $req['edate']){
			$Where[] = " ( RegDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
	}

	$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where idx > 0 $WhereQuery  ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];

  $Query = "SELECT * FROM ".$Board['table_board']." where idx > 0   $WhereQuery order by idx desc";
	$LIST = $db -> SelectList($Query." limit ".$Q['Limit'] ."");

	/*******************************************************************************
	 * 기간설정
	 ******************************************************************************/	
	if($req['sdate'] && $req['edate'] && ($req['edate'] == date("Y-m-d"))){
		$sdate = explode("-",$req['sdate']);	
		$edate = explode("-",$req['edate']);	
		if($req['sdate'] == $req['edate']) $dateCheck = "today";
		if(mktime(0,0,0,$sdate[1],$sdate[2]+7,$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "7day";
		if(mktime(0,0,0,$sdate[1],$sdate[2]+15,$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "15day";
		if(mktime(0,0,0,$sdate[1]+1,$sdate[2],$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "1month";
		if(mktime(0,0,0,$sdate[1]+3,$sdate[2],$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "3month";
		if(mktime(0,0,0,$sdate[1]+6,$sdate[2],$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "6month";
		if(mktime(0,0,0,$sdate[1],$sdate[2],$sdate[0]+1) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "1year";
	}
	if(!$req['sdate'] && !$req['edate']) $dateCheck = "all";
?>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.pagination.js"></script>
<script type="text/javascript" src="../include/js/list.js"></script>
<script type="text/javascript">
//<![CDATA[
 // When document is ready, initialize pagination
$(document).ready(function(){      
	initPagination(<?=($req['pagenumber']==1)? "0":$req['pagenumber']-1;?>, <?=$Board['page_limit']?> );
});
//]]>
</script>

</head>
<?	require_once "../include/_body_top.inc.php"; ?>


			<form name="sfrm" method="get">
			<input type="hidden" id="total_entries" value="<?=$TOTAL?>">
			<input type="hidden" name="eq" value="<?=encrypt_md5($Query,'regexcel@)!@')?>">
			</form>

				<!-- search -->
				<form name="sform" method="get">
				<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
				<div class="SearchArea">
					<table width="100%">
						<col width="100px"></col>
						<col width="*"></col>
						<tr>
							<td class="none">
							<dl>
								<dt>* 작성일</dt>
								<dd>
								<input type="text" name="sdate" value="<?=$req['sdate']?>" class="input-date" id="startdate" readonly> ~ <input type="text" name="edate" value="<?=$req['edate']?>" class="input-date" id="enddate" readonly> 
								<img src="../images/search/period_1_day<?=($dateCheck == "today")?"_ov":"";?>.gif" class="pointer" onclick="setDate('<?=date("Y-m-d")?>','','');">
								<img src="../images/search/period_1_week<?=($dateCheck == "7day")?"_ov":"";?>.gif" class="pointer" onclick="setDate('<?=date("Y-m-d")?>','7','D');">
								<img src="../images/search/period_15_day<?=($dateCheck == "15day")?"_ov":"";?>.gif" class="pointer" onclick="setDate('<?=date("Y-m-d")?>','15','D');">
								<img src="../images/search/period_1_month<?=($dateCheck == "1month")?"_ov":"";?>.gif" class="pointer" onclick="setDate('<?=date("Y-m-d")?>','1','M');">
								<img src="../images/search/period_3_month<?=($dateCheck == "3month")?"_ov":"";?>.gif" class="pointer" onclick="setDate('<?=date("Y-m-d")?>','3','M');">
								<img src="../images/search/period_6_month<?=($dateCheck == "6month")?"_ov":"";?>.gif" class="pointer" onclick="setDate('<?=date("Y-m-d")?>','6','M');">
								<img src="../images/search/period_1_year<?=($dateCheck == "1year")?"_ov":"";?>.gif" class="pointer" onclick="setDate('<?=date("Y-m-d")?>','1','Y');">
								<img src="../images/search/period_all<?=($dateCheck == "all")?"_ov":"";?>.gif"  class="pointer" onclick="setDate('','','');">
								</dd>
							</dl>
							</td>
						</tr>
						<tr>
							<td>
							<dl>
								<dt>* 검색어</dt>
								<dd>
								<select name="sn">
								<option value=''>전체</option>
								<option value='s1'  <?=Select("s1",$req['sn'])?>>제목</option>
								<option value='s2'  <?=Select("s2",$req['sn'])?>>내용</option>
								</select> 
								<input type="text" name="st" class="input" value="<?=$req['st']?>">					
								</dd>
							</dl>
							</td>
						</tr>
						<tr>
							<td style=""><img src="../images/btn_SelectDel.gif" class="pointer" onclick="checkDelete();"></td>
						</tr>
					</table>
				</div>	
				<div style='text-align:center'><input type="image" src="../images/btn_confirm_m.gif">	</div>
				</form>
				<!--// search -->
				
				<!-- list -->
				<form name="boardform" method="post">
				<input type="hidden" name="idx" value="">
				<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
				<input type="hidden" name="am" value="">
				<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
				</form>
				<div class="leftbtn number">Total : <?=$TOTAL?>, <b style="color:#ff3300"><?=$req['pagenumber']?></b> of <?=ceil($TOTAL/$Board['page_limit'])?> pages</div>

				<form name="lform" method="post" action="<?=$Board['Link']?>?at=dataprocess">
				<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
				<input type="hidden" name="sn" value="<?=$req['sn']?>">
				<input type="hidden" name="CodeCategory" value="<?=$req['sn']?>">
				<input type="hidden" name="am" value="">
				<input type="hidden" name="idx" value="">

		<table cellspacing="0" cellpadding="0" class="listtable">
			<tr>
				<th  class="tableth f11" style="width:60px;" >번호<!--</br>앵콜--></th>
				<th  class="tableth f11" style="width:80px">이미지</th>
				<th  class="tableth f11" style="width:">상품명</th>
				<th  class="tableth f11" style="width:80px">품명</th>
				<th  class="tableth f11" style="width:120px;" >등록일</th>
				<th  class="tableth f11" style="width:120px;">원산지</th>
				<th  class="tableth f11" style="width:120px;">조회수</th>
				<th  class="tableth f11" style="width:50px;">관리</th>
				<th  class="tableth f11" style="width:50px;">삭제</th>
			</tr>
			<?
				if($LIST){
					foreach($LIST as $key => $Value){

						switch($Value['PGubun']){
							Case "T":$Value['PGubun'] = "Today"; break;
							Case "E":$Value['PGubun'] = "Every"; break;
							Case "G":$Value['PGubun'] = "Gift";  break;
						}
						
						$Cnt = 0;
						if($Value['PGubun'] == "Gift") {
								$This['StockCnt'] = $Value['MaxCnt'] - $Value['SaleCnt'];
						}else{
							$Value['Option1Cnt'] = explode("^^",$Value['Option1Cnt']);
							$Value['Option2Parent'] = explode("^^",$Value['Option2Parent']);
							$Value['Option2Cnt'] = explode("^^",$Value['Option2Cnt']);
							$Option1Cnt = count($Value['Option1Cnt']);
							$Option2Cnt = count($Value['Option2Cnt']);
							if($Option2Cnt > 0){
								for($i=0; $i < $Option2Cnt; $i++){
									$Cnt = $Cnt + $Value['Option2Cnt'][$i];
								}
							}else{
								if($Option1Cnt > 0){
									for($i=0; $i < $Option1Cnt; $i++){
										$Cnt = $Cnt +  $Value['Option1Cnt'][$i];
									}
								}
							}

							if($Value['Option1Cnt']){
								$This['StockCnt'] = $Cnt;
							}else{
								$This['StockCnt'] = $Value['MaxCnt'] - $Value['SaleCnt'];
							}
						}

						if($Value['SaleStatus'] == "end"){
							$Value['SaleStatus'] = "<img src='../images/icon_saleend.gif'>";
						}elseif($Value['SaleStatus'] == "ready"){
							$Value['SaleStatus'] = "<img src='../images/icon_saleready.gif'>";
						}else{
							$Value['SaleStatus'] = "";
						}

						//if($This[StockCnt] < 1) $Value[SaleStatus] = "<img src='../images/icon_saleend.gif'>";

						if($Value['PType'] == "C") {
							$Value['PType'] = "<img src='../images/icon_CouponProduct.gif'>";
						}elseif($Value['PType'] == "D"){
							$Value['PType'] = "<img src='../images/icon_DeliveryProduct.gif'>";						
						}else{
							$Value['PType'] = "";
						}
			?>
			<tr>
				<td class="tabletd center number" ><?=$NUMBER--?></td>
				<td class="tabletd center f11"><img src="<?=$Value['ProdImage01']?>" width="80"></td>
				<td class="tabletd left  "><?=$Value['ProdTitle']?><br><?=$Value['PType']?> <?=$Value['SaleStatus']?> <br/>
				<font color="#ff3300">
				<?
					$addr1 = $addr2 = $division1 = $division2 = null;
					$addr1 =  CategoryName('product',$Value['PCategory1']);
					if($Value['PCategory2'])	$addr2 =  CategoryName('product',$Value['PCategory1'],$Value['PCategory2']);


					$addr = false;
					if($addr2){
						echo $addr1." - ".$addr2;
						$addr = true;
					}else{
						if($addr1) echo $addr1;
						else echo "지역설정안됨";
						$addr = true;
					}
					echo "</font>";

				?>
				</font>				
				</td>
				<td class="tabletd center number" ><?=$Value['ProdInfo01']?></td>
				<td class="tabletd center number" ><?=$Value['RegDate']?></td>
				<td class="tabletd center number" ><?=$Value['ProdInfo02']?></td>
				<td class="tabletd center number" ><?=$Value['Hits']?></td>
				<td class="tabletd center " ><a href="<?=$href?>&at=copy&idx=<?=$Value['idx']?>"><img src='../images/btn_copy.gif'></a> <br/> <a href="<?=$href?>&at=modify&idx=<?=$Value['idx']?>"><img src='../images/btn_modify.gif'></a></td>
				<td class="tabletd center last" ><img src='../images/btn_del.gif' style="cursor:pointer" onclick="goDel('<?=$Value['idx']?>');"></td>
			</tr>
			<?
					}
				}else{
      ?>
					<tr>
						<td colspan="9" class="tabletd center" style="height:200px">데이터가 없습니다.</td>
					</tr>
      <?
        }
			?>

		</table>
				<div class="rightbtn"><a href="<?=$href?>&at=write"><img src="../images/btn_write.gif"></a></div>
				<br>
				<div class="page" style="text-align:center; "> 
				<div id="Pagination"></div>
						<?
						$cfg['btn_first'] = "<img src='"._ADMIN_."/images/page/page_first.gif' align='middle' alt='처음으로'/>";
						$cfg['btn_prev']  = "<img src='"._ADMIN_."/images/page/page_prev.gif' align='middle'  alt='이전 10개'/>";
						$cfg['btn_next']  = "<img src='"._ADMIN_."/images/page/page_next.gif' align='middle'  alt='다음 10개'/>";
						$cfg['btn_last']  = "<img src='"._ADMIN_."/images/page/page_last.gif' align='middle'  alt='마지막으로'/>";
						//include _CORE_PATH_."/system/inc.page.php";
						?>
				</div>
				</form>

				<!--// list -->


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>