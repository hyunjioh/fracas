<?
if(!defined("_gurudol_included")) exit;
###################################################################################################
/*
● Request()       : 전송된 변수 체크
● Input()         : 입력할 변수 체크
● SetValue()      : 변수 기본값 설정

● RemoveXSS()         : XSS (cross site scripting) filter function 
● mysql_escape_str()  : mysql_real_escape_string 사용, 입력 데이터 체크

● new_token()         : 폼 작성시 토큰 생성
● check_token()       : 토큰 체크

*/
###################################################################################################


# ● 전송된 변수 체크
function Request($str){
	return CheckValue("check", $str);
}

function RequestValueCheck($buff){
	if(!is_array($buff)) return RemoveXSS($buff); 
	return array_map('RemoveXSS',$buff); 
}

# ● 입력할 변수 체크
function Input($str){
	return CheckValue("input", $str);
}
function InputValueCheck($buff){
	if(!is_array($buff)) return mysql_escape_str($buff); 
	return array_map('mysql_escape_str',$buff); 
}

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

# ● XSS (cross site scripting) filter function 
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

      // &#00064 @ 0{0,7} matches '0' zero to seven times 
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
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag 
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags 
         if ($val_before == $val) { 
            // no replacements were made, so exit the loop 
            $found = false; 
         } 
      } 
   } 
   return $val; 
} 


// SQL 인젝션 공격대응
// mysql_real_escape_string 함수를 사용, 
// ON일 경우 magic_quotes_gpc/magic_quotes_sybase 효과 제거
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
	return $string;
}

# ● 변수 기본값 설정
function SetValue($val, $type = null, $default = null){
	if(!$val || $val == "")  $val = $default;
	if($type && $type != "") $val = TypeCheck($type, trim($val));
	return $val;
}

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



# ● 작성폼의 토큰 생성
function new_token($form) {

	// generate a token from an unique value, took from microtime, you can also use salt-values, other crypting methods...
	$token = md5(uniqid(microtime(), true));  
	
	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	$_SESSION[$form.'_token'] = $token; 
	
	return $token;
}

# ● 작성폼의 토큰 확인
function check_token($form) {
		
		// check if a session is started and a token is transmitted, if not return an error
	if(!isset($_SESSION[$form.'_token'])) { 
		return false;
		}
	
	// check if the form is sent with token in it
	if(!isset($_POST['token'])) {
		return false;
		}
	
	// compare the tokens against each other if they are still the same
	if ($_SESSION[$form.'_token'] !== $_POST['token']) {
		return false;
		}
	
	return true;
}

# ● 작성폼의 토큰 제거
function destory_token($form) {
	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	unset($_SESSION[$form.'_token']); 
}














/******************************************/
//[암호화] Function #1 (MD5 + Base64)
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

//    $name = '테스트';
//    $enc_name = encrypt_md5_base64($name);
//    $dec_name = decrypt_md5_base64($enc_name);
    
//    echo "name = {$name}<br>\n";
//    echo "encode_name = {$enc_name}<br>\n";
//    echo "decode_name = {$dec_name}<br>\n";
//=========================================/

/******************************************/
//[암호화] Function #2 (MD5 + Hex) 
function encrypt_md5($buf, $key="password"){
	$key1 = pack("H*",md5($key));
	while($buf){
		$m = substr($buf, 0, 16);
		$buf = substr($buf, 16);
            
		$c = "";
		for($i=0;$i<16;$i++){
			$c .= $m{$i}^$key1{$i};
		}
		$ret_buf .= $c;
		$key1 = pack("H*",md5($key.$key1.$m));
	}
        
	$len = strlen($ret_buf);
	for($i=0; $i<$len; $i++)
	$hex_data .= sprintf("%02x", ord(substr($ret_buf, $i, 1)));
	return($hex_data);
}
    
function decrypt_md5($hex_buf, $key="password"){
	$len = strlen($hex_buf);
	for ($i=0; $i<$len; $i+=2)
	$buf .= chr(hexdec(substr($hex_buf, $i, 2)));
        
	$key1 = pack("H*", md5($key));
	while($buf){
		$m = substr($buf, 0, 16);
		$buf = substr($buf, 16);
           
		$c = "";
		for($i=0;$i<16;$i++){
			$c .= $m{$i}^$key1{$i};
		}
           
		$ret_buf .= $m = $c;
		$key1 = pack("H*",md5($key.$key1.$m));
		}
        
	return($ret_buf);
}
//    $name = '테스트';
//    $enc_name = encrypt_md5($name);
//    $dec_name = decrypt_md5($enc_name);
    
//    echo "name = {$name}<br>\n";
//    echo "encode_name = {$enc_name}<br>\n";
//    echo "decode_name = {$dec_name}<br>\n";
//=========================================/

// 암호화
// 키값 : dbf007$
function encrypt_md5_2($buf, $key='dbf007$')
{
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

// 복호화
// 키값 : dbf007$
function decrypt_md5_2($hex_buf, $key='dbf007$')
{
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

?>