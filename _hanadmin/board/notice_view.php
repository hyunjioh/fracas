<?
	if(!defined("_g_board_include_")) exit;
	require_once "../include/_header.inc.php";

	if(!$req['idx'])	locationReplace($Board['Link']);
	$BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx'];
	$Value = $db -> SelectOne($BoardView);
	if(!$Value)	locationReplace($Board['Link']);
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
<table cellspacing="0" cellpadding="0" class="viewtable">
  <? if($_Category){ ?>
  <tr>
    <th class="tableth f11" style="width:120px">분류</th>
    <td class="tabletd left" colspan="2"><?=$_Category[$Value['Category']]?></td>
  </tr>
  <? } ?>
  <tr>
    <th class="tableth f11" style="width:120px">제목</th>
    <td class="tabletd left nowrap" colspan="2"><?=$Value['Subject']?></td>
  </tr>
  <tr>
    <th class="tableth f11" style="width:120px">작성</th>
    <td class="tabletd left"><?=$Value['UserName']?> ( ID : <?=$Value['UserID']?>)</td>
    <td class="tabletd right">
    <span class="number">Registered : <strong><?=$Value['RegDate']?></strong></span> | <span class="number">Hit : <strong><?=$Value['Hit']?></strong></span>
    <? if($Value['UpdateDate'] > 0){ ?> | <span class="number">Update : <strong><?=$Value['UpdateDate']?></strong></span><? } ?>
    </td>
  </tr>
  <tr>
    <th class="tableth">첨부</th>
    <td colspan="2" class="tabletd">
    <?
      $AttachList = AttachList($Value['idx']);
      if($AttachList) echo $AttachList;
    ?>

    </td>
  </tr>
  <tr>
    <th class="tableth f11" style="width:120px">내용</th>
    <td class="tabletd left " colspan="2"><div class="smartOutput se2_outputarea"><?=$Value['Content']?></div></td>
  </tr>

</table>
<div style="margin:20px 0 50px; text-align:center"><a href="<?=$href?>"><img src="../images/btn_list.gif"></a> <a href="<?=$href?>&at=modify&idx=<?=$Value['idx']?>"><img src="../images/btn_update.gif"></a>  <img src="../images/btn_delete.gif" class="pointer" onclick="delcheck();"> </div>


<? if($Board['use_comment'] == "Y"){    ?>
      <!-- comment -->
      <div class="clearfix" id="comment" style="width:680px">
      <h2 >Comment &nbsp;&nbsp;<span class="f_12 txt_normal">댓글 <span class="txt_orange" id="commentCount">0</span>개가 달렸습니다.</span></h2>
        <div class="comment">
        <form name="cform" method="post" id="cform">
        <input type="hidden" name="tid" value="<?=$Board['comment_table']?>">
        <input type="hidden" name="bid" value="<?=$Board['board_id']?>">
        <input type="hidden" name="pid" value="<?=$req['idx']?>">
        <input type="hidden" name="uid" value="<?=$MemberID?>">
        <input type="hidden" name="unm" value="<?=$MemberName?>">
        <? include "../include/comment.php"; ?>
        <div id="comment_loader" align="center"><img src="../images/common/loading.gif" width="28" height="28" align="absmiddle"/> Loading...</div>
        <div id="CommentLIST"></div>
        </div>
      </div>
      <!-- //comment -->
      <!-- //게시판 -->
<? } ?>




	<!--// list -->


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>