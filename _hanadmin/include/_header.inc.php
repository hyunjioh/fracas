<?
if(!defined("_administrators_")) 	define("_administrators_",true);
require_once "../../_core/_lib.php";
require_once "../include/manager.inc.php";
if(!defined("_is_manager_"))	toplocationHref( _ADMIN_);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<title><?=_HOMEPAGE_TITLE_?></title>
<link rel="stylesheet" type="text/css" href="../css/default.css" />
<link rel="stylesheet" type="text/css" href="../css/contents.css" />
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/common.js"></script>
<script type='text/javascript' src='<?=_CORE_?>/js/jquery-ui-1.8.16.custom.min.js'></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/themes/base/jquery.ui.all.css">
<script type="text/javascript">
jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '년'};
	$.datepicker.setDefaults($.datepicker.regional['ko']);
});


$.datepicker.setDefaults({
	dateFormat : "yy-mm-dd" ,
   showOn: 'both',
   buttonImageOnly: true,
   buttonImage: '../images/search/calendar.png',
   buttonText: 'Calendar' 
});
</script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.tools.min.js"></script><!-- jquery Tools (overlay) -->
<script type="text/javascript" src="<?=_ADMIN_?>/include//js/overlay.js"></script>