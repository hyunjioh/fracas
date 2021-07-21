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
ul.member_list {  padding-bottom:3px; }
ul.member_list:after { content:''; display:block; clear:both;}
ul.member_list li {   float:left;   border:1px solid #ddd; background:#eee; margin-right:3px; margin-bottom:3px; padding-left:3px; padding-right:21px; position:relative; }

ul.member_list li .close {background:url(../images/icon/select_list_del.png); width:16px; height:16px; position:absolute; right:2px; top:2px; cursor:pointer;   }
</style>
<script type="text/javascript">
$(document).ready(function(){
  $(".close").click(function(){
    $(this).hide().parent().animate({ opacity: 0.25, width: 'toggle' }, 1000, function() { $(this).remove(); });

  });
});
</script>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$('.load_btn').hide();
});
function emailSend(){
  if( $(".member_list li").length < 1){
    alert("수신할 회원이 없습니다.");
    return false;
  }else{
    $(".member_list li").each(function(){
      input = "<input type='hidden' name='to_list[]' value='"+$(this).text()+"'>";
      $("#emailfrm").append(input);
    });
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
      , url: '<?=_CORE_?>/act/?at=selectsendemail'
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
	<span class="title">E-mail 전송</span>
	<span class="btn"><a href="#close" onclick="window.close();"><img src="../images/btn_x.gif" alt="닫기" /></a></span>
</h2>


<!-- CONTENTS -->
<div class="popContents">

  <div style="position:relative; border:1px solid #ddd; width:730px; height:120px; padding:3px; overflow-y:scroll; margin-bottom:10px;">
  <?
    if($req['gidx']){
      echo "<ul class='member_list'>";
      foreach($req['gidx'] as $gkey => $gvalue){
        $mid = decrypt_md5($gvalue,"mid");      
        $Mem = $db -> SelectOne("Select m_email as email From G_Member Where m_id = '".$mid."' ");
        if($Mem){
          echo "<li>".$Mem['email']."<span class='close'></span></li>";
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

<form name="emailfrm" id="emailfrm"  method="post" onsubmit="return emailSend();">
<table style="" class="formtable" style="border:1px solid #ddd; ">
  <col width="70"></col>
  <col width="*"></col>
  <tr>
    <th class="tableth f11">발신</th>
    <td class="tabletd left"><?=$site['postmaster_name']?> &lt; <?=$site['postmaster_email']?> &gt;</td>
  </tr>
  <tr>
    <th class="tableth f11">제목</th>
    <td class="tabletd left"><input type="text" name="title" class="input" style="width:500px;border:1px solid #C0C0C0" value=""></td>
  </tr>
  <tr>
    <td class="tabletd" colspan="2"><textarea style="width:100%; height:180px;" id="Content" name="Content"></textarea></td>
  </tr>
</table>
<div class="load_btn" align="center" style="margin-top:10px; background: none transparent"><img src="../images/common/loader_Submit.gif" align="absmiddle" width="24" height="24" /></div>
<div class="email_act_btn"  style="margin:10px 0; text-align:center" ><input type="image" src="../images/common/btn_sms_send.gif" border="0" id="submit_btn"> <img src="../images/common/btn_sms_refresh.gif" border="0" onclick="document.emailfrm.reset();" class="pointer">
</div>

</form>

</div>
<!-- //CONTENTS -->

</body>
</html>

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