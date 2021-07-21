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
        <? //include "inc/log.ip.php"; ?>
        <? //include "inc/log.os.php"; ?>
        <? //include "inc/log.bw.php"; ?>
        <? //include "inc/log.dim.php"; ?>
        <? //include "inc/log.color.php"; ?>


        <ul class="mytabs" id="tabs">
            <li class="current"><a href="inc/log.ip.php">아이피</a></li>
            <li><a href="inc/log.os.php">운영체제</a></li>
            <li><a href="inc/log.bw.php">브라우저</a></li>
            <li><a href="inc/log.dim.php">해상도</a></li>
            <li><a href="inc/log.color.php">화면색상</a></li>
        </ul>
        <div class="mytabs-container" id="tabs-container" ></div>


      </div>
			<!-- //로그분석 -->








<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>