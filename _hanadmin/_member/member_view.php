<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	if(!$req['mid'])	locationReplace($Board['Link']);	
  $req['mid'] = decrypt_md5($req['mid'],'mid');
  $Field = "substring( (replace(cast(SYSDATE() as date),'-','') - replace(m_birthday,'-','')) ,1,2) as age, cast(m_birthday as date) as m_birthday";
	$Query = "select * from ".$Board['table_board']." where  m_id = '".$req['mid']."'";
	$Value = $db -> SelectOne($Query);
	if(!$Value)	locationReplace($Board['Link']);	
  $Value['birthY'] = substr($Value['m_birthday'],0,4);
  $Value['birthM'] = substr($Value['m_birthday'],5,2);
  $Value['birthD'] = substr($Value['m_birthday'],8,2);
  $Value['m_birthday'] = substr($Value['m_birthday'],0,10);

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


function trustUpdate(){
	var f = document.boardform;
	if(confirm("정말로 변경하시겠습니까?")){
		f.action = "<?=$Board['Link']?>?at=dataprocess";
		f.am.value = "TrustUpdate";
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
			<input type="hidden" name="mid" value="<?=encrypt_md5($req['mid'],'mid')?>">
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
        <col width="150"></col>
        <col width="250"></col>
        <col width="150"></col>
        <col width="*"></col>
				<tr>
					<th class="tableth ">ID</th>
					<td class="tabletd"><?=$Value['m_id']?> <? if($Value['m_realMember'] == "N") echo "가짜회원"; ?></td>
					<th class="tableth " >이름</th>
					<td class="tabletd left "><?=$Value['m_name']?></td>
				</tr>

				<tr>
					<th class="tableth " >이메일</th>
					<td class="tabletd left "><?=$Value['m_email']?></td>
					<th class="tableth " >핸드폰</th>
					<td class="tabletd left "><?=$Value['m_hp']?></td>
				</tr>
				<tr>
					<th class="tableth " >우편번호</th>
					<td class="tabletd left " colspan="3"><?=$Value['m_zip']?></td>
				</tr>
				<tr>
					<th class="tableth " >주소</th>
					<td class="tabletd left " colspan="3"><?=$Value['m_addr1']?> <?=$Value['m_addr2']?></td>
				</tr>
				<tr>
					<th class="tableth " >가입일</th>
					<td class="tabletd left "><?=$Value['m_regDate']?> (<?=$Value['m_regIP']?>)</td>
					<th class="tableth " >최근정보수정일</th>
					<td class="tabletd left "><?=$Value['m_updateDate']?> (<?=$Value['m_updateIP']?>)</td>
				</tr>
				<tr>
	          <th class="tableth " >방문회수</th>
					<td class="tabletd left "><?=$Value['m_visit']?></td>
					<th class="tableth " >최근방문일</th>
					<td class="tabletd left "><?=$Value['m_lastVisit']?> (<?=$Value['m_visitIP']?>)</td>
				</tr>

			</table>
			<div style="margin:20px 0 50px; text-align:center"><a href="<?=$href?>"><img src="../images/btn_list.gif"></a>   <img src="../images/btn_delete.gif" class="pointer" onclick="delcheck();"> </div>


			<!--// view -->
      </form>


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>