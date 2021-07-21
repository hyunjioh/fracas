<?
	if(!defined("_g_board_include_")) exit; 
	define("_administrators_",true);
	require_once "../../_core/_lib.php";
	require_once "../include/manager.inc.php";
	if(!defined("_is_manager_")){
		toplocationHref( _ADMIN_);
		exit;
	}

	$document_writer = "FISHBOL2012";
	$document_title = "Member";

	// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
	$filename = iconv("UTF-8", "EUC-KR", $document_title);

	header("Content-type: application/vnd.ms-excel"); 
	header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls"); 
	header("Content-Description: PHP4 Generated Data"); 
	//header("Content-charset=euc-kr" ); 

	header("Expires: 0"); 
	header("Cache-Control: must-revalidate, post-check=0,pre-check=0"); 
	header("Pragma: public"); 
	
	$SQL = Request("eq");
	if(!$SQL){
		toplocationHref( _ADMIN_);
		exit;	
	}

/*============================================================================================================================================
	* Query Execute
--------------------------------------------------------------------------------------------------------------------------------------------*/
	$Query = decrypt_md5($SQL,'regexcel@)!@');
	$LIST = $db -> SelectList($Query);

	$Country = Country();
?>
<html> 
<head> 
<html xmlns:x='urn:schemas-microsoft-com:office:excel'> 
<meta http-equiv="Content-Type" content="application/vnd.ms-excel;charset=utf-8">
<meta http-equiv='cache-control' content='no-cache'> 
<meta http-equiv='pragma' content='no-cache'> 
<style> 

table.excel { 
	border-style:ridge; 
	border-width:1; 
	border-collapse:collapse; 
	font-family:sans-serif; 
	font-size:12px; 
} 

table.excel thead th, table.excel tbody th { 
	background:#CCCCCC; 
	border-style:ridge; 
	border-width:1; 
	text-align: center; 
	vertical-align:middle; 
} 

table.excel tbody th { 
	height:30px;
	text-align:center; 
} 

table.excel tbody td { 
	mso-number-format:'\@';
} 

table.excel tbody td { 
	padding: 5px; 
} 

br{mso-data-placement:same-cell}


</style> 
</head> 

<!-- list -->
<table border="1" class="excel" cellspacing="0" cellpadding="0" class="listtable">
  <tr>
    <th  style="width:50px;">번호</th>
    <th  style="">아이디</th>
    <th  style="width:60px">성별</th>
	<th  style="width:80px">이름</th>
    <th  style="width:200px">이메일</th>
    <th  style="width:120px">핸드폰</th>
    <th  style="width:120px">우편번호</th>
    <th  style="width:250px">주소</th>
    <th  style="width:120px">가입일시</th>
  </tr>
  <?
    if($LIST){
      $NUMBER = 1;
      foreach($LIST as $key => $value){
            switch($value['m_sex']){
              case "M": $value['m_sex'] = "남성"; break;
              case "F": $value['m_sex'] = "여성"; break;
            }
  ?>
  <tr>
    <td ><?=$NUMBER++?></td>
    <td ><?=$value['m_id']?></td>
    <td ><?=$value['m_sex']?></td>
    <td ><?=$value['m_name']?></td>
    <td ><?=$value['m_email']?></td>
    <td ><?=$value['m_hp']?></td>
    <td ><?=$value['m_zip']?></td>
    <td ><?=$value['m_addr1']?> <?=$value['m_addr2']?></td>
    <td ><?=$value['m_regDate']?></td>
  </tr>
  <?
      }
    }else{
  ?>
  <tr>
    <td colspan="9" class="tabletd center" style="height:200px">데이터가 없습니다.</td>
  </tr>
  <?
    }	
    $db -> Disconnect();
  ?>


</table>
<!--// list -->
</body>
</html>