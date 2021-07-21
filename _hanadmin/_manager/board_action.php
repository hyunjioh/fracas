<?
	if(!defined("_g_board_include_")) exit; // Inclde Check
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');

	$req['m_id']  = Request('m_id');
	$req['m_id']  = SetValue($req['m_id'],'alnum');
	$req['m_name']  = Request('m_name');
	$req['m_level']  = Request('m_level');
	$req['m_passwd1']  = Request('m_passwd1');
	$req['m_passwd2']  = Request('m_passwd2');
	$req['m_jumin1']  = Request('m_jumin1');
	$req['m_jumin2']  = Request('m_jumin2');
	$req['m_jumin1']  = SetValue($req['m_jumin1'],'digit');
	$req['m_jumin2']  = SetValue($req['m_jumin2'],'digit');	
	$req['m_zip1']  = Request('m_zip1');
	$req['m_zip2']  = Request('m_zip2');
	$req['m_zip1']  = SetValue($req['m_zip1'],'digit');	
	$req['m_zip2']  = SetValue($req['m_zip2'],'digit');	
	$req['m_addr1']  = Request('m_addr1');
	$req['m_addr2']  = Request('m_addr2');
	$req['m_email1']  = Request('m_email1');
	$req['m_email2']  = Request('m_email2');
	$req['m_email3']  = Request('m_email3');
	$req['m_tel1']  = Request('m_tel1');
	$req['m_tel2']  = Request('m_tel2');
	$req['m_tel3']  = Request('m_tel3');
	$req['m_tel1']  = SetValue($req['m_tel1'],'digit');	
	$req['m_tel2']  = SetValue($req['m_tel2'],'digit');	
	$req['m_tel3']  = SetValue($req['m_tel3'],'digit');	
	$req['m_hp1']  = Request('m_hp1');
	$req['m_hp2']  = Request('m_hp2');
	$req['m_hp3']  = Request('m_hp3');
	$req['m_hp1']  = SetValue($req['m_hp1'],'digit');	
	$req['m_hp2']  = SetValue($req['m_hp2'],'digit');	
	$req['m_hp3']  = SetValue($req['m_hp3'],'digit');	
	$req['m_smsyn']  = Request('m_smsyn');
	$req['m_emailyn']  = Request('m_emailyn');
	$req['m_smsyn']  = SetValue($req['m_smsyn'],'alpha','N');	
	$req['m_emailyn']  = SetValue($req['m_emailyn'],'alpha','N');	
	$req['m_nick']  = Request('m_nick');


	if(trim($req['m_email2']) != ""){
		$req['m_email'] = $req['m_email1']."@".$req['m_email2'];
	}else{
		$req['m_email'] = $req['m_email1']."@".$req['m_email3'];
	}


	$pwchange = false;
	if($req['m_passwd1']){
			if($req['m_passwd1'] != $req['m_passwd2']){
				locationReplace("./",'비밀번호가 일치하지 않습니다.');
			}else{
				$pwchange = true;
				$req['m_passwd'] = md5($req['m_passwd1']);
			}
	}


	if($req['mode']){
			switch($req['mode']):

				case "updateData":
					if(new_token($Board['board_id']) == false) locationReplace("./",'비정상적인 접근입니다.');
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);

					if($pwchange){
						$Field = array(
							"h_name"    => $req['m_name'],
							"h_nick"      => $req['m_nick'],
							"h_passwd"=> $req['m_passwd'],
							"h_email"    => $req['m_email'],
							"h_mip" 	     => $set['IP'],
							"h_mdate"   => $set['Time'],
						);
					}else{
						$Field = array(
							"h_name"  => $req['m_name'],
							"h_nick"    => $req['m_nick'],
							"h_email"  => $req['m_email'],
							"h_mip" 	   => $set['IP'],
							"h_mdate" => $set['Time'],
						);					
					}

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT = mysql_query("UPDATE G_Member SET ".implode(",", $ret)." WHERE h_id = '".$_SESSION['_MEMBER_']['ID']."'");
					if($RESULT > 0){
						locationReplace("./","수정되었습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터처리중 장애가 발생하였습니다.");				
					}
					break;











			endswitch;
	}
?>