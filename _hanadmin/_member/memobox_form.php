<?
if(!defined("_g_board_include_")) exit; 
require_once "../include/_header.inc.php";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

$Where = null;

if($req['st']){
    if($req['sn'] == "s1") $Where[] = " ( m_UserEmail like '%".$req['st']."%') ";
    if($req['sn'] == "s2") $Where[] = " ( m_name like '%".$req['st']."%' ) ";
    if($req['sn'] == "s3") $Where[] = " ( m_nick like '%".$req['st']."%' ) ";
    if(!$req['sn']) $Where[] = " ( m_UserEmail like '%".$req['st']."%' or m_name like '%".$req['st']."%' or m_nick like '%".$req['st']."%') ";
}
if($req['se']){
    if($req['se'] == "s1") $Where[] = " ( m_sex = 'M') ";
    if($req['se'] == "s2") $Where[] = " ( m_sex = 'F' ) ";
}
if($req['sa']){
    if($req['sa'] == "s1") $Where[] = " ( m_auth = 'Y') ";
    if($req['sa'] == "s2") $Where[] = " ( m_auth = 'N' ) ";
    if($req['sa'] == "s3") $Where[] = " ( m_auth = 'I' ) ";
}

$SubWhere = null;
if(@in_array("s1",$req['ss'])) $SubWhere[] = " m_status = 'normal' ";
if(@in_array("s3",$req['ss'])) $SubWhere[] = " m_status = 'break' ";
if(@in_array("s4",$req['ss'])) $SubWhere[] = " m_status = 'bad' ";

if(is_array($SubWhere)){
  $Where[] = "  (".implode(" or ", $SubWhere).")" ;
}else{
  $Where[] = " m_status = '' " ;  
}

$SubWhere = null;
if(@in_array("s1",$req['sm'])) $SubWhere[] = " m_realMember = 'Y' ";
if(@in_array("s2",$req['sm'])) $SubWhere[] = " m_realMember = 'N' ";

if(is_array($SubWhere)){
  $Where[] = "  (".implode(" or ", $SubWhere).")" ;
}


$SubWhere = null;
if(@in_array("s1",$req['so'])) $SubWhere[] = " (replace(cast(SYSDATE() as date),'-','') - replace(m_birthday ,'-',''))  < 200000 ";
if(@in_array("s2",$req['so'])) $SubWhere[] = " (replace(cast(SYSDATE() as date),'-','') - replace(m_birthday ,'-',''))  between 200000 and 300000 ";
if(@in_array("s3",$req['so'])) $SubWhere[] = " (replace(cast(SYSDATE() as date),'-','') - replace(m_birthday ,'-',''))  between 300000 and 400000 ";

if(is_array($SubWhere)){
  $Where[] = "  (".implode(" or ", $SubWhere).")" ;
}else{
  $Where[] = " m_birthday  = '' " ;  
}

$SubWhere = null;
foreach($RegionList as $rk => $rv){
  if(@in_array($rk,$req['sr'])) $SubWhere[] = " m_addr1 = '$rv' ";  
}


if(is_array($SubWhere)){
  $Where[] = "  (".implode(" or ", $SubWhere).")" ;
}else{
  $Where[] = " m_addr11 = '' " ;  
}



if($req['sdate'] && $req['edate']){
    $Where[] = " ( m_regDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
}


$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";
$LimitQuery = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
$OrderByQuery = "m_regDate desc";


$Field  = " m_id ";
/*============================================================================================================================================
* Query Execute
--------------------------------------------------------------------------------------------------------------------------------------------*/
$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where m_regDate >0 $WhereQuery ");

$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];

$Query = "SELECT $Field  FROM ".$Board['table_board']." where m_regDate >0 $WhereQuery ORDER BY $OrderByQuery";
$LIST = $db -> SelectList($Query);

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
function frmcheck(){
  $("textarea[name=Memo]").val($("textarea[name=Memo]").val().replace("\r\n","</br>"));                      // 여기에 실행하고자 하는 코드를 넣으면 된다. 
}
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
							<dt>* 가입일</dt>
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
							<dt>* 지 &nbsp;&nbsp;역</dt>
							<?
								foreach($RegionList as $Key => $Value) echo "<dd><input type='checkbox' name='sr[]' value='$Key' ".Check($Key, $req[sr])." > $Value &nbsp;&nbsp;</dd>";
							?>
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
							<option value='s2'  <?=Select("s2",$req['sn'])?>>이름</option>
							<option value='s3'  <?=Select("s3",$req['sn'])?>>닉네임</option>
							</select> 
							<input type="text" name="st" class="input" value="<?=$req['st']?>">					
							</dd>
						</dl>
						<dl>
							<dt>* 성별</dt>
							<dd>
							<select name="se">
							<option value=''>-- 전체 --</option>
							<option value='s1' <?=Select("s1",$req['se'])?>>남자</option>
							<option value='s2' <?=Select("s2",$req['se'])?>>여자</option>
							</select> 
							</dd>
						</dl>
						<dl>
							<dt>* 나이</dt>
							<dd><input type="checkbox" name="so[]" value="s1" <?=Check("s1", $req['so'])?> > 10대&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="so[]" value="s2" <?=Check("s2", $req['so'])?> > 20대&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="so[]" value="s3" <?=Check("s3", $req['so'])?> > 30대&nbsp;&nbsp;</dd>
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
						<dl>
							<dt>* 회원상태</dt>
							<dd><input type="checkbox" name="ss[]" value="s1" <?=Check("s1", $req['ss'])?> > 정상&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s2" <?=Check("s2", $req['ss'])?> > 탈퇴&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s3" <?=Check("s3", $req['ss'])?> > 휴면&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s4" <?=Check("s4", $req['ss'])?> > 불량</dd>
						</dl>

						</td>
					</tr>
				</table>
		</div>	
		<div style='text-align:center'><input type="image" src="../images/btn_confirm_m.gif">	</div>
		</form>
    <!--// search -->
	
	  <!-- list -->
    <form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
    <input type="hidden" name="token" value="<?=$token?>">
    <input type="hidden" name="Html"  value="Y">
    <input type="hidden" name="idx" value="<?=$req['idx']?>">
    <input type="hidden" name="am" value="MemoSendALL">
    <input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">

    <input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
    <input type="hidden" name="sdate" value="<?=$req['sdate']?>">
    <input type="hidden" name="edate" value="<?=$req['edate']?>">
    <input type="hidden" name="sn" value="<?=$req['sn']?>">
    <input type="hidden" name="st" value="<?=$req['st']?>">
		<input type="hidden" name="eq" value="<?=encrypt_md5($Query,'regexcel@)!@')?>">

		<div class="leftbtn number">Total : <?=$TOTAL?> </div>

      <table cellspacing="0" cellpadding="0" class="formtable">
        <tr>
          <th class="tableth f11" style="width:120px">내용</th>
          <td class="tabletd left" colspan="3"><textarea class="msg" cols="80" rows="3" name="Memo"></textarea>

          </td>
        </tr>
      </table>


		<div style="clear:both"></div>
    <br/>
		<div style='text-align:center'><input type="image" src="../images/btn_memosend.gif">	</div>
		</form>
	  <!--// list -->



<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>