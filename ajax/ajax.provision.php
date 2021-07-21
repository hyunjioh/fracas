<?
include_once "../inc/pub.config.php";
?>
<div class="__popBasic _popAjax">
	<div class="inner">
		<div class="title">
			<h3>이용약관</h3>
			<button type="button" class="close _close" onclick="ajaxClose('._popAjax');">CLOSE</button>
		</div>
		<div class="wrap privacy">
			<?include_once PATH.'/inc/provision.php';?>
		</div>
	</div>
	<div class="bg _close" onclick="ajaxClose('._popAjax');"></div>
</div>