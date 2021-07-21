<?
if(!defined("_g_board_include_")) exit; 
require_once "../include/_header.inc.php";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

$Where = null;
$Where[] = " m_status = 'secede' ";
if($req['st']){
    if($req['sn'] == "s1") $Where[] = " ( m_email like '%".$req['st']."%') ";
}

if($req['sa']){
    if($req['sa'] == "s1") $Where[] = " ( m_auth = 'Y') ";
    if($req['sa'] == "s2") $Where[] = " ( m_auth = 'N' ) ";
}

if($req['sdate'] && $req['edate']){
    $Where[] = " ( m_exitDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
}

$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";
$LimitQuery = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
$OrderByQuery = "m_exitDate desc";


$Field  = " m_num, m_exitDate, m_id, m_exitReason,  m_status, m_auth, m_regDate ";
/*============================================================================================================================================
* Query Execute
--------------------------------------------------------------------------------------------------------------------------------------------*/
$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where m_regDate >0 $WhereQuery ");

$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];

$Query = "SELECT $Field  FROM ".$Board['table_board']." where m_regDate >0 $WhereQuery ORDER BY $OrderByQuery";
$LIST = $db -> SelectList($Query." LIMIT $LimitQuery ");

/*============================================================================================================================================
	* 데이터 생성
--------------------------------------------------------------------------------------------------------------------------------------------*/
	
/*******************************************************************************
 * 기간설정
 ******************************************************************************/	
if($req['sdate'] && $req['edate'] && ($req['edate'] == date("Y-m-d"))){
  $sdate = explode("-",$req['sdate']);	
  $edate = explode("-",$req['edate']);	
  if($req[sdate] == $req[edate]) $dateCheck = "today";
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
<script type="text/javascript">

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
					<tr>
						<td class="none">
						<dl>
							<dt>* 탈퇴일</dt>
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
							<option value=''>-- 전체 --</option>
							<option value='s1'  <?=Select("s1",$req['sn'])?>>E-mail</option>
							</select> 
							<input type="text" name="st" class="input" value="<?=$req['st']?>">					
							</dd>
						</dl>
						</td>
					</tr>
					<tr>
						<td>
						<dl>
							<dt>* 인&nbsp;&nbsp;&nbsp;증</dt>
							<dd>
							<select name="sa">
							<option value=''>-- 전체 --</option>
							<option value='s1' <?=Select("s1",$req['sa'])?>>인증</option>
							<option value='s2' <?=Select("s2",$req['sa'])?>>미인증</option>
							</select> 
							</dd>
						</dl>
						</td>
					</tr>
				</table>
		</div>	
		<div style='text-align:center'><input type="image" src="../images/btn_confirm_m.gif">	</div>
		</form>
    <!--// search -->
	
	  <!-- list -->
		<div class="leftbtn number">Total : <?=$TOTAL?>, <b style="color:#ff3300"><?=$req['pagenumber']?></b> of <?=ceil($TOTAL/$Board['page_limit'])?> pages</div>

		<form name="lform" method="post" action="<?=$Board['Link']?>?at=dataprocess">
		<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
		<input type="hidden" name="sn" value="<?=$req['sn']?>">
		<input type="hidden" name="CodeCategory" value="<?=$req['sn']?>">
		<input type="hidden" name="am" value="">
		<input type="hidden" name="idx" value="">
		<table cellspacing="0" cellpadding="0" class="listtable">
			<tr>
				<th class="tableth f11" style="width:50px;">번호</th>
				<th class="tableth f11" style="width:140px">아이디</th>
				<th class="tableth f11" style="width:50px">인증</th>
				<th class="tableth f11" style="width:120px;">가입일</th>
				<th class="tableth f11" style="width:120px;">탈퇴일</th>
				<th class="tableth f11" style="">탈퇴사유</th>
				<th class="tableth f11" style="">한마디</th>
			</tr>
			<?
				if($LIST){
					foreach($LIST as $key => $value){
            switch($value[m_status]){
              case "secession": $value[m_status] = "탈퇴"; break;
              case "normal": $value[m_status] = "정상"; break;
              case "break": $value[m_status] = "휴면"; break;
              case "bad": $value[m_status] = "불량"; break;
            }
            switch($value[m_auth]){
              case "N": $value[m_auth] = "미인증"; break;
              case "Y": $value[m_auth] = "인증"; break;
            }
            switch($value[g_UserSex]){
              case "M": $value[g_UserSex] = "남성"; break;
              case "F": $value[g_UserSex] = "여성"; break;
            }
            $g_exitReason = null;
            if($value[g_exitReason]){
              unset($exitReason);
              unset($k);
              unset($v);
              $exitReason = explode(",",$value[g_exitReason]);
              foreach($exitReason as $k => $v){
                $g_exitReason[] = $_Reason[$v];
              }
              $g_exitReason = implode(", ",$g_exitReason);

            }
			?>
			<tr>
				<td class="tabletd center number" ><a href="<?=$href?>&at=view&mid=<?=$value['m_num']?>"><?=$NUMBER--?></a></td>
				<td class="tabletd left " ><a href="<?=$href?>&at=view&mid=<?=$value['m_num']?>"><?=$value[m_id]?></a></td>

				<td class="tabletd center "><?=$value[m_auth]?></td>
				<td class="tabletd center number" ><?=$value[m_regDate]?></td>
				<td class="tabletd center number" ><?=$value[m_exitDate]?></td>
				<td class="tabletd left number last" ><?=$g_exitReason?></td>
				<td class="tabletd left number" ><?=nl2br($value[g_exitMsg])?></td>
			</tr>
			<?
					}
				}else{
			?>
			<tr>
				<td colspan="7" class="tabletd center" style="height:200px">데이터가 없습니다.</td>
			</tr>
			<?
				}	
				$db -> Disconnect();
			?>

	
		</table>
		<div style="clear:both"></div>
		<div class="page" style="text-align:center; cleaer:both"> 
  		<div id="Pagination"></div>
				<?
				$cfg['btn_first'] = "<img src='"._ADMIN_."/images/page/page_first.gif' align='middle' alt='처음으로'/>";
				$cfg['btn_prev']  = "<img src='"._ADMIN_."/images/page/page_prev.gif' align='middle'  alt='이전 10개'/>";
				$cfg['btn_next']  = "<img src='"._ADMIN_."/images/page/page_next.gif' align='middle'  alt='다음 10개'/>";
				$cfg['btn_last']  = "<img src='"._ADMIN_."/images/page/page_last.gif' align='middle'  alt='마지막으로'/>";
	//			include _CORE_PATH_."/system/inc.page.php";
				?>
		</div>
		</form>
	  <!--// list -->



<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>