<h4 class="">Laporan Data</h4>
<!-- Row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="fs-7">
                            <?php echo $this->db->get("m_user")->num_rows(); ?>
                        </h2>
                        <h6 class="fw-medium text-info mb-0">Pelanggan</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-info display-6"><i class="ti ti-users"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-primary">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="fs-7"><?php echo $this->db->get("m_kendaraan")->num_rows(); ?></h2>
                        <h6 class="fw-medium text-primary mb-0">Mobil</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-primary display-6"><i class="ti ti-car"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-success">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="fs-7"><?php echo $this->db->get("m_sopir")->num_rows(); ?></h2>
                        <h6 class="fw-medium text-success mb-0">Sopir</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-success display-6"><i class="ti ti-user"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-bottom border-danger">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="fs-7"><?php echo $this->db->get("m_order")->num_rows(); ?></h2>
                        <h6 class="fw-medium text-danger mb-0">transaksi</h6>
                    </div>
                    <div class="ms-auto">
                        <span class="text-danger display-6"><i class="ti ti-chart"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
<?php 
    setlocale(LC_ALL, 'IND');
    $_REQUEST['tgl_awal'] = date("Y-m-d", strtotime("-31 days", strtotime(date('Y-m-d'))));;
    $_REQUEST['tgl_akhir'] = date('Y-m-d');
    function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
        $dates = [];
        $current = strtotime( $first );
        $last = strtotime( $last );
        while( $current <= $last ) {
            $dates[] = date( $format, $current );
            $current = strtotime( $step, $current );
        }
        return $dates;
    }
    $tgl_awal  = $_REQUEST['tgl_awal'];
    $tgl_akhir = $_REQUEST['tgl_akhir'];
    $daterange = dateRange($tgl_awal, $tgl_akhir); 
?>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Laporan Transaksi Bulanan"
	},
	axisX: {
		valueFormatString: "DD MMM,YY"
	},
	axisY: {
		title: "Total",
		suffix: ""
	},
	legend:{
		cursor: "pointer",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	toolTip:{
		shared: true
	},
	data: [{
		name: "Total Transaksi",
		type: "spline",
		yValueFormatString: "#0.## Kali",
		showInLegend: true,
		dataPoints: [
            <?php foreach($daterange as $date){
                $transaksi = $this->db->query("SELECT COUNT(*) as jumlah FROM m_order 
                                                        WHERE DATE(create_at)>='".$date."'
                                                        AND DATE(create_at)<='".$date."'
                                                        ")->row_array();
            ?>
                { label: '<?php echo date('d M',strtotime($date)); ?>', y: <?php echo empty($transaksi['jumlah']) ? 0 : $transaksi['jumlah'];?> },
            <?php } ?>
		]
	}]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>