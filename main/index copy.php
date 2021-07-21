<?
include_once '../inc/pub.config.php';
include_once PATH.'/inc/common.php';
?>
<?
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */
unset($db);
$db = new MySQL;

/*-------------------------------------------------------------------------------------------------
▶ 게시판 정보 */	

//////////////
// 공지사항
//////////////
$Board['board_id'] = "notice";
$Board['board_name'] = "공지사항";
$Board['table_board'] = "G_Notice";

unset($WHERE);
$WHERE[] = " Status = 'Y' ";
$WHERE[] = " BoardID = '".$Board['board_id']."' ";

// 첫번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 1";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List1   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);

// 2-4번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 1, 5";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);

//////////////
// FAQ
//////////////
$Board['board_id'] = "faq";
$Board['board_name'] = "FAQ";
$Board['table_board'] = "G_Notice";

unset($WHERE);
$WHERE[] = " Status = 'Y' ";
$WHERE[] = " BoardID = '".$Board['board_id']."' ";

// 첫번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 1";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List021   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);

// 2-4번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 1, 5";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List02   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);

//////////////
// 자료실
//////////////
$Board['board_id'] = "data";
$Board['board_name'] = "자료실";
$Board['table_board'] = "G_Notice";

unset($WHERE);
$WHERE[] = " Status = 'Y' ";
$WHERE[] = " BoardID = '".$Board['board_id']."' ";

// 첫번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 1";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List031   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);

// 2-4번째
$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 1, 5";

$SelectField = "idx, Subject, Content, cast(RegDate as date) as RegDate, Hit, BoardID, UserName, Category ";
$List03   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where Notice = 'N' ".$WhereQuery.$OrderbyQuery.$LimitQuery);

//////////////
// 하단 배너
//////////////
$Board['board_id'] = "Banner";
$Board['board_name'] = "하단 배너";
$Board['table_board'] = "G_Banner";

unset($WHERE);
$WHERE[] = " Category = 'WCW9IX' ";
$WHERE[] = " BoardID = '".$Board['board_id']."' ";

$WhereQuery   = (is_array($WHERE))? " and (".implode(" and ", $WHERE).")" : "";
$OrderbyQuery = " Order by idx desc ";
$LimitQuery   = " Limit 10";

