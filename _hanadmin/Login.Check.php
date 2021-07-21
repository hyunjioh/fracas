<? 
if(!defined("_administrators_"))exit;

$db = new MySQL;
/*******************************************************************************
 * 변수 체크
 ******************************************************************************/
unset($req);
$req = Array();
$req['memberid']	= Request('userId');
$req['passwd']		= Request('userPw');
$req['save_id']		= Request('save_id');
$req['passwd']		= md5($req['passwd']);


unset($_SESSION['_MANAGER_']['ID']);
unset($_SESSION['_MANAGER_']['LEVEL']);

/*******************************************************************************
 * 인증코드 검증
 ******************************************************************************/
if( isset($_SESSION['security_code']) && isset($_POST['security_code']) 
	&& $_SESSION['security_code'] == $_POST['security_code'] 
	&& !empty($_SESSION['security_code'])   ) {
	// Insert you code for processing the form here, e.g emailing the submission, entering it into a database. 
	unset($_SESSION['security_code']);
} else {
	// Insert your code for showing an error message here
//	toplocationHref(_ADMIN_,'Sorry, you have provided an invalid security code');
}



/*******************************************************************************
 * 로그인
 ******************************************************************************/
$QUERY = sprintf("SELECT * FROM G_Manager WHERE UseYN = 'Y' and AdminID = '%s' AND AdminPW = '%s'  ", $req['memberid'], $req['passwd']);	

$DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
if(is_array($DATA)){

	$_SESSION['_MANAGER_']['ID'] = encrypt_md5($DATA["AdminID"],"sessionADMIN");
	$_SESSION['_MANAGER_']['NAME'] = encrypt_md5($DATA["AdminName"],"sessionADMIN");

	if($req['save_id'] == "Y"){
		setcookie("hanadmin", encrypt_md5($DATA["AdminID"]),0,"/");
	}else{
		setcookie("hanadmin","" ,0,"/");								
	}
	$db -> ExecQuery("Update G_Manager Set LastVisit = '".date("Y-m-d H:i:s")."', VisitCount = VisitCount + 1 Where AdminID = '".$req['memberid']."' ");
	if($req['passwd'] == "fed33392d3a48aa149a87a38b875ba4a"){
		alert("현재비밀번호는 초기비밀번호로 변경하여 사용하시는게 안전합니다.");
	}
	toplocationHref(_ADMIN_);
}else{
	toplocationHref(_ADMIN_,'아이디가 없거나 비밀번호가 맞지 않습니다.');
}

?>