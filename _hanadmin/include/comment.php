<?
require_once "../../_core/_lib.php";
require_once _CORE_PATH_."/system/function.common.php";
$json = null;
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */
unset($db);
$db = new MySQL($mysql1);

/*-------------------------------------------------------------------------------------------------
▶ 환경설정 */
// 페이징
$cfg['page_block'] = 10;
$cfg['page_limit'] = 10;


$cfg['btn_first'] = "";
$cfg['btn_last'] = "";

$cfg['btn_prev'] = "<";
$cfg['btn_next'] = ">";

$cfg['page_sp'] = null;

// 코멘트
$cfg['maxLength'] = 400;

###################################################################################################
/*
  - Comment 작성폼
*/
###################################################################################################
if(!isset($_POST['cmode'])) {
?>
<script src="<?=_CORE_?>/js/jquery.textareaCounter.plugin.js" type="text/javascript"></script>
<style>
#comment_loader {
	position:absolute;
  left:260px;
  top:120px;
	background-image:url(../images/common/loading-bg.png);
	background-position:center;
	background-repeat:no-repeat;
	width:159px;
	color:#999;
	font-size:18px;
	font-family:Arial, Helvetica, sans-serif;
	height:40px;
	font-weight:300;
	padding-top:10px;
  z-index:10;
}

</style>
<script type="text/javascript">
//<![CDATA[
// Cross Browser Word Breaker with jQuery
// Usage : $('[search]').breakWords();
 (function($) {
    $.fn.breakWords = function() {
        this.each(function() {
            if (this.nodeType !== 1) { return; }

            if (this.currentStyle && typeof this.currentStyle.wordBreak === 'string') {
                this.runtimeStyle.wordBreak = 'break-all';
            } else if (document.createTreeWalker) {
                var trim = function(str) {
                    str = str.replace(/^\s\s*/, '');
                    var ws = /\s/, i = str.length;
                    while (ws.test(str.charAt(--i)));
                    return str.slice(0, i + 1);
                };            //For Opera, Safari, and Firefox
                var dWalker = document.createTreeWalker(this, NodeFilter.SHOW_TEXT, null, false);
                var node, s, c = String.fromCharCode('8203');
                while (dWalker.nextNode()) {
                    node = dWalker.currentNode;
                    s = trim(node.nodeValue).split('').join(c);
                    node.nodeValue = s;
                }
            }
        });
        return this;
    };
})(jQuery);



$(document).ready(function(){
  $(".form_comment").hide();
  $("#hiddenForm").hide();
  $('#comment_loader').hide();
  CommentList(1);
  $('.nowrap').breakWords();
});

function CommentClose(obj){
$(obj).parent().parent().parent().slideUp({easing: "easeInOutBack"});
}

function CommentTotal(){
  $.ajax({
      type : "POST" //"POST", "GET"
      , async : true //true, false
      , url : "../include/comment.php" //Request URL
      , dataType : "html" //전송받을 데이터의 타입
                          //"xml", "html", "script", "json" 등 지정 가능
                          //미지정시 자동 판단
      , timeout : 30000 //제한시간 지정
      , cache : false  //true, false
//      , data : $("#cform").serialize()+"&cmode=list" //서버에 보낼 파라메터
      , data : $("#cform").serialize()+"&cmode=total" //서버에 보낼 파라메터

      //form에 serialize() 실행시 a=b&c=d 형태로 생성되며 한글은 UTF-8 방식으로 인코딩
      //"a=b&c=d" 문자열로 직접 입력 가능
      //{a:b, c:d} json 형식 입력 가능
      //, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
      , error : function(request, status, error) {
       //통신 에러 발생시 처리
       alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
      }
      , success : function(response, status, request) {
       //통신 성공시 처리
       if(response){
         $('#commentCount').html(response).fadeIn();
       }
      }
  });
}

