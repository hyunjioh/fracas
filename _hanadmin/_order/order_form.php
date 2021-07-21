<?
  if(!defined("_g_board_include_")) exit;
  require_once "../include/_header.inc.php";

  if($req['OrderNum']){
    $token = new_token($Board['board_id']);
    /*-------------------------------------------------------------------------------------------------
    ▶ 데이터베이스 연결 */
    unset($db);
    $db = new MySQL;
	$SQL = "select *  from ".$Board['table_board']." where OrderNum = ".$req['OrderNum'];
//	echo $SQL;
    $Value = $db -> SelectOne($SQL);
    if(!$Value) locationReplace($Board['Link']);
    $href = $href."&at=view&OrderNum=".$req['OrderNum'];

    $mode = "updateData";
    if($req['at'] == "reply") {
      $mode = "replyData";
      $Value['Subject'] = "[답변] ".$Value['Subject'];
      $Value['Question'] = $Value['Content'];
      $Value['Content'] = "";
      $Value['RegDate'] = "";
    }


	$Board['table_board'] = "G_Order";

	//
	$req['OrderStatus']   = Request('OrderStatus');

	$Where = null;
	$Where[] = " OrderNum = '".$req['OrderNum']."' ";

//////////////////////////////////////////////////////////
// 개인 결제정보 조건
//	$Where[] = " OrderType = 'normal' ";
//	$Where[] = " OrderStatus = 'end' ";
//	$Where[] = " g_UserID = '".$req['g_UserID']."' ";
//////////////////////////////////////////////////////////
	$WhereQuery = (is_array($Where))? " and (".implode(" AND ", $Where).")" : "";

	// 결제정보
	$Q['Limit'] = "1";
	$Query = "SELECT * FROM ".$Board['table_board']." where 1 $WhereQuery order by OrderDate desc limit ".$Q['Limit'] ."";
	$Order = $db -> SelectOne($Query);

	// 상품정보
  	$Query2 = "Select idx, Pcode, ProdTitle, SalePrice, ProdMemo1, ProdImage01, Option1Name, PCategory1 from G_Product Where Pcode = '".$Order['Pcode']."' limit 1 ";
	$Prod = $db -> SelectOne($Query2);
	if($Prod){
		// 카테고리정보
		$Query3 = "Select Name from G_Product_Category Where Depth1='$Prod[PCategory1]' limit 1 ";
		$Cate = $db -> SelectOne($Query3);
	}

	// 결제자정보
  	$Query4 = "Select g_UserName, g_UserPhone from G_Member Where g_UserID = '".$Order['g_UserID']."' limit 1 ";
	$Mem = $db -> SelectOne($Query4);


	$PayMethod = "";
	if($Order['PayMethod']=='hp'){
		$PayMethod = "핸드폰";
	} else if($Order['PayMethod']=='card'){
		$PayMethod = "신용카드";
	} else if($Order['PayMethod']=='real'){
		$PayMethod = "실시간계좌이체";
	} else{
		$PayMethod = "???";
	}

  
  }else{
    $token = new_token($Board['board_id']);
    $mode = "newData";
    $Value[Hit] = 0;
    $Value[RegDate] = date("Y-m-d");
    $Value[Content] = "&nbsp;";
  }

?>
<!--<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>-->
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
  var f = document.sform;
  if(!f.Subject.value){
    alert("제목을 입력하세요.");
    f.Subject.focus();
    return false;
  }
  oEditors[0].exec("UPDATE_IR_FIELD", []);
  // 에디터의 내용에 대한 값 검증은 이곳에서 textarea 필드인 ir1의 값을 이용해서 처리하면 됩니다.
  if(f.Content.value == ""){
    alert("내용을 입력하세요.");
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
  if(len > 1) $("#attachFile input[type=file]").last().remove();
}

function go_status(){

	var f = document.sform;
	f.submit();
}

//]]>
</script>
</head>
<?  require_once "../include/_body_top.inc.php"; ?>

	<form name="sform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$_SERVER[PHP_SELF]?>?at=dataprocess">
      <input type="hidden" name="token" value="<?=$token?>">
      <input type="hidden" name="Html"  value="Y">
	  <input type="hidden" name="OrderNum" value="<?=$req['OrderNum']?>">
      <input type="hidden" name="am" value="<?=$mode?>">
      <input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">

      <input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
      <input type="hidden" name="sdate" value="<?=$req['sdate']?>">
      <input type="hidden" name="edate" value="<?=$req['edate']?>">
      <input type="hidden" name="sn" value="<?=$req['sn']?>">
      <input type="hidden" name="st" value="<?=$req['st']?>">


      <!-- list --
      <h3 class="sub-page-title"><span>내용보기</span></h3>-->

				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td height="10"><strong><font color="tomato">01.</font> 주문내역</strong></td>
					</tr>
				</table>
				<!-- list -->
				<table  width="50%" cellspacing="0" cellpadding="0"  class="viewtable">
					<colgroup>
					<col width="110px">
					<col width="">
					<col width="100px">
					</colgroup>
					<thead>
						<tr bgcolor="F5F3ED">
							<th scope="col">이미지</th>
							<th scope="col">상품명</th>
							<th scope="col">결제금액</th>
						</tr>
					</thead>
					<tbody>

						<tr>
							<td class="txt_bold" style="text-align:center;"><img src="<?=$Prod['ProdImage01']?>" width="93" height="93" alt="아이템 이미지" /></td>
							<td style="text-align:center;"><strong class="f_rGreen">[<?=$Cate['Name']?>] <?=$Prod['ProdTitle']?> <? if($Prod[Option1Name]!="") echo " + "; ?><?=$Prod[Option1Name]?></strong></td>
							<td style="text-align:center;"><strong class="f_red"><?=number_format($Prod['SalePrice'])?>원</strong></td>
						</tr>

