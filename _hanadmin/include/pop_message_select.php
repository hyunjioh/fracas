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
</head>
<body class="pop">

<h2>
	<span class="title">쪽지 전송</span>
	<span class="btn"><a href="#close" onclick="window.close();"><img src="../images/btn_x.gif" alt="닫기" /></a></span>
</h2>


<!-- CONTENTS -->
<div class="popContents">

  <div style="position:relative; border:1px solid #ddd; width:660px; height:160px; padding:10px; overflow-y:scroll; margin-bottom:10px;">
  <?
    if($req['gidx']){
      echo "<ul class='member_list'>";
      foreach($req['gidx'] as $gkey => $gvalue){
        $mid = decrypt_md5($gvalue,"mid");      
        $Mem = $db -> SelectOne("Select m_id as id From G_Member Where m_id = '".$mid."' ");
        if($Mem){
          echo "<li>".$Mem['id']."<span class='close'></span></li>";
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

  
<form name="messagefrm" id="messagefrm"  method="post" onsubmit="return messageSend();">
<input type="hidden" name="fromid" value="<?=$MemberID?>">

    <table style="" class="formtable" style="border:1px solid #ddd; ">
      <col width="70"></col>
      <col width="*"></col>
      <tr>
        <th class="tableth f11">발신</th>
        <td class="tabletd left"><?=$MemberName?> &lt; <?=$MemberID?> &gt;</td>
      </tr>
      <tr>
        <th class="tableth f11">제목</th>
        <td class="tabletd left"><input type="text" name="Subject" class="input" style="width:400px " value=""></td>
      </tr>
      <tr>
        <td class="tabletd" colspan="2"><textarea style="width:100%; height:80px; border:1px solid #ddd" id="Content" name="Content"></textarea></td>
      </tr>
    </table>

<div class="load_btn" align="center" style="margin-top:10px; background: none transparent"><img src="../images/common/loader_Submit.gif" align="absmiddle" width="24" height="24" /></div>
<div class="message_act_btn"  style="margin:10px 0; text-align:center" ><input type="image" src="../images/common/btn_sms_send.gif" border="0" id="submit_btn"> <img src="../images/common/btn_sms_refresh.gif" border="0" onclick="document.messagefrm.reset();" class="pointer">
</div>

</form>
</div>
<!-- //CONTENTS -->

</body>
</html>