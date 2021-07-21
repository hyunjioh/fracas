<?
    $PageSkin = ($Board['page_skin']) ? $Board['page_skin'] : "type1";
    $req['page_block'] = $Board['page_block'];
    $req['page_limit'] = $Board['page_limit'];
    $cfg['btn_first'] = "맨앞";
    $cfg['btn_prev']  = "이전";
    $cfg['btn_next']  = "다음";
    $cfg['btn_last']  = "맨뒤";



    if($TOTAL > 0){
      $func = (!$func)? "goPage" : $func;
      $req['pagenumber']   = (!$req['pagenumber'])? 1 : $req['pagenumber'];
      $req['page_limit']   = (!$req['page_limit'])? 1: $req['page_limit'];
      $req['page_block']   = (!$req['page_block'])? 10: $req['page_block'];

      // 전체 페이지
      $totalpage = ceil($TOTAL/$req['page_limit']);

      // 시작페이지
      if ( $req['pagenumber'] % $req['page_block'] == 0 ) $startpage = $req['pagenumber'] - ( $req['page_block'] - 1 );
      else $startpage = intval( $req['pagenumber'] / $req['page_block'] ) * $req['page_block'] + 1;

       // 이전 페이지 설정
      $prevpage = $startpage - 1;

      // 다음 페이지 설정
      $nextpage = $startpage + $req['page_block'];

      // 블럭내 마지막 페이지
      $lastpage = $startpage + ($req['page_block'] - 1);
      if($lastpage > $totalpage)$lastpage = $totalpage;

      //전체 마지막페이지
      if ( $totalpage / $req['page_block'] > 1 ) $laststartpage = (intval($totalpage / $req['page_block']) * $req['page_block'] ) + 1;
      else $laststartpage = 1;
    }
