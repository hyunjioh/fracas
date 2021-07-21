<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	if(!$req['idx'])	locationReplace("./");	
	$BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx'];
	$Value = $db -> SelectOne($BoardView);
	if(!$Value)	locationReplace("./");	


	$readCheck = $_SESSION['read'][$Board['board_id']];
	if(is_array($readCheck)){
		if( !in_array($req['idx'],$readCheck) ){
			$readCheck = array_push($readCheck,$req['idx']);
			$db -> ExecQuery("Update ".$Board['table_board']." set Hit = Hit + 1 where  BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
		}
	}else{
		$readCheck = array($req['idx']);
		$db -> ExecQuery("Update ".$Board['table_board']." set Hit = Hit + 1 where  BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");	
	}
	$_SESSION['read'][$Board['board_id']] = $readCheck;
?>	
<? include "../include/_header.inc.php"; ?>
<script type="text/javascript">
//<![CDATA[
function delcheck(){
	var f = document.boardform;
	if(confirm("<?=$msg['want_to_delete']?>")){
		f.action = "<?=$Board['Link']?>?at=dataprocess";
		f.am.value = "deleteData";
		f.submit();
	}
}

//]]>
</script>
<script type="text/javascript">
//<![CDATA[
function AjaxLoad(url, postvar, returnfn){
	if(getElement("CommentListButton"))	getElement("CommentListButton").style.display = 'none';
	if(getElement("CommentLoading"))	getElement("CommentLoading").style.display = '';
	httpRequest = getXMLHttpRequest();
	httpRequest.onreadystatechange = returnfn;
	httpRequest.open("POST", url, true);
	//httpRequest.setRequestHeader('Content-Type','application/x-www-form-urlencoded');  //한글 
	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=euc-kr");
	httpRequest.send(postvar);
}

function CommentList() {
	if (httpRequest.readyState == 4) {
		if(httpRequest.status == 200) {
			// 값이 있을때만 처리
			resultText = httpRequest.responseText;
			document.getElementById("CommentListDiv").innerHTML = resultText;
		}
	}
}

function CommentActResult() {
	if (httpRequest.readyState == 4) {
		if(httpRequest.status == 200) {
			var f = document.cform;
			// 값이 있을때만 처리
			resultText = httpRequest.responseText;
			if(resultText != "Y"){
				alert("<?=$msg['data_error']?>");
			}
			postvars  = "idx="+f.idx.value;
			postvars += "&bt="+f.bt.value;
			postvars += "&check="+f.check.value;
			postvars += "&limit="+f.limit.value;
			AjaxLoad(f.url.value, postvars, CommentList);
		}
	}
}

function CommentInput(url){
	var f = document.cform;
	if(!f.Content.value){
		alert("<?=$msg['Please_enter_content']?>");
		f.Content.focus();
		return;
	}
	postvars = "idx="+f.idx.value;
	postvars += "&check="+f.check.value;
	postvars += "&Name="+f.Name.value;
	postvars += "&Content="+f.Content.value;
	postvars += "&limit="+f.limit.value;
	postvars += "&bt="+f.bt.value;
	postvars += "&am=commentNew";
	load(url,postvars,CommentActResult);
}


function CommentDel(url, cidx){
	var f = document.cform;
	if(confirm("<?=$msg['want_to_delete']?>")){
		postvars = "idx="+f.idx.value;
		postvars += "&cidx="+cidx;
		postvars += "&check="+f.check.value;
		postvars += "&Name="+f.Name.value;
		postvars += "&Content="+f.Content.value;
		postvars += "&limit="+f.limit.value;
		postvars += "&am=commentDel";

		load(url,postvars,CommentActResult);
	}
}

function CommentReplyDisplay(cidx){
	var f = document.cform
	var PreCidx;
	if(getElement("Comment_"+cidx).style.display == "none"){
		if(f.preCidx.value != ""){
			getElement("Comment_"+f.preCidx.value).style.display = "none";	
		}
		getElement("Comment_"+cidx).style.display = "";
		f.preCidx.value = cidx;
	}else{
		getElement("Comment_"+cidx).style.display = "none";
		f.preCidx.value = "";
	}
	getElement("Content_"+cidx).value = "";
	getElement("CommentReply_"+cidx).style.display = "";
	getElement("CommentUpdate_"+cidx).style.display = "none";
}

function CommentReply(url, obj){
	var f = document.cform;
	if(!obj.value){
		alert("<?=$msg['Please_enter_content']?>");
		obj.focus();
		return;
	}
	var objstr = obj.id;
	cidx = objstr.substring(8,objstr.Length);
	postvars = "idx="+f.idx.value;
	postvars += "&cidx="+cidx;
	postvars += "&bt="+f.bt.value;
	postvars += "&check="+f.check.value;
	postvars += "&Name="+f.Name.value;
	postvars += "&Content="+obj.value;
	postvars += "&limit="+f.limit.value;
	postvars += "&am=commentReply";
	load(url,postvars,CommentActResult);
}


function CommentEditDisplay(cidx){
	var f = document.cform
	var PreCidx;
	var val = getElement("Value_"+cidx).innerText;
	val = val.replace("<BR>","/n");
	if(getElement("Comment_"+cidx).style.display == "none"){
		if(f.preCidx.value != ""){
			getElement("Comment_"+f.preCidx.value).style.display = "none";	
			getElement("Content_"+f.preCidx.value).value = "";
		}
		getElement("Comment_"+cidx).style.display = "";
		getElement("Content_"+cidx).value = val;
		f.preCidx.value = cidx;

	}else{
		getElement("Comment_"+cidx).style.display = "none";
		getElement("Content_"+cidx).value = "";
		f.preCidx.value = "";
	}
	getElement("CommentReply_"+cidx).style.display = "none";
	getElement("CommentUpdate_"+cidx).style.display = "";	
}

function CommentUpdate(url, obj){
	var f = document.cform;
	if(!obj.value){
		alert("<?=$msg['Please_enter_content']?>");
		obj.focus();
		return;
	}
	var objstr = obj.id;
	cidx = objstr.substring(8,objstr.Length);
	postvars  = "idx="+f.idx.value;
	postvars += "&bt="+f.bt.value;
	postvars += "&check="+f.check.value;
	postvars += "&Name="+f.Name.value;
	postvars += "&Content="+obj.value;
	postvars += "&limit="+f.limit.value;
	postvars += "&cidx="+cidx;
	postvars += "&am=commentUpdate";
	load(url,postvars,CommentActResult);
}

function coupon_search(){
	var href = "./?at=couponsearch";
	var searchwin = window.open(href, 'search', 'width=628,height=478');
	if ( searchwin ) {
		searchwin.focus();
	}

}
//]]>
</script>
</head>
<body>

<div id="wrapper">	
<? @include "../include/top_menu.php"; ?>
<? @include "../include/left_menu.php"; ?>
<div id="body-content">
<h3 class="page-title"><span><?=$PageTitle?></span></h3>
<form name="boardform" method="post">
<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="am" value="">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
</form>


<table width="100%" cellspacing="0" cellpadding="0" class="viewtable">
	<col width="120"></col>
	<col width=""></col>
	<col width="200"></col>
	<tr>
		<th class="tableth">제목</th>
		<td colspan="2" class="tabletd"><?=$Value[Subject]?></td>
	</tr>
	<tr>
		<th class="tableth">작성</th>
		<td class="tabletd"><?=$Value[UserName]?></td>
		<td class="tabletd right number">Date : <?=substr($Value[RegDate],0,10)?>, Hit : <?=$Value[Hit]?></td>
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
		<th class="tableth">내용</th>
		<td colspan="2" class="tabletdcontent smartOutput" height="200"><?=$Value[Content]?></td>
	</tr>
	<tfoot>
		<tr>
		<td colspan="3" class="tfoottd_R">
		<a href="./?<?=$parameter?>"><img src="<?=_ADMIN_?>/images/board/btn_list.gif" align="middle"></a> 
		<a href="./?at=modify&<?=$parameter?>&idx=<?=$Value[idx]?>"><img src="<?=_ADMIN_?>/images/board/btn_modify.gif" align="middle"></a>
		<img src="<?=_ADMIN_?>/images/board/btn_delete.gif" class="pointer" onclick="delcheck();" align="middle">
		</td>
		</tr>
	</tfoot>
</table>



</div>
<div id="copyright"></div>












</div>
<? include "../include/_footer.inc.php"; ?>