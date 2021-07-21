<?
	if(!defined("_g_board_include_")) exit; 
	if($req['idx']){
		$token = new_token($Board['board_id']);
		/*-------------------------------------------------------------------------------------------------
		▶ 데이터베이스 연결 */	
		unset($db);
		$db = new MySQL;

		$mode = "updateData";
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where idx = ".$req['idx']);
		if(!$Value)	locationReplace("./");	
		$href = $href."&at=view&idx=".$req['idx'];
		$title = $Value[board_name];
	}else{
		$token = new_token($Board['board_id']);
		$mode = "newData";
		$title = "게시판 생성";
		$Value['table_board'] = "G_Board";
		$Value['table_attach'] = "G_Board_Attach";
		$Value['table_comment'] = "G_Board_Comment";
		$Value['page_limit'] = "10";
		$Value['page_block'] = "10";
		$Value['use_file'] = "10";
		$Value['use_reply'] = "N";
		$Value['use_comment'] = "N";
		$Value['use_category'] = "N";
		$Value['subject_length_main'] = "30";
		$Value['subject_length_board'] = "60";
		$Value['content_length'] = "200";
		$Value['thumb_s_size'] = "120";
		$Value['thumb_m_size'] = "300";
		$Value['thumb_b_size'] = "600";
		$Value['file_max_size'] = "20M";
		$Value['file_check_type'] = "deny";
		$Value['file_check_ext'] = "php|phps|html|htm|exe|bat|sql";
		$Value['level_list'] = "0";
		$Value['level_view'] = "0";
		$Value['level_write'] = "1";
		$Value['level_modify'] = "1";
		$Value['level_reply'] = "1";
		$Value['level_download'] = "0";
		$Value['level_delete'] = "1";
		$Value['level_comment'] = "1";
	}
