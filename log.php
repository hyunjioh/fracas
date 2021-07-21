<?
include "_core/_lib.php";
include _CORE_PATH_."/system/class.MySQL.php";
require_once _CORE_PATH_."/system/class.Session.php";
ini_set("allow_url_fopen",1);



###################################################################################################
#
# Init
#
###################################################################################################
# 데이터베이스에 연결한다.
$db = new MySQL;
unset($set, $value);

	$OSArray = array(
		/* MOBILE */
		array('PSP', 'PlayStation Portable'),
		array('Symbian', 'Symbian PDA'),
		array('Nokia', 'Nokia PDA'),
		array('LGT', 'LG Mobile'),
		array('KTF', 'KTF Mobile'),
//		array('mobile', 'ETC Mobile'),
		array('PPC', 'Microsoft PocketPC'),
		array('Android 1.5','Android 1.5'),
		array('Android 1.6','Android 1.6'),
		array('Android 2.0','Android 2.0'),
		array('Android 2.1','Android 2.1'),
		array('Android 2.2','Android 2.2'),
		array('Android 2.3','Android 2.3'),
		array('Android 3.0','Android 3.0'),
		array('Android 3.1','Android 3.1'),
		array('Android 4.0','Android 4.0'),
		array('Android','Android Etc'),
		array('iPhone OS 5','iPhone OS 5'),
		array('iPhone','iPhone Etc'),
		
		/* PC */
		array('Windows CE', 'Windows CE'),
		array('Win98', 'Windows 98'),
		array('Windows 9x', 'Windows ME'),
		array('Windows me', 'Windows ME'),
		array('Windows 98', 'Windows 98'),
		array('Windows 95', 'Windows 95'),
		array('Windows NT 6.1', 'Windows 7'),
		array('Windows NT 6', 'Windows Vista'),
		array('Windows NT 5.2', 'Windows 2003/XP x64'),
		array('Windows NT 5.01', 'Windows 2000 SP1'),
		array('Windows NT 5.1', 'Windows XP'),
		array('Windows NT 5', 'Windows 2000'),
		array('Windows NT', 'Windows NT'),
		array('Mac OS X', 'Mac OS X'),
		array('Mac_PowerPC', 'Mac PowerPC'),
		array('Unix', 'Unix'),
		array('bsd', 'BSD'),
		array('Ubuntu', 'Ubuntu'),
		array('Linux', 'Linux'),
		array('Wget', 'Linux'),
		array('windows', 'ETC Windows'),
		array('mac', 'ETC Mac'),

		/* WEB ROBOT */
		array('Googlebot', 'GoogleBot'),
		array('FeedFetcher-Google', 'Google RSS'),
		array('OmniExplorer', 'OmniExplorerBot'),
		array('MJ12bot', 'majestic12Bot'),
		array('ia_archiver', 'Alexa(IA Archiver)'),
		array('Yandex', 'Yandex bot'),
		array('Inktomi', 'Inktomi Slurp'),
		array('Giga', 'GigaBot'),
		array('Jeeves', 'Jeeves bot'),
		array('Planetwide', 'IBM Planetwide bot'),
		array('bot', 'ETC Robot'),
		array('Crawler', 'ETC Robot'),
		array('library', 'ETC Robot'),
		array('Yahoo! Slurp', 'Yahoo Bot'),
		array('Netcraft', 'Netcraft Survey'),
		array('thunderstone', 'thunderstone Survey'),
		array('Python-urllib', 'Python Module'),
	);


	$BrowserArray = array(
		/* MOBILE */
		array('IEmobile', 'Internet Explorer Mobile'),
		array('PSP', 'PlayStation Portable'),
		array('Symbian', 'Symbian PDA'),
		array('Nokia', 'Nokia PDA'),
		array('LGT', 'LG Mobile'),
//		array('mobile', 'ETC Mobile'),

		/* BROWSER */
		array('MSIE 9',        'Internet Explorer 9'),
		array('MSIE 8',        'Internet Explorer 8'),
		array('MSIE 2',        'Internet Explorer 2'),
		array('MSIE 3',        'Internet Explorer 3'),
		array('MSIE 4',        'Internet Explorer 4'),
		array('MSIE 5',        'Internet Explorer 5'),
		array('MSIE 6',        'Internet Explorer 6'),
		array('MSIE 7',        'Internet Explorer 7'),

		array('MSIE', 'ETC Internet Explorer'),
		array('Firefox', 'FireFox'),
		array('Chrome', 'Chrome'),
		array('Safari', 'Safari'),
		array('Opera', 'Opera'),
		array('Lynx', 'Lynx'),
		array('LibWWW', 'LibWWW'),
		array('Konqueror', 'Konqueror'),
		array('Internet Ninja', 'Internet Ninja'),
		array('Download Ninja', 'Download Ninja'),
		array('WebCapture', 'WebCapture'),
		array('LTH', 'LTH Browser'),
		array('Gecko', 'Gecko compatible'),
		array('Mozilla', 'Mozilla compatible'),
		array('wget', 'Wget command'),

		/* WEB ROBOT */
		array('Googlebot', 'GoogleBot'),
		array('OmniExplorer', 'OmniExplorerBot'),
		array('MJ12bot', 'majestic12Bot'),
		array('ia_archiver', 'Alexa(IA Archiver)'),
		array('Yandex', 'Yandex bot'),
		array('Inktomi', 'Inktomi Slurp'),
		array('Giga', 'GigaBot'),
		array('Jeeves', 'Jeeves bot'),
		array('Planetwide', 'IBM Planetwide bot'),
		array('bot', 'ETC Robot'),
		array('Crawler', 'ETC Robot'),
	);

	$value['domain'] = js_unescape($_GET['uid']);
	$value['url'] = js_unescape($_GET['url']);
	$value['ref'] = js_unescape($_GET['ref']);
	$value['sid'] = session_id();
	$value['dim'] = $_GET['dim'];
	$value['cd']  = $_GET['cd'];
	$value['ip']  = $_SERVER['REMOTE_ADDR'];
	$value['now'] = date("Y-m-d H:i:s");