$SelectField = " * ";
$List04   = $db -> SelectList("Select ".$SelectField." From ".$Board['table_board']." Where idx > 0 ".$WhereQuery.$OrderbyQuery.$LimitQuery);
?>
</head>
<body>
<div id="wrap">
	<?include_once PATH.'/inc/head.php';?>

	<div id="vis">
		<div class="roll">
			<div class="vis" style="background-image:url(<?=DIR?>/images/vis1.jpg);"></div>
			<div class="vis" style="background-image:url(https://via.placeholder.com/1920x604&text=2);"></div>
			<div class="vis" style="background-image:url(https://via.placeholder.com/1920x604&text=3);"></div>
		</div>
	</div>

	<div id="main">
		<div class="inner">

			<div class="campus">
				<div class="tit">
					<h3><img src="<?=DIR?>/images/tit-campus.png" alt="경기 중장년 행복캠퍼스" class="__p"><span class="__m">경기 중장년 행복캠퍼스</span></h3>
					<ul>
						<li><img src="<?=DIR?>/images/ico-phone.png" alt=""><span>031-899-7067~7068</span></li>
						<li><img src="<?=DIR?>/images/ico-loc.png" alt=""><span>경기도 용인시 기흥구 강남로 40 강남대학교 심전 2관 9~11층</span></li>
					</ul>
				</div>
				<div class="btn">
					<ul>
						<li><a href="#"><img src="<?=DIR?>/images/ico-campus1.png" alt=""><span>교육신청</span></a></li>
						<li><a href="#"><img src="<?=DIR?>/images/ico-campus2.png" alt=""><span>대관신청</span></a></li>
						<li><a href="#"><img src="<?=DIR?>/images/ico-campus3.png" alt=""><span>공지사항</span></a></li>
						<li><a href="#"><img src="<?=DIR?>/images/ico-campus4.png" alt=""><span>오시는 길</span></a></li>
					</ul>
				</div>
			</div>

			<div class="__pgmList _pgmRow2">
				<div class="tit">
					<h3>
						<strong>교육 프로그램 안내</strong>
						<span>선착순 모집중! 마감되기 전에 서두르세요~</span>
					</h3>
				</div>
				<div class="area">

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회  온라인, 오프라인 병합</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회  온라인, 오프라인 병합</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

				</div>
			</div>

			<div class="__pgmList _pgmRow2">
				<div class="tit">
					<h3>
						<strong>취·창업지원 안내</strong>
						<span>어르신들의 취·창업 관련 지원을 안내해 드립니다.</span>
					</h3>
				</div>
				<div class="area">

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회  온라인, 오프라인 병합</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회  온라인, 오프라인 병합</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="date">05.06  ~ 07.01 / 목 10-12시 8회</p>
							</div>
						</a>
					</div>

				</div>
			</div>

		</div>
	</div>

	<div id="notice">
		<div class="inner">
			<div class="lef">
				<div class="tab">
					<a href="#" class="active">공지사항</a>
					<a href="#">센터소식</a>
					<a href="#">언론보도</a>
				</div>
				<div class="sec">
					<div class="area active">
						<a href="#" class="more"></a>
						<div class="box">
							<a href="#" class="in">
								<p class="subject">경기도 중장년 행복캠퍼스 남부센터 개소식 안내 경기도 중장년 행복캠퍼스 남부센터 개소식 안내</p>
								<p class="sum">행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 내딛고 싶었지만, 코로나19로 인해 여러분들을 초대 행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 인해 여러분들을 초대</p>
								<p class="date">2021-05-11</p>
							</a>
						</div>
						<div class="box">
							<a href="#" class="in">
								<p class="subject">경기도 중장년 행복캠퍼스 남부센터 개소식 안내 경기도 중장년 행복캠퍼스 남부센터 개소식 안내</p>
								<p class="sum">행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 내딛고 싶었지만, 코로나19로 인해 여러분들을 초대 행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 인해 여러분들을 초대</p>
								<p class="date">2021-05-11</p>
							</a>
						</div>
						<div class="box">
							<a href="#" class="in">
								<p class="subject">경기도 중장년 행복캠퍼스 남부센터 개소식 안내 경기도 중장년 행복캠퍼스 남부센터 개소식 안내</p>
								<p class="sum">행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 내딛고 싶었지만, 코로나19로 인해 여러분들을 초대 행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 인해 여러분들을 초대</p>
								<p class="date">2021-05-11</p>
							</a>
						</div>
					</div>
					<div class="area">
						<a href="#" class="more"></a>
						<div class="box">
							<a href="#" class="in">
								<p class="subject">2경기도 중장년 행복캠퍼스 남부센터 개소식 안내 경기도 중장년 행복캠퍼스 남부센터 개소식 안내</p>
								<p class="sum">행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 내딛고 싶었지만, 코로나19로 인해 여러분들을 초대 행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 인해 여러분들을 초대</p>
								<p class="date">2021-05-11</p>
							</a>
						</div>
						<div class="box">
							<a href="#" class="in">
								<p class="subject">2경기도 중장년 행복캠퍼스 남부센터 개소식 안내 경기도 중장년 행복캠퍼스 남부센터 개소식 안내</p>
								<p class="sum">행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 내딛고 싶었지만, 코로나19로 인해 여러분들을 초대 행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 인해 여러분들을 초대</p>
								<p class="date">2021-05-11</p>
							</a>
						</div>
						<div class="box">
							<a href="#" class="in">
								<p class="subject">2경기도 중장년 행복캠퍼스 남부센터 개소식 안내 경기도 중장년 행복캠퍼스 남부센터 개소식 안내</p>
								<p class="sum">행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 내딛고 싶었지만, 코로나19로 인해 여러분들을 초대 행복캠퍼스의 시작을 여러분들과 함께 힘찬 발걸음을 인해 여러분들을 초대</p>
								<p class="date">2021-05-11</p>
							</a>
						</div>
					</div>
					<div class="area">
						<a href="#" class="more"></a>
						<div class="box">
							<a href="https://blog.naver.com/gyeonggi_gov/222400305032" class="in"  target='_blank'>
								<p class="subject">[경기도민기자단] 시니어들의 인생 제2막 힘차게 나빌레라! 경기중장년 행복캠퍼스(남부)취재기</p>
								<p class="sum">경기도에서는 지방정부 최초로 50,60대의 미래를 위한 종합서비스 공간'경기 중장년 행복캠퍼스'를 개소했습니다.</p>
								<p class="date">2021-06-16</p>
							</a>
						</div>
						<div class="box">
							<a href="https://imnews.imbc.com/replay/2021/nwtoday/article/6214897_34943.html" class="in"  target='_blank'>
								<p class="subject">중장년 위한 '행복캠퍼스'…"인생 2막 설계"</p>
								<p class="sum">경기도가 강남대학과 대진대학 두 곳에 마련한 중장년 행복캠퍼스에서는 캘리그래피 외에 디지털 소통과 재무설계 유튜버, 드론 자격증 등 노후설계와 재취업과 관련된 14개의 특화된 수업을 제공합니다.</p>
								<p class="date">2021-06-01</p>
							</a>
						</div>
						
					</div>
				</div>
			</div>
			<div class="rig">
				<div class="ban">
					<div class="roll">
						<div class="box"><a href="#"><span style="background-image:url(https://via.placeholder.com/350x300&text=1);"></span></a></div>
						<div class="box"><a href="#"><span style="background-image:url(https://via.placeholder.com/350x300&text=2);"></span></a></div>
						<div class="box"><a href="#"><span style="background-image:url(https://via.placeholder.com/350x300&text=3);"></span></a></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="bot">
		<div class="inner">

			<div class="__pgmList _pgmRow1">
				<div class="tit">
					<h3>
						<strong>동아리/사회공헌</strong>
						<span>5060세대의 다양한 활동을 알려드립니다.</span>
					</h3>
				</div>
				<div class="area">

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

					<div class="box">
						<a href="#" class="in">
							<div class="img"><span style="background-image:url(https://via.placeholder.com/560x400);"></span></div>
							<div class="info">
								<p class="subject">디지털시대 스마트 라이프 즐기기 디지털시대 스마트 라이프 즐기기</p>
								<p class="sum">새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요 새로운 커뮤니티 활동모임 영상누리 커뮤니티 활동 후기를 만나 보세요</p>
								<p class="date">2021-05-11 </p>
							</div>
						</a>
					</div>

				</div>
			</div>

		</div>
	</div>

	<?include_once PATH.'/inc/foot.php';?>
