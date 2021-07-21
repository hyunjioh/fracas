<?
if(!defined("_g_board_include_")) exit;
###################################################################################################
/*
  - 공지형 게시판
  - G_Notice : 원글 저장
  - G_Notice_Attach : 첨부파일저장
  - G_Notice_Comment : 코멘트저장
*/
###################################################################################################
$req['_referer_']	 = Request('_referer_');
$req['mode']			 = Request('am');

$req['UserName']   = Input('UserName');
$req['RegDate']    = Input('RegDate');
$req['UserID']     = $MemberID;
if(!$req['UserName'])   $req['UserName'] = $MemberName;
if(!$req['RegDate'])	  $req['RegDate']  = $dateTime;
if(!$req['UpdateDate'])	$req['UpdateDate']  = $dateTime;

$req['Hit']        = Request('Hit');
$req['Html']       = Request('Html');
$req['Notice']     = Request('Notice');
$req['Status']     = Request('Status');
$req['Category']   = Input('Category');

$req['Hit']        = SetValue($req['Hit'],'digit', 0);
$req['Html']       = SetValue($req['Html'],'alpha', 'html');
$req['Notice']     = SetValue($req['Notice'],'alpha', 'N');
$req['Status']     = SetValue($req['Status'],'alpha', 'Y');


$req['Subject']    = Input('Subject');
$req['Content']    = Input('Content');
$req['Comment']    = Input('Comment');
$req['LinkUrl']    = Input('LinkUrl');

$req['LinkUrl']    =  UrlCheck($req['LinkUrl']);

$req['RegIP']   = ip_addr();

if($req['mode']){
switch($req['mode']):

/*******************************************************************************
 *
 * 새글작성
 *
 ******************************************************************************/
case "newData":
  if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
  /*-------------------------------------------------------------------------------------------------
  ▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
  destory_token($Board['board_id']);

  $Field = array(
    "BoardID"     => $Board['board_id'],
    "Category"    => $req['Category'],

    "UserID"       => $req['UserID'],
    "UserName"     => $req['UserName'],

    "Subject"     => $req['Subject'],
    "Content"     => $req['Content'],
    "Comment"     => $req['Comment'],
    "LinkUrl"     => $req['LinkUrl'],

    "Hit"         => $req['Hit'],
    "RegID" 	    => $req['UserID'],
    "RegIP" 	    => $req['RegIP'],
    "RegDate"     => $req['RegDate'],

    "Html"        => $req['Html'],
    "Notice"      => $req['Notice'],
    "Status"      => "Y",
  );

  $Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
  $RESULT = $db->ExecQuery($Query);
  if($RESULT > 0){
    $Pidx = LAST_INSERT_ID();
    AttachProcess($Pidx, $subDir);
    locationReplace($href,"등록 되었습니다.");
  }else{
    locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");
  }
break;


/*******************************************************************************
 *
 * 글 수정
 *
 ******************************************************************************/
case "updateData":
  if(new_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
  /*-------------------------------------------------------------------------------------------------
  ▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
  destory_token($Board['board_id']);

  $Field = array(
    "Category"    => $req['Category'],

    "UserID"       => $req['UserID'],
    "UserName"     => $req['UserName'],

    "Subject"     => $req['Subject'],
    "Content"     => $req['Content'],
    "Comment"     => $req['Comment'],
    "LinkUrl"     => $req['LinkUrl'],
    "Hit"         => $req['Hit'],
    "RegDate"     => $req['RegDate'],
    "UpdateDate"  => $dateTime,

    "Html"        => $req['Html'],
    "Notice"      => $req['Notice'],
    "Status"      => $req['Status'],
  );

  foreach($Field AS $key => $value) {
     $ret[] = $key."='".$value."'";
  }
  $RESULT = $db->ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
  if($RESULT >= 0){
    $Pidx = $req['idx'];
    if(isset($_POST['files_del']) && !empty($_POST['files_del']))		AttachSelectDel($Pidx, $_POST['files_del']);
    AttachProcess($Pidx, $subDir);
    locationReplace($href."&at=view&idx=$req[idx]","수정되었습니다.");
  //}elseif($RESULT == 0){
  //	locationReplace($href,"변경된 내용이 없습니다.");
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
  $CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx = '".$req['idx']."'");

  if($CHECK){
    $RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
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
 * 선택삭제
 *
 ******************************************************************************/
case "checkDelete":
  $req['gidx'] = Request("gidx");
  if($req['gidx']){
    foreach($req['gidx'] as $gkey => $gvalue){
      $RESULT = $db -> ExecQuery("DELETE from ".$Board['table_board']." WHERE idx = '".$gvalue."'");
      AttachDel($gvalue);
    }
  }
  toplocationHref($req['_referer_'],"삭제 되었습니다." );
break;




/*******************************************************************************
 *
 * End
 *
 ******************************************************************************/
endswitch;
}
?>