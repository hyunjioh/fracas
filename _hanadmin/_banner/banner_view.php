<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	if(!$req['idx'])	locationReplace($Board['Link']);	
	$BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx'];
	$Value = $db -> SelectOne($BoardView);
	if(!$Value)	locationReplace($Board['Link']);	

  if($Value['AttachSaveFile01']){
    $AttachFile = true;
    $downinfo = trim(
      _CRIPT_KEY_._UPLOAD_PATH_.$Value['AttachSaveFile01'].
      _CRIPT_KEY_.$Value['AttachFileName01']
    );
    $downinfo = urlencode(encrypt_md5_base64($downinfo));
    $AttachFileDownload = "down=$downinfo";
  }
?>
<script type="text/javascript">
//<![CDATA[
function delcheck(){
	var f = document.boardform;
	if(confirm("정말로 삭제하시겠습니까?")){
		f.action = "<?=$Board['Link']?>?at=dataprocess";
		f.am.value = "deleteData";
		f.submit();
	}
}

$(document).ready(function(){
  var baseWidth = "700";
  $(".editor-image").each(function(){
    imgWidth = $(this).width();
    imgHeight = $(this).height();
    if(imgWidth > baseWidth){
      reWidth = baseWidth;
      reHeight = (reWidth/imgWidth)*imgHeight;

      $(this).attr("width",reWidth);
      $(this).removeAttr("height");
    }
  });
});
//]]>
</script>
<script type="text/javascript">
//<![CDATA[

//]]>
</script>


</head>
<?	require_once "../include/_body_top.inc.php"; ?>



<!-- view -->
<form name="boardform" method="post">
<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="am" value="">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">

<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="sdate" value="<?=$req['sdate']?>">
<input type="hidden" name="edate" value="<?=$req['edate']?>">
<input type="hidden" name="sn" value="<?=$req['sn']?>">
<input type="hidden" name="st" value="<?=$req['st']?>">
<input type="hidden" name="sc" value="<?=$req['sc']?>">
<input type="hidden" name="orderby" value="<?=$req['orderby']?>">
<input type="hidden" name="sort" value="<?=$req['sort']?>">
</form>

<table cellspacing="0" cellpadding="0" class="formtable">
  <col width="120"></col>
  <col width="*"></col>
  <? if($_Category){ ?>
  <tr>
    <th class="tableth f11" >분류</th>
    <td class="tabletd left" colspan="2"><?=$_Category[$Value['Category']]?></td>
  </tr>
  <? } ?>
  <tr>
    <th class="tableth f11" >제목</th>
    <td class="tabletd left" colspan="2"><?=$Value['Subject']?></td>
  </tr>
  <tr>
    <th class="tableth f11" >링크</th>
    <td class="tabletd left" colspan="2"><?=autoLink($Value['LinkUrl'])?> [ <?=$Value['LinkTarget']?> ] </td>
  </tr>
  <tr>
    <th class="tableth f11" >이미지</th>
    <td class="tabletd left" colspan="2">
    <? if($AttachFileDownload){ ?>
    <a href="<?=_CORE_?>/act/?at=down&<?=$AttachFileDownload?>"><img src="../images/icon/disk.png" alt="Download" />  <?=$Value['AttachFileName01']?></a><br/>
    <img src="<?=_CORE_?>/act/thumb.php?src=<?=$Value['AttachSaveFile01']?>&x=400&y=300&f=0" >
    <? } ?>    
    </td>
  </tr>
  <tr>
    <th class="tableth f11" >내용</th>
    <td class="tabletd left " colspan="2"><div class="smartOutput se2_outputarea"><?=$Value['Content']?></div></td>
  </tr>

</table>
<div style="margin:20px 0 50px; text-align:center"><a href="<?=$href?>"><img src="../images/btn_list.gif"></a> <a href="<?=$href?>&at=modify&idx=<?=$Value['idx']?>"><img src="../images/btn_update.gif"></a>  <img src="../images/btn_delete.gif" class="pointer" onclick="delcheck();"> </div>
<!--// list -->


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>