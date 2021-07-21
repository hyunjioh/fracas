<div>
<ul class="vertical-list">
	<?
		$thispage = basename(dirname($_SERVER['SCRIPT_NAME']));
		$sub_menu_01 = $sub_menu_02 = $sub_menu_03 = $sub_menu_04 = $sub_menu_05 = null;
		$this_menu_icon = "<img src=\"../images/warning.png\" align=\"middle\" class=\"png24\">";
	?>
	<?
		if($thispage == "client"){
	?>
	<li><a href='<?=_ADMIN_?>/client/' class='button over' ><?=$this_menu_icon?> 고객관리</a></li>
	<?
		}
	?>
	<?
		if($thispage == "product"){
	?>
	<li><a href='<?=_ADMIN_?>/product/' class='button over' ><?=$this_menu_icon?> 오늘상품</a></li>
	<?
		}
	?>
	<?
		if($thispage == "product_ext"){
	?>
	<li><a href='<?=_ADMIN_?>/product_ext/' class='button over' ><?=$this_menu_icon?> 연장상품</a></li>
	<?
		}
	?>
	<?
		if($thispage == "product_old"){
	?>
	<li><a href='<?=_ADMIN_?>/product_old/' class='button over' ><?=$this_menu_icon?> 지난상품</a></li>
	<?
		}
	?>
</ul>
</div>