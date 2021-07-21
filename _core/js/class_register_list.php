<?php
/*=======================================================================================
◈ program
---------------------------------------------------------------------------------------*/
if(!defined("_g_board_include_")) exit;


// 주요 일정
$pre_ym = $_GET['pre_ym'];
$next_ym = $_GET['next_ym'];

$year = $_GET['year'];
$month = $_GET['month'];

if($pre_ym=="Y"){

	$month--;
	if($month<1){
		$month=12;
		$year--;
	}

} elseif($next_ym=="Y"){

	$month++;
	if($month>12){
		$month=1;
		$year++;
	}

}

if($month>0 && $month<10){
	$month = "0".$month;
}


if(trim($year)==""){
	$year_n = date('Y');
} else{
	$year_n = $year;
}

if(trim($month)==""){
	$month_n = date('m');
} else{
	$month_n = $month;
}

?>	

<? include "../include/Site_Title.php" ?>
<title> <?=$Site_Title?> </title>

</head>

<body class="sub">

<!-- WRAPPER -->
<div id="wrapper">
	<div class="wrap_left">

	<!-- header -->
	<? include "../include/header.php" ?>
	<!-- //header -->

	<!-- visual -->
	<? include "../include/visual.php" ?>
	<!-- //visual -->

	<!-- CONTAINER -->
	<div id="container">

		<!-- snb -->
		<? include "../include/snb.php" ?>
		<!-- //snb -->		

		<!-- location -->
		<? include "../include/location.php" ?>
		<!-- //location -->	

		<!-- headline -->
		<? include "../include/headline.php" ?>
		<!-- //headline -->

		<!-- CONTENTS -->
		<div id="contents">

			<!-- CONTENTS_IN -->
			<div id="contents_in">

<?
		$now_time = time();
		
		function v_week1($y, $m, $d) {
		$week = Array("일","월","화","수","목","금","토");
		echo $week[date("w", mktime(0,0,0,$m,$d,$y))];
		}
		
		if ($year){
		$toyear = $year;
		}else{
		$toyear = date("Y",$now_time);				// 현재 일을 출력
		}
		if ($month){
		$tomonth = $month;
		}else{
		$tomonth = date("n",$now_time);				// 현재 일을 출력
		}
		if ($dday){
		$today = $dday;
		}else{
		  if ($year && $month){
		  $today = 1;
		  }else{
		  $today = date("j",$now_time);				// 현재 일을 출력
		  }
		}

		if(!$year) $year = date("Y",$now_time);		// 현재 년도를 출력
		if(!$month) $month = date("m",$now_time);	// 현재 월을 출력
		
		if($month == '12') { 
			$p_year = $year; 
			$p_month = $month - 1;
			$n_year = $year + 1;
			$n_month = '1';
		
		} else if($month == '1') { 
			$p_year = $year - 1; 
			$p_month = '12'; 
			$n_year = $year; 
			$n_month = $month + 1;  
		
		} else { 
			$p_year = $year; 
			$p_month = $month - 1; 
			$n_year = $year; 
			$n_month = $month + 1;
		}
		
		$firstday = date("w",mktime(0,0,0,$month,1,$year));
		$lastday = date("t",mktime(0,0,0,$month,1,$year));
