<?php
if(!defined("_hannet_included")) exit;
###################################################################################################
/*
  * 파일명 : function.common.php
  * 기능   : 일반 함수
  * create : 2012-05-09
  * update : 2012-05-09
              - function_name() 함수 추가
              - function_name() 함수 수정
*/
###################################################################################################


/**************************************************************************************************
// 시스템 & 개발
● function dbConn($mysql)               : 데이터베이스 연결 ($mysql : db 접속정보 - 배열)
● function phpTimer()                   : php 실행시간 체크
● function array_combine($arr1, $arr2)  : $arr1 배열과 $arr2 배열 합치기
● function http_build_query($data)      : URL 인코드한 쿼리 문자열 생성
● function if_echo($boolen, $val) : $boolen True 시 $val 표시
● function print_dev($str)        : 개발 코드 화면 프린트

// 클라이언트 환경
● function ip_addr()                    : 사용자 아이피
● function is_mobile_agent()            : Mobile OS 체크 (iPad 제외)
● function ip_block($deny_ip_list, $ip_check_rule, $client_ip ) : ip block
● function getBrowser() : 브라우저 체크

// 조건문
● function Select($name, $val)    : selectbox 체크
● function Check($name, $val)     : input, radio checkbox 체크

// 문자열
● function randomString($type, $length)  : 랜덤문자열 생성 ($type : 문자열에 포함될 문자배열, $length : 리던될 문자열 길이)
● function Euckr($str)            : Utf-8 => EucKr
● function Utf8($str)             : EucKr => Utf-8
● function iso2022kr($message)    : iso-2022-kr => ksc5601
● function utf8RawUrlDecode($source)            : 자바스크립트 escape 함수를 이용해서 특수 문자를 인코딩 - > utf-8 형식의 특수 문자를 원래대로 복원
● function js_escape($str, $chr_set='utf-8')    : php 문자열을 javascript escape 문자열로
● function js_unescape($str, $chr_set='euc-kr') : javascript unescape 문자열을 php로 받기
● function strCut($str, $len, $tail="")    : 문자열 자르기
● function strCount($str)                  : 글자수 카운트

● function printByte($bytes)              : 파일사이즈를 최적화된 단위로 변환
● function getExt($file)                   : 파일명에서 파일 확장자를 구함
● function emailCheck($email)              : 이메일 형식 체크
● function autoLink(&$str)                 : 문자열내 링크요소에 링크 걸기
● function urlCheck(&$str)                 : url을 검사하여 유효한 url로 리턴

● function highlight($word, $subject)      : 특정단어 강조표시 (검색어 치환)
● function fontTagRemove($str)             : span/font 태그 삭제
● function br2nl($string)                  : br -> nl

// object
● function curl_get_file_contents($URL)                             : 외부 URL의 내용 얻어오기
● function objectsIntoArray($arrObjData, $arrSkipIndices = array()) : object(XML) to array

// api
● function NaverMapNPoint($mapAddr)                            : 네이버 맵 좌표구하기
● function googleCurrency($from_Currency,$to_Currency,$amount) : 구글에서 환율정보 가져오기

// security
● function RemoveXSS()          : XSS (cross site scripting) filter function
● function mysql_escape_str()   : mysql_real_escape_string 사용, 입력 데이터 체크

● function new_token($form)     : 작성폼의 토큰 생성
● function check_token($form)   : 작성폼의 토큰 확인
● function destory_token($form) : 작성폼의 토큰 제거

● function encrypt_md5($buf, $key='dbf007$') : 암호화 (md5)
● function decrypt_md5($buf, $key='dbf007$') : 복호화 (md5)

● function encrypt_md5_base64($buf, $key='dbf007$') : 암호화 (md5)
● function decrypt_md5_base64($buf, $key='dbf007$') : 복호화 (md5)]

● function Request($str)              : 전송된 변수 체크 반환
● function Input($str)                : 입력할 변수 체크 반환
● function CheckValue($type, $val)    : 전송유형별 값 체크 반환
● function RequestValueCheck($buff)   : 전송된 변수 체크
● function InputValueCheck($buff)     : 입력할 변수 체크
● function SetValue($val, $type = null, $default = null) : 변수 기본값 설정
● function TypeCheck($type, $val)  : 변수 형태 체크

// page control
● function metaRefresh($url, $sec=0)             : meta refresh 로 페이지 이동
● function selfClose($msg = null)                : javascript self.close();
● function historyBack($msg = null)              : javascript history.go(-1);
● function locationHref($url, $msg = null)       : javascript location.href;
● function locationReplace($url, $msg = null)    : javascript location.replace;
● function toplocationHref($url, $msg = null)    : javascript parent.location.href;
● function toplocationReplace($url, $msg = null) : javascript parent.location.replace;
● function openerlocationHref($url, $msg = null) : javascript opener.location.href;
● function openerlocationReload($msg = null)     : javascript opener.location.reload();
● function formSubmit($url, $msg = Null, $Field = null) : form submit
● function alert($msg) : javascript alert();

// board
● function LAST_INSERT_ID() : LAST_INSERT_ID 구하기
● function Fid() : 새글의  fid 구하기
● function Hit() : 조회수 증가
● function NextSubject($mode = "thread") : 이전글 ($mode => thread : 계층형, 일반형)
● function PrevSubject($mode = "thread") : 다음글 ($mode => thread : 계층형, 일반형)
● function Thread($idx) : 답글의 thread 구하기
● function IconNew($val, $interval, $img) : 새글아이콘
● function CheckReply($thread, $img = "") : 답변글 아이콘
● function CheckSecret($secret, $img = "") : 비밀글 아이콘
● function fnGetFileicon($fileurl) : 첨부파일의 아이콘
● function ThumbNailView($file, $header = "t", $w = "", $h = "", $height = "") : 썸네일 보기
● Function thumbnail($file, $save_filename, $save_path, $max_width, $max_height)  : 썸네일 생성
● function DirectDownload() : 첨부파일 다운로드 (다이렉트 경로지정)



▶ 첨부파일 저장 테이블을 사용시 사용되는 함수 (G_Board_Attach)
● function AttachProcess($Pidx, $subDir) : 첨부파일 저장 (첨부파일테이블 별도 운영시)
● function AttachFile($attach, $UploadConfig, $delCheck, $delfile, $arrNum = null) : 첨부파일 업로드
● function AttachCnt($idx) : 첨부파일 개수
● function CheckAttach($idx,$img = "") : 첨부파일 존재 여부
● function FirstAttach($pidx) : 첨부된 파일중 하나만 가져오기 (먼저올린순)
● function AttachInfo($fileidx) : 첨부파일 정보
● function AttachDownload($fileidx) : 첨부파일 정보
● function AttachList($idx) : 첨부파일 목록
● function AttachModify($idx) : 첨부파일 수정
● function AttachDel($idx) : 첨부파일 삭제
● function AttachSelectDel($Pidx, $AttachIdx) : 첨부파일 삭제
● function AttachThumbNail($idx, $w = "", $h = "", $height = "", $one = "") : 첨부파일 썸네일 (각 첨부파일의 썸네일)
● function AttachThumbNailOne($idx, $w = "", $h = "", $height = "") : 첨부파일 썸네일 (원글에 첨부된 파일중 하나만)
● function download() : 첨부파일 다운로드

● function CommentDel($idx) : 코멘트 삭제

***************************************************************************************************/



/*====================================================================================================
▶ 시스템
----------------------------------------------------------------------------------------------------*/
/** 데이터베이스 연결 **/
function dbConn($mysql){
	$connect = mysql_connect($mysql['db_host'], $mysql['db_user'], $mysql['db_pass'],$mysql['db_name']) or die("connection error");
	mysql_select_db($mysql['db_name'],$connect);
}

/** php 실행시간 체크 **/
function phpTimer(){
  static $arr_timer;
  if(!isset($arr_timer)){
  $arr_timer = explode(" ", microtime());
  }else{
    $arr_timer2 = explode(" ", microtime());
    $result = ($arr_timer2[1] - $arr_timer[1]) + ($arr_timer2[0] - $arr_timer[0]);
    $result = sprintf("%.4f",$result);
    return $result;
  }
  return false;
}

/** 배열 합치기 (PHP 5) **/
if(!function_exists("array_combine")){
	function array_combine($arr1, $arr2) {
			$out = array();
			$arr1 = array_values($arr1);
			$arr2 = array_values($arr2);
			foreach($arr1 as $key1 => $value1) {
					$out[(string)$value1] = $arr2[$key1];
			}
			return $out;
	}
}

/** 값의 JSON 표현을 반환 (PHP 5 >= 5.2.0, PECL json >= 1.2.0)  **/
if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}

/** JSON 문자열 디코드 (PHP 5 >= 5.2.0, PECL json >= 1.2.0)  **/
if (!function_exists('json_decode')) {
  function json_decode($json) {
    $comment = false;
    $out     = '$x=';
    for ($i=0; $i<strlen($json); $i++) {
      if (!$comment) {
        if (($json[$i] == '{') || ($json[$i] == '[')) {
          $out .= 'array(';
        }
        elseif (($json[$i] == '}') || ($json[$i] == ']')) {
          $out .= ')';
        }
        elseif ($json[$i] == ':') {
          $out .= '=>';
        }
        elseif ($json[$i] == ',') {
          $out .= ',';
        }
        elseif ($json[$i] == '"') {
          $out .= '"';
        }
        /*elseif (!preg_match('/\s/', $json[$i])) {
          return null;
        }*/
      }
      else $out .= $json[$i] == '$' ? '\$' : $json[$i];
      if ($json[$i] == '"' && $json[($i-1)] != '\\') $comment = !$comment;
    }
    eval($out. ';');
    return $x;
  }
}



/* URL 인코드한 쿼리 문자열 생성 (PHP 5)*/
if (!function_exists('http_build_query')) {
    function http_build_query($data, $prefix='', $sep='', $key='') {
        $ret = array();
        foreach ((array)$data as $k => $v) {
            if (is_int($k) && $prefix != null) {
                $k = urlencode($prefix . $k);
            }
            if ((!empty($key)) || ($key === 0))  $k = $key.'['.urlencode($k).']';
            if (is_array($v) || is_object($v)) {
                array_push($ret, http_build_query($v, '', $sep, $k));
            } else {
                array_push($ret, $k.'='.urlencode($v));
            }
        }
        if (empty($sep)) $sep = ini_get('arg_separator.output');
        return implode($sep, $ret);
    }// http_build_query
}//if


/** if_echo($boolen, $val) : $boolen True 시 $val 표시 **/
function if_echo($boolen, $val){	if($boolen) echo $val;}

/** 개발 코드 화면 프린트 **/
function print_dev($str){
	if(ip_addr() == DEV_IP){
		echo "<pre>";
		print_R($str);
	}
}

/*====================================================================================================
▶ 클라이언트 환경
----------------------------------------------------------------------------------------------------*/
/** php 사용자 아이피 **/
function ip_addr() {
	 if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
		 $ip=$_SERVER['HTTP_CLIENT_IP'];
	 } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
		 $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	 } else {
		 $ip=$_SERVER['REMOTE_ADDR'];
	 }
	 return $ip;
}

/** Mobile OS 체크 (iPad 제외) **/
function is_mobile_agent(){
 if( !preg_match('/(iPad)/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/(iPhone|Mobile|UP.Browser|Android|BlackBerry|Windows CE|Nokia|webOS|Opera Mini|SonyEricsson|opera mobi|Windows Phone|IEMobile|POLARIS)/i', $_SERVER['HTTP_USER_AGENT']) ) {
  return true;
 } else {
  return false;
 }
}

/** IP BLOCK **/
function ip_block($deny_ip_list, $ip_check_rule, $client_ip ) {
  if($client_ip == "") $client_ip = ip_addr();
  $client_ip_arr = explode(".", $client_ip);
  $deny_ip_list_arr = explode(",", $deny_ip_list);
  $deny_ip_total = count($deny_ip_list_arr);

  for($i=0; $i < $deny_ip_total; $i++) {
      $deny_ip_arr = explode(".", $deny_ip_list_arr[$i]);
      $deny_ip_arr_count = count($deny_ip_arr);
      if($deny_ip_arr_count < 4){
        for($k=$deny_ip_arr_count; $k < 4; $k++){
          $deny_ip_arr[$k] = "*";
        }
      }
      $count=0;
      for($j=0; $j < 4; $j++) {
          if (($deny_ip_arr[$j] == $client_ip_arr[$j]) || ($deny_ip_arr[$j] == '*')) {
              $count++;
          }
          if ($count == 4) return true;
      }
  }
  return false;
}

