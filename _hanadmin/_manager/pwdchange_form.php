<?
	if(!defined("_g_board_include_")) exit;
	require_once "../include/_header.inc.php";

  $token = new_token($Board['board_id']);
	$mode = "passwdUpdate";
?>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
	if( $.trim($("#oldpasswd").val()) == '' ){
			alert("현재비밀번호를 입력해 주세요.");
			$("#oldpasswd").select();
			return false;
	}
	if( $.trim($("#passwd1").val()) == '' ){
			alert("변경하실 비밀번호를 입력해 주세요.");
			$("#passwd1").select();
			return false;
	}
	if( $.trim($("#passwd1").val()).length < 4 || $.trim($("#passwd1").val()).length > 16 ){
			alert("비밀번호는 4~16자리 입니다.");
			$("#passwd1").select();
			return false;
	}

	if( $.trim($("#passwd2").val()) == '' ){
			alert("변경하실 비밀번호를 입력해 주세요.");
			$("#passwd2").select();
			return false;
	}
	if( $.trim($("#passwd1").val()) != $.trim($("#passwd2").val())   ){
			alert("변경하실 비밀번호가 서로 같지 않습니다.\n\n다시 입력하여 주세요.");
			$("#passwd1").select();
			return false;
	}
  return true;
}

//]]>
</script>
</head>
<?	require_once "../include/_body_top.inc.php"; ?>


    <form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
    <input type="hidden" name="token" value="<?=$token?>">
    <input type="hidden" name="Html"  value="Y">

    <input type="hidden" name="idx" value="<?=$req['idx']?>">
    <input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
    <input type="hidden" name="am" value="<?=$mode?>">
    <input type="hidden" name="_referer_" value="<?=$req['ref']?>">






      <!-- list -->


        <h3 class="sub-page-title"><span>비밀번호 변경</span></h3>
        <table cellspacing="0" cellpadding="0" class="formtable">
					<col width="200"></col>
					<col width="*"></col>
          <tr>
            <th class="tableth f11">현재비밀번호</th>
            <td class="tabletd left" colspan="3"><input type="password" style="width:150px" class="input" name="orgpasswd" id="oldpasswd" maxlength="16"></td>
          </tr>

          <tr>
            <th class="tableth f11">변경하실 비밀번호</th>
            <td class="tabletd left" colspan="3"><input type="password" style="width:150px" class="input" name="passwd1" id="passwd1" maxlength="16"></td>
          </tr>
          <tr>
            <th class="tableth f11">변경하실 비밀번호(재입력)</th>
            <td class="tabletd left" colspan="3"><input type="password" style="width:150px" class="input" name="passwd2" id="passwd2" maxlength="16"></td>
          </tr>

        </table>
        <div style="margin:20px 0 50px; text-align:center"><input type="image" src="../images/btn_ok.gif" style="cursor:pointer;"> <a href="<?=$href?>"><img src="../images/btn_cancel.gif"  style="cursor:pointer;"></a></div>
      <!--// list -->
    </form>




<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>
