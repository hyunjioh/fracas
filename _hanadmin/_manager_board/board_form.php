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
		$parameter = "at=view&idx=".$req['idx']."&".$parameter;
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

// 파일첨부 추가
function addInputFile(){
	var frm = document.boardform;
	var newfile = document.createElement('Input'); // DIV 객체 생성
	var filelimit = 10;
	var filecount = 0;
	
	var formlength = frm.length;
	for(i=0; i < formlength; i ++){
		if (frm[i].type == "file[]")
		{
			filecount = filecount + 1;
		}
	}

//	var uploadfilecount = parseInt(frm.fileCount.value);
	if((filecount) >= filelimit){
		alert("최대 " + filelimit + " 개 까지 입니다.");
		return;
	}
	newfile.setAttribute('type','file');
	newfile.setAttribute('name','files[]');
	newfile.setAttribute('size','50');
	newfile.setAttribute('class','inputFile');
	attachFile.appendChild(newfile);
}

// 파일첨부 삭제
function delInputFile(){
	var frm = document.boardform;
	var filecount = 0;
	var formlength = frm.length;
	for(i=0; i < formlength; i ++){
		if (frm[i].type == "file")
		{
			filecount = filecount + 1;
		}
	}

	if(filecount > 1){
		var delarticle = formlength - 1;
		var obj = frm[delarticle];
		attachFile.removeChild(obj);
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
		<th class="tableth">제목</th>
		<td class="tabletd"><input type="text" name="Subject" maxlength="255" value="<?=$Value[Subject]?>" class="forminput" style="width:500px"></td>
	</tr>
	<tr>
		<th class="tableth">작성자</th>
		<td class="tabletd"><input type="text" name="Name" maxlength="30" value="<?=$Value[UserName]?>" class="forminput" ></td>
	</tr>
	<tr>
		<th class="tableth">날짜</th>
		<td class="tabletd"><input type="text" name="RegDate" maxlength="30" value="<?=substr($Value[RegDate],0,10)?>" class="forminput" ></td>
	</tr>
	<tr>
		<th class="tableth">조회수</th>
		<td class="tabletd"><input type="text" name="Hit" maxlength="30" value="<?=$Value[Hit]?>" class="forminput" ></td>
	</tr>
	<tr>
		<th class="tableth">내용</th>
		<td class="tabletd"><textarea name="Content" id="Content" style="width:680px; height:300px"><?=$Value[Content]?></textarea></td>
	</tr>
	<tr>
		<td class="tableth">첨부 <span style="cursor:pointer" onClick="javascript:addInputFile()"><img src='<?=_ADMIN_?>/images/board/icon_attach_plus.gif' width='16' height='16' alt='icon_attach_plus.gif' align='middle' /></span> <span style="cursor:pointer" onClick="javascript:delInputFile()"><img src='<?=_ADMIN_?>/images/board/icon_attach_minus.gif' width='16' height='16' alt='icon_attach_minus.gif' align='middle' /></span></td>
		<td class="tabletd">
		<?=AttachModify($Value['idx'])?>
			<div id="attachFile" style="width:550px">
			<input type="file" name="files[]" class="inputFile" size="50">
			</div>
		</td>
	</tr>
	<tfoot>
		<tr>
		<td colspan="2" class="tfoottd_C">
		<input type="image" src="<?=_ADMIN_?>/images/board/btn_save.gif" align="middle">
		<a href="./?<?=$Link?>"><img src="<?=_ADMIN_?>/images/board/btn_cancel.gif" align="middle"></a>
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