<?
if(!defined("_g_board_include_")) exit;
###################################################################################################
/*
  - 상품카테고리 설정
  - 테이블명 : G_Product_Category
*/
###################################################################################################

$req['_referer_']	 = Request('_referer_');
$req['mode']			 = Request('am');

	if($req['mode']){
			switch($req['mode']):













				case "Depth1":
						$req['Name']			= Request('Name');
						$Depth1 = $db -> Value("Select max(Depth1) from ".$Board['table_board']." Where Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' ");
						if(!$Depth1){
							$Depth1 = 10;
						}else{
							$Depth1 = $Depth1+1;						
						}
						$Depth2 = "00";
						$Depth3 = "000";
						$Code = date("YmdHis").rand(1000,9999);

						$SortNum = $Depth1.$Depth2.$Depth3;

            $CHECK = $db -> SelectOne("Select Depth1 from ".$Board['table_board']." Where Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' and Name = '".$req['Name']."' ");
            if($CHECK){
                locationReplace($href."&at=write","같은이름의 카테고리가 존재합니다.");            
            }else{
              $Field = array(
                "Code"       => $Code,
                "Depth1"     => $Depth1,
                "Depth2"     => $Depth2,
                "Depth3"     => $Depth3,
                "SortNum"    => $SortNum,
                "Name"       => $req['Name'],
                "Gubun"      => $req['Gubun'],
              );
              $RESULT = $db -> ExecQuery("INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')");
              if($RESULT > 0){
                locationReplace($href."&at=write","등록되었습니다.");
              }else{
                locationReplace($href."&at=write","데이터 처리중 장애가 발생하였습니다.");				
              }		
            }
					break;


				case "Depth2":
						$req['Depth1']			= Request('Depth1');
						$req['Name']			= Request('Name');
						$Depth2 = $db -> Value("Select max(Depth2) from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' ");
						if(!$Depth2){
							$Depth2 = 10;
						}else{
							$Depth2 = $Depth2+1;						
						}
						$Depth1 = $req['Depth1'];
						$Depth3 = "000";
						$Code = date("YmdHis").rand(1000,9999);

						$SortNum = $Depth1.$Depth2.$Depth3;

            $CHECK = $db -> SelectOne("Select Depth1 from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' and Name = '".$req['Name']."' ");
            if($CHECK){
                locationReplace($href."&at=write","같은이름의 카테고리가 존재합니다.");            
            }else{
              $Field = array(
                "Code"       => $Code,
                "Depth1"     => $Depth1,
                "Depth2"     => $Depth2,
                "Depth3"     => $Depth3,
                "SortNum"    => $SortNum,
                "Name"       => $req['Name'],
                "Gubun"      => $req['Gubun'],
              );
              $RESULT = $db -> ExecQuery("INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')");
              if($RESULT > 0){
                locationReplace($href."&at=write&depth1=".$req['Depth1'],"등록되었습니다.");
              }else{
                locationReplace($href."&at=write&depth1=".$req['Depth1'],"데이터 처리중 장애가 발생하였습니다.");				
              }		
            }
					break;

				case "Depth3":
						$req['Depth1']			= Request('Depth1');
						$req['Depth2']			= Request('Depth2');
						$req['Name']			= Request('Name');
						$Depth3 = $db -> Value("Select max(Depth3) from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000' and Gubun='".$req['Gubun']."' ");
						if(!$Depth3){
							$Depth3 = 100;
						}else{
							$Depth3 = $Depth3+1;						
						}
						$Depth1 = $req['Depth1'];
						$Depth2 = $req['Depth2'];
						$Code = date("YmdHis").rand(1000,9999);

						$SortNum = $Depth1.$Depth2.$Depth3;

            $CHECK = $db -> SelectOne("Select Depth1 from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000' and Gubun='".$req['Gubun']."' and Name = '".$req['Name']."' ");
            if($CHECK){
                locationReplace($href."&at=write","같은이름의 카테고리가 존재합니다.");            
            }else{

              $Field = array(
                "Code"       => $Code,
                "Depth1"     => $Depth1,
                "Depth2"     => $Depth2,
                "Depth3"     => $Depth3,
                "SortNum"    => $SortNum,
                "Name"       => $req['Name'],
                "Gubun"      => $req['Gubun'],
              );
              $RESULT = $db -> ExecQuery("INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')");
              if($RESULT > 0){
                locationReplace($href."&at=write&depth1=".$req['Depth1']."&depth2=".$req['Depth2'],"등록되었습니다.");
              }else{
                locationReplace($href."&at=write&depth1=".$req['Depth1']."&depth2=".$req['Depth2'],"데이터 처리중 장애가 발생하였습니다.");				
              }		
            }
					break;




































				case "Depth1Select":
						$req['Depth1']	  = Request('Depth1');

						$LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' order by SortNum");
						$CHECK = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."'   ");
            if($CHECK){
              $json['count'] = $CHECK;
            }else{
              $json['count'] = 0;            
            }
            if($LIST){
              $i=0;
              for($i=0; $i < count($LIST); $i++){
                $json['item'][$i]['value'] = $LIST[$i]['Depth2'];
                $json['item'][$i]['title'] = $LIST[$i]['Name'];
              }
              $json['result'] = "YES";
            }else{
              $json['result'] = "NO";
            }
            echo json_encode($json);

					break;

				case "Depth2Select":
						$req['Depth1']	  = Request('Depth1');
						$req['Depth2']	  = Request('Depth2');

						$LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000' and Gubun='".$req['Gubun']."' order by SortNum ");
						$CHECK = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."' and PCategory2 = '".$req['Depth2']."'   ");
            if($CHECK){
              $json['count'] = $CHECK;
            }else{
              $json['count'] = 0;            
            }
            if($LIST){
              $i=0;
              for($i=0; $i < count($LIST); $i++){
                $json['item'][$i]['value'] = $LIST[$i]['Depth3'];
                $json['item'][$i]['title'] = $LIST[$i]['Name'];
              }
              $json['result'] = "YES";
            }else{
              $json['result'] = "NO";
            }
            echo json_encode($json);

					break;

				case "Depth3Select":
						$req['Depth1']	  = Request('Depth1');
						$req['Depth2']	  = Request('Depth2');
						$req['Depth3']	  = Request('Depth3');

						$CHECK = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."' and PCategory2 = '".$req['Depth2']."' and PCategory3 = '".$req['Depth3']."'    ");
            if($CHECK){
              $json['count'] = $CHECK;
            }else{
              $json['count'] = 0;            
            }
            echo json_encode($json);

					break;





				case "Category1Update":
					$req['Depth1']	 = Request('depth1');
					$req['Name']	  = Request('Name');
          $idx = $db -> Value("Select idx from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' ");

					$SortNum = $req['Depth1']."00"."000";	
					
					$Field = array(
						"Name"     => $req['Name'],
						"SortNum"  => $SortNum,
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}

          $CHECK = $db -> SelectOne("Select Depth1 from ".$Board['table_board']." Where Depth1 <> '".$req['Depth1']."' and Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' and Name = '".$req['Name']."' ");
          if($CHECK){
              $json['result'] = "EXISTS";            
          }else{
            $RESULT = $db -> ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE idx = '".$idx."' ");

            $LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' order by SortNum ");
            $CHECK = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."'   ");

            if($CHECK){
              $json['count'] = $CHECK;
            }else{
              $json['count'] = 0;            
            }
            if($LIST){
              $i=0;
              for($i=0; $i < count($LIST); $i++){
                $json['item'][$i]['value'] = $LIST[$i]['Depth1'];
                $json['item'][$i]['title'] = $LIST[$i]['Name'];
              }
              $json['result'] = "YES";
            }else{
              $json['result'] = "NO";
            }
          }
          echo json_encode($json);

				break;

				case "Category1Delete":
					$req['Depth1']	 = Request('depth1');
					$req['Name']	   = Request('Name');

          // 카테고리체크
          $Depth1Check  = $db -> Total("Select count(*)  from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 <> '000' and Gubun='".$req['Gubun']."' ");
          // 상품체크
					$ProductCheck = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."'   ");          

          $delete = false;
          if($Depth1Check > 0){
            $delete = true;
            $json['error'] = "A";
          }
          if($ProductCheck > 0){
            $delete = true;
            $json['error'] = "B";
          }

          if(!$delete){
            $RESULT = $db -> ExecQuery("Delete from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' ");
            if($RESULT){
              $LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth2 = '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' order by SortNum ");          
              if($LIST){
                $i=0;
                for($i=0; $i < count($LIST); $i++){
                  $json['item'][$i]['value'] = $LIST[$i]['Depth1'];
                  $json['item'][$i]['title'] = $LIST[$i]['Name'];
                }
                $json['result'] = "YES";
              }else{
                $json['result'] = "NO";
              }            
            }else{
              $json['error'] = "C";
            }

          }else{
            $json['error'] = "check";
          }
          echo json_encode($json);


				break;















				case "Category2Update":
					$req['Depth1']	  = Request('depth1');
					$req['Depth2']	  = Request('depth2');
					$req['Name']	    = Request('Name');
          $idx = $db -> Value("Select idx from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 = '000' and Gubun='".$req['Gubun']."' ");

					$SortNum = $req['Depth1'].$req['Depth2']."000";	
					
					$Field = array(
						"Name"     => $req['Name'],
						"SortNum"  => $SortNum,
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}

          $CHECK = $db -> SelectOne("Select Depth1 from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '".$req['Depth2']."' and Depth3 = '000' and Gubun='".$req['Gubun']."' and Name = '".$req['Name']."' ");
          if($CHECK){
              $json['result'] = "EXISTS";            
          }else{
            $RESULT = $db -> ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE idx = '".$idx."' ");

            $LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='".$req['Gubun']."' order by SortNum ");
            $CHECK = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."' and PCategory2 = '".$req['Depth2']."'   ");

            if($CHECK){
              $json['count'] = $CHECK;
            }else{
              $json['count'] = 0;            
            }
            if($LIST){
              $i=0;
              for($i=0; $i < count($LIST); $i++){
                $json['item'][$i]['value'] = $LIST[$i]['Depth2'];
                $json['item'][$i]['title'] = $LIST[$i]['Name'];
              }
              $json['result'] = "YES";
            }else{
              $json['result'] = "NO";
            }
          }
          echo json_encode($json);

				break;

				case "Category2Delete":
					$req['Depth1']	 = Request('depth1');
					$req['Depth2']	 = Request('depth2');
					$req['Name']	  = Request('Name');


          // 카테고리체크
          $Depth1Check  = $db -> Total("Select count(*)  from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000' and Gubun='".$req['Gubun']."' ");
          // 상품체크
					$ProductCheck = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."' and PCategory2 = '".$req['Depth2']."'   ");          

          $delete = false;
          if($Depth1Check > 0){
            $delete = true;
            $json['error'] = "A";
          }
          if($ProductCheck > 0){
            $delete = true;
            $json['error'] = "B";
          }

          if(!$delete){
            $RESULT = $db -> ExecQuery("Delete from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 = '000' and Gubun='".$req['Gubun']."' ");
            if($RESULT){
              $json['error'] = "N";
              $LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='".$req['Gubun']."'  order by SortNum ");          
              if($LIST){
                $i=0;
                for($i=0; $i < count($LIST); $i++){
                  $json['item'][$i]['value'] = $LIST[$i]['Depth2'];
                  $json['item'][$i]['title'] = $LIST[$i]['Name'];
                }
                $json['result'] = "YES";
              }else{
                $json['result'] = "NO";
              }            
            }else{
              $json['error'] = "C";
            }

          }else{
            $json['error'] = "check";
          }
          echo json_encode($json);
				break;












				case "Category3Update":
					$req['Depth1']	  = Request('depth1');
					$req['Depth2']	  = Request('depth2');
					$req['Depth3']	  = Request('depth3');
					$req['Name']	    = Request('Name');
          $idx = $db -> Value("Select idx from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 = '".$req['Depth3']."' and Gubun='".$req['Gubun']."' ");

					$SortNum = $req['Depth1'].$req['Depth2'].$req['Depth3'];	
					
					$Field = array(
						"Name"     => $req['Name'],
						"SortNum"  => $SortNum,
					);

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}
          $CHECK = $db -> SelectOne("Select Depth1 from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '".$req['Depth3']."' and Gubun='".$req['Gubun']."' and Name = '".$req['Name']."' ");
          if($CHECK){
              $json['result'] = "EXISTS";            
          }else{

            $RESULT = $db -> ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE idx = '".$idx."' ");

            $LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000' and Gubun='".$req['Gubun']."' order by SortNum ");
            $CHECK = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."' and PCategory2 = '".$req['Depth2']."'  and PCategory3 = '".$req['Depth3']."'   ");

            if($CHECK){
              $json['count'] = $CHECK;
            }else{
              $json['count'] = 0;            
            }
            if($LIST){
              $i=0;
              for($i=0; $i < count($LIST); $i++){
                $json['item'][$i]['value'] = $LIST[$i]['Depth3'];
                $json['item'][$i]['title'] = $LIST[$i]['Name'];
              }
              $json['result'] = "YES";
            }else{
              $json['result'] = "NO";
            }
          }
          echo json_encode($json);

				break;

				case "Category3Delete":
					$req['Depth1']	 = Request('depth1');
					$req['Depth2']	 = Request('depth2');
					$req['Depth3']	 = Request('depth3');
					$req['Name']	   = Request('Name');

          // 상품체크
					$ProductCheck = $db -> Total("Select count(*) from G_Product Where PCategory1 = '".$req['Depth1']."' and PCategory2 = '".$req['Depth2']."' and PCategory3 = '".$req['Depth3']."'  ");          

          $delete = false;

          if($ProductCheck > 0){
            $delete = true;
            $json['error'] = "B";
          }

          if(!$delete){
            $RESULT = $db -> ExecQuery("Delete from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 = '".$req['Depth3']."' and Gubun='".$req['Gubun']."' ");
            if($RESULT){
              $json['error'] = "N";
              $LIST = $db -> SelectList("Select * from ".$Board['table_board']." Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000' and Gubun='".$req['Gubun']."' order by SortNum ");          
              if($LIST){
                $i=0;
                for($i=0; $i < count($LIST); $i++){
                  $json['item'][$i]['value'] = $LIST[$i]['Depth3'];
                  $json['item'][$i]['title'] = $LIST[$i]['Name'];
                }
                $json['result'] = "YES";
              }else{
                $json['result'] = "NO";
              }            
            }else{
              $json['error'] = "C";
            }

          }else{
            $json['error'] = "check";
          }
          echo json_encode($json);
				break;




			endswitch;
	}
?>