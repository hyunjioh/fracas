<?php
if(!defined("_hannet_included")) exit;
###################################################################################################
/*
  * 파일명 : function.mall.php
  * 기능   : 회원 & 상품소개 & 주문관련 함수
  * create : 2012-05-09
  * update : 2012-05-09
              - function_name() 함수 추가
              - function_name() 함수 수정
*/
###################################################################################################


/**************************************************************************************************
● function memberNumber() : 회원번호 생성
● function XID()          : 회원링크코드 생성
● function productNumber($Cate1 = "10", $Cate2 = "00", $Cate3 = "000") : 상품코드생성($Cate1 : 1차카테고리, $Cate2 : 2차카테고리, $Cate3 : 3차카테고리 )
● function orderNumber($type = "order") : 주문번호생성 ($type : order => 정상주문, claim => 클레임주문)
● function CategoryName($Gubun, $Cate1, $Cate2 = "", $Cate3 = "") : 카테고리 이름
● function Rules($type) : 서비스 이용 규칙 불러오기
● function Lastest($Link, $Cnt) : 최근 게시글 불러오기
● function getConfig($Link)    : 게시판 설정 가져오기
● function Search($str, $Link) : 통합검색
***************************************************************************************************/

/** 회원번호 생성 **/
function memberNumber(){
  global $db;
  $return = null;
  $Number_head = "1";
  $Number_body = randString("num",9);
  $memberNumber = $Number_head.$Number_body;

  if(strlen($memberNumber) == "10"){
    $CHECK = $db -> SelectOne("Select m_num from G_Member Where m_num = '".$memberNumber."' ");
    if(!$CHECK)   $return = $memberNumber;
  }
  if(!$return)   memberNumber();
  else return $return;
}

/** 회원링크코드 생성 **/
function XID(){
  global $db;
  $XID = randString("alnum",14);
  $QUERY = sprintf("SELECT m_linkCode FROM G_Member WHERE ( m_linkCode = '%s')  ", $XID);
  $DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
  if(!$DATA){
    return $XID;
  }else{
    XID();
  }
}

/** 상품번호 생성 **/
function productNumber($Cate1 = "10", $Cate2 = "00", $Cate3 = "000"){
  global $db;
  $return = null;
  if(!$Cate1) $Cate1 = "10";
  if(!$Cate2) $Cate2 = "00";
  if(!$Cate3) $Cate3 = "000";
  $Number_head = $Cate1.$Cate2.$Cate3;


  $Query =  " Select max(SUBSTRING(Pcode,8)) as Pcode " ;
  $Query .= " from G_Product ";
  $Query .= " Where ";
  $Query .= " ifnull( if(PCategory1 = '','10' , PCategory1 ), '10' ) = '".$Cate1."' ";
  $Query .= " and ifnull( if(PCategory2 = '','00' , PCategory2 ), '00' ) = '".$Cate2."' ";
  $Query .= " and ifnull( if(PCategory3 = '','000' , PCategory3 ), '000' ) = '".$Cate3."' ";

  $PCHECK = $db -> Value($Query);
  $Number_body = ($PCHECK)? $PCHECK+1: "10000";

  $productNumber = $Number_head.$Number_body;
  if(strlen($productNumber) == "12"){
    $CHECK = $db -> SelectOne("Select Pcode from G_Product Where Pcode = '".$productNumber."' ");
    if(!$CHECK)   $return = $productNumber;
  }

  if(!$return)   productNumber($Cate1, $Cate2, $Cate3);
  else return $return;
}

/** 주문번호 생성 **/
function orderNumber($type = "order"){
  global $db;
  $return = null;
  if($type != "order" && $type != "claim" ) $type = "claim";
  $Number_head = ($type == "order")? "9":"8" ;
  $Number_body = date("ymdHis").randString("num",4);
  $OrderNumber = $Number_head.$Number_body;

  if(strlen($OrderNumber) == "17"){
    $CHECK = $db -> SelectOne("Select OrderNum from G_Order Where OrderNum = '".$OrderNumber."' ");
    if(!$CHECK)   $return = $OrderNumber;
  }
  if(!$return)   OrderNumber($type);
  else return $return;
}

