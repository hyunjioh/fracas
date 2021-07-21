<?
$_dep = array(7,2);
$_tit = array('멤버십','회원가입');
include_once '../inc/pub.config.php';
include_once PATH.'/inc/common.php';
?>
<script type="text/javascript">

	function frmcheck(){

		var f = document.signupform;

		if(!f.agreement1.checked){
			alert('홈페이지 이용약관에 동의하셔야 합니다.');
			return false;
		}

		if(!f.agreement2.checked){
			alert('개인정보 취급방침에 동의하셔야 합니다.');
			return false;
		}


		if( $.trim($("#m_name").val()) == '' ){
			alert("이름을 입력해 주세요.");
			$("#m_name").select();
			return false;
		}
		if( $.trim($("#m_id").val()) == '' ){
			alert("아이디를 입력해 주세요.");
			$("#m_id").select();
			return false;
		}
		if( $.trim($("#idDuplicateYn").val()) != 'Y' ){
			alert("아이디 중복확인이 되지 않았습니다.");
			$("#m_id").select();
			return false;
		}
		if( $.trim($("#m_passwd1").val()) == '' ){
			alert("비밀번호를 입력해 주세요.");
			$("#m_passwd1").select();
			return false;
		}
		if( $.trim($("#m_passwd1").val()).length < 8 || $.trim($("#m_passwd1").val()).length > 15 ){
			alert("비밀번호는 8~15자리 입니다.");
			$("#m_passwd1").select();
			return false;
		}
/*
		if(isInputCheckText($.trim($("#m_passwd1").val()))){
			alert("영문 대/소문자, 숫자, 특수문자 중 3가지 이상을 조합하세요.");
			$("#m_passwd1").select();
			return false;
		}
*/
		if( $.trim($("#m_passwd2").val()) == '' ){
			alert("비밀번호를 다시한번 입력해 주세요.");
			$("#m_passwd2").select();
			return false;
		}
		if( $.trim($("#m_passwd1").val()) != $.trim($("#m_passwd2").val())   ){
			alert("비밀번호가 서로 같지 않습니다.\n\n다시 입력하여 주세요.");
			$("#m_passwd2").select();
			return false;
		}
		if( $.trim($("#m_email").val()) == '' ){
			alert("이메일을 입력해 주세요.");
			$("#m_email").select();
			return false;
		}
		if( $.trim($("#emailDuplicateYn").val()) != 'Y' ){
			alert("이메일 중복확인이 되지 않았습니다.");
			$("#m_email").select();
			return false;
		}
	
		if( $.trim($("#m_hp2").val()) == '' ){
			alert("전화번호를 입력해 주세요.");
			$("#m_hp2").select();
			return false;
		}
		if( $.trim($("#m_hp3").val()) == '' ){
			alert("전화번호를 입력해 주세요.");
			$("#m_hp3").select();
			return false;
		}

		if( $("input[name=m_email_chk]").val() != "2"  ){
			alert("이메일 [가입확인 및 인증번호받기] 버튼을 클릭하세요.");
			return false;
		}
		if( $("input[name=m_email_chk02]").val() != "2"  ){
			alert("이메일인증 [인증확인] 버튼을 클릭하세요.");
			return false;
		}
		  return true;

		}


	// 아이디 중복 체크
	function checkId(arg){

		var f = document.signupform;

			if(!checkCode(arg)){

				$('#commentId').html("* 한글 및 특수문자, 공백은 넣을 수 없습니다.");
				f.m_id.value = "";
				f.m_id.focus();
				f.idDuplicateYn.value = "N";
				return false;

			} else if(arg.length < 6 || arg.length > 12){

				$('#commentId').html("* 아이디는 <em class='hColor1'>6자 이상, 12자 이하로 작성</em>해주세요.");
				f.m_id.focus();
				f.idDuplicateYn.value = "N";
				return false;

			} else{

				$.ajax({
					cache:false,
					async:false,
					type: "POST",
					data: "m_id=" + arg,
					url: "/_core/act/?at=checkid",
					success: function(data) {
						if(data != null) {

							if(data != "true"){
								$('#commentId').html("* <em class='hColor1'>이미 사용중인 아이디</em>입니다.");
								f.idDuplicateYn.value = "N";
							} else{
								$('#commentId').html("* <font color='blue'>사용 가능한 아이디</font>입니다.");
								f.idDuplicateYn.value = "Y";
							}

						} // end if
					}// success
				});

			} // end if

	}

	// 이메일 중복 체크
	function checkEmail(arg){

		var f = document.signupform;

				var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;   
				if(regex.test(arg) === false) {

					$('#commentEmail').html("* 이메일 주소를 정확히 입력해주세요.");
					f.m_email.focus();
					f.emailDuplicateYn.value = "N";
					return false;

				} else{

				$.ajax({
					cache:false,
					async:false,
					type: "POST",
					data: "m_email=" + arg,
					url: "/_core/act/?at=checkemail",
					success: function(data) {
						if(data != null) {

							if(data != "true"){
								$('#commentEmail').html("* <em class='hColor1'>이미 사용중인 이메일 주소</em>입니다.");
								f.emailDuplicateYn.value = "N";
							} else{
								$('#commentEmail').html("* <font color='blue'>사용 가능한 이메일 주소</font>입니다.");
								f.emailDuplicateYn.value = "Y";
							}

						} // end if
					}// success
				});

			} // end if

	}

	// 가입확인 및 인증번호받기
	function regCheckEmail02(){

		var val = jQuery.trim($("input[name=m_email]").val());
		if(!isValidEmail(val)){
	//		chkmessage(obj, false, "<font color='red'>이메일이 잘못된 형식입니다.</font>");
			message("이메일이 잘못된 형식입니다.");
			$("input[name=m_email]").focus();
			return false;
		}

		if(jQuery.trim($("input[name=m_email]").val())==""){
			message("이메일 주소를 입력 하세요.");
			$("input[name=m_email]").focus();
			return false;
		}

		result = "";
	   $.ajax({
			cache:false,
			async:false,
			type: "POST",
					dataType : "json",
			data: {"val":val, "rt":"json"},
			url: "<?=_CORE_?>/act/?at=checkemail02",
				success: function(msg) {
					result = msg;

					if(result==true){
						$("input[name=m_email_chk]").val('2');
						$("input[name=m_email_chk02]").val('0');
						$("input[name=m_email]").attr("readonly",true);
						$("input[name=email_chk]").attr("readonly",false);
						alert("입력하신 이메일주소로 인증번호가 발송되었습니다.");
					} else{
						alert("사용중인 이메일 입니다. \n다른 이메일주소를 입력하세요.");
					}
				}
			});
	}
	// 이메일인증확인
	function regCheckEmail03(){

		if( $("input[name=m_email_chk02]").val() == "2"  ){
			alert("이메일인증이 이미 완료되었습니다.");
			return false;
		}

		var val = jQuery.trim($("input[name=m_email]").val());
		if(!isValidEmail(val)){
	//		chkmessage(obj, false, "<font color='red'>이메일이 잘못된 형식입니다.</font>");
			message("이메일이 잘못된 형식입니다.");
			$("input[name=m_email]").focus();
			return false;
		}
		var num = jQuery.trim($("input[name=email_chk]").val());
		if(num == ""){
				message("인증번호를 입력해주세요.");
				$("input[name=email_chk]").focus();
				return false;		
		}

		result = "";
	   $.ajax({
			cache:false,
			async:false,
			type: "POST",
					dataType : "json",
			data: {"val":val,"num":num, "rt":"json"},
			url: "<?=_CORE_?>/act/?at=checkemail03",
				success: function(msg) {
					result = msg;

					if(result==true){
						$("input[name=m_email_chk02]").val('2');
						$("input[name=email_chk]").attr("readonly",true);
						alert("이메일인증이 완료되었습니다.");
					} else{
						$("input[name=m_email_chk02]").val('0');
						alert("인증번호를 확인하세요.");
					}
				}
			});
	}
	// 이메일인증번호 - 재전송
	function regCheckEmail04(){

		if( $("input[name=m_email_chk02]").val() != "2"  ){
			alert("먼저 이메일인증 [인증확인] 버튼을 클릭하세요.");
			return false;
		}

		var val = jQuery.trim($("input[name=m_email]").val());
		if(!isValidEmail(val)){
	//		chkmessage(obj, false, "<font color='red'>이메일이 잘못된 형식입니다.</font>");
			message("이메일이 잘못된 형식입니다.");
			$("input[name=m_email]").focus();
			return false;
		}

		result = "";
	   $.ajax({
			cache:false,
			async:false,
			type: "POST",
					dataType : "json",
			data: {"val":val, "rt":"json"},
			url: "<?=_CORE_?>/act/?at=checkemail04",
				success: function(msg) {
					result = msg;

					if(result==true){
						alert("인증번호가 재전송되었습니다.");
					} else{
						alert("관리자에게 문의하세요.");
					}
				}
			});
	}
	function isValidEmail(mail){
		return true;
	/* fix.
	  var t = escape(mail);
	  if(t.match(/^(\w+)@(\w+)[.](\w+)$/ig) == null && t.match(/^(\w+)@(\w+)[.](\w+)[.](\w+)$/ig) == null){
		return false;
	  } else {
		return true;
	  }
	*/
	}
	function message(msg){
	//	$('.popup_style').hide();
	//	$('.popup,.st18').fadeIn('fast').find("#popup_msg").html(msg);
		alert(msg);
		return false;
	}

	// 영문+숫자 only
	function checkCode(arg){

	 for(var i = 0; i < arg.length; i++){

		var k = arg.charCodeAt(i);
		if(!(k > 96 && k < 123 || k > 64 && k < 91 || k > 47 && k < 58)){
		 return false;}
	 }
	 return true;
	}

	// number only
	function checkNumber(){
		var objEv = event.srcElement;
		var numPattern = /([^0-9])/;
		numPattern = objEv.value.match(numPattern);
		if(numPattern != null){
			alert("숫자만 입력해 주세요 ! ");
			objEv.value="";
			objEv.focus();
			return false;
		}
	}

