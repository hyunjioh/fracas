<?
define("_administrators_",true);
include "../../_core/_lib.php";
require_once _CORE_PATH_."/system/class.MySQL.php";

ini_set("allow_url_fopen",1);
$Yesterday = time()-86400;


$pageTitle = "관리자페이지 (".date("Y-m-d").")";

$Board['Link'] = null;
$Board['page_limit'] = null;
$LogGraphName = "최근 1주간 방문자";
/*-------------------------------------------------------------------------------------------------
▶ 데이터베이스 연결 */
unset($db);
$db = new MySQL;


/*-------------------------------------------------------------------------------------------------
▶ 방문자수 */
$Total_Visit = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic`");
$Year_Visit  = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic` WHERE time LIKE '".date("Y")."%'");
$Month_visit = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic` WHERE time LIKE '".date("Y-m")."%'");
$Today_visit = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic` WHERE time LIKE '".date("Y-m-d")."%'");
$Yesterday_visit = $db->Total("SELECT count(*) as cnt FROM `G__Log_Basic` WHERE time LIKE '".date("Y-m-d",$Yesterday)."%'");


/*-------------------------------------------------------------------------------------------------
▶ 회원가입 */
$Total_Member = $db->Total("SELECT count(*) as cnt FROM `G_Member` Where m_status = 'normal' ");
$Today_Member = $db->Total("SELECT count(*) as cnt FROM `G_Member` Where m_status = 'normal'  and m_regDate  = '".date("Y-m-d")."'");
$Month_Member = $db->Total("SELECT count(*) as cnt FROM `G_Member` Where m_status = 'normal'  and m_regDate = '".date("Y-m")."'");
$Yesterday_Member = $db->Total("SELECT count(*) as cnt FROM `G_Member` Where m_status = 'normal' and m_regDate = '".date("Ymd",$Yesterday)."'");


/*-------------------------------------------------------------------------------------------------
▶ 트래픽 (cafe24의 경우 호스팅관리 > 기본관리 > 사용량모니터링 > 웹트래픽용량 - 모링터링 페이지 )*/
$throttle_url = "http://hansian.cafe24.com/~hansian/throttle-me";
if($throttle_url){
	$file = file($throttle_url); // 소스를 읽고,
	$traffic['use'] = sprintf("%0.2fM",strip_tags($file['43']) / 1024); // 44번 라인을 읽어서 태그를 없애고 MB단위로...배열은 0부터 44-1 = 43
	$traffic['limit'] = sprintf("%0.1fM",strip_tags(eregi_replace("M", "",$file['47']))); // 48번 라인을 읽어서 태그를 없애고 GB단위로...
}


$date1 = date("Y-m-d",time()-86400*7);
$date2 = date("Y-m-d",time());
$Graph = $db -> SelectList("SELECT count(*) as cnt, cast(time as date) as day FROM `G__Log_Basic` WHERE uid='"._DOMAIN_."' and time between '".$date1."' and '".$date2." 23:59:59' GROUP BY dayofmonth(time) order by time");
if($Graph){
	$cnt = count($Graph);
	for($i=0; $i < $cnt; $i++){
		//$Chart['col'][] = $Graph[$i] [month]."/".$Graph[$i] [day];
		//$Chart['num'][] = $Graph[$i] [cnt];

		$Chart[$Graph[$i]['day']] = $Graph[$i]['cnt'];

	}

	$StartDateArr  = explode("-",$date1);
	$EndDateArr    = explode("-",$date2);
	$StartDateUnix = mktime(0,0,0, $StartDateArr['1'],$StartDateArr['2'],$StartDateArr['0']);
	$EndDateUnix   = mktime(0,0,0, $EndDateArr['1'],$EndDateArr['2'],$EndDateArr['0'])+86400;
	for($i = $StartDateUnix; $i < $EndDateUnix; $i = $i + 86400){
		$dateKey = date("Y-m-d", $i);
		if(!isset($Chart[$dateKey])) {
			$Chart[(string)$dateKey] = 0;
		}
	}
	ksort($Chart);
}