?>
<?
if($TOTAL > 0){
/*******************************************************************************
 *
 * page navi skin
 *
 ******************************************************************************/
switch($PageSkin):

/*******************************************************************************
 *
 * skin 1
 *
 ******************************************************************************/
case "type1":
  $cfg['btn_first'] = "<img src=\"../images/btn/page1_btn_first.gif\" alt=\"처음\" /> ";
  $cfg['btn_prev']  = "<img src=\"../images/btn/page1_btn_prev.gif\" alt=\"이전10\" /> ";
  $cfg['btn_next']  = " <img src=\"../images/btn/page1_btn_next.gif\" alt=\"다음10\" />";
  $cfg['btn_last']  = " <img src=\"../images/btn/page1_btn_last.gif\" alt=\"마지막\" />";
  echo "<div class=\"page1\">";

  /*-------------------------------------------------------------------------------------------------
  ▶ 맨 처음으로 */
  if($cfg['btn_first'] != ""){
    if ( $req['pagenumber'] > $req['page_block'] ) echo " <a href='javascript:$func(1);' class=\"btn\">".$cfg['btn_first']."</a>";
    else echo "<a href=\"#\" class=\"btn\">".$cfg['btn_first']."</a>";
  }

  /*-------------------------------------------------------------------------------------------------
  ▶ 이전 10 */
  if ( $totalpage > $req['page_block'] && $req['pagenumber'] > $req['page_block'] ) echo " <a href='javascript:$func(".$prevpage.");'>".$cfg['btn_prev']."</a>";
  else echo "<a href=\"#\">".$cfg['btn_prev']."</a>";

  /*-------------------------------------------------------------------------------------------------
  ▶ 페이징 리스트 */
  if ( $totalpage <= 1 ) {
      echo "<span class=\"cur_page\">1</span>";
  } else {
    // 페이지 링크 번호 나열
    if($startpage < 1 )$startpage = 1;
    for ( $i = $startpage ; $i <= ($startpage + ($req['page_block'] - 1) ) ; $i++ ) {

      if( $req['pagenumber'] != $i ) echo "<a href='javascript:$func(".$i.")'>".$i."</a>";
      else	echo "<span class=\"cur_page\">$i</span>";

      if($i < $lastpage) echo "".$cfg['page_sp'].""; // 페이지 번호사이의 구분자
      if ( $i >= $totalpage ) {
        break;
      }
    }
  }

  /*-------------------------------------------------------------------------------------------------
  ▶ 다음 10 */
  if ( $startpage + $req['page_block'] - 1 < $totalpage) echo " <a href='javascript:$func(".$nextpage.")' >".$cfg['btn_next']."</a>";
  else echo "<a href=\"#\">".$cfg['btn_next']."</a>";

  /*-------------------------------------------------------------------------------------------------
  ▶ 맨 끝으로 */
  if($cfg['btn_last'] != ""){
    if ( $req['pagenumber'] < intval($laststartpage) ) echo " <a href='javascript:$func(".$totalpage.");' class=\"btn\">".$cfg['btn_last']."</a>";
    else 	echo "<a href=\"#\" class=\"btn\">".$cfg['btn_last']."</a>";
  }
break;



/*******************************************************************************
 *
 * skin 2
 *
 ******************************************************************************/
case "type2":
  $cfg['btn_first'] = "<img src=\"../images/btn/page2_btn_first.gif\" alt=\"처음\" /> ";
  $cfg['btn_prev']  = "<img src=\"../images/btn/page2_btn_prev.gif\" alt=\"이전10\" />";
  $cfg['btn_next']  = "<img src=\"../images/btn/page2_btn_next.gif\" alt=\"다음10\" />";
  $cfg['btn_last']  = " <img src=\"../images/btn/page2_btn_last.gif\" alt=\"마지막\" />";
  echo "<div class=\"page2\">";

  /*-------------------------------------------------------------------------------------------------
  ▶ 맨 처음으로 */
  if($cfg['btn_first'] != ""){
    echo "<span class=\"btn\">";
    if ( $req['pagenumber'] > $req['page_block'] ) echo "<a href='javascript:$func(1);' >".$cfg['btn_first']."</a>";
    else echo "<a href=\"#\">".$cfg['btn_first']."</a>";
    echo "</span>";
  }

  /*-------------------------------------------------------------------------------------------------
  ▶ 이전 10 */
  echo "<span class=\"btn\">";
  if ( $totalpage > $req['page_block'] && $req['pagenumber'] > $req['page_block'] ) echo "<a href='javascript:$func(".$prevpage.");'>".$cfg['btn_prev']."</a>";
  else echo "<a href=\"#\">".$cfg['btn_prev']."</a>";
  echo "</span>";

  /*-------------------------------------------------------------------------------------------------
  ▶ 페이징 리스트 */

  echo "<ul>";
  if ( $totalpage <= 1 ) {
      echo "<li class=\"bg_none\">1</li>";
  } else {
    // 페이지 링크 번호 나열
    if($startpage < 1 )$startpage = 1;
    for ( $i = $startpage ; $i <= ($startpage + ($req['page_block'] - 1) ) ; $i++ ) {
      $firtclass = ($i == $startpage)? " class=\"bg_none\" " : "" ;
      $firtclass2 = ($i == $startpage)? " bg_none " : "" ;
      if( $req['pagenumber'] != $i ) echo "<li $firtclass><a href='javascript:$func(".$i.")'>".$i."</a></li>";
      else	echo "<li class=\"cur_page $firtclass2\">$i</li>";

      //if($i < $lastpage) echo "".$cfg['page_sp'].""; // 페이지 번호사이의 구분자
      if ( $i >= $totalpage ) {
        break;
      }
    }
  }
  echo "</ul>";

  /*-------------------------------------------------------------------------------------------------
  ▶ 다음 10 */
  echo "<span class=\"btn\">";
  if ( $startpage + $req['page_block'] - 1 < $totalpage) echo "<a href='javascript:$func(".$nextpage.")' >".$cfg['btn_next']."</a>";
  else echo "<a href=\"#\">".$cfg['btn_next']."</a>";
  echo "</span>";

  /*-------------------------------------------------------------------------------------------------
  ▶ 맨 끝으로 */
  if($cfg['btn_last'] != ""){
    echo "<span class=\"btn\">";
    if ( $req['pagenumber'] < intval($laststartpage) ) echo "<a href='javascript:$func(".$totalpage.");' >".$cfg['btn_last']."</a>";
    else 	echo "<a href=\"#\">".$cfg['btn_last']."</a>";
    echo "</span>";
  }
break;


/*******************************************************************************
 *
 * skin 3
 *
 ******************************************************************************/
case "type3":
  $cfg['btn_first'] = "<img src=\"../images/btn/page3_btn_first.gif\" alt=\"처음\" /> ";
  $cfg['btn_prev']  = "<img src=\"../images/btn/page3_btn_prev.gif\" alt=\"이전10\" /> ";
  $cfg['btn_next']  = " <img src=\"../images/btn/page3_btn_next.gif\" alt=\"다음10\" />";
  $cfg['btn_last']  = " <img src=\"../images/btn/page3_btn_last.gif\" alt=\"마지막\" />";
  echo "<div class=\"page3\">";

  /*-------------------------------------------------------------------------------------------------
  ▶ 맨 처음으로 */
  if($cfg['btn_first'] != ""){
    if ( $req['pagenumber'] > $req['page_block'] ) echo " <a href='javascript:$func(1);' class=\"btn\">".$cfg['btn_first']."</a>";
    else echo "<a href=\"#\" class=\"btn\">".$cfg['btn_first']."</a>";
  }

  /*-------------------------------------------------------------------------------------------------
  ▶ 이전 10 */
  if ( $totalpage > $req['page_block'] && $req['pagenumber'] > $req['page_block'] ) echo " <a href='javascript:$func(".$prevpage.");' class=\"btn\">".$cfg['btn_prev']."</a>";
  else echo "<a href=\"#\" class=\"btn\">".$cfg['btn_prev']."</a>";

  /*-------------------------------------------------------------------------------------------------
  ▶ 페이징 리스트 */
  if ( $totalpage <= 1 ) {
      echo "<span class=\"cur_page\">1</span>";
  } else {
    // 페이지 링크 번호 나열
    if($startpage < 1 )$startpage = 1;
    for ( $i = $startpage ; $i <= ($startpage + ($req['page_block'] - 1) ) ; $i++ ) {

      if( $req['pagenumber'] != $i ) echo "<a href='javascript:$func(".$i.")' >".$i."</a>";
      else	echo "<span class=\"cur_page\">$i</span>";

      if($i < $lastpage) echo "".$cfg['page_sp'].""; // 페이지 번호사이의 구분자
      if ( $i >= $totalpage ) {
        break;
      }
    }
  }

  /*-------------------------------------------------------------------------------------------------
  ▶ 다음 10 */
  if ( $startpage + $req['page_block'] - 1 < $totalpage) echo " <a href='javascript:$func(".$nextpage.")' class=\"btn\">".$cfg['btn_next']."</a>";
  else echo "<a href=\"#\" class=\"btn\">".$cfg['btn_next']."</a>";

  /*-------------------------------------------------------------------------------------------------
  ▶ 맨 끝으로 */
  if($cfg['btn_last'] != ""){
    if ( $req['pagenumber'] < intval($laststartpage) ) echo " <a href='javascript:$func(".$totalpage.");' class=\"btn\">".$cfg['btn_last']."</a>";
    else 	echo "<a href=\"#\" class=\"btn\">".$cfg['btn_last']."</a>";
  }
break;


/*******************************************************************************
 *
 * End
 *
 ******************************************************************************/
endswitch;
}
?>