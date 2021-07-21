<?	if(!defined("_g_board_include_")) exit; ?>
<? include "../include/_header.inc.php"; ?>
<?

		$token = new_token($Board['board_id']);
		/*-------------------------------------------------------------------------------------------------
		▶ 데이터베이스 연결 */	
		unset($db);
		$db = new MySQL;

		$Query = "Select * from G_Member Where h_id = '".$_SESSION['_MEMBER_']['ID']."' ";
		$value  = $db -> SelectOne($Query);



		$jumin = explode("-",$value['h_jumin']);
		if(is_array($jumin)){
			$value['h_jumin1'] = $jumin[0];
			$value['h_jumin2'] = (isset($jumin[1]))? $jumin[1] : null;
		}else{
			$value['h_jumin1'] = null;
			$value['h_jumin2'] = null;
		}

		$zip = explode("-",$value['h_zip']);
		if(is_array($zip)){
			$value['h_zip1'] = $zip[0];
			$value['h_zip2'] = (isset($zip[1]))? $zip[1]: null;
		}else{
			$value['h_zip1'] = null;
			$value['h_zip2'] = null;
		}

		$email = explode("@",$value['h_email']);
		if(is_array($email)){
			$value['h_email1'] = $email[0];
			$value['h_email2'] = (isset($email[1]))? $email[1]: null;
		}else{
			$value['h_email1'] = null;
			$value['h_email2'] = null;
		}

		$tel = explode("-",$value['h_tel']);
		if(is_array($email)){
			$value['h_tel1'] = $tel[0];
			$value['h_tel2'] = (isset($tel[1]))? $tel[1] : null;
			$value['h_tel3'] = (isset($tel[2]))? $tel[2] : null;
		}else{
			$value['h_tel1'] = null;
			$value['h_tel2'] = null;
			$value['h_tel3'] = null;
		}

		$hp = explode("-",$value['h_hp']);
		if(is_array($email)){
			$value['h_hp1'] = $hp[0];
			$value['h_hp2'] = (isset($hp[1]))? $hp[1] : null;
			$value['h_hp3'] = (isset($hp[2]))? $hp[2] : null;
		}else{
			$value['h_hp1'] = null;
			$value['h_hp2'] = null;
			$value['h_hp3'] = null;
		}
?>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
	var f = document.boardform;
	if(!f.m_name.value){
		alert("이름을 입력하세요.");
		f.m_name.focus();
		return false;
	}

	if(f.m_passwd1.value){
			if(f.m_passwd1.value.length < 4 || f.m_passwd1.value.length > 20){
				alert("비밀번호는 4~20자리에 맞게 입력하세요.");
				f.m_passwd1.focus();
				return false;				
			}

			if(f.m_passwd1.value !=  f.m_passwd2.value ){
				alert("비밀번호가 일치하지 않습니다..");
				f.m_passwd1.focus();
				return false;				
			}

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
<input type="hidden" name="am" value="updateData">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width=""></col>
	<tr>
			<th class="tableth">아이디</th>
			<td class="tabletd"><?=$value['h_id'];?></td>
		</tr>
		<tr>
			<th class="tableth">이름</th>
			<td class="tabletd"><input type="text" name="m_name" class="inputText" onFocus="this.className='inputFocus';" onBlur="this.className='inputText';" style="IME-MODE: active;" size="20" value="<?=$value["h_name"]?>"></td>
		</tr>
		<tr>
			<th class="tableth">닉네임</th>
			<td class="tabletd"><input type="text" name="m_nick" class="inputText" onFocus="this.className='inputFocus';" onBlur="this.className='inputText';" style="IME-MODE: active;" size="20" value="<?=$value["h_nick"]?>"></td>
		</tr>
		<tr>
			<th class="tableth">비밀번호</th>
			<td class="tabletd"><input type="password" name="m_passwd1" class="inputText" onFocus="this.className='inputFocus';" onBlur="this.className='inputText';"  size="20" maxlength="20"></td>
		</tr>
		<tr>
			<th class="tableth">비밀번호 확인</th>
			<td class="tabletd"><input type="password" name="m_passwd2" class="inputText" onFocus="this.className='inputFocus';" onBlur="this.className='inputText';"  size="20"></td>
		</tr>
		<tr>
			<th class="tableth">이메일</th>
			<td class="tabletd"><input name="m_email1" type="text" class="inputText" onFocus="this.className='inputFocus';" onBlur="this.className='inputText';" size="18"  style="ime-mode:disabled" value="<?=$value["h_email1"]?>">	@ <input name="m_email2" type="text" class="inputText" onFocus="this.className='inputFocus';" onBlur="this.className='inputText';" size="18" disabled value="<?=$value["h_email2"]?>">
			<select name="m_email3" onChange="onChangeEmail(hform.m_email1, hform.m_email2, hform.m_email3);" >	
			<option value="">기타[직접입력] </option>
			<?
				foreach($config['email_list'] as $email_key => $email_value){
					echo "<option value='".$email_value."' ".Selected($email_value, $value["h_email2"]).">".$email_value."</option>".ENTER; 
				}
			?>
			</select>			
			</td>
		</tr>
	<tfoot>
		<tr>
		<td colspan="2" class="tfoottd_C">
		<input type="image" src="<?=_ADMIN_?>/images/board/btn_confirm.gif" align="middle">
		</td>
		</tr>
	</tfoot>
</table>
</form>


</div>
<div id="copyright"></div>












</div>
<? include "../include/_footer.inc.php"; ?>
