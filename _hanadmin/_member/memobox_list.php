<?
if(!defined("_g_board_include_")) exit; 
require_once "../include/_header.inc.php";

$req['mid'] = Request("mid");
if($req['mid']){
  $req['st'] = decrypt_md5($req['mid'],'mid');
}

$Where = null;
if($req['st']){
  if($req['sn'] == "s1") $Where[] = " ( UserID like '%".$req['st']."%') ";
  if($req['sn'] == "s2") $Where[] = " ( RegID like '%".$req['st']."%' ) ";
  if($req['sn'] == "s3") $Where[] = " ( Subject like '%".$req['st']."%' ) ";
  if($req['sn'] == "s4") $Where[] = " ( Memo like '%".$req['st']."%' ) ";
  if(!$req['sn']) $Where[] = " ( UserID like '%".$req['st']."%' or RegID like '%".$req['st']."%' or Subject like '%".$req['st']."%' or Memo like '%".$req['st']."%') ";
}

if($req['sdate'] && $req['edate']){
    $Where[] = " ( RegDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
}

$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";
$Q['Limit'] = ($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;

$TOTAL = $db -> Total("SELECT COUNT(*) FROM ".$Board['table_board']." where idx > 0 $WhereQuery  ");
$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];

$LIST = $db -> SelectList("SELECT * FROM ".$Board['table_board']." where idx > 0   $WhereQuery order by RegDate desc, idx desc limit ".$Q['Limit'] ."");





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
        <option value=''>-- 전체 --</option>
        <option value='s1'  <?=Select("s1",$req['sn'])?>>받은사람 ID</option>
        <option value='s2'  <?=Select("s2",$req['sn'])?>>보낸사람 ID</option>
        <option value='s3'  <?=Select("s3",$req['sn'])?>>제목</option>
        <option value='s4'  <?=Select("s4",$req['sn'])?>>내용</option>
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
    <th class="tableth f11" style="width:50px;">번호</th>
    <th class="tableth f11" style="width:50px;">구분</th>
    <th class="tableth f11" style="">메세지</th>
    <th class="tableth f11" style="width:80px;">To</th>
    <th class="tableth f11" style="width:80px;">From</th>
    <th class="tableth f11" style="width:120px;">작성일</th>
  </tr>
  <?
    if($LIST){
      foreach($LIST as $key => $value){
        $read_message_icon = ($value['readYN'] == "Y")? "../images/common/mail-mark-read.png":"../images/common/mail-mark-unread.png";
  ?>
  <tr>
    <td class="tabletd center f11"><input type="checkbox" name="gidx[]" value="<?=$value['idx']?>"></td>
    <td class="tabletd center number" ><?=$NUMBER--?></td>
    <td class="tabletd center number" ><img src="<?=$read_message_icon?>" ></td>
    <td class="tabletd left " >
    <b><?=$value['Subject']?></b></br>
    <?=$value['Memo']?></td>
    <td class="tabletd center "><b><?=$value['UserID']?></b></td>
    <td class="tabletd center "><?=$value['RegID']?></td>
    <td class="tabletd center number" ><?=$value['RegDate']?></td>
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

<div class="page" style="text-align:center; clear:both">
  <div id="Pagination"></div>
</div>
</form>
<div style="clear:both"></div>
<div class="notification">
  <img src="../images/common/mail-mark-read.png"> 읽은 메세지<br>
  <img src="../images/common/mail-mark-unread.png"> 읽지 않은 메세지<br>
</div>

<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>