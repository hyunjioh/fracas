<?
	if(!defined("_g_board_include_")) exit; // Inclde Check
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');

	$req['Hit']        = Input('Hit');
	$req['Hit']        = SetValue($req['Hit'],'digit', 0);

	$req['RegDate']    = Input('RegDate');
	$req['Html']       = Input('Html');
	$req['Notice']     = Input('Notice');
	$req['Notice']     = SetValue($req['Notice'],'alpha', 'N');
	$req['Secret']     = Input('Secret');
	$req['Secret']     = SetValue($req['Secret'],'alpha', 'N');
	$req['Category']   = Input('Category');

	$req['UserName']     = Input('Name');
	$req['UserID']       = $_SESSION['_MEMBER_']['ID'];
	$req['UserEmail']    = Input('Email');
	$req['UserHomepage'] = Input('Homepage');
	$req['UserTel']      = Input('Tel');
	$req['UserHp']       = Input('Hp');
	$req['Company']      = Input('Company');
	$req['Passwd']       = Input('Passwd');


	$req['Link1']      = Input('Link1');
	$req['Subject']    = Input('Subject');
	$req['Content']    = Input('Content');


	if(!$req['RegDate'])		$req['RegDate'] = date("Y-m-d");


	if($req['mode']){
			switch($req['mode']):










				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
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
					$RESULT = mysql_query($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						AttachProcess($Pidx, $subDir);
						locationReplace($href,$msg['data_registered']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;










				case "updateData":
					if(new_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"BoardID"     => $Board['board_id'],
						"Category"    => $req['Category'],
						"Html"        => $req['Html'],
						"Notice"      => $req['Notice'],
						"Secret"      => $req['Secret'],

						"UserName"     => $req['UserName'],
						"UserEmail"    => $req['UserEmail'],
						"UserTel"      => $req['UserTel'],
						"UserHp"       => $req['UserHp'],
						"UserHomepage" => $req['UserHomepage'],
						
					  "Link1"       => $req['Link1'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],

						"Hit"         => $req['Hit'],
						"RegDate"     => $req['RegDate'],
						"UpdateID" 	  => $req['UserID'],
						"UpdateIP" 	  => ip_addr(),
						"UpdateDate"  => time(),
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT = mysql_query("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
					if($RESULT > 0){
						$Pidx = $req['idx'];
						$subDir = date("Y/m/d");
						AttachSelectDel($Pidx, $_POST['files_del']);
						AttachProcess($Pidx, $subDir);
						locationReplace($href."&at=view&idx=$req[idx]",$msg['data_modified']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;





				case "replyData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
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
					$RESULT = mysql_query($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						AttachProcess($Pidx, $subDir);
						locationReplace($href,$msg['data_registered']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;






				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx = '".$req['idx']."'");
					$REPLY = $db -> Value("select idx from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx <> '".$req['idx']."' and fid = '".$CHECK['fid']."' and thread like '".$CHECK['thread']."%' and length(thread) > ".strlen($CHECK['thread'])." ");

					if($CHECK){
						if($REPLY){
							locationReplace($req['_referer_'],$msg['reply_exists']);										
						}else{
							$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
							if($RESULT >= 0){
								AttachDel($req['idx']);
								locationReplace($href,$msg['data_deleted']);
							}else{
								locationReplace($req['_referer_'],$msg['data_error']);				
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
						locationReplace($req['_referer_'],$msg['Password_is_incorrect']);									
					}
					break;









			endswitch;
	}
?>