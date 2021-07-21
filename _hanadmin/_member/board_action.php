<?
	if(!defined("_g_board_include_")) exit; // Inclde Check
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');


	$req['m_id']    = Input('h_id');
	$req['m_nick']    = Input('h_nick');
	$req['m_name']  = Input('h_name');
	$req['m_jumin1']   = Input('h_jumin1');
	$req['m_jumin2']   = Input('h_jumin2');
	$req['m_hp1']       = Input('h_hp1');
	$req['m_hp2']       = Input('h_hp2');
	$req['m_hp3']       = Input('h_hp3');
	$req['m_tel1']       = Input('h_tel1');
	$req['m_tel2']       = Input('h_tel2');
	$req['m_tel3']       = Input('h_tel3');
	$req['m_fax1']      = Input('h_fax1');
	$req['m_fax2']      = Input('h_fax2');
	$req['m_fax3']      = Input('h_fax3');
	$req['m_email1']   = Input('h_email1');
	$req['m_email2']   = Input('h_email2');

	$req['m_zip1']      = Input('h_zip1');
	$req['m_zip2']      = Input('h_zip2');
	$req['m_addr1']   = Input('h_addr1');
	$req['m_addr2']   = Input('h_addr2');
	$req['m_emailyn']   = Input('h_emailyn');
	$req['m_level']        = Input('h_level');
	$req['m_passwd1']   = Input('h_passwd1');

	$req['m_level'] = SetValue($req['m_level'],'digit', 1);

	if(trim($req['m_email2']) != ""){
		$req['m_email'] = $req['m_email1']."@".$req['m_email2'];
	}else{
		$req['m_email'] = $req['m_email1']."@".$req['m_email3'];
	}

	$AddField = null;

	if($req['mode']){
			switch($req['mode']):










				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);


					$QUERY = sprintf("SELECT h_id, h_name, h_email, h_jumin FROM ".$Board['table_board']." WHERE ( h_id = '%s')  ", $req['m_id']);	
					$DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
					if(is_array($DATA)){
						if( $DATA["h_id"] == $req['m_id']) 	toplocationHref($req['_referer_'],'등록된 아이디 입니다.');
						if($_SESSION['_MEMBER_']['LEVEL']<9){
							if( $DATA["h_jumin"] == $req['m_jumin'] ) 	toplocationHref($req['_referer_'],'등록된 주민등록번호 입니다.');
							if( $DATA["h_email"] == $req['m_email']) 	toplocationHref($req['_referer_'],'등록된 이메일 입니다.');
						}
					}


					$Field = array(
						"h_id"     => $req['m_id'],
						"h_name"   => $req['m_name'],
						"h_nick"   => $req['m_nick'],
						"h_level"  => $req['m_level'],
						"h_passwd" => md5($req['m_passwd1']),
						"h_jumin"  => $req['m_jumin1']."-".$req['m_jumin2'],
						"h_zip"    => $req['m_zip1']."-".$req['m_zip2'],
						"h_addr1"  => $req['m_addr1'],
						"h_addr2"  => $req['m_addr2'],
						"h_email"  => $req['m_email'],
						"h_tel"    => $req['m_tel1']."-".$req['m_tel2']."-".$req['m_tel3'],
						"h_fax"     => $req['m_fax1']."-".$req['m_fax2']."-".$req['m_fax3'],
						"h_hp"     => $req['m_hp1']."-".$req['m_hp2']."-".$req['m_hp3'],
						"h_wip" 	 => ip_addr(),
						"h_wdate"  => time(),
						"h_emailyn" => $req['m_emailyn']
					);

					$Query = "INSERT INTO ".$Board['table_board']."  (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = mysql_query($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						AttachProcess($Pidx, $subDir);
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

					$QUERY = sprintf("SELECT h_id, h_name, h_email, h_jumin FROM ".$Board['table_board']." WHERE ( h_idx <> '%s' and h_id = '$s')  ", $req['idx'], $req['m_id']);	
					$DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
					if(is_array($DATA)){
						toplocationHref($req['_referer_'],'등록된 아이디 입니다.');
					}
					$QUERY = sprintf("SELECT h_id, h_name, h_email, h_jumin FROM ".$Board['table_board']." WHERE ( h_idx <> '%s' and h_email = '$s')  ", $req['idx'], $req['m_email'] );	
					$DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
					if(is_array($DATA)){
						toplocationHref($req['_referer_'],'등록된 이메일 입니다.');
					}
					$QUERY = sprintf("SELECT h_id, h_name, h_email, h_jumin FROM ".$Board['table_board']." WHERE ( h_idx <> '%s' and h_jumin = '$s')  ", $req['idx'], $req['m_jumin1']."-".$req['m_jumin2']);	
					$DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
					if(is_array($DATA)){
						toplocationHref($req['_referer_'],'등록된 주민등록번호 입니다.');
					}


					$Field = array(
						"h_name"   => $req['m_name'],
						"h_nick"   => $req['m_nick'],
						"h_level"  => $req['m_level'],
						"h_jumin"  => $req['m_jumin1']."-".$req['m_jumin2'],
						"h_zip"    => $req['m_zip1']."-".$req['m_zip2'],
						"h_addr1"  => $req['m_addr1'],
						"h_addr2"  => $req['m_addr2'],
						"h_email"  => $req['m_email'],
						"h_tel"    => $req['m_tel1']."-".$req['m_tel2']."-".$req['m_tel3'],
						"h_hp"     => $req['m_hp1']."-".$req['m_hp2']."-".$req['m_hp3'],
						"h_fax"     => $req['m_fax1']."-".$req['m_fax2']."-".$req['m_fax3'],
						"h_mip" 	 => ip_addr(),
						"h_mdate"  => time(),
						"h_emailyn" => $req['m_emailyn']
					);

					if($req['m_passwd1'])  $AddField = array("h_passwd" => md5($req['m_passwd1']));

					if($AddField) $Field = array_merge($Field, $AddField);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT = mysql_query("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE  h_idx = '".$req['idx']."'");
					if($RESULT > 0){
						$Pidx = $req['idx'];
						$subDir = date("Y/m/d");
						AttachSelectDel($Pidx, $_POST['files_del']);
						AttachProcess($Pidx, $subDir);
						locationReplace($Board['Link']."?at=view&idx=$req[idx]&$parameter",$msg['data_modified']);
					}else{
						locationReplace($req['_referer_'],$msg['data_error']);				
					}
					break;







				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where  h_idx = '".$req['idx']."'");

					if($CHECK){
							$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE  h_idx = '".$req['idx']."'");
							if($RESULT >= 0){
								//AttachDel($req['idx']);
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