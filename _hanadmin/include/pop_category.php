<?
define("_administrators_",true);
define("_g_board_include_",true);
include "../../_core/_lib.php";
require_once "../include/manager.inc.php";
if(!defined("_is_manager_"))	exit;

$req['val'] = Request("val");

$req['table_board'] = null;
$req['board_id'] = null;
if($req['val']){
  $req['val'] = decrypt_md5($req['val'],"Board");
  $req['val'] = explode("|",$req['val']);
  /*-------------------------------------------------------------------------------------------------
  ▶ 데이터베이스 연결 */
  unset($db);
  $db = new MySQL;
  if(count($req['val']) == 2){
    $req['table_board'] = $req['val']['0'];
    $req['board_id']    = $req['val']['1'];
    $LIST = $db -> SelectList("Select *  from G__Category Where TableName = '".$req['table_board']."' and BoardID = '".$req['board_id']."' ");
  }
}
?>
<script type="text/javascript">
//<![CDATA[
var loader = "<img src=\"../images/common/loader_Submit.gif\" align=\"absmiddle\" width=\"24\" height=\"24\" />";
$(document).ready(function(){
	$('.load_btn').hide();
  $(".categorydel").live("click", function() {
    if($(this).css('opacity') < 1) return false;
    if(confirm("정말로 삭제하시겠습니까?")){
      parentObj = $(this).parent().parent();
      categorycode = parentObj.find(".category_code").text();
      // 데이터 입력
      $.ajax({
          type: 'POST'
          , async: true
          , dataType : "json" //전송받을 데이터의 타입
          , url: '<?=_CORE_?>/act/?at=categorydel'
          , data: "ccode="+categorycode
          , beforeSend: function() {
              btnHTML = parentObj.find(".btn").html();
              parentObj.find(".btn").html(loader);
              //$('.category_act_btn').hide();
              //$('.load_btn').show().fadeIn('fast');
            }
          , success : function(response, status, request) {
              if(response){
                setTimeout(function() {
                  if(response.error == "Y"){
                    alert(response.msg);
                    //$('.load_btn').hide();
                    //$('.category_act_btn').show().fadeIn('fast');
                    parentObj.find(".btn").html(btnHTML);
                    return false;
                  }
                  if(response.error == "N"){
                    //$("#category_overlay_link").overlay().close();
                    parentObj .remove();
                  }
                }, 1000);
              }
            }
          , error: function(request, status, err) {
              alert("error code : " + request.status + "\r\nmessage : " + request.reponseText);
              alert('서버와의 통신이 실패했습니다.');
              return false;
            }
          , complete: function() {

              return false;
            }
      });
      return false;
    }
  });


/*
  $(".categoryedit").live("click", function() {
		if($("#categoryNameEdit").length > 0){
			alert("test");
			return false;
		}
    parentObj = $(this).parent().parent();
    categoryname = parentObj.find(".category_name").text();
    categorynameHTML = "<div id='categoryNameEdit'><input type='text' id='cName' value='"+categoryname+"' class='input' > <img type='image' src='../images/btn_confirm_s.gif'></div>" ;
    parentObj.find(".category_name").html(categorynameHTML);
    $("#cName").focus();

			//

		$(document).live('click', function (e) {
			if(!$( e.target ).hasClass("categoryedit")){
				var id = $( e.target ).closest("div").attr("id");
				if(id != "categoryNameEdit"){
					parentObj.find(".category_name").html(categoryname);
				}
			}
		});



  });
*/


});
function categoryAdd(){
  if(jQuery.trim($("#categoryaddfrm input[name=CategoryName]").val()) == ""){
    alert("카테고리이름을 입력해주세요.");
    $("#categoryaddfrm input[name=CategoryName]").focus();
    return false;
  }
  // 데이터 입력
  $.ajax({
      type: 'POST'
      , async: true
      , dataType : "json" //전송받을 데이터의 타입
      , url: '<?=_CORE_?>/act/?at=categoryadd'
      , data: $("#categoryaddfrm").serialize()
      , beforeSend: function() {
          $('.category_act_btn').hide();
          $('.load_btn').show().fadeIn('fast');
        }
      , success : function(response, status, request) {
          if(response){
            setTimeout(function() {
              if(response.error == "Y"){
                alert(response.msg);
                $('.load_btn').hide();
                $('.category_act_btn').show().fadeIn('fast');




                return false;
              }
              if(response.error == "N"){
                //$("#category_overlay_link").overlay().close();
                CategoryTR  = "<tr id='"+response.code+"'>";
                CategoryTR +="  <td class=\"tabletd center\"><span class=\"category_code\">"+response.code+"</span></td>";
                CategoryTR +="  <td class=\"tabletd left category_name\">"+jQuery.trim($("#categoryaddfrm input[name=CategoryName]").val())+"</td>";
                CategoryTR +="  <td class=\"tabletd center\">0</td>";
                CategoryTR +="  <td class=\"tabletd center btn\"><img src='../images/btn_s/btn_modify.gif' class='pointer categoryedit'  onclick=\"categoryEdit('"+response.code+"');\"> <img src='../images/btn_s/btn_del.gif' class='pointer categorydel'></td>";
                CategoryTR +="</tr>";

                $("#category_list_table tbody").find(".nodata").hide().end().append(CategoryTR);
                $('.load_btn').hide();
                $('.category_act_btn').show().fadeIn('fast');
                $("#categoryaddfrm input[name=CategoryName]").val('');

              }
            }, 1000);
          }
        }
      , error: function(request, status, err) {
          alert("error code : " + request.status + "\r\nmessage : " + request.reponseText);
          alert('서버와의 통신이 실패했습니다.');
          return false;
        }
      , complete: function() {

          return false;
        }
  });
  return false;
}

