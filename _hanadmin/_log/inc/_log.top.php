<!-- 차트 -->
<script src="<?=_CORE_?>/plugin/Highcharts-2.2.4/js/highcharts.src.js"></script>
<script src="<?=_CORE_?>/plugin/Highcharts-2.2.4/js/modules/exporting.js"></script>
<script src="<?=_CORE_?>/plugin/Highcharts-2.2.4/js/highcharts.skin.js"></script>
<!-- //차트 -->

<!-- datepicker -->
<script type='text/javascript' src='<?=_CORE_?>/js/jquery-ui-1.8.16.custom.min.js'></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="<?=_CORE_?>/js/jquery-ui-1.8.11.custom/themes/base/jquery.ui.all.css">
<script type="text/javascript">
jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: '년'};
	$.datepicker.setDefaults($.datepicker.regional['ko']);
});


$.datepicker.setDefaults({
	dateFormat : "yy-mm-dd" ,
   showOn: 'both',
   buttonImageOnly: true,
   buttonImage: './images/calendar.png',
   buttonText: 'Calendar'
});

$(document).ready(function() {
	$("#onedate").datepicker( {
		showOn: "button",
    maxDate: 0,
    onSelect: function (dateText, inst){
			$("input[name=edate]").val(dateText);
		}
	});
	$("#startdate").datepicker( {
		showOn: "button",
    maxDate: 0
	});
	$("#enddate").datepicker( {
		showOn: "button",
    maxDate: 0
	});
});
</script>
<!-- //datepicker -->



<script type="text/javascript">
// <![CDATA[
function showFlashObject(id,width,height,movie,flashvars,style){
	var s = '<object id="'+id+'" classid="clsid:D27CDB6E-AE6D-11CF-96B8-444553540000" width="'+width+'" height="'+height+'" style="'+style+'"><param name="movie" value="'+movie+'"/><param name="menu" value="false"/><param name="quality" value="high"/><param name="allowScriptAccess" value="sameDomain"/><param name="play" value="true"/><param name="wmode" value="transparent"/><param name="flashvars" value="'+flashvars+'"/><embed swLiveConnect="true" flashvars="'+flashvars+'" src="'+movie+'" quality="high" bgcolor="" wmode="transparent" width="'+width+'" height="'+height+'" name="'+id+'" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object>';
	document.write(s);
}

function selectSearch(val){
	var frm = document.hform;
	frm.at.value = val;
	if($("#enddate").length == 0 && val !="" ){
		$("input[name=sdate]").val('');
		$("input[name=edate]").val('');
	}
	frm.submit();
}