/** 브라우저 체크 **/
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
 
    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; }
    elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; }
     
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { $bname = 'Internet Explorer'; $ub = "MSIE"; } 
    elseif(preg_match('/Firefox/i',$u_agent)) { $bname = 'Mozilla Firefox'; $ub = "Firefox"; } 
    elseif(preg_match('/Chrome/i',$u_agent)) { $bname = 'Google Chrome'; $ub = "Chrome"; } 
    elseif(preg_match('/Safari/i',$u_agent)) { $bname = 'Apple Safari'; $ub = "Safari"; } 
    elseif(preg_match('/Opera/i',$u_agent)) { $bname = 'Opera'; $ub = "Opera"; } 
    elseif(preg_match('/Netscape/i',$u_agent)) { $bname = 'Netscape'; $ub = "Netscape"; } 
     
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
     
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){ $version= $matches['version'][0]; }
        else { $version= $matches['version'][1]; }
    }
    else { $version= $matches['version'][0]; }
     
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    return array('userAgent'=>$u_agent, 'name'=>$bname, 'version'=>$version, 'platform'=>$platform, 'pattern'=>$pattern);
}


/*====================================================================================================
▶ 조건문
----------------------------------------------------------------------------------------------------*/
/** select box selected 체크 **/
function Select($name, $val){	if($name == $val) { return "selected";	} else {	return null; }}

/** radio box OR check box checked 체크 **/
function Check($name, $val){
	if(is_array($val)){
		if(in_array($name,$val)) {	return "checked";	}	else { return null; }
	}else{
		if($name == $val) {	return "checked";	}	else { return null; }
	}
}


/*====================================================================================================
▶ 문자열
----------------------------------------------------------------------------------------------------*/
/** 랜덤문자열 생성 ($type : 문자열에 포함될 문자배열, $length : 리던될 문자열 길) **/
/* $type : alpha => 영대, num => 숫자, alnum => 영대+숫자 */
function randString($type, $length){
  $return = null;
  $type = strtolower($type);
  switch($type){
    case "alpha":
        $arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
      break;
    case "num":
    	$arr = array('1','2','3','4','5','6','7','8','9','0');
      break;
    case "alnum":
    	$arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0');
      break;
    default:
    	$arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0');
  }

	$cnt = count($arr);
	for($i=0;$i<$length;$i++){
	  $rand = rand(0,$cnt-1);
		$return .= $arr[$rand];
	}
	return $return;
}

/** UTF-8 -> Euc-kr **/
function Euckr($str){
	$enc = mb_detect_encoding($str, "UTF-8, EUC-KR");
	if($enc == "UTF-8")	return iconv("UTF-8","EUC-KR",$str);
	else return $str;
}

/** Euckr -> Utf8 **/
function Utf8($str){
	$enc = mb_detect_encoding($str, "UTF-8, EUC-KR");
	if($enc == "EUC-KR")	return iconv("EUC-KR","UTF-8",$str);
	else return $str;
}

/** iso-2022-kr => ksc5601 **/
function iso2022kr($message){
  $esc_string = chr(27)."$)C";
  if(strstr($message, $esc_string))
  {
    $message = str_replace($esc_string, "", $message);
    $length = strlen($message);
    $status = 0;
    $output = "";
    for($i=0; $i<$length; $i++)
    {
      $bits = substr($message, $i, 1);
      if($bits == chr(14)) $status = 1;
      else if($bits == chr(15)) $status = 0;
      else
      {
        if($status == 1) $bits = chr(ord($bits) | 128);
        $output .= $bits;
      }
    }
    $message = $output;
  }
  return $message;
}

/** 자바스크립트 escape 함수를 이용해서 특수 문자를 인코딩 - > utf-8 형식의 특수 문자를 원래대로 복원 **/
function utf8RawUrlDecode ($source) {
   $decodedStr = "";
   $pos = 0;
   $len = strlen ($source);
   while ($pos < $len) {
       $charAt = substr ($source, $pos, 1);
       if ($charAt == '%') {
           $pos++;
           $charAt = substr ($source, $pos, 1);
           if ($charAt == 'u') {
               // we got a unicode character
               $pos++;
               $unicodeHexVal = substr ($source, $pos, 4);
               $unicode = hexdec ($unicodeHexVal);
               $entity = "&#". $unicode . ';';
               $decodedStr .= utf8_encode ($entity);
               $pos += 4;
           }
           else {
               // we have an escaped ascii character
               $hexVal = substr ($source, $pos, 2);
               $decodedStr .= chr (hexdec ($hexVal));
               $pos += 2;
           }
       } else {
           $decodedStr .= $charAt;
           $pos++;
       }
   }
   return $decodedStr;
}

/** php 문자열을 javascript escape 문자열로 **/
function js_escape($str, $chr_set='utf-8') {
	$arr_dec = unpack("n*", iconv($chr_set, "UTF-16BE", $str));
	$callback_function = create_function('$dec', 'if(in_array($dec, array(42, 43, 45, 46, 47, 64, 95))) return chr($dec); elseif($dec >= 127) return "%u".strtoupper(dechex($dec)); else return rawurlencode(chr($dec));');
	$arr_hexcode = array_map($callback_function, $arr_dec);
	return implode($arr_hexcode);
}

/** javascript unescape 문자열을 php로 받기 **/
function js_unescape($str, $chr_set='euc-kr'){
	$callback_function = create_function('$matches, $chr_set="'.$chr_set.'"', 'return iconv("UTF-16BE", $chr_set, pack("n*", hexdec($matches[1])));');
	return rawurldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', $callback_function, $str));
}

/** 문자열 자르기 **/
function strCut($str, $len, $tail=""){
	if(strtoupper(mb_detect_encoding($str)) == "UTF-8"){
		# ● UTF-8 문자열 자르기
		$size = $len;
		$substr = substr($str, 0, $size*2);
		$multi_size = preg_match_all('/[\x80-\xff]/', $substr, $multi_chars);

		if($multi_size >0)
		 $size = $size + intval($multi_size/3)-1;

		if(strlen($str)>$size)
		{
		 $str = substr($str, 0, $size);
		 $str = preg_replace('/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str);
		 $str .=  $tail;
		}
	}else{
		if(strlen($str)>$len){
			for($i=0; $i<$len; $i++) if(ord($str[$i]) > 127) $i ++;
			$str = substr($str,0,$i).$tail;
		}
	}
	return $str;
}

/** 글자수 카운트 **/
function strCount($str){
 $kChar = 0;
 for( $i = 0 ; $i < strlen($str) ;$i++){
  $lastChar = ord($str[$i]);
  if($lastChar >= 127){
   $i= $i+2;
  }
  $kChar++;
 }
 return $kChar;
}

/** 파일사이즈를 최적화된 단위로 변환 **/
function printByte($bytes){
	if(!$bytes || $bytes == 0) return;
	$s = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
	$e = floor(log($bytes)/log(1024));
	return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
}

/** 파일명에서 파일 확장자를 구함 **/
function getExt($file){
	$needle = strrpos($file, ".") + 1; // 파일 마지막의 "." 문자의 위치를 반환한다.
	$slice = substr($file, $needle); // 확장자 문자를 반환한다.
	$ext = strtolower($slice); // 반환된 확장자를 소문자로 바꾼다.
	return $ext;
}

/** 이메일 형식 체크 **/
function emailCheck($email){
	if(!eregi("^[a-zA-Z0-9]+[_a-zA-Z0-9-]*(\.[_a-z0-9-]+)*@[a-z??0-9]+(-[a-z??0-9]+)*(\.[a-z??0-9-]+)*(\.[a-z]{2,4})$", $email)) return FALSE;
	return $email;
}

/** 장문자열내 링크요소에 링크 걸기   **/
function autoLink(&$str){
   // 속도 향상 031011
   $str = preg_replace("/&lt;/", "\t_lt_\t", $str);
   $str = preg_replace("/&gt;/", "\t_gt_\t", $str);
   $str = preg_replace("/&amp;/", "&", $str);
   $str = preg_replace("/&quot;/", "\"", $str);
   $str = preg_replace("/&nbsp;/", "\t_nbsp_\t", $str);
   $str = preg_replace("/([^(http:\/\/)]|\(|^)(www\.[^[:space:]]+)/i", "\\1<A HREF=\"http://\\2\" TARGET='_blank'>\\2</A>", $str);
   $str = preg_replace("/([^(HREF=\"?'?)|(SRC=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,]+)/i", "\\1<A HREF=\"\\2\" TARGET='_blank'>\\2</A>", $str);
   // 이메일 정규표현식 수정 061004
   //$str = preg_replace("/(([a-z0-9_]|\-|\.)+@([^[:space:]]*)([[:alnum:]-]))/i", "<a href='mailto:\\1'>\\1</a>", $str);
   $str = preg_replace("/([0-9a-z]([-_\.]?[0-9a-z])*@[0-9a-z]([-_\.]?[0-9a-z])*\.[a-z]{2,4})/i", "<a href='mailto:\\1'>\\1</a>", $str);
   $str = preg_replace("/\t_nbsp_\t/", "&nbsp;" , $str);
   $str = preg_replace("/\t_lt_\t/", "&lt;", $str);
   $str = preg_replace("/\t_gt_\t/", "&gt;", $str);

   return $str;
}

/** url을 검사하여 유효한 url로 리턴   **/
function urlCheck($str){
  $return = null;
  if($str){
    $URL = parse_url($str);
    if(is_array($URL)){
      if(!$URL['scheme']){
        $URL['scheme'] = "http://";
      }else{
        $URL['scheme'] .= "://";
      }

      if($URL['scheme'] != "http" && $URL['scheme'] != "https") $URL['scheme'] = "http";
      $URL['scheme'] .= "://";

      if(empty($URL['host']) &&  !empty($URL['path']) ){
        $URL['hostname'] = $URL['path'];
      }else{
        $URL['hostname'] = $URL['host'];
      }

      if(   (gethostbyname($URL['hostname']) != $URL['hostname']) && (gethostbyname($URL['hostname']) != "")  ){
        $return = $URL['scheme'];
				if($URL['user']) $return .= $URL['user'];
				if($URL['pass']) $return .= ":".$URL['pass'];
        if($URL['user'] || $URL['pass']) $return .= "@";
				if($URL['host']) $return .= $URL['host'];
				if($URL['port']) $return .= ":".$URL['port'];
				if($URL['path']) $return .= $URL['path'];
				if($URL['query']) $return .= "?".$URL['query'];
				if($URL['fragment']) $return .= "#".$URL['fragment'];


      }
    }
  }
  return $return;
}

/** 특정단어 강조표시 (검색어 치환)   **/
function highlight($word, $subject) {
	$split_subject = explode(" ", $subject);
	$split_word = explode(" ", $word);

	foreach ($split_subject as $k => $v){
		foreach ($split_word as $k2 => $v2){
//			if($v2 == $v){
//				$split_subject[$k] = "<span class='highlight'>".$v."</span>";
//			}
      if(preg_match("/$v2/",$v)){
				$split_subject[$k] = "<span class='highlight'>".$v."</span>";
				$split_subject[$k] = str_replace($v2,"<span class='highlight'>".$v2."</span>",$v);
      }

		}
	}


	return implode(' ', $split_subject);
}

/** span/font 태그 삭제  **/
function fontTagRemove($str){
	return preg_replace("<\/?(span|font)[^>]*>", "", $str);
}

/** br -> nl  **/
function br2nl($string) {
	return preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $string);
}

/*====================================================================================================
▶ object
----------------------------------------------------------------------------------------------------*/
/** 외부 URL의 내용 얻어오기 **/
function curl_get_file_contents($URL) {
  $c = curl_init();
  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($c, CURLOPT_URL, $URL);
  $contents = curl_exec($c);
  curl_close($c);

  if ($contents) return $contents;
  else return FALSE;
}

/** object(XML) to array **/
function objectsIntoArray($arrObjData, $arrSkipIndices = array()){
    $arrData = array();

    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }

    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}


