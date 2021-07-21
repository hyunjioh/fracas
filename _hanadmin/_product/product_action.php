<?
if(!defined("_g_board_include_")) exit; 
###################################################################################################
/*
  - 상품관리
  - 테이블명 : G_Product, G_Product_Category
*/
###################################################################################################
$req['_referer_']	 = Request('_referer_');
$req['mode']			 = Request('am');

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




	if($req['mode']){

		if($req['mode'] == "ProductAdd" || $req['mode'] == "ProductModify" || $req['mode'] == "ProductCopy"  ){
					$req['ProdTitle']     = Input('ProdTitle');
					$req['ProdSubTitle']  = Input('ProdSubTitle');

					$req['PCategory1']    = Input('PCategory1');
					$req['PCategory2']    = Input('PCategory2');
					$req['PCategory3']    = Input('PCategory3');

					$req['Wonga']         = Input('Wonga');
					$req['OrgPrice']      = Input('OrgPrice');
					$req['SalePrice']     = Input('SalePrice');
					$req['SaleRatio']     = Input('SaleRatio');
					$req['DeliveryPrice'] = Input('DeliveryPrice');
					$req['FreeDelivery']    = Input('FreeDelivery');
					$req['DeliveryCompany'] = Input('DeliveryCompany');

					$req['MaxCnt']			 = Input('MaxCnt');
					$req['SaleCnt']			 = Input('SaleCnt');
					$req['SaleStatus']   = Input('SaleStatus');

					$req['ProdMemo1']   = Input('ProdMemo1');
					$req['ProdMemo2']   = Input('ProdMemo2');
					$req['ProdMemo3']   = Input('ProdMemo3');

					$req['ProdInfo01']   = Input('ProdInfo01');
					$req['ProdInfo02']   = Input('ProdInfo02');
					$req['ProdInfo03']   = Input('ProdInfo03');
					$req['ProdInfo04']   = Input('ProdInfo04');
					$req['ProdInfo05']   = Input('ProdInfo05');
					$req['ProdInfo06']   = Input('ProdInfo06');

					$req['SortNum']   = Input('SortNum');

					$req['Option1Name']   = Input('Option1Name');
					$req['Option1Cnt']   = Input('Option1Cnt');
					$req['Option1Wonga']   = Input('Option1Wonga');
					$req['Option1OrgPrice']   = Input('Option1OrgPrice');
					$req['Option1SalePrice']   = Input('Option1SalePrice');
					$req['Option1SaleRatio']   = Input('Option1SaleRatio');
					$req['DelCompany']   = Input('DelCompany');
					$req['AmountDisplay']   = Input('AmountDisplay');

					$req['InstantDeal']   = Input('InstantDeal');
					$req['OptionCart']   = Input('OptionCart');
					$req['OptionCartNum']   = Input('OptionCartNum');

					if(!$req['OptionCart']) $req['OptionCart'] = "N";

					$req['Option2Parent']   = $_POST['Option2Name'];
					$req['Option2Name']   = $_POST['Option2Name'];
					$req['Option2Cnt']   = $_POST['Option2Cnt'];
					$req['Option2Wonga']   = $_POST['Option2Wonga'];
					$req['Option2OrgPrice']   = $_POST['Option2OrgPrice'];
					$req['Option2SalePrice']   = $_POST['Option2SalePrice'];
					$req['Option2SaleRatio']   = $_POST['Option2SaleRatio'];

					$req['Option1Name'] = @implode("^^",$req['Option1Name']);
					$req['Option1Cnt'] = @implode("^^",$req['Option1Cnt']);
					$req['Option1Wonga'] = @implode("^^",$req['Option1Wonga']);
					$req['Option1OrgPrice'] = @implode("^^",$req['Option1OrgPrice']);
					$req['Option1SalePrice'] = @implode("^^",$req['Option1SalePrice']);
					$req['Option1SaleRatio'] = @implode("^^",$req['Option1SaleRatio']);





					if(is_array($req['Option2Name'] )){
						foreach($req['Option2Name'] as $key => $value){
							if(is_array($value)){
								foreach($value as $keys => $values){					
									$set['Option2Name'][] = $values;
									$set['Option2Parent'][] = $key;
								}
							}
						}


					foreach($req['Option2Cnt'] as $key => $value){
						if(is_array($value)){
							foreach($value as $keys => $values){					
								$set['Option2Cnt'][] = $values;
							}
						}
					}

					foreach($req['Option2Wonga'] as $key => $value){
						if(is_array($value)){
							foreach($value as $keys => $values){					
								$set['Option2Wonga'][] = $values;
							}
						}
					}

					foreach($req['Option2OrgPrice'] as $key => $value){
						if(is_array($value)){
							foreach($value as $keys => $values){					
								$set['Option2OrgPrice'][] = $values;
							}
						}
					}

					foreach($req['Option2SalePrice'] as $key => $value){
						if(is_array($value)){
							foreach($value as $keys => $values){					
								$set['Option2SalePrice'][] = $values;
							}
						}
					}

					foreach($req['Option2SaleRatio'] as $key => $value){
						if(is_array($value)){
							foreach($value as $keys => $values){					
								$set['Option2SaleRatio'][] = $values;
							}
						}
					}
					}
					$req['Option2Parent'] = @implode("^^",$set['Option2Parent']);
					$req['Option2Name'] = @implode("^^",$set['Option2Name']);
					$req['Option2Cnt'] = @implode("^^",$set['Option2Cnt']);
					$req['Option2Wonga'] = @implode("^^",$set['Option2Wonga']);
					$req['Option2OrgPrice'] = @implode("^^",$set['Option2OrgPrice']);
					$req['Option2SalePrice'] = @implode("^^",$set['Option2SalePrice']);
					$req['Option2SaleRatio'] = @implode("^^",$set['Option2SaleRatio']);


		}


			switch($req['mode']):

				case "CategoryList1":
						$req['Depth1']	  = Request('depth1');
						

						$Depth1 = $db -> SelectList("Select * from G_Product_Category Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='product' ");
						if($Depth1){
							echo "<select name='PCategory2'		id='Category2' onChange='Category2Select();'>";
							echo "<option value=''>카테고리2을 선택하세요.</option>";
							foreach($Depth1 as $key => $value){
								echo "<option value='".$value['Depth2']."'>".$value['Name']."</option>";
							}
							echo "</select>";
						}

					break;


				case "CategoryList2":
						$req['Depth1']	  = Request('depth1');
						$req['Depth2']	  = Request('depth2');
						

						$Depth1 = $db -> SelectList("Select * from G_Product_Category Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000'  and Gubun='product'  ");
						if($Depth1){
							echo "<select name='PCategory3'		id='Category3' >";
							echo "<option value=''>카테고리3을 선택하세요.</option>";
							foreach($Depth1 as $key => $value){
								echo "<option value='".$value['Depth3']."'>".$value['Name']."</option>";
							}
							echo "</select>";
						}

					break;


				case "DivisionList1":
						$req['Depth1']	  = Request('depth1');
						

						$Depth1 = $db -> SelectList("Select * from G_Product_Category Where Depth1 = '".$req['Depth1']."' and Depth2 <> '00' and Depth3 = '000' and Gubun='product' ");
						if($Depth1){
							echo "<select name='ProdDivision2'		id='Division2' onChange='Division2Select();'>";
							echo "<option value=''>분류2을 선택하세요.</option>";
							foreach($Depth1 as $key => $value){
								echo "<option value='".$value['Depth2']."'>".$value['Name']."</option>";
							}
							echo "</select>";
						}

					break;


				case "DivisionList2":
						$req['Depth1']	  = Request('depth1');
						$req['Depth2']	  = Request('depth2');
						

						$Depth1 = $db -> SelectList("Select * from G_Product_Category Where Depth1 = '".$req['Depth1']."' and Depth2 = '".$req['Depth2']."' and Depth3 <> '000'  and Gubun='product'  ");
						if($Depth1){
							echo "<select name='ProdDivision3'		id='Division3' >";
							echo "<option value=''>분류3을 선택하세요.</option>";
							foreach($Depth1 as $key => $value){
								echo "<option value='".$value['Depth3']."'>".$value['Name']."</option>";
							}
							echo "</select>";
						}

					break;





				case "ProductAdd":
					$req['Pcode'] = ProductCode($req['PGubun'], $req['PType']);

					$Field = array(
						"Pcode"          => 	$req['Pcode'],
						"ProdTitle"      => 	$req['ProdTitle'],
						"ProdSubTitle"   => 	$req['ProdSubTitle'],
						"PCategory1"     => 	$req['PCategory1'],
						"PCategory2"     => 	$req['PCategory2'],
						"PCategory3"     => 	$req['PCategory3'],

						"Wonga"         => 	$req['Wonga'],
						"OrgPrice"      => 	$req['OrgPrice'],
						"SalePrice"     => 	$req['SalePrice'],
						"SaleRatio"     => 	$req['SaleRatio'],

						"MaxCnt"        => 	$req['MaxCnt'],
						"SaleCnt"       => 	$req['SaleCnt'],

						"DeliveryPrice"    => 	$req['DeliveryPrice'],
						"FreeDelivery"     => 	$req['FreeDelivery'],
						"DeliveryCompany"  => 	$req['DeliveryCompany'],
						"SaleStatus"       => 	$req['SaleStatus'],

						"ProdMemo1"        => 	$req['ProdMemo1'],
						"ProdMemo2"        => 	$req['ProdMemo2'],
						"ProdMemo3"        => 	$req['ProdMemo3'],

						"ProdInfo01"        => 	$req['ProdInfo01'],
						"ProdInfo02"        => 	$req['ProdInfo02'],
						"ProdInfo03"        => 	$req['ProdInfo03'],
						"ProdInfo04"        => 	$req['ProdInfo04'],
						"ProdInfo05"        => 	$req['ProdInfo05'],
						"ProdInfo06"        => 	$req['ProdInfo06'],

						"SortNum"           => 	$req['SortNum'],


						"Option1Name"       => 	$req['Option1Name'],
						"Option1Wonga"      => 	$req['Option1Wonga'],
						"Option1OrgPrice"   => 	$req['Option1OrgPrice'],
						"Option1SalePrice"  => 	$req['Option1SalePrice'],
						"Option1SaleRatio"  => 	$req['Option1SaleRatio'],
						"Option1Cnt"        => 	$req['Option1Cnt'],

						"Option2Parent"     => 	$req['Option2Parent'],

						"Option2Name"       => 	$req['Option2Name'],
						"Option2Wonga"      => 	$req['Option2Wonga'],
						"Option2OrgPrice"   => 	$req['Option2OrgPrice'],
						"Option2SalePrice"  => 	$req['Option2SalePrice'],
						"Option2SaleRatio"  => 	$req['Option2SaleRatio'],
						"Option2Cnt"        => 	$req['Option2Cnt'],

						"RegDate"           =>  $dateTime,
						"RegID"             => 	decrypt_md5($_SESSION['_MANAGER_']['ID']),
					);

					if($_FILES["ProdImage01"]['tmp_name'][$k]){
						$AttachReturn = AttachFile($_FILES["ProdImage01"], $cfg['file'], '','');
						if($AttachReturn){
							$Field['ProdImage01']  = _UPLOAD_.$subdir."/".$AttachReturn['SaveName'];			
						}
					}

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
					$RESULT = $db -> ExecQuery($Query);

					if($RESULT){
						locationReplace($href,"등록되었습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;



				case "ProductCopy":
					$req['P_Pcode']    = Input('P_Pcode');
					$req['Pcode'] = ProductCode($req['PGubun'], $req['PType']);


					$Field = array(
						"Pcode"          => 	$req['Pcode'],
						//"P_Pcode"        => 	$req['P_Pcode'],
						"ProdTitle"      => 	$req['ProdTitle'],
						"ProdSubTitle"   => 	$req['ProdSubTitle'],
						"PCategory1"     => 	$req['PCategory1'],
						"PCategory2"     => 	$req['PCategory2'],
						"PCategory3"     => 	$req['PCategory3'],

						"Wonga"         => 	$req['Wonga'],
						"OrgPrice"      => 	$req['OrgPrice'],
						"SalePrice"     => 	$req['SalePrice'],
						"SaleRatio"     => 	$req['SaleRatio'],

						"MaxCnt"        => 	$req['MaxCnt'],
						"SaleCnt"       => 	$req['SaleCnt'],

						"DeliveryPrice"    => 	$req['DeliveryPrice'],
						"FreeDelivery"     => 	$req['FreeDelivery'],
						"DeliveryCompany"  => 	$req['DeliveryCompany'],
						"SaleStatus"       => 	$req['SaleStatus'],

						"ProdMemo1"        => 	$req['ProdMemo1'],
						"ProdMemo2"        => 	$req['ProdMemo2'],
						"ProdMemo3"        => 	$req['ProdMemo3'],


						"ProdInfo01"        => 	$req['ProdInfo01'],
						"ProdInfo02"        => 	$req['ProdInfo02'],
						"ProdInfo03"        => 	$req['ProdInfo03'],
						"ProdInfo04"        => 	$req['ProdInfo04'],
						"ProdInfo05"        => 	$req['ProdInfo05'],
						"ProdInfo06"        => 	$req['ProdInfo06'],

						"SortNum"           => 	$req['SortNum'],

						"Option1Name"       => 	$req['Option1Name'],
						"Option1Wonga"      => 	$req['Option1Wonga'],
						"Option1OrgPrice"   => 	$req['Option1OrgPrice'],
						"Option1SalePrice"  => 	$req['Option1SalePrice'],
						"Option1SaleRatio"  => 	$req['Option1SaleRatio'],
						"Option1Cnt"        => 	$req['Option1Cnt'],

						"Option2Parent"     => 	$req['Option2Parent'],

						"Option2Name"       => 	$req['Option2Name'],
						"Option2Wonga"      => 	$req['Option2Wonga'],
						"Option2OrgPrice"   => 	$req['Option2OrgPrice'],
						"Option2SalePrice"  => 	$req['Option2SalePrice'],
						"Option2SaleRatio"  => 	$req['Option2SaleRatio'],
						"Option2Cnt"        => 	$req['Option2Cnt'],
						"RegDate"    =>   $dateTime,
						"RegID"      => 	decrypt_md5($_SESSION['_MANAGER_']['ID']),
					);
					if($_FILES["files"]['tmp_name'][$k]){
						$AttachReturn = AttachFile($_FILES["files"], $cfg['file'], '','');
						if($AttachReturn){
							$Field['ProdImage01']  = $subdir."/".$AttachReturn['SaveName'];			
						}
					}

					$Query = "INSERT INTO ".$Board['table_board']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";	//echo $Query;
					//exit;
					$RESULT = $db -> ExecQuery($Query);

					if($RESULT){
						locationReplace($href."&at=write","등록되었습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;

				case "ProductModify":
					$req['idx']    = Input('idx');
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where idx = '".$req['idx']."'");
					$Field = array(
						"ProdTitle"      => 	$req['ProdTitle'],
						"ProdSubTitle"   => 	$req['ProdSubTitle'],
						"PCategory1"     => 	$req['PCategory1'],
						"PCategory2"     => 	$req['PCategory2'],
						"PCategory3"     => 	$req['PCategory3'],

						"Wonga"         => 	$req['Wonga'],
						"OrgPrice"      => 	$req['OrgPrice'],
						"SalePrice"     => 	$req['SalePrice'],
						"SaleRatio"     => 	$req['SaleRatio'],

						"MaxCnt"        => 	$req['MaxCnt'],
						"SaleCnt"       => 	$req['SaleCnt'],

						"DeliveryPrice"    => 	$req['DeliveryPrice'],
						"FreeDelivery"     => 	$req['FreeDelivery'],
						"DeliveryCompany"  => 	$req['DeliveryCompany'],
						"SaleStatus"       => 	$req['SaleStatus'],

						"ProdMemo1"        => 	$req['ProdMemo1'],
						"ProdMemo2"        => 	$req['ProdMemo2'],
						"ProdMemo3"        => 	$req['ProdMemo3'],


						"ProdInfo01"        => 	$req['ProdInfo01'],
						"ProdInfo02"        => 	$req['ProdInfo02'],
						"ProdInfo03"        => 	$req['ProdInfo03'],
						"ProdInfo04"        => 	$req['ProdInfo04'],
						"ProdInfo05"        => 	$req['ProdInfo05'],
						"ProdInfo06"        => 	$req['ProdInfo06'],

						"SortNum"           => 	$req['SortNum'],

						"Option1Name"       => 	$req['Option1Name'],
						"Option1Wonga"      => 	$req['Option1Wonga'],
						"Option1OrgPrice"   => 	$req['Option1OrgPrice'],
						"Option1SalePrice"  => 	$req['Option1SalePrice'],
						"Option1SaleRatio"  => 	$req['Option1SaleRatio'],
						"Option1Cnt"        => 	$req['Option1Cnt'],

						"Option2Parent"     => 	$req['Option2Parent'],

						"Option2Name"       => 	$req['Option2Name'],
						"Option2Wonga"      => 	$req['Option2Wonga'],
						"Option2OrgPrice"   => 	$req['Option2OrgPrice'],
						"Option2SalePrice"  => 	$req['Option2SalePrice'],
						"Option2SaleRatio"  => 	$req['Option2SaleRatio'],
						"Option2Cnt"        => 	$req['Option2Cnt'],
					);

					if($_FILES["ProdImage01"]['tmp_name'][$k]){
						$AttachReturn = AttachFile($_FILES["ProdImage01"], $cfg['file'], '','');
						if($AttachReturn){
							$Field['ProdImage01']  = _UPLOAD_.$subdir."/".$AttachReturn['SaveName'];			
						}
					}

					foreach($Field AS $key => $value) {
						 $ret[] = $key."='".$value."'";
					}

					$RESULT = $db -> ExecQuery("UPDATE ".$Board['table_board']." SET ".implode(",", $ret)." WHERE idx = '".$req[idx]."'" );


					if($RESULT >= 0){
						locationReplace($href."&at=modify&idx=".$req['idx'],"수정되었습니다.");
					}else{
						locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
					}
					break;


				case "deleteData":
					$CHECK = $db -> SelectOne("select * from ".$Board['table_board']." where idx = '".$req['idx']."'");

					if($CHECK){
							$RESULT = $db -> ExecQuery("DELETE From ".$Board['table_board']." WHERE  idx = '".$req['idx']."'");
							if($RESULT >= 0){
								locationReplace($href,"삭제되었습니다.");
							}else{
								locationReplace($req['_referer_'],"데이터 처리중 장애가 발생하였습니다.");				
							}
					}else{
							locationReplace($Board['Link']);						
					}
					break;


				case "checkSaleEnd":

					$req['gidx']   = $_POST["gidx"];		
					if($req[gidx]){
						foreach($req['gidx'] as $gkey => $gvalue){
							$Query = "UPDATE MC_Product SET SaleStatus = 'end'  WHERE  SaleStatus = 'ing' and Pcode = '".$gvalue."' ";		
							$db -> ExecQuery($Query);
						}						
					}
					toplocationHref($req['_referer_'],"처리 되었습니다." );	
					break;

				case "ProductSort";
					$req['gidx']   = $_POST["gidx"];		
					if($req['gidx']){
						foreach($req['gidx'] as $gkey => $gvalue){
							$i = $gkey+1;
							$Query = "UPDATE MC_Product SET SortNum = '$i'  WHERE  idx = '".$gvalue."' ";	
							//echo $Query;
							$db -> ExecQuery($Query);
						}						
					}
					toplocationHref($req['_referer_'],"처리 되었습니다." );	

					break;


			endswitch;
	}
?>