// 영문 대/소문자 숫자 특수문자 체크
 function isInputCheckText(text){
	var s = (isCase(text));
	var s_1  = s.split("/");
	if(s_1[0]>0)s_1[0] = 1;
	if(s_1[1]>0)s_1[1] = 1;
	if(s_1[2]>0)s_1[2] = 1;
	if(s_1[3]>0)s_1[3] = 1;
	if(  (    parseInt(s_1[0]) + parseInt(s_1[1]) + parseInt(s_1[2]) + parseInt(s_1[3])   )  < 3){
	 return true;
	}else{
	 return false;
	}
 }

	// 영문자검사  대문자/ 소문자/ 숫자
	function isCase(input){
		var chars1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var chars2 = "abcdefghijklmnopqrstuvwxyz";
		var chars3 = "0123456789";
		var chars4 = "'`!@#$%^&*()-=~_+\|,./<>?;:\"[]{}";
		return containsChar(input, chars1,chars2,chars3,chars4);
	}

	function containsChar(input,chars1,chars2,chars3,chars4){
		var cnt1 = 0;
		var cnt2 = 0;
		var cnt3 = 0;
		var cnt4 = 0;
		for(var inx=0; inx < input.length;inx++){
		 if(chars1.indexOf(input.charAt(inx))!= -1){
			cnt1++;
		 }
		 if(chars2.indexOf(input.charAt(inx))!= -1){
			cnt2++;
		 }
		 if(chars3.indexOf(input.charAt(inx))!= -1){
			cnt3++;
		 }
		 if(chars4.indexOf(input.charAt(inx))!= -1){
			cnt4++;
		 }
		}
		return (cnt1+"/"+cnt2+"/"+cnt3+"/"+cnt4);
	}

