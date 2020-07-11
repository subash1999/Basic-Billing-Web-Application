<?php include_once("helper_functions.php"); ?>
<?php include_once(snippet("dashboard_top.php")); ?>
<?php include_once(controller("ContactController.php")); ?>
<?php include_once(controller("TransistionController.php")); ?>
<?php include_once(controller("BillController.php")); ?>
<?php 
$transistion = new TransistionController();
$all_transistions = $transistion->get_total_transistion_group_by_date();
$sell_transistions = $transistion->get_total_sell_transistion_group_by_date();
$buy_transistions = $transistion->get_total_buy_transistion_group_by_date();
$chart_data = array();
for($a=0,$s=0,$b=0;$a<count($all_transistions);$a++){
  $all_t['amount'] = 0;
  $sell_t['amount'] = 0;
  $buy_t['amount'] = 0;
  $all_t = $all_transistions[$a];
  if(isset($sell_transistions[$s])){
    if(strcasecmp($all_t['date'],$sell_transistions[$s]['date'])==0){
      $sell_t = $sell_transistions[$s];
      $s++;
    }
  }  
  if(isset($buy_transistions[$b])){
    if(strcasecmp($all_t['date'],$buy_transistions[$b]['date'])==0){
      $buy_t = $buy_transistions[$b];
      $b++;
    }
  }
  array_push($chart_data,array(date("d-M-y", strtotime($all_t['date'])),(float)$all_t['amount'],(float)$sell_t['amount'],(float)$buy_t['amount'],(float)$sell_t['amount']-(float)$buy_t['amount']));
}
$chart_data = json_encode($chart_data);
?>

<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Charts</h2>
    </div>
</header>
<div class="container-fluid">
    <div id="chart-container">FusionCharts will render here</div>
</div>
<script>
    const data = <?php echo($chart_data);  ?>;
    const schema = [{
  "name": "Time",
  "type": "date",
  "format": "%d-%b-%y"
}, {
  "name": "Total Transistion Amount",
  "type": "number"
}, {
  "name": "Total Sell Amount",
  "type": "number"
}, {
  "name": "Total Buy Amount",
  "type": "number"
}, {
  "name": "Net Profit Amount",
  "type": "number"
}];
    const dataStore = new FusionCharts.DataStore();
  const dataSource = {
    chart: {},
    caption: {
      text: "Transistion Summary"
    },
    subcaption: {
      text: "Transistions Per Day"
    },
    yaxis: [
      {
        plot: {
          value: "Total Transistion Amount",
          connectnulldata: true
        },
        format: {
          prefix: "Rs"
        },
        title: "Per Day"
      },
      {
        plot: {
          value: "Total Sell Amount",
          connectnulldata: true
        },
        format: {
          prefix: "Rs"
        },
        title: "Per Day"
      },
      {
        plot: {
          value: "Total Buy Amount",
          connectnulldata: true
        },
        format: {
          prefix: "Rs"
        },
        title: "Per Day"
      },
      {
        plot: {
          value: "Net Profit Amount",
          connectnulldata: true
        },
        format: {
          prefix: "Rs "
        },
        title: "Per Day"
      }
    ]
  };
  dataSource.data = dataStore.createDataTable(data, schema);
  dataSource.chart.theme = "candy";

  new FusionCharts({
    type: "timeseries",
    renderAt: "chart-container",
    width: "100%",
    height: "700",
    dataSource: dataSource
  }).render();
</script>
<?php include_once(snippet("dashboard_bottom.php")); ?>