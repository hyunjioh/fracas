<?
//	if(!defined("_g_board_include_")) exit;

	if(!$req['idx'])	locationReplace($Board['Link']);
	$BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx'];
	$Value = $db -> SelectOne($BoardView);
	if(!$Value)	locationReplace($Board['Link']);


	  
		$mode = "updateData";
		if($req['at'] == "reply") {
		  $mode = "replyData";
		  $Value['info02'] = "";
		  $Value['info03'] = "";
		}
		$mode = "deleteData";
	if($req['at'] == "reply") {
	  $mode = "deleteData";
	  $Value['info02'] = "";
	  $Value['info03'] = "";
	  }

?>

</head>
<body>

<!-- view -->
<form name="signupform" id="signupform" method="post" action="<?=_CORE_?>/act/?at=join" onsubmit="return frmcheck();"  >
<!-- <form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess"> -->
<!-- 
<form name="boardform" method="post"> -->
<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="am" value="">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">

<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="sdate" value="<?=$req['sdate']?>">
<input type="hidden" name="edate" value="<?=$req['edate']?>">
<input type="hidden" name="sn" value="<?=$req['sn']?>">
<input type="hidden" name="st" value="<?=$req['st']?>">
<input type="hidden" name="sc" value="<?=$req['sc']?>">
<input type="hidden" name="orderby" value="<?=$req['orderby']?>">
<input type="hidden" name="sort" value="<?=$req['sort']?>">
</form>

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


				<div class="__board-view">
					<div class="top">
						<h3><?=$Value['Subject']?></h3>
						<div class="info">
							<div class="file">
								
								<tr>
									<td><strong>서비스 실무 담당자</strong></td>
									<td><?=$Value['info05']?></td>
							
								</tr>
								
							</div>
							
							
						</div>
						<div class="info">
							<div class="file">
								
								<tr>
									<td><strong>종료일</strong></td>
									<td><?=$Value['info07']?></td>

									
								</tr>
								
							</div>
							
						</div>
						<div class="file">
								
								<tr>
									<td><strong>방문희망날짜</strong></td>
									<input type="text" name="UserName"  value="<?=$Value['info02']?>" size="5" maxlength="255" class="input" >

									
								</tr>
								
							</div>
							
						</div>
						
					</div>
					<div class="con2">
					<tr><td>
					<textarea type="text" name="UserName"  value="<?=$Value['info03']?>" size="5" maxlength="255" class="input" ></textarea>
</td></tr>
					
					</div>
				</div>

				<div class="__botarea">
					<!-- <div class="cen">
						<a href="<?=$href?>" class="__btn2">목록</a>
						<a href="<?=$href?>&at=modify&idx=<?=$Value['idx']?>">삭제</a>
						<a href="<?=$href?>&at=modify&idx=<?=$Value['idx']?>">수정</a>
					</div> -->
					<!-- <div class="__botarea"> -->
					<div class="cen">
						<button type="submit" class="__btn2" style="padding-top: 0">승인 요청</button>
					</div>
				</div>
				<!-- </div> -->



			</div>
		</div>
	</div>
	</form>
	<?include_once PATH.'/inc/foot.php';?>
</div>
</body>
</html>