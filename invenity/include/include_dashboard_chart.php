<?php


// Get all device data
$device_datas_all       = $devClass->show_device();
$device_datas_new       = $devClass->show_device("", "new");
$device_datas_in_use    = $devClass->show_device("", "in use");
$device_datas_damaged   = $devClass->show_device("", "damaged");
$device_datas_repaired  = $devClass->show_device("", "repaired");
$device_datas_discarded = $devClass->show_device("", "discarded");

// Loop device data all
$all_total = 0;
foreach ($device_datas_all as $dda) {
	$all_total++;
}

// Loop device data new
$new_total = 0;
foreach ($device_datas_new as $ddn) {
	$new_total++;
}

// Loop device data in use
$in_use_total = 0;
foreach ($device_datas_in_use as $ddi) {
	$in_use_total++;
}

// Loop device data damaged
$damaged_total = 0;
foreach ($device_datas_damaged as $ddd) {
	$damaged_total++;
}

// Loop device data repaired
$repaired_total = 0;
foreach ($device_datas_repaired as $ddr) {
	$repaired_total++;
}

// Loop device data discarded
$discarded_total = 0;
foreach ($device_datas_discarded as $ddds) {
	$discarded_total++;
}

?>

<!-- Chart JS -->
<script type="text/javascript" src="./assets/plugins/chartjs/Chart.min.js"></script>
<script type="text/javascript">
	var barChartData = {
		labels : [ "All Device", "New Device", "In Use Device", "Damaged Device", "Repaired Device", "Discarded Device" ],
		datasets : [
			{
				fillColor: "rgba(151,187,205,0.5)",
	            strokeColor: "rgba(151,187,205,0.8)",
	            highlightFill: "rgba(151,187,205,0.75)",
	            highlightStroke: "rgba(151,187,205,1)",
				data : [<?php echo $all_total.",".$new_total.",".$in_use_total.",".$damaged_total.",".$repaired_total.",".$discarded_total; ?>]
			}
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}
</script>