/*-------------------------------------------------------------------------------------------------
▶ Disk 사용량 */
$Quota = trim(exec("quota hansian"));
if($Quota) $Disk = explode(" ",$Quota);
?>
<? include "../include/_header.inc.php" ?>
<!-- 차트 -->
<script src="<?=_CORE_?>/plugin/Highcharts-2.2.4/js/highcharts.src.js"></script>
<script src="<?=_CORE_?>/plugin/Highcharts-2.2.4/js/modules/exporting.js"></script>
<script src="<?=_CORE_?>/plugin/Highcharts-2.2.4/js/highcharts.skin.js"></script>
<!-- //차트 -->

<script type="text/javascript" src="<?=_CORE_?>/js/jquery.progressbar/js/jquery.progressbar.js"></script>

<script type="text/javascript">
$(function () {
    // On document ready, call visualize on the datatable.
    $(document).ready(function() {
  			// Apply the theme
	  		var highchartsOptions = Highcharts.setOptions(Highcharts.theme_grid);
        /**
         * Visualize an HTML table using Highcharts. The top (horizontal) header
         * is used for series names, and the left (vertical) header is used
         * for category names. This function is based on jQuery.
         * @param {Object} table The reference to the HTML table to visualize
         * @param {Object} options Highcharts options
         */
        Highcharts.visualize = function(table, options) {
            // the categories
            options.xAxis.categories = [];
            $('tbody th', table).each( function(i) {
                options.xAxis.categories.push(this.innerHTML);
            });

            // the data series
            options.series = [];
            $('tr', table).each( function(i) {
                var tr = this;
                $('th, td', tr).each( function(j) {
                    //if (j > 0) { // skip first column
                        if (i == 0) { // get the name and init the series
                            options.series[j - 1] = {
                                name: this.innerHTML,
                                data: []

                            };

                        } else { // add values
                          if(j > 0 ){
                            //options.series[j-1].data.push({ name : dataname , y : parseFloat(this.innerHTML), sliced: true, selected: true});
                            options.series[j-1].data.push({ name : dataname , y : parseFloat(this.innerHTML)});
                          }else{
                            dataname = this.innerHTML;
                          }

                        }
                    //}
                });
            });
            var chart = new Highcharts.Chart(options);
        }

        var table = document.getElementById('log_datatable'),
        options = {
            chart: {
                animation: false,
								height : 247,
                renderTo: 'log_graph',
                type: 'column' // line, spline, area, areaspline, column, bar, pie, scatter
            },
            title: {
               text: '<?=$LogGraphName?>'
            },
              /*
            subtitle: {
              text : '<?=$GraphSubTitle?>',
              color : '#ff3300',
                y  : 35
            },
            */
            xAxis: {
              tickPixelInterval: 50  ,
              title: {
                text: null
              },
              labels:{
                style: {
                   color: '#000',
                   font: '9px tahoma'
                }
              },
              min: 0
            },
            yAxis: {
                title: {
                    text: null
                },
              allowDecimals : false,

              min: -1
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return this.x + " : <b>" + this.y + "</b>";
                }
            },
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            }
        };

        options.legend = {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -100,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: '#FFFFFF',
            shadow: true,
            enabled  : false
        };

        Highcharts.visualize(table, options);
    });

});

$(document).ready(function() {
  $("#disk_graph").progressBar();
  $("#traffic_graph").progressBar();
  
});

</script>
<?	require_once "../include/_body_top.inc.php"; ?>
<table id="log_datatable" style="display:none">
	<thead>
		<tr>
			<th></th>
			<th><?=$LogGraphName?></th>
		</tr>
	</thead>
	<tbody>
		<?
			foreach($Chart as $key => $value){
        $key = substr($key,-5);
		?>
		<tr>
			<th><?=$key?></th>
			<td><?=$value?></td>
		</tr>
		<?
				$i++;
			}
		?>
	</tbody>
