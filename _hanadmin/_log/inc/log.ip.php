<?
	$GraphName = "방문자 IP";
  define("_log_sub_include",true);
  include "../index.php";
	unset($list, $list_total, $graph, $graph_total, $max, $Count, $Percent, $req );
	$req['sdate'] = (!$_GET['sdate'])?  date("Y-m-d", time()-86400*7) : $_GET['sdate'];
	$req['edate'] = (!$_GET['edate'])?  date("Y-m-d") : $_GET['edate'];
	$GraphSubTitle = ($req['sdate'] == $req['edate']) ? $req['sdate']: $req['sdate']." ~ ".$req['edate'];
	$WhereQuery = " time between '".$req['sdate']."' and '".$req['edate']."  23:59:59' ";
	$Query = "SELECT ip, count(*) as cnt FROM `G__Log_Basic` WHERE  ".$WhereQuery." GROUP BY ip ORDER BY cnt DESC";
	//$Query = "SELECT ip, count(*) as cnt FROM `G__Log_Basic` WHERE  time LIKE '".$date."%' GROUP BY ip ORDER BY cnt DESC";
	$DATA  = $db -> SelectList($Query);
	$cnt = count($DATA);

	$max = 0;
	$list = array();
	$graph = array();
	$list_total = 0;
	$graph_total=0;
	if($cnt > 0){
		$max = $DATA[0]['cnt'];
		$i = 1;
		foreach($DATA as $key => $value){
			$list_total = $list_total + $value['cnt'];
			$list[$value['ip']] = (int)$value['cnt'];

			if($i <= 5){
				$graph_total = $graph_total + $value['cnt'];
				$graph[$i] = (int)$value['cnt'];
			}
			$i++;
		}
		if($etc > 0) $graph['기타'] = $etc;
	}

	$log_IP['list'] = $list;
	$log_IP['list_total'] = $list_total;
	$log_IP['graph'] = $graph;
	$log_IP['graph_total'] = $graph_total;
	$log_IP['max'] = ceil(($max+1)/10)*10;
	$total = $log_IP['graph_total'];

	if($total > 0 ){
		$data_keys = implode("|",array_keys($log_IP['graph']));
		$data_values = implode("|",array_values($log_IP['graph']));

    $Count['total']  = $log_IP['list_total'];
    $Count['top5']   = $log_IP['graph_total'];
    $Count['etc']    = $log_IP['list_total'] - $log_IP['graph_total'];
    $Percent['top5'] = ($log_IP['graph_total']/$log_IP['list_total'])*100;
    $Percent['etc']  = (( $log_IP['list_total'] - $log_IP['graph_total'])/$log_IP['list_total'])*100;
	}else{
		$data_keys = null;
		$data_values = null;
    echo "데이터가 없습니다.";
    exit;
	}
?>
<script type="text/javascript">
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

        var table = document.getElementById('ip_datatable'),
        options = {
            chart: {
                animation: false,
								height : 350,
                renderTo: 'ip_graph',
                type: 'bar' // line, spline, area, areaspline, column, bar, pie, scatter
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
              allowDecimals : false
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true,
												color: '#FFFFFF',
												align: 'right',
												x: -1,
												y: 7
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return this.x.toLowerCase() + " : <b>" + this.y + "</b>";
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
<table id="ip_datatable" style="display:none">
	<thead>
		<tr>
			<th></th>
			<th><?=$GraphName?></th>
		</tr>
	</thead>
	<tbody>
		<?
			$i = 0;
			foreach($list as $key => $value){
				if($i > 4) break;
		?>
		<tr>
			<th><?=$key?></th>
			<td><?=$value?></td>
		</tr>
		<?
				$i++;
			}
      if($Count['etc'] > 0){
		?>
		<tr>
			<th>etc</th>
			<td><?=$Count['etc']?></td>
		</tr>
    <?
      }
    ?>
	</tbody>
</table>
<div id="ip_graph" class="graph_container"></div>
<div class="pageContent">
	<ul class="accordion">
		<li>
			<!--<a href="#<?=basename(__FILE__)?>" class="more">상세보기</a>-->
			<ul>
			<?
				$i = 1;
				foreach($list as $key => $value){
					if($list_total > 0)$percent = sprintf("%.2f",($value/$list_total)*100);
					else $percent = sprintf("%.2f",0);

					if($i%2==0) $cellcolor = "#efefef";
					else $cellcolor = "#ffffff";
      ?>
      <?
          if($i == 1){
			?>
				<li class="log_table_summary first">
					<dl>
						<dt class="number number-middle">Top5</dt>
						<dt class="percent"><span class="number-middle"><?=number_format($Count['top5'])?></span> <span class="number-middle">(<?=sprintf("%.2f",$Percent['top5'])?>%)</span></dt>
					</dl>
				</li>
      <?
          }  
      ?>
      <?
          if($i == 6){
			?>
				<li class="log_table_summary">
					<dl>
						<dt class="number number-middle">etc</dt>
						<dt class="percent"><span class="number-middle"><?=number_format($Count['etc'])?></span> <span class="number-middle">(<?=sprintf("%.2f",$Percent['etc'])?>%)</span></dt>
					</dl>
				</li>
      <?
          }  
      ?>
				<li>
					<dl>
						<dt class="number"><? if($i  < 6) echo "<strong>";?><?=$i?>. <?=$key?><? if($i  < 6) echo "</strong>";?> <? //ip2flag($key)?></dt>
						<dt class="percent"><? if($i  < 6) echo "<strong>";?><span class="number-small"><?=number_format($value)?></span><? if($i  < 6) echo "</strong>";?>
						<? if($i  < 6) echo "<strong>";?><span class="number-small">(<?=$percent?>%)</span><? if($i  < 6) echo "</strong>";?>
						</dt>
					</dl>
				</li>
				<?
						$i++;
					if($i > 100) break;
					}
				?>
				<li class="log_table_summary">
					<dl>
						<dt class="number number-big">Total</dt>
						<dt class="percent"><span class="number-big"><?=number_format($Count['total'])?></span> <span class="number-big">(100%)</span></dt>
					</dl>
				</li>
			</ul>
		</li>
	</ul>
</div>
<div class="clear"></div>
<br>
<br>