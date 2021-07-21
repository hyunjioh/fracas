<?
include_once '../inc/pub.config.php';
include_once PATH.'/inc/common.php';
?>
<?
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */
unset($db);
$db = new MySQL;

/*-------------------------------------------------------------------------------------------------
▶ 게시판 정보 */	

//////////////
// 공지사항
//////////////
$Board['board_id'] = "notice";
$Board['board_name'] = "공지사항";
$Board['table_board'] = "G_Notice";

unset($WHERE);
$WHERE[] = " Status = 'Y' ";
$WHERE[] = " BoardID = '".$Board['board_id']."' ";

// 첫번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 1";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List1   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);

// 2-4번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 0, 3";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);


?>


</head>
<body>
<div id="main">
    <?include_once PATH.'/inc/head.php';?>
    <?include_once PATH.'/inc/side_nav.php';?>
 
	
	<? if(!isset($MemberID) || empty($MemberID)){?>
		<span><a href="<?=DIR?>/member/join.php"><img src="<?=DIR?>/images/head-mypage.png" alt="회원가입" class="__p">회원가입</a></span>
		<span><a href="<?=DIR?>/member/login.php"><img src="<?=DIR?>/images/head-login.png" alt="로그인" class="__p">로그인</a></span>
	<? } else{ ?>	
		<span><a href="<?=DIR?>/member/mypage.php"  style="font-size: 17px;">마이페이지</a></span>
		<span><a href="/_core/act/?at=logout" style="font-size: 17px;">로그아웃</a></span>
	<? } // end if ??>

    <?include_once PATH.'/inc/footer.php';?>
</div> 

<script>
vis.init();
pgm.init();
notice.init();
</script>

<!-- Popup Script -->
<?
// 팝업

	$sql_p = "Select * from G_Popup Where Display = 'Y' and now() between StartDate and EndDate";
	$Popup = mysql_query($sql_p);

	if($Popup){
		while($pvalue = mysql_fetch_array($Popup)){
?>
<script type='text/javascript'>
//<![CDATA[
$(function() {
	if ( getCookie( "popuplayer<?=$pvalue['idx']?>" ) != "done" ) { 
		$("#popuplayer<?=$pvalue['idx']?>").fadeIn();
	}
});
//]]>
</script>
<div style="width:<?=$pvalue['Width']?>px; height:<?=$pvalue['Height']?>px; position:absolute; top:<?=$pvalue['toppos']?>px; left:<?=$pvalue['leftpos']?>px; z-index:9999; background-color:#FFF; border:1px solid #c0c0c0; display:none;" id="popuplayer<?=$pvalue['idx']?>">
<?=$pvalue['Content']?>
<form name="popuplayer<?=$pvalue['idx']?>">
<div style="width:100%; height:30px; text-align:right; height:20px; background-color:#000000; color:white"><span style="color:grey"><label><input type="checkbox" name="popupcheck" value="Y" style="border:none"> 오늘하루열지않음</label> <span style="display:inie-block:width:300px">&nbsp;</span></span> <a href="javascript:popupClose('popuplayer<?=$pvalue['idx']?>');"><span style="color:grey">Close</span></a>&nbsp;&nbsp;</div>
</form>
</div>
<?
		}
	}	
?>
<script type='text/javascript'>
//<![CDATA[
function popupClose(cookiename){ 
	var f = eval("document."+cookiename);
	if(f.popupcheck.checked){
		setCookie( cookiename, "done" , 1); 
	}
	$("#"+cookiename).hide().html("");
} 

/*=================================================================================================
 cookie 
=================================================================================================*/
//쿠키생성 ;;
function setCookie( name, value, expiredays ){
	var today = new Date();
	today.setDate( today.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
}

// 쿠키정보 ;;
function getCookie( name ) { 
	var nameOfCookie = name + "="; 
	var x = 0; 
	while ( x <= document.cookie.length ) { 
		var y = (x+nameOfCookie.length); 
		if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
				endOfCookie = document.cookie.length; 
			return unescape( document.cookie.substring( y, endOfCookie ) ); 
		} 
		x = document.cookie.indexOf( " ", x ) + 1; 
		if ( x == 0 ) 
		break; 
	} 
	return ""; 
}
//]]>
</script>
<!-- //Popup Script -->

</body>
</html>