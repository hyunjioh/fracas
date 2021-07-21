<?php
if(!defined("_g_board_include_")) exit; 

$req['idx'] = Request("idx");
$req['date'] = Request("date");
if(!$req['date']) $req['date'] = date("Y-m-d");

$req['startdate'] = $req['date'];
$req['starttime'] = "09:00";
$req['enddate'] = $req['date'];
$req['endtime'] = "18:00";

/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */	
unset($db);
$db = new MySQL;

if($req['idx']){
  $title = "일정수정";
  $mode = "updateData";
  $Query = "Select * from ".$Board['table_board']." Where idx = '".$req['idx']."'  ";
  $Value  = $db -> SelectOne($Query);
  $Value['starttime'] = substr($Value['startdate'],11,5);
  $Value['startdate'] = substr($Value['startdate'],0,10);
  $Value['endtime'] = substr($Value['enddate'],11,5);
  $Value['enddate'] = substr($Value['enddate'],0,10);
}else{
  $title = "일정입력";
  $mode = "newData";
  $Value['startdate'] = $req['startdate'];
  $Value['starttime'] = $req['starttime'];
  $Value['enddate'] = $req['enddate'];
  $Value['endtime'] = $req['endtime'];

  $Value['Subject'] = $req['Subject'];
  $Value['Content'] = $req['Content'];
}


?>
<script>
  var objid = '#scheduleInfo';
</script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery.clockpick.1.2.9/jquery.clockpick.1.2.9.js"></script>
<link rel="stylesheet" href="<?=_CORE_?>/js/jquery.clockpick.1.2.9/jquery.clockpick.1.2.9.css" type="text/css">
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	$('#load').hide();
  $("input[name=Subject]").focus();
});

