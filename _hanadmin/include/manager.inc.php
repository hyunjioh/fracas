<?
/*====================================================================================================
◈ 접급권한 체크
----------------------------------------------------------------------------------------------------*/
if(isset($_SESSION['_MANAGER_']['ID']) && $_SESSION['_MANAGER_']['ID'] != "") define("_is_manager_", $_SESSION['_MANAGER_']['ID']);



/*====================================================================================================
◈ 메뉴셋팅
----------------------------------------------------------------------------------------------------*/
$SNB['0'] = "<img src='"._ADMIN_."/images/snb/snb.gif'>";

// $GNB['A'] = "<img src='"._ADMIN_."/images/gnb/gnb0.gif'>";
// $SNB['A'] = "<img src='"._ADMIN_."/images/snb/snb0.gif'>";

$Menu['A']['A001'] = array("사이트관리",_ADMIN_."/_popup/popup.php");
$Menu['A001']['11'] = array("팝업관리",_ADMIN_."/_popup/popup.php");
$Menu['A001']['12'] = array("배너관리",_ADMIN_."/_banner/banner.php");
//$Menu['A001']['13'] = array("환경설정",_ADMIN_."/_site/siteconfig.php");

// $Menu['A']['A002'] = array("관리자",_ADMIN_."/_schedule/");
// $Menu['A002']['11'] = array("일정관리",_ADMIN_."/_schedule/");
// $Menu['A002']['12'] = array("임시메모",_ADMIN_."/_notes/");
// $Menu['A002']['13'] = array("관리자비밀번호변경",_ADMIN_."/_manager/pwdchange.php");

// $Menu['A']['A003'] = array("로그분석",_ADMIN_."/_log/today.php");
// $Menu['A003']['11'] = array("오늘접속",_ADMIN_."/_log/today.php");
// $Menu['A003']['12'] = array("방문자수",_ADMIN_."/_log/visitcount.php");
// $Menu['A003']['13'] = array("유입분석",_ADMIN_."/_log/referer.php");
// $Menu['A003']['14'] = array("페이지분석",_ADMIN_."/_log/page.php");
// $Menu['A003']['15'] = array("사용자환경",_ADMIN_."/_log/user.php");


$GNB['B'] = "<img src='"._ADMIN_."/images/gnb/gnb5.gif'>";
$SNB['B'] = "<img src='"._ADMIN_."/images/snb/snb5.gif'>";
$Menu['B']['B001'] = array("커뮤니티",_ADMIN_."/board/notice.php");
$Menu['B001']['11'] = array("공지사항",_ADMIN_."/board/notice.php");
// $Menu['B001']['12'] = array("FAQ",_ADMIN_."/board/faq.php");
// $Menu['B001']['13'] = array("자료실",_ADMIN_."/board/data.php");
$Menu['B001']['14'] = array("수강후기",_ADMIN_."/board/counsel02.php");
$Menu['B001']['15'] = array("소식통",_ADMIN_."/board/data2.php");
$Menu['B001']['16'] = array("취창업게시판",_ADMIN_."/board/data3.php");
$Menu['B001']['17'] = array("상담신청",_ADMIN_."/board/qna.php");
$Menu['B001']['18'] = array("동아리개설신청",_ADMIN_."/board/Application.php");

$Menu['B001']['19'] = array("동아리목록",_ADMIN_."/board/data4.php");
/*
$Menu['B001']['12'] = array("상담문의",_ADMIN_."/board/counsel.php");
$Menu['B001']['13'] = array("포토갤러리",_ADMIN_."/board/gallery.php");
$Menu['B001']['14'] = array("교육수강후기",_ADMIN_."/board/counsel02.php");
*/

/*
$GNB['C'] = "<img src='"._ADMIN_."/images/gnb/gnb6.gif'>";
$SNB['C'] = "<img src='"._ADMIN_."/images/snb/snb6.gif'>";

$Menu['C']   ['C001'] = array("고객센터"            ,_ADMIN_."/board/faq.php");
$Menu['C001']['11']   = array("자주하는질문"      ,_ADMIN_."/board/faq.php");
$Menu['C001']['12']   = array("English"            ,_ADMIN_."/board/english.php");
*/

$GNB['D'] = "<img src='"._ADMIN_."/images/gnb/gnb1.gif'>";
$SNB['D'] = "<img src='"._ADMIN_."/images/snb/snb1.gif'>";
/*
$Menu['D']['D001'] = array("프로그램 일정"				,_ADMIN_."/board/programUse.php");
$Menu['D001']['11'] = array("이용안내 - 주간"			,_ADMIN_."/board/programUse.php");
$Menu['D001']['12'] = array("주간캘린더"			,_ADMIN_."/board/program.php");
$Menu['D001']['13'] = array("프리미엄GB스쿨"		,_ADMIN_."/board/program02.php");
$Menu['D001']['14'] = array("프로그램일정표"		,_ADMIN_."/board/program03.php");

$Menu['D']['D002'] = array("프로그램 게시판"      ,_ADMIN_."/board/programBoard.php");
$Menu['D002']['11'] = array("산모&아기프로그램"		,_ADMIN_."/board/programBoard.php");
$Menu['D002']['12'] = array("이벤트/특강"				,_ADMIN_."/board/programBoard02.php");
$Menu['D002']['13'] = array("데모강좌보기",_ADMIN_."/board/gallery02.php");
*/
// $Menu['D']   ['D001'] = array("학점은행제"            ,_ADMIN_."/board/schedule.php");
// $Menu['D001']['11']   = array("학점은행제"            ,_ADMIN_."/board/schedule.php");

