<!-- BEGIN: MAIN -->

<div class="block">
	<h2><i class="fa fa-plug"></i> {PHP.L.bstat_graph_title}</h2>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			['Дата', '{PHP.L.bstat_graph_debet}', '{PHP.L.bstat_graph_credit}'],
			<!-- BEGIN: PAY_ROW -->
			['{PAY_ROW_DAY|cot_date('d.m.Y', $this)}',  {PAY_ROW_DEBET_SUMM},  {PAY_ROW_CREDIT_SUMM}],
			<!-- END: PAY_ROW -->
        ]);

        var options = {
			title: '',
			hAxis: {title: 'Дата',  titleTextStyle: {color: '#333'}},
			vAxis: {minValue: 0},
			seriesType: "bars",
			series: {5: {type: "line"}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('bstat_graph_chart_div'));
        chart.draw(data, options);
      }
    </script>
	<div class="wrapper">
		<div id="bstat_graph_chart_div" style="width: 100%; height: 400px;"></div>
	</div>
</div>

<div class="block">
	<h2><i class="fa fa-plug"></i> {PHP.L.bstat_users_title}</h2>
	<div class="wrapper">
		<table class="cells table table-striped">
			<!-- BEGIN: BAL_ROW -->
			<tr>
				<td style="width:200px;"><a href="{BAL_ROW_USER_DETAILSLINK}">{BAL_ROW_USER_FULL_NAME}</a></td>
				<td style="text-align: right;">{BAL_ROW_SUMM} {PHP.cfg.payments.valuta}</td>
				<td style="width:50px; text-align: right;">
					<a
						href="{BAL_ROW_USER_ID|cot_url('admin', 'm=payments&id='$this)}"
					><img src="images/icons/default/16/arrow-right.png"/></a>
				</td>
			</tr>
			<!-- END: BAL_ROW -->
			<tr>
				<td>{PHP.L.All}</td>
				<td style="text-align: right;">{BAL_SUMM} {PHP.cfg.payments.valuta}</td>
				<td style="width:50px; text-align: right;">
					<a href="{PHP|cot_url('admin', 'm=payments')}"><img src="images/icons/default/16/arrow-right.png"/></a>
				</td>
			</tr>
		</table>
	</div>
</div>
<!-- END: MAIN -->