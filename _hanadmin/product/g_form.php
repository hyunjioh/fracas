<?
	if(!defined("_g_board_include_")) exit; 
	if($req['idx']){
		$token = new_token($Board['board_id']);
		/*-------------------------------------------------------------------------------------------------
		▶ 데이터베이스 연결 */	
		unset($db);
		$db = new MySQL;

		$mode = "updateData";
		$Value = $db -> SelectOne("select *  from ".$Board['table_board']." where BoardID = '".$Board['board_id']."' and idx = ".$req['idx']);
		if(!$Value)	locationReplace("./");	
		$href = $href."&idx=".$req['idx'];
	}else{
		$token = new_token($Board['board_id']);
		$mode = "newData";
		$Value[Hit] = 0;
		$Value[RegDate] = date("Y-m-d");
		$Value[UserName]  = $_SESSION['_MEMBER_']['NAME'];
		$Value[UserEmail] = $_SESSION['_MEMBER_']['EMAIL'];

		$Value[ListView] = "Y";
	}
?>
<? include "../include/_header.inc.php"; ?>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/themes/base/jquery.ui.all.css">
<script type="text/javascript">
//<![CDATA[

$(document).ready(function() {
		$("#StartDate").datepicker( {
			dateFormat : "yy-mm-dd" ,
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true				
		});
		$("#EndDate").datepicker( {
			minDate: $("#StartDate").val(),
			dateFormat : "yy-mm-dd" ,
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true				
		});

		$( "#StartDate" ).change(function() {
			$("#EndDate").val($("#StartDate").val())
			$("#EndDate").datepicker( {
				minDate: $("#startdate").val(),
				dateFormat : "yy-mm-dd" ,
				showOn: "button",
				buttonImage: "images/calendar.gif",
				buttonImageOnly: true				
			});
		});
});

function frmcheck(){
	var f = document.boardform;
	if(!f.ProdTitle.value){
		alert("<?=$msg['Please_enter_subject']?>");
		f.ProdTitle.focus();
		return false;
	}
	oEditors[0].exec("UPDATE_IR_FIELD", []);
	// 에디터의 내용에 대한 값 검증은 이곳에서 textarea 필드인 ir1의 값을 이용해서 처리하면 됩니다.
	if(f.ProdDesc.value == ""){
		alert(f.ProdDesc.value);
		alert("<?=$msg['Please_enter_content']?>");
		oEditors[0].exec("FOCUS", []); 
		return false;
	}	
}


function addFileField(str){
	var max    = $("#maxfile").text();
	var remain = $("#remainfile").text();
	var now = max - remain;
	var len    = $("#attachFile input[type=file]").length;
	if(len  >= remain){
		alert("파일 첨부는 최대 "+max+" 까지 입니다.");
		return false;
	}
	$("#attachFile").append(str);
}

function removeFileField(){
	var max    = $("#maxfile").text();
	var remain = $("#remainfile").text();
	var len    = $("#attachFile input[type=file]").length;
	if(len > 1)	$("#attachFile input[type=file]").last().remove();
}
//]]>
</script>
</head>
<body>

<div id="wrapper">	
<? @include "../include/top_menu.php"; ?>
<div id="body-content-ext">
<h3 class="page-title"><span><?=$PageTitle?></span></h3>

<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="./?at=dataprocess">
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="Html"  value="Y">

