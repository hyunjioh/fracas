<? 
if(!defined("_administrators_"))exit;
if(defined("_is_manager_"))toplocationHref( _ADMIN_ );

$UserID = (isset($_COOKIE['hanadmin']) && !empty($_COOKIE['hanadmin']) )? decrypt_md5($_COOKIE['hanadmin']):null;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title><?=_HOMEPAGE_TITLE_?></title>
<link rel="stylesheet" type="text/css" href="./css/default.css" />

<style type="text/css">
.admin { background:url("./images/bg_admin.jpg") no-repeat 0 160px;  height:436px; width:572px; margin:0 auto; position:relative;}
.admin fieldset { position:absolute; top:290px; left:304px;}
.admin fieldset input { width:155px; height:18px; color:#0066CC; border:1px solid #e4e4e4; background:#f5f4f4; margin-bottom:8px; padding-left:5px;}
.admin .btn { position:absolute; top:289px; left:473px;}
</style>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script language="javascript">
function checkLogin(){
    
    if( $.trim($("#userId").val()) == '' ){
        alert("아이디를 입력해 주세요.");
        $("#userId").focus();
        return;
    }
    if( $.trim($("#userPw").val()) == '' ){
        alert("비밀번호를 입력해 주세요.");
        $("#userPw").focus();
        return;
    }
    // 로그인 프로세스 호출
    $.ajax({
        type: 'post'
        , async: true
        , url: '/member.do?cmd=login'
        , data: $("#frm").serialize() 
        , beforeSend: function() {
             $('#ajax_load_indicator').show().fadeIn('fast'); 
          }
        , success: function(data) {
            var response = data.trim();
            console.log("success forward : "+response);
            // 메세지 할당
            switch(response) {
                case "nomatch": 
                    msg = "아이디 또는 비밀번호가 일치하지 않습니다."; break;
                case "fail": 
                    msg = "로그인에 실패 했습니다."; break;
                default : 
                    msg = "존재하지 않는 사용자입니다."; break;
            }
            // 분기 처리
            if(response=="success"){
                window.location.href = "${targetUrl}";
            } else {
                alert(msg);
            }
          }
        , error: function(data, status, err) {
        	console.log("error forward : "+data);
            alert('서버와의 통신이 실패했습니다.');
          }
        , complete: function() { 
        	$('#ajax_load_indicator').fadeOut();
          }
    });
}

function loginSubmit(){
	if( $.trim($("#userId").val()) == '' ){
			alert("아이디를 입력해 주세요.");
			$("#userId").select();
			return false;
	}
	if( $.trim($("#userPw").val()) == '' ){
			alert("비밀번호를 입력해 주세요.");
			$("#userPw").select();
			return false;
	}
//	if( $.trim($("#security_code").val()) == '' ){
//			alert("보안문자를 입력해 주세요.");
//			$("#security_code").select();
//			return false;
//	}
}
$(document).ready(function($){
	$("#userId").focus();
});




</script>
</head>

<body>
	<form method="POST" name="frm" action="./?at=loginprocess" onsubmit="return loginSubmit();">
<!-- wrapper -->
<div id="bg_none" style="margin:0 auto; width:100%;">
		<!-- contents  -->
		<div class="admin">
			<fieldset>
				<ul>
					<li>
					  <input title="아이디"   type="text"  name="userId" id="userId" maxlength="16" onkeypress="if (event.keyCode==13) loginSubmit();" tabindex="1" style="ime-mode:disabled;" /></li>
					<li>
					  <input title="패스워드" type="password" name="userPw" id="userPw" maxlength="16" onkeypress="if (event.keyCode==13) loginSubmit();" tabindex="2" /></li>
				</ul>
			</fieldset>
			<span class="btn"><input type="image" src="./images/btn_login.gif" alt="로그인" tabindex="3"/></span>
		</div>
		<!-- //contents -->
	</form>
</div>
<!-- //wrapper -->

</body>
</html>