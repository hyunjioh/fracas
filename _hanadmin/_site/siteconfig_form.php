<?
if(!defined("_g_board_include_")) exit;
$token = new_token($Board['board_id']);
require_once "../include/_header.inc.php";

$Value = $db -> SelectOne("select *  from ".$Board['table_board']." ");
?>
<script type="text/javascript" src="<?=_CORE_?>/plugin/SmartEditorBasic.0.3.17/js/HuskyEZCreator.js" ></script>
<link rel="stylesheet" type="text/css" href="<?=_CORE_?>/js/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
//<![CDATA[
function frmcheck(){
  var f = document.boardform;

}

//]]>
</script>
<script type="text/javascript">

$(document).ready(function() {
  $('#startdate').datetimepicker({
    numberOfMonths: 3,
    hourGrid: 4,
    minuteGrid: 10,
    timeFormat: 'hh:mm:ss'
  });

  $('#enddate').datetimepicker({
    numberOfMonths: 3,
    hourGrid: 4,
    minuteGrid: 10,
    timeFormat: 'hh:mm:ss'
  });
});
</script>
</head>
<?  require_once "../include/_body_top.inc.php"; ?>


      <form name="boardform" method="post" enctype="multipart/form-data" onsubmit="return frmcheck();" action="<?=$Board['Link']?>?at=dataprocess">
      <input type="hidden" name="token" value="<?=$token?>">
      <input type="hidden" name="idx" value="<?=$Value['idx']?>">
      <input type="hidden" name="am" value="updateData">
      <input type="hidden" name="_referer_" value="<?=$req['ref']?>">

			<h3 class="sub-page-title"><span>SMS</span></h3>
      <table cellspacing="0" cellpadding="0" class="formtable">
				<col width="150"></col>
				<col width="*"></col>
        <tr>
          <th class="tableth">발신번호</th>
          <td class="tabletd"><input type="text" name="sms_callback" value="<?=$Value['sms_callback']?>" size="20" class="input"></td>
        </tr>
			</table>

			<h3 class="sub-page-title"><span>E-mail</span></h3>
      <table cellspacing="0" cellpadding="0" class="formtable">
				<col width="150"></col>
				<col width="*"></col>
        <tr>
          <th class="tableth">발신 E-mail</th>
          <td class="tabletd"><input type="text" name="postmaster_email" value="<?=$Value['postmaster_email']?>" size="50" class="input" maxlength="80"></td>
        </tr>
        <tr>
          <th class="tableth">발신 E-mail 이름</th>
          <td class="tabletd"><input type="text" name="postmaster_name" value="<?=$Value['postmaster_name']?>" size="50" class="input" maxlength="80"></td>
        </tr>
      </table>
      <div style="margin:20px 0 50px; text-align:center"><input type="image" src="../images/btn_ok.gif" style="cursor:pointer;"></div>
      <!--// list -->
    </form>

<? include "../include/_body_bottom.inc.php"; ?>
<? include "../include/_footer.inc.php"; ?>
