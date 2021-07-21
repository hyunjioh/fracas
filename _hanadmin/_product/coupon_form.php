<?
	if(!defined("_g_board_include_")) exit; 
	require_once "../include/_header.inc.php";
	$token = new_token($Board['board_id']);
	$mode = "newData";
?>
<script type="text/javascript" src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.alphanumeric.pack.js"></script>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
	if(!$("input[name=CouponName]").val()){
		alert("쿠폰이름을 입력하세요.");
		$("input[name=CouponName]").focus();
		return false;
	}
	if(!$("input[name=CouponCnt]").val()){
		alert("발급매수를 입력하세요.");
		$("input[name=CouponCnt]").focus();
		return false;
	}
	if(!$("input[name=LimitDate]").val()){
		alert("유효기간 입력하세요.");
		$("input[name=LimitDate]").focus();
		return false;
	}
}





$(document).ready(function() {
	$("#regdate").datepicker( {
		showOn: "button"
	});
});

function delcheck(i){
	var f = document.boardform;
	if(confirm("정말로 삭제하시겠습니까?")){
		f.action = "<?=$Board['Link']?>?at=dataprocess";
		f.idx.value = i;
		f.am.value = "deleteData";
		f.submit();
	}
}

$(function() {

	// if the function argument is given to overlay,
	// it is assumed to be the onBeforeLoad event listener
	$("a[rel]").overlay({
		fixed : false, 
		effect: 'myEffect',

		mask: {

			// you might also consider a "transparent" color for the mask
			color: '#999',

			// load mask a little faster
			loadSpeed: 200,

			// very transparent
			opacity: 0.7
		},




		onBeforeLoad: function() {

			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");

			// load the page specified in the trigger
			wrap.load(this.getTrigger().attr("href"));
		},

		onLoad: function(){
			var obj = this;
			$(".close2").click(function(){
				obj.close();
			});
		}

	});
});

// adds an effect called "myEffect" to the overlay
$.tools.overlay.addEffect("myEffect", function(position, done) {

      /*
        - 'this' variable is a reference to the overlay API
        - here we use jQuery's fadeIn() method to perform the effect
      */
      this.getOverlay().css(position).fadeIn(this.getConf().speed, done);
   },

   // close function
   function(done) {

      // fade out the overlay
      this.getOverlay().fadeOut(this.getConf().closeSpeed, done);
			location.href = location.href;
   }
);

$(function() {
		$("input[name=CouponCnt]").numeric(); 
		$(".input_alnum").css("ime-mode", "disabled"); 
});
//]]>
</script>

</head>
<?	require_once "../include/_body_top.inc.php"; ?>
<body>



<form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
<input type="hidden" name="token" value="<?=$token?>">
<input type="hidden" name="Html"  value="Y">

<input type="hidden" name="idx" value="<?=$req['idx']?>">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="am" value="<?=$mode?>">
<input type="hidden" name="_referer_" value="<?=$_SERVER['REQUEST_URI']?>">
<table width="100%" cellspacing="0" cellpadding="0" class="formtable">
	<col width="120"></col>
	<col width=""></col>
	<tr id="Region1">
		<th class="tableth">쿠폰이름</th>
		<td class="tabletd" ><input type="text" name="CouponName" maxlength="50" value="" class="input" size="50" ></td>
	</tr>
	<tr id="Region1">
		<th class="tableth">적용상품</th>
		<td class="tabletd" >
    <?
      $Product = $db -> SelectList("Select * from G_Product Where SellYN='Y'  Order by idx ");
      echo "<select name='Pcode'>";
      if($Product){
        $cnt = count($Product);
        for($i=0; $i<$cnt; $i++){
          $V = $Product[$i];
          echo "<option value='".$V['Pcode']."'>".ProductCategory('product',$V['PCategory1'])." ".$V['ProdTitle']."</option>";
        }        
      }else{      
        echo "<option value=''>등록된 상품이 없습니다.</option>";
      }
      echo "</select>";
    ?>    
    </td>
	</tr>
	<tr>
		<th class="tableth">발급매수</th>
		<td class="tabletd"><input type="text" name="CouponCnt" maxlength="8" value="" class="input input_alnum" style="width:60px">매</td>
	</tr>
	<tr>
		<th class="tableth">유효기간</th>
		<td class="tabletd"><input type="text" name="LimitDate" maxlength="10" value="" class="input-date" id="regdate" readonly> </td>
	</tr>
</table>
<div style="margin:20px 0 30px; text-align:center"><input type="image" src="../images/btn_ok.gif" style="cursor:pointer;"> </div>
</form>



<table width="100%" cellspacing="0" cellpadding="0" class="listtable">
	<col width="60"></col>
	<col width="*"></col>
	<col width="100"></col>
	<col width="100"></col>
	<col width="100"></col>
	<col width="200"></col>
	<tr>
		<th class="tableth">번호</th>
		<th class="tableth">쿠폰명</th>
		<th class="tableth">유효기간</th>
		<th class="tableth">발급매수</th>
		<th class="tableth">발급일</th>
		<th class="tableth">관리</th>
	</tr>
	<?
		$LIST = $db -> SelectList("Select count(idx) as Cnt , idx, PubDate, CouponName, LimitDate from G_Coupon group by CouponName order by PubDate desc");
		$TOTAL = count($LIST);
		$NUMBER = $TOTAL - ($req['pagenumber'] - 1)*$Board['page_limit'];
		if($LIST){
			foreach($LIST as $key => $value){
	?>
	<tr>
		<td class="tabletd center"><a href="<?=$href?>&at=view&idx=<?=$value['idx']?>"><?=$NUMBER--?></a></td>
		<td class="tabletd center"><a href="coupon_overlay.php?idx=<?=$value['idx']?>" class="overlay<?=$value['idx']?>" rel="#overlay"><?=$value['CouponName']?></a> </td>
		<td class="tabletd center"><?=substr($value['LimitDate'],0,10)?></td>
		<td class="tabletd center"><?=$value['Cnt']?></td>
		<td class="tabletd center"><?=substr($value['PubDate'],0,10)?></td>
		<td class="tabletd center">
			<a href="excel.php?idx=<?=$value['idx']?>"><img src="../images/btn_excel.gif"></a>
			<img src="../images/btn_delete.gif" style="cursor:pointer" onclick="delcheck(<?=$value['idx']?>);">
		</td>
	</tr>
	<?
			}
		}else{
  ?>
  <tr>
    <td colspan="6" class="tabletd center" style="height:200px">데이터가 없습니다.</td>
  </tr>
  <?    
    }	
		$db -> Disconnect();
	?>
</table>

</div>

<!-- overlayed element -->
<div class="apple_overlay" id="overlay">
	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap"></div>
</div>

<!-- preload the images -->
<div style='display:none'>
	<img src='../images/x.png' alt='' />
</div>
<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>

