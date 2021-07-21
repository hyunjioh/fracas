<?	if(!defined("_g_board_include_")) exit; ?>
<? include "../include/_header.inc.php"; ?>
</head>

<?	require_once "../include/_body_top.inc.php"; ?>




			<!-- 로그분석 -->
			<div id="LOG">
				<? include "inc/_log.top.php"; ?>
				<br>

				<?
				$date = $Today_M;
				?>
				<? //include "inc/log.date.php"; ?>
				<? //include "inc/log.time.php"; ?>
				<? //include "inc/log.yoil.php"; ?>



        <ul class="mytabs" id="tabs">
            <li class="current"><a href="inc/log.date.php">일별 방문자</a></li>
            <li ><a href="inc/log.dateavg.php">일별 평균체류시간</a></li>
            <li><a href="inc/log.time.php">시간대 방문자</a></li>
            <li><a href="inc/log.yoil.php">요일별 방문자</a></li>
            <li><a href="inc/log.main.php"><?=substr($req['sdate'],0,4)?>년 월별 방문자</a></li>
            <li><a href="inc/log.day.php"><?=substr($req['sdate'],0,7)?>  일별 방문자</a></li>
        </ul>
        <div class="mytabs-container" id="tabs-container" ></div>
			</div>
			<!-- //로그분석 -->







<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>