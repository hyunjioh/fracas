<?

	if(!$req['idx'])	locationReplace($Board['Link']);
	$BoardView = "select * from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx'];
	$Value = $db -> SelectOne($BoardView);
	if(!$Value)	locationReplace($Board['Link']);


	  


?>

</head>
<body>
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
<div id="content">

<form name="signupform" id="signupform" method="post" action="<?=_CORE_?>/act/?at=subjoin2" onsubmit="return frmcheck();"  >
	<input type="hidden" name="_referer_" value="<?=$req['ref']?>">
	<input type="hidden" name="return_url" value="<?=_THIS_URI_?>/login.php">
	<input type="hidden" name="am" value="newData">
	<input type="hidden" name="m_indivi" value="<?=$req['m_indivi']?>">

	<input type="hidden" name="idDuplicateYn" id="idDuplicateYn" value="N">
	<input type="hidden" name="emailDuplicateYn" id="emailDuplicateYn" value="N">

	<input type="hidden" name="m_id_chk" value="">
	<input type="hidden" name="m_email_chk" value="">
	<input type="hidden" name="m_email_chk02" value="">
	<input type="hidden" name="info02" value="">
	<input type="hidden" name="info03" value="">
	<input type="hidden" name="idx" value="<?=$Value['idx']?>">

	<div class="__toparea __mt50">
		<div class="__tit1">
			<h3>서브 아이디 신청</h3>
			<!-- <td><?=$Value['idx']?></td> -->
		</div>
		<div class="rig __txt16 __blue2">
			* 필수정보입력입니다.
		</div>
	</div>

	<table class="__tbl-write">
		<caption>작성</caption>
		<tbody>

	
		<div class="__board-view">
					<div class="top">
						<h3><?=$Value['Subject']?></h3>
						<!-- <div class="info">
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
									<input type="text" name="info02"  value="<?=$Value['info02']?>" size="5" maxlength="255" class="input" >

									
								</tr>
								
							</div>
							
						</div> -->
						
					</div>
					<div class="con2">
					<tr><td>
					<textarea type="text" name="info03"  value="<?=$Value['info03']?>" size="5" maxlength="255" class="input" ></textarea>
</td></tr>
					
					</div>
							

		</tbody>
	</table>

	<div class="__botarea">
		<div class="cen">
			<button type="submit" class="__btn2" style="padding-top: 0">수정</button>
		</div>
	</div>

</form>
</div>
	<?include_once PATH.'/inc/foot.php';?>
</div>
</body>
</html>