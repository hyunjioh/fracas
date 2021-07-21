<?
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
			if($AttachFile['msg']) alert($AttachFile['msg']);
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
			if(file_exists($updir)) @chmod( $updir, 0777);
			else mkdir( $updir , 0777);
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

			/* 용량체크 */
			if($filesize > $UploadConfig['fileMaxSize'])	{
				$return['msg'] = $filename.' size exceeds.';
				$return['result'] = false;
				return $return;
			} // if($filesize > $checkInfo['file_max_size'])

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
			if($_SESSION['_MEMBER_']['LEVEL'] < $Board['level_download']){
				$return = $file['FileName'];		
			}else{
				$return = fnGetFileicon($file['SaveName'])." <a href='".$Board['Link']."?at=download&down=$downinfo'>".$file['FileName']." <span class='number'>(".printbyte($file['FileSize'])." , ".number_format($file['Down'])." Down)</span></a>";		
			}
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
▶ 첨부파일 수정 */
function AttachModify($idx){
	global $db, $Board;
	$return = null;
	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by FileGubun asc";
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
▶ 답변글 아이콘 */
function CheckReply($thread, $img = ""){
	$icon_re = Null;
	$img = ($img)? $img :"<img src='"._CORE_."/images/common/icon_re.gif' align='middle' alt='reply' /> " ;
	if($thread!="A"){
		for($i=1;$i<strlen($thread);$i++)$icon_re = $icon_re."&nbsp;";
	}
	if($icon_re)$icon_re .= $icon_re. $img ;	
	return $icon_re;
}

/*-------------------------------------------------------------------------------------------------
▶ 답변글 아이콘 */
function CheckSecret($secret, $img = ""){
	$return = Null;
	if($secret == "Y"){
		$return = ($img)? $img: " <img src='"._CORE_."/images/common/icon_secret.gif' align='middle' alt='secret' /> " ;	
	}

	return $return;
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
▶ 써네일 생성 */
Function thumbnail($file, $save_filename, $save_path, $max_width, $max_height) {
	$gd_version=gd_info();


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

	if(!$img_info) return;

	// 전송받은 이미지의 포맷값 얻기 (gif, jpg png)
	if($img_info[2] == 1) {
					$src_img = @ImageCreateFromGif($file);
					} else if($img_info[2] == 2) {
									$src_img = @ImageCreateFromJPEG($file);
									} else if($img_info[2] == 3) {
													$src_img = @ImageCreateFromPNG($file);
									} else {
									return 0;
					}

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
▶ 동영상 재생(wmv, flv) */
function Video($idx){
	global $db, $Board;
	$return = null;
	if($idx){
		$Query = "Select * from ".$Board['table_attach']." Where BoardID='".$Board['board_id']."' and Pidx='$idx' order by FileGubun asc";
		$file = $db -> SelectList($Query);
		if($file){
			foreach($file as $fileKey => $fileValue){
				if(eregi("image",$fileValue['FileType'])){ 
					$image = _UPLOAD_.$fileValue['SavePath']."/".$fileValue['SaveName'];
				}
				if(eregi("wmv",$fileValue['FileType'])){ 
					$wmv = _UPLOAD_.$fileValue['SavePath']."/".$fileValue['SaveName'];
				}
				if(eregi("flv",$fileValue['FileType'])){ 
					$flv = _UPLOAD_.$fileValue['SavePath']."/".$fileValue['SaveName'];
				}
			}
		}
	}

	if($wmv){
	$return="
		<div name=\"mediaspace\" id=\"mediaspace\" style='margin:0 auto; text-align:center'></div>
		<script type='text/javascript' src=\""._CORE_."/plugin/wmvplayer/silverlight.js\"></script>
		<script type='text/javascript' src=\""._CORE_."/plugin/wmvplayer/wmvplayer.js\"></script>
		<script type=\"text/javascript\">
			var cnt = document.getElementById(\"mediaspace\");
			var src = '"._CORE_."/plugin/wmvplayer/wmvplayer.xaml';
			var cfg = {
				file:'$wmv',
				image:'$image',
				width:'600',
				height:'400'
			};
			var ply = new jeroenwijering.Player(cnt,src,cfg);
		</script>
		";
	}

	if($flv){
	$return = "
	<script type=\"text/javascript\" src=\""._CORE_."/plugin/mediaplayer/swfobject.js\"></script>
	<script type=\"text/javascript\">
		swfobject.registerObject(\"player\",\"9.0.98\",\""._CORE_."/plugin/mediaplayer/expressInstall.swf\");
	</script>
	<div style='margin:0 auto; text-align:center'>
	<object id=\"player\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" name=\"player\" width=\"600\" height='400' >
		<param name=\"movie\" value=\""._CORE_."/plugin/mediaplayer/player.swf\" />
		<param name=\"allowfullscreen\" value=\"true\" />
		<param name=\"allowscriptaccess\" value=\"always\" />
		<param name=\"flashvars\" value=\"file=$flv&image=$image\" />
		<object type=\"application/x-shockwave-flash\" data=\""._CORE_."/plugin/mediaplayer/player.swf\" width=\"600\" >
			<param name=\"movie\" value=\""._CORE_."/plugin/mediaplayer/player.swf\" />
			<param name=\"allowfullscreen\" value=\"true\" />
			<param name=\"allowscriptaccess\" value=\"always\" />
			<param name=\"flashvars\" value=\"file=$flv&image=$image\" />
			<p><a href=\"http://get.adobe.com/flashplayer\">Get Flash</a> to see this player.</p>
		</object>
	</object>	
	</div>
	";
	}

	$obj = "
		<OBJECT classid='clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95' width='300'>
		<PARAM NAME='Filename' VALUE='음악 파일 경로'>
		<param name='ClickToPlay' value='true'>
		<param name='AutoSize' value='true'>
		<param name='AutoStart' value='true'>
		<param name='ShowControls' value='true'>
		<param name='ShowAudioControls' value='true'>
		<param name='ShowDisplay' value='false'>
		<param name='ShowTracker' value='true'>
		<param name='ShowStatusBar' value='false'>
		<param name='EnableContextMenu' value='false'>
		<param name='ShowPositionControls' value='false'>
		<param name='ShowCaptioning' value='false'>
		<param name='AutoRewind' value='true'>
		<param name='Enabled' value='true'>
		<param name='EnablePositionControls' value='true'>
		<param name='EnableTracker' value='true'>
		<param name='PlayCount' value='1'>
		<param name='SendWarningEvents' value='true'>
		<param name='SendErrorEvents' value='true'>
		<param name='SendKeyboardEvents' value='false'>
		<param name='SendMouseClickEvents' value='false'>
		<param name='SendMouseMoveEvents' value='false'>
		<param name='ShowGotoBar' value='false'>
		<param name='TransparentAtStart' value='false'>
		<param name='Volume' value='0'>
		</OBJECT>
	";

	return $return;
}
?>