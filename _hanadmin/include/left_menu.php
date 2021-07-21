<script>

$(document).ready(function($){
//	$("#LeftMenuHide").css("cursor","pointer");
//$("#LeftMenuShow").css("cursor","pointer");
//	$("#LeftMenuShow").hide();
//	$("#LeftMenuHide").click(function(){
//		$("#container").animate({"left": "-=130px"}, "fast");
//		$("#LeftMenuHide").hide();
//		$("#LeftMenuShow").show();
//	});
//	$("#LeftMenuShow").click(function(){
//		$("#container").animate({"left": "+=130px"}, "fast");
//		$("#LeftMenuHide").show();
//		$("#LeftMenuShow").hide();
//	});
});
</script>
<div id="left-menu">
<ul class="vertical-list">
	<?
		$thispage = basename(dirname($_SERVER['SCRIPT_NAME']));
		$sub_menu_01 = $sub_menu_02 = $sub_menu_03 = $sub_menu_04 = $sub_menu_05 = null;
		$this_menu_icon = "<img src=\"../images/warning.png\" align=\"middle\" class=\"png24\">";

		$LeftMenuIndex=0;
		$leftmenu[$LeftMenuIndex][_log] = array("로그분석", _ADMIN_."/_log/");
		$leftmenu[$LeftMenuIndex][_schedule] = array("일정관리", _ADMIN_."/_schedule/");
		$leftmenu[$LeftMenuIndex][_manager_board] = array("관리자게시판", _ADMIN_."/_manager_board/");
		$leftmenu[$LeftMenuIndex][_manager] = array("정보변경", _ADMIN_."/_manager/");

		$LeftMenuIndex++;
		$leftmenu[$LeftMenuIndex][_notice] = array("공지사항", _ADMIN_."/_notice/");
		$leftmenu[$LeftMenuIndex][_faq]    = array("FAQ", _ADMIN_."/_faq/");
		$leftmenu[$LeftMenuIndex][_qna]    = array("Q&A", _ADMIN_."/_qna/");
		$leftmenu[$LeftMenuIndex][_counsel] = array("1 : 1 고객상담", _ADMIN_."/_counsel/");

		$LeftMenuIndex++;
		$leftmenu[$LeftMenuIndex][_member] = array("회원관리", _ADMIN_."/_member/");		
		$leftmenu[$LeftMenuIndex][_point] = array("포인트관리", _ADMIN_."/_point/");		

		$LeftMenuIndex++;
		$leftmenu[$LeftMenuIndex][product] = array("상품관리", _ADMIN_."/product/");	
		
		$LeftMenuIndex++;
		$leftmenu[$LeftMenuIndex][order] = array("주문관리", _ADMIN_."/order/");		

		$LeftMenuIndex++;
		$leftmenu[$LeftMenuIndex][_popup] = array("팝업관리", _ADMIN_."/_popup/");		
	?>
	<?
		for($memuIndex = 0; $memuIndex <= $LeftMenuIndex; $memuIndex++){
			if(in_array($thispage, array_keys($leftmenu[$memuIndex]))){
				$SelectLeftMenu = $leftmenu[$memuIndex];
				foreach($SelectLeftMenu as $LmKey => $LmValue){
					$LeftMenuClass = ($LmKey == $thispage)? "over" : "";
					$LeftMenuIcon = ($LmKey == $thispage)? $this_menu_icon : "";
	?>
	<li><a href='<?=$LmValue[1]?>' class='button <?=$LeftMenuClass?>' ><?=$LeftMenuIcon?> <?=$LmValue[0]?></a></li>
	<?
				}
				break;
			}
		}
	?>
	<li><a href='<?=_ADMIN_?>/Logout.php' class='button' style="color:yellow">로그아웃</a></li>
</ul>
<center><span style="display:block; font-size:12px; font-family:tahoma; margin-top:5px" ><span id="LeftMenuHide"> &lt;&lt; </span><?=ip_addr();?><span id="LeftMenuShow"> &gt;&gt; </span></span>
<?
if(ip_addr() == _DEV_IP_) echo " <img src='"._ADMIN_."/images/icon_setting.png' align='middle' style='cursor:pointer' onclick='setup(\""._ADMIN_."/_setup/"."\");'>";
?>
</center>
</div>