var editOn = false;
function categoryEdit(code){
  var prevObjid = "";
  if($("input[name=ccode]").length > 0){
    prevObjid = $("input[name=ccode]").val();
    prevcategoryname= $("input[name=c_name]").val();
    prevObj = $("#"+prevObjid);

    if($("input[name=ccode]").val() != code){
      prevObj.find(".category_name").html(prevcategoryname);
      prevObj.find(".btn img").fadeTo("fast",1);
      editOn = false;
    }    

  }
	if(!editOn){
    if(prevObjid != code){
      parentObj = $("#"+code);
      categoryname = parentObj.find(".category_name").text();
      categorynameHTML = "<div id='categoryNameEdit'><input type='hidden' name='ccode' value='"+code+"'><input type='text' id='cName' name='c_name' value='"+categoryname+"' class='input' > <img type='image' src='../images/btn_confirm_s.gif'></div>" ;
      parentObj.find(".category_name").html(categorynameHTML);
      //btnHTML = parentObj.find(".btn").html();
      parentObj.find(".btn img").fadeTo("fast",0.2);    
      editOn = true;

      $("#category_list_layer").live('click', function (e) {
        if(!$( e.target ).hasClass("categoryedit")){
          var id = $( e.target ).closest("div").attr("id");
          if(id != "categoryNameEdit"){
            parentObj.find(".category_name").html(categoryname);
            parentObj.find(".btn img").fadeTo("fast",1);
            editOn = false;
            return false;
          }
        }else{
         return false;
        }
        event.preventDefault(); 
      });
    }
	}
}

//]]>
</script>
<h2>카테고리관리</h2>
<table width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #fff">
	<tr>
    <td class="tabletd" style="vertical-align:top; padding:5px; border-bottom:1px solid #fff ">

    <form name="categorylistfrm" id="categorylistfrm"  method="post">
    <div style="width:545px; height:230px; overflow-y:auto" id="category_list_layer">
    <table class="listtable" id="category_list_table">
      <thead>
      <tr>
        <th class="tableth" style="width:100px;">코드</th>
        <th class="tableth" style="">카테고리명</th>
        <th class="tableth " style="width:80px;">게시물 수</th>
        <th class="tableth " style="width:120px;">관리</th>
      </tr>
      </thead>
      <tbody>
      <?
        if($LIST){
          $cnt = count($LIST);
          for($i = 0; $i < $cnt; $i++){
            $total = $db -> Total("Select count(*) from ".$LIST[$i]['TableName']." Where BoardID = '".$LIST[$i]['BoardID']."' and Category = '".$LIST[$i]['CategoryCode']."' " );
      ?>
      <tr id="<?=$LIST[$i]['CategoryCode']?>">
        <td class="tabletd center"><span class="category_code"><?=$LIST[$i]['CategoryCode']?></span></td>
        <td class="tabletd left category_name"><?=$LIST[$i]['CategoryName']?></td>
        <td class="tabletd center"><?=$total?></td>
        <td class="tabletd center btn"><img src='../images/btn_s/btn_modify.gif' class='pointer categoryedit' onclick="categoryEdit('<?=$LIST[$i]['CategoryCode']?>');">
        <? if($total < 1){?><img src='../images/btn_s/btn_del.gif' class='pointer categorydel'><? } ?></td>
      </tr>
      <?
          }
        }else{
      ?>
      <tr class="nodata">
        <td colspan="4" class="tabletd center" style="height:100px">데이터가 없습니다.</td>
      </tr>
      <?
        }
      ?>
      </tbody>
    </table>
    </div>
    </form>
    <br/>

    <form name="categoryaddfrm" id="categoryaddfrm"  method="post" onsubmit="return categoryAdd();">
    <input type="hidden" name="table_board" value="<?=$req['table_board']?>">
    <input type="hidden" name="board_id" value="<?=$req['board_id']?>">
    <table class="formtable" style="border-bottom:1px solid #ddd">
      <tr>
        <th class="tableth" style="width:120px;">카테고리</th>
        <td class="tabletd ">
        <input type="text" class="input" name="CategoryName" value="" style="float:left; margin-top:2px; " maxlength="30">
        <div class="load_btn" style=" float:left; margin-left:2px; "><img src="../images/common/loader_Submit.gif" align="absmiddle" width="24" height="24" /></div>
        <div class="category_act_btn"  style="float:left; margin-left:2px; " ><input type="image" src="../images/btn_regist.gif"></div>

        </td>
       </tr>
    </table>
    </form>
    </td>
	</tr>
</table>

