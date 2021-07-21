<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";

	if($req['mid']){
		$token = new_token($Board['board_id']);
		/*-------------------------------------------------------------------------------------------------
		▶ 데이터베이스 연결 */	
		unset($db);
		$db = new MySQL;
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where g_UserNum = ".$req['mid']);
		if(!$Value)	locationReplace($Board['Link']);	
		$href = $href."&at=view&idx=".$req['mid'];

		$mode = "updateData";
		if($req['at'] == "reply") {
			$mode = "replyData";
			$Value['Subject'] = "[답변] ".$Value['Subject'];
			$Value['Question'] = $Value['Content'];
			$Value['Content'] = "";
			$Value['RegDate'] = "";
		}


	}else{
		$token = new_token($Board['board_id']);
		$mode = "newData";
		$Value[Hit] = 0;
		$Value[RegDate] = date("Y-m-d");
		$Value[Content] = "&nbsp;";
	}

?>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
	var f = document.boardform;
	if(!f.Subject.value){
		alert("제목을 입력하세요.");
		f.Subject.focus();
		return false;
	}
	oEditors[0].exec("UPDATE_IR_FIELD", []);
	// 에디터의 내용에 대한 값 검증은 이곳에서 textarea 필드인 ir1의 값을 이용해서 처리하면 됩니다.
	if(f.Content.value == ""){
		alert("내용을 입력하세요.");
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
<?	require_once "../include/_body_top.inc.php"; ?>





			<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$_SERVER[PHP_SELF]?>?at=dataprocess">
			<input type="hidden" name="token" value="<?=$token?>">
			<input type="hidden" name="Html"  value="Y">
			<input type="hidden" name="idx" value="<?=$req['idx']?>">
			<input type="hidden" name="am" value="<?=$mode?>">
			<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">

			<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
			<input type="hidden" name="sdate" value="<?=$req['sdate']?>">
			<input type="hidden" name="edate" value="<?=$req['edate']?>">
			<input type="hidden" name="sn" value="<?=$req['sn']?>">
			<input type="hidden" name="st" value="<?=$req['st']?>">
			<input type="hidden" name="scc" value="<?=$req['scc']?>">



				
				<!-- list -->


				<h3 class="sub-page-title"><span>새글작성</span></h3>
				<table cellspacing="0" cellpadding="0" class="formtable">
					<tr>
						<th class="tableth f11" style="width:120px">제목</th>
						<td class="tabletd left" colspan="3"><input type="text" style="width:350px" class="input" name="Subject" maxlength="255" value="<?=$Value[Subject]?>">
						</td>
					</tr>

					<tr>
						<th class="tableth">작성자</th>
						<td class="tabletd"><input type="text" name="Name" maxlength="30" value="<? if($req['idx']){ echo $Value[UserName]; }else{ echo "admin"; } ?>" class="input" ></td>
					</tr>


					<tr>
						<th class="tableth">작성일</th>
						<td class="tabletd"><input type="text" name="RegDate" value="<? if($req['idx']){ echo $Value[RegDate]; }else{ echo date('Y-m-d H:i:s'); } ?>" size="20" maxlength="30"  class="input" > (입력예 : 2001-01-01 00:00:00)</td>
					</tr>

					<tr>
						<th class="tableth">조회수</th>
						<td class="tabletd"><input type="text" name="Hit"  value="<?=$Value[Hit]?>" size="5" maxlength="10" class="input" > (숫자만 입력해 주세요.)</td>
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
		<!--						* 첨부파일은 <b><?=str_replace("|",",",$Board['file_check_ext'])?></b> <?=($Board['file_check_type']=="deny")? "를 제외한 파일이 업로드 가능합니다.":" 만 가능합니다."; ?> <br>-->
								&nbsp;&nbsp;<span style="cursor:pointer" onClick="javascript:addFileField('<input type=file name=files[] class=input size=90>')"><img src='<?=_ADMIN_?>/images/icon_plus.png' alt='plus' align='middle' /></span> <span style="cursor:pointer" onClick="javascript:removeFileField()"><img src='<?=_ADMIN_?>/images/icon_minus.png' alt='minus' align='middle' /></span>
							</div>
							<?
								echo AttachModify($Value['idx']);
							?>
							<input type="file" name="files[]" class="input" size="90">
							<?

							?>
							</div>
							<?
								}
							?>
						</td>
					</tr>
					<tr>
						<th class="tableth f11" style="width:120px">내용</th>
						<td class="tabletd left" colspan="3"><textarea name="Content" id="Content" style="width:680px; height:200px"><?=$Value[Content]?></textarea>
						</td>
					</tr>
				</table>
				<div style="margin:20px 0 50px; text-align:center"><input type="image" src="../images/btn_ok.gif" style="cursor:pointer;"> <a href="<?=$href?>"><img src="../images/btn_cancel.gif"  style="cursor:pointer;"></a></div>
				<!--// list -->



			</form>

<? include "../include/_body_bottom.inc.php"; ?>
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