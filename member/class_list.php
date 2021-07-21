<?
$Where = null;
//$WHERE[] = " Status = 'ing' ";
$WHERE[] = " BoardID = '".$Board['board_id']."' ";
$WHERE[] = " UserID = '".$MemberID."' ";
if($req['st']){
    if($req['sn'] == "s1") $WHERE[] = " ( Subject like '%".$req['st']."%') ";
    if($req['sn'] == "s2") $WHERE[] = " ( Content like '%".$req['st']."%') ";
    if($req['sn'] == "") $WHERE[] = " ( Subject like '%".$req['st']."%' or Content like '%".$req['st']."%') ";
}

if($req['sc']){
    $WHERE[] = " Category like '%".$req['sc']."%' ";
}

if($req['sdate'] && $req['edate']){
    $WHERE[] = " ( RegDate between '".$req['sdate']."' and '".$req['edate']." 23:59:59') ";
}

$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit ".($req['pagenumber'] - 1)*$Board['page_limit'].", ".$Board['page_limit'] ;

$SelectField = " * ";
$TOTAL  = $db -> Total("Select count(*) From ".$Board['comment_table']." Where Notice = 'N' ".$WhereQuery);
$Notice = $db -> SelectList("Select ".$SelectField." From ".$Board['comment_table']." Where Notice = 'Y' ".$WhereQuery.$OrderbyQuery);
$List   = $db -> SelectList("Select ".$SelectField." From ".$Board['comment_table']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);
$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];


/*
// 상담학 아카데미
unset($WHERE);
$WHERE[] = " UserID = '".$MemberID."' ";
$WHERE[] = " Category = '1WIR9N' ";
$WHERE[] = " BoardID = 'course02' ";

$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 999" ;

$SelectField = " * ";
$TOTAL  = $db -> Total("Select count(*) From ".$Board['comment_table']." Where idx > 0 ".$WhereQuery);
$List01   = $db -> SelectList("Select ".$SelectField." From ".$Board['comment_table']." Where idx > 0 ".$WhereQuery.$OrderbyQuery.$LimitQuery);


// 심리평가 및 상담의 이해와 실습
unset($WHERE);
$WHERE[] = " UserID = '".$MemberID."' ";
$WHERE[] = " Category = 'IAL3D3' ";
$WHERE[] = " BoardID = 'course02' ";

$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 999" ;

$SelectField = " * ";
$TOTAL  = $db -> Total("Select count(*) From ".$Board['comment_table']." Where idx > 0 ".$WhereQuery);
$List02   = $db -> SelectList("Select ".$SelectField." From ".$Board['comment_table']." Where idx > 0 ".$WhereQuery.$OrderbyQuery.$LimitQuery);

// 상담학아카데미 인턴쉽
unset($WHERE);
$WHERE[] = " UserID = '".$MemberID."' ";
$WHERE[] = " Category = 'E9BC9F' ";
$WHERE[] = " BoardID = 'course02' ";

$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 999" ;

$SelectField = " * ";
$TOTAL  = $db -> Total("Select count(*) From ".$Board['comment_table']." Where idx > 0 ".$WhereQuery);
$List03   = $db -> SelectList("Select ".$SelectField." From ".$Board['comment_table']." Where idx > 0 ".$WhereQuery.$OrderbyQuery.$LimitQuery);
*/
// ?>
</head>
<body>
<div id="wrap" class="sub sub<?=$_dep[0];?> sub<?=$_dep[0].$_dep[1];?>">
	<?include_once PATH.'/inc/head.php';?>
	<div id="svis">
		<h2><?=$_tit[0]?></h2>
	</div>
	<div id="snb">
		<div class="inner">
			<ul class="menu">
				<li class=""><a href="./mypage.php"><span>내정보</span></a></li>
				<li class="active" ><a href="./class.php"><span>수강신청내역</span></a></li>
			</ul>
		</div>
	</div>


	<div id="sub">
		<div class="inner">
			<div id="tit">
				<h3><?=end($_tit);?></h3>
			</div>
			<div id="content">

		


				<form name="searchform" method="get" class="__search">
				<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
					<input type="text" name="st" value="<?=$req['st']?>">
					<button type="submit"><i class="axi axi-search"></i></button>
				</form>

				<table class="__tbl-list responsive fix">
					<caption>TABLE</caption>
					<colgroup>
						<col style="width:80px;">
						<col style="width:*;">
						<col style="width:80px;">
						<col style="width:150px;">
						
						<col style="width:120px;">
					</colgroup>
					<thead>
						<tr>
						<th scope="col">번호</th>
								<th scope="col">강좌명</th>
								<th scope="col">강사명</th>
								<th scope="col">강의횟수<br/>/총시간</th>
								<th scope="col">수강확정 이수</th>
						</tr>
					</thead>
					<tbody>
					<?
						if($List){
							foreach($List as $key => $Value){
							  //$New = IconNew($Value['RegDate'], 86400, "<img src=\"../images/board/ico_new.gif\"  class=\"vt_mid\" alt=\"new\"  />");
							  $Attach = CheckAttach($Value['idx'], "<i class=\"axi axi-inbox\"></i> ");

							  if($Value['Category']=="1WIR9N") $Value['Category'] = "기업 방문형 IP 교육";
							  if($Value['Category']=="IAL3D3") $Value['Category'] = "기업 방문형 IP 상담 및 선행특허조사";
							  if($Value['Category']=="E9BC9F") $Value['Category'] = "IP지원사업 신청 가이드";

							  $Check = $db -> SelectOne("Select * from G_Info Where BoardID = '".$Value['BoardID']."' and idx = '".$Value['Pidx']."' ");
					?>
						<tr>
							<td class="__p"><?=$NUMBER--?></td>
							<td><a href="<?=$href?>&at=view&idx=<?=$Value['idx']?>"><?=$Value['Subject']?></a></td>
							<td><?=$Check['UserName']?></td>
						
							
						
					
							<td><?=$Check['ans04']?></td>
							<td class="__p"><?=$Value['Notice']?></td>
						</tr>
					<?
							}
						}else{
					?>
					<tr>
						<td colspan="7" class="tabletd center" style="height:200px">데이터가 없습니다.</td>
					</tr>
					<?
						}
						$db -> Disconnect();
					?>
					</tbody>
				</table>

				<!-- page -->
		      <? include "../inc/page.inc.php"; ?>
				<!-- page -->



			</div>
		</div>
	</div>
	<?include_once PATH.'/inc/foot.php';?>
</div>
</body>
</html>