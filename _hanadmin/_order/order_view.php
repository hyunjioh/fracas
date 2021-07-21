<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	if(!$req['idx'])	locationReplace($Board['Link']);	
	$BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx'];
	$Value = $db -> SelectOne($BoardView);
	if(!$Value)	locationReplace($Board['Link']);	

	$Hit = Hit();
	$AttachList = AttachList($Value['idx']);
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
		</form>

		<h3 class="sub-page-title"><span>글내용보기</span></h3>
		<table cellspacing="0" cellpadding="0" class="formtable">
			<tr>
				<th class="tableth f11" style="width:120px">작성</th>
				<td class="tabletd left"><?=$Value[UserName]?> <?=$Value[UserID]?></td>
				<td class="tabletd right"><span class="number">Date : <?=$Value[RegDate]?></span></td>
			</tr>
			<tr>
				<th class="tableth f11" style="width:120px">제목</th>
				<td class="tabletd left" colspan="2"><?=$Value[Subject]?></td>
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
				<td class="tabletd left " colspan="2"><div class="smartOutput"><?=$Value[Content]?></div></td>
			</tr>

		</table>
		<div style="margin:20px 0 50px; text-align:center"><a href="<?=$href?>"><img src="../images/btn_list.gif"></a> <a href="<?=$href?>&at=modify&idx=<?=$Value[idx]?>"><img src="../images/btn_update.gif"></a>  <img src="../images/btn_delete.gif" class="pointer" onclick="delcheck();"> </div>
	<!--// list -->


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>