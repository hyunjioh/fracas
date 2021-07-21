<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;


	if(!$db -> CheckTable("G_Schedule")){
		$Q="
		CREATE TABLE IF NOT EXISTS `G_Schedule` (
			`idx` int(11) NOT NULL AUTO_INCREMENT,
			`fid` int(11) NOT NULL DEFAULT '0',
			`thread` varchar(20) NOT NULL DEFAULT '',
			`BoardID` varchar(30) NOT NULL DEFAULT '',
			`Category` varchar(30) NOT NULL DEFAULT '',
			`MemberID` varchar(20) NOT NULL DEFAULT '',
			`Name` varchar(20) NOT NULL DEFAULT '',
			`Passwd` varchar(20) NOT NULL DEFAULT '',
			`Subject` varchar(255) NOT NULL DEFAULT '',
			`Content` mediumtext NOT NULL,
			`Link1` varchar(255) NOT NULL DEFAULT '',
			`Html` char(1) NOT NULL DEFAULT '',
			`Secret` char(1) NOT NULL DEFAULT '',
			`Notice` char(1) NOT NULL DEFAULT '',
			`Hit` mediumint(8) NOT NULL DEFAULT '0',
			`startdate` datetime NOT NULL,
			`enddate` datetime NOT NULL,
			`dateY` varchar(4) NOT NULL DEFAULT '',
			`dateM` char(2) NOT NULL DEFAULT '',
			`dateD` char(2) NOT NULL DEFAULT '',
			`dateT` char(2) NOT NULL DEFAULT '',
			`Status` varchar(10) NOT NULL DEFAULT '',
			`GoodHit` mediumint(8) NOT NULL DEFAULT '0',
			`BadHit` mediumint(8) NOT NULL DEFAULT '0',
			`RegID` varchar(20) NOT NULL DEFAULT '',
			`RegIP` varchar(20) NOT NULL DEFAULT '',
			`RegDate` varchar(12) NOT NULL DEFAULT '',
			`UpdateID` varchar(20) NOT NULL DEFAULT '',
			`UpdateIP` varchar(20) NOT NULL DEFAULT '',
			`UpdateDate` varchar(12) NOT NULL DEFAULT '',
			PRIMARY KEY (`idx`)
		)";
		$db -> ExecQuery($Q);
	}


	if(!$db -> CheckTable("G_Schedule_Attach")){
		$Q="
		CREATE TABLE IF NOT EXISTS `G_Schedule_Attach` (
			`idx` int(11) NOT NULL AUTO_INCREMENT,
			`Pidx` varchar(11) NOT NULL DEFAULT '',
			`BoardID` varchar(30) NOT NULL DEFAULT '',
			`FileName` varchar(100) NOT NULL DEFAULT '',
			`SaveName` varchar(60) NOT NULL DEFAULT '',
			`FileSize` varchar(20) NOT NULL DEFAULT '',
			`FileType` varchar(30) NOT NULL DEFAULT '',
			`FileMemo` varchar(255) NOT NULL DEFAULT '',
			`FileGubun` varchar(10) NOT NULL DEFAULT '',
			`Down` int(11) NOT NULL DEFAULT '0',
			`RegIP` varchar(15) NOT NULL DEFAULT '',
			`RegDate` varchar(12) NOT NULL DEFAULT '',
			PRIMARY KEY (`idx`)
		)";
		$db -> ExecQuery($Q);
	}


	$req['idx'] = Request("idx");
	$req['mode'] = Request("am");


	$req['Hit']        = Input('Hit');
	$req['Hit']        = SetValue($req['Hit'],'digit', 0);

	$req['RegDate']    = Input('RegDate');
	$req['Html']       = Input('Html');
	$req['Notice']     = Input('Notice');
	$req['Notice']     = SetValue($req['Notice'],'alpha', 'N');
	$req['Secret']     = Input('Secret');
	$req['Secret']     = SetValue($req['Secret'],'alpha', 'N');
	$req['Category']   = Input('Category');


	$req['Link1']      = Input('Link1');
	$req['Subject']    = Input('Subject');
	$req['Content']    = Input('Content');


	$req['startdate'] = Request("startdate");
	$req['starttime'] = Request("starttime");
	$req['enddate']   = Request("enddate");
	$req['endtime']   = Request("endtime");


	if($req['startdate'] >= $req['enddate']){
		if(str_replace(":","",$req['starttime']) > str_replace(":","",$req['endtime'])) $req['endtime'] = $req['starttime'];
	}

	$req['start'] = $req['startdate']." ".$req['starttime'].":00";
	$req['end']   = $req['enddate']." ".$req['endtime'].":00";



	if($req['mode']){
		switch($req['mode']):
			

			case "newData":
					$Field = array(
						"fid"			    => Fid(),
						"thread"      => 'A',	
						"BoardID"     => $Board['board_id'],
						"Category"    => $req['Category'],
						"Html"        => $req['Html'],
						"Notice"      => $req['Notice'],
						"Secret"      => $req['Secret'],
						
					  "Link1"       => $req['Link1'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],

						"startdate"   => $req['start'],
						"enddate"     => $req['end'],

						"Hit"         => $req['Hit'],
						"MemberID"    => $_SESSION['_MEMBER_']['ID'],
						"RegID" 	    => $_SESSION['_MEMBER_']['ID'],
						"RegIP" 	    => ip_addr(),
						"RegDate"     => time(),


					);

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT =  $db -> ExecQuery($Query);
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						//AttachProcess($Pidx, $subDir);
            $msg = "등록되었습니다.";
            $json['error'] = "N";
            $json['msg']   = $msg;
					}else{
            $msg = "데이터처리중 장애가 발생하였습니다.";
            $json['error'] = "Y";
            $json['msg']   = $msg;
					}
          echo json_encode($json);
				break;





				case "updateData":
					$req['startdate'] = Request("startdate");
					$req['starttime'] = Request("starttime".$req['idx']);
					$req['enddate']   = Request("enddate");
					$req['endtime']   = Request("endtime".$req['idx']);

					if($req['startdate'] >= $req['enddate']){
						if(str_replace(":","",$req['starttime']) > str_replace(":","",$req['endtime'])) $req['endtime'] = $req['starttime'];
					}

					$req['start'] = $req['startdate']." ".$req['starttime'].":00";
					$req['end']   = $req['enddate']." ".$req['endtime'].":00";
					$Field = array(
						"BoardID"     => $Board['board_id'],
						"Category"    => $req['Category'],
						"Html"        => $req['Html'],
						"Notice"      => $req['Notice'],
						"Secret"      => $req['Secret'],

						
					  "Link1"       => $req['Link1'],
						"Subject"     => $req['Subject'],
						"Content"     => $req['Content'],

						"startdate"   => $req['start'],
						"enddate"     => $req['end'],

						"UpdateID" 	 => $_SESSION['_MEMBER_']['ID'],
						"UpdateIP" 	 => ip_addr(),
						"UpdateDate" =>  time()
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
					$RESULT =  $db -> ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
					if($RESULT > 0){
						$Pidx = LAST_INSERT_ID();
						$subDir = date("Y/m/d");
						//AttachProcess($Pidx, $subDir);
            $msg = "수정되었습니다.";
            $json['error'] = "N";
            $json['msg']   = $msg;
					}elseif($RESULT == 0){
            $msg = "수정된 내용이 없습니다.";
            $json['error'] = "Y";
            $json['msg']   = $msg;
					}else{
            $msg = "데이터처리중 장애가 발생하였습니다.";
            $json['error'] = "Y";
            $json['msg']   = $msg;
					}
          echo json_encode($json);
					break;



				case "dateMove":
					$req['idx'] = Request("idx");
					$req['datep']   = Request("datep");
          $Query = "Select * from ".$Board['table_board']." Where idx = '".$req['idx']."'  ";
          $Value  = $db -> SelectOne($Query);

          if($Value){
            $Value['start']  = strtotime($Value['startdate']) + 86400*$req['datep'];
            $Value['end']    = strtotime($Value['enddate']) + 86400*$req['datep'];
            $Field = array(
              "startdate"   => date("Y-m-d H:i:s",$Value['start']),
              "enddate"     => date("Y-m-d H:i:s",$Value['end']),
            );

            foreach($Field AS $key => $value) {
               $ret[] = $key."='".$value."'";
            }
            $RESULT = $db -> ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
            if($RESULT > 0){
              $Pidx = LAST_INSERT_ID();
              $subDir = date("Y/m/d");
              //AttachProcess($Pidx, $subDir);
              $json['error'] = "N";
            }elseif($RESULT == 0){
              $msg = "수정된 내용이 없습니다.";
              $json['error'] = "Y";
              $json['msg']   = $msg;
            }else{
              $msg = "데이터처리중 장애가 발생하였습니다.";
              $json['error'] = "Y";
              $json['msg']   = $msg;
            }
          }else{
            $msg = "잘못된 접근입니다.";
            $json['error'] = "Y";
            $json['msg']   = $msg;          
          }
          echo json_encode($json);
				break;

				case "dateResize":
					$req['idx'] = Request("idx");
					$req['dayp']   = Request("dayp");
          $Query = "Select * from ".$Board['table_board']." Where idx = '".$req['idx']."'  ";
          $Value  = $db -> SelectOne($Query);

          if($Value){
            $Value['end']    = strtotime($Value['enddate']) + 86400*$req['dayp'];
            $Field = array(
              "enddate"     => date("Y-m-d H:i:s",$Value['end']),
            );

            foreach($Field AS $key => $value) {
               $ret[] = $key."='".$value."'";
            }
            $RESULT = $db -> ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
            if($RESULT > 0){
              $Pidx = LAST_INSERT_ID();
              $subDir = date("Y/m/d");
              //AttachProcess($Pidx, $subDir);
              $json['error'] = "N";
            }elseif($RESULT == 0){
              $msg = "수정된 내용이 없습니다.";
              $json['error'] = "Y";
              $json['msg']   = $msg;
            }else{
              $msg = "데이터처리중 장애가 발생하였습니다.";
              $json['error'] = "Y";
              $json['msg']   = $msg;
            }
          }else{
            $msg = "잘못된 접근입니다.";
            $json['error'] = "Y";
            $json['msg']   = $msg;          
          }
          echo json_encode($json);
				break;



				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where BoardID='".$Board['board_id']."' and  idx = '".$req['idx']."'");

					if($CHECK){
							$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
              if($RESULT > 0){
                $Pidx = LAST_INSERT_ID();
                $subDir = date("Y/m/d");
                //AttachProcess($Pidx, $subDir);
                $msg = "삭제되었습니다.";
                $json['error'] = "N";
                $json['msg']   = $msg;
              }else{
                $msg = "데이터처리중 장애가 발생하였습니다.";
                $json['error'] = "Y";
                $json['msg']   = $msg;
              }
              echo json_encode($json);
					}
					break;



		endswitch;
	}
?>