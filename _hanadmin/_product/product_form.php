<?
  if(!defined("_g_board_include_")) exit;
	$token = new_token($Board['board_id']);
  require_once "../include/_header.inc.php";

	if($req['idx']){
		if($req[at] == "modify"){
			$mode = "ProductModify";
			$pageTitle = "상품수정";
		}else{
			$mode = "ProductCopy";
			$pageTitle = "상품복사";
		}
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where idx = ".$req['idx']);
		if(!$Value)	locationReplace($Board['Link']);	
		$href = $href."&idx=".$req['idx'];

		$Value['Option1Name'] = explode("^^",$Value['Option1Name']);
		$Value['Option1Cnt'] = explode("^^",$Value['Option1Cnt']);
		$Value['Option1Wonga'] = explode("^^",$Value['Option1Wonga']);
		$Value['Option1OrgPrice'] = explode("^^",$Value['Option1OrgPrice']);
		$Value['Option1SalePrice'] = explode("^^",$Value['Option1SalePrice']);
		$Value['Option1SaleRatio'] = explode("^^",$Value['Option1SaleRatio']);
		$Value['Option2Name'] = explode("^^",$Value['Option2Name']);
		$Value['Option2Parent'] = explode("^^",$Value['Option2Parent']);
		$Value['Option2Cnt'] = explode("^^",$Value['Option2Cnt']);
		$Value['Option2Wonga'] = explode("^^",$Value['Option2Wonga']);
		$Value['Option2OrgPrice'] = explode("^^",$Value['Option2OrgPrice']);
		$Value['Option2SalePrice'] = explode("^^",$Value['Option2SalePrice']);
		$Value['Option2SaleRatio'] = explode("^^",$Value['Option2SaleRatio']);

    $PCategory1 = $Value['PCategory1'];
    $PCategory2 = $Value['PCategory2'];
    $PCategory3 = $Value['PCategory3'];
	}else{
		$pageTitle = "신규등록";
		$token = new_token($Board['board_id']);
		$mode = "ProductAdd";

		$Value['SaleStatus'] = "ready";
    $Value['Pcode'] = null;
    $Value['ProdTitle'] = null;
    $value['Name'] = null;
    $Value['ProdImage01'] = null;
    $Value['ProdInfo01'] = null;
    $Value['ProdInfo02'] = null;
    $Value['ProdInfo03'] = null;
    $Value['ProdInfo04'] = null;
    $Value['SortNum']    = null;
    $Value['ProdMemo1']  = null;
    $PCategory1 =  $PCategory2 = $PCategory3 = null;
	}


?>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/themes/base/jquery.ui.all.css">
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.clockpick.1.2.7/jquery.clockpick.1.2.7.js"></script>
<link rel="stylesheet" href="<?=_CORE_?>/js/jquery.clockpick.1.2.7/jquery.clockpick.1.2.7.css" type="text/css">
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.tools.min.js"></script>
<script src="<?=_CORE_?>/js/imagePreview.js" type="text/javascript"></script>

<script type="text/javascript" src="<?=_CORE_?>/plugin/ckeditor_3.6.2/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
  var f = document.boardform;
  if(!f.Subject.value){
    alert("제목을 입력하세요.");
    f.Subject.focus();
    return false;
  }
}



	function Category1Select(){
	 $("#Region1").hide();
	 $("#Region2").hide();
	 $("#select1").html('');
	 $("#select2").html('');
 	 $.ajax({
		 type: "POST",
		 url: "<?=$Board['Link']?>?at=dataprocess",
		 data: "am=CategoryList1&depth1="+$('#Category1').val(),
		 success: function(msg){
			 $("#Region1").fadeIn();
			 $("#select1").html(msg);

		 }
	 });	
	}

	function Category2Select(){
	 $("#Region2").hide();
	 $("#select2").html('');
 	 $.ajax({
		 type: "POST",
		 url: "<?=$Board['Link']?>?at=dataprocess",
		 data: "am=CategoryList2&depth1="+$('#Category1').val()+"&depth2="+$('#Category2').val(),
		 success: function(msg){
			 $("#Region2").fadeIn();
			 $("#select2").html(msg);
		 }
	 });	
	}