<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="am" value="<?=$mode?>">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width=""></col>
	<tr>
		<th class="tableth">상품명</th>
		<td class="tabletd"><input type="text" name="ProdTitle" maxlength="255" value="<?=$Value[ProdTitle]?>" class="input-blur" style="width:500px"> </td>
	</tr>
	<tr>
		<th class="tableth">상품분류</th>
		<td class="tabletd"><input type="text" name="ProdDivision" maxlength="50" value="<?=$Value[ProdDivision]?>" class="input-blur" style="width:100px"></td>
	</tr>
	<tr>
		<th class="tableth">상품지역(주소)</th>
		<td class="tabletd"><input type="text" name="ProdAddr" maxlength="50" value="<?=$Value[ProdAddr]?>" class="input-blur" style="width:100px"> 주소지 명칭, 예)서울</td>
	</tr>
	<tr>
		<th class="tableth">상품지역(구역)</th>
		<td class="tabletd"><input type="text" name="ProdRegion" maxlength="50" value="<?=$Value[ProdRegion]?>" class="input-blur" style="width:100px"> 구역이름, 예)홍대</td>
	</tr>
	<tr>
		<th class="tableth">판매기간</th>
		<td class="tabletd"><input type="text" name="StartDate" id="StartDate" maxlength="10" value="<?=$Value[StartDate]?>" class="input-blur" style="width:100px"> ~ <input type="text" name="EndDate" id="EndDate" maxlength="10" value="<?=$Value[EndDate]?>" class="input-blur" style="width:100px"> 
		</td>
	</tr>
	<tr>
		<th class="tableth">옵션</th>
		<td class="tabletd"> <input type="checkbox" name="Blind" maxlength="10" value="Y" <?=Checked("Y",$Value[Blind])?> class="input-blur" > 블라인드 딜&nbsp;&nbsp;&nbsp;<br>
		<input type="checkbox" name="ListView" maxlength="10" value="Y" <?=Checked("Y",$Value[ListView])?> class="input-blur" > 지난목록 보이기	<br>	
		<input type="checkbox" name="SaleEnd" maxlength="10" value="Y" <?=Checked("Y",$Value[SaleEnd])?> class="input-blur" > 판매종료
		</td>
	</tr>

	<tr>
		<th colspan="2" height="10"></th>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width="120"></col>
	<col width="120"></col>
	<col width="120"></col>
	<col width=""></col>
	<tr>
		<th class="tableth" rowspan="2">가격</th>
		<th class="tableth">상품가격</th>
		<th class="tableth">판매가격</th>
		<td class="tableth">할인율</td>
		<td class="tableth"></td>
	</tr>
	<tr>
		<td class="tabletd"><input type="text" name="OrgPrice" maxlength="10" value="<?=$Value[OrgPrice]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"></td>
		<td class="tabletd"><input type="text" name="SalePrice" maxlength="10" value="<?=$Value[SalePrice]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"></td>
		<td class="tabletd"><input type="text" name="SaleRatio" maxlength="10" value="<?=$Value[SaleRatio]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"></td>
		<td class="tabletd"></td>
	</tr>
	<tr>
		<th colspan="5" height="10"></th>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width="120"></col>
	<col width="120"></col>
	<col width="120"></col>
	<col width="120"></col>
	<col width=""></col>
	<tr>
		<th class="tableth" rowspan="2">수량</th>
		<th class="tableth">최대수량</th>
		<th class="tableth">딜 수량</th>
		<td class="tableth">판매량</td>
		<td class="tableth">재고량</td>
		<td class="tableth"></td>
	</tr>
	<tr>
		<td class="tabletd"><input type="text" name="MaxCnt" maxlength="10" value="<?=$Value[MaxCnt]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"></td>
		<td class="tabletd"><input type="text" name="DealCnt" maxlength="10" value="<?=$Value[DealCnt]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"></td>
		<td class="tabletd"><input type="text" name="SaleCnt" maxlength="10" value="<?=$Value[SaleCnt]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"></td>
		<td class="tabletd"><input type="text" name="StockCnt" maxlength="10" value="<?=$Value[StockCnt]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"></td>
		<td class="tabletd"></td>
	</tr>
	<tr>
		<th class="tableth">1인당 구매제한</th>
		<td class="tabletd" colspan="5"><input type="text" name="LimitCnt" maxlength="10" value="<?=$Value[LimitCnt]?>" class="input-blur" style="width:100px; text-align:right; padding-right:5px"> * 0 일 경우 제한 없음</td>
	</tr>
	<tr>
		<th colspan="5" height="10"></th>
	</tr>