</script>
</head>
<body>
<div id="wrap" class="sub sub<?=$_dep[0];?> sub<?=$_dep[0].$_dep[1];?>">
	<?include_once PATH.'/inc/head.php';?>
	<div id="svis">
		<h2><?=$_tit[0]?></h2>
	</div>
	<div id="sub">
		<div class="inner">
			<div id="tit">
				<h3><?=end($_tit);?></h3>
			</div>
			<div id="content">

			<form name="signupform" id="signupform" method="post" action="<?=_CORE_?>/act/?at=join" onsubmit="return frmcheck();"  >
				<input type="hidden" name="_referer_" value="<?=$req['ref']?>">
				<input type="hidden" name="return_url" value="<?=_THIS_URI_?>/login.php">
				<input type="hidden" name="am" value="newData">
				<input type="hidden" name="m_indivi" value="<?=$req['m_indivi']?>">

				<input type="hidden" name="idDuplicateYn" id="idDuplicateYn" value="N">
				<input type="hidden" name="emailDuplicateYn" id="emailDuplicateYn" value="N">

				<input type="hidden" name="m_id_chk" value="">
				<input type="hidden" name="m_email_chk" value="">
				<input type="hidden" name="m_email_chk02" value="">

				<div class="__tit1">
					<h3>이용약관</h3>
				</div>
				<div class="__agree">
					<div class="area">
						<?include_once PATH.'/inc/provision.php';?>
					</div>
					<div class="lab">
						<label>
							<input type="checkbox" name="agreement1">
							이용약관에 동의합니다.
						</label>
					</div>
				</div>

				<div class="__tit1 __mt50">
					<h3>개인정보 수집 및 이용 안내</h3>
				</div>
				<div class="__agree">
					<div class="area">
						<?include_once PATH.'/inc/privacy.php';?>
					</div>
					<div class="lab">
						<label>
							<input type="checkbox" name="agreement2">
							개인정보 수집 및 이용에 대해 동의합니다.
						</label>
					</div>
				</div>

				<div class="__toparea __mt50">
					<div class="__tit1">
						<h3>기본정보</h3>
					</div>
					<div class="rig __txt16 __blue2">
						* 필수정보입력입니다.
					</div>
				</div>

				<table class="__tbl-write">
					<caption>작성</caption>
					<tbody>
						<tr>
							<th scope="row"><span class="impor">아이디</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_id" id="m_id" onkeyup="checkId(this.value);">
								<span class="dib fs_11" id="commentId">* 6~12자의 영문 소문자, 숫자와 특수기호(_) 만 사용할 수 있습니다.</span>
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">비밀번호</span></th>
							<td>
								<input type="password" class="__form1" style="width:300px;" name="m_passwd1" id="m_passwd1">
								<span class="dib fs_11">
									* 영문과 숫자가 최소 하나 이상 포함되어야 하며 8자 이상
								</span>
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">비밀번호 확인</span></th>
							<td>
								<input type="password" class="__form1" style="width:300px;" name="m_passwd2" id="m_passwd2">
								<span class="dib fs_11">* 입력 오류 방지를 위하여 똑같이 한 번 더 입력해 주세요.</span>
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">성명</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_name" id="m_name">
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">성별</span></th>
							<td>
								<label><input type="radio" name="m_sex" value="M"> 남</label>
								<label><input type="radio" name="m_sex" value="F" checked> 여</label>
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">생년월일</span></th>
							<td><!--
								<input type="text" class="__form1 __m-w25p" style="width:120px;"> 년 &nbsp;&nbsp;
								<input type="text" class="__form1 __m-w20p" style="width:70px;"> 월 &nbsp;&nbsp;
								<input type="text" class="__form1 __m-w20p" style="width:70px;"> 일-->
								<select name="m_birth_y">
									<? 
										$today_y = date("Y");
										for($i=$today_y;$i>1920;$i--){ 
									?>
										<option value="<?=$i?>"><?=$i?></option>
									<? } ?>
								</select>년
								<select name="m_birth_m">
									<? 
										for($i=1;$i<13;$i++){ 
											$j = $i;
											if($i<10) $j = "0".$i;
									?>
										<option value="<?=$j?>"><?=$j?></option>
									<? } ?>
								</select>월
								<select name="m_birth_d">
									<? 
										for($i=1;$i<32;$i++){ 
											$j = $i;
											if($i<10) $j = "0".$i;
									?>
										<option value="<?=$j?>"><?=$j?></option>
									<? } ?>
								</select>일
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">E-mail</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_email" id="m_email" onkeyup="checkEmail(this.value);">
								<button type="button" class="__btn1 green" onclick="javascript:regCheckEmail02();">가입확인 및 인증번호 받기</button>
								<span class="dib fs_11" id="commentEmail">* 아이디/패스워드찾기 등에 필요한 정보이니 정확하게 기입해 주세요.</span>
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">E-mail 인증</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="email_chk">
								<button type="button" class="__btn1 gray" onclick="javascript:regCheckEmail03();">인증확인</button>
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">일반전화</span></th>
							<td>
								<ul class="__dtbl" style="max-width:390px;">
									<li class="td"><input type="text" class="__form1" name="m_tel1" id="m_tel1" onchange="javascript:checkNumber();"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_tel2" id="m_tel2" onchange="javascript:checkNumber();"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_tel3" id="m_tel3" onchange="javascript:checkNumber();"></li>
								</ul>
							</td>
						</tr>
						<tr>
							<th scope="row"><span class="impor">휴대폰</span></th>
							<td>
								<ul class="__dtbl" style="max-width:390px;">
									<li class="td"><input type="text" class="__form1" name="m_hp1" id="m_hp1" onchange="javascript:checkNumber();"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_hp2" id="m_hp2" onchange="javascript:checkNumber();"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_hp3" id="m_hp3" onchange="javascript:checkNumber();"></li>
								</ul>
							</td>
						</tr>

