<?
$_dep = array(7,3);
$_tit = array('멤버십','아이디/비밀번호 찾기');
include_once '../inc/pub.config.php';
include_once PATH.'/inc/common.php';
?>
</head>
<body>
<div id="wrap" class="sub sub<?=$_dep[0];?> sub<?=$_dep[0].$_dep[1];?>">
	<?include_once PATH.'/inc/head.php';?>
	<div id="svis">
		<h2><?=$_tit[0]?></h2>
	</div>
	<div id="sub">
		<div class="inner">
			<div id="tit">
				<h3><?=end($_tit);?></h3>
			</div>
			<div id="content">

				<div class="__tit1">
					<h3>아이디 찾기</h3>
				</div>

	<form name="findidform" id="findidform" method="post" action="<?=_CORE_?>/act/?at=findid"  >
				<table class="__tbl-write">
					<caption>작성</caption>
					<tbody>
						<tr>
							<th scope="row"><span>이름</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_name" id="m_name">
							</td>
						</tr>
						<tr>
							<th scope="row"><span>이메일</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_email" id="m_email">
							</td>
						</tr>
					</tbody>
				</table>

				<div class="__botarea">
					<div class="cen">
						<button type="submit" class="__btn2">찾기</button>
					</div>
				</div>
	</form>

				<div class="__tit1 __mt50">
					<h3>비밀번호 찾기</h3>
				</div>

	<form name="findpwform" id="findpwform" method="post" action="<?=_CORE_?>/act/?at=findpw"  >
				<table class="__tbl-write">
					<caption>작성</caption>
					<tbody>
						<tr>
							<th scope="row"><span>아이디</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_id" id="m_id">
							</td>
						</tr>
						<tr>
							<th scope="row"><span>이름</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_name" id="m_name">
							</td>
						</tr>
						<tr>
							<th scope="row"><span>이메일</span></th>
							<td>
								<input type="text" class="__form1" style="width:300px;" name="m_email" id="m_email">
							</td>
						</tr>
					</tbody>
				</table>

				<div class="__botarea">
					<div class="cen">
						<button type="submit" class="__btn2">찾기</button>
					</div>
				</div>
	</form>

			</div>
		</div>
	</div>
	<?include_once PATH.'/inc/foot.php';?>
</div>
</body>
</html>