</table>



<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width=""></col>
	<tr>
		<th class="tableth">썸네일</th>
		<td class="tabletd"><input type="file" name="ImageThumb" class="input-blur" style="width:500px"> (37 × 37)
		<?=($Value[ImageThumb])? "<br><img src='"._UPLOAD_.$Value[ImageThumb]."'>":"";?>
		</td>
	</tr>
	<tr>
		<th class="tableth">배너이미지</th>
		<td class="tabletd"><input type="file" name="ImageBanner" class="input-blur" style="width:500px"> (129 × 84)
		<?=($Value[ImageBanner])? "<br><img src='"._UPLOAD_.$Value[ImageBanner]."' width=80>":"";?>		
		</td>
	</tr>
	<tr>
		<th class="tableth">주문이미지</th>
		<td class="tabletd"><input type="file" name="ImageList" class="input-blur" style="width:500px"> (123 × 88)
		<?=($Value[ImageList])? "<br><img src='"._UPLOAD_.$Value[ImageList]."' width=80>":"";?>		
		</td>
	</tr>
	<tr>
		<th class="tableth">티켓이미지</th>
		<td class="tabletd"><input type="file" name="ImageTicket"  class="input-blur" style="width:500px"> (119 × 90)
		<?=($Value[ImageTicket])? "<br><img src='"._UPLOAD_.$Value[ImageTicket]."' width=80>":"";?>		
		</td>
	</tr>
	<tr>
		<th class="tableth">메인이미지</th>
		<td class="tabletd"><input type="file" name="ImageMain"  class="input-blur" style="width:500px"> (980 × 392)
		<?=($Value[ImageMain])? "<br><img src='"._UPLOAD_.$Value[ImageMain]."' width=80>":"";?>		
		</td>
	</tr>
	<tr>
		<th class="tableth">가격이미지</th>
		<td class="tabletd"><input type="file" name="ImagePrice"  class="input-blur" style="width:500px"> (276 × 116)
		<?=($Value[ImagePrice])? "<br><img src='"._UPLOAD_.$Value[ImagePrice]."' width=80>":"";?>		
		</td>
	</tr>
	<tr>
		<th class="tableth">주의사항</th>
		<td class="tabletd"><input type="file" name="ImageInfo"  class="input-blur" style="width:500px"> (717 × ∞)
		<?=($Value[ImageInfo])? "<br><img src='"._UPLOAD_.$Value[ImageInfo]."' width=80>":"";?>		
		</td>
	</tr>
	<tr>
		<th colspan="2" height="10"></th>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width=""></col>
	<tr>
		<th class="tableth">상품설명</th>
		<td class="tabletd"><textarea name="ProdDesc" id="ProdDesc" style="width:680px; height:300px"><?=$Value[ProdDesc]?></textarea></td>
	</tr>
	<tfoot>
		<tr>
		<td colspan="2" class="tfoottd_C">
		<input type="image" src="<?=_ADMIN_?>/images/board/btn_save.gif" align="middle">
		<a href="<?=$href?>"><img src="<?=_ADMIN_?>/images/board/btn_list.gif" align="middle"></a> 
		<!--
		<a href="<?=$href?>"><img src="<?=_ADMIN_?>/images/board/btn_cancel.gif" align="middle"></a>
		-->
		</td>
		</tr>
	</tfoot>
</table>

</form>


</div>
<div id="copyright"></div>












</div>
<? include "../include/_footer.inc.php"; ?>
	<script type="text/javascript">
	<!--
	var EditorUrl = "<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/";
	var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		oAppRef: oEditors,
		elPlaceHolder: "ProdDesc",
		sSkinURI: EditorUrl+"SEditorSkin.html",
		fCreator: "createSEditorInIFrame",
		BoardID : "<?=$Board['board_id']?>",
		EditorUrl : EditorUrl
	});
	//-->
	</script>