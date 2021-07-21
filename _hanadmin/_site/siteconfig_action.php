<?
if(!defined("_g_board_include_")) exit; 
###################################################################################################
/*
  - 홈페이지 팝업관리
  - G_Popup : 원글 저장
*/
###################################################################################################
$req['_referer_']	 = Request('_referer_');
$req['mode']			 = Request('am');

$req['sms_callback']       = Input('sms_callback');
$req['postmaster_email']   = Input('postmaster_email');
$req['postmaster_name']    = Input("postmaster_name");


	if($req['mode']){
			switch($req['mode']):
				case "updateData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

          $CHECK = $db -> SelectOne("select *  from ".$Board['table_board']." ");

					$Field = array(
						"sms_callback"      => $req['sms_callback'],
						"postmaster_email"  => $req['postmaster_email'],
						"postmaster_name"   => $req['postmaster_name'],
					);

          if($CHECK){
            foreach($Field AS $key => $value) {
               $ret[] = $key."='".$value."'";
            }
  					$Query = "UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE idx = '".$req['idx']."'";
          }else{
  					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
          }
					$RESULT = $db->ExecQuery($Query);
					if($RESULT > 0){
						locationReplace($href,"수정되었습니다.");
					}elseif($RESULT == 0){
						locationReplace($href,"변경된 내용이 없습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;
			endswitch;
	}
?>