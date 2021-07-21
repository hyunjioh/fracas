<?
if(!defined("_g_board_include_")) exit;
require_once "../include/_header.inc.php";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */
unset($db);
$db = new MySQL;

$Where = null;

$Where[] = " m_status = 'normal' ";

if($req['st']){
    if($req['sn'] == "s1") $Where[] = " ( m_email like '%".$req['st']."%') ";
    if($req['sn'] == "s2") $Where[] = " ( m_name like '%".$req['st']."%' ) ";
    if($req['sn'] == "s3") $Where[] = " ( m_id like '%".$req['st']."%' ) ";
    if($req['sn'] == "s4") $Where[] = " ( m_position like '%".$req['st']."%' ) ";
    if(!$req['sn']) $Where[] = " ( m_email like '%".$req['st']."%' or m_name like '%".$req['st']."%' or m_id like '%".$req['st']."%' or m_position like '%".$req['st']."%') ";
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
if(@in_array("s1",$req['ss'])) $SubWhere[] = " m_company = '부산' ";
if(@in_array("s2",$req['ss'])) $SubWhere[] = " m_company = '울산' ";
if(@in_array("s3",$req['ss'])) $SubWhere[] = " m_company = '경남' ";
if(@in_array("s4",$req['ss'])) $SubWhere[] = " m_company = '기타' ";

if(is_array($SubWhere)){
  $Where[] = "  (".implode(" or ", $SubWhere).")" ;
}

// 실제/가짜 회원
$SubWhere = null;
if(@in_array("s1",$req['sm'])) $SubWhere[] = " m_realMember = 'Y' ";
if(@in_array("s2",$req['sm'])) $SubWhere[] = " m_realMember = 'N' ";

if(is_array($SubWhere)){
  $Where[] = "  (".implode(" or ", $SubWhere).")" ;
}

// 연령대
if(@in_array("s0",$req['so'])){

}else{
  $SubWhere = null;
  if(@in_array("s1",$req['so'])) $SubWhere[] = " (replace(cast(SYSDATE() as date),'-','') - replace(m_birthday ,'-',''))  < 200000 ";
  if(@in_array("s2",$req['so'])) $SubWhere[] = " (replace(cast(SYSDATE() as date),'-','') - replace(m_birthday ,'-',''))  between 200000 and 300000 ";
  if(@in_array("s3",$req['so'])) $SubWhere[] = " (replace(cast(SYSDATE() as date),'-','') - replace(m_birthday ,'-',''))  between 300000 and 400000 ";
  if(is_array($SubWhere)){
    $Where[] = "  (".implode(" or ", $SubWhere).")" ;
  }else{
    $Where[] = " m_birthday  = '' " ;
  }
}



$SubWhere = null;
foreach($RegionList as $rk => $rv){
  //if(@in_array($rk,$req['sr'])) $SubWhere[] = " m_addr1 = '$rv' ";
}


if(is_array($SubWhere)){
  $Where[] = "  (".implode(" or ", $SubWhere).")" ;
}else{
  //$Where[] = " m_addr1 = '' " ;
}


// 등록일
if($req['sdate'] && $req['edate']){
    $Where[] = " ( m_regDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
}

// 출산예정일
if($req['sdate02'] && $req['edate02']){
	$sdate02_tmp = explode("-",$req['sdate02']);
	$sdate02 = $sdate02_tmp[2]."/".$sdate02_tmp[0]."/".$sdate02_tmp[1];
	$edate02_tmp = explode("-",$req['edate02']);
	$edate02 = $edate02_tmp[2]."/".$edate02_tmp[0]."/".$edate02_tmp[1];
    $Where[] = " ( m_major between '".$sdate02."' and '".$edate02." 23:59:59') ";
}


$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";
$LimitQuery = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;
$OrderByQuery = "m_regDate desc";


$Field  = " * ";
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
<!-- jQuery Context Menu -->
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.contextMenu-1.01/jquery.contextMenu.js"></script>
<link href="<?=_CORE_?>/js/jquery.contextMenu-1.01/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
//<![CDATA[


$(document).ready( function() {
  $("#memberList .memberid a").click(function(){
    return false;
  });
  // Show menu when a list item is clicked
  $("#memberList .memberid a").contextMenu({
    menu: 'myMenu'
  }, function(obj, el, pos) {
    if(obj.attr("class") == "view"){
      obj.attr("href",$(el).attr("href")).click();
    }
    if(obj.attr("class") == "memobox"){
      var memoboxhref = "memobox.php?sn=s1&mid="+$(el).attr("rel");
      obj.attr("href",memoboxhref).click();
    }
    if(obj.attr("class") == "func_overlay"){
			var hrefurl = obj.attr("href") + "?mid=" + $(el).attr("rel");
			if(obj.attr("id") == "sms_overlay"){
				$("#sms_overlay_link").attr("href",hrefurl).click();
			}
			if(obj.attr("id") == "email_overlay"){
				$("#email_overlay_link").attr("href",hrefurl).click();
			}
			if(obj.attr("id") == "message_overlay"){
				$("#message_overlay_link").attr("href",hrefurl).click();
			}
		}
  });

  $("input[name='so[]']").click(function(){
    if($(this).is(":checked")){
      if($(this).val() == "s0"){        
        $("input[name='so[]']:not([value=s0])").attr("checked",false);
      }else{
        $("input[name='so[]'][value=s0]").attr("checked",false);      
      }
    }
  });


});

function checkSMSSend(){
	var checkLength = $("input[name='gidx[]']:checked").length;
	if(checkLength < 1){
		alert("선택된 항목이 없습니다.");
		return ;
	}
  w = 760;
  h = 360;
  winpos = "left=" + ((window.screen.width-w)/2) + ",top=" + ((window.screen.height-h)/2);
	winstyle="width="+w+",height="+h+",status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=no,copyhistory=no," + winpos;
  var sms_popup = window.open("", 'sms_popup' , winstyle);
  document.lform.target = "sms_popup";
  document.lform.method = "post";
  document.lform.action = "../include/pop_sms_select.php";
  document.lform.submit();
  sms_popup.focus();
}

function checkEmailSend(){
	var checkLength = $("input[name='gidx[]']:checked").length;
	if(checkLength < 1){
		alert("선택된 항목이 없습니다.");
		return ;
	}  
  w = 760;
  h = 620;
  winpos = "left=" + ((window.screen.width-w)/2) + ",top=" + ((window.screen.height-h)/2);
	winstyle="width="+w+",height="+h+",status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=no,copyhistory=no," + winpos;
  var sms_popup = window.open("", 'sms_popup' , winstyle);
  document.lform.target = "sms_popup";
  document.lform.method = "post";
  document.lform.action = "../include/pop_email_select.php";
  document.lform.submit();
  sms_popup.focus();
}

function checkMessageSend(){
	var checkLength = $("input[name='gidx[]']:checked").length;
	if(checkLength < 1){
		alert("선택된 항목이 없습니다.");
		return ;
	}
  w = 700;
  h = 500;
  winpos = "left=" + ((window.screen.width-w)/2) + ",top=" + ((window.screen.height-h)/2);
	winstyle="width="+w+",height="+h+",status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=no,copyhistory=no," + winpos;
  var sms_popup = window.open("", 'sms_popup' , winstyle);
  document.lform.target = "sms_popup";
  document.lform.method = "post";
  document.lform.action = "../include/pop_message_select.php";
  document.lform.submit();
  sms_popup.focus();
}
//]]>
</script>
<style>
#member_sms_overlay {
	background-color:#fff;
	border:10px solid #466aac;
	display:none;
	width:420px;
	height:340px;
	margin:0 auto;
}

