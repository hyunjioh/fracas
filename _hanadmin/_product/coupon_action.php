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
	$req['Comment']		= Request('Comment');



	if($req['mode']){
			switch($req['mode']):










				case "newData":
					if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);
					$req['CouponName']		= Request('CouponName');
					$req['CouponCnt']			= Request('CouponCnt');
					$req['LimitDate']			= Request('LimitDate');
					$req['Pcode']		    	= Request('Pcode');
					$req['CouponCode'] = date("YmdHis").rand(000000,999999);

					for($i=0; $i < $req['CouponCnt']; $i++){
						$req['Coupon'] = rand_alpla(4)."-".rand_num(4)."-".rand_alphanum(4)."-".rand_num(4);
						$CHECK = $db -> SelectOne("Select idx from G_Coupon Where Coupon = '".$req['Coupon']."' ");
						if(!$CHECK){
							$Field = array(
								"CouponCode"  => $req['CouponCode'],
								"CouponName"  => $req['CouponName'],
								"LimitDate"   => $req['LimitDate'],
								"Pcode"       => $req['Pcode'],
								"PubDate"     => $date,
								"Coupon"      => $req['Coupon']
							);
							$RESULT = $db -> ExecQuery("INSERT INTO G_Coupon (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')");
						}else{
							$i = $i-1;
						}

					}
			
					if($RESULT > 0){
						locationReplace($req['_referer_'],"등록 되었습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
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
						locationReplace($href."&at=view&idx=$req[idx]","수정되었습니다.");
					}elseif($RESULT == 0){
						locationReplace($href,"변경된 내용이 없습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;



				case "delete":
					$CHECK = $db -> SelectOne("select * from G_Coupon where  idx = '".$req['idx']."'");

					if($CHECK){
						$RESULT = $db -> ExecQuery("DELETE From G_Coupon WHERE  idx = '".$req['idx']."'");
            if($RESULT >= 0){
              locationReplace($href,"삭제되었습니다.");
            }else{
              locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
            }
					}else{
							//locationReplace($Board['Link']);						
					}
					break;

				case "deleteData":
					$CHECK = $db -> SelectOne("select * from G_Coupon where  idx = '".$req['idx']."'");

					if($CHECK){
						$RESULT = $db -> ExecQuery("DELETE From G_Coupon WHERE  CouponCode = '".$CHECK['CouponCode']."'");
            if($RESULT >= 0){
              locationReplace($href,"삭제되었습니다.");
            }else{
              locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
            }

					}else{
							//locationReplace($Board['Link']);						
					}
					break;















	


			endswitch;
	}
?>