/*====================================================================================================
▶ api
----------------------------------------------------------------------------------------------------*/
/** 네이버 맵 좌표구하기 **/
function NaverMapNPoint($mapAddr){
  require_once _CORE_PATH_."/system/PHP.HTTPRequest.php";
  require_once _CORE_PATH_."/system/XMLparse.php";

  $key = "0c54cee5a7e09ed7e99311294772f8ca";
  $key = "554efccdef53214c37bd834f65085d00";
  $query = urlencode(trim($mapAddr));
  if (strlen($query) > 0) {
    $minx = 999999;
    $maxx = 0;
    $miny = 999999;
    $maxy = 0;

    $encodedquery = urlencode($query);

    $url = "http://map.naver.com/api/geocode.php?key=".$key."&query=".$query."&coord=latlng" ;
  //echo $url;
    $httpr = new HttpRequest('GET',$url);
    $httpr->send();
    $parser = new XMLParser($httpr->responseText);             // 객체생성 parser라는 객체를 생성함
    $parser->Parse();                                  // Parse()메소를 호출하여 xml을 dom 방식으로 파싱함


    function NaverMapApi($parser){
      $childrenCount = count($parser->document->tagChildren);
      $return['channel'][$parser->document->tagChildren[0]->tagName] = $parser->document->tagChildren[0]->tagData; // userquery
      $return['channel'][$parser->document->tagChildren[1]->tagName] = $parser->document->tagChildren[1]->tagData; // total

      if($childrenCount > 5)$childrenCount = 5;
      for($i=2; $i < $childrenCount; $i++){
        $j = $i - 2;
        $return['item'][$j][$parser->document->tagChildren[$i]->tagChildren[0]->tagChildren[0]->tagName] = $parser->document->tagChildren[$i]->tagChildren[0]->tagChildren[0]->tagData; // title
        $return['item'][$j][$parser->document->tagChildren[$i]->tagChildren[0]->tagChildren[1]->tagName] = $parser->document->tagChildren[$i]->tagChildren[0]->tagChildren[1]->tagData; // link
      }
      return $return;
    }
  $xmlData = NaverMapApi($parser);
  }
  if($xmlData) return $xmlData;
}


/** 구글에서 환율정보 가져오기 **/
function googleCurrency($from_Currency,$to_Currency,$amount) {
	$amount = urlencode($amount);
	$from_Currency = urlencode($from_Currency);
	$to_Currency = urlencode($to_Currency);
	$url = "http://www.google.com/ig/calculator?hl=en&q=$amount$from_Currency=?$to_Currency";
	$ch = curl_init();
	$timeout = 0;
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$rawdata = curl_exec($ch);
	curl_close($ch);
	$data = explode('"', $rawdata);
	$data = explode(' ', $data[3]);
	$var = $data[0];
	return round($var,3);
  /* 국가코드
  <option value="EUR">Euro - EUR</option>
  <option value="USD" selected="selected">United States Dollars - USD</option>
  <option value="GBP">United Kingdom Pounds - GBP</option>
  <option value="CAD">Canada Dollars - CAD</option>
  <option value="AUD">Australia Dollars - AUD</option>
  <option value="JPY">Japan Yen - JPY</option>
  <option value="INR">India Rupees - INR</option>
  <option value="NZD">New Zealand Dollars - NZD</option>
  <option value="CHF">Switzerland Francs - CHF</option>
  <option value="ZAR">South Africa Rand - ZAR</option>
  <option value="DZD">Algeria Dinars - DZD</option>
  <option value="USD">America (United States) Dollars - USD</option>
  <option value="ARS">Argentina Pesos - ARS</option>
  <option value="AUD">Australia Dollars - AUD</option>
  <option value="BHD">Bahrain Dinars - BHD</option>
  <option value="BRL">Brazil Reais - BRL</option>
  <option value="BGN">Bulgaria Leva - BGN</option>
  <option value="CAD">Canada Dollars - CAD</option>
  <option value="CLP">Chile Pesos - CLP</option>
  <option value="CNY">China Yuan Renminbi - CNY</option>
  <option value="CNY">RMB (China Yuan Renminbi) - CNY</option>
  <option value="COP">Colombia Pesos - COP</option>
  <option value="CRC">Costa Rica Colones - CRC</option>
  <option value="HRK">Croatia Kuna - HRK</option>
  <option value="CZK">Czech Republic Koruny - CZK</option>
  <option value="DKK">Denmark Kroner - DKK</option>
  <option value="DOP">Dominican Republic Pesos - DOP</option>
  <option value="EGP">Egypt Pounds - EGP</option>
  <option value="EEK">Estonia Krooni - EEK</option>
  <option value="EUR">Euro - EUR</option>
  <option value="FJD">Fiji Dollars - FJD</option>
  <option value="HKD">Hong Kong Dollars - HKD</option>
  <option value="HUF">Hungary Forint - HUF</option>
  <option value="ISK">Iceland Kronur - ISK</option>
  <option value="INR">India Rupees - INR</option>
  <option value="IDR">Indonesia Rupiahs - IDR</option>
  <option value="ILS">Israel New Shekels - ILS</option>
  <option value="JMD">Jamaica Dollars - JMD</option>
  <option value="JPY">Japan Yen - JPY</option>
  <option value="JOD">Jordan Dinars - JOD</option>
  <option value="KES">Kenya Shillings - KES</option>
  <option value="KRW">Korea (South) Won - KRW</option>
  <option value="KWD">Kuwait Dinars - KWD</option>
  <option value="LBP">Lebanon Pounds - LBP</option>
  <option value="MYR">Malaysia Ringgits - MYR</option>
  <option value="MUR">Mauritius Rupees - MUR</option>
  <option value="MXN">Mexico Pesos - MXN</option>
  <option value="MAD">Morocco Dirhams - MAD</option>
  <option value="NZD">New Zealand Dollars - NZD</option>
  <option value="NOK">Norway Kroner - NOK</option>
  <option value="OMR">Oman Rials - OMR</option>
  <option value="PKR">Pakistan Rupees - PKR</option>
  <option value="PEN">Peru Nuevos Soles - PEN</option>
  <option value="PHP">Philippines Pesos - PHP</option>
  <option value="PLN">Poland Zlotych - PLN</option>
  <option value="QAR">Qatar Riyals - QAR</option>
  <option value="RON">Romania New Lei - RON</option>
  <option value="RUB">Russia Rubles - RUB</option>
  <option value="SAR">Saudi Arabia Riyals - SAR</option>
  <option value="SGD">Singapore Dollars - SGD</option>
  <option value="SKK">Slovakia Koruny - SKK</option>
  <option value="ZAR">South Africa Rand - ZAR</option>
  <option value="KRW">South Korea Won - KRW</option>
  <option value="LKR">Sri Lanka Rupees - LKR</option>
  <option value="SEK">Sweden Kronor - SEK</option>
  <option value="CHF">Switzerland Francs - CHF</option>
  <option value="TWD">Taiwan New Dollars - TWD</option>
  <option value="THB">Thailand Baht - THB</option>
  <option value="TTD">Trinidad and Tobago Dollars - TTD</option>
  <option value="TND">Tunisia Dinars - TND</option>
  <option value="TRY">Turkey Lira - TRY</option>
  <option value="AED">United Arab Emirates Dirhams - AED</option>
  <option value="GBP">United Kingdom Pounds - GBP</option>
  <option value="USD">United States Dollars - USD</option>
  <option value="VEB">Venezuela Bolivares - VEB</option>
  <option value="VND">Vietnam Dong - VND</option>
  <option value="ZMK">Zambia Kwacha - ZMK</option>
  */
}

/*====================================================================================================
▶ security
----------------------------------------------------------------------------------------------------*/
/** XSS (cross site scripting) filter function  **/
function RemoveXSS($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are*
   // allowed in some inputs
   $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&
   // #X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
   // ;? matches the ;, which is optional
   // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

   // &#x0040 @ search for the hex values
      $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
      // with a ;

      // @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style',
'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
               $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
               $pattern .= ')?';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         //$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $replacement = htmlspecialchars($ra[$i]);
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return trim($val);
}

/** SQL 인젝션 공격대응  **/
/** mysql_real_escape_string 함수를 사용,   **/
/** ON일 경우 magic_quotes_gpc/magic_quotes_sybase 효과 제거   **/
function mysql_escape_str($string){
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string");
	// i.e PHP >= v4.3.0
	if ($new_enough_php) {
		//undo any magic quote effects so mysql_real_escape_string can do the work
		if ($magic_quotes_active) {
			$string = stripslashes($string);
		}
		$new_string = mysql_real_escape_string($string);
		if (empty($new_string) && !empty($string)) {
			die("mysql_real_escape_string failed."); //insert your error handling here
		}
		$string = $new_string;
	} else { // before PHP v4.3.0
		// if magic quotes aren't already on this add slashes manually
		if (!$magic_quotes_active) {
			$string = addslashes($string);
		} //if magic quotes are active, then the slashes already exist
	}
	return trim($string);
}

/** 작성폼의 토큰 생성  **/
function new_token($form) {
	// generate a token from an unique value, took from microtime, you can also use salt-values, other crypting methods...
	$token = md5(uniqid(microtime(), true));

	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	$_COOKIE[$form.'_token'] = $token;
  @setcookie($form.'_token', $token,time()+600);
	return $token;
}

/** 작성폼의 토큰 확인  **/
function check_token($form) {
		// check if a session is started and a token is transmitted, if not return an error
	if(!isset($_COOKIE[$form.'_token']) || empty($_COOKIE[$form.'_token']) ) {
		return false;
	}

	return true;
	// check if the form is sent with token in it
	if(!isset($_POST['token'])) {
		return false;
	}

	// compare the tokens against each other if they are still the same
	if ($_COOKIE[$form.'_token'] !== $_POST['token']) {
		return false;
	}
	return true;
}

/** 작성폼의 토큰 제거  **/
function destory_token($form) {
	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	unset($_COOKIE[$form.'_token']);
  @setcookie($form.'_token', "",0,"/");
}

/** 암호화 (md5) **/
function encrypt_md5($buf, $key='dbf007$'){
	$ret_buf = $hex_data = null;
	$ret_buf = $hex_data = "";
 $key1 = pack("H*",md5($key));
 while($buf)
 {
  $m = substr($buf, 0, 16);
  $buf = substr($buf, 16);
  $c = "";
  for($i=0;$i<16;$i++)
  {
		if(isset($m{$i})) $c .= $m{$i}^$key1{$i};
  }
  $ret_buf .= $c;
  $key1 = pack("H*",md5($key.$key1.$m));
 }
 $len = strlen($ret_buf);
 for($i=0; $i<$len; $i++){
  $hex_data .= sprintf("%02x", ord(substr($ret_buf, $i, 1)));
 }
 return($hex_data);
}

/** 복호화 (md5)  **/
function decrypt_md5($hex_buf, $key='dbf007$'){
	$buf = $ret_buf = null;
 $len = strlen($hex_buf);
 for ($i=0; $i<$len; $i+=2){
  $buf .= chr(hexdec(substr($hex_buf, $i, 2)));
  $key1 = pack("H*", md5($key));
 }
 while($buf)
 {
  $m = substr($buf, 0, 16);
  $buf = substr($buf, 16);
  $c = "";
  for($i=0;$i<16;$i++)
  {
   $c .= ( isset($m{$i}) )? $m{$i}^$key1{$i} :"";
  }
  $ret_buf .= $m = $c;
  $key1 = pack("H*",md5($key.$key1.$m));
 }
 return($ret_buf);
}

/** 암호화 (MD5 + Base64)  **/
function encrypt_md5_base64($plain_text, $password="password", $iv_len = 16){
	$enc_text = Null;
	$plain_text .= "\x13";
	$n = strlen($plain_text);
	if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
	$i = 0;

	while ($iv_len-- >0){
		$enc_text .= chr(mt_rand() & 0xff);
	}

	$iv = substr($password ^ $enc_text, 0, 512);
	while($i <$n){
		$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
		$enc_text .= $block;
		$iv = substr($block . $iv, 0, 512) ^ $password;
		$i += 16;
	}
	return base64_encode($enc_text);
}

/** 복호화 (MD5 + Base64)  **/
function decrypt_md5_base64($enc_text, $password="password", $iv_len = 16){
	$enc_text = base64_decode($enc_text);
	$n = strlen($enc_text);
	$i = $iv_len;
	$plain_text = '';
	$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
	while($i <$n){
		$block = substr($enc_text, $i, 16);
		$plain_text .= $block ^ pack('H*', md5($iv));
		$iv = substr($block . $iv, 0, 512) ^ $password;
		$i += 16;
	}
	return preg_replace('/\x13\x00*$/', '', $plain_text);
}

/** 전송된 변수 체크 반환  **/
function Request($str){
	return CheckValue("check", $str);
}

/** 입력할 변수 체크 반환 **/
function Input($str){
	return removeHackTag(CheckValue("input", $str));
}

/** 전송유형별 값 체크 반환 **/
function CheckValue($type, $val){
	if($type == "input"){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$return = (isset($_POST[$val]))? InputValueCheck($_POST[$val]) : null;
		}else{
			$return = (isset($_GET[$val]))? InputValueCheck($_GET[$val]) : null;
		}
	}else{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$return = (isset($_POST[$val]))? RequestValueCheck($_POST[$val]) : null;
		}else{
			$return = (isset($_GET[$val]))? RequestValueCheck($_GET[$val]) : null;
		}
	}
	return $return;
}

