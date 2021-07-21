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
		if(!$Value)	locationReplace($Board['Link']);	
		$href = $href."&at=view&idx=".$req['idx'];

		if($req['at']=="reply"){
			$Value[UserName]		 = "";
			$Value[UserTel]		 = "";
			$Value[UserEmail]		 = "";
			$Value[RegDate] = date("Y-m-d");
			$Value[Hit] = 0;
			$token = new_token($Board['board_id']);
			$mode = "replyData";
		}
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
<? @include "../include/top_menu.php"; ?>
<? @include "../include/left_menu.php"; ?>
<div id="body-content">
<h3 class="page-title"><span><?=$PageTitle?></span></h3>

<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
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
		<th class="tableth">제목</th>
		<td class="tabletd"><input type="text" name="Subject" maxlength="255" value="<?=$Value[Subject]?>" class="input-blur" style="width:500px"></td>
	</tr>
	<tr>
		<th class="tableth">작성자</th>
		<td class="tabletd"><input type="text" name="Name" maxlength="30" value="<?=$Value[UserName]?>" class="input-blur" ></td>
	</tr>
	<tr>
		<th class="tableth">날짜</th>
		<td class="tabletd"><input type="text" name="RegDate" value="<?=substr($Value[RegDate],0,10)?>" size="10" maxlength="30"  class="input-blur" > (입력예 : 2001-01-01)</td>
	</tr>
	<tr>
		<th class="tableth">조회수</th>
		<td class="tabletd"><input type="text" name="Hit"  value="<?=$Value[Hit]?>" size="5" maxlength="10" class="input-blur" > (숫자만 입력해 주세요.)</td>
	</tr>
	<tr>
		<td class="tableth">첨부</td>
		<td class="tabletd">
			<?
				if($Board['use_file']>0){
					$file_cnt = AttachCnt($Value['idx']);
					$file_max = $Board['use_file'];
			?>
			<div id="maxfile" style="display:none"><?=$file_max?></div>
			<div id="remainfile" style="display:none"><?=($file_max - $file_cnt)?></div>
			<div id="attachFile" style="width:100%">
			<div style="background-color:#f5f5f5; border:1px dotted #ff6600; padding:10px; margin-bottom:5px">
				* 첨부파일은 최대 <b><?=$Board['use_file']?></b>개 까지 업로드 가능 합니다.<br>
				* 첨부파일의 최대용량은 <b><?=$Board['file_max_size']?></b> 입니다.<br>
				* 첨부파일은 <b><?=str_replace("|",",",$Board['file_check_ext'])?></b> <?=($Board['file_check_type']=="deny")? "를 제외한 파일이 업로드 가능합니다.":" 만 가능합니다."; ?> <br>
			</div>
			<?
				echo AttachModify($Value['idx']);
			?>
			<input type="file" name="files[]" class="input-blur" size="50">
			<?

			?>
			</div>
			<?
				}
			?>
		</td>
	</tr>
	<tr>
		<th class="tableth">내용</th>
		<td class="tabletd"><textarea name="Content" id="Content" style="width:680px; height:300px"><?=$Value[Content]?></textarea></td>
	</tr>
	<tr>
		<th class="tableth">답변</th>
		<td class="tabletd"><textarea name="Content" id="Comment" style="width:680px; height:200px"><?=$Value[Comment]?></textarea></td>
	</tr>
	<tr>
		<th class="tableth">상태</th>
		<td class="tabletd">
		<input type="radio" name="Status" value="Y" <?=Check("Y",$Value[Status])?>> 已答复
		<input type="radio" name="Status" value="N" <?=Check("N",$Value[Status])?>> 未答复
		</td>
	</tr>
	<tfoot>
		<tr>
		<td colspan="2" class="tfoottd_C">
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