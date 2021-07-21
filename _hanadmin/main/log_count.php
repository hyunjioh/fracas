<?
	define("_administrators_",true);
	include "../../_core/_lib.php";
	require_once "../include/manager.inc.php";
	if(!defined("_is_manager_"))	toplocationHref( _ADMIN_);
	

	ini_set("allow_url_fopen",1);
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;

	$Chart = null;
  $date1 = date("Y-m-d",time()-86400*7);
  $date2 = date("Y-m-d",time());
	$Graph = $db -> SelectList("SELECT count(*) as cnt, dayofmonth(time) as day, Month(time) as month,  Year(time) as year FROM `G__Log_Basic` WHERE   time between '".$date1."' and '".$date2." 23:59:59' GROUP BY dayofmonth(time)");	
  if($Graph){
    $cnt = count($Graph);
    for($i=0; $i < $cnt; $i++){
      $Graph[$i]['month'] = ($Graph[$i]['month'] < 10)? "0".$Graph[$i]['month']:$Graph[$i]['month'];
      $Graph[$i]['day'] = ($Graph[$i]['day'] < 10)? "0".$Graph[$i]['day']:$Graph[$i]['day'];
//      $Chart['data'][$i][] = strtotime($Graph[$i][year].$Graph[$i][month].$Graph[$i][day]." 09:00:00")."000";
      $Chart['data'][$i][] = $Graph[$i]['month']."-".$Graph[$i]['day'];
      $Chart['data'][$i][] = (int)$Graph[$i]['cnt'];
    }
  }

  echo json_encode($Chart);

?>