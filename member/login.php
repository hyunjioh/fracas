<?
$_dep = array(7,1);
$_tit = array('멤버십','로그인');
include_once '../inc/pub.config.php';
include_once PATH.'/inc/common.php';
?>
<?
	// 로그인 체크
    if(!isset($MemberID) || empty($MemberID)){
    } else{
      locationReplace("/");
	}
?>
<script>
$(document).ready(function(){
  if($("input[name=loginid]").val()){
    $("input[name=passwd]").focus();
  }else{
    $("input[name=loginid]").focus();
  }
});
function loginSubmit(){

    if( $.trim($("#loginid").val()) == '' ){
        alert("아이디를 입력해 주세요.");
        $("#loginid").focus();
        return false;
    }
    if( $.trim($("#passwd").val()) == '' ){
        alert("비밀번호를 입력해 주세요.");
        $("#passwd").focus();
        return false;
    }

    var loginidval = "<?=$UserID?>";

    // 로그인 프로세스 호출
    $.ajax({
        type: 'POST'
        , async: true
	      , dataType : "json" //전송받을 데이터의 타입
        , url: '<?=_CORE_?>/act/?at=login&ty=json'
        , data: $("#loginfrm").serialize()
        , beforeSend: function() {

          }
		, success : function(response, status, request) {

			if(response){

                if(response.error == "Y"){
                  alert(response.msg);

                  if(loginidval){
                    $("#passwd").val('').focus();                  
                  }else{
                    $("#passwd").val('');
                    $("#loginid").val('').focus();
                  }
                  return false;
                } else if(response.error == "N"){

						location.href="/";

					return;
                }
			}

          }
        , error: function(request, status, err) {
			alert("error code : " + request.status + "\r\nmessage : " + request.reponseText);
            alert('서버와의 통신이 실패했습니다.');
			return false;
          }
        , complete: function() {
/*
			alert(response.msg);
			location.replace("<?=$req['return_url']?>");
			return false;
*/
          }
    });
		return false;
}

function estimateView(arg){


    $.ajax({
        type: 'POST'
        , async: true
	      , dataType : "json" //전송받을 데이터의 타입
        , url: "/_core/act/?at=loginView"
        , data: "m_id=" + arg
        , beforeSend: function() {

          }
		, success : function(response, status, request) {

			if(response){

				$("#estiCnt").val(response.cnt);
				$("#estiCnt02").val(response.cnt02);

			} // end if
		}// success
	});

}
</script>
</head>
<body>
<div id="wrap" class="sub sub<?=$_dep[0];?> sub<?=$_dep[0].$_dep[1];?>">
	<?include_once PATH.'/inc/head.php';?>
	<?include_once PATH.'/inc/side_nav.php';?>


	<div id="sub">
		<div class="inner">
			
			<div id="content">

				<form class="__login" name="loginform" id="loginfrm" method="post" onsubmit="return loginSubmit();">
					<div class="inner">
						<div class="tit">
							<h3><img src="<?=DIR?>/images/ico-log.gif" alt=""> <span>LOGIN</span></h3>
							<p>홈페이지 방문을 환영합니다!<br/>다양하고 정확한 정보제공을 위해 로그인을 하신 뒤 이용해주세요.</p>
						</div>
					</div>

					<div class="area">
						<div class="form">
							<ul>
								<li class="text"><input type="text" placeholder="아이디" name="loginid" id="loginid"></li>
								<li class="pass"><input type="password" placeholder="비밀번호" name="passwd" id="passwd"></li>
							</ul>
							<button type="submit">로그인</button>
						</div>
						<ul class="link">
							<li><a href="<?=DIR?>/member/find.php">ID/PW찾기</a></li>
							<li><a href="<?=DIR?>/member/join.php">회원가입</a></li>
						</ul>
					</div>
				</form>

			</div>
		</div>
	</div>
	<?include_once PATH.'/inc/foot.php';?>
</div>
</body>
</html>