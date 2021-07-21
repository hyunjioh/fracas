<?
define("_administrators_",true);
define("_g_board_include_",true);
include "../../_core/_lib.php";
require_once "../include/manager.inc.php";
if(!defined("_is_manager_"))	exit;

$req['mid'] = Request("mid");

$Value['email'] = null;
if($req['mid']){
  /*-------------------------------------------------------------------------------------------------
  ▶ 데이터베이스 연결 */
  unset($db);
  $db = new MySQL;
  $req['mid'] = decrypt_md5($req['mid'],'mid');
  $Value = $db -> SelectOne("Select m_id as id, m_name as name from G_Member Where m_id = '".$req['mid']."' ");
}
?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$('.load_btn').hide();
});
function messageSend(){
  if(jQuery.trim($("#messagefrm input[name=Subject]").val()) == ""){
    alert("제목을 입력해주세요.");
    $("#messagefrm  input[name=Subject]").focus();
    return false;
  }
  if(jQuery.trim($("#messagefrm textarea[name=Content]").val()) == ""){
    alert("내용을 입력하세요.");
    $("#messagefrm textarea[name=Content]").focus();
    return false;
  }

  // 데이터 입력
  $.ajax({
      type: 'POST'
      , async: true
      , dataType : "json" //전송받을 데이터의 타입
      , url: '<?=_CORE_?>/act/?at=sendmessage'
      , data: $("#messagefrm").serialize()
      , beforeSend: function() {
          $('.message_act_btn').hide();
          $('.load_btn').show().fadeIn('fast');
        }
      , success : function(response, status, request) {
          if(response){
            setTimeout(function() {
              if(response.error == "Y"){
                alert(response.msg);
                $('.load_btn').hide();
                $('.message_act_btn').show().fadeIn('fast');
                return false;
              }
              if(response.error == "N"){
                $("#message_overlay_link").overlay().close();
                alert(response.msg);
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
//]]>
</script>
<h2>쪽지 전송</h2>
<form name="messagefrm" id="messagefrm"  method="post" onsubmit="return messageSend();">
<input type="hidden" name="fromid" value="<?=$MemberID?>">
<table width="100%" cellspacing="0" cellpadding="0" class="viewtable" style="border:1px solid #fff">
	<tr>
    <td class="tabletd" style="vertical-align:top; padding-top:10px; ">
    <table style="" class="formtable" style="border:1px solid #ddd; ">
      <col width="70"></col>
      <col width="*"></col>
      <tr>
        <th class="tableth f11">발신</th>
        <td class="tabletd left"><?=$MemberName?> &lt; <?=$MemberID?> &gt;</td>
      </tr>
      <tr>
        <th class="tableth f11">수신</th>
        <td class="tabletd left"><input type="text" name="toid" class="input" style="width:100px " value="<?=$Value['id']?>" readonly></td>
      </tr>
      <tr>
        <th class="tableth f11">제목</th>
        <td class="tabletd left"><input type="text" name="Subject" class="input" style="width:400px " value=""></td>
      </tr>
      <tr>
        <td class="tabletd" colspan="2"><textarea style="width:100%; height:80px; border:1px solid #ddd" id="Content" name="Content"></textarea></td>
      </tr>
    </table>
    </td>
	</tr>
</table>
<div class="load_btn" align="center" style="margin-top:10px; background: none transparent"><img src="../images/common/loader_Submit.gif" align="absmiddle" width="24" height="24" /></div>
<div class="message_act_btn"  style="margin:10px 0; text-align:center" ><input type="image" src="../images/common/btn_sms_send.gif" border="0" id="submit_btn"> <img src="../images/common/btn_sms_refresh.gif" border="0" onclick="document.messagefrm.reset();">
</div>

</form>