/** 카테고리 이름 생성 **/
function CategoryName($Gubun, $Cate1, $Cate2 = "", $Cate3 = ""){
  global $db, $db2;
  if(!$Gubun) return;
  if(!$Cate1) return;
  if(!$Cate2) $Depth2 = "00";
  if(!$Cate3) $Depth3 = "000";
  $return = "";
  if($Gubun){
    $Value = $db -> Value("Select Name from G_Product_Category Where Depth1 = '$Cate1' and Depth2 = '$Cate2' and Depth3 = '$Cate3' and Gubun ='$Gubun'");
    if($Value) $return = $Value;

  }
  return $return;
}

/** 서비스 이용 규칙 불러오기 **/
function Rules($type){
  if($type){
    switch($type){
    case "service":
        $filename = _PATH_."/include/rule_service.txt";
        $handle = @fopen($filename, "r");
        $contents = @fread($handle, @filesize($filename));
        @fclose($handle);
        echo @nl2br($contents);
      break;
    case "privacy":
        $filename = _PATH_."/include/rule_privacy.txt";
        $handle = @fopen($filename, "r");
        $contents = @fread($handle, @filesize($filename));
        @fclose($handle);
        echo @nl2br($contents);
      break;


    }
  }
}

/** 최근 게시글 불러오기 **/
function Lastest($Link, $Cnt){
  global $db;
  $return = null;
  include $Link;

  if($Board){
    $DATA = $db -> SelectList("Select idx, Subject,  cast(RegDate as date) as RegDate from ".$Board['table_board']." Where BoardID = '".$Board['board_id']."' order by idx desc limit ".$Cnt);
  }
  if($DATA){
    $return = $DATA;
    $DATA['Total'] = count($DATA);
  }
  $DATA['href'] = $Link;
  return $DATA;
}

/* 게시판 설정 가져오기 */
function getConfig($Link){
  global $db;
  define("_get_config_", true); // config 설정만 얻어오기
  include $Link;
  return $Board;
}

/* 통합검색 */
function Search($str, $Link){
  global $db;
  $Board = getConfig($Link);
  if($Board){
    $WhereQuery = " and ( Subject like '%".$str."%' or Content like '%".$str."%') ";
    $Count = $db -> Total("Select count(*) from ".$Board['table_board']." Where BoardID = '".$Board['board_id']."' $WhereQuery");
    $List = $db  -> SelectList("Select * from  ".$Board['table_board']." Where BoardID = '".$Board['board_id']."' $WhereQuery order by idx desc limit 0, 5");
    $return['href']  = $Link;
    $return['board_name']  = $Board['board_name'];
    $return['Total'] = $Count;
    if($Count > 0){
      $return['Data']  = $List;
    }
  }else{
    $return = null;  
  }

  return $return;
}

/* 국가명 구하기 */
function Country($code = ''){
	global $db;
	if($code){
		$return = $db -> Value("Select country from ip2nationCountries Where iso_code_3 = '$code' ");		
	}else{
		$return = $db -> SelectList("Select iso_code_3 as code, country from ip2nationCountries Where iso_code_3 <> ''  order by country ");
	}
	return $return;
}


/** 게시판 카테고리 생성 **/
function SetBoardCategory(){
  global $db;
  $BoardCategory = randString("alnum",6);
  $QUERY = sprintf("SELECT CategoryCode FROM G__Category  WHERE ( CategoryCode  = '%s')  ", $BoardCategory);
  $DATA = $db -> SelectOne($QUERY); // 데이터를 가져온다.
  if(!$DATA){
    return $BoardCategory;
  }else{
    SetBoardCategory();
  }
}

function BoardCategory($Board){
  global $db;
  $return = null;
  $LIST = $db -> SelectList("Select *  from G__Category Where TableName = '".$Board['table_board']."' and BoardID = '".$Board['board_id']."' ");
  if($LIST){
    foreach($LIST as $key => $value){
      $return[$value['CategoryCode']] = $value['CategoryName'];
    }
  }
  return $return;
}
?>