<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<!-- script charset="UTF-8" type="text/javascript" src="http://s1.daumcdn.net/svc/attach/U03/cssjs/postcode/1466041074120/160616.js"></script -->
<script>
    function cube_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = ''; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    fullAddr = data.roadAddress;

                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    fullAddr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                if(data.userSelectedType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('cube_postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('m_addr1').value = fullAddr;

                // 커서를 상세주소 필드로 이동한다.
                document.getElementById('m_addr2').focus();
            }
        }).open();
    }
</script>
						<tr>
							<th scope="row"><span class="impor">주소</span></th>
							<td>
								<div>
									<input type="text" class="__form1" style="width:120px;" name="m_zip" id="cube_postcode">
									<a href="javascript:cube_execDaumPostcode();"><button type="button" class="__btn1 black">우편번호 검색</button></a>
								</div>
								<div class="__mt10">
								
									<ul class="__dtbl" style="max-width:800px;">
										<li class="td"><input type="text" class="__form1" name="m_addr1" id="m_addr1"></li>
										<li class="td tac" style="width:5px;"></li>
										<li class="td"><input type="text" class="__form1" name="m_addr2" id="m_addr2"></li>
									</ul>
								</div>
							</td>
						</tr>

					</tbody>
				</table>

				<div class="__botarea">
					<div class="cen">
						<button type="submit" class="__btn2">회원가입</button>
					</div>
				</div>

			</form>

			</div>
		</div>
	</div>
	<?include_once PATH.'/inc/foot.php';?>
</div>
</body>
</html>