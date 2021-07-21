<?
	if(!defined("_g_board_include_")) exit; // Inclde Check

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
	if(!isset($_SERVER['HTTP_REFERER'])) alert($msg['direct_link_deny']);
	if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) alert($msg['direct_link_deny']);
	/*------------------------------------------------------
	$file => 실제 파일 경로
	$filename => 다운로드시 붙여질 파일명
	------------------------------------------------------*/
	$file = _UPLOAD_PATH_.$filepath."/".$savename; //실제 파일명 또는 경로 

	//$filename =  iconv(mb_detect_encoding($realname),"EUC-KR",$realname); 
	$filename = $realname;

	if(file_exists($file)){
		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT))
		{ 
			if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) 
			{ 
			header("Content-Type: doesn/matter"); 
			header("Content-disposition: filename=$filename"); 
			header("Content-Transfer-Encoding: binary"); 
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			} 

			if(strstr($HTTP_USER_AGENT, "MSIE 5.0")) 
			{ 
			Header("Content-type: file/unknown"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			Header("Content-Description: PHP4 Generated Data"); 
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			} 

			if(strstr($HTTP_USER_AGENT, "MSIE 5.1")) 
			{ 
			Header("Content-type: file/unknown"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			Header("Content-Description: PHP4 Generated Data"); 
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			} 
			
			if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
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
			echo $msg['file_does_not_exist']; 
			exit;
		} 	
	} else { 
		echo $msg['file_does_not_exist']; 
		exit;
	} 	
?><?
	if(!defined("_g_board_include_")) exit; // Inclde Check

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
	if(!isset($_SERVER['HTTP_REFERER'])) alert($msg['direct_link_deny']);
	if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) alert($msg['direct_link_deny']);
	/*------------------------------------------------------
	$file => 실제 파일 경로
	$filename => 다운로드시 붙여질 파일명
	------------------------------------------------------*/
	$file = _UPLOAD_PATH_.$filepath."/".$savename; //실제 파일명 또는 경로 

	//$filename =  iconv(mb_detect_encoding($realname),"EUC-KR",$realname); 
	$filename = $realname;

	if(file_exists($file)){
		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT))
		{ 
			if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) 
			{ 
			header("Content-Type: doesn/matter"); 
			header("Content-disposition: filename=$filename"); 
			header("Content-Transfer-Encoding: binary"); 
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			} 

			if(strstr($HTTP_USER_AGENT, "MSIE 5.0")) 
			{ 
			Header("Content-type: file/unknown"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			Header("Content-Description: PHP4 Generated Data"); 
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			} 

			if(strstr($HTTP_USER_AGENT, "MSIE 5.1")) 
			{ 
			Header("Content-type: file/unknown"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			Header("Content-Description: PHP4 Generated Data"); 
			Header("Cache-Control: cache, must-revalidate");
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			} 
			
			if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
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
			echo $msg['file_does_not_exist']; 
			exit;
		} 	
	} else { 
		echo $msg['file_does_not_exist']; 
		exit;
	} 	
?>