/** 전송된 변수 체크  **/
function RequestValueCheck($buff){
	if(!is_array($buff)) return RemoveXSS($buff);
	return array_map('RemoveXSS',$buff);
}

/** 입력할 변수 체크  **/
function InputValueCheck($buff){
	if(!is_array($buff)) return mysql_escape_str($buff);
	return array_map('mysql_escape_str',$buff);
}

/** 변수 기본값 설정  **/
function SetValue($val, $type = null, $default = null){
	if($type && $type != "") $val = TypeCheck($type, trim($val));
	if(strlen($val) == 0){
		if(!$val || $val == "" )  $val = $default;
	}
	return $val;
}

/** 변수 형태 체크  **/
function TypeCheck($type, $val){
	switch($type){
		Case "digit":

			if(ctype_digit($val) == true) $return  = $val;
			else $return = null;
		break;
		Case "alpha":
			if(ctype_alpha($val) == true) $return  = $val;
			else $return  = null;
		break;
		Case "alnum":
			if(ctype_alnum($val) == true) $return  = $val;
			else $return = null;
		break;
		Default:
			$return = $val;
	}
	return $return;
}

/*====================================================================================================
▶ page control
----------------------------------------------------------------------------------------------------*/
/** meta refresh  **/
function metaRefresh($url, $sec=0){
  echo "<meta http-equiv=Refresh content='$sec;URL=$url'>";
  exit;
}