?>
<script language="javascript">
function go_pre(){
	location.href="<?=$_SERVER['PHP_SELF']?>?pre_ym=Y&year=<?=$year_n?>&month=<?=$month_n?>";
}
function go_next(){
	location.href="<?=$_SERVER['PHP_SELF']?>?next_ym=Y&year=<?=$year_n?>&month=<?=$month_n?>";
}
</script>					

				<!-- calendar_month -->
				<div class="calendar_month">
					<p class="date">
						<a href="<?=$_SERVER['PHP_SELF']?>?pre_ym=Y&year=<?=$year_n?>&month=<?=$month_n?>"><img src="../images/board/btn_prev2.gif" alt="이전" /></a>
						<?=$year_n?>. <?=$month_n?>.
						<a href="<?=$_SERVER['PHP_SELF']?>?next_ym=Y&year=<?=$year_n?>&month=<?=$month_n?>"><img src="../images/board/btn_next2.gif" alt="다음" /></a>
					</p>

					<p class="icon">
						<img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 신청가능&nbsp;&nbsp;
						<img src="../images/board/ico_class_no.gif" alt="마감" /> 마감
					</p>
				</div>
				<!-- //calendar_month -->

				<!-- calendar -->
				<table class="calendar" summary="">
					<caption>강좌신청 월별 일정표</caption>
					<colgroup>
					<col width="15%" />
					<col width="*" />
					<col width="14%" />
					<col width="14%" />
					<col width="14%" />
					<col width="14%" />
					<col width="14%" />
					</colgroup>

					<thead>
					<tr>
						<th class="first-child">일요일</th>
						<th>월요일</th>
						<th>화요일</th>
						<th>수요일</th>
						<th>목요일</th>
						<th>금요일</th>
						<th class="last-child">토요일</th>
					</tr>
					</thead>

					<tbody>
          	<?
          	if(($firstday > 4 && $lastday == 31)||($firstday > 5 && $lastday == 30)){
          		$week_num = 5;
          	} else if($firstday == 0 && $lastday == 28){
          		$week_num = 3;
          	} else {
          		$week_num = 4;
          	}
				$day = 1;
				for($i=0; $i<=$week_num; $i++) {
					echo "<tr>\n";
					if($i == 0){
						if($day <= $firstday){
							for($k = 0;$k < $firstday;$k++){
								echo "<td height='90'></td>";
							}
						}
					}
					for($j=0; $j<=6; $j++){
				
					//echo ("<td width='25' height='14' align='center' valign='middle'>");
					echo ("");
						if($firstday == $j || $day > 1) {
							if($day > $lastday){ 
								echo ("<td height='90'></td>");
							} else {
				
								$days = $day;
				
				

					$day_tem=$day<10?"0".$day:$day;
				
				    $user_dates = $year."-".$month."-".$day_tem;

					###########################################################
					$Board['board_id'] = "course";
					$Board['board_name'] = "주요일정";
					$Board['table_board'] = "G_Info";
					###########################################################
					
					$StrSelect = " idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, sDate, Status, Comment  ";
					$query = " SELECT $StrSelect					".
							 "   FROM ".$Board['table_board']."			".
							 "  WHERE idx > 0						".
							 "			AND Status in ('ing','end') 			".
							 "			AND BoardID =  '".$Board['board_id']."' 			".
							 "			AND sDate = '".$user_dates."'	".
							 "  ORDER BY idx DESC					";

					$List03   = $db -> SelectList($query);
				
					$subject1 = "";
					$_bg = "";
					$class = "";

					if($List03){
						foreach($List03 as $key => $Value03){

							$idx = $Value03['idx'];
							$SUBJECT = strCut($Value03['Subject'],15,"..");

							$imgStatus = "<img src='../images/board/ico_class_ok.gif' alt='신청가능' />";
							if($Value03['Status']=="end"){
								$imgStatus = "<img src='../images/board/ico_class_no.gif' alt='마감' />";
							}
							if($idx){
									$_bg = "bgcolor='#D2E9FF'";
									//$subject1 .= "<br />".$imgStatus." <a onclick=\"layer_open('layer2');return false;\" href=\"#\">$SUBJECT</a>";
									$subject1 .= "<br />".$imgStatus." <a href=\"popCourse.php?idx=".$Value03['idx']."\" rel='#event_overlay' class='overlay'>".$SUBJECT."</a>";
									
							} // end if

						}
					}
				
				
				    ##########################################################
				    ##########################################################	
					if(date("Y-m-d") == $user_dates) $class = "class='today'";

								if($subject1){
									//$days  = $subject1."".$days."</a>";				
									//$days  = "<a href=\"/cnss/schedule.php?at=view&sDate=$user_dates\"><font color='tomato'><b>".$days."</b></font></a>";
									$days  = "<font color='tomato'><b>".$days."</b></font>".$subject1;
								}else{
									$days  = $days;
								}
								
								if($j == 6) {									
									echo("<td $class width='14%' height='90'><font color=#80b600>$days</font></td>");									
								} else if($j == 0) {
									echo("<td $class width='14%' height='90'><font color=#f56b16>$days</font></td>");									
								} else {
									echo("<td $class width='14%' height='90'>$days</td>");									
								}	
							}
						$day ++;
						}
						//echo "</td>\n";
					}
				echo ("</tr>\n");
				}

				?>
					<!--tr>
						<td class="txt_monday">1</td>
						<td>2
							<ul>
							<li><a onclick="layer_open('layer2');return false;" href="#"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 프리미움 GB 스쿨 (낮반)</a></li>
							<li><a onclick="layer_open('layer2');return false;" href="#"><img src="../images/board/ico_class_no.gif" alt="마감" /> 프리미움 GB 스쿨 (저녁 직장인반)</a></li>
							</ul>
						</td>
						<td>3</td>
						<td>4</td>
						<td>5</td>
						<td>6</td>
						<td class="txt_saturday">7
							<ul>
							<li><a href="#none"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 프리미움 GB 스쿨 (낮반)</a></li>
							<li><a href="#none"><img src="../images/board/ico_class_no.gif" alt="마감" /> 출산준비물 특강</a></li>
							</ul>
						</td>
					</tr>

					<tr>
						<td class="txt_monday">8
							<ul>
							<li><a href="#none"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 예감놀 클라스 </a></li>
							</ul>	
						</td>
						<td class="today">9
							<ul>
							<li><a href="#none"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 프리미움 GB 스쿨 (일요일 1day 클라스) </a></li>
							</ul>
						</td>
						<td>10</td>
						<td>11
							<ul>
							<li><a href="#none"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 프리미움 GB 스쿨 (c/s 육아과정)</a></li>
							</ul>
						</td>
						<td>12</td>
						<td>13</td>
						<td class="txt_saturday">14</td>
					</tr>

					<tr>
						<td class="txt_monday">15</td>
						<td>16</td>
						<td>17
							<ul>
							<li><a href="#none"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 프리미움 GB 스쿨 (낮반)</a></li>
							<li><a href="#none"><img src="../images/board/ico_class_no.gif" alt="마감" /> 프리미움 GB 스쿨 (저녁 직장인반)</a></li>
							</ul>
						</td>
						<td>18</td>
						<td>19</td>
						<td>20</td>
						<td class="txt_saturday">21
							<ul>
							<li><a href="#none"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 프리미움 GB 스쿨 (낮반)</a></li>
							<li><a href="#none"><img src="../images/board/ico_class_no.gif" alt="마감" /> 프리미움 GB 스쿨 (저녁 직장인반)</a></li>
							</ul>
						</td>
					</tr>

					<tr>
						<td class="txt_monday">22
							<ul>
							<li><a href="#none"><img src="../images/board/ico_class_ok.gif" alt="신청가능" /> 예교원 멤버십 육아강좌 </a></li>
							<li><a href="#none"><img src="../images/board/ico_class_no.gif" alt="마감" /> 프리미움 GB 스쿨 (저녁 직장인반)</a></li>
							</ul>
						</td>
						<td>23</td>
						<td>24</td>
						<td>25</td>
						<td>26</td>
						<td>27</td>
						<td class="txt_saturday">28</td>
					</tr>

					<tr>
						<td class="txt_monday">29</td>
						<td>30</td>
						<td>31</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="txt_saturday">&nbsp;</td>
					</tr -->
					</tbody>
				</table>
				<!-- //calendar -->

			</div>
			<!-- //CONTENTS_IN -->

		</div>
		<!-- //CONTENTS -->

	</div>
	<!-- //CONTAINER -->

	<!-- footer -->
	<? include "../include/footer.php" ?>
	<!-- //footer -->

	</div>