#member_email_overlay {
	background-color:#fff;
	border:10px solid #466aac;
	display:none;
	width:760px;
	height:530px;
	margin:0 auto;.
}

#member_message_overlay {
	background-color:#fff;
	border:10px solid #466aac;
	display:none;
	width:560px;
	height:350px;
	margin:0 auto;.
}

.admin_overlay .close {
	background-image:url(/images/overlay/close.png);
	position:absolute; right:5px; top:7px;
	cursor:pointer;
	height:18px;
	width:20px;
	z-index:3;
}

.admin_overlay h2 {
  padding:0 0 15px 0;
  color:#fff;
  background-color:#466aac;
  font:bold 22px Malgun Gothic;
}


</style>
<style>
.contextMenu LI.view A { background-image: url(../images/common/ico_memberview.png); }
.contextMenu LI.sms A { background-image: url(../images/common/ico_sms.png); }
.contextMenu LI.email A { background-image: url(../images/common/ico_email.png); }
.contextMenu LI.message A { background-image: url(../images/common/ico_message.png); }
.contextMenu LI.messagelist A { background-image: url(../images/common/ico_message_display.png); }

</style>

<!-- //jQuery Context Menu -->

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
  if($("input[name=excel]").val() == ""  ){
    alert("파일을 선택하세요.");
    return false;
  }
  return true;
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
							<dt>* 검색어</dt>
							<dd>
							<select name="sn">
							<option value=''>-- 전체 --</option>
							<!-- option value='s4'  <?=Select("s4",$req['sn'])?>>병원명</option -->
							<option value='s1'  <?=Select("s1",$req['sn'])?>>E-mail</option>
							<option value='s2'  <?=Select("s2",$req['sn'])?>>이름</option>
							<option value='s3'  <?=Select("s3",$req['sn'])?>>아이디</option>
							</select>
							<input type="text" name="st" class="input" value="<?=$req['st']?>">
							</dd>
						</dl>
						<!--dl>
							<dt>* 지역</dt>
							<dd><input type="checkbox" name="ss[]" value="s1" <?=Check("s1", $req['ss'])?> > 부산&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s2" <?=Check("s2", $req['ss'])?> > 울산&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s3" <?=Check("s3", $req['ss'])?> > 경남&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s4" <?=Check("s4", $req['ss'])?> > 기타&nbsp;&nbsp;</dd>
						</dl-->
						</td>
					</tr>
					<!--tr>
						<td>
						<dl>
							<dt>* 출산예정일</dt>
							<dd>
							<input type="text" name="sdate02" value="<?=$req['sdate02']?>" class="input-date" id="startdate02" readonly> ~ <input type="text" name="edate02" value="<?=$req['edate02']?>" class="input-date" id="enddate02" readonly>
							<img src="../images/search/period_1_day<?=($dateCheck == "today")?"_ov":"";?>.gif" class="pointer" onclick="setDate02('<?=date("Y-m-d")?>','','');">
							<img src="../images/search/period_1_week<?=($dateCheck == "7day")?"_ov":"";?>.gif" class="pointer" onclick="setDate02('<?=date("Y-m-d")?>','7','D');">
							<img src="../images/search/period_15_day<?=($dateCheck == "15day")?"_ov":"";?>.gif" class="pointer" onclick="setDate02('<?=date("Y-m-d")?>','15','D');">
							<img src="../images/search/period_1_month<?=($dateCheck == "1month")?"_ov":"";?>.gif" class="pointer" onclick="setDate02('<?=date("Y-m-d")?>','1','M');">
							<img src="../images/search/period_3_month<?=($dateCheck == "3month")?"_ov":"";?>.gif" class="pointer" onclick="setDate02('<?=date("Y-m-d")?>','3','M');">
							<img src="../images/search/period_6_month<?=($dateCheck == "6month")?"_ov":"";?>.gif" class="pointer" onclick="setDate02('<?=date("Y-m-d")?>','6','M');">
							<img src="../images/search/period_1_year<?=($dateCheck == "1year")?"_ov":"";?>.gif" class="pointer" onclick="setDate02('<?=date("Y-m-d")?>','1','Y');">
							<img src="../images/search/period_all<?=($dateCheck == "all")?"_ov":"";?>.gif"  class="pointer" onclick="setDate02('','','');">
							</dd>
						</dl>
						<dl>
							<dt>* 출산희망방법</dt>
							<dd><input type="checkbox" name="ss[]" value="s1" <?=Check("s1", $req['ss'])?> > 자연주의 출산&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s2" <?=Check("s2", $req['ss'])?> > 자연분만&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s3" <?=Check("s3", $req['ss'])?> > 무통분만&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s4" <?=Check("s4", $req['ss'])?> > 제왕절개&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="ss[]" value="s5" <?=Check("s5", $req['ss'])?> > VBAC</dd>
						</dl>
						<dl>
							<dt>* 실제/가짜회원</dt>
							<dd><input type="checkbox" name="sm[]" value="s1" <?=Check("s1", $req['sm'])?> > 실회원&nbsp;&nbsp;</dd>
							<dd><input type="checkbox" name="sm[]" value="s2" <?=Check("s2", $req['sm'])?> > 가짜회원&nbsp;&nbsp;</dd>
						</dl>
						</td>
					</tr-->
					<tr>
						<td style="">
            <img src="../images/btn_excel.gif" class="pointer" onclick="goExcel('<?=$Board['Link']?>?at=excel');">
            <img src="../images/btn_SelectDel.gif" class="pointer" onclick="checkDelete();">
            <!-- img src="../images/btn_SelectSMSSend.gif.gif" class="pointer" onclick="checkSMSSend();" -->
            <img src="../images/btn_SelectEmailSend.gif" class="pointer" onclick="checkEmailSend();">
            <!-- img src="../images/btn_SelectMessageSend.gif" class="pointer" onclick="checkMessageSend();" -->
            
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
		<table cellspacing="0" cellpadding="0" class="listtable" id="memberList">
			<tr>
				<th class="tableth f11" style="width:30px;"><input type="checkbox" name="checkall" onclick="javascript:checkAll();"></th>
				<th class="tableth f11" style="width:50px;">번호</th>
				<th class="tableth f11" style="">아이디</th>
				<th class="tableth f11" style="width:60px">성별</th>
				<th class="tableth f11" style="width:80px">이름</th>
				<th class="tableth f11" style="width:230px">이메일</th>
				<th class="tableth f11" style="width:100px">전화번호</th>
				<th class="tableth f11" style="width:60px;">가입일</th>
			</tr>
			<?
				if($LIST){
					foreach($LIST as $key => $value){
            switch($value['m_status']){
              case "secession": $value['m_status'] = "탈퇴"; break;
              case "normal": $value['m_status'] = "정상"; break;
              case "break": $value['m_status'] = "휴면"; break;
              case "bad": $value['m_status'] = "불량"; break;
            }
            switch($value['m_auth']){
              case "N": $value['m_auth'] = "미승인"; break;
              case "Y": $value['m_auth'] = "승인"; break;
              case "I": $value['m_auth'] = "승인대기"; break;
            }
            switch($value['m_sex']){
              case "M": $value['m_sex'] = "남성"; break;
              case "F": $value['m_sex'] = "여성"; break;
            }

            $value['mid'] = encrypt_md5($value['m_id'],'mid');
			?>
			<tr>
				<td class="tabletd center f11"><input type="checkbox" name="gidx[]" value="<?=$value['mid']?>"></td>
				<td class="tabletd center number" ><a href="<?=$href?>&at=view&mid=<?=$value['mid']?>"><?=$NUMBER--?></a></td>
				<td class="tabletd left memberid" ><a href="<?=$href?>&at=view&mid=<?=$value['mid']?>" rel="<?=$value['mid']?>"><?=$value['m_id']?></a></td>
				<td class="tabletd center "><?=$value['m_sex']?></td>
				<td class="tabletd center "><?=$value['m_name']?></td>
				<td class="tabletd center "><?=$value['m_email']?></td>
				<td class="tabletd center "><?=$value['m_hp']?></td>
				<td class="tabletd center number last" ><?=substr($value['m_regDate'],0,10)?></td>
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
		<div style="clear:both"></div>
		<div class="page" style="text-align:center; clear:both">
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

    <!--
		<div class="notification">
			* 엑셀변환은 검색한 조건으로 생성됩니다.<br>
			* 승인된 회원만 서비스 이용이 가능합니다.<br>
      <hr style=" display:block;">
			<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$_SERVER[PHP_SELF]?>?at=dataprocess">
			<input type="hidden" name="token" value="<?=$token?>">
			<input type="hidden" name="Html"  value="Y">
			<input type="hidden" name="idx" value="<?=$req['idx']?>">
			<input type="hidden" name="am" value="excelMemberInsert">
			<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
      * 회원등록 : <INPUT TYPE="file" NAME="excel" style="width:400px; height:24px; border:2px solid darkgray"> <input type="image" src="../images/btn_write.gif" id="excelsubmit" name="submit" value="submit"><br/>
      * 샘플 [<a href="member_sample.xls"><b><font color='red'>다운로드</font></b></a>]<br>
      * Excel 97 -2003 통합문서(*.xls) 형식만 지원합니다.<br>
      </form>
		</div>
    -->


<? include "../include/_body_bottom.inc.php"; ?>

<? include "../include/_footer.inc.php"; ?>
  <ul id="myMenu" class="contextMenu">
    <li class="view"><a href="#view" class="view">View</a></li>
    <!-- li class="sms separator"><a href="../include/pop_sms.php" class="func_overlay" id="sms_overlay" >SMS</a></li -->
    <li class="email"><a href="../include/pop_email.php" class="func_overlay" id="email_overlay">E-mail</a></li>
    <!-- li class="message"><a href="../include/pop_message.php" class="func_overlay" id="message_overlay">쪽지발송</a></li>
    <li class="messagelist separator"><a href="#" class="memobox">쪽지확인</a></li -->
  </ul>
   <a href="#" rel="#member_sms_overlay" class="overlay" id="sms_overlay_link"></a>
   <a href="#" rel="#member_email_overlay" class="overlay" id="email_overlay_link"></a>
   <a href="#" rel="#member_message_overlay" class="overlay" id="message_overlay_link"></a>

  <div class="admin_overlay" id="member_sms_overlay">
    <div class="contentWrap"></div>
  </div>
  <div class="admin_overlay" id="member_email_overlay">
    <div class="contentWrap"></div>
  </div>
  <div class="admin_overlay" id="member_message_overlay">
    <div class="contentWrap"></div>
  </div>