</div>

<script>
vis.init();
pgm.init();
notice.init();
</script>

<!-- Popup Script -->
<?
// 팝업

	$sql_p = "Select * from G_Popup Where Display = 'Y' and now() between StartDate and EndDate";
	$Popup = mysql_query($sql_p);

	if($Popup){
		while($pvalue = mysql_fetch_array($Popup)){
?>
<script type='text/javascript'>
//<![CDATA[
$(function() {
	if ( getCookie( "popuplayer<?=$pvalue['idx']?>" ) != "done" ) { 
		$("#popuplayer<?=$pvalue['idx']?>").fadeIn();
	}
});
//]]>
</script>
<div style="width:<?=$pvalue['Width']?>px; height:<?=$pvalue['Height']?>px; position:absolute; top:<?=$pvalue['toppos']?>px; left:<?=$pvalue['leftpos']?>px; z-index:9999; background-color:#FFF; border:1px solid #c0c0c0; display:none;" id="popuplayer<?=$pvalue['idx']?>">
<?=$pvalue['Content']?>
<form name="popuplayer<?=$pvalue['idx']?>">
<div style="width:100%; height:30px; text-align:right; height:20px; background-color:#000000; color:white"><span style="color:grey"><label><input type="checkbox" name="popupcheck" value="Y" style="border:none"> 오늘하루열지않음</label> <span style="display:inie-block:width:300px">&nbsp;</span></span> <a href="javascript:popupClose('popuplayer<?=$pvalue['idx']?>');"><span style="color:grey">Close</span></a>&nbsp;&nbsp;</div>
</form>
</div>
<?
		}
	}	
?>
<script type='text/javascript'>
//<![CDATA[
function popupClose(cookiename){ 
	var f = eval("document."+cookiename);
	if(f.popupcheck.checked){
		setCookie( cookiename, "done" , 1); 
	}
	$("#"+cookiename).hide().html("");
} 

/*=================================================================================================
 cookie 
=================================================================================================*/
//쿠키생성 ;;
function setCookie( name, value, expiredays ){
	var today = new Date();
	today.setDate( today.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + today.toGMTString() + ";";
}

// 쿠키정보 ;;
function getCookie( name ) { 
	var nameOfCookie = name + "="; 
	var x = 0; 
	while ( x <= document.cookie.length ) { 
		var y = (x+nameOfCookie.length); 
		if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
				endOfCookie = document.cookie.length; 
			return unescape( document.cookie.substring( y, endOfCookie ) ); 
		} 
		x = document.cookie.indexOf( " ", x ) + 1; 
		if ( x == 0 ) 
		break; 
	} 
	return ""; 
}
//]]>
</script>
<!-- //Popup Script -->

</body>
</html>