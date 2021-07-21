<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	// fix.
	$Board['table_board'] = "G_Item";

	$Where = null;
//	$Where[] = " BoardID = '".$Board['board_id']."' ";

	if($req['sn'] == "s1") $Where[] = " ( g_UserID like '%".$req['st']."%') ";
	if($req['sn'] == "s2") $Where[] = " ( OrderNum like '%".$req['st']."%') ";
	if($req['sn'] == "") $Where[] = " ( g_UserID like '%".$req['st']."%' or OrderNum like '%".$req['st']."%') ";

	if($req['sdate'] && $req['edate']){
			$Where[] = " ( OrderDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
	}

	if($req['PCategory1']){	$PCategory[] = " PCategory1 = '".$req['PCategory1']."' ";}
	if($req['PCategory2']){	$PCategory[] = " PCategory1 = '".$req['PCategory2']."' ";}
	if($req['PCategory3']){	$PCategory[] = " PCategory1 = '".$req['PCategory3']."' ";}
	if($req['PCategory4']){	$PCategory[] = " PCategory1 = '".$req['PCategory4']."' ";}
	if($req['PCategory5']){	$PCategory[] = " PCategory1 = '".$req['PCategory5']."' ";}
	if($req['PCategory6']){	$PCategory[] = " PCategory1 = '".$req['PCategory6']."' ";}
	if(is_array($PCategory)) $Where[] =  " (".implode(" or ", $PCategory).")" ;

	$Where[] = " OrderType not in('cancel') ";
	$Where[] = " OrderStatus = 'end' ";
//	$Where[] = " g_UserID = '".$req['g_UserID']."' ";
	$Where[] = " ( SaleCnt<0 or PGubun='period' )";

	$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";
	$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;

	$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where 1 $WhereQuery  ");
	$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];

	$SQL = "SELECT * FROM ".$Board['table_board']." where 1 $WhereQuery order by OrderDate desc, g_UserID desc limit ".$Q['Limit'] ."";
