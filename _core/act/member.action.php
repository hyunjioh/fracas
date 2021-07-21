<?php
if(!defined("_hannet_included")) exit;
if(!defined("_act_include")) exit;

if($req['mode']){
switch($req['mode']):



/*******************************************************************************
 *
 * 로그아웃
 *
 ******************************************************************************/
case "Logout":
	@session_start();
	if(count($_SESSION)){
		foreach($_SESSION as $key => $value){
			$_SESSION[$key] = null;
			unset($_SESSION[$key]);
		}
	}
	$_SESSION['_MEMBER_']['ID']    = null;
	$_SESSION['_MEMBER_']['NAME']    = null;
	$_SESSION['_TEMP_']['BASIC'] = null;
	toplocationReplace($req['_referer_']);
break;





/*******************************************************************************
 *
 * 로그인
 *
 ******************************************************************************/
case "Login":
	$req['memberid']	= Request('loginid');
	$req['passwd']		= Request('passwd');
	$req['save_login']= Request('save_login');
	$req['passwd']		= md5($req['passwd']);

	if(!$req['_referer_']) $req['_referer_'] = "/";

	if(count($_SESSION)){
		foreach($_SESSION as $key => $value){
			unset($_SESSION['$key']);
		}
	}
	$_SESSION['_MEMBER_']['ID']    = null;
	$_SESSION['_MEMBER_']['NAME']    = null;
	$_SESSION['_TEMP_']['BASIC'] = null;
	$_SESSION['_MEMBER_']['EDIT']    = null;
	$_SESSION['_MEMBER_']['EMAIL']    = null;

	$QUERY = sprintf("SELECT m_id  FROM  G_Member WHERE m_id = '%s' and m_status in ('normal','break') ", $req['memberid']);
	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.


	$QUERY = sprintf("SELECT m_id, m_name, m_nick, m_num, m_email   FROM  G_Member WHERE m_id = '%s' and m_passwd = '%s' and m_status in ('normal','break') ", $req['memberid'], $req['passwd']);
	$DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.

	if(is_array($DATA)){
		//$QUERY = sprintf("SELECT s_Photo_01  FROM  G_Member_Sub WHERE MemberNo = '%s' ", $DATA['g_UserNum']);
		//$SUB = $db -> SelectOne($QUERY); // 데이터를 가져온다.

		$_SESSION['_MEMBER_']['ID']   = encrypt_md5($DATA['m_id'],"session");
		$_SESSION['_MEMBER_']['NAME'] = encrypt_md5($DATA['m_name'],"session");
		$_SESSION['_MEMBER_']['EMAIL'] = $DATA['m_email'];

		if($SUB){
			//setcookie("prothumb",$SUB['s_Photo_01'] ,0,"/");
		}

		if($req['save_login'] == "Y"){
			setcookie("userid", encrypt_md5($DATA["m_id"],"cookie"),time()+86400*30,"/");
		}else{
			setcookie("userid","" ,0,"/");
		}
		$db -> ExecQuery("Update G_Member Set m_lastVisit = '".$date."', m_visit = m_visit + 1, m_visitIP = '".ip_addr()."' Where m_id = '".$req['memberid']."' ");
		//$db -> ExecQuery("Update G__Log_Basic Set mid = '".$DATA["m_id"]."' Where sid = '".session_id()."' ");
		if($_GET['ty'] == "json"){
			$json['error'] = "N";
		}else{
			toplocationHref($req['return_url']);
		}
	}else{
		if($CHECK){
			$msg = "아이디 또는 비밀번호가 잘못입력되었습니다.";
			if($_GET['ty'] == "json"){
				$json['error'] = "Y";
				$json['msg']   = $msg;
			}else{
				toplocationHref($req[_referer_],$msg);
			}
		}else{
			$msg = "아이디 또는 비밀번호가 잘못입력되었습니다.";
			if($_GET['ty'] == "json"){
				$json['error'] = "Y";
				$json['msg']   = $msg;
			}else{
				toplocationHref($req[_referer_],$msg);
			}
		}
	}
	if($_GET['ty'] == "json"){
		echo json_encode($json);
	}
break;



/*******************************************************************************
 *
 * 아이디 중복체크
 *
 ******************************************************************************/
case "CheckID":
	$req['m_id']	= Request('m_id');
	$QUERY = sprintf("SELECT m_id  FROM  G_Member WHERE m_id = '%s' and m_status in ('normal','break') ", $req['m_id']);
	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.
  if($CHECK) $json = false;
  else $json = true;
  echo json_encode($json);
break;


/*******************************************************************************
 *
 * 이메일 중복체크
 *
 ******************************************************************************/
case "CheckEmail":
	$req['m_email']	= Request('m_email');
	$req['m_num']	  = Request('m_num');
  if($MemberID){
  	$QUERY = sprintf("SELECT m_email  FROM  G_Member WHERE m_email = '%s' and m_status in ('normal','break') and m_id <> '%s' ", $req['m_email'], $MemberID);
  }else{
  	$QUERY = sprintf("SELECT m_email  FROM  G_Member WHERE m_email = '%s' and m_status in ('normal','break') ", $req['m_email']);
  }
	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.
  if($CHECK) $json = false;
  else $json = true;
  echo json_encode($json);
break;

/*******************************************************************************
 *
 * 이메일 중복검사 및 인증번호 발송
 *
 ******************************************************************************/
case "CheckEmail02":

	$req['m_email']	= Request('val');
	// 회원 구분 - 일반
	$m_level = 1;
	$m_status = "temp";

	$QUERY = sprintf("SELECT m_email  FROM  G_Member WHERE m_email = '%s' and m_status not in ('temp') ", $req['m_email']);
	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.

	if($CHECK){
		$response = false;
	} else{

		// 데이터베이스 입력
		$XID = XID();
		$XID = substr($XID,0,5);
		$Field = array(
		"m_linkCode" => $XID,

		"m_level"    => $m_level,
		"m_status"    => $m_status,
		"m_email" => $req['m_email'],
			
		);
		$Field['m_regIP']   = ip_addr();
		$Field['m_regDate'] = $dateTime;
		$Field['m_visitIP']   = ip_addr();
		$Field['m_lastVisit'] = $dateTime;

		$Query = "INSERT INTO G_Member (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
		$RESULT = $db->ExecQuery($Query);
		if($RESULT > 0){

			// 인증번호 메일 발송
			$header = "From:webmaster@kcgu.ac.kr\n";
			$header .= "Content-type:text/html;\n";    // 텍스트 타입 설정 (text/html 형식 사용)

			$subject = "[한국상담대학원대학교 상담학아카데미] 회원가입을 위한 이메일인증 정보입니다. (".date("Y-m-d H:i:s").")"; 
			$subject = "=?UTF-8?B?".base64_encode($subject)."?="; 

			$mail_body = "<br />안녕하세요.";
			$mail_body .= "<br />저희 사이트를 이용해주셔서 진심으로  감사드립니다.";

			$mail_body .= "<br /><br />고객님의 이메일인증 번호는 <strong>$XID</strong> 입니다.";
//			$mail_body .= "<br><br><strong>“대한민국은 아침을 거르지 않습니다. 신명나는 우리먹거리 얼쑤 !”</strong>";
//			$mail_body .= "<br /><br /><strong>Rchips</strong> 로그인하기 ☞ <a href='http://kcgu.ac.kr/' target='_blank'>http://kcgu.ac.kr/</a>";
			$mail_body .= "<br /><br />본 메일은 발신전용입니다. 문의 사항이 있으시면 상담 및 문의전화를 이용해 주세요.";
			$mail_body .= "<br />상담시간 : 월~금 오전 9시 - 오후 6시<br />
						상담 및 문의전화    ☎ 02-584-6863 <br />
							Copyright  2019 한국상담대학원대학교 All Right Reserved.<br />";

//			$mail_body = mb_convert_encoding($mail_body,"EUC-KR","UTF-8");
			$mail_body = iconv( mb_detect_encoding( $mail_body ), 'utf-8', $mail_body);

			$email_ok = mail($req['m_email'], $subject, $mail_body, $header);

			$response = true;
		}else{
			$response = false;
		}

		echo json_encode($response);

	}

break;

/*******************************************************************************
 *
 * 이메일 - 인증번호 확인
 *
 ******************************************************************************/
case "CheckEmail03":
	$req['m_email']	= Request('val');
	$req['m_linkCode']	= Request('num');
	$m_status = "temp";

	$QUERY = sprintf("SELECT m_email  FROM  G_Member WHERE m_email = '%s' and m_status = '".$m_status."' and m_linkCode = '%s' order by m_idx desc limit 1 ", $req['m_email'], $req['m_linkCode']);
	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.
  if(!$CHECK) $response = false;
  else $response = true;

	echo json_encode($response);

break;

/*******************************************************************************
 *
 * 이메일 - 인증번호 재전송
 *
 ******************************************************************************/
case "CheckEmail04":

	$req['m_email']	= Request('val');
	$m_status = "temp";

	$QUERY = sprintf("SELECT m_linkCode FROM  G_Member WHERE m_email = '%s' and m_status = '".$m_status."' order by m_idx desc limit 1 ", $req['m_email']);
	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.

	if(!$CHECK){
		$response = false;
	} else{

		// 인증번호 메일 발송
		$header = "From:webmaster@kcgu.ac.kr\n";
		$header .= "Content-type:text/html;\n";    // 텍스트 타입 설정 (text/html 형식 사용)

		$subject = "[한국상담대학원대학교 상담학아카데미] 회원가입을 위한 이메일인증 정보입니다. (".date("Y-m-d H:i:s").")"; 
		$subject = "=?UTF-8?B?".base64_encode($subject)."?="; 

		$mail_body = "<br />안녕하세요.";
//		$mail_body .= "<br />Rchips 관리자 입니다.";
		$mail_body .= "<br />저희 사이트를 이용해주셔서 진심으로  감사드립니다.";

		$mail_body .= "<br /><br />고객님의 이메일인증 번호는 <span>".$CHECK['m_linkCode']."</span> 는 입니다.";
//			$mail_body .= "<br><br><strong>“대한민국은 아침을 거르지 않습니다. 신명나는 우리먹거리 얼쑤 !”</strong>";
			$mail_body .= "<br /><br />본 메일은 발신전용입니다. 문의 사항이 있으시면 상담 및 문의전화를 이용해 주세요.";
			$mail_body .= "<br />상담시간 : 월~금 오전 9시 - 오후 6시<br />
						상담 및 문의전화    ☎ 02-584-6863 <br />
							Copyright  2019 한국상담대학원대학교 All Right Reserved.<br />";

		$mail_body = mb_convert_encoding($mail_body,"EUC-KR","UTF-8");
		$email_ok = mail($req['m_email'], $subject, $mail_body, $header);

		$response = true;
	}

	echo json_encode($response);

break;

/*******************************************************************************
 *
 * 회원가입
 *
 ******************************************************************************/
case "JoinMember":
  // 필수값
  unset($RequiredField);
  $RequiredField = array(
	"m_name",
    "m_id",
    "m_passwd1",
    "m_passwd2",
    "m_email",
    "m_hp1",
    "m_hp2",
    "m_hp3",
  );

  // 변수 담기
/*
	$req['authroot']	= Request('authroot');
	$req['namecheck']	= Request('namecheck');
	$req['m_hash']	  = Request('m_hash');
	$req['m_birth']	  = Request('m_birth');
	$req['m_sex']	    = Request('m_sex');
*/
//	$req['m_indivi']	  = Request('m_indivi');
	$req['m_name']	  = Request('m_name');
	$req['m_id']	    = Request('m_id');
	$req['m_passwd1']	= Request('m_passwd1');
	$req['m_passwd2']	= Request('m_passwd2');
	$req['m_email']	  = Request('m_email');

	$req['m_sex']	    = Request('m_sex');

	$req['m_birth_y']	    = Request('m_birth_y');
	$req['m_birth_m']	    = Request('m_birth_m');
	$req['m_birth_d']	    = Request('m_birth_d');

	$req['m_tel1']	  = Request('m_tel1');
	$req['m_tel2']	  = Request('m_tel2');
	$req['m_tel3']	  = Request('m_tel3');

	$req['m_hp1']	    = Request('m_hp1');
	$req['m_hp2']	    = Request('m_hp2');
	$req['m_hp3']	    = Request('m_hp3');

	$req['m_zip']	    = Request('m_zip');
	$req['m_addr1']	  = Request('m_addr1');
	$req['m_addr2']	  = Request('m_addr2');

	$XID	= Request('email_chk');
	$m_status = "normal";


	$req['m_job1']	    = Request('m_job1');
	$req['m_job2']	    = Request('m_job2');
	$req['m_major']	    = Request('m_major');

	$req['m_hospital1']	    = Request('m_hospital1');	
	$req['m_hospital2']	    = Request('m_hospital2');	
	$req['m_hospital_etc']	    = Request('m_hospital_etc');	

	$req['m_company']	    = $req['m_hospital1'];
	$req['m_position']	    = $req['m_hospital2'];
	$req['m_position02']	    = $req['m_hospital_etc'];

	$req['m_department']	    = Request('m_department');
	$req['m_bizNum']	    = Request('m_bizNum');
	$req['m_bizNum02']	    = Request('m_bizNum02');
	if($req['m_bizNum']==""){
		$req['m_bizNum'] = $req['m_bizNum02'];
	}



  foreach($RequiredField as $k => $v){
    // 필수값누락
    if(!isset($req[$v]) || empty($req[$v])){
  		historyBack("필수 입력값 누락입니다.");
      break;
    }
  }

  // 비밀번호 다름
  if($req['m_passwd1'] != $req['m_passwd2']){
		historyBack("비밀번호를 확인해 주세요.");
  }

  // 아이디 오류
  if(strlen($req['m_id']) < 6 || strlen($req['m_id']) > 12){
	  historyBack("아이디를 확인해 주세요.");
//	  toplocationHref($req['_referer_']);
  }

  // 아이디 중복체크
	if( $db -> SelectOne("Select * from G_Member Where m_status not in ('temp') and m_id = '".$req['m_id']."' ") ){
		historyBack("등록된 아이디 입니다.");
	}
  // 이메일 중복체크
	if( $db -> SelectOne("Select * from G_Member Where m_status not in ('temp') and m_email = '".$req['m_email']."' ") ){
		historyBack("등록된 이메일 입니다.");
	}



  // 가공되는 변수
  $req['m_passwd'] = md5($req['m_passwd1']);
  $req['m_hp']   = $req['m_hp1']."-".$req['m_hp2']."-".$req['m_hp3'];
  $req['m_tel']   = $req['m_tel1']."-".$req['m_tel2']."-".$req['m_tel3'];
  $req['m_birth']   = $req['m_birth_y']."-".$req['m_birth_m']."-".$req['m_birth_d'];


  // 데이터베이스 입력
  $Field = array(
    "m_name"     => $req['m_name'],
    "m_id"       => $req['m_id'],
    "m_passwd"   => $req['m_passwd'],
    "m_sex"      => $req['m_sex'],
    "m_birthday"      => $req['m_birth'],
    "m_email"    => $req['m_email'],
    "m_tel"      => $req['m_tel'],
    "m_hp"       => $req['m_hp'],
    "m_zip"      => $req['m_zip'],
    "m_addr1"    => $req['m_addr1'],
    "m_addr2"    => $req['m_addr2'],

	"m_status"	=> $m_status,

    "m_regDate"    => $dateTime,
    "m_regIP"      => ip_addr(),
    "m_lastVisit"  => $dateTime,
    "m_smsDate"    => $dateTime,
    "m_emailDate"  => $dateTime,
    "m_smsIP"      => ip_addr(),
    "m_emailIP"    => ip_addr(),
  );

//	$Query = "INSERT INTO G_Member (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
	foreach($Field AS $key => $value) {
		 $ret[] = $key."='".$value."'";
	}

	$RESULT = $db->ExecQuery("UPDATE G_Member SET ".implode(",", $ret)." WHERE m_status = 'temp' and m_email = '".$req['m_email']."' and m_linkCode = '".$XID."' ");

	if($RESULT > 0){
    new_token($token['joinEnd']);


/*-------------------------------------------------------------------------------------------------
		▶ 이메일 전송 
		$Subject = "["._HOMEPAGE_NAME_."] ".$m_gubun." 가입이 완료되었습니다.";
	//								$Subject = iconv("utf-8","gb2312",$Subject);

		$AltBody = $Subject ;

		$body      = file_get_contents('../../mail_join.php');
		$body      = str_replace("[ID]", $req['m_id'], $body);
		$body      = str_replace("[PW]", $req['m_passwd1'], $body);

		$body      = eregi_replace("[\]",'',$body);
	//								$body      = iconv("utf-8","gb2312",$body);

		$to = $req['m_email'];
		$from = "webmaster@"+_DOMAIN_;

		include _CORE_PATH_."/plugin/PHPMailer_5.2.4/class.phpmailer.php";
		$mail = new PHPMailer();
		$mail-> CharSet   = "UTF-8";
		$mail-> Encoding = "base64";
		$body = eregi_replace("[\]",'',$body);

		$mail->IsSendmail();  // tell the class to use Sendmail
		$mail->AddReplyTo($from,_HOMEPAGE_NAME_);
		$mail->From       = $from;
		$mail->FromName   = _HOMEPAGE_NAME_;
		$mail->AddAddress($to);

		$mail->Subject    = $Subject ;
		$mail->AltBody    = $AltBody; // optional, comment out and test
		$mail->MsgHTML($body);

		$mail->Send();
*/

		locationReplace($req['return_url'],"회원가입이 완료되었습니다.");
	}else{
		toplocationHref($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");
	}


break;


/*******************************************************************************
 *
 * 아이디 찾기
 *
 ******************************************************************************/
case "FindID":

	$req['m_email']	= Request('m_email');
	$req['m_name']	= Request('m_name');

	$QUERY = sprintf("SELECT m_id, m_email  FROM  G_Member WHERE m_email = '%s' and m_status in ('normal','break') ", $req['m_email']);

	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.
  if($CHECK) $json = false;
  else $json = true;
//  echo json_encode($json);

  if($CHECK or is_array($CHECK)){

		/*-------------------------------------------------------------------------------------------------
		▶ 이메일 전송 */
		$str = $CHECK['m_id'];
		$toEmail = $CHECK['m_email'];

		$Title = "[한국상담대학원대학교 상담학아카데미] 고객님의 아이디 정보입니다.";
		$Content = "고객님의 아이디는 <span>$str</span> 는 입니다. <br><br>".$site['site_name']."";
		EmailSend($toEmail, $Title, $Content);

		locationReplace('/',"아이디가 이메일로 발송되었습니다.");

  }else{
	toplocationHref($req['_referer_'],"입력하신 정보에 해당하는 아이디가 없습니다.");
  }

break;


/*******************************************************************************
 *
 * 비밀번호 재발급
 *
 ******************************************************************************/
case "ResetPassword":

	$req['m_name']	= Request('m_name');
	$req['m_id']	= Request('m_id');
	$req['m_email']	= Request('m_email');

	$QUERY = sprintf("SELECT m_id, m_email  FROM  G_Member WHERE m_name = '%s' and m_id = '%s' and m_email = '%s' and m_status in ('normal','break') ", $req['m_name'], $req['m_id'], $req['m_email']);

	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.
  if($CHECK) $json = false;
  else $json = true;

	if($CHECK or is_array($CHECK)){

		$req['passwd'] = random_string(9);
		$req['new_passwd'] = md5($req['passwd']);

		$R = $db -> ExecQuery(sprintf("Update G_Member Set m_passwd = '%s' Where m_id = '%s' and m_name='%s'  ", $req['new_passwd'], $req['m_id'], $req['m_name']));

		/*-------------------------------------------------------------------------------------------------
		▶ 이메일 전송 */
		$user_id = $CHECK['m_id'];
		$toEmail = $CHECK['m_email'];
		$Title = "[한국상담대학원대학교 상담학아카데미] 비밀번호재설정 안내입니다.";
		$Content = "고객님의 비밀번호가 <span>".$req['passwd']."</span> 로 변경되었습니다.<br>로그인 후 비밀번호를 변경하여 주세요.";

	//    EmailSend($toEmail, $Title, $Content);
		// 비밀번호 메일 발송
		$header = "From:webmaster@kcgu.ac.kr\n";
		$header .= "Content-type:text/html;\n";    // 텍스트 타입 설정 (text/html 형식 사용)

		$subject = "[한국상담대학원대학교 상담학아카데미] 비밀번호 변경 정보입니다. (".date("Y-m-d H:i:s").")"; 
		$subject = "=?UTF-8?B?".base64_encode($subject)."?="; 

		$mail_body = "<br />안녕하세요.";
//		$mail_body .= "<br />Rchips 관리자 입니다.";
		$mail_body .= "<br />저희 사이트를 이용해주셔서 진심으로  감사드립니다.";

		$mail_body .= "<br /><br />고객님의 비밀번호가 <strong>".$req['passwd']."</strong> 로 변경되었습니다.";
	//			$mail_body .= "<br><br><strong>“대한민국은 아침을 거르지 않습니다. 신명나는 우리먹거리 얼쑤 !”</strong>";
			$mail_body .= "<br /><br />본 메일은 발신전용입니다. 문의 사항이 있으시면 상담 및 문의전화를 이용해 주세요.";
			$mail_body .= "<br />상담시간 : 월~금 오전 9시 - 오후 6시<br />
						상담 및 문의전화    ☎ 02-584-6863 <br />
							Copyright  2019 한국상담대학원대학교 All Right Reserved.<br />";

		$mail_body = mb_convert_encoding($mail_body,"EUC-KR","UTF-8");
		$email_ok = mail($toEmail, $subject, $mail_body, $header);

		locationReplace('/',"비밀번호가 이메일로 발송되었습니다.");

	}else{
		toplocationHref($req['_referer_'],"입력하신 정보에 해당하는 아이디가 없습니다.");
	}

break;


/*******************************************************************************
 *
 * 회원정보 수정 전 비밀번호 확인
 *
 ******************************************************************************/
case "MyinfoUpdatePW":
	$req['passwd']	= Request('passwd');
    // 필수값누락
    if(!isset($req['passwd']) || empty($req['passwd'])){
  		historyBack();
      break;
    }

	$req['passwd'] = MD5($req['passwd']);

	$QUERY = sprintf("SELECT m_id  FROM  G_Member WHERE m_passwd = '%s' and m_status in ('normal','break') ", $req['passwd']);
	$CHECK = $db -> SelectOne($QUERY); // 데이터를 가져온다.


  if($CHECK){
	  $_SESSION['_MEMBER_']['EDIT']    = "Y";
	  toplocationHref("/mypage/modify_write.php");
  } else{
	  toplocationHref("/mypage/modify.php","비밀번호를 확인하세요.");
  }

break;


/*******************************************************************************
 *
 * 회원정보수정
 *
 ******************************************************************************/
case "MyinfoUpdate":
  if(!isset($MemberID) || empty($MemberID)) locationReplace("/","로그인 후 이용하실 수 있습니다.");
  // 필수값
  $RequiredField = array(
    "m_hp1",
    "m_hp2",
    "m_hp3",
  );


	$req['m_passwd1']	= Request('m_passwd1');
	$req['m_passwd2']	= Request('m_passwd2');
	$req['m_email']	  = Request('m_email');

	$req['m_sex']	  = Request('m_sex');

	$req['m_birth_y']	    = Request('m_birth_y');
	$req['m_birth_m']	    = Request('m_birth_m');
	$req['m_birth_d']	    = Request('m_birth_d');

	$req['m_tel1']	  = Request('m_tel1');
	$req['m_tel2']	  = Request('m_tel2');
	$req['m_tel3']	  = Request('m_tel3');

	$req['m_hp1']	    = Request('m_hp1');
	$req['m_hp2']	    = Request('m_hp2');
	$req['m_hp3']	    = Request('m_hp3');

	$req['m_zip']	    = Request('m_zip');
	$req['m_addr1']	  = Request('m_addr1');
	$req['m_addr2']	  = Request('m_addr2');


	$req['m_job1']	    = Request('m_job1');
	$req['m_job2']	    = Request('m_job2');
	$req['m_major']	    = Request('m_major');

	$req['m_hospital1']	    = Request('m_hospital1');	
	$req['m_hospital2']	    = Request('m_hospital2');	
	$req['m_hospital_etc']	    = Request('m_hospital_etc');	

	$req['m_company']	    = $req['m_hospital1'];
	$req['m_position']	    = $req['m_hospital2'];
	$req['m_position02']	    = $req['m_hospital_etc'];

	$req['m_department']	    = Request('m_department');
	$req['m_bizNum']	    = Request('m_bizNum');
	$req['m_bizNum02']	    = Request('m_bizNum02');
	if($req['m_bizNum']==""){
		$req['m_bizNum'] = $req['m_bizNum02'];
	}


  foreach($RequiredField as $k => $v){
    // 필수값누락
    if(!isset($req[$v]) || empty($req[$v])){
  		historyBack();
      break;
    }
  }

  // 비밀번호 다름
  if($req['m_passwd1'] != $req['m_passwd2'])	toplocationHref($req['_referer_']);


  // 가공되는 변수
  $req['m_hp']   = $req['m_hp1']."-".$req['m_hp2']."-".$req['m_hp3'];
  $req['m_tel']   = $req['m_tel1']."-".$req['m_tel2']."-".$req['m_tel3'];

  // 데이터베이스 입력
  $Field = array(
    "m_tel"      => $req['m_tel'],
    "m_hp"       => $req['m_hp'],
    "m_zip"      => $req['m_zip'],
    "m_addr1"    => $req['m_addr1'],
    "m_addr2"    => $req['m_addr2'],

    "m_updateDate"    => $dateTime,
    "m_updateIP"      => ip_addr()
  );
  
  
  if(!empty($req['m_passwd1'])){
    $Field['m_passwd'] = md5($req['m_passwd1']);
  }

  foreach($Field AS $key => $value) {
     $ret[] = $key."='".$value."'";
  }
  $RESULT = $db->ExecQuery("UPDATE G_Member SET ".implode(",", $ret)." WHERE m_id = '".$MemberID."' ");
	if($RESULT > 0){
		locationReplace($req['return_url'],"회원정보가 수정되었습니다.");
	}else{
		toplocationHref($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");
	}


break;
/*******************************************************************************
 *
 * 글 수정
 *
 ******************************************************************************/

case "SubJoinMember2":
	if(!isset($MemberID) || empty($MemberID)) locationReplace("/","로그인 후 이용하실 수 있습니다.");
	// 필수값
	unset($RequiredField);
	$RequiredField = array(
	//   "m_id_sub01",
	//   "m_id_sub02",
	// //   "m_id_sub03",
	// //   "m_id_sub04",
	// //   "m_id_sub05",
	//   "m_passwd_sub01",
	//   "m_passwd_sub02",
	// //   "m_passwd_sub03",
	//   "m_passwd_sub04",
	//   "m_passwd_sub05"
	);
  
// 	// 변수 담기

$req['idx']	  = Request('idx');
	  $req['info02']	  = Request('info02');
	  $req['info03']	  = Request('info03');
	 $idx = Request('idx');

	// 데이터베이스 입력
	$Field = array(
	  "info02"    => $req['info02'],
	  "info03"    => $req['info03'],

	);
  

  //	$Query = "INSERT INTO G_Member (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
	  foreach($Field AS $key => $value) {
		   $ret[] = $key."='".$value."'";
		 
	  }

	  $BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx'];

	
	  $RESULT = $db->ExecQuery("UPDATE G_Info_Comment SET ".implode(",", $ret)." WHERE   UserID = '".$MemberID."' and idx = ".$req['idx']);

	//   echo "UPDATE G_Info_Comment SET ".implode(",", $ret)." WHERE   UserID = '".$MemberID."' and idx = ".$req['idx'];
	//   break;
	  if($RESULT > 0){
	  new_token($token['joinEnd']);

		  locationReplace($req['return_url'],"수정 완료되었습니다.");
	  }else{
		  toplocationHref($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");
	  }
  
  
  break;
  /*******************************************************************************
 *
 * 글 삭제
 *
 ******************************************************************************/
case "SubJoinMember3":
	if(!isset($MemberID) || empty($MemberID)) locationReplace("/","로그인 후 이용하실 수 있습니다.");
	
  
// 	// 변수 담기

	 $req['idx']	  = Request('idx');
	 $idx = Request('idx');

	  foreach($Field AS $key => $value) {
		   $ret[] = $key."='".$value."'";
		 
	  }

	  $BoardView = "select * from G_Info_Comment where idx = ".$req['idx'];
	
	
	  $RESULT = $db->ExecQuery("DELETE From G_Info_Comment WHERE idx = '".$req['idx']."'");

	  
	  if($RESULT > 0){
	  new_token($token['joinEnd']);
		  locationReplace($req['return_url'],"수정 완료되었습니다.");
	  }else{
		  toplocationHref($req['_referer_']);
	  }
  



/*******************************************************************************
 *
 * End
 *
 ******************************************************************************/
endswitch;
}
?>