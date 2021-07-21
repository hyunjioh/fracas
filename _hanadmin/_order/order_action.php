<?
	if(!defined("_g_board_include_")) exit; // Inclde Check

	$Board['table_board'] = "G_Order";
	$Board['table_board_2'] = "G_Item";

	$req['_referer_']	= Request('_referer_');
	$req['mode']		= Request('am');

	$req['OrderNum']	= Input('OrderNum');
	$req['OrderStatus']	= Input('OrderStatus');
	$req['OrderType']="";
	$req['CancelDate']="";
	if($req['OrderStatus']=="end"){
		$req['OrderType']="normal";
		$req['CancelDate']="";
	} elseif($req['OrderStatus']=="cancel"){
		$req['OrderType']="cancel";
		$req['CancelDate']=date("Y-m-d H:i:s");
	}


	if($req['mode']){
			switch($req['mode']):

				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"fid"			    => Fid(),
						"thread"      => 'A',	
						"BoardID"     => $Board['board_id'],
						"Category"    => $req['Category'],
						"Html"        => $req['Html'],
						"Notice"      => $req['Notice'],
						"Secret"      => $req['Secret'],

						"UserID"       => $req['UserID'],
						"UserName"     => $req['UserName'],
						"UserEmail"    => $req['UserEmail'],
						"UserTel"      => $req['UserTel'],
						"UserHp"       => $req['UserHp'],
						"UserHomepage" => $req['UserHomepage'],
						
					  "Link1"       => $req['Link1'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],

						"Hit"         => $req['Hit'],
						"RegID" 	    => $req['UserID'],
						"RegIP" 	    => ip_addr(),
						"RegDate"     => $req['RegDate'],
					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = $db->ExecQuery($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						AttachProcess($Pidx, $subDir);
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
						
						"OrderStatus"	=> $req['OrderStatus'],
						"OrderType"		=> $req['OrderType'],
						"CancelDate"	=> $req['CancelDate']
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT = $db->ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE OrderNum = '".$req['OrderNum']."' ");
					if($RESULT > 0){
						$RESULT2 = $db->ExecQuery("UPDATE ".$Board['table_board_2']." SET ".implode(",", $ret)." WHERE OrderNum = '".$req['OrderNum']."' ");
						if($RESULT2){
							locationReplace($href."&at=modify&OrderNum=$req[OrderNum]","수정되었습니다.");
						} else{
							locationReplace($req['_referer_'],"관리자에게 문의하세요.");
						}
						
					}elseif($RESULT == 0){
						locationReplace($href,"변경된 내용이 없습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;


				case "replyData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],"정상적인 접근이 아닙니다.");
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Thread = Thread($req['idx']);
					$Field = array(
						"fid"			    => $Thread['fid'],
						"thread"      => $Thread['thread'],	
						"BoardID"     => $Board['board_id'],
						"Category"    => $req['Category'],
						"Html"        => $req['Html'],
						"Notice"      => $req['Notice'],
						"Secret"      => $req['Secret'],

						"UserID"       => $req['UserID'],
						"UserName"     => $req['UserName'],
						"UserEmail"    => $req['UserEmail'],
						"UserTel"      => $req['UserTel'],
						"UserHp"       => $req['UserHp'],
						"UserHomepage" => $req['UserHomepage'],
						
					  "Link1"       => $req['Link1'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],

						"Hit"         => $req['Hit'],
						"RegID" 	    => $req['UserID'],
						"RegIP" 	    => ip_addr(),
						"RegDate"     => $req['RegDate'],
					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = $db->ExecQuery($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						AttachProcess($Pidx, $subDir);
						locationReplace($href,"등록 되었습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;






				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx = '".$req['idx']."'");
					$REPLY = $db -> Value("select idx from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx <> '".$req['idx']."' and fid = '".$CHECK['fid']."' and thread like '".$CHECK['thread']."%' and length(thread) > ".strlen($CHECK['thread'])." ");

					if($CHECK){
						if($REPLY){
							locationReplace($req['_referer_'],"답변이 존재하여 삭제되지 않습니다.");										
						}else{
							$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
							if($RESULT >= 0){
								AttachDel($req['idx']);
								locationReplace($href,"삭제되었습니다.");
							}else{
								locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
							}
						}
					}else{
							locationReplace($Board['Link']);						
					}
					break;


				case "pwCkeck":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx = '".$req['idx']."' and Passwd = '".$req['chkPasswd']."' ");					
					if($CHECK){
						$_SESSION[$key] = md5($req['chkPasswd']);
						$parameter = ($req['nextmode'] == "dataprocess")? $parameter .= "&am=deleteData":"";
						locationReplace($href."&at=".$req['nextmode']."&idx=".$req['idx']);
					}else{
						locationReplace($req['_referer_'],"비밀번호가 정확하지 않습니다.");									
					}
					break;



				case "checkDelete":
					$req[gOrderNum] = Input("gOrderNum");

					if($req[gOrderNum]){
						foreach($req[gOrderNum] as $gkey => $gvalue){
							$req['NewCodeName'] = Request("CodeName_".$gvalue);
							$req['NewCodeSort'] = Request("CodeSort_".$gvalue);
							$Field = array(
								"CodeName"    => $req['NewCodeName'],
								"CodeSort"    => $req['NewCodeSort'],
							);
							foreach($Field AS $key => $value) {
								 $ret[] = $key."='".$value."'";
							}

							$RESULT = $db -> ExecQuery("DELETE from ".$Board['table_board']." WHERE OrderNum = '".$gvalue."'");
							$RESULT2 = $db -> ExecQuery("DELETE from G_Item WHERE OrderNum = '".$gvalue."'");
						}						
					}
					toplocationHref($req['_referer_'],"삭제 되었습니다." );			
				break;


			endswitch;
	}
?>