<?
	if(!defined("_g_board_include_")) exit; 
	if($req['idx']){
		$token = new_token($Board['board_id']);
		/*-------------------------------------------------------------------------------------------------
		▶ 데이터베이스 연결 */	
		unset($db);
		$db = new MySQL;

		$mode = "updateData";
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']."  where h_idx = ".$req['idx']);
		if(!$Value)	locationReplace("./");	
		$parameter = "at=view&idx=".$req['idx']."&".$parameter;


		$jumin = explode("-",$Value['h_jumin']);
		if(is_array($jumin)){
			$Value['h_jumin1'] = $jumin[0];
			$Value['h_jumin2'] = (isset($jumin[1]))? $jumin[1] : null;
		}else{
			$Value['h_jumin1'] = null;
			$Value['h_jumin2'] = null;
		}

		$zip = explode("-",$Value['h_zip']);
		if(is_array($zip)){
			$Value['h_zip1'] = $zip[0];
			$Value['h_zip2'] = (isset($zip[1]))? $zip[1]: null;
		}else{
			$Value['h_zip1'] = null;
			$Value['h_zip2'] = null;
		}

		$email = explode("@",$Value['h_email']);
		if(is_array($email)){
			$Value['h_email1'] = $email[0];
			$Value['h_email2'] = (isset($email[1]))? $email[1]: null;
		}else{
			$Value['h_email1'] = null;
			$Value['h_email2'] = null;
		}

		$tel = explode("-",$Value['h_tel']);
		if(is_array($email)){
			$Value['h_tel1'] = $tel[0];
			$Value['h_tel2'] = (isset($tel[1]))? $tel[1] : null;
			$Value['h_tel3'] = (isset($tel[2]))? $tel[2] : null;
		}else{
			$Value['h_tel1'] = null;
			$Value['h_tel2'] = null;
			$Value['h_tel3'] = null;
		}

		$hp = explode("-",$Value['h_hp']);
		if(is_array($email)){
			$Value['h_hp1'] = $hp[0];
			$Value['h_hp2'] = (isset($hp[1]))? $hp[1] : null;
			$Value['h_hp3'] = (isset($hp[2]))? $hp[2] : null;
		}else{
			$Value['h_hp1'] = null;
			$Value['h_hp2'] = null;
			$Value['h_hp3'] = null;
		}
	}else{
		$token = new_token($Board['board_id']);

		$mode = "newData";


	}
?>
<? include "../include/_header.inc.php"; ?>

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
<h3 class="page-title"><?=$PageTitle?></h3>

<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="./?at=dataprocess">
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="Html"  value="Y">

<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="am" value="<?=$mode?>">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width="200"></col>
	<col width="120"></col>
	<col width=""></col>
	<tr>
		<th class="tableth">이름</th>
		<td class="tabletd" colspan="3"><input type="text" name="h_name" maxlength="255" value="<?=$Value[h_name]?>" class="forminput" style="width:120px"></td>
	</tr>
	<tr>
		<th class="tableth">닉네임</th>
		<td class="tabletd"><input type="text" name="h_nick" maxlength="30" value="<?=$Value[h_nick]?>" class="forminput" ></td>
		<th class="tableth">주민등록번호</th>
		<td class="tabletd"><input type="text" name="h_jumin1" maxlength="6" value="<?=$Value[h_jumin1]?>" class="forminput" size="6"> - <input type="text" name="h_jumin2" maxlength="7" value="<?=$Value[h_jumin2]?>" class="forminput" size="7"></td>
	</tr>
	<tr>
		<th class="tableth">아이디</th>
		<td class="tabletd"><input type="text" name="h_id" maxlength="20"  class="forminput" value="<?=$Value[h_id]?>"></td>
		<th class="tableth">비밀번호</th>
		<td class="tabletd"><input type="text" name="h_passwd1" maxlength="20" value="" class="forminput" ></td>
	</tr>
	<tr>
		<th class="tableth">휴대폰</th>
		<td class="tabletd" colspan="3"><input type="text" name="h_hp1" maxlength="4" value="<?=$Value[h_hp1]?>" class="forminput" size="4">-<input type="text" name="h_hp2" maxlength="4" value="<?=$Value[h_hp2]?>" class="forminput" size="4">-<input type="text" name="h_hp3" maxlength="4" value="<?=$Value[h_hp3]?>" class="forminput" size="4"></td>
	</tr>
	<tr>
		<th class="tableth">전화번호</th>
		<td class="tabletd"><input type="text" name="h_tel1" maxlength="4" value="<?=$Value[h_tel1]?>" class="forminput" size="4">-<input type="text" name="h_tel2" maxlength="4" value="<?=$Value[h_tel2]?>" class="forminput" size="4">-<input type="text" name="h_tel3" maxlength="4" value="<?=$Value[h_tel3]?>" class="forminput" size="4"></td>
		<th class="tableth">팩스번호</th>
		<td class="tabletd"><input type="text" name="h_fax1" maxlength="4" value="<?=$Value[h_fax1]?>" class="forminput" size="4">-<input type="text" name="h_fax2" maxlength="4" value="<?=$Value[h_fax2]?>" class="forminput" size="4">-<input type="text" name="h_fax3" maxlength="4" value="<?=$Value[h_fax3]?>" class="forminput" size="4"></td>
	</tr>
	<tr>
		<th class="tableth">이메일</th>
		<td class="tabletd" colspan="3"><input type="text" name="h_email1" maxlength="50" value="<?=$Value[h_email1]?>" class="forminput" >@<input type="text" name="h_email2" maxlength="50" value="<?=$Value[h_email2]?>" class="forminput" >
		<input type="checkbox" name="h_emailyn" value="Y" <? if($Value[h_emailyn] == "Y") echo "checked"; ?>> 이메일 수신동의
		</td>
	</tr>
	<tr>
		<th class="tableth">우편번호</th>
		<td class="tabletd" colspan="3"><input type="text" name="h_zip1" maxlength="3" value="<?=$Value[h_zip1]?>" class="forminput" size="3"> - <input type="text" name="h_zip2" maxlength="3" value="<?=$Value[h_zip2]?>" class="forminput" size="3"></td>
	</tr>
	<tr>
		<th class="tableth">주소</th>
		<td class="tabletd" colspan="3"><input type="text" name="h_addr1" maxlength="100" value="<?=$Value[h_addr1]?>" class="forminput" style="width:350px"> <input type="text" name="h_addr2" maxlength="60" value="<?=$Value[h_addr2]?>" class="forminput" style="width:200px"> </td>
	</tr>
	<tr>
		<th class="tableth">회원레벨</th>
		<td class="tabletd" colspan="3"><input type="text" name="h_level" maxlength="3" value="<?=$Value[h_level]?>" class="forminput" size="3"> 1: 일반회원, 100: 관리자</td>
	</tr>
	<tfoot>
		<tr>
		<td colspan="4" class="tfoottd_C">
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