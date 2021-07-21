<?
include_once "../inc/pub.config.php";
?>
<div class="__popBasic _popAjax">
	<div class="inner">
		<div class="title">
			<h3>개인정보 취급방침</h3>
			<button type="button" class="close _close" onclick="ajaxClose('._popAjax');">CLOSE</button>
		</div>
		<div class="wrap privacy">
			<?include_once PATH.'/inc/privacy.php';?>
		</div>
	</div>
	<div class="bg _close" onclick="ajaxClose('._popAjax');"></div>
</div>