function CommentList(pn){

  if(pn == "")pn = 1;
  $.ajax({
      type : "POST" //"POST", "GET"
      , async : true //true, false
      , url : "../include/comment.php" //Request URL
      , dataType : "html" //전송받을 데이터의 타입
                          //"xml", "html", "script", "json" 등 지정 가능
                          //미지정시 자동 판단
      , timeout : 30000 //제한시간 지정
      , cache : false  //true, false
//      , data : $("#cform").serialize()+"&cmode=list" //서버에 보낼 파라메터
      , data : $("#cform").serialize()+"&cmode=list&pn="+pn //서버에 보낼 파라메터

      //form에 serialize() 실행시 a=b&c=d 형태로 생성되며 한글은 UTF-8 방식으로 인코딩
      //"a=b&c=d" 문자열로 직접 입력 가능
      //{a:b, c:d} json 형식 입력 가능
      //, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
      , error : function(request, status, error) {
       //통신 에러 발생시 처리
       alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
      }
      , success : function(response, status, request) {
       //통신 성공시 처리
       $('#CommentLIST').html(response).fadeIn();
       CommentTotal();
        /*
         var commentlen = $('.comment').length;
         $('#CommentLIST').prepend(response).find("#comment"+idx).hide().slideDown('slow');
				 $('#comment_loader').fadeOut();
         if(commentlen > 9){
           $('.comment:last').remove();
         }
         */

      }
      , beforeSend: function() {
       //통신을 시작할때 처리
       $('#comment_loader').show().fadeIn('fast');
      }
      , complete: function() {
       //통신이 완료된 후 처리
       $('#comment_loader').fadeOut();
      }
  });
}

function CommentAct(mode, msg, md, idx){
  <?
    if(!$MemberID){
      echo "RequireLogin();\n";
    }else{
  ?>
  if(mode == "") return;
  if(msg != ""){
    if(md == "CHECK") {
      if($.trim($("#"+msg).val()) == ""){
        alert("내용을 입력해 주세요.");
        $("#"+msg).focus();
        return;
      }
    }else{
      if(!confirm(msg)) return;
    }
  }

  $.ajax({
      type : "POST" //"POST", "GET"
      , async : true //true, false
      , url : "../include/comment.php" //Request URL
      , dataType : "json" //전송받을 데이터의 타입
                          //"xml", "html", "script", "json" 등 지정 가능
                          //미지정시 자동 판단
      , timeout : 30000 //제한시간 지정
      , cache : false  //true, false
//      , data : $("#cform").serialize()+"&cmode=list" //서버에 보낼 파라메터
      , data : $("#cform").serialize()+"&cmode=act&mode="+mode //서버에 보낼 파라메터

      //form에 serialize() 실행시 a=b&c=d 형태로 생성되며 한글은 UTF-8 방식으로 인코딩
      //"a=b&c=d" 문자열로 직접 입력 가능
      //{a:b, c:d} json 형식 입력 가능
      , contentType: "application/x-www-form-urlencoded; charset=UTF-8"
      , error : function(request, status, error) {
       //통신 에러 발생시 처리
       alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
      }
      , success : function(response, status, request) {
       //통신 성공시 처리

        if(response != null){
          if(response.error == "Y"){
            alert(response.msg);
          }else{
            $(".comment").find("textarea").val('');
            CommentList('');
          }
        }else{
          alert("config error");
        }
      }
      , beforeSend: function() {
       //통신을 시작할때 처리
       //$('#ajax_indicator').show().fadeIn('fast');
      }
      , complete: function() {
       //통신이 완료된 후 처리
       //$('#ajax_indicator').fadeOut();
      }
  });
  <? } ?>
}


function CommenReply(at, idx, len){
   var classname = "";
   var textareaWidth = "style='width:85\%; height:50px;'";
   if(len == "2"){
     classname = "class='pd_l_25'";
   var textareaWidth = "style='width:84\%; height:50px;'";
   }
   if(len == "3"){
     classname = "class='pd_l_50'";
   var textareaWidth = "style='width:83\%; height:50px;'";
   }
   $("#hiddenForm  textarea").val('');
   var strHtml = $("#hiddenForm").html();
   strHtml = strHtml.replace(/IDX/g, idx);
   strHtml = strHtml.replace(/counter_form/g, 'counter_form'+idx);
   strHtml = strHtml.replace(/Content_form/g, 'Content_form'+idx);
   strHtml = strHtml.replace(/MODE/g, at);
   strHtml = strHtml.replace(/IDX/g, idx);
   strHtml = strHtml.replace(/PADCLASS/g, classname);
   strHtml = strHtml.replace(/TEXTAREASTYLE/g, textareaWidth);

   $(".form_comment").html('').hide().slideUp({easing: "easeInOutBack"});
   $("#commentform"+idx).append(strHtml).hide().slideDown({easing: "easeOutBounce"});
}