/** self.close  **/
function selfClose($msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "self.close();".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** history.back  **/
function historyBack($msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "history.go(-1);".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** location.href  **/
function locationHref($url, $msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "location.href = '$url';".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** location.replace()  **/
function locationReplace($url, $msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "location.replace('$url');".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** top.location.href  **/
function toplocationHref($url, $msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "parent.location.href = '$url';".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** top.location.replace  **/
function toplocationReplace($url, $msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "parent.location.replace('$url');".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** opener.location.href  **/
function openerlocationHref($url, $msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "opener.location.href = '$url';".ENTER;
	echo "self.close();".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** opener.location.reload()  **/
function openerlocationReload($msg = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "opener.location.reload();".ENTER;
	echo "self.close();".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

/** form submit  **/
function formSubmit($url, $msg = Null, $Field = null){
	$alert = ($msg) ? "alert('$msg');" : "";
	if(is_array($Field)){
		echo "<script type='text/javascript'>".ENTER;
		echo "<!--".ENTER;
		echo $alert.ENTER;
		foreach($Field as $Key => $Value)		echo "document.hform.".$Key.".value='".$Value."';".ENTER;
		echo "document.hform.submit();".ENTER;
		echo "//-->".ENTER;
		echo "</script>".ENTER;
	}else{
		echo "<script type='text/javascript'>".ENTER;
		echo "<!--".ENTER;
		echo $alert.ENTER;
		echo "document.hform.action ='$url';".ENTER;
		echo "document.hform.submit();".ENTER;
		echo "//-->".ENTER;
		echo "</script>;".ENTER;
	}
	exit;
}

/** alert  **/
function alert($msg){
	if( $msg != Null)	{
		echo "<script type='text/javascript'>".ENTER;
		echo "<!--".ENTER;
		echo "window.alert('$msg');".ENTER;
		echo "//-->".ENTER;
		echo "</script>".ENTER;
	}
}

/*====================================================================================================
▶ board
----------------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------
▶ LAST_INSERT_ID 구하기 */
function LAST_INSERT_ID(){
	global $db;
	$GETIDX = $db->Value("Select LAST_INSERT_ID() as idx");
	if($GETIDX)	$return = $GETIDX;
	else $return = 1;
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ 새글의  fid 구하기 */
function Fid(){
	global $db, $Board;
	# 새로 작성된 게시물의 fid(family id), uid(unique id)값을 결정한다. */
	$CHECK = $db->Value("SELECT max(fid) as maxfid FROM ".$Board['table_board']." Where BoardID = '".$Board['board_id']."'");
	if($CHECK) { $new_fid = $CHECK + 1;} else { $new_fid = 1;}
	return $new_fid;
}

/*-------------------------------------------------------------------------------------------------
▶ 조회수 증가 */
function Hit(){
	global $db, $Board, $req;
	$key = $Board['table_board'].$Board['board_id']."_".$req['idx'];
	$return = 0;
	if(!isset($_COOKIE[$key]) || empty($_COOKIE[$key]) ){
		if($req['idx']){
			$db -> ExecQuery("Update ".$Board['table_board']." set Hit = Hit + 1 where  BoardID = '".$Board['board_id']."' and idx = '".$req['idx']."'");
			$return = 1;
		}
		@setcookie($key,date("Y-m-d"),time()+86400,"/");
	}
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ 이전글 */
function NextSubject($mode = "thread"){
	global $db, $Board, $req, $Value, $href;

	if($mode == "thread"){
		if(isset($Value['fid'])){
			/*
				윗글
				thread의 길이가 2이상이면 윗글은 분명히 같은 fid 이다.
				그중 thread 가 더 작은값중 맨 처음것을 찾는다.
			*/
			$thread_len = strlen($Value['thread']);
			if($thread_len > 1){
				$NextQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and fid = ".$Value['fid']." AND thread < '".$Value['thread']."' order by thread DESC limit 1";
			}else{
				$NextQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and fid > ".$Value['fid']." order by fid ASC, thread DESC limit 1";
			}
		}else{
			$NextQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and idx > ".$Value['idx']." Order By idx asc Limit 0,1";
		}
		$NextDATA = $db->SelectOne($NextQuery);
		if($NextDATA)	{
			return "<a href='".$href."&at=view&idx=".$NextDATA['idx']."'>".$NextDATA['Subject']."</a>";
		}else{
			return "이전글이 없습니다.";
		}
	}

}

/*-------------------------------------------------------------------------------------------------
▶ 다음글 */
function PrevSubject($mode = "thread"){
	global $db, $Board, $req, $Value, $href;

	if($mode == "thread"){
		if(isset($Value['fid'])){
			$thread_len = strlen($Value['thread']);
			if($thread_len > 1){
				$MaxThread = $db->SelectOne("SELECT max(thread) as maxthread FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and fid = ".$Value['fid']);
				if($Value['thread'] == $MaxThread['maxthread']){
					$PrevQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and fid < ".$Value['fid']." order by fid DESC, thread ASC limit 1";
				}else{
					$PrevQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and fid = ".$Value['fid']." AND thread > '".$Value['thread']."' order by fid DESC, thread ASC limit 1";
				}
			}else{
				$FidCount = $db->SelectOne("SELECT count(fid) as countfid FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and fid = ".$Value['fid']);
				if($FidCount['countfid'] > 1){
					$PrevQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and fid = ".$Value['fid']." AND thread > '".$Value['thread']."' order by fid DESC, thread ASC limit 1";
				}else{
					$PrevQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and fid < ".$Value['fid']." order by fid DESC, thread ASC limit 1";
				}
			}
		}else{
			$PrevQuery = "SELECT idx, Subject FROM ".$Board['table_board']." WHERE BoardID = '".$Board['board_id']."' and Notice = 'N' and idx < ".$Value['idx']." Order By idx desc Limit 0,1";
		}

		$PrevDATA = $db->SelectOne($PrevQuery);
		if($PrevDATA){
			return "<a href='".$href."&at=view&idx=".$PrevDATA['idx']."'>".$PrevDATA['Subject']."</a>";
		}else{
			return "다음글이 없습니다.";
		}
	}

}


/*-------------------------------------------------------------------------------------------------
▶ 답글의 thread 구하기 */
function Thread($idx){
	global $db, $Board;
	$return = null;
	$CHECK = $db -> SelectOne("SELECT fid, thread FROM ".$Board['table_board']." Where BoardID = '".$Board['board_id']."' and idx = '".$idx."'");
	if(is_array($CHECK)) {
		$fid = $CHECK['fid'];
		$thread = $CHECK['thread'];

		# 원글의 입력값으로부터 답변글에 입력할 정보(정렬 및 indent에 필요한 thread필드값)를 뽑아낸다. */
		$SelectQuery  = "SELECT thread AS thread ,right(thread,1) as rightthread FROM ".$Board['table_board'];
		$WhereQuery   = " WHERE BoardID = '".$Board['board_id']."' and fid = ".$fid." AND length( thread ) = length('".$thread."')+1 AND locate('".$thread."',thread) = 1";
		$OrderbyQuery = " ORDER BY thread DESC LIMIT 1";
		$DATA = $db -> SelectOne($SelectQuery.$WhereQuery.$OrderbyQuery);// 데이터를 가져온다.
		if(is_array($DATA)){
			$thread_head = substr($DATA['thread'],0,-1);
			$thread_foot = ++$DATA['rightthread'];
			$new_thread = $thread_head . $thread_foot;
		}else{
			$new_thread = $thread ."A";
		}
		$return  = array("fid" => $fid,"thread" => $new_thread);
	}
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ new icon  */
function IconNew($val, $interval, $img){
	$return = null;
	if($val){
		if(strtotime($val)+$interval > time()) return $img;
	}
}

/*-------------------------------------------------------------------------------------------------
▶ 답변글 아이콘 */
function CheckReply($thread, $img = ""){
	$icon_re = Null;
	$img = ($img)? $img :"<img src='"._CORE_."/images/common/icon_re.gif' align='middle' alt='reply' /> " ;
	if($thread!="A"){
		for($i=1;$i<strlen($thread);$i++)$icon_re = $icon_re."&nbsp;&nbsp;";
	}
	if($icon_re)$icon_re .= $icon_re. $img ;
	return $icon_re;
}

/*-------------------------------------------------------------------------------------------------
▶ 비밀글 아이콘 */
function CheckSecret($secret, $img = ""){
	$return = Null;
	if($secret == "Y"){
		$return = ($img)? $img: " <img src='"._CORE_."/images/common/icon_secret.gif' align='middle' alt='secret' /> " ;
	}
	return $return;
}


/*-------------------------------------------------------------------------------------------------
▶ 파일아이콘 */
function fnGetFileicon($fileurl) {
	$img_url = _CORE_."/images/fileicon/";
	$aFileurl = explode(".",$fileurl);
	// 파일 타입 설정
	$cnt = count($aFileurl) -1;
	$file_ext = strtolower($aFileurl[$cnt]);
	switch($file_ext) {
	case "ai":  $file_type="<img src='".$img_url."ai.gif'  border='0'  alt='ai'  align='middle'/>"; break;
	case "psd": $file_type="<img src='".$img_url."psd.gif' border='0'  alt='psd' align='middle'/>"; break;
	case "fla": $file_type="<img src='".$img_url."fla.gif' border='0'  alt='fla' align='middle'/>"; break;
	case "swf": $file_type="<img src='".$img_url."swf.gif' border='0'  alt='swf' align='middle'/>"; break;
	case "eps": $file_type="<img src='".$img_url."eps.gif' border='0'  alt='eps' align='middle'/>"; break;

	case "alz": $file_type="<img src='".$img_url."alz.gif' border='0'  alt='alz' align='middle'/>"; break;
	case "zip": $file_type="<img src='".$img_url."zip.gif' border='0'  alt='zip' align='middle'/>"; break;
	case "rar": $file_type="<img src='".$img_url."rar.gif' border='0'  alt='rar' align='middle'/>"; break;
	case "tar": $file_type="<img src='".$img_url."tar.gif' border='0'  alt='tar' align='middle'/>"; break;
	case "tgz": $file_type="<img src='".$img_url."tgz.gif' border='0'  alt='tgz' align='middle'/>"; break;
	case "gz":  $file_type="<img src='".$img_url."gz.gif'  border='0'  alt='gz'  align='middle'/>"; break;

	case "gif": $file_type="<img src='".$img_url."gif.gif' border='0'  alt='gif' align='middle'/>"; break;
	case "bmp": $file_type="<img src='".$img_url."bmp.gif' border='0'  alt='bmp' align='middle'/>"; break;
	case "jpeg":$file_type="<img src='".$img_url."jpg.gif' border='0'  alt='jpeg' align='middle'/>"; break;
	case "jpg": $file_type="<img src='".$img_url."jpg.gif' border='0'  alt='jpg' align='middle'/>"; break;
	case "png": $file_type="<img src='".$img_url."etc.gif' border='0'  alt='etc' align='middle'/>"; break;

	case "dcr": $file_type="<img src='".$img_url."dcr.gif' border='0'  alt='dcr' align='middle'/>"; break;
	case "doc": $file_type="<img src='".$img_url."doc.gif' border='0'  alt='doc' align='middle'/>"; break;
	case "docx": $file_type="<img src='".$img_url."doc.gif' border='0'  alt='doc' align='middle'/>"; break;
	case "hwp": $file_type="<img src='".$img_url."hwp.gif' border='0'  alt='hwp' align='middle'/>"; break;
	case "gul": $file_type="<img src='".$img_url."gul.gif' border='0'  alt='gul' align='middle'/>"; break;
	case "pdf": $file_type="<img src='".$img_url."pdf.gif' border='0'  alt='pdf' align='middle'/>"; break;
	case "ppt": $file_type="<img src='".$img_url."ppt.gif' border='0'  alt='ppt' align='middle'/>"; break;
	case "xls": $file_type="<img src='".$img_url."xls.gif' border='0'  alt='xls' align='middle'/>"; break;

	case "asp":	$file_type="<img src='".$img_url."asp.gif' border='0'  alt='asp' align='middle'/>"; break;
	case "jsp": $file_type="<img src='".$img_url."jsp.gif' border='0'  alt='jsp' align='middle'/>"; break;
	case "php": $file_type="<img src='".$img_url."php.gif' border='0'  alt='php' align='middle'/>"; break;
	case "txt": $file_type="<img src='".$img_url."txt.gif' border='0'  alt='txt' align='middle'/>"; break;
	case "js":  $file_type="<img src='".$img_url."js.gif'  border='0'  alt='js'  align='middle'/>"; break;

	case "url": $file_type="<img src='".$img_url."url.gif' border='0'  alt='url' align='middle'/>"; break;
	case "xml": $file_type="<img src='".$img_url."xml.gif' border='0'  alt='xml' align='middle'/>"; break;
	case "html":$file_type="<img src='".$img_url."htm.gif' border='0'  alt='html' align='middle'/>"; break;
	case "htm": $file_type="<img src='".$img_url."htm.gif' border='0'  alt='htm' align='middle'/>"; break;

	case "eml": $file_type="<img src='".$img_url."eml.gif' border='0'  alt='eml' align='middle'/>"; break;
	case "ttf": $file_type="<img src='".$img_url."ttf.gif' border='0'  alt='ttf' align='middle'/>"; break;
	case "exe": $file_type="<img src='".$img_url."exe.gif' border='0'  alt='exe' align='middle'/>"; break;
	case "mdb": $file_type="<img src='".$img_url."mdb.gif' border='0'  alt='mdb' align='middle'/>"; break;

	case "asf": $file_type="<img src='".$img_url."asf.gif' border='0'  alt='asf' align='middle'/>"; break;
	case "asx": $file_type="<img src='".$img_url."asx.gif' border='0'  alt='asx' align='middle'/>"; break;
	case "avi": $file_type="<img src='".$img_url."avi.gif' border='0'  alt='avi' align='middle'/>"; break;
	case "wax": $file_type="<img src='".$img_url."avi.gif' border='0'  alt='wax' align='middle'/>"; break;
	case "mp3": $file_type="<img src='".$img_url."avi.gif' border='0'  alt='mp3' align='middle'/>"; break;
	case "wav": $file_type="<img src='".$img_url."avi.gif' border='0'  alt='wav' align='middle'/>"; break;
	case "wma": $file_type="<img src='".$img_url."avi.gif' border='0'  alt='wma' align='middle'/>"; break;
	case "wmv": $file_type="<img src='".$img_url."avi.gif' border='0'  alt='wmv' align='middle'/>"; break;
	case "mpg":	$file_type="<img src='".$img_url."avi.gif' border='0'  alt='avi' align='middle'/>"; break;
	case "mp3": $file_type="<img src='".$img_url."mp3.gif' border='0'  alt='mp3' align='middle'/>"; break;
	case "mid": $file_type="<img src='".$img_url."mid.gif' border='0'  alt='mid' align='middle'/>"; break;
	case "mov": $file_type="<img src='".$img_url."mov.gif' border='0'  alt='mov' align='middle'/>"; break;
	case "ram": $file_type="<img src='".$img_url."ram.gif' border='0'  alt='ram' align='middle'/>"; break;
	case "qt" : $file_type="<img src='".$img_url."mov.gif' border='0'  alt='qt'  align='middle'/>"; break;
	case "rm" : $file_type="<img src='".$img_url."rm.gif'  border='0'  alt='rm'  align='middle'/>"; break;
	case "smil":$file_type="<img src='".$img_url."smil.gif' border='0'  alt='smil' align='middle'/>"; break;
	case "mpeg":$file_type="<img src='".$img_url."avi.gif' border='0'  alt='mpeg' align='middle'/>"; break;

	case ""   : $file_type="<img src='".$img_url."unknown.gif' border='0'   alt='unknown' align='middle'/>"; break;
	default   : $file_type="<img src='".$img_url."unknown.gif' border='0'   alt='unknown' align='middle'/>"; break;
	}
	return $file_type;
}


/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 썸네일 */
function ThumbNailView($file, $header = "t", $w = "", $h = "", $height = ""){
	global $db, $Board;
	if($w == "")$w = "100";
	if($h == "")$h = "0";
	if($height == "")$height = "";
	else $height = "height='$height'";
	$return = null;
  $filenamePos = strrpos($file,"/");
  $filename = substr($file,$filenamePos+1,strlen($file));
  $filpath  = substr($file,0,$filenamePos);

	$thumbNailPath = _ROOT_.$filpath."/thumbnail/";
  $filePath = _ROOT_.$filpath."/";
  $file_header = $header."_";


  if(file_exists($filePath.$filename)){
      $thumbNailImageName = $file_header.$filename;
      $ImgWidth = $ImgHeight = $ImgType = $ImgAttr = null;
      $thumbPath = $thumbNailPath;

      if(!file_exists($thumbPath.$thumbNailImageName )){
        thumbnail($filePath.$filename, $thumbNailImageName, $thumbPath, $w, $h);
      }else{
        list($ImgWidth, $ImgHeight, $ImgType, $ImgAttr) = getimagesize($thumbPath.$thumbNailImageName);
        if($ImgWidth != $w || $ImgHeight != $h) thumbnail($filePath.$filename, $thumbNailImageName, $thumbPath, $w, $h);
      }
      $thumbNail = str_replace(_ROOT_,"",$thumbPath).$thumbNailImageName;
      if(file_exists($thumbPath.$thumbNailImageName)){
        $return = $thumbNail;
      }
  }


	return $return;

}

/*-------------------------------------------------------------------------------------------------
▶ 썸네일 생성 */
Function thumbnail($file, $save_filename, $save_path, $max_width, $max_height) {
	$gd_version=gd_info();
  $return = null;

	if(!is_writable($save_path)){
		umask(0);
		if(file_exists($save_path)) chmod( $save_path, 0777);
		else	mkdir( $save_path , 0777);

		if(!file_exists($save_path)) {
			$return['msg'] = "저장 폴더가 존재하지 않습니다. ";
			$return['result'] = false;
			return $return;
		}
		if(!is_writable($save_path)) {
			$return['msg'] = "저장 폴더에 쓰기권한이 없습니다.";
			$return['result'] = false;
			return $return;
		}
	}

	// 전송받은 이미지 정보를 받는다
	$img_info = @getImageSize($file);

	if(!$img_info){
  }else{
	// 전송받은 이미지의 포맷값 얻기 (gif, jpg png)
	if($img_info[2] == 1) {
					$src_img = @ImageCreateFromGif($file);
					} else if($img_info[2] == 2) {
									$src_img = ImageCreateFromJPEG($file);
									} else if($img_info[2] == 3) {
													$src_img = @ImageCreateFromPNG($file);
									} else {
									return 0;
					}

  if($src_img){

	// 전송받은 이미지의 실제 사이즈 값얻기
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width <= $max_width) {
					$max_width = $img_width;
					$max_height = $img_height;
	}

	//if($img_width > $max_width){
	//	$max_height = ceil(($max_width / $img_width) * $img_height);
	//}

	// 최대허용높이를 0으로 하면
	if($max_height == 0){
		$max_height = ceil(($max_width / $img_width) * $img_height);
	}

	// 최대 폭을 0으로 하면
	if($max_width == 0){
		$max_width = (($img_width / $img_height) * $max_height);
	}

	 // 이미지 높이가 허용 높이보다 크다면
	if($img_height > $max_height){
		// 허용 폭도 허용높이의 크기에 맞춘 비율로 줄인다.
		$max_width2 = (($img_width / $img_height) * $max_height);
	}else{
		// 허용높이보다 이미지 높이가 작다면 최대 이미지폭은 그대로 사용한다.
		$max_width2 = $max_width;
	}

	// 새로구한 허용 폭이 넘어온 허용폭보다 크다면
	if($max_width2 > $max_width){
		// 허용폭을 넘어온 허용폭을 사용한다.
		$max_width = $max_width;
		// 허용높이는 넘어온 허용폭의 비율에 맞추어 사용한다.
		$max_height = ceil(($max_width / $img_width) * $img_height);
	}else{
		// 새로구한 허용폭이 넘어온 허용폭보다 작으면,  새로구한 값을 허용폭으로 사용하고, 허용높이를 새로구한다.
		$max_width = $max_width2;
		$max_height = ceil(($max_width / $img_width) * $img_height);
	}







	if ($img_width<500)	//no point in resampling images larger than 500 - too much overhead - a resize is more economical
	{

		if (substr_count(strtolower($gd_version['GD Version']), "2.")>0)
		{
			//GD 2.0
			//$thumbnail = ImageCreateTrueColor($thumb_width, $thumb_height);
			//imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);
			// 새로운 트루타입 이미지를 생성
			$dst_img = @imagecreatetruecolor($max_width, $max_height);

			// R255, G255, B255 값의 색상 인덱스를 만든다
			@ImageColorAllocate($dst_img, 255, 255, 255);

			// 이미지를 비율별로 만든후 새로운 이미지 생성
			@ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, ImageSX($src_img),ImageSY($src_img));
		} else {
			//GD 1.0
			// 새로운 트루타입 이미지를 생성
			//$dst_img = @imagecreatetruecolor($max_width, $max_height);
			$dst_img = @imagecreate($max_width, $max_height);

			// R255, G255, B255 값의 색상 인덱스를 만든다
			//@ImageColorAllocate($dst_img, 255, 255, 255);

			// 이미지를 비율별로 만든후 새로운 이미지 생성
			@imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, ImageSX($src_img),ImageSY($src_img));
			//$thumbnail = imagecreate($thumb_width, $thumb_height);
			//imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);
		}
	} else {
		if (substr_count(strtolower($gd_version['GD Version']), "2.")>0)

		{
			//GD 2.0
			//$thumbnail = ImageCreateTrueColor($thumb_width, $thumb_height);
			//imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);
			// 새로운 트루타입 이미지를 생성
			$dst_img = @imagecreatetruecolor($max_width, $max_height);

			// R255, G255, B255 값의 색상 인덱스를 만든다
			@ImageColorAllocate($dst_img, 255, 255, 255);

			// 이미지를 비율별로 만든후 새로운 이미지 생성
			@imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, ImageSX($src_img),ImageSY($src_img));
		} else {
			//GD 1.0
			// 새로운 트루타입 이미지를 생성
			//$dst_img = @imagecreatetruecolor($max_width, $max_height);
			$dst_img = @imagecreate($max_width, $max_height);

			// R255, G255, B255 값의 색상 인덱스를 만든다
			//@ImageColorAllocate($dst_img, 255, 255, 255);

			// 이미지를 비율별로 만든후 새로운 이미지 생성
			@imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, ImageSX($src_img),ImageSY($src_img));
			//$thumbnail = imagecreate($thumb_width, $thumb_height);
			//imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);
		}
	}

	// 알맞는 포맷으로 저장
	if($img_info[2] == 1) {
					@ImageInterlace($dst_img);
					//ImageGif($dst_img, $save_path.$save_filename);
									@ImageJPEG($dst_img, $save_path.$save_filename);
					} else if($img_info[2] == 2) {
									@ImageInterlace($dst_img);
									@ImageJPEG($dst_img, $save_path.$save_filename);
									} else if($img_info[2] == 3) {
													@ImagePNG($dst_img, $save_path.$save_filename);
									}

	// 임시 이미지 삭제
	@ImageDestroy($dst_img);
	@ImageDestroy($src_img);
//return $max_width."-".$max_height;
  }
  }
}


/*-------------------------------------------------------------------------------------------------
▶ 파일다운로드 */
function DirectDownload(){
	global $Board;
	
	//$down = urlencode(encrypt_md5_base64(_CRIPT_KEY_."저정된 파일명(파일경로포함)"._CRIPT_KEY_."다운받을 파일명"));

	$req['down'] = $_GET['down'];
	$downinfo = $req['down'];
	$downinfo = decrypt_md5_base64($downinfo);
	$down = explode(_CRIPT_KEY_,urldecode($downinfo));

	$savename = $down[1];
	$realname = 	(mb_check_encoding($down[2],"UTF-8"))? iconv("UTF-8","euc-kr",$down[2]): $down[2];


	// 접근경로 확인
	if(!isset($_SERVER['HTTP_REFERER'])) alert("직접 다운로드 받으실수 없습니다.");
	if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) alert("외부에서는 다운로드 받으실수 없습니다.");
	/*------------------------------------------------------
	$file => 실제 파일 경로
	$filename => 다운로드시 붙여질 파일명
	------------------------------------------------------*/
	$file = $savename; //실제 파일명 또는 경로

	//$filename =  iconv(mb_detect_encoding($realname),"EUC-KR",$realname);
	$filename = $realname;


	if(file_exists($file)){
		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $_SERVER['HTTP_USER_AGENT']))
		{
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5"))
			{
			header("Content-Type: doesn/matter");
			header("Content-disposition: filename=$filename");
			header("Content-Transfer-Encoding: binary");
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.0"))
			{
			Header("Content-type: file/unknown");
			header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Description: PHP4 Generated Data");
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.1"))
			{
			Header("Content-type: file/unknown");
			header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Description: PHP4 Generated Data");
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0"))
			{
			Header("Content-type: application/x-msdownload");
			Header("Content-Length: ".(string)(filesize("$file")));
			Header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Transfer-Encoding: binary");
			Header("Cache-Control: cache, must-revalidate");
			Header("Pragma: no-cache");
			Header("Expires: 0");
			}
		} else {
			Header("Content-type: file/unknown");
			Header("Content-Length: ".(string)(filesize("$file")));
			Header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Description: PHP4 Generated Data");
			Header("Cache-Control: cache, must-revalidate");
			Header("Pragma: no-cache");
			Header("Expires: 0");
		}

		if (is_file("$file")) {
			$fp = fopen("$file", "rb");
			if (!fpassthru($fp))
				fclose($fp);
		} else {
			echo "해당 파일이나 경로가 존재하지 않습니다.";
			exit;
		}
	} else {
		echo "해당 파일이나 경로가 존재하지 않습니다.";
		exit;
	}
}
































/*-------------------------------------------------------------------------------------------------
▶ 파일업로드 */
function AttachProcess($Pidx, $subDir){
	global  $db,  $Board, $_FILES;
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

	if($_FILES['files']){
		$fileCount = count($_FILES['files']['tmp_name']);

		for($i=0; $i < $fileCount; $i++){

			$AttachFile = AttachFile($_FILES["files"], $cfg['file'], '','', $i);

			if(is_array($AttachFile)){
				if($AttachFile['result'] == true){
					$FileGubun = $db -> Value("Select Max(FileGubun) as FileGubun from ".$Board['table_attach']." Where Pidx = '$Pidx' ");
					if($FileGubun > 0) $FileGubun = $FileGubun + 1;
					else $FileGubun = 1;

					$FileArray[$i] = Array(
						"FileGubun"=> $FileGubun,
						"FileName" => $AttachFile['FileName'],
						"SaveName" => $AttachFile['SaveName'],
						"FileSize" => $AttachFile['FileSize'],
						"FileType" => $AttachFile['FileType'],
						"SavePath" => $subdir
					);
				}

				$FileArrayAdd = Array(
					"BoardID" =>  $Board['board_id'],
					"Pidx"		=>  $Pidx,
					"Down"		=>  0,
					"RegIP" 	=>  ip_addr(),
					"RegDate" =>  time(),
				);

				if(isset($FileArray[$i])) {
					$FileArrayField = array_merge($FileArrayAdd,$FileArray[$i]);
					$Query = "INSERT INTO ".$Board['table_attach']." (`".implode("`, `", array_keys($FileArrayField))."`)  VALUES ('".implode("', '", $FileArrayField)."')";
					$db->ExecQuery($Query);
				}
			}
			if(isset($AttachFile['msg']) && !empty($AttachFile['msg'])) alert($AttachFile['msg']);
		}
	}
}


/* 첨부파일 저장 =========================================================================================================================================*/
/*
	$AttachFile = AttachFile(첨부파일($_FILES['file']), '업로드 환경설정', '업로드파일이 배열이라면 숫자 입력');
*/
	function AttachFile($attach, $UploadConfig, $delCheck, $delfile, $arrNum = null){
		$return  = null;     // return 값 초기화
		/* 파일 정보 */
		if(is_numeric($arrNum)){
			$tmpname = $attach['tmp_name'][$arrNum];
			$filename = $attach['name'][$arrNum];
			$filetype = $attach['type'][$arrNum];
			$filesize = $attach['size'][$arrNum];
			$fileerror = $attach['error'][$arrNum];
		}else{
			$tmpname = $attach['tmp_name'];
			$filename = $attach['name'];
			$filetype = $attach['type'];
			$filesize = $attach['size'];
			$fileerror = $attach['error'];
		}


		$subdir = str_replace(_UPLOAD_PATH_,"",$UploadConfig['savePath']);

		$dir = explode("/",$subdir);
		$updir = _UPLOAD_PATH_;
		foreach($dir as $path){
			$updir = $updir."/$path";
			umask(0);
			if(file_exists($updir)){
        @chmod( $updir, 0777);
      }else{
        if(!mkdir( $updir , 0777)){
  				$return['msg'] = "폴더 생성이 정상적으로 이루어지지 않았습니다. 폴더권한을 확인해주세요.";
	  			$return['result'] = false;
		  		return $return;
        }
      }
		}

		$UploadConfig['savePath'] = $UploadConfig['savePath']."/";

		if(!is_writable($UploadConfig['savePath'])){
			umask(0);
			if(file_exists($UploadConfig['savePath'])) @chmod( $UploadConfig['savePath'], 0777);
			else @mkdir( $UploadConfig['savePath'] , 0777);

			if(!file_exists($UploadConfig['savePath'])) {
				$return['msg'] = "파일 저장 폴더가 존재하지 않습니다. ";
				$return['result'] = false;
				return $return;
			}
			if(!is_writable($UploadConfig['savePath'])) {
				$return['msg'] = "파일 저장 폴더에 쓰기권한이 없습니다.";
				$return['result'] = false;
				return $return;
			}
		}




		if(isset($tmpname) && is_uploaded_file($tmpname)){
			/* 확장자 */
			$needle = strrpos($filename, ".") + 1; // 파일 마지막의 "." 문자의 위치를 반환한다.
			$slice = substr($filename, $needle); // 확장자 문자를 반환한다.
			$ext = strtolower($slice); // 반환된 확장자를 소문자로 바꾼다.

			/* 확장자 체크 */
			if($UploadConfig['fileCheckType'] == "allow"){
				if (!in_array(strtolower($ext), $UploadConfig['checkExt'])) {
					$return['msg'] = $filename.' not allow file.';
					$return['result'] = false;
					return $return;
				}
			}else{
				if (in_array(strtolower($ext), $UploadConfig['checkExt'])) {
					$return['msg'] = $filename.' is deny file.';
					$return['result'] = false;
					return $return;
				}
			} // if($checkInfo['filecheck'] == "allow"){

			/* 용량체크 */
			if($filesize > $UploadConfig['fileMaxSize'])	{
				$return['msg'] = $filename.' size('.printbyte($filesize).') exceeds. (Max : '.printbyte($UploadConfig['fileMaxSize']).')';
				$return['result'] = false;
				return $return;
			} // if($filesize > $checkInfo['file_max_size'])

			/* 파일 이름 재성성 */
			$content_type = split("/",$filetype);
			$nameheader = $content_type[0];
			$namebody = md5(uniqid(rand()));
			$refilename = $nameheader."_".$namebody.".".$ext;


			/*  공백과 업로드 않되는 파일명의 Ascii 코드 값을 "_"로 수정하여 업로드 한다!*/
			$AsciiCode = Array("32","34","36","38","39","40","41","42","47","60","62","63","92","96","124");
			For($i=0; $i<strlen($refilename); $i++){
				IF(ord(substr($refilename,$i,1))>127){ $i++;}
				For($j=0; $j<sizeof($AsciiCode); $j++){
					IF(ord(substr($refilename,$i,1))==$AsciiCode[$j]){
						$refilename = str_replace(substr($refilename,$i,1),"_",$refilename);
					}
				}
			}
			$savename = $refilename;

			/* 중복된 파일이름이 있는지 체크 */
			$count = $flag = 1;
			while($flag){
				if(file_exists($UploadConfig['savePath'].$savename)){
					$Head = ereg_replace(".".$ext, "", $refilename);
					$savename = $Head."_".$count.".".$ext;
					$count++;
				}else{
					break;
				}
			}//	while($flag){


			/* 파일 업로드 */
			if(!move_uploaded_file($tmpname, $UploadConfig['savePath'].$savename)){
					$return['msg'] = $filename.' upload error.';
					$return['result'] = "fail";
			}else{
				//$return['msg'] = $filename.' upload success.';
				$return['result'] = true;
				$return['SaveName'] = $savename;
				$return['FileName'] = $filename;
				$return['FileSize'] = $filesize;
				$return['FileType'] = $filetype;
			}	// if(!move_uploaded_file($tmpname, $savePath.$savename)){

		}//if(isset($attach['tmp_name']) && is_uploaded_file($attach['tmp_name'])){



		if($return['result'] == true){
			if($delfile){
				$return['delete'] = true;
				if(file_exists($UploadConfig['savePath'].$delfile)){
					@unlink($UploadConfig['savePath'].$delfile);
				}
			}// if($delfile)


		}else{
			if($return['result'] == "fail") return $return;
			if($delCheck == "Y"){
				if($delfile){
					$return['delete'] = true;
					if(file_exists($UploadConfig['savePath'].$delfile)){
						@unlink($UploadConfig['savePath'].$delfile);
					}
				}// if($delfile)
			}
		}
		return $return;
	}
/* 첨부파일 저장 =========================================================================================================================================*/

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 갯수  */
function AttachCnt($idx){
	global $db, $Board;
	$return = null;
	if($idx){
		$Query = "Select count(*) from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx'";
		$return = $db -> Total($Query);
		if($return == 0) $return = null;
	}
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 존재여부 체크 */
function CheckAttach($idx,$img = ""){
	$fileCnt = AttachCnt($idx);

	if($fileCnt > 0) $fileICON = ($img) ? $img :"<img src='"._CORE_."/images/common/icon_file.gif' align='smiddle' alt='file' />";
	else $fileICON = "";
	return $fileICON;
}

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 정보 */
function FirstAttach($pidx){
	global $db, $Board;
	$return = null;
	if($pidx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$pidx' order by idx asc ";
		$return = $db -> SelectOne($Query);
	}
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 정보 */
function AttachInfo($fileidx){
	global $db, $Board;
	$return = null;
	if($fileidx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and idx='$fileidx'";
		$return = $db -> SelectOne($Query);
	}
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 다운로드 */
function AttachDownload($fileidx){
	global $db, $Board;
	$return = null;
	if($fileidx){
		$file = AttachInfo($fileidx);
		if($file){
			$downinfo = trim(
				_CRIPT_KEY_.$file['idx'].
				_CRIPT_KEY_.$file['SaveName'].
				_CRIPT_KEY_.$file['FileName'].
				_CRIPT_KEY_.$file['SavePath']
			);
			$downinfo = urlencode(encrypt_md5_base64($downinfo));
				$return = fnGetFileicon($file['SaveName'])." <a href='".$Board['Link']."?at=download&down=$downinfo'>".$file['FileName']." <span class='number'>(".printbyte($file['FileSize']).")</span></a>";
		}
	}
	return $return;
}
/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 다운로드 */
function AttachDownload02($fileidx){
	global $db, $Board;
	$return = null;
	if($fileidx){
		$file = AttachInfo($fileidx);
		if($file){
			$downinfo = trim(
				_CRIPT_KEY_.$file['idx'].
				_CRIPT_KEY_.$file['SaveName'].
				_CRIPT_KEY_.$file['FileName'].
				_CRIPT_KEY_.$file['SavePath']
			);
			$downinfo = urlencode(encrypt_md5_base64($downinfo));
				$return = "<a href='".$Board['Link']."?at=download&down=$downinfo' class='__pdf'><img src='/images/ico-pdf.png' alt=''></a>";
		}
	}
	return $return;
}


/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 목록 */
function AttachList($idx){
	global $db, $Board;
	$return = null;
	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by FileGubun asc";
		$file = $db -> SelectList($Query);
		if($file){
			foreach($file as $fileKey => $fileValue){
				if($return){
					$return .= "<br>";
				}
				$return .= "".AttachDownload($fileValue['idx']);
			}
		}
	}
	return $return;
}
/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 목록 */
function AttachList02($idx){
	global $db, $Board;
	$return = null;
	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by FileGubun asc";
		$file = $db -> SelectList($Query);
		if($file){
			foreach($file as $fileKey => $fileValue){
				if($return){
					$return .= "<br>";
				}
				$return .= "".AttachDownload02($fileValue['idx']);
			}
		}
	}
	return $return;
}


/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 목록 */
function AttachArray($idx){
	global $db, $Board;
	$return = null;
	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by idx desc, FileGubun asc";
		$file = $db -> SelectList($Query);
		if($file){
      $return = $file;
		}
	}
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 수정 */
function AttachModify($idx){
	global $db, $Board;
	$return = null;
	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by idx desc, FileGubun asc";
		$file = $db -> SelectList($Query);
		if($file){
			foreach($file as $fileKey => $fileValue){
				$return .= "".AttachDownload($fileValue['idx'])." <input type='checkbox' name='files_del[]' value='".$fileValue['idx']."' style='margin:0; vertical-align:middle'> 삭제<br>";
			}
		}
	}
	return $return;
}

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 삭제 */
function AttachDel($idx){
	global $db, $Board;
	$Query = "SELECT * From ".$Board['table_attach']." WHERE BoardID = '".$Board['board_id']."' and Pidx = '".$idx."'";
	$CHECK = $db->SelectList($Query);
	if($CHECK){
		foreach($CHECK as $Key => $Value){
			if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/s_".$Value['SaveName']))			@unlink(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/s_".$Value['SaveName']);
			if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/m_".$Value['SaveName']))			@unlink(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/m_".$Value['SaveName']);
			if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/b_".$Value['SaveName']))			@unlink(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/b_".$Value['SaveName']);
			if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/".$Value['SaveName'])) @unlink(_UPLOAD_PATH_.$Value['SavePath']."/".$Value['SaveName']);
			$db->ExecQuery("DELETE From ".$Board['table_attach']." WHERE BoardID = '".$Board['board_id']."' and Pidx = '".$idx."' and idx = '".$Value['idx']."' ");
		}
	}
}


/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 삭제 */
function AttachSelectDel($Pidx, $AttachIdx){
	global $db, $Board;
	$DelCount = count($AttachIdx);
	for($i=0; $i< $DelCount; $i++){
		$Query = "SELECT * From ".$Board['table_attach']." WHERE BoardID = '".$Board['board_id']."' and Pidx = '".$Pidx."' and idx = '".$AttachIdx[$i]."'";
		$CHECK = $db->SelectList($Query);
		if($CHECK){
			foreach($CHECK as $Key => $Value){
				if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/s_".$Value['SaveName']))			@unlink(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/s_".$Value['SaveName']);
				if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/m_".$Value['SaveName']))			@unlink(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/m_".$Value['SaveName']);
				if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/b_".$Value['SaveName']))			@unlink(_UPLOAD_PATH_.$Value['SavePath']."/thumbnail/b_".$Value['SaveName']);
				if(file_exists(_UPLOAD_PATH_.$Value['SavePath']."/".$Value['SaveName'])) @unlink(_UPLOAD_PATH_.$Value['SavePath']."/".$Value['SaveName']);
				$db->ExecQuery("DELETE From ".$Board['table_attach']." WHERE BoardID = '".$Board['board_id']."' and Pidx = '".$Pidx."' and idx = '".$Value['idx']."' ");
			}
		}
	}

}

/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 썸네일 */
function AttachThumbNail($idx, $w = "", $h = "", $height = "", $one = ""){
	global $db, $Board;
	$return = null;
	if($w == "")$w = "100";
	if($h == "")$h = "0";
	if($height == "")$height = "";
	else $height = "height='$height'";
	switch($w){
		case $Board['thumb_s_size']: $file_header = "s_";break;
		case $Board['thumb_m_size']: $file_header = "m_";break;
		case $Board['thumb_b_size']: $file_header = "b_";break;
	}



	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by FileGubun asc";
		$file = $db -> SelectList($Query);
		if($file){

			foreach($file as $fileKey => $fileValue){
				$ImgWidth = $ImgHeight = $ImgType = $ImgAttr = null;
				$filePath = _UPLOAD_PATH_.$fileValue['SavePath']."/";
				if(eregi("image",$fileValue['FileType'])){
					if(file_exists($filePath.$fileValue['SaveName'])){
						$thumbNailImageName = $file_header.$fileValue['SaveName'];
						if(eregi("image",$fileValue['FileType'])){
							$thumbPath = $filePath."thumbnail/";
							if(!file_exists($thumbPath.$thumbNailImageName )){

								thumbnail($filePath.$fileValue['SaveName'], $thumbNailImageName, $thumbPath, $w, $h);
							}else{
								list($ImgWidth, $ImgHeight, $ImgType, $ImgAttr) = getimagesize($thumbPath.$thumbNailImageName);
								if($ImgWidth != $w) thumbnail($filePath.$fileValue['SaveName'], $thumbNailImageName, $thumbPath, $w, $h);
							}

							if($return){$return .= "<br>";}
							$thumbNail = str_replace($_SERVER['DOCUMENT_ROOT'],"",$thumbPath).$thumbNailImageName;

							if(file_exists($thumbPath.$thumbNailImageName)){
								list($ImgWidth, $ImgHeight, $ImgType, $ImgAttr) = getimagesize($thumbPath.$thumbNailImageName);
								if($w > $ImgWidth) $printW = $ImgWidth ;
								else $printW = $w;
								if($thumbNail){
								$return .= "<img src='".$thumbNail."' width='".$printW."' $height style='cursor:pointer' alt='image' />";
								}
							}
						}
					}





				}
			}
		}
	}
	if($return){$return .= "<br>";}
	return $return;
}


