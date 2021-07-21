<?	if(!defined("_g_board_include_")) exit; ?>
<? include "../include/_header.inc.php"; ?>
</head>
<?	require_once "../include/_body_top.inc.php"; ?>




			<!-- 로그분석 -->
			<div id="LOG">
				<? include "inc/_log.top.php"; ?>
				<br>


				<?
				$date = $Today_D;
				?>
				<? //include "inc/log.today.php"; ?>
				<? //include "inc/log.searchengine.php"; ?>
				<? //include "inc/log.searchword.php"; ?>
				<? //include "inc/log.link.php"; ?>



        <ul class="mytabs" id="tabs">
            <li class="current"><a href="inc/log.main.php"><?=substr($req['edate'],0,4)?>년 월별 방문자</a></li>
            <li><a href="inc/log.day.php"><?=substr($req['edate'],0,7)?>  일별 방문자</a></li>
        </ul>
        <div class="mytabs-container" id="tabs-container" ></div>
			</div>
			<!-- //로그분석 -->




<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>