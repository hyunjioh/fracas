<?
	/*-------------------------------------------------------------------------------------------------
	▶ 기본 변수 */
	$Board['Link'] = "./";

	$Domain = _DOMAIN_;
	$SYear =  date("Y");
	$NYear = date("Y")+1;


	$cfg['yoil'] = array("일","월","화","수","목","금","토");
	$cfg['yoil2'] = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");

	$cfg['color'] = array(
		"1"=>"1-bit (2 colors)",
		"8"=>"8-bit (256 colors)",
		"16"=>"16-bit (65,536 colors)",
		"24"=>"24-bit (16,777,216 colors)",
		"32"=>"32-bit (4,294,967,296 colors)",
		""=>"알수없음",
		"Unknown"=>"알수없음"
		);

	$cfg['hour'] = array(
		"00:00 - 00:59",
		"01:00 - 01:59",
		"02:00 - 02:59",
		"03:00 - 03:59",
		"04:00 - 04:59",
		"05:00 - 05:59",
		"06:00 - 06:59",
		"07:00 - 07:59",
		"08:00 - 08:59",
		"09:00 - 09:59",
		"10:00 - 10:59",
		"11:00 - 11:59",
		"12:00 - 12:59",
		"13:00 - 13:59",
		"14:00 - 14:59",
		"15:00 - 15:59",
		"16:00 - 16:59",
		"17:00 - 17:59",
		"18:00 - 18:59",
		"19:00 - 19:59",
		"20:00 - 20:59",
		"21:00 - 21:59",
		"22:00 - 22:59",
		"23:00 - 23:59"
	);
	/*-------------------------------------------------------------------------------------------------
	▶ 변수 체크 */
	// 기본 변수
	$req['idx']        = Request('idx');
	$req['pagenumber'] = Request('pagenumber');
	$req['pagenumber'] = SetValue($req['pagenumber'],'digit', 1);

	// 검색변수
	$req['sn'] = Request('sn');
	$req['st'] = Request('st');
	$req['sc'] = Request('sc');

	$req['sYear'] = Request("sYear");
	$req['sYear'] = SetValue($req['sYear'],'digit',  date("Y"));

	$req['sMonth'] = Request("sMonth");
	$req['sMonth'] = SetValue($req['sMonth'],'digit',  date("m"));

	$req['sDay'] = Request("sDay");
	$req['sDay'] = SetValue($req['sDay'],'digit',  date("d"));

	$req['sdate'] = Request('sdate');
	$req['edate'] = Request('edate');

	if(!$req['sdate']) $req['sdate'] = date("Y-m-d",time()-86400*7);
	if(!$req['edate']) $req['edate'] = date("Y-m-d");


	$Today_Y  = $req['sYear'] ;
	$Today_M = $req['sYear']."-".$req['sMonth'] ;
	$Today_D  = $req['sYear']."-".$req['sMonth']."-".$req['sDay'] ;

	// 정렬
	$req['orderby'] = Request('orderby');
	$req['sort']    = Request('sort');

	$parameter  = "pagenumber=".$req['pagenumber'];
	$parameter .= "&sn=".$req['sn'];
	$parameter .= "&st=".$req['st'];
	$parameter .= "&sc=".$req['sc'];
	$parameter .= "&orderby=".$req['orderby'];
	$parameter .= "&sort=".$req['sort'];


	/*
	$Query = "SELECT count(*) as cnt FROM `G__Log_Basic` WHERE  time LIKE '".$Today_Y."%'";
	$TODAY_Y  = $db -> SelectOne($Query);
	$Query = "SELECT count(*) as cnt FROM `G__Log_Basic` WHERE  time LIKE '".$Today_M."%' ";
	$TODAY_M  = $db -> SelectOne($Query);
	$Query = "SELECT count(*) as cnt FROM `G__Log_Basic` WHERE  time LIKE '".$Today_D."%' ";
	$TODAY_D  = $db -> SelectOne($Query);

	$Today['today']['Y'] = $TODAY_Y['cnt'];
	$Today['today']['m'] = $TODAY_M['cnt'];
	$Today['today']['d'] = $TODAY_D['cnt'];
	*/


	function flag($ip){
		global $db;
		$SQL = "SELECT i.country as Country, c.lat, c.lon FROM  ip2nationCountries c, ip2nation i  WHERE i.ip < INET_ATON('".$ip."') AND c.code = i.country ORDER BY i.ip DESC LIMIT 0,1";
		$flag  = $db -> SelectOne($SQL);

		if($flag['Country'] == "eu"){
			$flag['lat'] = "46";
			$flag['lon'] = "2";
		}
		$return = ($flag)? "<a href=\"#\" class=\"tip_trigger\"><img src='"._CORE_."/images/flag/gif/".$flag['Country'].".gif' align='middle' class=\"tip_trigger\"> <span class=\"tip\" style=\"width: 300px; height:200px\" ><img src=\"http://maps.google.com/maps/api/staticmap?zoom=3&size=300x200&maptype=roadmap&markers=color:blue|".$flag['lat'].",".$flag['lon']."&sensor=false\"></span></a>": "";
		return $return;
	}

	function ip2flag($ip){
		global $db;
		$SQL = "SELECT * from G__IP  WHERE IP = '$ip'  ORDER BY IP DESC LIMIT 0,1";
		$flag  = $db -> SelectOne($SQL);
		$flag['Country'] = strtolower($flag['Country']);
    if($flag['Country']){
  		$return = ($flag)? "<a href=\"#\" class=\"tip_trigger\"><img src='"._CORE_."/images/flag/gif/".$flag['Country'].".gif' align='middle' class=\"tip_trigger\"> <span class=\"tip\" style=\"width: 300px;; height:200px\"><img src=\"http://maps.google.com/maps/api/staticmap?zoom=3&size=300x200&maptype=roadmap&markers=color:blue|".$flag['Lat'].",".$flag['Lng']."&sensor=false\"></span></a>": "";
    }else{
      $return = "";
    }
		return $return;
	}
?>