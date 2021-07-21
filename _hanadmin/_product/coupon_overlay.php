<?
require_once "../../_core/_lib.php";
require_once _CORE_PATH_."/system/function.board.php";
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;
define("_admin_include", true);
$req['idx']			= Request('idx');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> Overlay </title>
	<!-- [e] title -->
	<link rel="stylesheet" type="text/css" href="<?=_ADMIN_?>/css/style.css" />
	<script type="text/javascript">
	$(document).ready(function() {
		$('#load').hide();
	});

	$(function() {
		$(".deletebtn").click(function() {
			$('#load').fadeIn();
			var commentContainer = $(this).parent().parent().parent();
			var id = $(this).attr("id");
			var string = 'idx='+ id + "&am=delete" ;
		
			$.ajax({
				 type: "POST",
				 url: "index.php?at=dataprocess",
				 data: string,
				 cache: false,
				 success: function(msg){
					commentContainer.slideUp('slow', function() {$("#"+id).remove();});
					$('#load').fadeOut();
				}
				 
			});

			return false;
		});
	});
	</script>
<style>
.box {
	padding:3px;
	border-bottom:1px dotted #ccc;
	width:368px;
	height:30px;
	padding-left:20px
}
.box:hover{background-color:#ccc;}

#load {
	position:absolute;
	left:125px;
	background-image:url(images/loading-bg.png);
	background-position:center;
	background-repeat:no-repeat;
	width:159px;
	color:#999;
	font-size:18px;
	font-family:Arial, Helvetica, sans-serif;
	height:40px;
	font-weight:300;
	padding-top:14px;
	top: 123px;
}
#container {
	position:relative;
}
a.deletebtn {
	padding:3px;
	text-align:center;
	font-size:18px;
	font-weight:700;
	text-decoration:none;
	color:#C00;
}
a.deletebtn:hover {
	background-color:#900;
	color:#FFF;
}

.text span{display:inline-block}

</style>
	</head>
	<body>

	<?
		$CHECK = $db -> SelectOne("Select CouponName, CouponCode, PubDate from G_Coupon Where idx='".$req['idx']."' order by PubDate desc");
		$LIST = $db -> SelectList("Select * from G_Coupon Where CouponCode='".$CHECK['CouponCode']."' and PubDate='".$CHECK['PubDate']."' order by PubDate desc");
		$TOTAL = count($LIST);	
	?>
  <div id="load" align="center"><img src="images/loading.gif" width="28" height="28" align="absmiddle"/> Loading...</div>
	<div id="popupLayer" class="overlay_popup">
			<div class="titlebox">
				<h1><?=$CHECK['CouponName'] ?></h1>
			</div>

			<table width="100%" cellspacing="0" cellpadding="0" class="listtable">
				<col width="60"></col>
				<col width="*"></col>
				<col width="70"></col>
				<col width="60"></col>
				<col width="10"></col>
				<tr>
					<th class="tableth">번호</th>
					<th class="tableth">쿠폰명</th>
					<th class="tableth">발급일</th>
					<th class="tableth">사용</th>
					<th class="tableth"></th>
				</tr>
			</table>
			<div style="width:100%; height:200px; overflow-y:auto">
				<?
					$NUMBER = $TOTAL;
					if($LIST){
						foreach($LIST as $key => $value){
				?>
				<div class="box">
					<div class="text">
						<span style="width:60px"><?=$NUMBER--?></span>
						<span style="width:180px"><b><?=$value['Coupon']?></b></span> <span></span>
						<span style="width:70px"><?=substr($value['PubDate'],0,10)?></span>
						<span style="text-align:right; width:40px"><?=$value['UseYN']?> <a href="#" id="<?=$value['idx']?>" class="deletebtn">x</a></span>
					</div>
				</div>
				<?
						}
					}	
					$db -> Disconnect();
				?>

			</div>
	</div>

	</body>
</html>