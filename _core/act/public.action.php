<?php
if(!defined("_hannet_included")) exit;
if(!defined("_act_include")) exit;

if($req['mode']){
switch($req['mode']):

/*******************************************************************************
 *
 * 북마크를 통한 접속
 *
 ******************************************************************************/
case "Bookmark":
  setcookie($token['bookmark'],md5(session_id()) ,0,"/");  
  metaRefresh("/");
break;


/*******************************************************************************
 *
 * 링크로 접속한 사용자 체크
 *
 ******************************************************************************/
case "LinkCode":
  $req['XID'] = Request("xid");
  if(!$req['XID']) toplocationhref("/","정상적인 접근이 아닙니다.");
  if(strlen(trim($req['XID'])) != "14") toplocationhref("/","정상적인 접근이 아닙니다.");
  $Query = "Select * from G_Member Where m_linkCode = '".$req['XID']."' ";
  $CHECK = $db -> SelectOne($Query);
  if($CHECK){
    setcookie("XID",trim($req['XID']) ,0,"/");
    toplocationhref("/");
  }else{
    toplocationhref("/","유효한 링크값이 아닙니다.");
  }
break;

/*******************************************************************************
 *
 * 우편번호/주소 검색
 *
 ******************************************************************************/
case "SearchAddress":
	$req['dong']	= Request('dong');
	$QUERY = "SELECT *  FROM  Zipcode WHERE DONG like '%".$req['dong']."%'";
	$LIST = $db -> SelectList($QUERY); // 데이터를 가져온다.
  if($LIST){
    $json['error'] = "N";
    $count = count($LIST);
		for($i=0; $i < $count; $i++){
      $json['item'][$i]['ZIPCODE'] = $LIST[$i]['ZIPCODE'];
      $json['item'][$i]['SIDO']    = $LIST[$i]['SIDO'];
      $json['item'][$i]['GUGUN']   = $LIST[$i]['GUGUN'];
      $json['item'][$i]['DONG']    = $LIST[$i]['DONG'];
      $json['item'][$i]['BUNJI']   = $LIST[$i]['BUNJI'];
    }
  }else{
    $json['error'] = "Y";
    $json['msg']   = "검색결과가 없습니다.";
  }
  echo json_encode($json);
break;


/*******************************************************************************
 *
 * SMS 전송
 *
 ******************************************************************************/
case "SendSms":
	$req['SmsMsg']       = Request('SmsMsg');
	$req['callback']	   = Request('callback');
	$req['reserve']	     = Request('reserve');
	$req['recv_hp_list'] = Request('recv_hp_list');
  if(!$req['SmsMsg'] || !$req['callback'] || !$req['reserve'] || !$req['recv_hp_list']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{

    $recvCount = count($req['recv_hp_list']);
    for($i=0; $i < $recvCount; $i++){
      $recv_hp = $req['recv_hp_list'][$i];
      $RESULT = 1;
      $ResultSum = $ResultSum + $RESULT;
    }

    // SMS 연동
    if($ResultSum > 0){
      $json['error'] = "N";
      $json['msg']   = "전송이 완료되었습니다.";
      $json['msg']  .= "\r\n MSG : ".$req['SmsMsg'];
      $json['msg']  .= "\r\n callback : ".$req['callback'];
      $json['msg']  .= "\r\n send sms count : ".$ResultSum;
    }else{
      $json['error'] = "N";
      $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
    }
  }
  echo json_encode($json);
break;


/*******************************************************************************
 *
 * 선택회원 SMS 전송
 *
 ******************************************************************************/
case "SelectSendSms":
	$req['SmsMsg']       = Request('SmsMsg');
	$req['callback']	   = Request('callback');
	$req['reserve']	     = Request('reserve');
	$req['to_list']      = Request('to_list');
  if(!$req['SmsMsg'] || !$req['callback'] || !$req['reserve'] || !$req['to_list']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{

    $success = $fail = 0;
    $org_count = count($req['to_list']);
    $req['to'] = array_unique($req['to_list']);
    $count = count($req['to']);
    for($i=0; $i < $count; $i++){
      $recv_hp = $req['to'][$i];


      if($ResultSum > 0){
        $success++;
      }else{
        $fail++;
      } 
    }

    // SMS 연동
    if($ResultSum > 0){
      /*
      $json['error'] = "N";
      $json['msg']   = "전송이 완료되었습니다.";
      $json['msg']  .= "\r\n MSG : ".$req['SmsMsg'];
      $json['msg']  .= "\r\n callback : ".$req['callback'];
      $json['msg']  .= "\r\n send sms count : ".$ResultSum;
      */
    }else{
      /*
      $json['error'] = "N";
      $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
      */
    }

    $json['error'] = "N";
    $json['msg']   = "전체($org_count)건 중 중복(".($org_count-$count).")을 제거한 $count 건중 성공($success), 실패($fail) 전송하였습니다.";

  }
  echo json_encode($json);
break;


/*******************************************************************************
 *
 * 이메일전송
 *
 ******************************************************************************/
case "SendEmail":
	$req['fromEmail'] = $site['postmaster_email'];
	$req['fromName']  = $site['postmaster_name'];
	$req['toEmail']	  = Request('toEmail');
	$req['title']	    = Request('title');
	$req['Content']	  = Request('Content');

	$to       = $req['toEmail'];
	$from     = $req['fromEmail'];
	$fromName = $req['fromName'];

  if(!$req['fromEmail'] || !$req['toEmail']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{
    /*-------------------------------------------------------------------------------------------------
    ▶ 이메일 전송 */
    $Subject = $req['title'];
    $MailBody    = $req['Content'];
    $AltBody = $Subject ;

    /*
    $Subject = iconv("utf-8","gb2312",$Subject);
    $AltBody = iconv("utf-8","gb2312",$AltBody);
    $body      = file_get_contents('../../mail/pw.html');
    $body      = str_replace("[NAME]",$CHECK['h_fname']." ".$CHECK['h_lname'],$body);
    $body      = str_replace("[PASSWORD]",  $req['passwd'],  $body);
    //$body      = iconv("utf-8","gb2312",$body);
    */
    $MailBody      = eregi_replace("[\]",'',$MailBody);
    include _CORE_PATH_."/plugin/PHPMailer_v5.1/class.phpmailer.php";
    $mail = new PHPMailer();
    $mail-> CharSet   = "utf-8";
    $mail-> Encoding = "base64";
    $body = eregi_replace("[\]",'',$body);

    $mail->IsSendmail();  // tell the class to use Sendmail
    //$mail->AddReplyTo($from, $fromName);
    $mail->FromName   = $fromName;
    $mail->From       = $from;
    $mail->AddAddress($to);

    $mail->Subject    = $Subject ;
    $mail->AltBody    = $AltBody; // optional, comment out and test
    $mail->MsgHTML($MailBody);
    //$Attach = AttachLink($Pidx);
    //if($Attach){
    //	for($i=0; $i < count($Attach); $i++)  $mail->AddAttachment($Attach[$i]);      // attachment
    //}
    if($mail->Send()){
      $json['error'] = "N";
      $json['msg']   = "전송이 완료되었습니다.";
    }else{
      $json['error'] = "N";
      $json['msg']   = "이메일전송에 실패하였습니다.";
		}
  }

  echo json_encode($json);

break;


/*******************************************************************************
 *
 * 선택회원 이메일전송
 *
 ******************************************************************************/
case "SelectSendEmail":
	$req['fromEmail'] = $site['postmaster_email'];
	$req['fromName']  = $site['postmaster_name'];
	$req['to_list']	  = Request('to_list');
	$req['title']	    = Request('title');
	$req['Content']	  = Request('Content');

	$to       = $req['toEmail'];
	$from     = $req['fromEmail'];
	$fromName = $req['fromName'];

  if(!$req['fromEmail'] || !$req['to_list']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{

    $success = $fail = 0;
    $org_count = count($req['to_list']);
    $req['to'] = array_unique($req['to_list']);
    $count = count($req['to']);


    $Subject = $req['title'];
    $MailBody    = $req['Content'];
    $AltBody = $Subject ;

    /*
    $Subject = iconv("utf-8","gb2312",$Subject);
    $AltBody = iconv("utf-8","gb2312",$AltBody);
    $body      = file_get_contents('../../mail/pw.html');
    $body      = str_replace("[NAME]",$CHECK['h_fname']." ".$CHECK['h_lname'],$body);
    $body      = str_replace("[PASSWORD]",  $req['passwd'],  $body);
    //$body      = iconv("utf-8","gb2312",$body);
    */
    $MailBody      = eregi_replace("[\]",'',$MailBody);
    include _CORE_PATH_."/plugin/PHPMailer_v5.1/class.phpmailer.php";
    for($i=0; $i<$count; $i++){

      $to  = $req['to'][$i];
      /*-------------------------------------------------------------------------------------------------
      ▶ 이메일 전송 */
      $mail = new PHPMailer();
      $mail-> CharSet   = "utf-8";
      $mail-> Encoding = "base64";
      $body = eregi_replace("[\]",'',$body);

      $mail->IsSendmail();  // tell the class to use Sendmail
      //$mail->AddReplyTo($from, $fromName);
      $mail->FromName   = $fromName;
      $mail->From       = $from;
      $mail->AddAddress($to);

      $mail->Subject    = $Subject ;
      $mail->AltBody    = $AltBody; // optional, comment out and test
      $mail->MsgHTML($MailBody);
      //$Attach = AttachLink($Pidx);
      //if($Attach){
      //	for($i=0; $i < count($Attach); $i++)  $mail->AddAttachment($Attach[$i]);      // attachment
      //}
      if($mail->Send()){
        $success++;
      }else{
        $fail++;
      }
    }
    $json['error'] = "N";
    $json['msg']   = "전체($org_count)건 중 중복(".($org_count-$count).")을 제거한 $count 건중 성공($success), 실패($fail) 전송하였습니다.";

  }

  echo json_encode($json);

break;


/*******************************************************************************
 *
 * 쪽지 전송
 *
 ******************************************************************************/
case "SendMessage":
	$req['fromid']    = Request('fromid');
	$req['to_list']	    = Request('to_list');
	$req['Subject']	  = Request('Subject');
	$req['Content']	  = Request('Content');
  if(!$req['fromid'] || !$req['toid']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{
    $Field['UserID']  = $req['toid'];
    $Field['RegID']   = $req['fromid'];
    $Field['Subject'] = $req['Subject'];
    $Field['Memo']    = $req['Content'];
    $Field['RegDate'] = $dateTime;
    $Query = "INSERT INTO G_MemoBox (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";

    $RESULT = $db->ExecQuery($Query);
    if($RESULT > 0){
      $json['error'] = "N";
      $json['msg']   = "전송이 완료되었습니다.";
    }else{
      $json['error'] = "N";
      $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
    }
  }
  echo json_encode($json);
break;



/*******************************************************************************
 *
 * 선택회원 쪽지 전송
 *
 ******************************************************************************/
case "SelectSendMessage":
	$req['fromid']    = Request('fromid');
	$req['to_list']	  = Request('to_list');
	$req['Subject']	  = Request('Subject');
	$req['Content']	  = Request('Content');

  if(!$req['fromid'] || !$req['to_list']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{
    $success = $fail = 0;
    $org_count = count($req['to_list']);
    $req['to'] = array_unique($req['to_list']);
    $count = count($req['to']);
    for($i=0; $i<$count; $i++){
      $Field['UserID']  = $req['to'][$i];
      $Field['RegID']   = $req['fromid'];
      $Field['Subject'] = $req['Subject'];
      $Field['Memo']    = $req['Content'];
      $Field['RegDate'] = $dateTime;
      $Query = "INSERT INTO G_MemoBox (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
      $RESULT = $db->ExecQuery($Query);
      if($RESULT > 0){
        $success++;
      }else{
        $fail++;
      } 
      $json['error'] = "N";
      $json['msg']   = "전체($org_count)건 중 중복(".($org_count-$count).")을 제거한 $count 건중 성공($success), 실패($fail) 전송하였습니다.";

    }
  }
  echo json_encode($json);
break;


/*******************************************************************************
 *
 * 카테고리 추가
 *
 ******************************************************************************/
case "CategoryAdd":
	$req['table_board']  = Request('table_board');
	$req['board_id']	   = Request('board_id');
	$req['CategoryName'] = Request('CategoryName');

  if(!$req['table_board'] || !$req['board_id'] || !$req['CategoryName']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{
    $Field['TableName'] = $req['table_board'];
    $Field['BoardID']   = $req['board_id'];
    $Field['CategoryName'] = $req['CategoryName'];
    $Field['CategoryCode'] = SetBoardCategory();
    

    $CHECK = $db -> SelectOne("Select * From G__Category Where TableName = '".$Field['TableName']."' and BoardID = '".$Field['BoardID']."' and CategoryName = '".$Field['CategoryName']."'   ");

	$total_s = $db -> SelectOne("Select count(*) as cnt From G__Category Where TableName = '".$Field['TableName']."' and BoardID = '".$Field['BoardID']."'  ");
	$total_ = (int)$total_s["cnt"] + 1;

	$Field['sort']   = $total_;

    if($CHECK){
      $json['error'] = "Y";
      $json['msg']   = "등록된 카테고리명 입니다.";    
    }else{
      $Query = "INSERT INTO G__Category  (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
      $RESULT = $db->ExecQuery($Query);
      if($RESULT > 0){
          $json['error'] = "N";
          $json['msg']   = "카테고리(".$req['CategoryName'].")가 추가되었습니다.";
          $json['code']   = $Field['CategoryCode'];
		  $json['sort']   = $Field['sort'];
		  $json['CategoryName']   = $Field['CategoryName'];
      }else{
          $json['error'] = "Y";
          $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
      }
    }
  }
  echo json_encode($json);
break;


/*******************************************************************************
 *
 * 카테고리 수정
 *
 ******************************************************************************/
case "CategoryModify":

	$req['ccode']  = Request('ccode');
	$req['sort']  = Request('sort');
	$req['CategoryName']  = Request('CategoryName');
//	$req['sort']  = 1;
//	$req['CategoryName']  = "aa";

  if(!$req['ccode']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{
    $CHECK = $db -> SelectOne("Select * From G__Category Where CategoryCode = '".$req['ccode']."' ");
    if($CHECK){
      
	  $Query = "Update G__Category set sort = ".$req['sort'].", CategoryName = '".$req['CategoryName']."' Where CategoryCode = '".$req['ccode']."' ";

      $RESULT = $db->ExecQuery($Query);
      if($RESULT > 0){
          $json['error'] = "N";
          $json['msg']   = "카테고리(".$CHECK['CategoryName'].")가  수정되었습니다.";
          $json['code']   = $req['ccode'];
      }else{
          $json['error'] = "Y";
          $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
      }
    }else{
      $json['error'] = "Y";
      $json['msg']   = "잘못된 접근입니다.";    
    }
  }
  echo json_encode($json);
break;


/*******************************************************************************
 *
 * 카테고리 삭제
 *
 ******************************************************************************/
case "CategoryDelete":
	$req['ccode']  = Request('ccode');

  if(!$req['ccode']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{
    $CHECK = $db -> SelectOne("Select * From G__Category Where CategoryCode = '".$req['ccode']."' ");
    if($CHECK){
      $Query = "Delete from G__Category  Where CategoryCode = '".$req['ccode']."' ";
      $RESULT = $db->ExecQuery($Query);
      if($RESULT > 0){
          $json['error'] = "N";
          $json['msg']   = "카테고리(".$CHECK['CategoryName'].")가  삭제되었습니다.";
          $json['code']   = $req['ccode'];
      }else{
          $json['error'] = "Y";
          $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
      }
    }else{
      $json['error'] = "Y";
      $json['msg']   = "잘못된 접근입니다.";    
    }
  }
  echo json_encode($json);
break;
/*******************************************************************************
 *
 * End
 *
 ******************************************************************************/
endswitch;
}
?>