/*-------------------------------------------------------------------------------------------------
▶ 첨부파일 썸네일 */
function AttachThumbNailOne($idx, $w = "", $h = "", $height = ""){
	global $db, $Board;
	if($w == "")$w = "100";
	if($h == "")$h = "0";
	if($height == "")$height = "";
	else $height = "height='$height'";
	$return = null;
	$thumbNailPath = $cfg['file']['savePath']."thumbnail/";

	switch($w){
		case $Board['thumb_s_size']: $file_header = "s_";break;
		case $Board['thumb_m_size']: $file_header = "m_";break;
		case $Board['thumb_b_size']: $file_header = "b_";break;
	}

	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by FileGubun asc limit 0, 1";
		$file = $db -> SelectList($Query);
		if($file){
			foreach($file as $fileKey => $fileValue){
				$filePath = _UPLOAD_PATH_.$fileValue['SavePath']."/";
				if(eregi("image",$fileValue['FileType'])){
					if(file_exists($filePath.$fileValue['SaveName'])){
						$thumbNailImageName = $file_header.$fileValue['SaveName'];
						$ImgWidth = $ImgHeight = $ImgType = $ImgAttr = null;
						$thumbPath = $filePath."thumbnail/";
						if(!file_exists($thumbPath.$thumbNailImageName )){
							thumbnail($filePath.$fileValue['SaveName'], $thumbNailImageName, $thumbPath, $w, $h);
						}else{
							list($ImgWidth, $ImgHeight, $ImgType, $ImgAttr) = getimagesize($thumbPath.$thumbNailImageName);
							if($ImgWidth != $w || $ImgHeight != $h) thumbnail($filePath.$fileValue['SaveName'], $thumbNailImageName, $thumbPath, $w, $h);
						}

						$thumbNail = str_replace($_SERVER['DOCUMENT_ROOT'],"",$thumbPath).$thumbNailImageName;

						if(file_exists($thumbPath.$thumbNailImageName)){
							$return .= "<img src='".$thumbNail."' width='".$w."' style='cursor:pointer' $height alt='image' class='oneimage'/>";
						}
					}
				}
			}
		}
	}
	$return = ($return)? $return : 	"<img src='"._CORE_."/images/common/no_image.gif'  style='cursor:pointer' alt='no image' />";
	return $return;
}


