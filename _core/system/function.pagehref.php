<?
if(!defined("_gurudol_included")) exit;
###################################################################################################
/*

�� alert()           : �޼��� ����
�� windowOpen()      : ��â����
�� selfClose()       : ������ �ݱ�
�� historyBack()     : ���� ��������
�� historyReferrer() : ������������

�� locationReplace()    : ���� �������� �ٲ�
�� locationHref()       : ������ �̵�
�� toplocationHref()    : �ֻ��� �����ӿ��� ������ �̵�
�� openerlocationHref() : �θ�â���� ������ �̵�
�� formSubmit()         : ������
�� metaRefresh()        : META �ױ׸� �̿��� Refresh

*/
###################################################################################################


# �� alert �޼��� ����
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

# �� �޽��� ���� ������ ����
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

# �� �޽��� ���� �ڷ� �̵�
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

# �� �޽��� ���� �ڷ� �̵�
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

# �� �޽��� ���� �ش������� ȣ��
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

# �� �޽��� ���� �ش������� �̵�
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

# �� �޽��� ���� �ش������� �̵�
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
 
// �޽��� ���� �ش������� �̵�
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

// �޽��� ���� �� �ʵ忡 �ش� ���� ��� �ش������� �̵�
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

// ��Ÿ �̵�
function metaRefresh($url, $sec=0){
		echo "<meta http-equiv=Refresh content='$sec;URL=$url'>";
		exit;
}


?>