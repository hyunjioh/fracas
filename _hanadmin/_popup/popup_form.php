<?
if(!defined("_g_board_include_")) exit;
$token = new_token($Board['board_id']);
require_once "../include/_header.inc.php";

$mode = "newData";
$Value['Content'] = "&nbsp;";
$Value['Status']  = "ready";
$Value['Subject'] = null;
$Value['Width']   = null;
$Value['Height']  = null;
$Value['leftpos'] = 0;
$Value['toppos']  = 0;
$Value['Display']  = "N";
$Value['StartDate'] = $date." 00:00:00";
$Value['EndDate']   = $date." 00:00:00";

if($req['idx']){
	$mode = "updateData";
	$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where idx = ".$req['idx']);
	if(!$Value) locationReplace($Board['Link']);
	$href = $href."&at=view&idx=".$req['idx'];
}

?>

<!-- script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script -->
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic2.1.0.8008/js/HuskyEZCreator.js" charset="utf-8"></script>

<link rel="stylesheet" type="text/css" href="<?=_CORE_?>/js/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
  var f = document.boardform;
  if(!f.Subject.value){
    alert("제목을 입력하세요.");
    f.Subject.focus();
    return false;
  }
  if(!f.StartDate.value){
    alert("기간(시작일)을 입력하세요.");
    f.StartDate.focus();
    return false;
  }
  if(!f.EndDate.value){
    alert("기간(종료일)을 입력하세요.");
    f.EndDate.focus();
    return false;
  }

  if(!f.Width.value){
    alert("크기(width)를 입력하세요.");
    f.Width.focus();
    return false;
  }

  if(!f.Height.value){
    alert("크기(height)를 입력하세요.");
    f.Height.focus();
    return false;
  }

  if(!f.leftpos.value){
    alert("위치(left)를 입력하세요.");
    f.leftpos.focus();
    return false;
  }
  if(!f.toppos.value){
    alert("위치(top)를 입력하세요.");
    f.toppos.focus();
    return false;
  }

  oEditors.getById['Content'].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용된다.
  if($("#Content").val() == ""){
    alert("내용을 입력하세요.");
    oEditors.getById['Content'].exec("FOCUS", []);
    return false;
  }
}

function addFileField(str){
  var max    = $("#maxfile").text();
  var remain = $("#remainfile").text();
  var now = max - remain;
  var len    = $("#attachFile input[type=file]").length;
  if(len  >= remain){
    alert("파일 첨부는 최대 "+max+" 까지 입니다.");
    return false;
  }
  $("#attachFile").append(str);
}

function removeFileField(){
  var max    = $("#maxfile").text();
  var remain = $("#remainfile").text();
  var len    = $("#attachFile input[type=file]").length;
  if(len > 1) $("#attachFile input[type=file]").last().remove();
}

//]]>
</script>
<script type="text/javascript">

$(document).ready(function() {
  $('#startdate').datetimepicker({
    numberOfMonths: 3,
    hourGrid: 4,
    minuteGrid: 10,
    timeFormat: 'hh:mm:ss'
  });

  $('#enddate').datetimepicker({
    numberOfMonths: 3,
    hourGrid: 4,
    minuteGrid: 10,
    timeFormat: 'hh:mm:ss'
  });
});
</script>
</head>
<?  require_once "../include/_body_top.inc.php"; ?>


      <form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
      <input type="hidden" name="token" value="<?=$token?>">
      <input type="hidden" name="Html"  value="Y">
      <input type="hidden" name="idx" value="<?=$req['idx']?>">
      <input type="hidden" name="am" value="<?=$mode?>">
      <input type="hidden" name="_referer_" value="<?=$req['ref']?>">

      <input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
      <input type="hidden" name="sdate" value="<?=$req['sdate']?>">
      <input type="hidden" name="edate" value="<?=$req['edate']?>">
      <input type="hidden" name="sn" value="<?=$req['sn']?>">
      <input type="hidden" name="st" value="<?=$req['st']?>">







      <!-- list -->


      <table cellspacing="0" cellpadding="0" class="formtable">
        <tr>
          <th class="tableth">기간</th>
          <td class="tabletd"><input type="text" name="StartDate" value="<?=$Value['StartDate']?>" class="input-datetime" id="startdate" readonly> ~ <input type="text" name="EndDate" value="<?=$Value['EndDate']?>" class="input-datetime" id="enddate" readonly>  </td>
        </tr>
        <tr>
          <th class="tableth">크기</th>
          <td colspan="2" class="tabletd">Width : <input type="text" name="Width" value="<?=$Value['Width']?>" size="4" class="input">px &nbsp;&nbsp; Height : <input type="text" name="Height" value="<?=$Value['Height']?>"  size="4" class="input">px</td>
        </tr>
        <tr>
          <th class="tableth">위치</th>
          <td colspan="2" class="tabletd">Left : <input type="text" name="leftpos" value="<?=$Value['leftpos']?>" size="4" class="input">px &nbsp;&nbsp; Top : <input type="text" name="toppos" value="<?=$Value['toppos']?>"  size="4" class="input">px</td>
        </tr>

        <tr>
          <th class="tableth">노출</th>
          <td class="tabletd">
            <input type="radio" name="Display" value="Y" <? if($Value['Display'] == "Y") {echo "checked";}?>> 보임 &nbsp;&nbsp;&nbsp;
            <input type="radio" name="Display" value="N" <? if($Value['Display'] != "Y") {echo "checked";}?>> 숨김 &nbsp;&nbsp;&nbsp;
          </td>
        </tr>
        <tr style="display:none;">
          <th class="tableth">형태</th>
          <td class="tabletd">
            <input type="radio" name="BrowserType" value="overlay" checked> 레이어
          </td>
        </tr>
        <tr>
          <th class="tableth f11" style="width:120px">제목</th>
          <td class="tabletd left" colspan="3"><input type="text" style="width:350px" class="input" name="Subject" maxlength="255" value="<?=$Value['Subject']?>">
          </td>
        </tr>
        <tr>
          <th class="tableth f11" style="width:120px">내용</th>
          <td class="tabletd left" colspan="3"><textarea name="Content" id="Content" style="width:680px; height:250px"><?=$Value['Content']?></textarea>
          </td>
        </tr>
      </table>
      <div style="margin:20px 0 50px; text-align:center"><input type="image" src="../images/btn_ok.gif" style="cursor:pointer;"> <a href="<?=$href?>"><img src="../images/btn_cancel.gif"  style="cursor:pointer;"></a></div>
      <!--// list -->
    </form>

<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>



<script type="text/javascript">
var EditorUrl = "<?=_CORE_?>/plugin/SmartEditorBasic2.1.0.8008/";
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
oAppRef: oEditors,
oAppRef: oEditors,
elPlaceHolder: "Content",
sSkinURI: EditorUrl+"SmartEditor2Skin.html",
fCreator: "createSEditor2",
BoardID : "<?=$Board['board_id']?>",
EditorUrl : EditorUrl
});
</script>