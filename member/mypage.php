<?
$_dep = array(7,4);
$_tit = array('마이페이지','내정보');
include_once '../inc/pub.config.php';
include_once PATH.'/inc/common.php';
?>
<?
	// 로그인 체크
    if(!isset($MemberID) || empty($MemberID)){
      locationReplace("/");
    }

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

	$memInfo = $db -> SelectOne("Select * from G_Member where m_id = '".$MemberID."'");
	switch($memInfo['m_sex']){
	  case "M": $memInfo['m_sex'] = "남성"; break;
	  case "F": $memInfo['m_sex'] = "여성"; break;
	}

	$m_hp = explode("-",$memInfo['m_hp']);
	$m_tel = explode("-",$memInfo['m_tel']);
?>
<script type="text/javascript">

	function frmcheck(){

		var f = document.signupform;

		if( $.trim($("#m_passwd1").val()) != '' ){

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

		}

		if( $.trim($("#m_hp2").val()) == '' ){
			alert("휴대폰를 입력해 주세요.");
			$("#m_hp2").select();
			return false;
		}
		if( $.trim($("#m_hp3").val()) == '' ){
			alert("휴대폰를 입력해 주세요.");
			$("#m_hp3").select();
			return false;
		}

		  return true;

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
</script>
</head>
<body>
<div id="wrap" class="sub sub<?=$_dep[0];?> sub<?=$_dep[0].$_dep[1];?>">
	<?include_once PATH.'/inc/head.php';?>
	<div id="svis">
		<h2><?=$_tit[0]?></h2>
	</div>
	<div id="snb">
		<div class="inner">
			<ul class="menu">
				<li class="active"><a href="./mypage.php"><span>내정보</span></a></li>
				<li class="" ><a href="./class.php"><span>수강신청내역</span></a></li>
			</ul>
		</div>
	</div>

	<div id="sub">
		<div class="inner">
			<div id="tit">
				<h3><?=end($_tit);?></h3>
			</div>
			<div id="content">

			<form name="signupform" id="signupform" method="post" action="<?=_CORE_?>/act/?at=myinfo" onsubmit="return frmcheck();"  >
				<input type="hidden" name="_referer_" value="<?=$req['ref']?>">
				<input type="hidden" name="return_url" value="<?=$_SERVER['PHP_SELF']?>">
				<input type="hidden" name="am" value="newData">
				<input type="hidden" name="m_indivi" value="<?=$req['m_indivi']?>">

				<table class="__tbl-write">
					<caption>작성</caption>
					<tbody>
						<tr>
							<th scope="row"><span>아이디</span></th>
							<td><?=$MemberID?></td>
						</tr>
						<tr>
							<th scope="row"><span>비밀번호</span></th>
							<td>
								<input type="password" class="__form1" style="width:300px;" name="m_passwd1" id="m_passwd1">
								<span class="dib">
									* 비밀번호를 변경하실 경우, 입력하세요.
								</span>
							</td>
						</tr>
						<tr>
							<th scope="row"><span>비밀번호 확인</span></th>
							<td>
								<input type="password" class="__form1" style="width:300px;" name="m_passwd2" id="m_passwd2">
							</td>
						</tr>
						<tr>
							<th scope="row"><span>성명</span></th>
							<td>
								<?=$MemberName?>
							</td>
						</tr>
						<tr>
							<th scope="row"><span>성별</span></th>
							<td><?=$memInfo['m_sex']?></td>
						</tr>
						<tr>
							<th scope="row"><span>생년월일</span></th>
							<td><?=$memInfo['m_birthday']?></td>
						</tr>
						<tr>
							<th scope="row"><span>E-mail</span></th>
							<td><?=$memInfo['m_email']?></td>
						</tr>
						<tr>
							<th scope="row"><span>일반전화</span></th>
							<td>
								<ul class="__dtbl" style="max-width:390px;">
									<li class="td"><input type="text" class="__form1" name="m_tel1" id="m_tel1" onchange="javascript:checkNumber();" value="<?=$m_hp[0]?>"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_tel2" id="m_tel2" onchange="javascript:checkNumber();" value="<?=$m_hp[1]?>"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_tel3" id="m_tel3" onchange="javascript:checkNumber();" value="<?=$m_hp[2]?>"></li>
								</ul>
							</td>
						</tr>
						<tr>
							<th scope="row"><span>휴대폰</span></th>
							<td>
								<ul class="__dtbl" style="max-width:390px;">
									<li class="td"><input type="text" class="__form1" name="m_hp1" id="m_hp1" onchange="javascript:checkNumber();" value="<?=$m_tel[0]?>"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_hp2" id="m_hp2" onchange="javascript:checkNumber();" value="<?=$m_tel[1]?>"></li>
									<li class="td tac" style="width:15px;">-</li>
									<li class="td"><input type="text" class="__form1" name="m_hp3" id="m_hp3" onchange="javascript:checkNumber();" value="<?=$m_tel[2]?>"></li>
								</ul>
							</td>
						</tr>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script charset="UTF-8" type="text/javascript" src="http://s1.daumcdn.net/svc/attach/U03/cssjs/postcode/1466041074120/160616.js"></script>
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
									<input type="text" class="__form1" style="width:120px;" name="m_zip" id="cube_postcode" value="<?=$memInfo['m_zip']?>">
									<a href="javascript:cube_execDaumPostcode();"><button type="button" class="__btn1 black">우편번호 검색</button></a>
								</div>
								<div class="__mt10">
								
									<ul class="__dtbl" style="max-width:800px;">
										<li class="td"><input type="text" class="__form1" name="m_addr1" id="m_addr1" value="<?=$memInfo['m_addr1']?>"></li>
										<li class="td tac" style="width:5px;"></li>
										<li class="td"><input type="text" class="__form1" name="m_addr2" id="m_addr2" value="<?=$memInfo['m_addr2']?>"></li>
									</ul>
								</div>
							</td>
						</tr>

					</tbody>
				</table>

				<div class="__botarea">
					<div class="cen">
						<button type="submit" class="__btn2">내정보 수정</button>
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