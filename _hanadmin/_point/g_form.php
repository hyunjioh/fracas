<?
	if(!defined("_g_board_include_")) exit; 
	if($req['idx']){
		$token = new_token($Board['board_id']);
		/*-------------------------------------------------------------------------------------------------
		▶ 데이터베이스 연결 */	
		unset($db);
		$db = new MySQL;

		$mode = "updateData";
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx']);
		if(!$Value)	locationReplace("./");	
		//$href = $href."&at=view&idx=".$req['idx'];
	}else{
		$token = new_token($Board['board_id']);
		$mode = "newData";
		$Value[Hit] = 0;
		$Value[RegDate] = date("Y-m-d");
		$Value[UserName]  = $_SESSION['_MEMBER_']['NAME'];
		$Value[UserEmail] = $_SESSION['_MEMBER_']['EMAIL'];
	}
?>
<? include "../include/_header.inc.php"; ?>
<!-- Contact Form CSS files -->
<link type='text/css' href='../css/simplemodal.css' rel='stylesheet' media='screen' />

<!-- IE6 "fix" for the close png image -->
<!--[if lt IE 7]>
<link type='text/css' href='../css/simplemodal_ie.css' rel='stylesheet' media='screen' />
<![endif]-->

<script type='text/javascript' src='<?=_CORE_?>/js/jquery.simplemodal.js'></script>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/themes/base/jquery.ui.all.css">
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
	var f = document.boardform;
	if(!f.Subject.value){
		alert("<?=$msg['Please_enter_subject']?>");
		f.Subject.focus();
		return false;
	}
	oEditors[0].exec("UPDATE_IR_FIELD", []);
	// 에디터의 내용에 대한 값 검증은 이곳에서 textarea 필드인 ir1의 값을 이용해서 처리하면 됩니다.
	if(f.Content.value == ""){
		alert("<?=$msg['Please_enter_content']?>");
		oEditors[0].exec("FOCUS", []); 
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
	if(len > 1)	$("#attachFile input[type=file]").last().remove();
}

function delcheck(){
	var f = document.boardform;
	if(confirm("<?=$msg['want_to_delete']?>")){
		f.action = "<?=$Board['Link']?>?at=dataprocess";
		f.am.value = "deleteData";
		f.submit();
	}
}

$(document).ready(function() {
		$("#regdate").datepicker( {
			dateFormat : "yy-mm-dd" ,
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true				
		});

});


/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();

	// Load dialog on click
	$('.basic').click(function (e) {
		$('#basic-modal-content').modal();

		return false;
	});
});

$(document).ready(function() {
	$('#memberSearch').click(function (e) {
	 if(!$("#SearchID").val()){
		alert("검색어를 입력하세요.");
		return false;
	 }
		onSubmit();
	});
$('#SearchID').live("keypress", function(e) {
                /* ENTER PRESSED*/
   if (e.keyCode == 13) {
		 if(!$("#SearchID").val()){
			alert("검색어를 입력하세요.");
			return false;
		 }
		onSubmit();
	 }
	});
 });

 function onSubmit(){
 	 $.ajax({
		 type: "POST",
		 url: "../include/member_search.php",
		 data: "stext="+$('#SearchID').val(),
		 success: function(msg){
			 $("#msg").html(msg);
		 }
	 });
 }

 function searchResult(vala, valb){
	$("#MemberID").val(vala);
	$("#MemberNick").html(valb);
	$.modal.close();
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

<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="./?at=dataprocess">
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="Html"  value="Y">

<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="am" value="<?=$mode?>">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width=""></col>
	<tr>
		<th class="tableth">회원선택</th>
		<td class="tabletd"><? if($mode == "updateData" ){?><?=$Value[MemberID]?><?}else{?><input type="text" name="MemberID" id="MemberID" maxlength="30" value="<?=$Value[MemberID]?>" class="input-blur" readonly> <a href='#' class='basic'><img src="../images/board/btn_search.gif"></a> <span id="MemberNick"></span><?}?></td>
	</tr>
	<tr>
		<th class="tableth">포인트</th>
		<td class="tabletd"><? if($mode == "updateData" ){?><?=$Value[Point]?><?}else{?><input type="text" name="Point" maxlength="10" value="<?=$Value[Point]?>" class="input-blur" ><?}?></td>
	</tr>
	<tr>
		<th class="tableth">지급일선택</th>
		<td class="tabletd"><? if($mode == "updateData" ){?><?=substr($Value[PointDate],0,10)?><?}else{?><input type="text" name="PointDate" value="<?=substr($Value[PointDate],0,10)?>" size="10" maxlength="30"  class="input-blur" id="regdate"> (입력예 : 2001-01-01)<?}?></td>
	</tr>
	<tr>
		<th class="tableth">내용</th>
		<td class="tabletd"><input type="text" name="Comment" maxlength="255" value="<?=$Value[Comment]?>" class="input-blur" style="width:500px"></td>
	</tr>
	<tfoot>
		<tr>
		<td colspan="2" class="tfoottd_C">
		<input type="image" src="<?=_ADMIN_?>/images/board/btn_save.gif" align="middle">
		<a href="<?=$href?>"><img src="<?=_ADMIN_?>/images/board/btn_cancel.gif" align="middle"></a>
		<img src="<?=_ADMIN_?>/images/board/btn_delete.gif" class="pointer" onclick="delcheck();" align="middle">
		</td>
		</tr>
	</tfoot>
</table>
</form>


</div>
<div id="copyright"></div>


</div>

<!-- modal content -->
<div id="basic-modal-content">
	<h3>회원검색</h3>
	<p>&nbsp;</p>
	<p class="search"><input type="text" name="SearchID" id="SearchID" maxlength="30" class="input-blur"> <img src="../images/board/btn_search_s.gif" id="memberSearch" class="pointer"> (아이디, 닉네임, 이메일로 검색하실 수 있습니다.)</p>
	<p>&nbsp;</p>
	<div style="height:250px; overflow-y:auto" id="msg">
	<p><code>검색 결과가 존재하지 않습니다.</code></p>	
	</div>
</div>

<!-- preload the images -->
<div style='display:none'>
	<img src='../images/x.png' alt='' />
</div>
<? include "../include/_footer.inc.php"; ?>
