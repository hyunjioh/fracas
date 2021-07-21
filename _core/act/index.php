<?php
define("_act_include",true);
include "../_lib.php";
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */
$db = new MySQL($mysql1);


/*-------------------------------------------------------------------------------------------------
▶ 접속체크 */
//if(!isset($_SERVER['HTTP_REFERER'])) exit;
//if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) exit;


/*-------------------------------------------------------------------------------------------------
▶ 변수 */
$req['at']         = Request('at');
$req['_referer_']	 = Request('_referer_');
$req['return_url'] = Request('return_url');


if(!$req['_referer_']) $req['_referer_'] = "/";
if(!$_GET['at']) $_GET['at'] = $req['at'];


$site = $db -> SelectOne("Select * from G__Site order by idx desc limit 1 ");
/*-------------------------------------------------------------------------------------------------
▶ 페이지 호출 */
$include_page = null;

if($_GET['at']){
switch($_GET['at']):
/*******************************************************************************
 *
 * member.action.php
 *
 ******************************************************************************/
	case "logout": // 로그아웃
		$req['mode'] = "Logout";
		$include_page = "member.action.php"; break;

	case "login":  // 로그인
		$req['mode'] = "Login";
		$include_page = "member.action.php"; break;

	case "checkid":  // 아이디중복체크
		$req['mode'] = "CheckID";
		$include_page = "member.action.php"; break;

	case "checkemail":  // 아이디중복체크
		$req['mode'] = "CheckEmail";
		$include_page = "member.action.php"; break;

	case "checkemail02": // 이메일 가입확인 및 인증번호받기
		$req['mode'] = "CheckEmail02";
		$include_page = "member.action.php"; break;

	case "checkemail03": // 이메일 - 인증번호 확인
		$req['mode'] = "CheckEmail03";
		$include_page = "member.action.php"; break;

	case "checkemail04": // 이메일 - 인증번호 재전송
		$req['mode'] = "CheckEmail04";
		$include_page = "member.action.php"; break;

	case "join":  // 회원가입
		$req['mode'] = "JoinMember";
		$include_page = "member.action.php"; break;

	case "findid":  // 아이디찾기
		$req['mode'] = "FindID";
		$include_page = "member.action.php"; break;

	case "findpw":  // 비밀번호 재발급
		$req['mode'] = "ResetPassword";
		$include_page = "member.action.php"; break;

	case "modifyMem":  // 회원정보수정 - 비빌번호 확인
		$req['mode'] = "MyinfoUpdatePW";
		$include_page = "member.action.php"; break;

	case "myinfo":  // 회원정보수정
		$req['mode'] = "MyinfoUpdate";
		$include_page = "member.action.php"; break;
	
		case "subjoin2":  // 글 수정
			$req['mode'] = "SubJoinMember2";
			$include_page = "member.action.php"; break;
		case "subjoin3":  // 글 삭제
			$req['mode'] = "SubJoinMember3";
			$include_page = "member.action.php"; break;
	

/*******************************************************************************
 *
 * public.action.php
 *
 ******************************************************************************/

	case "bookmarkvisit":  // 우편번호/주소 검색
		$req['mode'] = "Bookmark";
		$include_page = "public.action.php"; break;

	case "searchaddr":  // 우편번호/주소 검색
		$req['mode'] = "SearchAddress";
		$include_page = "public.action.php"; break;

	case "sendsms":  // SMS 전송
		$req['mode'] = "SendSms";
		$include_page = "public.action.php"; break;

	case "sendemail":  // Email 전송
		$req['mode'] = "SendEmail";
		$include_page = "public.action.php"; break;

	case "sendmessage": // 쪽지 전송
		$req['mode'] = "SendMessage";
		$include_page = "public.action.php"; break;

	case "selectsendsmse": // 선택회원 SMS 전송
		$req['mode'] = "SelectSendSms";
		$include_page = "public.action.php"; break;

	case "selectsendemail": // 선택회원 Email 전송
		$req['mode'] = "SelectSendEmail";
		$include_page = "public.action.php"; break;

	case "selectsendmessage": // 선택회원 쪽지 전송
		$req['mode'] = "SelectSendMessage";
		$include_page = "public.action.php"; break;

	case "categoryadd": // 카테고리추가
		$req['mode'] = "CategoryAdd";
		$include_page = "public.action.php"; break;

	case "categoryedit": // 카테고리수정
		$req['mode'] = "CategoryModify";
		$include_page = "public.action.php"; break;

	case "categorydel": // 카테고리삭제
		$req['mode'] = "CategoryDelete";
		$include_page = "public.action.php"; break;




  case "down": // 첨부파일 다운로드 (디비접근없이 파일경로를 이용하여 다이렉트 다운로드)
    DirectDownload();		break;
/*******************************************************************************
 *
 * End
 *
 ******************************************************************************/
endswitch;
}



if($include_page && file_exists($include_page)) include $include_page;

?>