//]]>
</script>
<script type="text/javascript">
	//<![CDATA[

var editor;

function changeEnter()
{
	// If we already have an editor, let's destroy it first.
	if ( editor )
		editor.destroy( true );

	// Create the editor again, with the appropriate settings.
	editor = CKEDITOR.replace( 'ProdMemo1',
		{
			width:'700px',
			enterMode		: 2,
			shiftEnterMode	: 2,
			toolbar :
			[
				['Source','-','Bold', 'Italic', '-', 'TextColor','BGColor', '-', 'Link', 'Unlink'],
				['About']
			]

		});
		
}

window.onload = changeEnter;

$(function(){
  $("#Category1").val('<?=$PCategory1?>');
  $("#Category2").val('<?=$PCategory2?>');
  $("#Category3").val('<?=$PCategory3?>');

  if($("#Category2").length < 1)		Category1Select();
  if($("#Category3").length < 1)		Category2Select();
});

	//]]>
</script>
</head>
<?  require_once "../include/_body_top.inc.php"; ?>





    <form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
    <input type="hidden" name="token" value="<?=$token?>">
    <input type="hidden" name="Html"  value="Y">

    <input type="hidden" name="idx" value="<?=$req['idx']?>">
    <input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
    <input type="hidden" name="am" value="<?=$mode?>">
    <input type="hidden" name="_referer_" value="<?=$req['ref']?>">

    <input type="hidden" name="sdate" value="<?=$req['sdate']?>">
    <input type="hidden" name="edate" value="<?=$req['edate']?>">
    <input type="hidden" name="st" value="<?=$req['st']?>">		

    <input type="hidden" name="TotalRatio" value="">		

    <input type="hidden" name="P_Pcode" value="<?=$Value['Pcode']?>">		







      <!-- list -->

		<table cellspacing="0" cellpadding="0" class="formtable">
			<?
				if($Value['Pcode']){
			?>
			<tr>
				<th class="tableth " style="width:120px">상품코드</th>
				<td class="tabletd left" colspan="3"><?=$Value['Pcode']?></td>
			</tr>
			<?
				}	
			?>

		</table>
		<div class="rightbtn"></div>
		<table cellspacing="0" cellpadding="0" class="formtable">
			<tr>
				<th class="tableth " style="width:120px; ">상품명</th>
				<td class="tabletd left" colspan="3"><input type="text" name="ProdTitle" value="<?=$Value['ProdTitle']?>" class="input" style="width:500px;font-size:1.5em; font-weight:bold"></td>
			</tr>
			<tr>
				<th class="tableth " >카테고리</th>
				<td class="tabletd left" colspan="3">

				<div style="display:inline ">
				<select name='PCategory1'		id="Category1" onChange="Category1Select();">
				<option value="">카테고리1을 선택하세요.</option>
				<?
					$Depth1 = $db -> SelectList("Select * from G_Product_Category Where Depth2 = '00' and Depth3 = '000' and Gubun='product' ");
					if($Depth1){
						foreach($Depth1 as $key => $value){
							echo "<option value='".$value['Depth1']."'>".$value['Name']."</option>";
						}
					}
				?>
				</select></div> 
				
				<div id="select1" style="display:inline ">
				<?
					if($PCategory2){
				?>
				<select name='PCategory2'		id='Category2' onChange='Category2Select();'>
				<option value="">카테고리2을 선택하세요.</option>
				<?
					$Depth2 = $db -> SelectList("Select * from G_Product_Category Where Depth1 = '".$PCategory1."' and Depth2 <> '00' and Depth3 = '000' and Gubun='product' ");
					if($Depth2){
						foreach($Depth2 as $key => $value){
							echo "<option value='".$value['Depth2']."'>".$value['Name']."</option>";
						}
					}
				?>
				</select>		
				<?
				}
				?>
				</div>
				
				<div id="select2" style="display:inline ">
				<?
					if($PCategory3){
				?>
				<select name='PCategory3'		id='Category3' >
				<option value="">카테고리3을 선택하세요.</option>
				<?
					$Depth3 = $db -> SelectList("Select * from G_Product_Category Where Depth1 = '".$PCategory1."' and Depth2 = '".$PCategory2."' and Depth3 <> '000' and Gubun='product' ");
					if($Depth3){
						foreach($Depth3 as $key => $value){
							echo "<option value='".$value['Depth3']."'>".$value['Name']."</option>";
						}
					}
				?>
				</select>		
				<?
				}
				?>		
				</div>


				</td>
			</tr>
			<tr>
				<th class="tableth" style="width:120px">상품이미지<br/><span style="font-weight:normal">270 x 242 </a></span></th>
				<td class="tabletd left" colspan="3">
				<? if($Value['ProdImage01']){ ?><a href="<?=$Value['ProdImage01']?>" class="preview" align="middle"><img src="<?=_ADMIN_?>/images/preview.png" /></a><? } ?>																				
				<input type="file" style="width:400px" name="ProdImage01" value="<?=$Value['ProdImage01']?>" class="input"></td>
			</tr>
			<tr>
				<th class="tableth " style="width:120px; ">품명</th>
				<td class="tabletd left" colspan="3"><input type="text" name="ProdInfo01" value="<?=$Value['ProdInfo01']?>" class="input" style="width:200px;font-size:1.5em; font-weight:bold"></td>
			</tr>
			<tr>
				<th class="tableth " style="width:120px; ">원산지</th>
				<td class="tabletd left" colspan="3"><input type="text" name="ProdInfo02" value="<?=$Value['ProdInfo02']?>" class="input" style="width:200px;font-size:1.5em; font-weight:bold"></td>
			</tr>
			<tr>
				<th class="tableth " style="width:120px; ">사이즈</th>
				<td class="tabletd left" colspan="3"><input type="text" name="ProdInfo03" value="<?=$Value['ProdInfo03']?>" class="input" style="width:200px;font-size:1.5em; font-weight:bold"></td>
			</tr>
			<tr>
				<th class="tableth " style="width:120px; ">생산기간</th>
				<td class="tabletd left" colspan="3"><input type="text" name="ProdInfo04" value="<?=$Value['ProdInfo04']?>" class="input" style="width:200px;font-size:1.5em; font-weight:bold"></td>
			</tr>
			<tr>
				<th class="tableth " style="width:120px; ">판매옵션</th>
				<td class="tabletd left" colspan="3">
				<input type="radio" name="SaleStatus" value="ready" <?=Check("ready",$Value['SaleStatus'])?>> 판매대기
				<input type="radio" name="SaleStatus" value="ing" <?=Check("ing",$Value['SaleStatus'])?>> 판매중
				<input type="radio" name="SaleStatus" value="end" <?=Check("end",$Value['SaleStatus'])?>> 판매완료
				</td>
			</tr>
			<tr>
				<th class="tableth " style="width:120px; ">정렬순서</th>
				<td class="tabletd left" colspan="3"><input type="text" name="SortNum" value="<?=$Value['SortNum']?>" class="input" style="width:100px;font-size:1.5em; font-weight:bold">(숫자만 입력하세요. 숫자가 높을수록 상위에 정렬됩니다.)</td>
			</tr>
			<tr>
				<th class="tableth " style="width:120px">상품상세정보</th>
				<td class="tabletd left" colspan="3">
				<img src="../images/blank.png" width="5" height="5" style="display:block"  >
				<textarea style="width:680px; height:200px" name="ProdMemo1" id="ProdMemo1" ><?=$Value['ProdMemo1']?></textarea></td>
			</tr>
		</table>
    <div style="margin:20px 0 50px; text-align:center"><input type="image" src="../images/btn_ok.gif" style="cursor:pointer;"> <a href="<?=$href?>"><img src="../images/btn_cancel.gif"  style="cursor:pointer;"></a></div>
      <!--// list -->
    </form>

<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>