<!--
						<tr>
							<td class="txt_bold">20110109_4553929</td>
							<td ><a href="notice_view.php">버블린</a></td>
							<td>1</td>
							<td>50,200원</td>
							<td>50,200원</td>
						</tr>
-->
					</tbody>
				</table>
				<!--// list --
				<div id="bbs_search" align="right">
					<div class="total">
					<b>
					총 주문금액 <?=number_format($sellprice_t)?>원 + 배송료 (<?=$delivery_2_msg?>) <?=number_format($deliveryfee)?>원 = <span class="txt_hotred">총 결제금액 <span class="price"><?=number_format($sellprice_t+$deliveryfee)?>원</span></span>
					</b>
					</div>
				</div>-->
				<br />
				<div class="pdt35"><strong><font color="tomato">02.</font> 결제정보</strong></div>
				<!-- write -->
				<table width="50%" cellspacing="0" cellpadding="0"  class="viewtable">
					<colgroup>
					<col width="110px">
					<col width="">
					</colgroup>
					<tr>
						<th bgcolor="F5F3ED">주문번호</th>
						<td style="padding-left:10px;"><span class="txt_small txt_gray"><?=$Order['OrderNum']?></span></td>
					</tr>
					<tr>
						<th bgcolor="F5F3ED">결제수단</th>
						<td style="padding-left:10px;"><span class="txt_small txt_gray"><?=$PayMethod?></span></td>
					</tr>
					<tr>
						<th bgcolor="F5F3ED">결제금액</th>
						<td style="padding-left:10px;"><span class="txt_small txt_gray"><?=number_format($Order['TotalAmount'])?>원</span></td>
					</tr>

					<tr>
						<th bgcolor="F5F3ED">PG사정보</th>
						<td style="padding-left:10px;"><?=$Order['TradeNum']?></td>
					</tr>

					<tr>
						<th bgcolor="F5F3ED">주문일시</th>
						<td style="padding-left:10px;"><?=$Order['OrderDate']?></td>
					</tr>
				</table>
				<!-- //write -->
				<br />
				<div class="pdt25"><strong><font color="tomato">03.</font> 결제자정보</strong></div>
				
				<table width="50%" cellspacing="0" cellpadding="0"  class="viewtable">
					<colgroup>
					<col width="110px">
					<col width="">
					</colgroup>
					<tr>
						<th bgcolor="F5F3ED">결제자</th>
						<td style="padding-left:10px;"><?=$Mem['g_UserName']?> <?=$Order['g_UserID']?></td>
					</tr>
					<tr>
						<th bgcolor="F5F3ED">전화번호</th>
						<td style="padding-left:10px;"><?=$Mem['g_UserPhone']?></td>
					</tr>
				</table>
				<br />				
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<colgroup>
					<col width="110px">
					<col width="">
					</colgroup>
					<tr>
					  <td><strong><font color="tomato">04.</font> 결제상태</strong></td>
					  <td style="padding-left:10px;">
					  <input type="radio" name="OrderStatus" value="end" <? if($Order['OrderStatus']=="end") echo "checked"; ?>>결제완료
					  &nbsp;&nbsp;
					  <input type="radio" name="OrderStatus" value="cancel" <? if($Order['OrderStatus']=="cancel") echo "checked"; ?>>결제취소
					  &nbsp;&nbsp;&nbsp;&nbsp;
					  <a href="#" onclick="javascript:if(confirm('결제상태를 변경하시겠습니까?')){ go_status(); }"><b>[상태변경]</b></a>
					  </td>
					</tr>
				</table>
				<table width="50%" cellspacing="0" cellpadding="0"  class="viewtable">
					<colgroup>
					<col width="110px">
					<col width="">
					</colgroup>
					<tr>
						<th height="1px"></th>
						<td style="padding-left:10px;"></td>
					</tr>
				</table>
				<br />
<!--
				<div class="pdt25"><strong><font color="tomato">05.</font> 관리자메모</strong></div>
-->
				<table width="100%" cellspacing="0" cellpadding="0"  class="viewtable">
					<thead>
					<tbody>
<!--
						<tr>
							<td style="text-align:left;">
							<textarea name="Content" id="Content" style="width:590px; height:200px"><?=$Value[Content]?></textarea>
							</td>
						</tr>
-->
                      <tr>
                        <td height="20" colspan="5">

		<!-- btn -->
		<div class="joinbg_btn txt_center">
				<table width="50%" border="0" cellspacing="0" cellpadding="0">
					<colgroup>
					<col width="110px">
					<col width="">
					</colgroup>
					<tr>
					  <td style="text-align:right;">
			<!--<a href="#" onclick="javascript:if(confirm('결제내역을 삭제하시겠습니까?')){ go_del(); }"><b>[삭제]</b></a>&nbsp;&nbsp;&nbsp;&nbsp;--><a href="<?=$href?>"><b>[주문목록]</b></a>
					</td>
					</tr>
				</table>
		</div>
		<!-- //btn -->
		
						</td>
                      </tr>
					</tbody>
				</table>
				<!--// list -->
	</form>

<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>



<script type="text/javascript">
  <!--
/*
  var EditorUrl = "<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/";
  var oEditors = [];
  nhn.husky.EZCreator.createInIFrame({
    oAppRef: oEditors,
    oAppRef: oEditors,
    elPlaceHolder: "Content",
    sSkinURI: EditorUrl+"SEditorSkin.html",
    fCreator: "createSEditorInIFrame",
    BoardID : "<?=$Board['board_id']?>",
    EditorUrl : EditorUrl
  });
*/
  //-->
</script>