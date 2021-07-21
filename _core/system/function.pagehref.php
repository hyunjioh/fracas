<?
if(!defined("_gurudol_included")) exit;
###################################################################################################
/*

● alert()           : 메세지 띄우기
● windowOpen()      : 새창열기
● selfClose()       : 윈도우 닫기
● historyBack()     : 이전 페이지로
● historyReferrer() : 이전페이지로

● locationReplace()    : 현제 페이지를 바꿈
● locationHref()       : 페이지 이동
● toplocationHref()    : 최상위 프레임에서 페이지 이동
● openerlocationHref() : 부모창에서 페이지 이동
● formSubmit()         : 폼전송
● metaRefresh()        : META 테그를 이용한 Refresh

*/
###################################################################################################


# ● alert 메세지 띄우기
function alert($msg){
	if( $msg != Null)	{
		echo "<script type='text/javascript'>".ENTER;
		echo "<!--".ENTER;
		echo "window.alert('$msg');".ENTER;
		echo "//-->".ENTER;
		echo "</script>".ENTER;
	}
}

function windowOpen($page){
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "windows.open($page);".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
}

# ● 메시지 띄우고 페이지 닫음
function selfClose($msg = Null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "self.close();".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

# ● 메시지 띄우고 뒤로 이동
function historyBack($msg){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "history.go(-1);".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

# ● 메시지 띄우고 뒤로 이동
function historyReferrer($msg){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "location.href=document.referrer;".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

# ● 메시지 띄우고 해당페이지 호출
function locationReplace($url, $msg = Null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "document.location.replace('$url');".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

# ● 메시지 띄우고 해당페이지 이동
function locationHref($url, $msg = Null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "location.href = '$url';".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}

# ● 메시지 띄우고 해당페이지 이동
function toplocationHref($url, $msg = Null){
	$alert = ($msg) ? "alert('$msg');" : "";
	echo "<script type='text/javascript'>".ENTER;
	echo "<!--".ENTER;
	echo $alert.ENTER;
	echo "parent.location.href = '$url';".ENTER;
	echo "//-->".ENTER;
	echo "</script>;".ENTER;
	exit;
}
 
// 메시지 띄우고 해당페이지 이동
function openerlocationHref($url, $msg = Null){
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

// 메시지 띄우고 각 필드에 해당 값을 담아 해당페이지 이동
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

// 메타 이동
function metaRefresh($url, $sec=0){
		echo "<meta http-equiv=Refresh content='$sec;URL=$url'>";
		exit;
}


?>