//	echo $SQL;
	$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where 1 $WhereQuery order by OrderDate desc, g_UserID desc limit ".$Q['Limit'] ."");

	
	/*******************************************************************************
	 * 기간설정
	 ******************************************************************************/	
	if($req[sdate] && $req[edate] && ($req['edate'] == date("Y-m-d"))){
		$sdate = explode("-",$req[sdate]);	
		$edate = explode("-",$req[edate]);	
		if($req[sdate] == $req[edate]) $dateCheck = "today";
		if(mktime(0,0,0,$sdate[1],$sdate[2]+7,$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "7day";
		if(mktime(0,0,0,$sdate[1],$sdate[2]+15,$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "15day";
		if(mktime(0,0,0,$sdate[1]+1,$sdate[2],$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "1month";
		if(mktime(0,0,0,$sdate[1]+3,$sdate[2],$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "3month";
		if(mktime(0,0,0,$sdate[1]+6,$sdate[2],$sdate[0]) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "6month";
		if(mktime(0,0,0,$sdate[1],$sdate[2],$sdate[0]+1) == mktime(0,0,0,$edate[1],$edate[2],$edate[0])) $dateCheck = "1year";
	}

	if(!$req[sdate] && !$req[edate]) $dateCheck = "all";

?>
<script type="text/javascript">
// When document is ready, initialize pagination
$(document).ready(function(){      
		initPagination();
});

$(document).ready(function() {
	$("#startdate").datepicker( {
		showOn: "button"
	});
	$("#enddate").datepicker( {
		showOn: "button"
	});
});
</script>

</head>
<?	require_once "../include/_body_top.inc.php"; ?>


			<form name="sfrm" method="get">
			<input type="hidden" id="total_entries" value="<?=$TOTAL?>">
			<input type="hidden" name="eq" value="<?=encrypt_md5_2($Query,'regexcel@)!@')?>">
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
								<dt>* 결제일</dt>
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
								<dt>* 카테고리</dt>
								<dd>
								 <input type="checkbox" name="PCategory1" value="10"  <?=Check("10",$req[PCategory1])?>> 꼬리잡기 </label>
								 <input type="checkbox" name="PCategory2" value="11"  <?=Check("11",$req[PCategory2])?>> 팀 꼬리잡기 </label>
								 <input type="checkbox" name="PCategory3" value="12"  <?=Check("12",$req[PCategory3])?>> 뒷꼬리 훔쳐보기 </label>
								 <input type="checkbox" name="PCategory4" value="13"  <?=Check("13",$req[PCategory4])?>> 키핑 확인권 </label>
								 <input type="checkbox" name="PCategory5" value="14"  <?=Check("14",$req[PCategory5])?>> 꼬리 자유이용권 </label>
								 <input type="checkbox" name="PCategory6" value="15"  <?=Check("15",$req[PCategory6])?>> G코인 </label>
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
								<option value='s1'  <?=Select("s1",$req['sn'])?>>ID</option>
								<option value='s2'  <?=Select("s2",$req['sn'])?>>주문번호</option>
								</select> 
								<input type="text" name="st" class="input" value="<?=$req['st']?>">					
								</dd>
							</dl>
							</td>
						</tr>
						<tr>
							<td style=""><img src="../images/btn_SelectDel.gif" class="pointer" onclick="checkDelete_2();"></td>
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
						<th class="tableth f11" style="width:30px;"><input type="checkbox" name="checkall" onclick="javascript:checkAll();"></th>
						<th class="tableth f11" style="width:40px;">번호</th>
						<th class="tableth f11" style="width:40px;">구분</th>
						<th class="tableth f11" style="width:80px;">주문번호</th>
						<th class="tableth f11" style="width:;">회원ID</th>
						<th class="tableth f11" style="width:;">상품명</th>
						<th class="tableth f11" style="width:180px;">개수/기간</th>
						<th class="tableth f11" style="width:120px;">연락처</th>
						<th class="tableth f11" style="width:150px;">사용일시</th>
					</tr>
					<?
						if($LIST){
							foreach($LIST as $key => $value){

								$Query = "Select ProdTitle, Option1Name, PCategory1 from G_Product Where Pcode='$value[Pcode]' limit 1 ";
								$Prod = $db -> SelectOne($Query);
								$Option1Name="";
								if($Prod){
									$Query2 = "Select Name from G_Product_Category Where Depth1='$Prod[PCategory1]' limit 1 ";
									$Cate = $db -> SelectOne($Query2);
									if(trim($Prod[Option1Name])!=""){
										$Option1Name="<br /><font color=tomato>-".$Prod[Option1Name]."</font>";
									}

									$Query3 = "Select g_UserPhone from G_Member Where g_UserID='$value[g_UserID]' limit 1 ";
									$Mem = $db -> SelectOne($Query3);

								} else{	// order(구매) 이외의 경우 : friend, betting
									$Query2 = "Select Name from G_Product_Category Where Depth1='$value[PCategory1]' limit 1 ";
									$Cate = $db -> SelectOne($Query2);
									if(trim($Prod[Option1Name])!=""){
										$Option1Name="<br /><font color=tomato>-".$Prod[Option1Name]."</font>";
									}

									$Query3 = "Select g_UserPhone from G_Member Where g_UserID='$value[g_UserID]' limit 1 ";
									$Mem = $db -> SelectOne($Query3);

								}

								// 기간제 아이템의 경우 : PGugun == period
								$msg_period = "개";
								if($value['PGubun']=="period"){
									$order_y = substr($value['OrderDate'],0,4);
									$order_m = substr($value['OrderDate'],5,2);
									$order_d = substr($value['OrderDate'],8,2);

									$start_d = $order_m.".".$order_d;
									$end_d = date('m.d',mktime(0,0,0,$order_m,$order_d+$value['SaleCnt'],$order_y));

									$msg_period = "일($start_d ~ $end_d)";
								} else{
									$value['SaleCnt'] *= -1;
								}

								// 구매세부 정보
								$Betting_msg = "";
								if($value['OrderType']=="betting"){
									$Betting_msg = "(공개구애신청)";
								} else if($value['OrderType']=="friend"){
									$Betting_msg = "(선물하기)";
								}

                switch($value['OrderType']){
                  case "order": $value['OrderTypeText'] = "주문"; break;
                  case "use": $value['OrderTypeText'] = "사용"; break;
                  case "betting": $value['OrderTypeText'] = "배팅"; break;
                  case "exchange": $value['OrderTypeText'] = "교환"; break;
                  case "couplebreak": $value['OrderTypeText'] = "선물"; break;
                  default: $value['OrderTypeText'] = $value['OrderType'];
                }
					?>
					<tr>
						<td class="tabletd center f11"><input type="checkbox" name="gOrderNum[]" value="<?=$value['OrderNum']?>" <? if($value['PGubun']=="period"){ echo "disabled"; } ?>></td>
						<td class="tabletd center number" ><?=$NUMBER--?></td>
						<td class="tabletd center number" ><?=$value['OrderTypeText']?></td>
						<td class="tabletd left " ><?=$value[OrderNum]?></td>
						<td class="tabletd center"><?=$value[g_UserID]?></td>
						<td style="padding-left:10px;" class="tabletd left" ><?=$Cate[Name]?><?=$Betting_msg?></td>
						<td class="tabletd center"><?=number_format($value['SaleCnt'])?><?=$msg_period?></td>
						<td class="tabletd center"><?=substr($Mem[g_UserPhone],2)?></td>
						<td class="tabletd center"><?=$value[OrderDate]?></td>
					</tr>
					<?
							}
						}else{
					?>
					<tr>
						<td colspan="8" class="tabletd center" style="height:200px">데이터가 없습니다.</td>
					</tr>
					<?						
						}	
						$db -> Disconnect();
					?>

			
				</table>
<!--				<div class="rightbtn"><a href="<?=$href?>&at=write"><img src="../images/btn_write.gif"></a></div>-->
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