function schedulesubmit(){
    if( $.trim($("input[name=Subject]").val()) == '' ){
      alert("제목을 입력해 주세요.");
      $("input[name=Subject]").focus();
      return false;
    }
    
    // 데이터 입력
    $.ajax({
        type: 'POST'
        , async: true
	      , dataType : "json" //전송받을 데이터의 타입
        , url: './?at=dataprocess'
        , data: $("#boardform").serialize()
        , beforeSend: function() {
        		$('#submit_btn').hide();
            $('#del_btn').hide();
						$('#load').show().fadeIn('fast');
          }
				, success : function(response, status, request) {
						if(response){
              setTimeout(function() {
                if(response.error == "Y"){
                  alert(response.msg);
                  $('#load').hide();
                  $('#submit_btn').show().fadeIn('fast');
                  $('#del_btn').show().fadeIn('fast');
                  if(loginidval){
                    $("#passwd").val('').focus();                  
                  }else{
                    $("#passwd").val('');
                    $("#loginid").val('').focus();
                  }
                  return false;
                }
                if(response.error == "N"){
                  //alert(response.msg);
                  $(".overlay").overlay().close();  
                  $('#calendar').fullCalendar( 'destroy' );
                  fullcalendar();
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


$(document).ready(function() {

		$("#clockpick").clockpick(
		{ 

				military : true,
				valuefield: 'starttime'			
		},
		cback); 

		$("#clockpick2").clockpick(
		{ 
				military : true,
				valuefield: 'endtime'			
		}); 


		$("#startdate").datepicker( {
			dateFormat : "yy-mm-dd" ,
			showOn: "button",
			buttonImage: "../images/search/calendar.png",
			buttonImageOnly: true				
		});
		$("#enddate").datepicker( {
			minDate: $("#startdate").val(),
			dateFormat : "yy-mm-dd" ,
			showOn: "button",
			buttonImage: "../images/search/calendar.png",
			buttonImageOnly: true				
		});

		$( "#startdate" ).change(function() {
			$("#enddate").val($("#startdate").val())
			$("#enddate").datepicker( {
				minDate: $("#startdate").val(),
				dateFormat : "yy-mm-dd" ,
				showOn: "button",
			buttonImage: "../images/search/calendar.png",
				buttonImageOnly: true				
			});
		});
});

function cback(){
	$("#endtime").val($("#starttime").val());
}

function delcheck(f){
	if(confirm("정말로 삭제하시겠습니까?")){
		$("input[name=am]").val("deleteData");

    
    // 데이터 입력
    $.ajax({
        type: 'POST'
        , async: true
	      , dataType : "json" //전송받을 데이터의 타입
        , url: './?at=dataprocess'
        , data: $("#boardform").serialize()
        , beforeSend: function() {
            $('#del_btn').hide();
        		$('#submit_btn').hide();
						$('#load').show().fadeIn('fast');
          }
				, success : function(response, status, request) {
						if(response){
              setTimeout(function() {
                if(response.error == "Y"){
                  alert(response.msg);
                  $('#load').hide();
                  $('#submit_btn').show().fadeIn('fast');
                  $('#del_btn').show().fadeIn('fast');
                  if(loginidval){
                    $("#passwd").val('').focus();                  
                  }else{
                    $("#passwd").val('');
                    $("#loginid").val('').focus();
                  }
                  return false;
                }
                if(response.error == "N"){
                  //alert(response.msg);
                  $(".overlay").overlay().close();  
                  $('#calendar').fullCalendar( 'destroy' );
                  fullcalendar();
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
}
//]]>
</script>
<style>
.input-date {background:#eee}
</style>
<div id="scheduleInfo">
<h2><?=$title?></h2>
<form name="boardform" id="boardform" method="post" onsubmit="return schedulesubmit();">
<input type="hidden" name="Html"  value="N">

<input type="hidden" name="idx" value="<?=$Value['idx']?>">
<input type="hidden" name="pagenumber" value="<?=$req['pagenumber']?>">
<input type="hidden" name="am" value="<?=$mode?>">
<input type="hidden" name="_referer_" value="<?=$req['ref']?>">
<table width="100%" cellspacing="0" cellpadding="0" class="viewtable" style="border:2px solid #fff; border-bottom:1px solid #cccccc">
	<col width="100"></col>
	<col width=""></col>
	<tr>
		<th class="tableth">날짜/시간</th>
		<td class="tabletd">
		<input type="text" name="startdate" id="startdate" size="10" class="input-date"  value="<?=$Value["startdate"]?>"  style="IME-MODE: active;" readonly>
		&nbsp;
		<input type="text" name="starttime" id="starttime" size="5"  class="input-date"  value="<?=$Value["starttime"]?>" readonly style="width:50px;"><IMG src="images/clock.png" id="clockpick" align="middle" style="cursor:pointer"> 
		
		&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;

		<input type="text" name="enddate" id="enddate" size="10" class="input-date" value="<?=$Value["enddate"]?>"  style="IME-MODE: active;" readonly>
		&nbsp;
		<input type="text" name="endtime" id="endtime" size="5"  class="input-date" value="<?=$Value["endtime"]?>" readonly style="width:50px;"><IMG src="images/clock.png" id="clockpick2" align="middle" style="cursor:pointer">
		</td>
	</tr>
	<tr>
		<th class="tableth">제목</th>
		<td class="tabletd"><input type="text" name="Subject" maxlength="255" class="input" style="width:300px" value="<?=$Value['Subject']?>"></td>
	</tr>
	<tr>
		<th class="tableth">내용</th>
		<td class="tabletd"><textarea name="Content" id="Content" style="width:95%; height:80px"><?=$Value['Content']?></textarea></td>
	</tr>
</table>
<div id="load" align="center" style="margin-top:10px;"><img src="../images/common/loader_Submit.gif" align="absmiddle" width="24" height="24" /></div>
<div style="margin:10px 0; text-align:center" ><input type="image" src="../images/btnA/btn_confirm.gif" align="middle" id="submit_btn">
<? if($mode == "updateData"){?>
<img src="../images/btnA/btn_delete.gif" align="middle" style="cursor:pointer" onclick="delcheck('<?=$value['idx']?>');" id="del_btn">
<? } ?>
</div>

</form>
</div>