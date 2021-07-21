	<?
		if($type == "comment") $func = "CommentPage";
		else  $func = "goPage";
		if($pagetype == "inline"){
			$totalpage = ceil($TOTAL/$Board['page_limit']);	
			//시작 페이지 번호 설정
			if ( $req['pagenumber'] % $Board['page_block'] == 0 ) $startpage = $req['pagenumber'] - ( $Board['page_block'] - 1 );
			else $startpage = intval( $req['pagenumber'] / $Board['page_block'] ) * $Board['page_block'] + 1;

			$prevpage = $startpage - 1; // 이전 페이지 설정
			$nextpage = $startpage + $Board['page_block']; // 다음 페이지 설정

			$lastpage = $startpage + ($Board['page_block'] - 1);
			if($lastpage > $totalpage)$lastpage = $totalpage;

			//마지막 페이징 번호 설정
			if ( $totalpage / $Board['page_block'] > 1 ) $laststartpage = (intval($totalpage / $Board['page_block']) * $Board['page_block'] ) + 1;
			else $laststartpage = 1;


			if ( $req['pagenumber'] > $Board['page_block'] ) echo " <a href='javascript:$func(1);'>".$cfg['btn_first']."</a> ";
			else echo " ".$cfg['btn_first']." ";

			if ( $totalpage > $Board['page_block'] && $req['pagenumber'] > $Board['page_block'] ) echo " <a href='javascript:$func(".$prevpage.");'>".$cfg['btn_prev']."</a> ";
			else echo " ".$cfg['btn_prev']." ";



			echo "&nbsp;";
			if ( $totalpage <= 1 ) {
					echo "<span style='font-size: 10pt; font-weight:bold; '>1</span>";
			} else {
				// 페이지 링크 번호 나열
				if($startpage < 1 )$startpage = 1;
				for ( $i = $startpage ; $i <= ($startpage + ($Board['page_block'] - 1) ) ; $i++ ) {
						
					if( $req['pagenumber'] != $i ) echo " <a href='javascript:$func(".$i.")' class='pagenum'>".$i."</a> ";
					else	echo " <span style='font-size: 10pt; font-weight:bold; color:red;'>".$i."</span> ";
						
					if($i < $lastpage) echo "".$cfg['page_sp'].""; // 페이지 번호사이의 구분자
					if ( $i >= $totalpage ) {
						break;
					}
				}
			}	
			echo "&nbsp;"; 


			if ( $startpage + $Board['page_block'] - 1 < $totalpage) echo " <a href='javascript:$func(".$nextpage.")'>".$cfg['btn_next']."</a> ";
			else echo " ".$cfg['btn_next']." ";

			if ( $req['pagenumber'] < intval($laststartpage) ) echo " <a href='javascript:$func(".$totalpage.");'>".$cfg['btn_last']."</a>";
			else 	echo " ".$cfg['btn_last']." ";

		
		}else{
			echo "<table border='0' cellpadding='0' cellspacing='0' align='center'><tr><td>";

			$totalpage = ceil($TOTAL/$Board['page_limit']);	
			//시작 페이지 번호 설정
			if ( $req['pagenumber'] % $Board['page_block'] == 0 ) $startpage = $req['pagenumber'] - ( $Board['page_block'] - 1 );
			else $startpage = intval( $req['pagenumber'] / $Board['page_block'] ) * $Board['page_block'] + 1;

			$prevpage = $startpage - 1; // 이전 페이지 설정
			$nextpage = $startpage + $Board['page_block']; // 다음 페이지 설정

			$lastpage = $startpage + ($Board['page_block'] - 1);
			if($lastpage > $totalpage)$lastpage = $totalpage;

			//마지막 페이징 번호 설정
			if ( $totalpage / $Board['page_block'] > 1 ) $laststartpage = (intval($totalpage / $Board['page_block']) * $Board['page_block'] ) + 1;
			else $laststartpage = 1;


			if ( $req['pagenumber'] > $Board['page_block'] ) echo " <a href='javascript:$func(1);'>".$cfg['btn_first']."</a> ";
			else echo " ".$cfg['btn_first']." ";

			if ( $totalpage > $Board['page_block'] && $req['pagenumber'] > $Board['page_block'] ) echo " <a href='javascript:$func(".$prevpage.");'>".$cfg['btn_prev']."</a> ";
			else echo " ".$cfg['btn_prev']." ";

			echo "</td>";


			echo "<td style='font-family:arial; font-size:9pt; padding-bottom:5px'>";
			echo "&nbsp;";
			if ( $totalpage <= 1 ) {
					echo "<span style='font-size: 10pt; font-weight:bold; '>1</span>";
			} else {
				// 페이지 링크 번호 나열
				if($startpage < 1 )$startpage = 1;
				for ( $i = $startpage ; $i <= ($startpage + ($Board['page_block'] - 1) ) ; $i++ ) {
						
					if( $req['pagenumber'] != $i ) echo " <a href='javascript:$func(".$i.")' class='pagenum'>".$i."</a> ";
					else	echo " <span style='font-size: 10pt; font-weight:bold; color:;'>".$i."</span> ";
						
					//if($i < $lastpage) echo "&nbsp;".$cfg['page_sp']."&nbsp;"; // 페이지 번호사이의 구분자
					if ( $i >= $totalpage ) {
						break;
					}
				}
			}	
			echo "&nbsp;"; 
			echo "</td>";		

			echo "<td>";

			if ( $startpage + $Board['page_block'] - 1 < $totalpage) echo " <a href='javascript:$func(".$nextpage.")'>".$cfg['btn_next']."</a> ";
			else echo " ".$cfg['btn_next']." ";

			if ( $req['pagenumber'] < intval($laststartpage) ) echo " <a href='javascript:$func(".$totalpage.");'>".$cfg['btn_last']."</a>";
			else 	echo " ".$cfg['btn_last']." ";


			echo "</td></tr></table>";
		}
?>