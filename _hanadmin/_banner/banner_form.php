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
$Value['LinkTarget'] = "_self";

if($req['idx']){
  /*-------------------------------------------------------------------------------------------------
  ▶ 데이터베이스 연결 */
  unset($db);
  $db = new MySQL;
  $Value = $db -> SelectOne("select *  from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx']);
  if(!$Value) locationReplace($Board['Link']);
  $href = $href."&at=view&idx=".$req['idx'];

  $mode = "updateData";
  if($Value['AttachSaveFile01']){
    $AttachFile = true;
    $downinfo = trim(
      _CRIPT_KEY_._UPLOAD_PATH_.$Value['AttachSaveFile01'].
      _CRIPT_KEY_.$Value['AttachFileName01']
    );
    $downinfo = urlencode(encrypt_md5_base64($downinfo));
    $AttachFileDownload = "down=$downinfo";
  }
}
?>
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
  return true;
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


<table cellspacing="0" cellpadding="0" class="formtable">
  <col width="120"></col>
  <col width="*"></col>
  <?
    if(isset($_Category) && $_Category){
  ?>
  <tr>
    <th class="tableth f11" >분류</th>
    <td class="tabletd left">
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
    <th class="tableth f11" >타이틀</th>
    <td class="tabletd left"><input type="text" style="width:350px" class="input" name="Subject" maxlength="255" value="<?=$Value['Subject']?>"></td>
  </tr>
  <tr>
    <th class="tableth f11" >이미지링크</th>
    <td class="tabletd left"><input type="text" style="width:550px" class="input" name="LinkUrl" maxlength="255" value="<?=$Value['LinkUrl']?>">
    Target : <select name="LinkTarget">
    <option value="_self" <?=Select("_self",$Value['LinkTarget'])?> >_self (현재창)</option>
    <option value="_blank" <?=Select("_blank",$Value['LinkTarget'])?> >_blank (새창)</option>
    </select>
    </td>
  </tr>
  <tr>
    <th class="tableth f11">이미지</th>
    <td class="tabletd left"><input type="file" style="width:550px" class="input" name="file_01" maxlength="255">
    <? if($AttachFileDownload){ ?><br/>
    <a href="<?=_CORE_?>/act/?at=down&<?=$AttachFileDownload?>"><img src="../images/icon/disk.png" alt="Download" />  <?=$Value['AttachFileName01']?></a>
    <input type="checkbox" name="file_01_del" value="<?=$Value['AttachSaveFile01']?>">삭제<br/>
    <img src="<?=_CORE_?>/act/thumb.php?src=<?=$Value['AttachSaveFile01']?>&x=400&y=300&f=0" >
    <? } ?>
    </td>
  </tr>
  <tr>
    <th class="tableth f11">설명</th>
    <td class="tabletd left"><textarea name="Content" id="Content" style="width:600px; height:100px"><?=$Value['Content']?></textarea>
    </td>
  </tr>
</table>
<div style="margin:20px 0 50px; text-align:center"><input type="image" src="../images/btn_ok.gif" style="cursor:pointer;"> <a href="<?=$href?>"><img src="../images/btn_cancel.gif"  style="cursor:pointer;"></a></div>
</form>

<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>
