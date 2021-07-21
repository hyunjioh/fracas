<?
	$GraphName = "시간별 방문자";
  define("_log_sub_include",true);
  include "../index.php";
	unset($list, $list_total, $graph, $graph_total, $max, $Count, $Percent, $req );
	$req['sdate'] = (!$_GET['sdate'])?  date("Y-m-d", time()-86400*7) : $_GET['sdate'];
	$req['edate'] = (!$_GET['edate'])?  date("Y-m-d") : $_GET['edate'];
	$GraphSubTitle = ($req['sdate'] == $req['edate']) ? $req['sdate']: $req['sdate']." ~ ".$req['edate'];
	$WhereQuery = " time between '".$req['sdate']."' and '".$req['edate']."  23:59:59' ";
	$Query = "SELECT count(*) as cnt, hour(time) as hour FROM `G__Log_Basic` WHERE ".$WhereQuery." GROUP BY hour(time)";
	//$Query = "SELECT count(*) as cnt, hour(time) as hour FROM `G__Log_Basic` WHERE time LIKE '".$date."%' GROUP BY hour(time)";
	$DATA  = $db -> SelectList($Query);
	$cnt = count($DATA);

	$max = 0;
	$list = array();
	$graph = array();
	$list_total = 0;
	$graph_total = 0;
	if($cnt > 0){
		$i = 0;
		foreach($DATA as $key => $value){
			if($max < (int)$value['cnt']){
				$max = $value['cnt'];
			}
			$list_total = $list_total + $value['cnt'];
			//$list[$this->hour[$value['hour']]] = (int)$value['cnt'];
			$list[$cfg['hour'][$value['hour']]] = (int)$value['cnt'];
			$graph[$value['hour']] = (int)$value['cnt'];
			$i++;
		}
	}

	for($i=0; $i<24; $i++){
		if(!isset($list[$cfg['hour'][$i]])){
			$list[$cfg['hour'][$i]] = 0;
			$graph[$i] = 0;
		}
	}

	ksort($list);
	ksort($graph);

	$log_Time['list'] = $list;
	$log_Time['list_total'] = $list_total;
	$log_Time['graph'] = $graph;
	$log_Time['graph_total'] = $graph_total;
	$log_Time['max'] = ceil(($max+1)/10)*10;


	$total = $log_Time['list_total'];
	$count = count($log_Time['list']);

	if($total > 0 ){
		$data_keys = implode("|",array_keys($log_Time['graph']));
		$data_values = implode("|",array_values($log_Time['graph']));

    $Count['total']  = $log_Time['list_total'];
    $Count['top5']   = $log_Time['graph_total'];
    $Count['etc']    = $log_Time['list_total'] - $log_Time['graph_total'];
    $Percent['top5'] = ($log_Time['graph_total']/$log_Time['list_total'])*100;
    $Percent['etc']  = (( $log_Time['list_total'] - $log_Time['graph_total'])/$log_Time['list_total'])*100;
	}else{
		$data_keys = null;
		$data_values = null;
    echo "데이터가 없습니다.";
    exit;
	}
?>
<script type="text/javascript">
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

    var table = document.getElementById('today_datatable'),
    options = {
        chart: {
            animation: false,
            height : 350,
            renderTo: 'today_graph',
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
          title: {
            text: null
          },
          labels:{

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
</script>
<table id="today_datatable" style="display:none">
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
        $key = substr($key, 0,2);
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
<div id="today_graph" class="graph_container"></div>
<?
if($total > 0){
?>
<table width="100%" cellpadding="0" cellspacing="0" class="Info">
  <col width=''></col>
  <col width='250'></col>
  <?
    $i = 0;
    foreach($log_Time['list'] as $key => $value){
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