/*-------------------------------------------------------------------------------------------------
▶ 파일다운로드 */
function download(){
	global $Board;
	$req['down'] = $_GET['down'];
	$downinfo = $req['down'];
	$downinfo = decrypt_md5_base64($downinfo);
	$down = explode(_CRIPT_KEY_,urldecode($downinfo));

	$idx = $down[1];
	$savename = $down[2];
	$realname = 	(mb_check_encoding($down[3],"UTF-8"))? iconv("UTF-8","euc-kr",$down[3]): $down[3];
	$filepath = $down[4];

	$db = new MySQL();
	$db -> ExecQuery("Update ".$Board['table_attach']." Set Down = Down + 1 Where idx = '".$idx."'");

	// 접근경로 확인
	if(!isset($_SERVER['HTTP_REFERER'])) alert("직접 다운로드 받으실수 없습니다.");
	if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) alert("외부에서는 다운로드 받으실수 없습니다.");
	/*------------------------------------------------------
	$file => 실제 파일 경로
	$filename => 다운로드시 붙여질 파일명
	------------------------------------------------------*/
	$file = _UPLOAD_PATH_.$filepath."/".$savename; //실제 파일명 또는 경로

	//$filename =  iconv(mb_detect_encoding($realname),"EUC-KR",$realname);
	$filename = $realname;
//echo $_SERVER['HTTP_USER_AGENT'];
//exit;
	if(file_exists($file)){
		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $_SERVER['HTTP_USER_AGENT']))
		{
			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5"))
			{
			header("Content-Type: doesn/matter");
			header("Content-disposition: filename=$filename");
			header("Content-Transfer-Encoding: binary");
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.0"))
			{
			Header("Content-type: file/unknown");
			header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Description: PHP4 Generated Data");
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.1"))
			{
			Header("Content-type: file/unknown");
			header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Description: PHP4 Generated Data");
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");
			}

			if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0"))
			{
			Header("Content-type: application/x-msdownload");
			Header("Content-Length: ".(string)(filesize("$file")));
			Header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Transfer-Encoding: binary");
			Header("Cache-Control: cache, must-revalidate");
			Header("Pragma: no-cache");
			Header("Expires: 0");
			}
		} else {
/*
			Header("Content-type: file/unknown");
			Header("Content-Length: ".(string)(filesize("$file")));
			Header("Content-Disposition: attachment; filename=$filename");
			Header("Content-Description: PHP4 Generated Data");
			Header("Cache-Control: cache, must-revalidate");
			Header("Pragma: no-cache");
			Header("Expires: 0");
*/

			header('Content-Type: application/x-octetstream');
			header('Content-Length: '.filesize($file));
			header('Content-Disposition: attachment; filename='.$filename);
			header('Content-Transfer-Encoding: binary');
		}

		ob_clean();
		flush();

		if (is_file("$file")) {
			$fp = fopen("$file", "rb");
			if (!fpassthru($fp))
				fclose($fp);
		} else {
			echo "해당 파일이나 경로가 존재하지 않습니다.";
			exit;
		}
	} else {
		echo "해당 파일이나 경로가 존재하지 않습니다.";
		exit;
	}
}




/*-------------------------------------------------------------------------------------------------
▶ 코멘트 삭제 */
function CommentDel($idx){
	global $db, $Board;
  if($Board['comment_table'] && $Board['use_comment'] == "Y" && !empty($idx) && ctype_digit($idx) ){
  	$db->ExecQuery("DELETE From ".$Board['comment_table']." WHERE BoardID = '".$Board['board_id']."' and Pidx = '".$idx."'  ");
  }
}



/**
* @brief iframe, script코드 제거
**/
function removeHackTag($content)
{
    // iframe 제거
    $content = preg_replace("!<iframe(.*?)<\/iframe>!is", '', $content);

    // script code 제거
    $content = preg_replace("!<script(.*?)<\/script>!is", '', $content);

    // meta 태그 제거
    $content = preg_replace("!<meta(.*?)>!is", '', $content);

    // style 태그 제거
    $content = preg_replace("!<style(.*?)<\/style>!is", '', $content);

    // XSS 사용을 위한 이벤트 제거
    $content = preg_replace_callback("!<([a-z]+)(.*?)>!is", removeJSEvent, $content);

    /**
    * 이미지나 동영상등의 태그에서 src에 관리자 세션을 악용하는 코드를 제거
    * - 취약점 제보 : 김상원님
    **/
    $content = preg_replace_callback("!<([a-z]+)(.*?)>!is", removeSrcHack, $content);

    return $content;
}

