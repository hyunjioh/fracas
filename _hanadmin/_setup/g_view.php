<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	if(!$req['idx'])	locationReplace("./");	
	$BoardView = "select * from ".$Board['table_board']." where idx = ".$req['idx'];
	$Value = $db -> SelectOne($BoardView);
	if(!$Value)	locationReplace("./");	
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


//]]>
</script>
</head>
<body>

<div id="wrapper">	
<div class="black">  
<ul id="top-menu" class="mega-menu" style="display:none; left:-2px; ">
	<li><a href="#" style="margin-left:-200px">게시판설정</a></li>
</ul>
</div>
<div id="body-content">
<h3 class="page-title"><span><?=$Value[board_name]?></span></h3>
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
		<th class="tableth">게시판 이름</th>
		<td colspan="2" class="tabletd"><?=$Value[board_name]?></td>
	</tr>
	<tr>
		<th class="tableth">게시판 아이디</th>
		<td colspan="2" class="tabletd"><?=$Value[board_id]?></td>
	</tr>
	<tr>
		<th class="tableth">게시판 테이블</th>
		<td colspan="2" class="tabletd"><?=$Value[table_board]?></td>
	</tr>
	<tr>
		<th class="tableth">파일 테이블</th>
		<td colspan="2" class="tabletd"><?=$Value[table_attach]?></td>
	</tr>
	<tr>
		<th class="tableth">코멘트 테이블</th>
		<td colspan="2" class="tabletd"><?=$Value[table_comment]?></td>
	</tr>
	<tr>
		<td colspan="3" height="10" class="tabletd"></td>
	</tr>

	<tr>
		<th class="tableth">페이지당 게시글</th>
		<td colspan="2" class="tabletd"><?=$Value[page_limit]?></td>
	</tr>
	<tr>
		<th class="tableth">페이징 블럭</th>
		<td colspan="2" class="tabletd"><?=$Value[page_block]?></td>
	</tr>
	<tr>
		<th class="tableth">파일 사용</th>
		<td colspan="2" class="tabletd"><?=$Value[use_file]?></td>
	</tr>
	<tr>
		<th class="tableth">답변 사용</th>
		<td colspan="2" class="tabletd"><?=$Value[use_reply]?></td>
	</tr>
	<tr>
		<th class="tableth">comment 사용</th>
		<td colspan="2" class="tabletd"><?=$Value[use_comment]?></td>
	</tr>
	<tr>
		<th class="tableth">카테고리 사용</th>
		<td colspan="2" class="tabletd"><?=$Value[use_category]?></td>
	</tr>
	<tr>
		<td colspan="3" height="10" class="tabletd"></td>
	</tr>
	<tr>
		<th class="tableth">제목길이(메인)</th>
		<td colspan="2" class="tabletd"><?=$Value[subject_length_main]?></td>
	</tr>
	<tr>
		<th class="tableth">제목길이(게시판)</th>
		<td colspan="2" class="tabletd"><?=$Value[subject_length_board]?></td>
	</tr>
	<tr>
		<th class="tableth">본문길이(게시판)</th>
		<td colspan="2" class="tabletd"><?=$Value[content_length]?></td>
	</tr>
	<tr>
		<th class="tableth">썸네일(small)</th>
		<td colspan="2" class="tabletd"><?=$Value[thumb_s_size]?></td>
	</tr>
	<tr>
		<th class="tableth">썸네일(middle)</th>
		<td colspan="2" class="tabletd"><?=$Value[thumb_m_size]?></td>
	</tr>
	<tr>
		<th class="tableth">썸네일(big)</th>
		<td colspan="2" class="tabletd"><?=$Value[thumb_b_size]?></td>
	</tr>
	<tr>
		<th class="tableth">파일최대용량</th>
		<td colspan="2" class="tabletd"><?=$Value[file_max_size]?></td>
	</tr>
	<tr>
		<th class="tableth">파일허용타입</th>
		<td colspan="2" class="tabletd"><?=$Value[file_check_type]?></td>
	</tr>
	<tr>
		<th class="tableth">확장자</th>
		<td colspan="2" class="tabletd"><?=$Value[file_check_ext]?></td>
	</tr>


	<tfoot>
		<tr>
		<td colspan="3" class="tfoottd_R">
		<a href="<?=$href?>"><img src="<?=_ADMIN_?>/images/board/btn_list.gif" align="middle"></a> 
		<a href="<?=$href?>&at=modify&idx=<?=$Value[idx]?>"><img src="<?=_ADMIN_?>/images/board/btn_modify.gif" align="middle"></a>
		<img src="<?=_ADMIN_?>/images/board/btn_delete.gif" class="pointer" onclick="delcheck();" align="middle">
		</td>
		</tr>
	</tfoot>
</table>



</div>
<div id="copyright"></div>












</div>
<? include "../include/_footer.inc.php"; ?>