// ]]>
</script>
<style>
.pageContent { width: 100%; }
.accordion { list-style-type: none; padding: 0; margin: 0;  border-top: none; border-left: none; }
.accordion ul { padding: 0; margin: 0; float: left; display: ;  }
.accordion li { background: #666;  list-style-type: none; padding: 0; margin: 0; float: left; display: block; width: 100%;}
.accordion li.active>a { background: url('./images/close.gif') no-repeat center right; }
.accordion li div { padding: 20px; background: #aef; display: block; clear: both; float: left; }
.accordion a.more { text-align:right; text-decoration: none;  font: bold 1.1em/2em "맑은고딕", 'Malgun gothic'; color: #fff; padding: 0 30px; display: block; cursor: pointer; background: url('./images/open.gif') no-repeat center right;}

/* Level 2 */
.accordion li ul li { background: #ffffff; border-bottom: 1px solid #cccccc; }
.accordion li ul li.first { border-top: 1px solid #cccccc;  }
.accordion li ul li.log_table_summary { background: #dddddd;     }
.accordion li ul li dl { width:100%;  }
.accordion li ul li dl dt{ float: left; vertical-align:middle; padding: 3px 0;   }
.accordion li ul li dl dt.number{ padding-left:10px; height:100%; vertical-align:middle; font-size:12px; border-left: 1px solid #cccccc; text-align:left; width:580px; max-width:590px;  }
.accordion li ul li dl dt.percent{ float:right; height:100%;  width:179px; text-align:right; padding-right:5px; vertical-align:middle; border-right: 1px solid #cccccc;  }

</style>
<script type="text/javascript">
var containerId = '#tabs-container';
var tabsId = '#tabs';

$(document).ready(function(){
	// Preload tab on page load
	if($(tabsId + ' li.current a').length > 0){
		loadTab($(tabsId + ' li.current a'));
	}
	$(tabsId + ' a').click(function(){

    if($(this).parent().hasClass('current')){ return false; }

    $(tabsId + ' li.current').removeClass('current');
    $(this).parent().addClass('current');

    loadTab($(this));
    return false;
  });
});

function loadTab(tabObj){
  if(!tabObj || !tabObj.length){ return; }
	startdate = $("input[name=sdate]").val();
	enddate = $("input[name=edate]").val();
	postvars = "sdate="+startdate+"&edate="+enddate;
/*  
  $(containerId).load(tabObj.attr('href')+"?"+postvars, function(){

      setTimeout(function() {
        result = $(this).html();
        if(result == "데이터가 없습니다."){
          result = "<img src='./images/nodata_chart.png'> 데이터가 없습니다."
          $(containerId).html(result);
        }
        $(containerId).removeClass('loading');
        $(containerId).fadeIn('slow');
      }, 1000);
  });
*/  

  $.ajax({
        async: true
      , url: tabObj.attr('href')
      , data: postvars
      , beforeSend: function() {
          $(containerId).html('').addClass('loading');
        }
      , success : function(response, status, request) {
          if(response){
             setTimeout(function() {
               if(response == "데이터가 없습니다.") response = "<img src='./images/nodata_chart.png'> 데이터가 없습니다."
               $(containerId).html(response).fadeIn('slow');
                $(containerId).removeClass('loading');
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


}
</script>
<style>
ul.mytabs {
	position: relative;
	z-index: 2;
}
ul.mytabs, ul.mytabs li {
	margin: 0;
	padding: 0;
	list-style: none;
	float: left;
}
ul.mytabs li { padding: 0; 	font-family: "맑은고딕", 'Malgun gothic', "돋움", Dotum, "굴림", Gulim, Arial, Helvetica, sans-serif, "Courier New", Courier, monospace ;  }
ul.mytabs li a {
	float: left;
	padding: 3px 14px;
	border: 1px solid #CCCCCC;
	border-bottom: 1px solid #E0E0E0;
	background: #F0F0F0;
	text-decoration: none;
	color: #333333;
	height: 22px;
}
ul.mytabs li A:HOVER, ul.mytabs li.current a {
	background: #FFFFFF;
}
ul.mytabs li.current a {
	font-weight: bold;
	border-bottom: 1px solid #FFFFFF;
}
div.mytabs-container {
	position: relative;
	z-index: 1;
	clear: both;
	border: 1px solid #CCCCCC;
	padding: 10px;
	top: -1px;
	text-align:center;
	vertical-align:middle;
	min-height:350px;
  line-height:350px;
}

.mytabs-container * {line-height:1.5;}

.graph_container {min-width: 300px; width:100%;  margin: 0 auto; margin-bottom:30px; padding-bottom:30px;}
input.input-search {
	margin-right:1px;
	border:solid 2px #4572a7 ;
	color:#4572a7;
	vertical-align:center;
	font:14px  tahoma;
	font-weight:bolder;
	text-align:center;
	padding:2px 4px 3px 4px;
}

.loading {
  background:url("./images/loading14.gif") no-repeat center  ;
  content:''
}
</style>
<?
	$sperator = "<span style='color:#A88B6F;'>|</span>";
?>
<form name='hform' method='post'>
<input type='hidden' name='at' value="<?=$req['at']?>">
<table class="Info" style="position:relative;z-index:10">
  <!--
  <col width="*"></col>
  <col width="400px"></col>
  -->
	<tr height="24px">
    <!--
		<td style="padding:10px 5px; " class='subbody-title'>
			<? if($req['at'] == ""){?>
			<b style='border:1px solid #385f8d; padding:5px;_padding:5px; background-color:#4572a7; color:#fff'>Main</b> <?=$sperator?>
			<? }else{ ?>
			<a href="#" onClick="javascript:selectSearch(''); return false;">Main</a> <?=$sperator?>
			<? } ?>

			<? if($req['at'] == "today"){?>
			<b style='border:1px solid #385f8d; padding:5px;_padding:5px; background-color:#4572a7; color:#fff'>일별접속</b> <?=$sperator?>
			<? }else{ ?>
			<a href="#" onClick="javascript:selectSearch('today'); return false;">일별접속</a> <?=$sperator?>
			<? } ?>

			<? if($req['at'] == "count"){?>
			<b style='border:1px solid #385f8d; padding:5px;_padding:5px; background-color:#4572a7; color:#fff'>방문자수</b> <?=$sperator?>
			<? }else{ ?>
			<a href="#" onClick="javascript:selectSearch('count'); return false;">방문자수</a> <?=$sperator?>
			<? } ?>

			<? if($req['at']== "referer"){?>
			<b style='border:1px solid #385f8d; padding:5px;_padding:5px; background-color:#4572a7; color:#fff'>유입분석</b>  <?=$sperator?>
			<? }else{ ?>
			<a href="#" onClick="javascript:selectSearch('referer'); return false;">유입분석</a> <?=$sperator?>
			<? } ?>

			<? if($req['at'] == "page"){?>
			<b style='border:1px solid #385f8d; padding:5px;_padding:5px; background-color:#4572a7; color:#fff'>접속페이지</b> <?=$sperator?>
			<? }else{ ?>
			<a href="#" onClick="javascript:selectSearch('page'); return false;">접속페이지</a> <?=$sperator?>
			<? } ?>

			<? if($req['at'] == "user"){?>
			<b style='border:1px solid #385f8d; padding:5px;_padding:5px; background-color:#4572a7; color:#fff'>사용자환경</b>
			<? }else{ ?>
			<a href="#" onClick="javascript:selectSearch('user'); return false;">사용자환경</a>
			<? } ?>

		</td>
    -->
		<td style="padding:10px 5px; " class='subbody-title'>&nbsp;</td>
		<td style="padding-right:10px; " align="right" valign="middle" class='subbody-title' >
		<table >
			<tr>
				<td align="right" >
				<?
					if($req['at'] == "" || $req['at'] == "today"){
				?>
				<input type="text" name="sdate" value="<?=$req['edate']?>" class="input-search" id="onedate" readonly maxlength="10" size="9">
				<input type="hidden" name="edate" value="<?=$req['edate']?>" class="input-search" readonly>
				<? }else{ ?>
				<input type="text" name="sdate" value="<?=$req['sdate']?>" class="input-search" id="startdate" readonly maxlength="10" size="9"> ~ <input type="text" name="edate" value="<?=$req['edate']?>" class="input-search" id="enddate" readonly maxlength="10" size="10">
				<? } ?>
				<input type='image' src="images/log_search.png" align='absmiddle' style='text-align:middle; ' >
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
