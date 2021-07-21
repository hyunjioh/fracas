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

$req['Subject']     = Input('Subject');
$req['Content']     = Input('Content');
$req['Category']    = Input('Category');
$req['file_01_del'] = Input('file_01_del');
$req['LinkTarget']  = Input('LinkTarget');
$req['LinkUrl']     = Input('LinkUrl');
$req['LinkUrl']     =  UrlCheck($req['LinkUrl']);
$req['BoardID'] = $Board['board_id'];
$req['Subject'] = htmlspecialchars(strip_tags($req['Subject']));
$req['Content'] = htmlspecialchars(strip_tags($req['Content']));
$req['RegIP']   = ip_addr();
$req['RegID']  = $req['UserID'];
$req['RegDate']  = $dateTime;

// 첨부파일 처리
$cfg['file']['fileMaxSize']   = $Board['file_max_size'];
$cfg['file']['fileCheckType'] = $Board['file_check_type'];
$cfg['file']['savePath'] = _UPLOAD_PATH_."/".$Board['board_id']."/".$subDir;
$cfg['file']['checkExt'] = explode("|",$Board['file_check_ext']);

switch( strtoupper(substr($cfg['file']['fileMaxSize'],-1))  ){
  Case "K": $cfg['file']['fileMaxSize'] = substr($cfg['file']['fileMaxSize'],0,-1)*1024; break;
  Case "M": $cfg['file']['fileMaxSize'] = substr($cfg['file']['fileMaxSize'],0,-1)*1024*1024; break;
  Case "G": $cfg['file']['fileMaxSize'] = substr($cfg['file']['fileMaxSize'],0,-1)*1024*1024*1024;	break;
  default : $cfg['file']['fileMaxSize'] = _UPLOAD_MAX_SIZE_;
}
$subdir = str_replace(_UPLOAD_PATH_,"",$cfg['file']['savePath']);				

if(isset($_FILES['file_01']) && !empty($_FILES['file_01']['tmp_name'])){
  $AttachReturn = AttachFile($_FILES["file_01"], $cfg['file'], '','');
  if($AttachReturn){
    if(!$AttachReturn['result']){
      alert($AttachReturn['msg']);
    }else{
      $req['AttachSaveFile01']  = $subdir."/".$AttachReturn['SaveName'];			
      $req['AttachFileName01']  = $subdir."/".$AttachReturn['FileName'];			
    }
  }
}





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
  $CHECK = $db -> SelectOne("select max(SortNum) as SortNum  from ".$Board['table_board']." where BoardID = '".$Board['board_id']."'");  


  $Field = array(
    "BoardID"     => $req['BoardID'],
    "Category"    => $req['Category'],

    "Subject"     => $req['Subject'],
    "Content"     => $req['Content'],
    "LinkUrl"     => $req['LinkUrl'],
    "LinkTarget"  => $req['LinkTarget'],

    "SortNum"     => $CHECK['SortNum']+1,
    "RegID" 	    => $req['RegID'],
    "RegIP" 	    => $req['RegIP'],
    "RegDate"     => $req['RegDate'],
  );



  if(isset($req['AttachSaveFile01'])  && !empty($req['AttachFileName01']) ){
    $Field['AttachSaveFile01'] = $req['AttachSaveFile01'];
    $Field['AttachFileName01'] = $req['AttachFileName01'];
  }

  $Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
  $RESULT = $db->ExecQuery($Query);
  if($RESULT > 0){
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
    "Subject"     => $req['Subject'],
    "Content"     => $req['Content'],
    "LinkUrl"     => $req['LinkUrl'],
    "LinkTarget"  => $req['LinkTarget'],
  );

  $CHECK = $db -> SelectOne("select *  from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx']);  
  if($req['file_01_del'] != ""){
    if($req['file_01_del'] == $CHECK['AttachSaveFile01']){
      if(file_exists(_UPLOAD_PATH_.$CHECK['AttachSaveFile01'])){
        @unlink(_UPLOAD_PATH_.$CHECK['AttachSaveFile01']);
      }
      $Field['AttachSaveFile01'] = "";
      $Field['AttachFileName01'] = "";
    }
  }

  if(isset($req['AttachSaveFile01'])  && !empty($req['AttachFileName01']) ){
    $Field['AttachSaveFile01'] = $req['AttachSaveFile01'];
    $Field['AttachFileName01'] = $req['AttachFileName01'];
  }

  if($Field['AttachSaveFile01'] != "" && $req['file_01_del'] == "" && $CHECK['AttachSaveFile01']){
    if(file_exists(_UPLOAD_PATH_.$CHECK['AttachSaveFile01'])){
      @unlink(_UPLOAD_PATH_.$CHECK['AttachSaveFile01']);
    }  
  }


  foreach($Field AS $key => $value) {
     $ret[] = $key."='".$value."'";
  }
  $RESULT = $db->ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
  if($RESULT >= 0){
    locationReplace($href."&at=view&idx=$req[idx]","수정되었습니다.");
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

      if($CHECK['AttachSaveFile01']){
        if(file_exists(_UPLOAD_PATH_.$CHECK['AttachSaveFile01'])){
          @unlink(_UPLOAD_PATH_.$CHECK['AttachSaveFile01']);
        }  
      }
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
      $CHECK = $db -> SelectOne("select * from ".$Board['table_board']." WHERE BoardID='".$Board['board_id']."' and  idx = '".$gvalue."'");
      $RESULT = $db -> ExecQuery("Delete from ".$Board['table_board']." WHERE BoardID='".$Board['board_id']."' and idx = '".$gvalue."'");
      if($CHECK['AttachSaveFile01']){
        if(file_exists(_UPLOAD_PATH_.$CHECK['AttachSaveFile01'])){
          @unlink(_UPLOAD_PATH_.$CHECK['AttachSaveFile01']);
        }  
      }
    }
  }
  toplocationHref($req['_referer_'],"삭제 되었습니다." );
break;


/*******************************************************************************
 *
 * 순서정렬
 *
 ******************************************************************************/
case "SortConfirm":
  $req['gidx'] = Request("gsort");
  if($req['gidx']){
    foreach($req['gidx'] as $gkey => $gvalue){
      $RESULT = $db -> ExecQuery("Update ".$Board['table_board']." set SortNum = '".($gkey+1)."' WHERE idx = '".$gvalue."'");
    }
  }
  toplocationHref($req['_referer_'],"수정 되었습니다." );
break;



/*******************************************************************************
 *
 * End
 *
 ******************************************************************************/
endswitch;
}
?>