?>
<? include "../include/_header.inc.php"; ?>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
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
<h3 class="page-title"><span><?=$title?></span></h3>

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
	<col width="200"></col>
	<tr>
		<th class="tableth">게시판 이름</th>
		<td colspan="2" class="tabletd"><input type="text" name="board_name" maxlength="50" class="input-blur" style="width:200px" value="<?=$Value[board_name]?>"></td>
	</tr>
	<tr>
		<th class="tableth">게시판 아이디</th>
		<td colspan="2" class="tabletd"><input type="text" name="board_id" maxlength="20" class="input-blur" style="width:200px" value="<?=$Value[board_id]?>"></td>
	</tr>
	<tr>
		<th class="tableth">게시판 테이블</th>
		<td colspan="2" class="tabletd"><input type="text" name="table_board" maxlength="30" class="input-blur" style="width:200px" value="<?=$Value[table_board]?>"></td>
	</tr>
	<tr>
		<th class="tableth">파일 테이블</th>
		<td colspan="2" class="tabletd"><input type="text" name="table_attach" maxlength="30" class="input-blur" style="width:200px" value="<?=$Value[table_attach]?>"></td>
	</tr>
	<tr>
		<th class="tableth">코멘트 테이블</th>
		<td colspan="2" class="tabletd"><input type="text" name="table_comment" maxlength="30" class="input-blur" style="width:200px" value="<?=$Value[table_comment]?>"></td>
	</tr>
	<tr>
		<td colspan="3" height="10" class="tabletd"></td>
	</tr>

	<tr>
		<th class="tableth">페이지당 게시글</th>
		<td colspan="2" class="tabletd"><input type="text" name="page_limit" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[page_limit]?>"></td>
	</tr>
	<tr>
		<th class="tableth">페이징 블럭</th>
		<td colspan="2" class="tabletd"><input type="text" name="page_block" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[page_block]?>"></td>
	</tr>
	<tr>
		<th class="tableth">파일 사용</th>
		<td colspan="2" class="tabletd"><input type="text" name="use_file" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[use_file]?>"></td>
	</tr>
	<tr>
		<th class="tableth">답변 사용</th>
		<td colspan="2" class="tabletd">
		<input type="radio" name="use_reply" value="Y" <?=($Value[use_file] == "Y")? "checked":"";?>> 사용 &nbsp;&nbsp;
		<input type="radio" name="use_reply" value="N" <?=($Value[use_file] != "Y")? "checked":"";?>> 사용안함 &nbsp;&nbsp;		
		</td>
	</tr>
	<tr>
		<th class="tableth">comment 사용</th>
		<td colspan="2" class="tabletd">
		<input type="radio" name="use_comment" value="Y" <?=($Value[use_comment] == "Y")? "checked":"";?>> 사용 &nbsp;&nbsp;
		<input type="radio" name="use_comment" value="N" <?=($Value[use_comment] != "Y")? "checked":"";?>> 사용안함 &nbsp;&nbsp;		
		</td>
	</tr>
	<tr>
		<th class="tableth">카테고리 사용</th>
		<td colspan="2" class="tabletd">
		<input type="radio" name="use_category" value="Y" <?=($Value[use_category] == "Y")? "checked":"";?>> 사용 &nbsp;&nbsp;
		<input type="radio" name="use_category" value="N" <?=($Value[use_category] != "Y")? "checked":"";?>> 사용안함 &nbsp;&nbsp;				
		</td>
	</tr>
	<tr>
		<td colspan="3" height="10" class="tabletd"></td>
	</tr>
	<tr>
		<th class="tableth">제목길이(메인)</th>
		<td colspan="2" class="tabletd"><input type="text" name="subject_length_main" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[subject_length_main]?>"></td>
	</tr>
	<tr>
		<th class="tableth">제목길이(게시판)</th>
		<td colspan="2" class="tabletd"><input type="text" name="subject_length_board" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[subject_length_board]?>"></td>
	</tr>
	<tr>
		<th class="tableth">본문길이(게시판)</th>
		<td colspan="2" class="tabletd"><input type="text" name="content_length" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[content_length]?>"></td>
	</tr>
	<tr>
		<th class="tableth">썸네일(small)</th>
		<td colspan="2" class="tabletd"><input type="text" name="thumb_s_size" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[thumb_s_size]?>"></td>
	</tr>
	<tr>
		<th class="tableth">썸네일(middle)</th>
		<td colspan="2" class="tabletd"><input type="text" name="thumb_m_size" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[thumb_m_size]?>"></td>
	</tr>
	<tr>
		<th class="tableth">썸네일(big)</th>
		<td colspan="2" class="tabletd"><input type="text" name="thumb_b_size" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[thumb_b_size]?>"></td>
	</tr>
	<tr>
		<th class="tableth">파일최대용량</th>
		<td colspan="2" class="tabletd"><input type="text" name="file_max_size" maxlength="10" class="input-blur" style="width:100px" value="<?=$Value[file_max_size]?>"></td>
	</tr>
	<tr>
		<th class="tableth">파일허용타입</th>
		<td colspan="2" class="tabletd">
		<input type="radio" name="file_check_type" value="deny" <?=($Value[file_check_type] == "deny")? "checked":"";?>> deny &nbsp;&nbsp;
		<input type="radio" name="file_check_type" value="allow" <?=($Value[file_check_type] == "allow")? "checked":"";?>> allow &nbsp;&nbsp;				</td>
	</tr>
	<tr>
		<th class="tableth">확장자</th>
		<td colspan="2" class="tabletd"><textarea name="file_check_ext" class="input-blur" style="width:100%"><?=$Value[file_check_ext]?></textarea></td>
	</tr>
	<tfoot>
		<tr>
		<td colspan="3" class="tfoottd_C">
		<input type="image" src="<?=_ADMIN_?>/images/board/btn_save.gif" align="middle">
		<a href="<?=$href?>"><img src="<?=_ADMIN_?>/images/board/btn_cancel.gif" align="middle"></a>
		</td>
		</tr>
	</tfoot>
</table>
</form>


</div>
<div id="copyright"></div>












</div>
<? include "../include/_footer.inc.php"; ?>
	<script type="text/javascript">
	<!--
	var EditorUrl = "<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/";
	var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		oAppRef: oEditors,
		elPlaceHolder: "Content",
		sSkinURI: EditorUrl+"SEditorSkin.html",
		fCreator: "createSEditorInIFrame",
		BoardID : "<?=$Board['board_id']?>",
		EditorUrl : EditorUrl
	});
	//-->
	</script>