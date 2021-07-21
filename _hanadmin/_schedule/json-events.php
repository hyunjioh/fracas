<?
	if(!defined("_g_board_include_")) exit; 
	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);


	$req['start'] = Request("start");
	$req['end'] = Request("end");

	if(!$req['start']) $req['start'] = time();
	if(!$req['end']) $req['end'] = time();

	$req['start'] = date("Y-m-d",$req['start']);
	$req['end'] = date("Y-m-d",$req['end']);




	$db = new MySQL;
	$SQL = "Select * from  ".$Board['table_board']."  Where startdate between '".$req['start']."' and '".$req['end']."' ";
	$LIST = $db -> SelectList($SQL);
	if($LIST){
		foreach($LIST as $key => $value){
			$json[$key]['id'] = (int)$value['idx'];
			$json[$key]['title'] = $value['Subject'];
			$json[$key]['start'] = $value['startdate'];
			$json[$key]['end'] = $value['enddate'];
			$json[$key]['url'] = "javascript:scheduleinfo('".$value['idx']."');";
			if($json[$key]['start'] == $json[$key]['end'] && substr($json[$key]['start'],11,8) == "00:00:00"){
				$json[$key]['allDay'] = true;
			}else{
				$json[$key]['allDay'] = false;			
			}
		}
	}else{
		$json = array();
	}
	echo json_encode($json);



//$log_file = "update_log.txt";
//$cont=fopen($log_file,'r');
//$incr=fgets($cont);
//	$incr = $incr.chr(13).$SQL;

//fclose($cont);
//$cont=fopen($log_file,'w');
//fwrite($cont,$incr);
//fclose($cont);
?>