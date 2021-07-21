<?
	if(!defined("_g_board_include_")) exit; // Inclde Check
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');


	$req['ProdTitle']    = Input('ProdTitle');
	$req['ProdDesc']     = Input('ProdDesc');
	$req['ProdDivision'] = Input('ProdDivision');
	$req['ProdRegion']   = Input('ProdRegion');
	$req['ProdAddr']     = Input('ProdAddr');
	$req['OrgPrice']     = Input('OrgPrice');
	$req['SalePrice']    = Input('SalePrice');
	$req['SaleRatio']    = Input('SaleRatio');
	$req['MaxCnt']			 = Input('MaxCnt');
	$req['DealCnt']			 = Input('DealCnt');
	$req['SaleCnt']			 = Input('SaleCnt');
	$req['StockCnt']   	 = Input('StockCnt');
	$req['StartDate']    = Input('StartDate');
	$req['EndDate']      = Input('EndDate');
	$req['SaleEnd']      = Input('SaleEnd');
	$req['SellerID']     = Input('SellerID');
	$req['SellerName']   = Input('SellerName');
	$req['SellerAddr']   = Input('SellerAddr');

	$req['Blind']      = Input('Blind');
	$req['ListView']   = Input('ListView');

	$req['Blind'] = ($req['Blind'])? $req['Blind'] : "N";
	$req['ListView'] = ($req['Blind'])? $req['ListView'] : "N";
	$req['SaleEnd'] = ($req['Blind'])? $req['SaleEnd'] : "N";

	function Upload($attach){
		global  $db,  $Board, $_FILES;
		$subDir = date("Y/m/d");
		$cfg['file']['savePath']      = _UPLOAD_PATH_."/".$Board['board_id']."/".$subDir;
		$cfg['file']['fileMaxSize']   = $Board['file_max_size'];
		$cfg['file']['fileCheckType'] = $Board['file_check_type'];
		$cfg['file']['checkExt']      = $Board['file_check_ext'];
		
		$cfg['file']['checkExt'] = explode("|",$cfg['file']['checkExt']);
		switch( strtoupper(substr($cfg['file']['fileMaxSize'],-1))  ){
			Case "K": $cfg['file']['fileMaxSize'] = substr($cfg['file']['fileMaxSize'],0,-1)*1024; break;
			Case "M": $cfg['file']['fileMaxSize'] = substr($cfg['file']['fileMaxSize'],0,-1)*1024*1024; break;
			Case "G": $cfg['file']['fileMaxSize'] = substr($cfg['file']['fileMaxSize'],0,-1)*1024*1024*1024;	break;
			default : $cfg['file']['fileMaxSize'] = _UPLOAD_MAX_SIZE_;
		}
		$subdir = str_replace(_UPLOAD_PATH_,"",$cfg['file']['savePath']);	

		$return = null;
		$AttachFile = AttachFile($_FILES[$attach], $cfg['file'], '','');

		if(is_array($AttachFile)){
			if($AttachFile['result'] == true){
				$return = $subdir."/".$AttachFile['SaveName'];
			}
		}

		return $return;
	}

	if($req['mode']){
			switch($req['mode']):










				case "newData":
					//if(check_token($Board['board_id']) == false) locationReplace($Board['Link'],$msg['access_deny']);
					/*-------------------------------------------------------------------------------------------------
					▶ 쿼리를 실행하면 결과에 상관없이 글 작성시 생성한 글 세션을 비운다. */
					destory_token($Board['board_id']);
					$req['Pcode'] = date("Y").random_string(10);
					$Field = array(
						"BoardID"     => $Board['board_id'],
						"Pcode"     => $req['Pcode'],
						"ProdTitle"     => $req['ProdTitle'],
						"ProdDesc"     => $req['ProdDesc'],
						"ProdDivision"     => $req['ProdDivision'],
						"ProdRegion"     => $req['ProdRegion'],
						"ProdAddr"     => $req['ProdAddr'],
						"OrgPrice"     => $req['OrgPrice'],
						"SalePrice"     => $req['SalePrice'],
						"SaleRatio"     => $req['SaleRatio'],
						"MaxCnt"     => $req['MaxCnt'],
						"DealCnt"     => $req['DealCnt'],
						"SaleCnt"     => $req['SaleCnt'],
						"StartDate"     => $req['StartDate'],
						"EndDate"     => $req['EndDate'],
						"SaleEnd"     => $req['SaleEnd'],
						"SellerID"     => $req['SellerID'],
						"SellerName"     => $req['SellerName'],
						"SellerAddr"     => $req['SellerAddr'],
						"Blind"     => $req['Blind'],
						"ListView"     => $req['ListView'],
					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = mysql_query($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$ImageThumb = Upload("ImageThumb");
						$ImageBanner = Upload("ImageBanner");
						$ImageList = Upload("ImageList");
						$ImageTicket = Upload("ImageTicket");
						$ImageMain = Upload("ImageMain");
						$ImagePrice = Upload("ImagePrice");
						$ImageInfo = Upload("ImageInfo");

						if($ImageThumb)  $FileField[ImageThumb] =$ImageThumb;
						if($ImageBanner)  $FileField[ImageBanner] =$ImageBanner;
						if($ImageList)  $FileField[ImageList] =$ImageList;
						if($ImageTicket)  $FileField[ImageTicket] =$ImageTicket;
						if($ImageMain)  $FileField[ImageMain] =$ImageMain;
						if($ImagePrice)  $FileField[ImagePrice] =$ImagePrice;
						if($ImageInfo)  $FileField[ImageInfo] =$ImageInfo;
						if($FileField){
						foreach($FileField AS $key => $value) {
							 $ret[] = $key."='".$value."'";
						}
						$RESULT = mysql_query("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$Pidx."'");
						}
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
						"ProdTitle"     => $req['ProdTitle'],
						"ProdDesc"     => $req['ProdDesc'],
						"ProdDivision"     => $req['ProdDivision'],
						"ProdRegion"     => $req['ProdRegion'],
						"ProdAddr"     => $req['ProdAddr'],
						"OrgPrice"     => $req['OrgPrice'],
						"SalePrice"     => $req['SalePrice'],
						"SaleRatio"     => $req['SaleRatio'],
						"MaxCnt"     => $req['MaxCnt'],
						"DealCnt"     => $req['DealCnt'],
						"SaleCnt"     => $req['SaleCnt'],
						"StartDate"     => $req['StartDate'],
						"EndDate"     => $req['EndDate'],
						"SaleEnd"     => $req['SaleEnd'],
						"SellerID"     => $req['SellerID'],
						"SellerName"     => $req['SellerName'],
						"SellerAddr"     => $req['SellerAddr'],

						"Blind"     => $req['Blind'],
						"ListView"     => $req['ListView'],
					);

						$ImageThumb = Upload("ImageThumb");
						$ImageBanner = Upload("ImageBanner");
						$ImageList = Upload("ImageList");
						$ImageTicket = Upload("ImageTicket");
						$ImageMain = Upload("ImageMain");
						$ImagePrice = Upload("ImagePrice");
						$ImageInfo = Upload("ImageInfo");

						if($ImageThumb)  $FileField[ImageThumb] =$ImageThumb;
						if($ImageBanner)  $FileField[ImageBanner] =$ImageBanner;
						if($ImageList)  $FileField[ImageList] =$ImageList;
						if($ImageTicket)  $FileField[ImageTicket] =$ImageTicket;
						if($ImageMain)  $FileField[ImageMain] =$ImageMain;
						if($ImagePrice)  $FileField[ImagePrice] =$ImagePrice;
						if($ImageInfo)  $FileField[ImageInfo] =$ImageInfo;
						if($FileField){
							$Field = array_merge($Field, $FileField);
						}

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