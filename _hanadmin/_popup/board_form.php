<?
	if(!defined("_g_board_include_")) exit; 
	if($req['idx']){
		$token = new_token($Board['board_id']);
		/*-------------------------------------------------------------------------------------------------
		▶ 데이터베이스 연결 */	
		unset($db);
		$db = new MySQL;

		$mode = "updateData";
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where  idx = ".$req['idx']);
		if(!$Value)	locationReplace("./");	
		$parameter = "at=view&idx=".$req['idx']."&".$parameter;

		$value['starttime'] = substr($Value['StartTime'],11,5);
		$value['startdate'] = substr($Value['StartTime'],0,10);

		$value['endtime'] = substr($Value['EndTime'],11,5);
		$value['enddate'] = substr($Value['EndTime'],0,10);
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
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/themes/base/jquery.ui.all.css">

<script type="text/javascript" src="<?=_CORE_?>/js/jquery.clockpick.1.2.7/jquery.clockpick.1.2.7.js"></script>
<link rel="stylesheet" href="<?=_CORE_?>/js/jquery.clockpick.1.2.7/jquery.clockpick.1.2.7.css" type="text/css">
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

$(document).ready(function() {
		$("#clockpick<?=$value['idx']?>").clockpick(
		{ 
				military : true,
				valuefield: 'starttime<?=$value['idx']?>'			
		},
		cback<?=$value['idx']?>); 

		$("#clockpick2<?=$value['idx']?>").clockpick(
		{ 
				military : true,
				valuefield: 'endtime<?=$value['idx']?>'			
		}); 


		$("#startdate<?=$value['idx']?>").datepicker( {
			dateFormat : "yy-mm-dd" ,
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true				
		});
		$("#enddate<?=$value['idx']?>").datepicker( {
			minDate: $("#startdate").val(),
			dateFormat : "yy-mm-dd" ,
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true				
		});

		$( "#startdate<?=$value['idx']?>" ).change(function() {
			$("#enddate<?=$value['idx']?>").val($("#startdate<?=$value['idx']?>").val())
			$("#enddate<?=$value['idx']?>").datepicker( {
				minDate: $("#startdate<?=$value['idx']?>").val(),
				dateFormat : "yy-mm-dd" ,
				showOn: "button",
				buttonImage: "images/calendar.gif",
				buttonImageOnly: true				
			});
		});
});

function cback<?=$value['idx']?>(){
	$("#endtime<?=$value['idx']?>").val($("#starttime<?=$value['idx']?>").val());
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
		<th class="tableth">기간</th>
		<td class="tabletd">
		<input type="text" name="startdate" id="startdate<?=$value['idx']?>" class="input-blur" style="IME-MODE: active;" value="<?=$value["startdate"]?>"  size="10" readonly>
		&nbsp;
		<input type="text" name="starttime<?=$value['idx']?>" id="starttime<?=$value['idx']?>" class="input-blur" size="5" readonly value="<?=$value["starttime"]?>"><IMG src="images/clock.png" id="clockpick<?=$value['idx']?>" align="middle"> 
		
		&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;

		<input type="text" name="enddate" id="enddate<?=$value['idx']?>" class="input-blur" style="IME-MODE: active;" value="<?=$value["enddate"]?>"  size="10" readonly>
		&nbsp;
		<input type="text" name="endtime<?=$value['idx']?>" id="endtime<?=$value['idx']?>" class="input-blur" size="5" readonly value="<?=$value["endtime"]?>"><IMG src="images/clock.png" id="clockpick2<?=$value['idx']?>" align="middle">		
		</td>
	</tr>
	<tr>
		<th class="tableth">노출</th>
		<td class="tabletd">
			<input type="radio" name="Display" value="Y" <? if($Value['Display'] == "Y") {echo "checked";}?>> 보임 &nbsp;&nbsp;&nbsp;
			<input type="radio" name="Display" value="N" <? if($Value['Display'] != "Y" || $Value['Display'] != "P") {echo "checked";}?>> 숨김 &nbsp;&nbsp;&nbsp;		
			<input type="radio" name="Display" value="P" <? if($Value['Display'] == "P") {echo "checked";}?>> 미리보기(관리자로 로긴했을경우 보임) &nbsp;&nbsp;&nbsp;		
		</td>
	</tr>
	<tr>
		<th class="tableth">크기</th>
		<td colspan="2" class="tabletd">Width : <input type="text" name="Width" value="<?=$Value[Width]?>" size="4">px &nbsp;&nbsp; Height : <input type="text" name="Height" value="<?=$Value[Height]?>"  size="4">px</td>
	</tr>
	<tr>
		<th class="tableth">위치</th>
		<td colspan="2" class="tabletd">Left : <input type="text" name="leftpos" value="<?=$Value[leftpos]?>" size="4">px &nbsp;&nbsp; Top : <input type="text" name="toppos" value="<?=$Value[toppos]?>"  size="4">px</td>
	</tr>

	<tr>
		<th class="tableth">제목</th>
		<td class="tabletd"><input type="text" name="Subject" maxlength="255" value="<?=$Value[Subject]?>" class="forminput" style="width:500px"></td>
	</tr>
	<tr>
		<th class="tableth">내용</th>
		<td class="tabletd"><textarea name="Content" id="Content" style="width:680px; height:300px"><?=$Value[Content]?></textarea></td>
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