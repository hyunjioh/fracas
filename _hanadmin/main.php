<?
	define("_g_board_include_",true);
	include "../_core/_lib.php";
	require_once _CORE_PATH_."/system/class.MySQL.php";
	require_once _CORE_PATH_."/system/function.board.php";
	require_once _CORE_PATH_."/lang/ko.php";

	/*-------------------------------------------------------------------------------------------------
	▶ 데이터베이스 연결 */	
	unset($db);
	$db = new MySQL;
	
	$Total_Visit = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic`");
	$Year_Visit  = $db->Total("SELECT  count(*) as cnt  FROM `G__Log_Basic` WHERE time LIKE '".date("Y")."%'");
	$Month_visit = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic` WHERE time LIKE '".date("Y-m")."%'");
	$Today_visit = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic` WHERE time LIKE '".date("Y-m-d")."%'");


	$Total_Member = $db->Total("SELECT count(*) as cnt FROM `G_Member` Where h_level <  100 ");
	$Today_Member = $db->Total("SELECT count(*) as cnt FROM `G_Member` Where h_level <  100 and h_wdate between ".mktime(0,0,0,date("m"),date("d"),date("Y"))." and ".mktime(12,59,59,date("m"),date("d"),date("Y")) );


	// 트래픽
	$throttle_url = "";
	if($throttle_url){
		ini_set("allow_url_fopen","1"); // 서버 설정에 따라 file() 함수의 사용이 가능하도록... [라인추가] 
		$file = file($throttle_url); // 소스를 읽고,
		$traffic = sprintf("%0.2fMB",strip_tags($file[43]) / 1024); // 44번 라인을 읽어서 태그를 없애고 MB단위로...배열은 0부터 44-1 = 43
		$limit = sprintf("%0.1fMB",strip_tags(eregi_replace("M", "",$file[47]))); // 48번 라인을 읽어서 태그를 없애고 GB단위로...
	}
?>
<? include "./include/_header.inc.php"; ?>
<script type="text/javascript">
function delcheck(val){
	var f = document.sform;
	if(confirm("정말로 삭제하시겠습니까?")){
		f.action = "product/?at=dataprocess";
		f.method = "post";
		f.idx.value = val;
		f.am.value = 'deleteData';
		f.submit();	
	}
}

function displaycheck(val){
	var f = document.sform;
	if(confirm("정말로 수정하시겠습니까?")){
		f.action = "product/?at=dataprocess";
		f.method = "post";
		f.idx.value = val;
		f.am.value = 'displayData';
		f.submit();	
	}
}
</script>
<style type="text/css">
	.leftcurtain{
		width: 50%;
		height: 100%;
		top: 0px;
		left: 0px;
		position: absolute;
		z-index: 2;
	}
	 .rightcurtain{
		width: 51%;
		height:  100%;
		right: 0px;
		top: 0px;
		position: absolute;
		z-index: 3;
	}
	.rightcurtain img, .leftcurtain img{
		width: 100%;
		height: 100%;
	}
	.popup{
		position: absolute;
		top: -40px;
		left: 90%;
		z-index: 4;
	}
	 
</style>
<link rel="stylesheet" type="text/css" href="css/custompopup.css"/>
<script type="text/javascript" src="js/custompopup.js"></script>
</head>




<div id="fade"></div>
<form name="sform" method="post">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="am" value="">
<input type="hidden" name="idx" value="">
</form>
<div id="wrapper">	
<? @include "./include/top_menu.php"; ?>
<? @include "./include/left_menu.php"; ?>
<div id="body-content-main">
<div class="main-layer">
<h3 class="page-title"><span>접속현황</span></h3>
<table width="100%" cellspacing="0" cellpadding="0" class="listtable" border="0">
	<tr>
		<td class="tableth" width="100" style="border-bottom:1px solid #cccccc; border-right:1px solid #cccccc">총접속</td>
		<td class="tabletd number" style="border-bottom:1px dashed #cccccc; border-left:1px dashed #cccccc; background-color:#f5f5f5; padding-left:5px"> <?=number_format($Total_Visit)?></td>
	</tr>
	<tr>
		<td class="tableth" style="border-bottom:1px solid #cccccc; border-right:1px solid #cccccc">금년접속</td>
		<td class="tabletd number" style="border-bottom:1px dashed #cccccc; border-left:1px dashed #cccccc; background-color:#f5f5f5; padding-left:5px"> <?=number_format($Year_Visit)?></td>
	</tr>
	<tr>
		<td class="tableth" style="border-bottom:1px solid #cccccc; border-right:1px solid #cccccc">금월접속</td>
		<td class="tabletd number" style="border-bottom:1px dashed #cccccc; border-left:1px dashed #cccccc; background-color:#f5f5f5; padding-left:5px"> <?=number_format($Month_visit)?></td>
	</tr>
	<tr>
		<td class="tableth" style="border-bottom:1px solid #cccccc; border-right:1px solid #cccccc">오늘접속</td>
		<td class="tabletd number" style="border-bottom:1px solid #cccccc; border-left:1px dashed #cccccc; background-color:#f5f5f5; font-weight:bold; padding-left:5px"> <?=number_format($Today_visit)?></td>
	</tr>
</table>
</div>

<div class="main-layer">
<h3 class="page-title"><span>회원현황</span></h3>
<table width="100%" cellspacing="0" cellpadding="0" class="listtable" border="0">
	<tr>
		<td class="tableth" width="100" style="border-bottom:1px solid #cccccc; border-right:1px solid #cccccc">전체회원</td>
		<td class="tabletd number" style="border-bottom:1px dashed #cccccc; border-left:1px dashed #cccccc; background-color:#f5f5f5; padding-left:5px"><?=number_format($Total_Member)?> 명</td>
	</tr>
	<tr>
		<td class="tableth" style="border-bottom:1px solid #cccccc; border-right:1px solid #cccccc">오늘가입</td>
		<td class="tabletd number" style="border-bottom:1px dashed #cccccc; border-left:1px dashed #cccccc; background-color:#f5f5f5; font-weight:bold; padding-left:5px"><?=number_format($Today_Member)?> 명</td>
	</tr>
</table>
</div>





</div>
<div id="copyright"></div>












</div>





<? include "./include/_footer.inc.php"; ?>