$Menu['D']['D001'] = array("수강신청 및 과목관리"      ,_ADMIN_."/board/schedule02.php");
$Menu['D001']['11'] = array("수강신청 및 과목관리"		,_ADMIN_."/board/schedule02.php");
// $Menu['D003']['12'] = array("심리평가 및 상담의 이해와 실습"		,_ADMIN_."/board/schedule03.php");
// $Menu['D003']['13'] = array("상담학아카데미 인턴십"		,_ADMIN_."/board/schedule04.php");
// $Menu['D003']['14'] = array("특강"		,_ADMIN_."/board/schedule05.php");
// $Menu['D001']['12'] = array("대관신청"		,_ADMIN_."/board/schedule06.php");

// $Menu['D']['D002'] = array("연혁관리"      ,_ADMIN_."/board/programBoard.php");
// $Menu['D002']['11'] = array("연혁"		,_ADMIN_."/board/programBoard.php");
// $Menu['D002']['12'] = array("역대원장"		,_ADMIN_."/board/programBoard02.php");

$GNB['E'] = "<img src='"._ADMIN_."/images/gnb/gnb3.gif'>";
$SNB['E'] = "<img src='"._ADMIN_."/images/snb/snb3.gif'>";
$Menu['E']['E001'] = array("회원관리",_ADMIN_."/_member/member.php");
$Menu['E001']['11'] = array("회원목록",_ADMIN_."/_member/member.php");



/*====================================================================================================
◈ gnb 메뉴순서
----------------------------------------------------------------------------------------------------*/
$GnbSort = array("D","B","C","E","A"); // 배열순서대로

/*====================================================================================================
◈ 메뉴생성
----------------------------------------------------------------------------------------------------*/
$pageCategory = null;
if(isset($pagecode))	$pageCategory = substr($pagecode,0,1);


$top_menu  = $snb_menu = null;
$snb_menu = ($pageCategory)? "<h2>".$SNB[$pageCategory]."</h2>" : "<h2>".$SNB['0']."</h2>";

if($pageCategory){
  $depth2 = substr($pagecode,0,4);
  $depth3 = substr($pagecode,4,2);
  $snb_menu .= "<ul>";
  foreach($Menu[$pageCategory] as $MenuKey => $MenuValue){
    $snb_menu .= "<li class='depth1'><a href='".$MenuValue[1]."'>".$MenuValue[0]."</a></li>";
    if($Menu[$MenuKey]){
      foreach($Menu[$MenuKey] as $SubMenuKey => $SubMenuValue){
        if(($SubMenuKey == $depth3) && ($MenuKey == $depth2)){
          $pageTitle = $SubMenuValue[0];
          $snb_class = "depth2_on";
        }else{
          $snb_class = "depth2";
        }
        $snb_menu .= "<li class='$snb_class'><a href='".$SubMenuValue[1]."'>".$SubMenuValue[0]."</a></li>";

      }
    }
  }
  foreach($GnbSort as $pgkey => $pgvalue){
    $top_menu .= "<li><a href=\"".$Menu[$pgvalue][$pgvalue.'001']['1']."\">".$GNB[$pgvalue]."</a></li>";
  }
  $snb_menu .= "</ul>";
}else{
  $snb_menu .= "<ul>";
  foreach($GnbSort as $pgkey => $pgvalue){
    foreach($Menu[$pgvalue] as $MenuKey => $MenuValue){
      $snb_menu .= "<li class='depth1'><a href='".$MenuValue[1]."'>".$MenuValue[0]."</a></li>";
      if($Menu[$MenuKey]){
        foreach($Menu[$MenuKey] as $SubMenuKey => $SubMenuValue){
          $snb_menu .= "<li class='depth2'><a href='".$SubMenuValue[1]."'>".$SubMenuValue[0]."</a></li>";
        }
      }
    }
    $top_menu .= "<li><a href=\"".$Menu[$pgvalue][$pgvalue.'001']['1']."\">".$GNB[$pgvalue]."</a></li>";
  }
  $snb_menu .= "</ul>";
}

$snb_menu .= "<div class=\"btm\"></div>";


$db = new MySQL;
$site = $db -> SelectOne("Select * from G__Site order by idx desc limit 1 ");
?>