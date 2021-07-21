<?
	if(!defined("_g_board_include_")) exit; // Inclde Check
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');


	$req['mode']			= Request('am');
	$req['MemberID']	= Request('MemberID');
	$req['Point']			= Request('Point');
	$req['PointDate']	= Request('PointDate');
	$req['Comment']		= Request('Comment');



	if(!$req['PointDate'])		$req['PointDate'] = date("Y-m-d");
	if(!$req['RegDate'])		$req['RegDate'] = date("Y-m-d");


	if($req['mode']){
			switch($req['mode']):










				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"RegID"       => $_SESSION['_MEMBER_']['ID'],
						"MemberID"    => $req['MemberID'],
						"Point"       => $req['Point'],
						"Comment"     => $req['Comment'],
						"PointDate"   => $req['PointDate'],
						"RegDate"     => $req['RegDate'],
						"BoardID"     => $Board['board_id'],
					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = mysql_query($Query);
					if($RESULT > 0){
						if($req['PointDate'] > date("Y-m-d")){
							$POINTRESULT = 1;
						}else{
							$Pidx = LAST_INSERT_ID();
							$POINTRESULT = mysql_query("Update G_Member set h_point = h_point + ".$req['Point']." Where h_id='".$req['MemberID']."'");
						}
						if($POINTRESULT > 0){
							locationReplace($href,$msg['data_registered']);
						}else{
							mysql_query("Delete from ".$Board['table_board']."   Where idx='".$Pidx."'");
							locationReplace($req['_referer_'],$msg['data_error']);				
						}						
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
						"Comment"     => $req['Comment'],
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT = mysql_query("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
					if($RESULT > 0){
						locationReplace($href."&at=modify&idx=$req[idx]",$msg['data_modified']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;



				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx = '".$req['idx']."'");

					if($CHECK){
						$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
						if($RESULT >= 0){
							locationReplace($href,$msg['data_deleted']);
						}else{
							locationReplace($req['_referer_'],$msg['data_error']);				
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