</div>
<!-- //WRAPPER -->



<!-- 레이어팝업 -->
<div class="layer">
<div class="bg"></div>
<div class="pop-layer" id="layer2">

	<!-- 레이어팝업_컨텐츠 -->
	<div class="top">
		<h3>프리미움 GB 스쿨 (낮반) </h3>
		<a class="cbtn" href="#"><img src="../images/board/btn_close.gif" class="btn_close" alt="닫기" /></a>
	</div>

	<div class="contents">
		<table class="bbs_view2" summary="">
			<caption>강좌상세보기</caption>
			<colgroup>
			<col width="22%">
			<col width="*">
			</colgroup>

			<tr>
				<th scope="row">시간</th>
				<td>2014년 06월 22일   14:00 ~ 18:00</td>
			</tr>
			<tr>
				<th scope="row">정원</th>
				<td>35 / 40 명</td>
			</tr>
			<tr>
				<th scope="row">상태</th>
				<td><img src="../images/board/ico_class_ok2.gif" alt="신청가능" /> <img src="../images/board/ico_class_no2.gif" alt="마감" /></td>
			</tr>
			<tr>
				<th scope="row">상세설명</th>
				<td>8~9월 출산예정자를 위한 낮반 1기 신청 <br />분만예행연습 별도 일정 추후 선택</td>
			</tr>
		</table>
		<p class="txt_center"><a href="#none"><img src="../images/board/btn_register2.gif" alt="신청하기" /></a></p>
	</div>	
	<!-- //레이어팝업_컨텐츠 -->

</div>
</div>
<!-- //레이어팝업 -->


<!-- popup overlay -->
<div class="event_overlay" id="event_overlay">
  <div class="contentWrap"></div>
</div>
<!-- //popup overlay -->

</body>
</html>