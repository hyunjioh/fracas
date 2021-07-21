<?
if(!defined("_g_board_include_")) exit; 
require_once "../include/_header.inc.php";

$Where = null;
$WHERE[] = " BoardID = '".$Board['board_id']."' ";
if($req['st']){
    if($req['sn'] == "s1") $WHERE[] = " ( Subject like '%".$req['st']."%') ";
    if($req['sn'] == "s2") $WHERE[] = " ( Content like '%".$req['st']."%') ";
    if($req['sn'] == "") $WHERE[] = " ( Subject like '%".$req['st']."%' or Content like '%".$req['st']."%') ";
}
if($req['sc']){
    $WHERE[] = " Category like '%".$req['sc']."%' ";
}

if($req['sdate'] && $req['edate']){
    $WHERE[] = " ( RegDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
}

$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by SortNum asc ";
$LimitQuery   = " Limit ".($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;

$SelectField = "* ";
$TOTAL  = $db -> Total("Select count(*) From ".$Board['table_board']." Where idx > 0 ".$WhereQuery);
$List   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where idx > 0 ".$WhereQuery.$OrderbyQuery.$LimitQuery);
$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];

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
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.tablednd.0.6.min.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.pagination.js"></script>
<script type="text/javascript" src="../include/js/list.js"></script>
<script type="text/javascript">
//<![CDATA[
// When document is ready, initialize pagination
$(document).ready(function(){      
	initPagination(<?=($req['pagenumber']==1)? "0":$req['pagenumber']-1;?>, <?=$Board['page_limit']?> );
});

function goSort(){
	var trLength = $("input[name='gsort[]']").length;
	if(trLength < 1){
		alert("항목이 없습니다.");
		return ;
	}else{
  	var f = document.lform;
	  f.am.value = 'SortConfirm';
  	f.submit();
  }
}
$(document).ready(function() {
	// Initialise the first table (as before)
	$("#dragtable").tableDnD({
	    onDragClass: "myDragClass",
	    onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            var debugStr = "Row dropped was "+row.id+". New order: ";
            for (var i=0; i<rows.length; i++) {
                debugStr += rows[i].id+" ";
            }
	    }
	});
});


$(document).ready(function() {
  $(".notification").hide();
  $(".help").click(function(){
    $(".notification").slideToggle();
  });
});
//]]>
</script>
</head>
<?	require_once "../include/_body_top.inc.php"; ?>


			<form name="sfrm" method="get">
			<input type="hidden" id="total_entries" value="<?=$TOTAL?>">
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
              <? if($_Category){ ?>
							<dl>
								<dt>* 분류</dt>
								<dd>
								<select name="sc">
								<option value=''>전체</option>
                <?
                  foreach($_Category as $k => $v){
                    echo "<option value='$k' ".Select($k, $req['sc']).">$v</option>";
                  }
                ?>
                </select>
								</dd>
							</dl>
              <? } ?>
							</td>
						</tr>
						<tr>
							<td style=""><img src="../images/btn_SelectDel.gif" class="pointer" onclick="checkDelete();" style="float:left;">  <img src="../images/btn_sort.gif" class="pointer" onclick="goSort();" style="float:left;"> <img src="../images/icon/icon_help.png" class="pointer help" style="float:right;  "></td>
						</tr>
					</table>
				</div>	
        <div class="notification">
          * 목록을 드래그하면 순서를 지정하실 수 있습니다.<br>
          * 정렬을 하신 다음 정렬순서 저장을 누르시면 원하시는 순서대로 게시판에 표시됩니다.<br>
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
        <div class="right number"><a  href="../include/pop_category.php?val=<?=encrypt_md5($Board['table_board']."|".$Board['board_id'],"Board")?>" rel="#category_write_overlay" class="oncloseact_overlay" id="category_overlay_link"><img src="../images/btn_CategoryManage.gif"></a></div>

				<form name="lform" method="post" action="<?=$Board['Link']?>?at=dataprocess">
				<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
				<input type="hidden" name="sn" value="<?=$req['sn']?>">
				<input type="hidden" name="CodeCategory" value="<?=$req['sn']?>">
				<input type="hidden" name="am" value="">
				<input type="hidden" name="idx" value="">
				<table cellspacing="0" cellpadding="0" class="listtable" id="dragtable">
					<tr class="nodrop nodrag">
						<th class="tableth f11" style="width:30px;"><input type="checkbox" name="checkall" onclick="javascript:checkAll();"></th>
						<th class="tableth f11" style="width:50px;">번호</th>
            <? if($_Category){ ?>
						<th class="tableth f11" style="width:150px;">분류</th>
            <? } ?>
						<th class="tableth f11" style="width:120px;">이미지</th>
						<th class="tableth f11" style="">제목</th>
						<th class="tableth f11" style="width:40px">정렬</th>
					</tr>
					<?
						if($List){
							foreach($List as $key => $Value){
					?>
					<tr id="<?=$Value['SortNum']?>">
						<td class="tabletd center f11"><input type="checkbox" name="gidx[]" value="<?=$Value['idx']?>">
            <input type="hidden" name="gsort[]" value="<?=$Value['idx']?>"></td>
						<td class="tabletd center number" ><a href="<?=$href?>&at=view&idx=<?=$Value['idx']?>"><?=$NUMBER--?></a> </td>
            <? if($_Category){ ?>
            <td class="tabletd center "><?=$_Category[$Value['Category']]?></td>
            <? } ?>
						<td class="notice center f11 img"><img src="<?=_CORE_?>/act/thumb.php?src=<?=$Value['AttachSaveFile01']?>&x=100&y=80&f=0" ></td>
						<td class="tabletd left " ><a href="<?=$href?>&at=view&idx=<?=$Value['idx']?>"><?=highlight($req['st'],$Value['Subject'])?></a><br/>
            <?=$Value['LinkUrl']?> [ <?=$Value['LinkTarget']?> ]
            </td>
						<td class="tabletd center " ><?=$Value['SortNum']?></td>
					</tr>

					<?
							}
						}else{
              $colspan = 5;
              if($_Category) $colspan++;
					?>
					<tr>
						<td colspan="<?=$colspan?>" class="tabletd center" style="height:200px">데이터가 없습니다.</td>
					</tr>
					<?						
						}	
						$db -> Disconnect();
					?>

			
				</table>
				<div class="rightbtn"><a href="<?=$href?>&at=write"><img src="../images/btn_write.gif"></a></div>
				<div class="page" style="text-align:center; clear:both">
				<div id="Pagination"></div>
				</div>
				</form>

				<!--// list -->

<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>
<div class="admin_overlay" id="category_write_overlay">
  <div class="contentWrap"></div>
</div>