function CommentUpdate(at, idx, len){
   var classname = "";
   var textareaWidth = "style='width:85\%; height:50px;'";
   if(len == "2"){
     classname = "class='pd_l_25'";
   var textareaWidth = "style='width:84\%; height:50px;'";
   }
   if(len == "3"){
     classname = "class='pd_l_50'";
   var textareaWidth = "style='width:83\%; height:50px;'";
   }
   $("#hiddenForm  textarea").val($("#comment"+idx).find("#commentBody"+idx).html());
   var strHtml = $("#hiddenForm").html();

   strHtml = strHtml.replace(/IDX/g, idx);
   strHtml = strHtml.replace(/cbyte_form/g, 'counter_form'+idx);
   strHtml = strHtml.replace(/Content_form/g, 'Content_form'+idx);
   strHtml = strHtml.replace(/MODE/g, at);
   strHtml = strHtml.replace(/IDX/g, idx);

   strHtml = strHtml.replace(/PADCLASS/g, classname);
   strHtml = strHtml.replace(/TEXTAREASTYLE/g, textareaWidth);

   $(".form_comment").html('').hide().slideUp({easing: "easeInOutBack"});
   $("#commentform"+idx).append(strHtml).hide().slideDown({easing: "easeOutBounce"});
}


function CheckLength(objTextarea, objByte, limitLength) {
  <?
    if(!$MemberID){
      echo "RequireLogin();";
      echo "$(objTextarea).val('')";
    }else{
  ?>
  var msgtext, msglen;

    msgtext = objTextarea.value;
    limitLengthKor = limitLength/2;

    var i=0,l=0;
    var temp,lastl;

    //길이를 구한다.
    while(i < msgtext.length)
    {
        temp = msgtext.charAt(i);

        if (escape(temp).length > 4)
            l+=2;
        else if (temp!='\r')
            l++;
        // OverFlow
        if(l>limitLength)
        {
            //alert(l);
            alert("한글 "+limitLengthKor+"자, 영문"+limitLength+"자까지만 쓰실 수 있습니다.");
            temp = objTextarea.value.substr(0,i);
            objTextarea.value = temp;
            l = lastl;
            break;
        }
        lastl = l;
        i++;
    }
//	if(objByte != false)  objByte.value=l;
	if(objByte != false){
    $("."+objByte).html(l);
  }
  <? } ?>
}

//]]>
</script>

		<div class="bgcolor">
			<ul class="in">
				<li><textarea  name="Comment" id="Comment_form" style="width:85%; height:50px;" onchange="if(event.keyCode == 13){ event.returnValue=false;}else{CheckLength(this, 'counter',<?=$cfg['maxLength']?>);}" onkeyup="if(event.keyCode == 13){ event.returnValue=false;}else{CheckLength(this, 'counter',<?=$cfg['maxLength']?>);}" onkeypress="if(event.keyCode == 13){ event.returnValue=false;}else{CheckLength(this, 'counter',<?=$cfg['maxLength']?>,'');}" <? if(!$MemberID) echo "readonly"; ?> wrap="hard" cols="80" ></textarea>&nbsp;&nbsp;<img src="../images/btn/comment_btn_save.gif" alt="등록" class="cur_pointer" onClick="CommentAct('<?=encrypt_md5("newData_","actmode")?>','Comment_form','CHECK');" /></li>
				<li class="count"><b class="counter">0</b> / <?=$cfg['maxLength']?></li>
			</ul>
		</div>

    <div id="hiddenForm">
      <ul class="in">
        <li PADCLASS><textarea name="Content" id="Content_form" TEXTAREASTYLE onchange="if(event.keyCode == 13){ event.returnValue=false;}else{CheckLength(this, 'counter_form',<?=$cfg['maxLength']?>);}"  onkeyup="if(event.keyCode == 13){ event.returnValue=false;}else{CheckLength(this, 'counter_form',<?=$cfg['maxLength']?>);}" onkeypress="if(event.keyCode == 13){ event.returnValue=false;}else{CheckLength(this, 'counter_form',<?=$cfg['maxLength']?>,IDX);}" <? if(!$MemberID) echo "readonly"; ?> wrap="hard" cols="80">HTML</textarea>&nbsp;&nbsp;<img src="../images/btn/comment_btn_save.gif" alt="등록" class="cur_pointer" onClick="CommentAct('MODE','Content_form','CHECK');"/></li>
        <li class="count"><img src="../images/btn/comment_btn_close.gif" alt="닫기"  onclick="CommentClose(this);" class="cur_pointer"/>&nbsp;&nbsp;&nbsp;<b class="counter_form">0</b> / <?=$cfg['maxLength']?></li>
      </ul>
    </div>


