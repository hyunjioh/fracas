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
  $Value = $db -> SelectOne("Select m_email as email from G_Member Where m_id = '".$req['mid']."' ");
}
?>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$('.load_btn').hide();
});
function emailSend(){
  if(jQuery.trim($("#emailfrm input[name=toEmail]").val()) == ""){
    alert("수신자 이메일 주소를 입력해주세요.");
    $("#emailfrm input[name=toEmail]").focus();
    return false;
  }
  if(jQuery.trim($("#emailfrm input[name=title]").val()) == ""){
    alert("이메일 제목을 입력해주세요.");
    $("#emailfrm input[name=title]").focus();
    return false;
  }
  oEditors[0].exec("UPDATE_IR_FIELD", []);
  // 에디터의 내용에 대한 값 검증은 이곳에서 textarea 필드인 ir1의 값을 이용해서 처리하면 됩니다.
  if(jQuery.trim($("#emailfrm textarea[name=Content]").val()) == ""){
    alert("내용을 입력하세요.");
    oEditors[0].exec("FOCUS", []);
    return false;
  }

  // 데이터 입력
  $.ajax({
      type: 'POST'
      , async: true
      , dataType : "json" //전송받을 데이터의 타입
      , url: '<?=_CORE_?>/act/?at=sendemail'
      , data: $("#emailfrm").serialize()
      , beforeSend: function() {
          $('.email_act_btn').hide();
          $('.load_btn').show().fadeIn('fast');
        }
      , success : function(response, status, request) {
          if(response){
            setTimeout(function() {
              if(response.error == "Y"){
                alert(response.msg);
                $('.load_btn').hide();
                $('.email_act_btn').show().fadeIn('fast');
                return false;
              }
              if(response.error == "N"){
                $("#email_overlay_link").overlay().close();
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
<h2>E-mail 전송</h2>
<form name="emailfrm" id="emailfrm"  method="post" onsubmit="return emailSend();">
<table width="100%" cellspacing="0" cellpadding="0" class="viewtable" style="border:1px solid #fff">
	<tr>
    <td class="tabletd" style="vertical-align:top; padding-top:10px; ">
    <table style="" class="formtable" style="border:1px solid #ddd; ">
      <col width="70"></col>
      <col width="*"></col>
      <tr>
        <th class="tableth f11">발신</th>
        <td class="tabletd left"><?=$site['postmaster_name']?> &lt; <?=$site['postmaster_email']?> &gt;</td>
      </tr>
      <tr>
        <th class="tableth f11">수신</th>
        <td class="tabletd left"><input type="text" name="toEmail" class="input" style="width:200px;border:1px solid #C0C0C0" value="<?=$Value['email']?>"></td>
      </tr>
      <tr>
        <th class="tableth f11">제목</th>
        <td class="tabletd left"><input type="text" name="title" class="input" style="width:500px;border:1px solid #C0C0C0" value=""></td>
      </tr>
      <tr>
        <td class="tabletd" colspan="2"><textarea style="width:100%; height:180px;" id="Content" name="Content"></textarea></td>
      </tr>
    </table>
    </td>
	</tr>
</table>
<div class="load_btn" align="center" style="margin-top:10px; background: none transparent"><img src="../images/common/loader_Submit.gif" align="absmiddle" width="24" height="24" /></div>
<div class="email_act_btn"  style="margin:10px 0; text-align:center" ><input type="image" src="../images/common/btn_sms_send.gif" border="0" id="submit_btn"> <img src="../images/common/btn_sms_refresh.gif" border="0" onclick="document.emailfrm.reset();">
</div>

</form>
<script type="text/javascript">
  <!--
  var EditorUrl = "<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/";
  var oEditors = [];
  nhn.husky.EZCreator.createInIFrame({
    oAppRef: oEditors,
    oAppRef: oEditors,
    elPlaceHolder: "Content",
    sSkinURI: EditorUrl+"SEditorSkinSimple.html",
    fCreator: "createSEditorInIFrame",
    BoardID : "<?=$Board['board_id']?>",
    EditorUrl : EditorUrl
  });
  //-->
</script>