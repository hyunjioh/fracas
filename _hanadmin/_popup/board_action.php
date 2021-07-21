<?
	if(!defined("_g_board_include_")) exit; // Inclde Check
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');

	$req['Subject']    = Input('Subject');
	$req['Content']    = Input('Content');
	$req['Display']    = Request("Display");

	$req['startdate']  = Request("startdate");
	$req['starttime']  = Request("starttime");
	$req['enddate']    = Request("enddate");
	$req['endtime']    = Request("endtime");

	$req['leftpos']       = Request("leftpos");
	$req['toppos']        = Request("toppos");

	$req['Width']        = Request("Width");
	$req['Height']       = Request("Height");

	if(!$req['RegDate'])		$req['RegDate'] = date("Y-m-d");

	if($req['startdate'] >= $req['enddate']){
		if(str_replace(":","",$req['starttime']) > str_replace(":","",$req['endtime'])) $req['endtime'] = $req['starttime'];
	}

	$req['start'] = $req['startdate']." ".$req['starttime'].":00";
	$req['end']   = $req['enddate']." ".$req['endtime'].":00";

	if($req['mode']){
			switch($req['mode']):










				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					$Field = array(
						"Display"     => $req['Display'],
						"StartTime"   => $req['start'],
						"EndTime"     => $req['end'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],
						"RegDate"     => $req['RegDate'],
						"leftpos"     => $req['leftpos'],
						"toppos"      => $req['toppos'],
						"Width"       => $req['Width'],
						"Height"      => $req['Height'],
					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = mysql_query($Query);
					if($RESULT > 0){
						locationReplace($Board['Link']."?$parameter",$msg['data_registered']);
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
						"Display"     => $req['Display'],
						"StartTime"   => $req['start'],
						"EndTime"     => $req['end'],
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
					$RESULT = mysql_query("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE idx = '".$req['idx']."'");
					if($RESULT > 0){
						locationReplace($Board['Link']."?at=view&idx=$req[idx]&$parameter",$msg['data_modified']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;





				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where  idx = '".$req['idx']."'");
					if($CHECK){
						$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE  idx = '".$req['idx']."'");
						if($RESULT >= 0){
							locationReplace($Board['Link']."?".$Link,$msg['data_deleted']);
						}else{
							locationReplace($req['_referer_'],$msg['data_error']);				
						}
					}else{
							locationReplace($Board['Link']);						
					}
					break;









			endswitch;
	}
?>