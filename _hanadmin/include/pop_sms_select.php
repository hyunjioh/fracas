<?
define("_administrators_",true);
include "../../_core/_lib.php";
require_once _CORE_PATH_."/system/class.MySQL.php";
include "../include/_header.inc.php"; 
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

$req['gidx'] = Request("gidx");
?>
<link rel="stylesheet" type="text/css" href="../css/default.css" />
<link rel="stylesheet" type="text/css" href="../css/contents.css" />
<style>
ul.member_list {  padding-bottom:10px; }
ul.member_list:after { content:''; display:block; clear:both;}
ul.member_list li {   float:left; border:1px solid #ddd; background:#eee; margin-right:3px; margin-bottom:3px; padding-left:3px; padding-right:23px;  position:relative; }

ul.member_list li .close {background:url(../images/icon/select_list_del.png); width:16px; height:16px; position:absolute; right:2px; top:2px; cursor:pointer;   }
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.load_btn').hide();
  $(".close").click(function(){
    $(this).hide().parent().animate({ opacity: 0.25, width: 'toggle' }, 1000, function() { $(this).remove(); });

  });
});

function messageSend(){
  if( $(".member_list li").length < 1){
    alert("수신할 회원이 없습니다.");
    return false;
  }else{
    $(".member_list li").each(function(){
      input = "<input type='hidden' name='to_list[]' value='"+$(this).text()+"'>";
      $("#messagefrm").append(input);
    });
  }
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
  //document.messagefrm.action = "<?=_CORE_?>/act/?at=selectsendmessage";
  //document.messagefrm.submit();

  // 데이터 입력

  $.ajax({
      type: 'POST'
      , async: true
      , dataType : "json" //전송받을 데이터의 타입
      , url: '<?=_CORE_?>/act/?at=selectsendmessage'
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
                alert(response.msg);
                self.close();
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
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".close").click(function(){
    $(this).hide().parent().animate({ opacity: 0.25, width: 'toggle' }, 1000, function() { $(this).remove(); });

  });
});
</script>
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
  if( $(".member_list li").length < 1){
    alert("수신할 회원이 없습니다.");
    return false;
  }else{
    $(".member_list li").each(function(){
      input = "<input type='hidden' name='to_list[]' value='"+$(this).text()+"'>";
      $("#smsfrm").append(input);
    });
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
  // 데이터 입력
  $.ajax({
      type: 'POST'
      , async: true
      , dataType : "json" //전송받을 데이터의 타입
      , url: '<?=_CORE_?>/act/?at=selectsendsmse'
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
                alert(response.msg);
                self.close();
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
</head>
<body class="pop">

<h2>
	<span class="title">SMS 전송</span>
	<span class="btn"><a href="#close" onclick="window.close();"><img src="../images/btn_x.gif" alt="닫기" /></a></span>
</h2>


<!-- CONTENTS -->
<div class="popContents">







<form name="smsfrm" id="smsfrm"  method="post" onsubmit="return smsSend();">
<table width="100%" cellspacing="0" cellpadding="0" class="viewtable" style="border:1px solid #fff">
	<col width="155"></col>
	<col width="*"></col>
	<tr>
		<td class="tabletd" style="vertical-align:top">
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
    <div style="position:relative; border:1px solid #ddd; width:98%; height:100px; padding:5px; overflow-y:scroll; margin-bottom:5px;">
    <?
      if($req['gidx']){
        echo "<ul class='member_list'>";
        foreach($req['gidx'] as $gkey => $gvalue){
          $mid = decrypt_md5($gvalue,"mid");      
          $Mem = $db -> SelectOne("Select replace(m_hp,'-','') as hp From G_Member Where m_id = '".$mid."' ");
          if($Mem){
            echo "<li>".$Mem['hp']."<span class='close'></span></li>";
          }else{
            echo "연락처 없음<br/>";
          }
        }    
        echo "</ul>";
        
      }else{
        echo "선택된 회원이 없습니다.";
      }
    ?>
    </div>
    <table style="" class="formtable" style="border:1px solid #ddd;">
      <col width="70"></col>
      <col width="*"></col>
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
<div class="sms_act_btn" style="margin:10px 0; text-align:center" ><input type="image" src="../images/common/btn_sms_send.gif" border="0" id="submit_btn"> <img src="../images/common/btn_sms_refresh.gif" border="0" onclick="document.smsfrm.reset();" class="pointer">
</div>

</form>

</div>
<!-- //CONTENTS -->

</body>
</html>