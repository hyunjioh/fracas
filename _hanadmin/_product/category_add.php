<?
	if(!defined("_g_board_include_")) exit; 
$req['category']	= Request('category');
$req['Gubun']			= Request('gubun');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> 카테고리 </title>
	<!-- [e] title -->
	<link rel="stylesheet" type="text/css" href="<?=_ADMIN_?>/css/style.css" />
	<script type="text/javascript">
	function goDepth1(){
		if(jQuery.trim($("input[name=Name]").val()) == ""){
			alert("카테고리명을 입력하세요.");
			$("input[name=Name]").focus();
			return false;
		}
	}	

	function goDepth2(){
		if(jQuery.trim($("input[name=Name]").val()) == ""){
			alert("카테고리명을 입력하세요.");
			$("input[name=Name]").focus();
			return false;
		}
		if(!$("#Category1").val()){
			alert("카테고리1을 선택하지 않았습니다.");
			return false
		}
		$("input[name=Depth1]").val($("#Category1").val());
	}	


	function goDepth3(){
		if(jQuery.trim($("input[name=Name]").val()) == ""){
			alert("카테고리명을 입력하세요.");
			$("input[name=Name]").focus();
			return false;
		}
		if(!$("#Category1").val()){
			alert("카테고리1을 선택하지 않았습니다.");
			return false
		}
		if(!$("#Category2").val()){
			alert("카테고리2을 선택하지 않았습니다.");
			return false
		}
		$("input[name=Depth1]").val($("#Category1").val());
		$("input[name=Depth2]").val($("#Category2").val());
	}	




	</script>
	<style>

	</style>
	</head>
	<body>
		<?
			if($req['category'] =="depth1"){
		?>
		<form name="gform"  method="post"  id="gform" action="<?=$Board['Link']?>?at=dataprocess" onsubmit="return goDepth1();">
		<input type="hidden" name="at" value="dataprocess">
		<input type="hidden" name="am" value="Depth1">
		<input type="hidden" name="gubun" value="<?=$req['Gubun']?>">
		<div id="popupLayer" class="overlay_popup">
			<div class="titlebox">
				<h1>카테고리1추가</h1>
			</div>
			<p class="txt">
				<!--
				<span>※</span> 극장명을 입력하세요..
				-->
			</p>
			<div class="authForm">
				<strong>카테고리명</strong>
				<input type="text" name="Name" class="input"  />
				<input type="image" src="../images/btn_confirm.gif"/>
			</div>
			<div class="btn">

			</div>
		</div> 
		</form>
		<?
			}	
		?>


		<?
			if($req['category'] =="depth2"){
		?>
		<form name="gform"  method="post"  id="gform" action="<?=$Board['Link']?>?at=dataprocess" onsubmit="return goDepth2();">
		<input type="hidden" name="at" value="dataprocess">
		<input type="hidden" name="am" value="Depth2">
		<input type="hidden" name="gubun" value="<?=$req['Gubun']?>">
		<input type="hidden" name="Depth1">
		<div id="popupLayer" class="overlay_popup">
			<div class="titlebox">
				<h1>카테고리2추가</h1>
			</div>
			<p class="txt">
				<!--
				<span>※</span> 극장명을 입력하세요..
				-->
			</p>
			<div class="authForm">
				<strong>카테고리명</strong>
				<input type="text" name="Name" class="input"  />
				<input type="image" src="../images/btn_confirm.gif"/>
			</div>
			<div class="btn">

			</div>
		</div> 
		</form>
		<?
			}	
		?>


		<?
			if($req['category'] =="depth3"){
		?>
		<form name="gform"  method="post"  id="gform" action="<?=$Board['Link']?>?at=dataprocess" onsubmit="return goDepth3();">
		<input type="hidden" name="at" value="dataprocess">
		<input type="hidden" name="am" value="Depth3">
		<input type="hidden" name="gubun" value="<?=$req['Gubun']?>">
		<input type="hidden" name="Depth1">
		<input type="hidden" name="Depth2">
		<div id="popupLayer" class="overlay_popup">
			<div class="titlebox">
				<h1>카테고리3추가</h1>
			</div>
			<p class="txt">
				<!--
				<span>※</span> 극장명을 입력하세요..
				-->
			</p>
			<div class="authForm">
				<strong>카테고리명</strong>
				<input type="text" name="Name" class="input"  />
				<input type="image" src="../images/btn_confirm.gif"/>
			</div>
			<div class="btn">

			</div>
		</div> 
		</form>
		<?
			}	
		?>


	</body>
</html>