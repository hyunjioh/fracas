<?
	if(!defined("_g_board_include_")) exit; // Inclde Check

	$req['_referer_']	 = Request('_referer_');
	$req['mode']			 = Request('am');

	if(!$req['RegDate'])		$req['RegDate'] = date("Y-m-d");


	if($req['mode']){
			switch($req['mode']):



				case "deleteData":
          if(!$req['mid']) toplocationhref("/");
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where g_UserNum  = '".$req['mid']."'");
					if($CHECK){
              $RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE g_UserNum  = '".$req['mid']."'");
              if($RESULT >= 0){
                $CHECKsub = $db -> SelectOne("select * from G_Member_Sub where  MemberNo = '".$gvalue."'");
                if($CHECKsub){
                  $db -> ExecQuery("DELETE From G_Member_Sub WHERE MemberNo = '".$gvalue."'");
                  if($CHECKSub['s_Photo_01'] && file_exists(_ROOT_.$CHECKSub['s_Photo_01'])) @unlink(_ROOT_.$CHECKSub['s_Photo_01']);
                  if($CHECKSub['s_Photo_02'] && file_exists(_ROOT_.$CHECKSub['s_Photo_02'])) @unlink(_ROOT_.$CHECKSub['s_Photo_02']);
                  if($CHECKSub['s_Photo_03'] && file_exists(_ROOT_.$CHECKSub['s_Photo_03'])) @unlink(_ROOT_.$CHECKSub['s_Photo_03']);
                  if($CHECKSub['s_Photo_04'] && file_exists(_ROOT_.$CHECKSub['s_Photo_04'])) @unlink(_ROOT_.$CHECKSub['s_Photo_04']);
                  if($CHECKSub['s_Photo_05'] && file_exists(_ROOT_.$CHECKSub['s_Photo_05'])) @unlink(_ROOT_.$CHECKSub['s_Photo_05']);
                }
                locationReplace($href,"삭제되었습니다.");
              }else{
                locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
              }
					}else{
							locationReplace($Board['Link']);						
					}
					break;








			endswitch;
	}
?>