<?
if(!defined("_g_board_include_")) exit;
$token = new_token($Board['board_id']);
require_once "../include/_header.inc.php";

$mode = "newData";
$Value['UserName'] = $MemberName;
$Value['RegDate']  = $dateTime;
$Value['Subject']  = null;
$Value['Content']  = "";
$Value['Category'] = null;
$Value['Html']     = "html";
$Value['Status']   = "Y";
$Value['Hit']      = 0;

if($req['idx']){
  $Value = $db -> SelectOne("select *  from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx']);
  if(!$Value) locationReplace($Board['Link']);
  $href = $href."&at=view&idx=".$req['idx'];

  $mode = "updateData";
  if($req['at'] == "reply") {
    $mode = "replyData";
    $Value['Subject'] = "[답변] ".$Value['Subject'];
    $Value['RegDate'] = $dateTime;;
  }
}
?>
<!--<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>-->
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic2.1.0.8008/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
  <? if($_Category){ ?>
  if($("#Category").val() == ""){
    alert("분류를 선택하세요.");
    $("#Category").focus();
    return false;
  }
  <? } ?>

  if($("input[name=Subject]").val() == ""){
    alert("제목을 입력하세요.");
    $("input[name=Subject]").focus();
    return false;
  }
  oEditors.getById['Content'].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용된다.
  if($("#Content").val() == ""){
    alert("내용을 입력하세요.");
    oEditors.getById['Content'].exec("FOCUS", []);
    return false;
  }
  return true;
}

function addFileField(str){
	str = "<input type=file name=files[] class='input attachinput' size=90>";
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
</head>
<?  require_once "../include/_body_top.inc.php"; ?>



<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
<!-- 체크변수 -->
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="Html"  value="html">
<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="am" value="<?=$mode?>">
<input type="hidden" name="_referer_" value="<?=$req['ref']?>">

<!-- 검색변수 -->
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="sdate" value="<?=$req['sdate']?>">
<input type="hidden" name="edate" value="<?=$req['edate']?>">
<input type="hidden" name="sn" value="<?=$req['sn']?>">
<input type="hidden" name="st" value="<?=$req['st']?>">
<input type="hidden" name="sc" value="<?=$req['sc']?>">
<input type="hidden" name="orderby" value="<?=$req['orderby']?>">
<input type="hidden" name="sort" value="<?=$req['sort']?>">



<!-- 입력/고정변수 -->
<input type="hidden" name="Html" value="<?=$Value['Html']?>">
<input type="hidden" name="Status" value="<?=$Value['Status']?>">






<!-- list -->
<table cellspacing="0" cellpadding="0" class="formtable">
  <?
    if(isset($_Category) && $_Category){
  ?>
  <tr>
    <th class="tableth f11" style="width:120px">분류</th>
    <td class="tabletd left" colspan="3">
    <select name="Category" id="Category">
    <option value="">선택하세요.</option>
    <?
      foreach($_Category as $k => $v){
        echo "<option value='$k' ".Select($k, $Value['Category']).">$v</option>";
      }
    ?>
    </select>
    </td>
  </tr>
  <?
    }  
  ?>
  <tr>
    <th class="tableth f11" style="width:120px">제목</th>
    <td class="tabletd left" colspan="3"><input type="text" style="width:350px" class="input" name="Subject" maxlength="255" value="<?=$Value['Subject']?>">
    <!-- <input type="checkbox" name="Notice" value="Y" <?=Check("Y",$Value['Notice'])?>> 공지 -->
    </td>
  </tr>
  <tr>
    <th class="tableth">작성자</th>
    <td class="tabletd"><input type="text" name="UserName" maxlength="30" value="<?=$Value['UserName']?>" class="input" ></td>
  </tr>
  <tr>
    <th class="tableth">작성일</th>
    <td class="tabletd"><input type="text" name="RegDate" value="<?=$Value['RegDate']?>" size="20" maxlength="30"  class="input" > (입력예 : 2001-01-01 00:00:00)</td>
  </tr>

  <tr>
    <th class="tableth">조회수</th>
    <td class="tabletd"><input type="text" name="Hit"  value="<?=$Value['Hit']?>" size="5" maxlength="10" class="input" > (숫자만 입력해 주세요.)</td>
  </tr>
  <tr>
    <td class="tableth">첨부</td>
    <td class="tabletd">
      <?
        if($Board['use_file']> 0){
          $file_cnt = (isset($Value['idx']))? AttachCnt($Value['idx']) :"";
          $file_max = $Board['use_file'];
      ?>
      <div id="maxfile" style="display:none"><?=$file_max?></div>
      <div id="remainfile" style="display:none"><?=($file_max - $file_cnt)?></div>
      <div id="attachFile" style="width:100%">

      <div class="notification">
        * 첨부파일은 최대 <b><?=$Board['use_file']?></b>개 까지 업로드 가능 합니다.<br>
        * 첨부파일의 최대용량은 <b><?=$Board['file_max_size']?></b> 입니다.<br>
        <!-- * 첨부파일은 <b><?=str_replace("|",",",$Board['file_check_ext'])?></b> <?=($Board['file_check_type']=="deny")? "를 제외한 파일이 업로드 가능합니다.":" 만 가능합니다."; ?> <br> -->
        &nbsp;&nbsp;
        <span style="cursor:pointer" onClick="javascript:addFileField()"><img src='<?=_ADMIN_?>/images/icon_plus.png' alt='plus' align='middle' /></span>
        <span style="cursor:pointer" onClick="javascript:removeFileField()"><img src='<?=_ADMIN_?>/images/icon_minus.png' alt='minus' align='middle' /></span>
      </div>

      <?
        if(isset($Value['idx']))    echo AttachModify($Value['idx']);
      ?>
      <input type="file" name="files[]" class="input attachinput" size="90">
      <?

      ?>
      </div>
      <?
        }
      ?>
    </td>
  </tr>
  <tr>
    <th class="tableth f11" style="width:120px">내용</th>
    <td class="tabletd left" colspan="3"><textarea name="Content" id="Content" style="width:750px; height:250px"><?=$Value['Content']?></textarea>
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