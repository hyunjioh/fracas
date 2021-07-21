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


$req['RegDate']    = Input('RegDate');
if(!$req['RegDate'])	$req['RegDate']  = $dateTime;

$req['Hit']        = Input('Hit');
$req['Html']       = Input('Html');
$req['Display']    = Input("Display");
$req['Hit']        = SetValue($req['Hit'],'digit', 0);
$req['Html']       = SetValue($req['Html'],'alpha', 'Y');
$req['Display']    = SetValue($req['Display'],'alpha', 'N');


$req['Subject']    = Input('Subject');
$req['Content']    = Input('Content');

$req['StartDate']  = Input('StartDate');
$req['EndDate']    = Input('EndDate');

$req['leftpos']       = Request("leftpos");
$req['toppos']        = Request("toppos");

$req['Width']        = Request("Width");
$req['Height']       = Request("Height");


	if($req['mode']){
			switch($req['mode']):



				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"Display"     => $req['Display'],
						"StartDate"   => $req['StartDate'],
						"EndDate"     => $req['EndDate'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],
						"RegDate"     => $req['RegDate'],
						"leftpos"     => $req['leftpos'],
						"toppos"      => $req['toppos'],
						"Width"       => $req['Width'],
						"Height"      => $req['Height'],
					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = $db->ExecQuery($Query);
					if($RESULT > 0){
						locationReplace($href,"등록 되었습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;










				case "updateData":
					if(new_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"Display"     => $req['Display'],
						"StartDate"   => $req['StartDate'],
						"EndDate"     => $req['EndDate'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],
						"leftpos"     => $req['leftpos'],
						"toppos"      => $req['toppos'],
						"Width"       => $req['Width'],
						"Height"      => $req['Height'],
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT = $db->ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE idx = '".$req['idx']."'");
					if($RESULT > 0){
						locationReplace($href."&at=view&idx=$req[idx]","수정되었습니다.");
					}elseif($RESULT == 0){
						locationReplace($href,"변경된 내용이 없습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;


				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where  idx = '".$req['idx']."'");
					if($CHECK){
						$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE  idx = '".$req['idx']."'");
						if($RESULT >= 0){
								locationReplace($href,"삭제되었습니다.");
						}else{
							locationReplace($req['_referer_'],"데이터처리중 장애가 발생하였습니다.");				
						}
					}else{
							locationReplace($Board['Link']);						
					}
					break;



				case "checkDelete":
					$req[gidx] = Request("gidx");		
					if($req[gidx]){
						foreach($req[gidx] as $gkey => $gvalue){
							$RESULT = $db -> ExecQuery("DELETE from ".$Board['table_board']." WHERE idx = '".$gvalue."'");
						}						
					}
					toplocationHref($req['_referer_'],"삭제 되었습니다." );			
				break;





			endswitch;
	}
?>