/**
 * @brief attribute의 value를 " 로 둘러싸도록 처리하는 함수
 **/
function fixQuotation($matches) {
    $key = $matches[1];
    $val = trim($matches[2]);

$close_tag = false;
if(substr($val,-1)=='/') {
  $close_tag = true;
  $val = rtrim(substr($val,0,-1));
}

if($val{0}=="'" && substr($val,-1)=="'")
{
  $val = sprintf('"%s"', substr($val,1,-1));
}

if($close_tag) $val .= ' /';

// attribute on* remove
if(preg_match('/^on([a-z]+)/i',preg_replace('/[^a-zA-Z_]/','',$key))) return '';

$output = sprintf('%s=%s', $key, $val);

return $output;
}

// hexa값을 RGB로 변환
if(!function_exists('hexrgb')) {
    function hexrgb($hexstr) {
      $int = hexdec($hexstr);

      return array('red' => 0xFF & ($int >> 0x10),
                   'green' => 0xFF & ($int >> 0x8),
                   'blue' => 0xFF & $int);
    }

}


function removeJSEvent($matches)
{
    $tag = strtolower($matches[1]);
    if(preg_match('/(src|href)=("|\'?)javascript:/i',$matches[2])) $matches[0] = preg_replace('/(src|href)=("|\'?)javascript:/i','$1=$2_javascript:', $matches[0]);
    return preg_replace('/ on([a-z]+)=/i',' _on$1=',$matches[0]);
}

function removeSrcHack($matches)
{
	include_once "xml/XmlParser.class.php";
    $tag = strtolower(trim($matches[1]));

    $buff = trim(preg_replace('/(\/>|>)/','/>',$matches[0]));
    $buff = preg_replace_callback('/([^=^"^ ]*)=([^ ^>]*)/i', fixQuotation, $buff);

    $oXmlParser = new XmlParser();
    $xml_doc = $oXmlParser->parse($buff);

    // src값에 module=admin이라는 값이 입력되어 있으면 이 값을 무효화 시킴
    $src = $xml_doc->{$tag}->attrs->src;
    $dynsrc = $xml_doc->{$tag}->attrs->dynsrc;
    if(_isHackedSrc($src) || _isHackedSrc($dynsrc) ) return sprintf("<%s>",$tag);

    return $matches[0];
}

function _isHackedSrc($src) {
    if(!$src) return false;
    if($src && preg_match('/javascript:/i',$src)) return true;
    if($src)
    {
        $url_info = parse_url($src);
        $query = $url_info['query'];
        $queries = explode('&', $query);
        $cnt = count($queries);
        for($i=0;$i<$cnt;$i++)
        {
            $pos = strpos($queries[$i],'=');
            if($pos === false) continue;
            $key = strtolower(trim(substr($queries[$i], 0, $pos)));
            $val = strtolower(trim(substr($queries[$i] ,$pos+1)));
            if(($key == 'module' && $val == 'admin') || $key == 'act' && preg_match('/admin/i',$val)) return true;
        }
    }
    return false;
}

/*
=================================================================================================================================
=
= 정리된 함수 End
=
=================================================================================================================================
*/


function cleanUTF8($str, $force_php = false) {

    // UTF-8 validity is checked since PHP 4.3.5
    // This is an optimization: if the string is already valid UTF-8, no
    // need to do PHP stuff. 99% of the time, this will be the case.
    // The regexp matches the XML char production, as well as well as excluding
    // non-SGML codepoints U+007F to U+009F
    if (preg_match('/^[\x{9}\x{A}\x{D}\x{20}-\x{7E}\x{A0}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]*$/Du', $str)) {
        return $str;
    }

    $mState = 0; // cached expected number of octets after the current octet
                 // until the beginning of the next UTF8 character sequence
    $mUcs4  = 0; // cached Unicode character
    $mBytes = 1; // cached expected number of octets in the current sequence

    // original code involved an $out that was an array of Unicode
    // codepoints.  Instead of having to convert back into UTF-8, we've
    // decided to directly append valid UTF-8 characters onto a string
    // $out once they're done.  $char accumulates raw bytes, while $mUcs4
    // turns into the Unicode code point, so there's some redundancy.

    $out = '';
    $char = '';

    $len = strlen($str);
    for($i = 0; $i < $len; $i++) {
        $in = ord($str{$i});
        $char .= $str[$i]; // append byte to char
        if (0 == $mState) {
            // When mState is zero we expect either a US-ASCII character
            // or a multi-octet sequence.
            if (0 == (0x80 & ($in))) {
                // US-ASCII, pass straight through.
                if (($in <= 31 || $in == 127) &&
                    !($in == 9 || $in == 13 || $in == 10) // save \r\t\n
                ) {
                    // control characters, remove
                } else {
                    $out .= $char;
                }
                // reset
                $char = '';
                $mBytes = 1;
            } elseif (0xC0 == (0xE0 & ($in))) {
                // First octet of 2 octet sequence
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x1F) << 6;
                $mState = 1;
                $mBytes = 2;
            } elseif (0xE0 == (0xF0 & ($in))) {
                // First octet of 3 octet sequence
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x0F) << 12;
                $mState = 2;
                $mBytes = 3;
            } elseif (0xF0 == (0xF8 & ($in))) {
                // First octet of 4 octet sequence
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x07) << 18;
                $mState = 3;
                $mBytes = 4;
            } elseif (0xF8 == (0xFC & ($in))) {
                // First octet of 5 octet sequence.
                //
                // This is illegal because the encoded codepoint must be
                // either:
                // (a) not the shortest form or
                // (b) outside the Unicode range of 0-0x10FFFF.
                // Rather than trying to resynchronize, we will carry on
                // until the end of the sequence and let the later error
                // handling code catch it.
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 0x03) << 24;
                $mState = 4;
                $mBytes = 5;
            } elseif (0xFC == (0xFE & ($in))) {
                // First octet of 6 octet sequence, see comments for 5
                // octet sequence.
                $mUcs4 = ($in);
                $mUcs4 = ($mUcs4 & 1) << 30;
                $mState = 5;
                $mBytes = 6;
            } else {
                // Current octet is neither in the US-ASCII range nor a
                // legal first octet of a multi-octet sequence.
                $mState = 0;
                $mUcs4  = 0;
                $mBytes = 1;
                $char = '';
            }
        } else {
            // When mState is non-zero, we expect a continuation of the
            // multi-octet sequence
            if (0x80 == (0xC0 & ($in))) {
                // Legal continuation.
                $shift = ($mState - 1) * 6;
                $tmp = $in;
                $tmp = ($tmp & 0x0000003F) << $shift;
                $mUcs4 |= $tmp;

                if (0 == --$mState) {
                    // End of the multi-octet sequence. mUcs4 now contains
                    // the final Unicode codepoint to be output

                    // Check for illegal sequences and codepoints.

                    // From Unicode 3.1, non-shortest form is illegal
                    if (((2 == $mBytes) && ($mUcs4 < 0x0080)) ||
                        ((3 == $mBytes) && ($mUcs4 < 0x0800)) ||
                        ((4 == $mBytes) && ($mUcs4 < 0x10000)) ||
                        (4 < $mBytes) ||
                        // From Unicode 3.2, surrogate characters = illegal
                        (($mUcs4 & 0xFFFFF800) == 0xD800) ||
                        // Codepoints outside the Unicode range are illegal
                        ($mUcs4 > 0x10FFFF)
                    ) {

                    } elseif (0xFEFF != $mUcs4 && // omit BOM
                        // check for valid Char unicode codepoints
                        (
                            0x9 == $mUcs4 ||
                            0xA == $mUcs4 ||
                            0xD == $mUcs4 ||
                            (0x20 <= $mUcs4 && 0x7E >= $mUcs4) ||
                            // 7F-9F is not strictly prohibited by XML,
                            // but it is non-SGML, and thus we don't allow it
                            (0xA0 <= $mUcs4 && 0xD7FF >= $mUcs4) ||
                            (0x10000 <= $mUcs4 && 0x10FFFF >= $mUcs4)
                        )
                    ) {
                        $out .= $char;
                    }
                    // initialize UTF8 cache (reset)
                    $mState = 0;
                    $mUcs4  = 0;
                    $mBytes = 1;
                    $char = '';
                }
            } else {
                // ((0xC0 & (*in) != 0x80) && (mState != 0))
                // Incomplete multi-octet sequence.
                // used to result in complete fail, but we'll reset
                $mState = 0;
                $mUcs4  = 0;
                $mBytes = 1;
                $char ='';
            }
        }
    }
    return $out;
}

function escapeHTML($string) {
    $string = cleanUTF8($string);
    $string = htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
    return $string;
}

// 랜덤값 생성 
function random_string($length) { 
	$randomcode = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'A', 'B', 'C', 'd', 'E', 'F', 'G', 'H', 'x', 'J', 'K', 'b', 'M', 'N', 'y', 'P', 'r', 'R', 'S', 'T', 'u', 'V', 'W', 'X', 'Y', 'Z'); 
	mt_srand((double)microtime()*1000000); 
  for($i=1;$i<=$length;$i++) $Rstring .= $randomcode[mt_rand(1, count($randomcode))]; 
  return $Rstring; 
} 

function EmailSend($toEmail, $title, $Content){
	global $site;
	$return = false;
	$req['fromEmail'] = $site['postmaster_email'];
	$req['fromName']  = $site['postmaster_name'];
	$req['toEmail']	  = $toEmail;
	$req['title']	    = $title;
	$req['Content']	  = $Content;

	$to       = $req['toEmail'];
	$from     = $req['fromEmail'];
	$fromName = $req['fromName'];

  if(!$req['fromEmail'] || !$req['toEmail']){
    $json['error'] = "Y";
    $json['msg']   = "필수정보 누락";
  }else{
    /*-------------------------------------------------------------------------------------------------
    ▶ 이메일 전송 */
    $Subject = $req['title'];
    $MailBody    = $req['Content'];
    $AltBody = $Subject ;

    /*
    $Subject = iconv("utf-8","gb2312",$Subject);
    $AltBody = iconv("utf-8","gb2312",$AltBody);
    $body      = file_get_contents('../../mail/pw.html');
    $body      = str_replace("[NAME]",$CHECK['h_fname']." ".$CHECK['h_lname'],$body);
    $body      = str_replace("[PASSWORD]",  $req['passwd'],  $body);
    //$body      = iconv("utf-8","gb2312",$body);
    */
    $MailBody      = eregi_replace("[\]",'',$MailBody);
    include _CORE_PATH_."/plugin/PHPMailer_5.2.4/class.phpmailer.php";
    $mail = new PHPMailer();
    $mail-> CharSet   = "utf-8";
    $mail-> Encoding = "base64";
    $body = eregi_replace("[\]",'',$body);

    $mail->IsSendmail();  // tell the class to use Sendmail
    //$mail->AddReplyTo($from, $fromName);
    $mail->FromName   = $fromName;
    $mail->From       = $from;
    $mail->AddAddress($to);

    $mail->Subject    = $Subject ;
    $mail->AltBody    = $AltBody; // optional, comment out and test
    $mail->MsgHTML($MailBody);
    //$Attach = AttachLink($Pidx);
    //if($Attach){
    //	for($i=0; $i < count($Attach); $i++)  $mail->AddAttachment($Attach[$i]);      // attachment
    //}
    if($mail->Send()){
			$return = true;
		}
  }
	return $return;
}



function masking($_type, $_data){
	$_data = str_replace('-','',$_data);
	$strlen = mb_strlen($_data, 'utf-8');
	$maskingValue = "";
	 
	$useHyphen = "-";

	if($_type == 'N'){
		switch($strlen){
			case 2:
				$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'*';
				break;
			case 3:
				$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'*'.mb_strcut($_data, 8, 11, "UTF-8");
				break;
			case 4:
				$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'**'.mb_strcut($_data, 12, 15, "UTF-8");
				break;
			default:
				$maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'**'.mb_strcut($_data, 12, 15, "UTF-8");
				break;
		}
	}else if($_type == 'P'){
		switch($strlen){
			case 10:
				$maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}***{$useHyphen}".mb_substr($_data, 6, 4);
				break;
			case 11:
				$maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}****{$useHyphen}".mb_substr($_data, 7, 4);
				break;
			default:
				trigger_error('Not a known format parametter in function', E_USER_NOTICE);
				break;
		}
	}else{
		trigger_error('Masking Function Parameter Error', E_USER_NOTICE);
	}
	return $maskingValue;
}

?>