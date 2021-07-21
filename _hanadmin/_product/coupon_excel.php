<?
header( "Content-type: application/vnd.ms-excel" );
header( "Content-Disposition: attachment; filename=".date("Y-m-d")."_coupon".".xls" );
header( "Content-Description: PHP4 Generated Data" );
require_once "../../_core/_lib.php";
require_once _CORE_PATH_."/system/function.board.php";
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;
define("_admin_include", true);
$req['idx']			= Request('idx');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> Overlay </title>
<style>

</style>
	</head>
	<body>

	<?
		$CHECK = $db -> SelectOne("Select CouponName, CouponCode, PubDate from G_Coupon Where idx='".$req['idx']."' order by PubDate desc");
		$LIST = $db -> SelectList("Select * from G_Coupon Where CouponCode='".$CHECK['CouponCode']."' and PubDate='".$CHECK['PubDate']."' order by PubDate desc");
		$TOTAL = count($LIST);	
	?>
	<div id="popupLayer" class="pop_authPhone">
			<div class="titlebox">
				<h1><?=$CHECK['CouponName'] ?></h1>
			</div>

			<table width="100%" cellspacing="0" cellpadding="0" class="listtable" border="1">
				<col width="60"></col>
				<col width="300"></col>
				<col width="120"></col>
				<col width="60"></col>
				<tr>
					<th class="tableth">번호</th>
					<th class="tableth">쿠폰명</th>
					<th class="tableth">발급일</th>
					<th class="tableth">사용</th>
				</tr>
				<?
					$NUMBER = $TOTAL;
					if($LIST){
						foreach($LIST as $key => $value){
				?>
				<tr>
					<th class="tableth"><?=$NUMBER--?></th>
					<th class="tableth"><?=$value['Coupon']?></th>
					<th class="tableth"><?=substr($value['PubDate'],0,10)?></th>
					<th class="tableth"><?=$value['UseYN']?></th>
				</tr>
				<?
						}
					}	
					$db -> Disconnect();
				?>
			</table>

	</div>

	</body>
</html>