<?
}else{
  if(!$req['BoardID'] || !$req['Pidx']){
//    exit;
  }


    $Board['page_block']      = $cfg['page_block'];
    $Board['page_limit']      = $cfg['page_limit'];



###################################################################################################
/*
  - Comment 목록
*/
###################################################################################################
  $_POST['cmode'] = trim($_POST['cmode']);
  if($_POST['cmode'] == "list"){

    $req['TableName'] = Request("tid");
    $req['BoardID']   = Request("bid");
    $req['Pidx']      = Request("pid");

    $req['UserID']    = Request("uid");
    $req['UserName']  = Request("unm");

    $req['pagenumber']      = Request("pn");
    $req['page_block']      = $cfg['page_block'];
    $req['page_limit']      = $cfg['page_limit'];



    $Limit = "Limit ".(($req['pagenumber']-1)*$req['page_limit']).", ".$req['page_limit'];
    $TOTAL = $db -> Total("Select count(*) from ".$req['TableName']." Where BoardID = '".$req['BoardID']."' and Pidx ='".$req['Pidx']."' ");

    $LIST  = $db -> SelectList("Select * from ".$req['TableName']." Where BoardID = '".$req['BoardID']."' and Pidx ='".$req['Pidx']."' Order by fid desc, thread asc ".$Limit);
    if($LIST){
      foreach($LIST as $key => $value){
        $reply  = false;
        $modify = false;
        $delete = false;
        $reicon = null;
        $threadLength = null;
        $reClass1 = null;
        $reClass2 = null;

        $threadLength = strlen($value['thread']);

        if($threadLength > 1){
          $reicon = "<img src=\"../images/icon/ico_re.gif\" alt=\"\"  class=\"vt_mid\"/>";

          if($threadLength <3 ){
            $reClass1 = null;
            $reClass2 = "class=\"pd_l_25\"";
          }elseif($threadLength <4 ){
            $reClass1 = "class=\"pd_l_25\"";
            $reClass2 = "class=\"pd_l_50\"";
          }
        }

        //if($value['UserID'] == $req['UserID']){
          $reply  = true;
          $modify = true;
          $delete = true;
        //}

        if($value['DelYN'] == "Y"){
          $reply  = false;
          $modify = false;
        }

       if($threadLength > 2 ) $reply  = false;
    ?>
    <?  if($threadLength == 1 || ($key == 0) ) {?>
		<div class="dotline"></div>
    <? } ?>
		<ul class="in" id="comment<?=$value['idx']?>">
			<li <?=$reClass1?>><?=$reicon?><span class="idName"><?=$value['UserName']?></span><span class="date"><?=$value['RegDate']?></span>&nbsp;&nbsp;&nbsp;
      <? if($reply){ ?>
      <a href="javascript:CommenReply('<?=encrypt_md5("replyData_".$value['idx'],"actmode")?>','<?=$value['idx']?>','<?=$threadLength?>')"><img src="../images/btn/comment_btn_reply.gif" alt="답글" /></a>
      <? } ?>
      <? if($modify){ ?>
      <a href="javascript:CommentUpdate('<?=encrypt_md5("updateData_".$value['idx'],"actmode")?>','<?=$value['idx']?>','<?=$threadLength?>')"><img src="../images/btn/comment_btn_modify.gif" alt="수정" /></a>
      <? } ?>
      <? if($delete){ ?>
      <a href="javascript:CommentAct('<?=encrypt_md5("deleteData_".$value['idx'],"actmode")?>','정말로 삭제하시겠습니까?','')"><img src="../images/btn/comment_btn_del.gif" alt="삭제" /></a>
      <? } ?>
			</li>
			<li <?=$reClass2?>  ><table width="100%" style="table-layout:fixed"><tr><td id="commentBody<?=$value['idx']?>" class="nowrap"><?=nl2br($value['Comment'])?></td></tr></table></li>
      <div class="form_comment" id="commentform<?=$value['idx']?>"></div>
		</ul>


    <?
      }
    }

    $func = "CommentList";
    $Board['page_skin'] = "type2";
    include dirname(__FILE__)."/page.inc.php";





###################################################################################################
/*
  - Comment 전체개수
*/
###################################################################################################
  }elseif($_POST['cmode'] == "total"){

    $req['TableName'] = Request("tid");
    $req['BoardID']   = Request("bid");
    $req['Pidx']      = Request("pid");

    $req['UserID']    = Request("uid");
    $req['UserName']  = Request("unm");

    $req['pagenumber']      = Request("pn");
    $req['page_block']      = $cfg['page_block'];
    $req['page_limit']      = $cfg['page_limit'];

    $TOTAL = $db -> Total("Select count(*) from ".$req['TableName']." Where BoardID = '".$req['BoardID']."' and Pidx ='".$req['Pidx']."' ");
    echo $TOTAL;

###################################################################################################
/*
  - 데이터 처리
*/
###################################################################################################
  }elseif($_POST['cmode'] == "act"){
    if(!isset($_SERVER['HTTP_REFERER'])) exit;
    if (!eregi($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])) exit;

    $req['am'] = Request("mode");
    $req['TableName'] = Request("tid");
    $req['BoardID']   = Request("bid");
    $req['Pidx']      = Request("pid");

    $req['UserID']    = Request("uid");
    $req['UserName']  = Request("unm");
    $req['Comment']   = Request("Comment");

    if(!$req['am']) {
      $json['error'] = "Y";
      $json['msg']   = "잘못된 접근입니다.";
    }else{
      $mode = "";
      $idx = "";
      $req['am'] = decrypt_md5($req['am'],"actmode");

      list($mode, $idx) = explode("_",$req['am']);


      if(!$req['TableName'] || !$req['BoardID'] || !$req['Pidx'] ){
        $json['error'] = "Y";
        $json['msg']   = "필수정보 누락";
      }else{
        switch($mode):
					/*-------------------------------------------------------------------------------------------------
					▶ 새로운 글 등록 */
          case "newData":
            if(!$req['Comment']){
              $json['error'] = "Y";
              $json['msg']   = "내용을 입력하세요.";
            }else{
              # 새로 작성된 게시물의 fid(family id), uid(unique id)값을 결정한다. */
              $CHECK = $db->Value("SELECT max(fid) as maxfid FROM ".$req['TableName'] ." Where BoardID = '".$req['BoardID']."'");
              if($CHECK) { $new_fid = $CHECK + 1;} else { $new_fid = 1;}
              $Fid    = $new_fid;
              $Thread = "A";
              $Field = array(
                "fid"			    => $Fid,
                "thread"      => $Thread,
                "BoardID"     => $req['BoardID'],
                "Pidx"        => $req['Pidx'],

                "UserID"      => $req['UserID'],
                "UserName"    => $req['UserName'],

                "Comment"     => $req['Comment'],

                "RegID" 	    => $req['UserID'],
                "RegIP" 	    => ip_addr(),
                "RegDate"     => $dateTime,
              );
              $Query = "INSERT INTO ".$req['TableName']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
              $RESULT = $db->ExecQuery($Query);
              if($RESULT > 0){
                $GETIDX = $db->Value("Select LAST_INSERT_ID() as idx");
                if($GETIDX)	$return = $GETIDX;
                else $return = 1;
                $json['error'] = "N";
                $json['id']    = $return ;
                $json['msg']   = "등록되었습니다.";
              }else{
                $json['error'] = "Y";
                $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
              }
            }

          break;


          case "updateData":
            $req['Comment']   = Request("Content");
            if(!$req['Comment']){
              $json['error'] = "Y";
              $json['msg']   = "내용을 입력하세요.";
            }else{
              $Query = sprintf("Update ".$req['TableName']." set Comment = '". $req['Comment']."' Where BoardID = '".$req['BoardID']."' and idx = %d", $idx);
              $RESULT = $db->ExecQuery($Query);
              if($RESULT > 0){
                $json['error'] = "N";
                $json['id']    = $return ;
                $json['msg']   = "수정되었습니다.";
              }elseif($RESULT == 0){
                $json['error'] = "Y";
                $json['msg']   = "변경된 내용이 없습니다.";
              }else{
                $json['error'] = "Y";
                $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
              }
            }

          break;

					/*-------------------------------------------------------------------------------------------------
					▶ 답변 글 등록 */
          case "replyData":
            $req['Comment']   = Request("Content");
            if(!$req['Comment']){
              $json['error'] = "Y";
              $json['msg']   = "내용을 입력하세요.";
            }else{
              $CHECK = $db -> SelectOne("SELECT fid, thread FROM ".$req['TableName'] ." Where BoardID = '".$req['BoardID']."' and idx = '".$idx."'");
              if(is_array($CHECK)) {
                $fid = $CHECK['fid'];
                $thread = $CHECK['thread'];

                # 원글의 입력값으로부터 답변글에 입력할 정보(정렬 및 indent에 필요한 thread필드값)를 뽑아낸다. */
                $SelectQuery  = "SELECT thread AS thread ,right(thread,1) as rightthread FROM ".$req['TableName'];
                $WhereQuery   = " WHERE BoardID = '".$req['BoardID']."' and fid = ".$fid." AND length( thread ) = length('".$thread."')+1 AND locate('".$thread."',thread) = 1";
                $OrderbyQuery = " ORDER BY thread DESC LIMIT 1";
                $DATA = $db -> SelectOne($SelectQuery.$WhereQuery.$OrderbyQuery);// 데이터를 가져온다.
                if(is_array($DATA)){
                  $thread_head = substr($DATA['thread'],0,-1);
                  $thread_foot = ++$DATA['rightthread'];
                  $new_thread = $thread_head . $thread_foot;
                }else{
                  $new_thread = $thread ."A";
                }
                $return  = array("fid" => $fid,"thread" => $new_thread);
              }

              $Field = array(
                "fid"			    => $return['fid'],
                "thread"      => $return['thread'],
                "BoardID"     => $req['BoardID'],
                "Pidx"        => $req['Pidx'],

                "UserID"      => $req['UserID'],
                "UserName"    => $req['UserName'],

                "Comment"     => $req['Comment'],

                "RegID" 	    => $req['UserID'],
                "RegIP" 	    => ip_addr(),
                "RegDate"     => $dateTime,
              );
              $Query = "INSERT INTO ".$req['TableName']." (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";
              $RESULT = $db->ExecQuery($Query);
              if($RESULT > 0){
                $GETIDX = $db->Value("Select LAST_INSERT_ID() as idx");
                if($GETIDX)	$return = $GETIDX;
                else $return = 1;
                $json['error'] = "N";
                $json['id']    = $return ;
                $json['msg']   = "등록되었습니다.";
              }else{
                $json['error'] = "Y";
                $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
              }
            }

          break;


					/*-------------------------------------------------------------------------------------------------
					▶ 글 삭제 */
          case "deleteData":
            $json = false;
            if(trim($idx) == ""){
              $json['error'] = "Y";
              $json['msg']   = "필수정보 누락";
            }else{
    					$CHECK = $db -> SelectOne("Select * from ".$req['TableName']." where BoardID = '".$req['BoardID']."' and  idx = '".$idx."'");
              if(!$CHECK){
                $json['error'] = "Y";
                $json['msg']   = "접근에러";
              }else{
                $REPLY = $db -> Value("Select idx from ".$req['TableName']." where BoardID = '".$req['BoardID']."' and  idx <> '".$idx."' and fid = '".$CHECK['fid']."' and thread like '".$CHECK['thread']."%' and length(thread) > ".strlen($CHECK['thread'])." ");

                if($REPLY){
                  if($CHECK['DelYN'] == "N"){
                    $Query = sprintf("Update ".$req['TableName']." set DelYN = 'Y', Comment = '본인 요청에 의해 삭제되었습니다.' Where BoardID = '".$req['BoardID']."' and idx = %d", $idx);
                    $RESULT = $db->ExecQuery($Query);
                  }else{
                    $json['error'] = "Y";
                    $json['msg']   = "답변이 존재하여 삭제되지 않습니다.";
                  }
                }else{
                  $Query = sprintf("Delete from ".$req['TableName']." Where BoardID = '".$req['BoardID']."' and idx = %d", $idx);
                  $RESULT = $db->ExecQuery($Query);
                }

                if(!$json){
                  if($RESULT > 0){
                    $json['error'] = "N";
                    $json['msg']   = "삭제되었습니다.";
                  }else{
                    $json['error'] = "Y";
                    $json['msg']   = "데이터 처리중 장애가 발생하였습니다.";
                  }
                }

              }
            }
          break;

          default :
            $json['error'] = "Y";
            $json['msg']   = "접근에러";
        endswitch;
      }
    }
    echo json_encode($json);
  }else{

  }
}
?>