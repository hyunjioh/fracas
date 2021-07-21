<?
  define("_administrators_",true);
  define("_g_board_include_",true);
  include "../../_core/_lib.php";
	require_once "../include/manager.inc.php";
	if(!defined("_is_manager_"))	exit;

  $req['mid'] = Request("mid");

  $Value['hp'] = null;
  if($req['mid']){
    /*-------------------------------------------------------------------------------------------------
    ▶ 데이터베이스 연결 */
    unset($db);
    $db = new MySQL;
    $req['mid'] = decrypt_md5($req['mid'],'mid');
    $Value = $db -> SelectOne("Select replace(m_hp,'-','') as hp from G_Member Where m_id = '".$req['mid']."' ");
  }

?>
<link rel="stylesheet" type="text/css" href="<?=_CORE_?>/js/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../include/js/sms.js"></Script>
<style>
#tr_sms_list option {background:#ddd; margin:1px;}
</style>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$('.load_btn').hide();
  var phone = "<?=$Value['hp']?>";
  if(phone){
    user_add(phone);
  }

  var now = new Date(); //현재 날짜 및 시간
//  var LimitDate = new Date(Date.parse(now) + 1000 * 60 * 5); //5분후
  var yyyy = now.getFullYear();
  var MM = now.getMonth();
  var dd = now.getDate();
  var hh = now.getHours();
  var mm = now.getMinutes()+5;
  var ss = now.getSeconds();
  var LimitDate = new Date(yyyy, MM, dd, hh, mm, 0 )


  $('#reservDate').datetimepicker({
    minDate:LimitDate, 
    numberOfMonths: 1,
    hourGrid: 4,
    minuteGrid: 10,
    timeFormat: 'hh:mm:ss',
    beforeShow: function(input, inst) {
      if($("input[name=reserve]:checked").val() == "N"){
        $('#reservDate').val('');
        $('#reservDate').datepicker( "disable","hide" );
      }else{
        $('#reservDate').datepicker( "enable","show" );      
      }
    }
  });
  $('#reservDate').datepicker( "disable","hide" );

  $("input[name=reserve]").click(function(){
    if($(this).val() == "Y"){
      $('#reservDate').datepicker( "enable","show" );          
    }else{
      $('#reservDate').val('');
      $('#reservDate').datepicker( "disable","hide" );    
    }
  });




});
function smsSend(){
  var recv_hp_list_html = "";
  $("#tr_sms_list option").each(function(){
    recv_hp_list_html += "<input type='hidden' name='recv_hp_list[]' value='"+$(this).text()+"'>";
  });
  if(recv_hp_list_html == ""){
    alert("수신자 목록에 수신자가 없습니다.");
    return false;
  }
  if($("#smsfrm input[name=callback]").val() == ""){
    alert("발신자 번호를 입력하세요.");
    $("#smsfrm input[name=callback]").focus().val('');
    return false;
  }
  if($("#SmsMsg").val() == "메세지를 입력하세요."){
    alert("메세지를 입력하세요.");
    $("#SmsMsg").focus().val('');
    return false;
  }
  if( $("#smsfrm input[name=reserve]:checked").length < 1){
    alert("즉시/예약 전송을 선택하여 주세요.");
    return false;
  }else{
    if($("#smsfrm input[name=reserve]:checked").val() == "Y" && $("#smsfrm input[name=reservDate]").val() == ""){
      alert("예약시간을 입력해주세요.");
      return false;
    }
  }
  $("#smsfrm").append(recv_hp_list_html);
  // 데이터 입력
  $.ajax({
      type: 'POST'
      , async: true
      , dataType : "json" //전송받을 데이터의 타입
      , url: '<?=_CORE_?>/act/?at=sendsms'
      , data: $("#smsfrm").serialize()
      , beforeSend: function() {
          $('.sms_act_btn').hide();
          $('.load_btn').show().fadeIn('fast');
        }
      , success : function(response, status, request) {
          if(response){
            setTimeout(function() {
              if(response.error == "Y"){
                alert(response.msg);
                $('.load_btn').hide();
                $('.sms_act_btn').show().fadeIn('fast');
                return false;
              }
              if(response.error == "N"){
                $("#sms_overlay_link").overlay().close();  
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
<h2>SMS 전송</h2>
<form name="smsfrm" id="smsfrm"  method="post" onsubmit="return smsSend();">
<table width="100%" cellspacing="0" cellpadding="0" class="viewtable" style="border:1px solid #fff">
	<col width="155"></col>
	<col width="*"></col>
	<tr>
		<td class="tabletd" >
    <table style="width:132px; padding:0; margin:0;">
      <tr>
        <td><img src="../images/common/bg_sms_top.gif"></td>
      </tr>
      <tr>
        <td style="height:110px; background:url('../images/common/bg_sms_body.gif') bottom transparent; padding:10px 20px; "><textarea id="SmsMsg" name="SmsMsg" style="width:92px; height:100%; overflow:hidden; border:none; font-family:'굴림'; font-size:9pt; line-height:1.4; background: transparent  " frameborder="0" border="0" cols="17" rows="6" onclick="initArea()" onkeyup="javascript:cal_byte();">메세지를 입력하세요.</textarea></td>
      </tr>
      <tr>
        <td style="text-align:right; padding-right:3px"><input type="text" name="msgByte" disabled value="0" style='font-size:9pt; width:20px; border:none; margin-bottom:2px; text-align:right; color:#ff3300'> / 80 bytes</td>
      </tr>
    </table>
    </td>
    <td class="tabletd" style="vertical-align:top; padding-top:10px; ">
    <table style="" class="formtable" style="border:1px solid #ddd; width:240px;">
      <col width="70"></col>
      <col width="*"></col>
      <tr>
        <th class="tableth f11">수신</th>
        <td class="tabletd left">
        <!-- 수신번호 -->
        <input type="text" name="recv_sms_hp" class="input" style="width:125;border:1px solid #C0C0C0"><br/>
        <!-- 수신번호 추가/삭제 -->
        <a href="javascript:;" onclick="user_add(document.smsfrm.recv_sms_hp.value)"><img src="../images/common/btn_sms_rec_add.gif" width="42" height="16"border="0"></a>
        <a href="javascript:user_del()"><img src="../images/common/btn_sms_rec_del.gif" width="42" height="16" border="0"></a><br/>
        <!-- 수신번호 리스트-->
        <select style="width:150px; height:50px; border:1px solid #ccc"  name="tr_sms_list" id="tr_sms_list" multiple></select><br/>
        </td>
      </tr>
      <tr>
        <th class="tableth f11">발신</th>
        <td class="tabletd left"><input type="text" name="callback" class="input" style="width:125;border:1px solid #C0C0C0" value="<?=$site['sms_callback']?>"></td>
      </tr>
      <tr>
        <th class="tableth f11"><input type="radio" name="reserve" value="N" checked> 즉시<br/>
        <input type="radio" name="reserve" value="Y"> 예약</th>
        <td class="tabletd left"> <input type="text" class="input" name="reservDate" id="reservDate" style="width:120px">
        </td>
      </tr>
    </table>
    </td>
	</tr>

</table>
<div class="load_btn" align="center" style="margin-top:10px; background: none transparent"><img src="../images/common/loader_Submit.gif" align="absmiddle" width="24" height="24" /></div>
<div class="sms_act_btn" style="margin:10px 0; text-align:center" ><input type="image" src="../images/common/btn_sms_send.gif" border="0" id="submit_btn"> <img src="../images/common/btn_sms_refresh.gif" border="0" onclick="document.smsfrm.reset();">
</div>

</form>