###################################################################################################
#
# User Interface
#
###################################################################################################
	$agent = $_SERVER['HTTP_USER_AGENT'];
	foreach($OSArray as $val){
		if(eregi($val[0], $agent)) {
			$value[os] = $val[1]; break; 
		}else{
			$value[os] = $agent; 		
		}
	}

	foreach($BrowserArray as $val){
		if(eregi($val[0], $agent)){
			$value[browser] = $val[1]; break;
		}else{
			$value[browser] = $agent;
		}
	}

###################################################################################################
#
# Access page
#
###################################################################################################
	$url = parse_url($value['url']);
	$value[host] = $value[uri] = null;
	$value[query] = null;
	if(isset($url[host])){
		$value[host] = $url[host];
		if($url[path])	$value[uri] = ($url[query])?	$url[path]."?".$url[query]:$url[path];
	}



###################################################################################################
#
# Referer
#
###################################################################################################
	$referer = parse_url(js_unescape($value['ref']));
	$value[ref_host] = $value[ref_uri] = null;
	$value[ref_engine] = $value[ref_query] = null;
	if(isset($referer[host])){
		$value[ref_host] = $referer[host];
		if($referer[path])	$value[ref_uri] = ($referer[query])?	$referer[path]."?".$referer[query]:$referer[path];

		/**********************************************
		>> Google */
		if (preg_match("/google/i", $value[ref_host])) {
			preg_match_all("/q\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Google";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> naver */
		if (preg_match("/naver/i", $value[ref_host])) {
			preg_match_all("/query\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Naver";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> daum */
		if (preg_match("/daum/i", $value[ref_host])) {
			preg_match_all("/q\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Daum";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> nate */
		if (preg_match("/nate/i", $value[ref_host])) {
			preg_match_all("/query\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Nate";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> yahoo */
		if (preg_match("/yahoo/i", $value[ref_host])) {
			preg_match_all("/p\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Yahoo";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> empas */
		if (preg_match("/empas/i", $value[ref_host])) {
			preg_match_all("/q\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Empas";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}


		/**********************************************
		>> paran */
		if (preg_match("/paran/i", $value[ref_host])) {
			preg_match_all("/Query\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Paran";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> chol */
		if (preg_match("/chol/i", $value[ref_host])) {
			preg_match_all("/q\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Chol";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> dreamwiz */
		if (preg_match("/dreamwiz/i", $value[ref_host])) {
			preg_match_all("/q\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "Dreamwiz";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		/**********************************************
		>> msn */
		if (preg_match("/msn/i", $value[ref_host])) {
			preg_match_all("/q\=(.*)\&/isU", $referer[query], $query);
			$value[ref_engine] = "MSN";
			$value[ref_query] = js_unescape(trim($query[1][0]));
		}

		//if(!$value[ref_engine]){
			$value[ref_engine] = $value[ref_host];
			$value[ref_query] = js_unescape(trim($query[1][0]));		
		//}
	}else{
  
    if(isset($_COOKIE[$token['bookmark']]) &&  !empty($_COOKIE[$token['bookmark']]) ){
      $value[ref_engine] = "bookmark";
    }else{
      $value[ref_engine] = "직접방문";
    }   
  }







	//print_R($value);

$tbQuery = "
CREATE TABLE IF NOT EXISTS `G__Log_Basic` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
  `page` text NOT NULL,
  `ref` text NOT NULL,
  `url` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `sid` varchar(32) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mid` varchar(20) NOT NULL,
  PRIMARY KEY (`idx`)
)";
$db -> ExecQuery($tbQuery);

$tbQuery = "
CREATE TABLE IF NOT EXISTS `G__Log_History` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
  `page` text NOT NULL,
  `sid` varchar(32) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`)
)";
$db -> ExecQuery($tbQuery);

$tbQuery = "
CREATE TABLE IF NOT EXISTS `G__Log_Ref` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
  `name` varchar(10) NOT NULL,
  `search` varchar(255) NOT NULL,
  `sid` varchar(32) NOT NULL,
  `qs` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`)
)";
$db -> ExecQuery($tbQuery);

$tbQuery = "
CREATE TABLE IF NOT EXISTS `G__Log_UserInfo` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(30) NOT NULL,
  `bn` varchar(30) NOT NULL,
  `os` varchar(20) NOT NULL,
  `dim` varchar(9) NOT NULL,
  `cd` varchar(2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`)
)";
$db -> ExecQuery($tbQuery);

$tbQuery = "
CREATE TABLE IF NOT EXISTS `G__IP` (
  `Country` varchar(10) NOT NULL,
  `Region` varchar(50) NOT NULL,
  `Lat` decimal(16,12) NOT NULL,
  `Lng` decimal(16,12) NOT NULL,
  `ISP` varchar(100) NOT NULL
)
";
$db -> ExecQuery($tbQuery);

###################################################################################################
#
# Data Insert
#
###################################################################################################
	$TOTAL = $db -> Total("SELECT COUNT(*) FROM G__Log_Basic WHERE sid='".$value['sid']."'");

	// 1분이내 해당페이지를 새로고침할 경우 기록하지 않는 타입
	$CHECK = $db -> Total("SELECT COUNT(*) FROM G__Log_History WHERE sid='".$value['sid']."' and page = '".$value['uri']."' and TIMESTAMPDIFF(MINUTE, time, NOW()) < 1");

	// 가장 마지막 접속페이지를 체크하여 페이지가 같으면 기록하지 않는 타입
	$CHECK = $db -> Total("SELECT COUNT(*) FROM G__Log_History WHERE sid='".$value['sid']."' and page = '".$value['uri']."' order by time desc limit 1");


	//아이피,호출된곳,호출한페이지
	$FieldArray = array(
		'uid'    => $value['domain'],
		'page'	 => $value['uri'],
		'ref'	   => $value['ref'],
		'url'	   => $value['host'],
		'ip' 	   => $value['ip'],
		'sid'	   => $value['sid'],
		'time'	 => $value['now'] ,
	);
	$Query_Basic = "INSERT INTO G__Log_Basic (`".implode("`, `", array_keys($FieldArray))."`)  VALUES ('".implode("', '", $FieldArray)."')";


	//브라우저,운영체제,해상도
	$FieldArray = array(
		'uid'    => $value['domain'],
		'bn' 	   => $value['browser'],
		'os'	   => $value['os'],
		'dim'	   => $value['dim'],
		'cd'	   => $value['cd'],
		'time'	 => $value['now'],
	);
	$Query_UserInfo = "INSERT INTO G__Log_UserInfo (`".implode("`, `", array_keys($FieldArray))."`)  VALUES ('".implode("', '", $FieldArray)."')";


	//검색엔진,검색어
	if($value[ref_engine]){
		//눌러본페이지
		$FieldArray = array(
			'uid'    => $value['domain'],
			'name'   => $value['ref_engine'],
			'search' => $value['ref_query'],
  		'sid'	   => $value['sid'],
			'qs'     => $value['ref_uri'],
			'time'	 => $value['now'],
		);
		$Query_Ref = "INSERT INTO G__Log_Ref (`".implode("`, `", array_keys($FieldArray))."`)  VALUES ('".implode("', '", $FieldArray)."')";
	}

	//눌러본페이지
	$FieldArray = array(
		'uid'    => $value['domain'],
		'page'	 => $value['uri'],
		'sid'	   => $value['sid'],
		'time'	 => $value['now'],
	);
	$Query_History = "INSERT INTO G__Log_History (`".implode("`, `", array_keys($FieldArray))."`)  VALUES ('".implode("', '", $FieldArray)."')";






	if(($value['host'] != $value['ref_host']) && $TOTAL == 0){
		$INSERT = $db -> ExecQuery($Query_Basic);
		$INSERT = $db -> ExecQuery($Query_UserInfo);
		$INSERT = $db -> ExecQuery($Query_Ref);
		$INSERT = $db -> ExecQuery($Query_History);
    /* IP trace */
    $TRACE = $db -> SelectOne("SELECT Country, Region, Lat, Lng FROM G__IP WHERE ip='".$value['ip']."'");
    if(!$TRACE){
      $xmlUrl = "http://xml.utrace.de/?query=".$value['ip']; // XML feed file/URL
      $xmlStr = file_get_contents($xmlUrl);
      $xmlObj = simplexml_load_string($xmlStr);
      $arrXml = objectsIntoArray($xmlObj);


      // 국가
      $values['Country'] = $arrXml[result][countrycode];
      // 지역
      $values['Region'] = $arrXml[result][region];
      // ISP
      $values['ISP'] = $arrXml[result][isp];
      // 위도
      $values['Lat'] = $arrXml[result][latitude];
      // 경도
      $values['Lng'] = $arrXml[result][longitude];

      if($values['Country']){
        $IPField = array(
            'Country' => $values['Country'],
            'Region'  => $values['Region'],
            'Lat'     => $values['Lat'],
            'Lng'     => $values['Lng'],
            'ISP'     => $values['ISP'],
            'IP'     => $values['ip'],
        );
        $Query_IP = "INSERT INTO G__IP (`".implode("`, `", array_keys($IPField))."`)  VALUES ('".implode("', '", $IPField)."')";
    		$INSERT = $db -> ExecQuery($Query_IP);
      }
    }
	}else{
		if($CHECK == 0){ $db -> ExecQuery($Query_History); }
	}
	unset($value);
	unset($values);
	unset($FieldArray);
	unset($FieldArrayAdd);
?>