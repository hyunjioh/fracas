<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	if(!$req['mid'])	locationReplace($Board['Link']);	
	$Query = "select *, substring( (replace(cast(SYSDATE() as date),'-','') - replace(g_UserBirth,'-','')) ,1,2) as age, cast(g_UserBirth as date) as g_UserBirth from ".$Board['table_board']." where  g_UserNum = ".$req['mid'];
	$Value = $db -> SelectOne($Query);
	if(!$Value)	locationReplace($Board['Link']);	
  $Value['birthY'] = substr($Value['g_UserBirth'],0,4);
  $Value['birthM'] = substr($Value['g_UserBirth'],5,2);
  $Value['birthD'] = substr($Value['g_UserBirth'],8,2);

  $g_exitReason = null;
  if($Value[g_exitReason]){
    unset($exitReason);
    unset($k);
    unset($v);
    $exitReason = explode(",",$Value[g_exitReason]);
    foreach($exitReason as $k => $v){
      $g_exitReason[] = $_Reason[$v];
    }
    $g_exitReason = implode(", ",$g_exitReason);

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


function authUpdate(){
	var f = document.boardform;
	if(confirm("정말로 변경하시겠습니까?")){
		f.action = "<?=$Board['Link']?>?at=dataprocess";
		f.am.value = "AuthUpdate";
		f.submit();
	}
}


function statusUpdate(){
	var f = document.boardform;
	if(confirm("정말로 변경하시겠습니까?")){
		f.action = "<?=$Board['Link']?>?at=dataprocess";
		f.am.value = "StatusUpdate";
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
			<input type="hidden" name="mid" value="<?=$req['mid']?>">
			<input type="hidden" name="am" value="">
			<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">

			<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
			<input type="hidden" name="sdate" value="<?=$req['sdate']?>">
			<input type="hidden" name="edate" value="<?=$req['edate']?>">
			<input type="hidden" name="sn" value="<?=$req['sn']?>">
			<input type="hidden" name="st" value="<?=$req['st']?>">
			<input type="hidden" name="se" value="<?=$req['se']?>">
			<input type="hidden" name="sa" value="<?=$req['sa']?>">
      <? 
        if($req['ss']){
          foreach($req['ss'] as $ssk => $ssv){
      ?>
			<input type="hidden" name="ss[]" value="<?=$ssv?>">
      <?
          }
        }
      ?>
      <? 
        if($req['so']){
          foreach($req['so'] as $sok => $sov){
      ?>
			<input type="hidden" name="so[]" value="<?=$sov?>">
      <?
          }
        }
      ?>
      <? 
        if($req['sr']){
          foreach($req['sr'] as $srk => $srv){
      ?>
			<input type="hidden" name="sr[]" value="<?=$srv?>">
      <?
          }
        }
      ?>
			<input type="hidden" name="sc" value="<?=$req['sc']?>">
			<input type="hidden" name="sp" value="<?=$req['sp']?>">



			<h3 class="sub-page-title"><span>기본정보</span></h3>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tr>
					<th class="tableth f11" style="width:290px">ID</th>
					<td class="tabletd left" colspan="2"><?=$Value[g_UserID]?></td>
				</tr>
				<tr>
					<th class="tableth f11" >승인여부</th>
					<td class="tabletd left " colspan="2">
            <input type="radio" name="auth" value='N' <?=Check("N",$Value['g_Auth'])?>>미승인&nbsp;&nbsp;
            <input type="radio" name="auth" value='Y' <?=Check("Y",$Value['g_Auth'])?>>승인&nbsp;&nbsp;
           </td>
				</tr>
				<tr>
					<th class="tableth f11" >가입일</th>
					<td class="tabletd left " colspan="2"><?=$Value[g_regDate]?></td>
				</tr>
				<tr>
					<th class="tableth f11" >탈퇴일</th>
					<td class="tabletd left " colspan="2"><?=$Value[g_exitDate]?></td>
				</tr>
				<tr>
					<th class="tableth f11" >탈퇴사유</th>
					<td class="tabletd left " colspan="2"><?=$g_exitReason?></td>
				</tr>
				<tr>
					<th class="tableth f11" >마지막한마디</th>
					<td class="tabletd left " colspan="2"><?=nl2br($Value[g_exitMsg])?></td>
				</tr>
			</table>
			<div style="margin:20px 0 50px; text-align:center"><a href="<?=$href?>"><img src="../images/btn_list.gif"></a>   <img src="../images/btn_delete.gif" class="pointer" onclick="delcheck();"> </div>



			<!--// view -->
      </form>


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>