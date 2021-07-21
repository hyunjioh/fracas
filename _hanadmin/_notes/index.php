<?php
$pagecode = "A00212";
define("_administrators_",true);
define("_g_board_include_",true);
include "../../_core/_lib.php";
require_once "../include/_header.inc.php";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

// Removing notes that are older than an hour:
//$db -> ExecQuery("DELETE FROM notes WHERE id>3 AND dt<SUBTIME(NOW(),'0 1:0:0')");

$Query = "SELECT * FROM notes ORDER BY id DESC";

$notes = '';
$left='';
$top='';
$zindex='';

$LIST = $db -> SelectList("SELECT * FROM notes ORDER BY id DESC");
$count = count($LIST);
if($count>0){
	for($i=0; $i<$count; $i++){
		$row = $LIST[$i];
		// The xyz column holds the position and z-index in the form 200x100x10:
		list($left,$top,$zindex) = explode('x',$row['xyz']);

		$notes.= '
		<div class="note '.$row['color'].'" style="left:'.$left.'px;top:'.$top.'px;z-index:'.$zindex.'">
			<span class="close"></span>
			'.htmlspecialchars($row['text']).'
			<div class="author">'.htmlspecialchars($row['name']).'</div>
			<span class="date">'.$row['dt'].'</span>
			<span class="data">'.$row['id'].'</span>
		</div>';
		}
}

?>


<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.2.6.css" media="screen" />
<script type="text/javascript" src="fancybox/jquery.fancybox-1.2.6.pack.js"></script>
<script type="text/javascript" src="script.js"></script>
</head>
<?	require_once "../include/_body_top.inc.php"; ?>



	<div id="main">
		<a id="addButton" class="green-button" href="add_note.html">Add a note</a> <!--<span style="margin-left:90px; padding-top:10px">1시간이 지난 메모는 삭제되며, 최소 3개는 계속 유지됩니다.</span>-->
		<?php echo $notes?>
	</div>


<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>
