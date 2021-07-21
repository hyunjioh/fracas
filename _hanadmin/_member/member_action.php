<?
	if(!defined("_g_board_include_")) exit; // Inclde Check

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');

	if(!$req['RegDate'])		$req['RegDate'] = date("Y-m-d");


	if($req['mode']){
			switch($req['mode']):

        // 회원삭제
				case "deleteData":
          if(!$req['mid']) toplocationhref("/");
          $req['mid'] = decrypt_md5($req['mid'],'mid');
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where m_id  = '".$req['mid']."'");
					if($CHECK){
              $RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE m_id  = '".$req['mid']."'");
              if($RESULT >= 0){
                locationReplace($href,"삭제되었습니다.");
              }else{
                locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
              }
					}else{
							locationReplace($Board['Link']);						
					}
				break;

        // 선택삭제
        case "checkDelete":
          $req['gidx'] = Request("gidx");
          $RESULT_Total = 0 ;
          if($req['gidx']){
            foreach($req['gidx'] as $gkey => $gvalue){
              $req['mid'] = decrypt_md5($gvalue,'mid');
              $RESULT = $db -> ExecQuery("DELETE from ".$Board['table_board']." WHERE m_id = '".$req['mid']."'");
              $RESULT_Total = $RESULT_Total + $RESULT;
            }
          }
          toplocationHref($req['_referer_'],$RESULT_Total."명 삭제 되었습니다." );
        break;

       // 상태변경
       case "StatusUpdate":
        	$req['status']        = Request('status');
          if(!$req['mid']) toplocationhref(_ADMIN_);
          if(!$req['status']) toplocationhref(_ADMIN_);
          $req['mid'] = decrypt_md5($req['mid'],'mid');
          $Query = "Update ".$Board['table_board']." Set m_status = '".$req['status']."' Where m_id  = '".$req['mid']."' ";
          $RESULT = $db -> ExecQuery($Query);
          if($RESULT >= 0){
            locationReplace($req['_referer_'],"변경되었습니다.");				          
          }else{
            locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				          
          }
       break;

       // 인증상태 변경
       case "AuthUpdate":
        	$req['auth']        = Request('auth');
          if(!$req['mid']) toplocationhref(_ADMIN_);
          if(!$req['auth']) toplocationhref(_ADMIN_);
          $req['mid'] = decrypt_md5($req['mid'],'mid');
          $Query = "Update ".$Board['table_board']." Set m_auth = '".$req['auth']."' Where m_id  = '".$req['mid']."' ";
          echo $Query;
          $RESULT = $db -> ExecQuery($Query);
          if($RESULT >= 0){
            locationReplace($req['_referer_'],"변경되었습니다.");				          
          }else{
            locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				          
          }
        break;

        
        /*
        case "excelMemberInsert":
          @ini_set('memory_limit',-1);
          function XID($lid){
            global $db;
            $QUERY = sprintf("SELECT g_XID FROM G_Member WHERE ( g_XID = '%s')  ", $lid);	
            $DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
            if(!$DATA){
              return $lid;
            }
          }
          $XID = false;
          while($XID == false){
            $XID = XID(authNumber(14));							
          }


          function MemberNum(){
            global $db;
            $MemberNum =	"1".rand(100000000,999999999);


            $Value = $db -> Value("Select m_id  from G_Member Where m_id  = '$MemberNum'");
            if($Value){
              MemberNum();
            }else{
              return $MemberNum;
            }
          }

          require_once _CORE_PATH_.'/plugin/phpExcelReader/reader.php';
          require_once _CORE_PATH_.'/plugin/phpExcelReader/oleread.php';
          $data = new Spreadsheet_Excel_Reader();
          $data->setUTFEncoder('iconv');
          $data->setOutputEncoding('UTF-8');

          $UploadConfig['savePath'] = "./temp/";
          $savename = date("Ymdhis").rand('1111111111','9999999999');
          $filePath = $UploadConfig['savePath'].$savename;


          if($_FILES['excel']['tmp_name']){
            $execel_type = array("application/vnd.ms-excel","application/octet-stream","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            if(!in_array($_FILES['excel']['type'],$execel_type)){
              echo "<script>alert('엑셀파일만 업로드 가능합니다.');</script>";
              exit;
            }

            if(move_uploaded_file($_FILES['excel']['tmp_name'], $filePath)){
              $data->read($filePath);
              echo "<pre>";
              if($data->sheets[0]['numRows'] > 1){
                $RESULT_TOTAL = 0;
                $date = date("Y-m-d H:i:s");
                for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
                  unset($Field);

                  
                  $req['c_passwd'] = md5("111111");
                  $req['c_email'] = authNumber(12).$data->sheets[0]['cells'][$i][1];
                  $req['birth'] = explode("/",$data->sheets[0]['cells'][$i][4]);
                  $req['g_UserBirth'] = $req['birth'][2]."-".$req['birth'][1]."-".$req['birth'][0];

                  $Field['m_id']     = MemberNum();
                  $Field['g_UserID']      = authNumber(12)."@".$data->sheets[0]['cells'][$i][1];
                  $Field['g_UserPass']    = $req['c_passwd'];
                  $Field['g_UserName']    = $data->sheets[0]['cells'][$i][2];
                  $Field['g_UserEmail']   = $req['c_email'];
                  $Field['g_UserPhone']   = $data->sheets[0]['cells'][$i][3];
                  $Field['g_regDate']     = $date;
                  $Field['g_exit_flag']   = "N";
                  $Field['g_UserBirth']   = $req['g_UserBirth'];
                  $Field['g_UserSex']     = $data->sheets[0]['cells'][$i][5];
                  $Field['g_UserAge']     = $data->sheets[0]['cells'][$i][6];
                  $Field['g_UserNick']    = $data->sheets[0]['cells'][$i][2];
                  $Field['g_OpenAge']     = "Y";
                  $Field['g_UserRegion1'] =  $data->sheets[0]['cells'][$i][7];
                  $Field['g_UserBlood']   =  $data->sheets[0]['cells'][$i][8];
                  $Field['g_UserGroup']   =  $data->sheets[0]['cells'][$i][9];
                  $Field['g_UserJob']     =  $data->sheets[0]['cells'][$i][10];
                  $Field['g_UserHeight']  =  $data->sheets[0]['cells'][$i][11];
                  $Field['g_UserColor']   =  $data->sheets[0]['cells'][$i][12];
                  $Field['g_UserReligion'] =  $data->sheets[0]['cells'][$i][13];
                  $Field['g_XID']          = $XID;
                  $Field['g_Visit']        = 1;
                  $Field['g_LastVisit']    = $date;
                  $Field['g_Level']        = "D";
                  $Field['g_RealMember']   = "N";
                  $Field['g_JoinStatus']   = "normal";
    							$Query = "INSERT INTO G_Member (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
    							$RESULT = $db -> ExecQuery($Query);
                  $RESULT_TOTAL = $RESULT_TOTAL + $RESULT;
                } //end for
              }
            }

            if($filePath ){
              //@unlink($filePath);
            }
          }

          if(!isset($RESULT_TOTAL)){
            echo "<script>alert('등록가능한 데이터가 없습니다.');</script>";
            echo "<script>location.href='member.php';</script>";
          }else{
            echo "<script>alert('총 $RESULT_TOTAL 건을 등록하였습니다.');</script>";
            echo "<script>location.href='member.php';</script>";
          }

         break;
         */



			endswitch;
	}
?>