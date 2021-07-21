<?
	if(!defined("_g_board_include_")) exit; // Inclde Check

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
	$req['UserID']       = decrypt_md5($_SESSION['_MANAGER_']['ID'],"sessionADMIN");
	$req['UserEmail']    = Input('Email');
	$req['UserHomepage'] = Input('Homepage');
	$req['UserTel']      = Input('Tel');
	$req['UserHp']       = Input('Hp');
	$req['Company']      = Input('Company');
	$req['Passwd']       = Input('Passwd');

	$req['Category'] = $req['cname']    = Input('cname');

	$req['Link1']      = Input('Link1');
	$req['Subject']    = Input('Subject');
	$req['Content']    = Input('Content');


	if(!$req['RegDate'])		$req['RegDate'] = $dateTime;


	if($req['mode']){
			switch($req['mode']):
        case "MemoSendALL":
        	$SQL = Request("eq");   
        	$req['Memo']   = Input('Memo');
          $Query = decrypt_md5($SQL,'regexcel@)!@');
          $LIST = $db -> SelectList($Query);      
          if($LIST){
            $SUM = 0;
            foreach($LIST as $key => $Value){
              $Field['UserID']  = $Value['g_UserID'];
              $Field['Memo']    = $req['Memo'];
              $Field['RegID']   = $req['UserID'];
              $Field['ExpireDate']   = time()+86400*7;
              $Field['RegDate']      = date("Y-m-d H:i:s");
              $RESULT = $db -> ExecQuery("INSERT INTO G_MemoBox (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')");
              $SUM = $SUM + $RESULT; 
            }
            locationReplace($req['_referer_'],$SUM."건 등록되었습니다.");		
          }else{
            locationReplace($req['_referer_'],"선택된 회원이 없습니다.");		
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





				case "checkDelete":
					$req[gidx] = Request("gidx");		
					if($req[gidx]){
						foreach($req[gidx] as $gkey => $gvalue){
							$req['NewCodeName'] = Request("CodeName_".$gvalue);
							$req['NewCodeSort'] = Request("CodeSort_".$gvalue);
							$Field = array(
								"CodeName"    => $req['NewCodeName'],
								"CodeSort"    => $req['NewCodeSort'],
							);
							foreach($Field AS $key => $value) {
								 $ret[] = $key."='".$value."'";
							}
							$RESULT = $db -> ExecQuery("DELETE from ".$Board['table_board']." WHERE idx = '".$gvalue."'");
						}						
					}
					toplocationHref($req['_referer_'],"삭제 되었습니다." );			
				break;





			endswitch;
	}
?>