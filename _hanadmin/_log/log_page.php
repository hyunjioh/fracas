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
        <? //include "inc/log.firstpage.php"; ?>
        <? //include "inc/log.lastpage.php"; ?>
        <? //include "inc/log.bestpage.php"; ?>


        <ul class="mytabs" id="tabs">
            <li class="current"><a href="inc/log.bestpage.php">인기있는 페이지</a></li>
            <li><a href="inc/log.firstpage.php">처음접속 페이지</a></li>
            <li><a href="inc/log.lastpage.php">마지막접속 페이지</a></li>
        </ul>
        <div class="mytabs-container" id="tabs-container" ></div>
      </div>
			<!-- //로그분석 -->








<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>