</table>

		<div class="main-layer" style="width:100%">
		<h3 class="page-title"><span>접속현황</span></h3>
    <!--
		<table width="100%" cellspacing="0" cellpadding="0" class="formtable" border="0" style="border:1px solid #dcd8d6">
			<col width="*"></col>
			<col width="80"></col>
			<col width="120"></col>
			<tr>
				<td class="tableth" rowspan="6" style="text-align:center; border-right:1px solid #dcd8d6">
          <div  id="log_graph" class="graph_container" style="width:100%;"></div>
        </td>
				<td class="tableth" >전체</td>
				<td class="tabletd number" > <?=number_format($Total_Visit)?> 명</td>
			</tr>
			<tr>
				<td class="tableth" >금년</td>
				<td class="tabletd number"> <?=number_format($Year_Visit)?> 명</td>
			</tr>
			<tr>
				<td class="tableth" >금월</td>
				<td class="tabletd number"> <?=number_format($Month_visit)?> 명</td>
			</tr>
			<tr>
				<td class="tableth" >어제</td>
				<td class="tabletd number" > <?=number_format($Yesterday_visit)?> 명</td>
			</tr>
			<tr>
				<td class="tableth" >오늘</td>
				<td class="tabletd number" > <?=number_format($Today_visit)?> 명</td>
			</tr>
		</table>
    -->
		<table width="100%" cellspacing="0" cellpadding="0" class="formtable" border="0" style="border:1px solid #dcd8d6;">
			<col width="*"></col>
			<col width="200"></col>
			<tr>
				<td class="tableth" rowspan="6" style="text-align:center; border-right:1px solid #dcd8d6">
          <div  id="log_graph" class="graph_container" style="width:100%;"></div>
        </td>
				<td class="tabletd number" style="height:250px; vertical-align:top;">
        <table width="100%" cellspacing="0" cellpadding="0" class="formtable" border="0" style="border:1px solid #dcd8d6; ">
          <col width="*"></col>
          <col width="80"></col>
          <col width="120"></col>
          <tr>
            <td class="tableth" >전체</td>
            <td class="tabletd number" > <?=number_format($Total_Visit)?> 명</td>
          </tr>
          <tr>
            <td class="tableth" >금년</td>
            <td class="tabletd number"> <?=number_format($Year_Visit)?> 명</td>
          </tr>
          <tr>
            <td class="tableth" >금월</td>
            <td class="tabletd number"> <?=number_format($Month_visit)?> 명</td>
          </tr>
          <tr>
            <td class="tableth" >어제</td>
            <td class="tabletd number" > <?=number_format($Yesterday_visit)?> 명</td>
          </tr>
          <tr>
            <td class="tableth" >오늘</td>
            <td class="tabletd number" > <?=number_format($Today_visit)?> 명</td>
          </tr>
        </table>        
        </td>
			</tr>
		</table>
		</div>


		<div class="main-layer" style="width:350px">
		<h3 class="page-title"><span>웹하드용량</span></h3>
		<table width="100%" cellspacing="0" cellpadding="0" class="formtable" border="0" style="border:1px solid #dcd8d6">
			<col width="*"></col>
			<col width="80"></col>
			<col width="120"></col>
			<tr>
				<td class="tableth" rowspan="3" style="text-align:center; border-right:1px solid #dcd8d6"><div id="disk_graph" class="progressBar"><? echo ($Disk['2']/$Disk['11'])*100 ?>%</div></td>
				<td class="tableth">전체</td>
				<td class="tabletd number" ><?=printByte($Disk['11']*1024)?></td>
			</tr>
			<tr>
				<td class="tableth">사용</td>
				<td class="tabletd number" ><?=printByte($Disk['2']*1024)?></td>
			</tr>
			<tr>
				<td class="tableth">남은용량</td>
				<td class="tabletd number" ><?=printByte(($Disk['11']-$Disk['2'])*1024)?></td>
			</tr>
		</table>
		</div>



		<div class="main-layer" style="width:330px">
		<h3 class="page-title"><span>트래픽</span></h3>
		<table width="100%" cellspacing="0" cellpadding="0" class="formtable" border="0" style="border:1px solid #dcd8d6">
			<col width="*"></col>
			<col width="80"></col>
			<col width="100"></col>
			<tr>
				<td class="tableth" rowspan="3" style="text-align:center; border-right:1px solid #dcd8d6"><div id="traffic_graph" class="progressBar"><? echo ($traffic['use']/$traffic['limit'])*100 ?>%</div></td>
				<td class="tableth">전체</td>
				<td class="tabletd number" ><?=$traffic['limit']?></td>
			</tr>
			<tr>
				<td class="tableth">사용</td>
				<td class="tabletd number" ><?=$traffic['use']?></td>
			</tr>
			<tr>
				<td class="tableth">남은용량</td>
				<td class="tabletd number" ><?=$traffic['limit']-$traffic['use']?>M</td>
			</tr>
		</table>
		</div>
    <!--
		<div class="main-layer" style="width:200px">
		<h3 class="page-title"><span>회원가입현황</span></h3>
		<table width="100%" cellspacing="0" cellpadding="0" class="formtable" border="0" style="border:1px solid #dcd8d6">
			<col width="80"></col>
			<col width="*"></col>

			<tr>
				<td class="tableth">전체</td>
				<td class="tabletd number" ><?=number_format($Total_Member)?> 명</td>
			</tr>
			<tr>
				<td class="tableth" >금월</td>
				<td class="tabletd number" ><?=number_format($Month_Member)?> 명</td>
			</tr>
			<tr>
				<td class="tableth" >어제</td>
				<td class="tabletd number" ><?=number_format($Yesterday_Member)?> 명</td>
			</tr>
			<tr>
				<td class="tableth" >오늘</td>
				<td class="tabletd number" ><?=number_format($Today_Member)?> 명</td>
			</tr>
		</table>
		</div>
    -->


		<!--
		<br>
		<a href="popA.html" onclick="window.open(this.href,'', 'width=700, height=500, scrollbars=no'); return false;" target="_blank" title="새창">팝업A</a><br><br>
		<a href="#">팝업B</a><br/><br/>

		<img src="../images/btnA/btn_confirm_m.gif" alt="검색" />
		<img src="../images/btnA/btn_confirm.gif" alt="확인" />
		<img src="../images/btnA/btn_list.gif" alt="목록" />
		<img src="../images/btnA/btn_modify.gif" alt="수정" />
		<img src="../images/btnA/btn_reply.gif" alt="답변" />
		<img src="../images/btnA/btn_result.gif" alt="결과보기" />
		<img src="../images/btnA/btn_save.gif" alt="저장" />
		<img src="../images/btnA/btn_write.gif" alt="등록" />
		<img src="../images/btnA/btn_cancel.gif" alt="취소" />
		<img src="../images/btnA/btn_delete.gif" alt="삭제" />
		<img src="../images/btnA/btn_search.gif" alt="검색" />
		<img src="../images/btnA/btn_x.gif" alt="닫기" style="background-color:blue;" /><br/><br/>

		<img src="../images/btnB/btn_confirm_m.gif" alt="검색" />
		<img src="../images/btnB/btn_confirm.gif" alt="확인" />
		<img src="../images/btnB/btn_list.gif" alt="목록" />
		<img src="../images/btnB/btn_modify.gif" alt="수정" />
		<img src="../images/btnB/btn_reply.gif" alt="답변" />
		<img src="../images/btnB/btn_result.gif" alt="결과보기" />
		<img src="../images/btnB/btn_save.gif" alt="저장" />
		<img src="../images/btnB/btn_write.gif" alt="등록" />
		<img src="../images/btnB/btn_cancel.gif" alt="취소" />
		<img src="../images/btnB/btn_delete.gif" alt="삭제" />
		<img src="../images/btnB/btn_search.gif" alt="검색" />
		<img src="../images/btnB/btn_x.gif" alt="닫기" style="background-color:blue;" />
		-->


<? include "../include/_body_bottom.inc.php"; ?>

<? include "../include/_footer.inc.php" ?>