<?
if(!defined("_g_board_include_")) exit;
###################################################################################################
/*
  - 제휴문의
  - G_Counsel : 원글 저장
*/
###################################################################################################
// 변수체크
$req['_referer_']	   = Request('_referer_');
$req['mode']			   = Request('am');

$req['Pidx']         = Input('idx');
$req['P_Comment'] = Input('Comment');
$req['Category'] = Input('Category');

$req['Character']     = Input('Character');
$req['info01']         = Input('info01');
$req['info02']         = Input('info02');
$req['info03']         = Input('info03');
$req['info04']         = Input('info04');

if($req['Category']=="1WIR9N"){
	$req['info01'] = implode(" / ",$req['info01']);
}

// 분류 체크
if(trim($req['Category'])==""){
//	locationReplace($req['_referer_'],"과목구분 정보가 부정확합니다. 다시 신청을 진행하세요.");
//	exit;
}


// 로그인 체크
$WriteOK = (!empty($MemberID)) ? true : false;
if(!$WriteOK){
	locationReplace($req['_referer_'],"로그인 하신 후 신청하세요.");
	exit;
}

// // 정원 체크
// $appCnt = 0;
// $appCnt = $db -> Total("Select count(*) from ".$Board['comment_table']." Where BoardID = '".$Board['board_id']."' and Pidx = '".$req['Pidx']."' ");

// if($appCnt >= $req['P_Comment']){
// 	locationReplace($req['_referer_'],"신청 정원 초과입니다.");
// 	exit;
// }

// 중복 신청 체크
$appCnt02 = $db -> Total("Select count(*) from ".$Board['comment_table']." Where BoardID = '".$Board['board_id']."' and Pidx = '".$req['Pidx']."' and UserID = '".$MemberID."' ");
if($appCnt02 > 0){
	locationReplace($req['_referer_'],"이미 신청하신 서비스입니다.");
	exit;
}

// 강좌 정보
$BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['Pidx'];
$Value = $db -> SelectOne($BoardView);
if(!$Value)	locationReplace($Board['Link']);

$req['Subject'] = $Value['Subject'];
$req['Comment'] = $Value['sDate']." ~ ".$Value['eDate'];

// 변수 가공
$req['BoardID'] = $Board['board_id'];
$req['RegIP']   = ip_addr();
if(!$req['UserID'])     $req['UserID'] = $MemberID;
if(!$req['RegID'])      $req['RegID']  = $req['UserID'];
if(!$req['UserName'])   $req['UserName'] = $MemberName;
if(!$req['RegDate'])	  $req['RegDate']  = $dateTime;
if(!$req['UpdateDate'])	$req['UpdateDate']  = $dateTime;


if($req['mode']){
switch($req['mode']):

/*******************************************************************************
 *
 * 새글작성
 *
 ******************************************************************************/
case "newData":
//  if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
  /*-------------------------------------------------------------------------------------------------
  ▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
//  destory_token($Board['board_id']);

  $Field = array(
    "BoardID"      => $req['BoardID'],
    "Pidx"         => $req['Pidx'],

    "UserID"     => $req['UserID'],
	"UserName"     => $req['UserName'],

    "Subject"     => $req['Subject'],
    "Comment"     => $req['Comment'],
    "Category"     => $req['Category'],
	"Character"     => $req['Character'],

    "info01"     => $req['info01'],
    "info02"     => $req['info02'],
    "info03"     => $req['info03'],
    "info04"     => $req['info04'],

    "RegID" 	    => $req['RegID'],
    "RegIP" 	    => $req['RegIP'],
    "RegDate"     => $req['RegDate'],
  );

  $Query = "INSERT INTO ".$Board['comment_table']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";

  $RESULT = $db->ExecQuery($Query);
  if($RESULT > 0){
    locationReplace($req['_referer_'],"신청하신 서비스는 담당자가 확인 후 접수 순서대로 연락 드리겠습니다.");
  }else{
    locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");
  }
break;

/*******************************************************************************
 *
 * 글삭제
 *
 ******************************************************************************/
case "deleteData":
 
  $CHECK = $db -> SelectOne("select * from G_Info_Comment where  idx = $idx ");

  echo "select * from G_Info_Comment  where  idx = $idx";
  break;

  if($CHECK){
    $RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
   
  //  echo "DELETE From ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'";
  //  break;

    if($RESULT >= 0){
      AttachDel($req['idx']);
      locationReplace($href,"삭제되었습니다.");
    }else{
      locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");
    }
  }else{
    locationReplace($Board['Link']);
  }
break;


/*******************************************************************************
 *
 * End
 *
 ******************************************************************************/
endswitch;
}
?>