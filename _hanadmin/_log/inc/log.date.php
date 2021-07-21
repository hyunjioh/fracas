<?
	$GraphName = "일별 방문자수";
  define("_log_sub_include",true);
  include "../index.php";
	unset($list, $list_total, $graph, $graph_total, $max, $Count, $Percent, $req );
	$req['sdate'] = (!$_GET['sdate'])?  date("Y-m-d", time()-86400*7) : $_GET['sdate'];
	$req['edate'] = (!$_GET['edate'])?  date("Y-m-d") : $_GET['edate'];
	$GraphSubTitle = ($req['sdate'] == $req['edate']) ? $req['sdate']: $req['sdate']." ~ ".$req['edate'];
	$WhereQuery = " time between '".$req['sdate']."' and '".$req['edate']."  23:59:59' ";
	$Query = "SELECT count(*) as cnt, cast(time as date) as day FROM `G__Log_Basic` WHERE ".$WhereQuery." GROUP BY cast(time as date)";
  $Query = "select avg(c) as period, day, count(sid) as cnt from (SELECT TIMESTAMPDIFF(second, min(time), max(time)) as c, cast(time as date) as day, sid  FROM `G__Log_History` Where sid in (Select sid from G__Log_Basic Where cast(G__Log_Basic.time as date) = cast(G__Log_History.time as date) and ".$WhereQuery." ) group by sid, cast(time as date) )  as tt group by day";
	//$Query = "SELECT count(*) as cnt, cast(time as date) as day FROM `G__Log_Basic` WHERE  time LIKE '".$date."%' GROUP BY cast(time as date)";
	$DATA  = $db -> SelectList($Query);
	$cnt = count($DATA);

	//$dateNal = date("t", mktime(1,1,1,$req['sMonth'] ,1,$req['sYear'] ));
	$max = 0;
	$list = array();
	$graph = array();
	$list_total = 0;
	$graph_total = 0;
	if($cnt > 0){
		$i=1;
		$max = $DATA[0]['cnt'];
		foreach($DATA as $key => $value){
			$list_total = $list_total + $value['cnt'];
			$list[$value['day']] = (int)$value['cnt'];
			if($i <= 5){
				$graph_total = $graph_total + $value['cnt'];
				$graph[$i] = (int)$value['cnt'];
			}
			if($key == 0){
				$StartDateData = $value['day'];
			}
			$i++;
		}
		$EndDateData = $value['day'];
	}

	if($StartDateData){
		$StartDateArr  = explode("-",$StartDateData);
		$EndDateArr    = explode("-",$EndDateData);
		$StartDateUnix = mktime(0,0,0, $StartDateArr['1'],$StartDateArr['2'],$StartDateArr['0']);
		$EndDateUnix   = mktime(0,0,0, $EndDateArr['1'],$EndDateArr['2'],$EndDateArr['0'])+86400;
		for($i = $StartDateUnix; $i < $EndDateUnix; $i = $i + 86400){
			$dateKey = date("Y-m-d", $i);
			if(!isset($list[$dateKey])) {
				$list[(string)$dateKey] = 0;
			}
		}
	}

	/*
	for($i=1; $i<=$dateNal; $i++){
		if(!isset($list[$i])) {
			$list[(string)$i] = 0;
		}
	}
	*/
	ksort($list);



	$log_Date['list'] = $list;
	$log_Date['list_total'] = $list_total;
	$log_Date['graph'] = $graph;
	$log_Date['graph_total'] = $graph_total;
	$log_Date['max'] = ceil(($max+1)/10)*10;

	$total = $log_Date['list_total'];
	$count = count($log_Date['list']);

	if($total > 0 ){
		$date_keys = implode("|",array_keys($log_Date['list']));
		$date_values = implode("|",array_values($log_Date['list']));

    $Count['total']  = $log_Date['list_total'];
    $Count['top5']   = $log_Date['graph_total'];
    $Count['etc']    = $log_Date['list_total'] - $log_Date['graph_total'];
    $Percent['top5'] = ($log_Date['graph_total']/$log_Date['list_total'])*100;
    $Percent['etc']  = (( $log_Date['list_total'] - $log_Date['graph_total'])/$log_Date['list_total'])*100;
	}else{
		$date_keys = null;
		$date_values = null;
    echo "데이터가 없습니다.";
    exit;
	}
?>
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

        var table = document.getElementById('date_datatable'),
        options = {
            chart: {
                animation: false,
								height : 350,
                renderTo: 'date_graph',
                type: 'areaspline' // line, spline, area, areaspline, column, bar, pie, scatter
            },
            title: {
                text: '<?=$GraphName?>'
            },
            subtitle: {
              text : '<?=$GraphSubTitle?>',
              color : '#ff3300',
                y  : 35
            },
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

              min: -1
            },
            plotOptions: {
                areaspline: {
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
</script>
<table id="date_datatable" style="display:none">
	<thead>
		<tr>
			<th></th>
			<th><?=$GraphName?></th>
		</tr>
	</thead>
	<tbody>
		<?
			$i = 0;
      $re_date = explode("-",$date);
			foreach($list as $key => $value){
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
<div id="date_graph" class="graph_container"></div>
<?
if($total > 0){
?>
<table width="100%" cellpadding="0" cellspacing="0" class="Info">
  <col width=''></col>
  <col width='250'></col>
  <?
    $i = 0;
    foreach($log_Date['list'] as $key => $value){
      if($total > 0)$percent = sprintf("%.2f",($value/$total)*100);
      else $percent = sprintf("%.2f",0);

      if($i%2==0) $cellcolor = "#efefef";
      else $cellcolor = "#ffffff";
  ?>
  <tr height='22'  bgcolor="<?=$cellcolor?>">
    <td align='left' style='padding-left:5px; border-left:1px solid #dddddd'><span class="number-normal"><?=$key?></span></td>
    <td align="right"style="padding-right:5px"><span class="number-small"><?=number_format($value)?></span> <span class="number-small">(<?=$percent?>%)</span></td>
  </tr>
  <?
    $i++;
    if($i < $count)	{
  ?>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC" height="1"></td>
  </tr>
  <?
      }
    }
  ?>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC" height="1"></td>
  </tr>
  <tr  bgcolor="#efefef">
    <td align='left' style="padding-left:5px; border-left:1px solid #cccccc"><span class="number-big">Total</span></td>
    <td align="right" style="padding-right:5px"><span class="number-big"><?=$Count['total']?></span> <span class="number-big">(100%)</span></td>
  </tr>
</table>
<?
}
?>
<br>