<?
	if(!defined("_g_board_include_")) exit; // Inclde Check

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');

	$req['orgpasswd']  = Request('orgpasswd');
	$req['passwd1']  = Request('passwd1');
	$req['passwd2']  = Request('passwd2');

	if($req['mode']){
			switch($req['mode']):



				case "passwdUpdate":
					if(new_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

          if(strlen($req['passwd1']) < 4 || strlen($req['passwd2']) < 4 || strlen($req['orgpasswd']) < 4){
  						locationReplace($href,"필수항목 누락입니다.");                        
          }
          $req['orgpasswd'] = md5($req['orgpasswd']);
          $CHECK = $db -> SelectOne("Select * from ".$Board['table_board']." Where AdminID = '".decrypt_md5($_SESSION['_MANAGER_']['ID'],"sessionADMIN")."' ");

          if($CHECK){
            if($CHECK['AdminPW'] == $req['orgpasswd']){
              if($req['passwd1'] == $req['passwd2']){
                 $SQL = "Update ".$Board['table_board']." Set AdminPW = '".md5($req['passwd1'])."' Where AdminID = '".decrypt_md5($_SESSION['_MANAGER_']['ID'],"sessionADMIN")."' ";
                 $RESULT = $db->ExecQuery($SQL);
                if($RESULT > 0){
                  locationReplace($href,"수정되었습니다.");
                }elseif($RESULT == 0){
                  locationReplace($href,"변경된 내용이 없습니다.");
                }else{
                  locationReplace($href,"데이터 처리중 장애가 발생하였습니다.");				
                }
              }else{
                locationReplace($href,"변경하실 비밀번호가 정확하지 않습니다.");              
              }
            }else{
  						locationReplace($href,"현재 비밀번호가 정확하지 않습니다.");              
            }                      
          }
					break;


			endswitch;
	}
?>