<?php
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>

<script>

$(document).ready(function () {
    cekrekap_pasien();
});

function cekrekap_pasien()
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'dashboard/cekrekap_pasien'; ?>",
        beforeSend: function(){
            //$("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            if (resp == '100') {
                // alert('Data rekap pasien sudah tersedia.');
            } else {
                $("#modal").modal('show');
                $("#content_modal").html(resp);
                //$("#loading").html("");
            }
            
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function detail_pasien(idkelas,tanggalrekap)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'dashboard/detail_pasien'; ?>",
        data: {"idkelas":idkelas,"tanggalrekap":tanggalrekap},
        beforeSend: function(){
            //$("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal").modal('show');
            $("#content_modal").html(resp);
            //$("#loading").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

</script>

<section class="content">
  <!-- Small boxes (Stat box) -->
    <div class="row">
        <?php
        foreach ($pasien as $psn) {
            switch ($psn['namakelas']) {
                case 'kelas 1':
                    $bg_color = 'bg-aqua';
                    break;
                case 'kelas 2':
                    $bg_color = 'bg-green';
                    break;
                case 'kelas 3':
                    $bg_color = 'bg-yellow';  
                    break;
                case 'vip':
                    $bg_color = 'bg-red';
                    break;
            } 
        ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
            <div class="small-box <?php echo $bg_color;?>">
                <div class="inner">
                    <h3><?php echo $psn['jumlah'];?></h3>
                    <p>Pasien <?php echo $psn['namakelas'];?></p>
                </div>
              <div class="icon">
                  <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer" onclick="javascript:detail_pasien('<?php echo $psn['idkelas'];?>','<?php echo $psn['tanggalrekap'];?>');">Tgl : <?php echo $psn['tanggalrekap'];?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <?php
        }
        ?>
    </div><!-- /.row -->

    <div class="row">
        <div class="col-lg-6">
          <!-- small box -->
            <?php
            if (count($pengajuan) == 0) {
                $hargatotal_a = 0;
                $tanggalpengajuan_a = '-';
            } else {
                $hargatotal_a = number_format($pengajuan[0]['hargatotal'],2,",",".");
                $tanggalpengajuan_a = $pengajuan[0]['tanggalpengajuan'];
            }
            ?>
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Pengajuan Bahan Masakan</h3>
                    <p>Jumlah Biaya : Rp. <?php echo $hargatotal_a;?></p>
                </div>
              <div class="icon">
                  <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url().'pengajuanbahan'; ?>" class="small-box-footer"> Tanggal pengajuan : <?php echo $tanggalpengajuan_a;?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-6">
          <!-- small box -->
            <?php
            if (count($pengecekan) == 0) {
                $hargatotal_b = 0;
                $tanggalpengajuan_b = '-';
            } else {
                $hargatotal_b= number_format($pengecekan[0]['hargatotal'],2,",",".");
                $tanggalpengajuan_b = $pengecekan[0]['tanggalpengajuan'];
            }
            ?>
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Penerimaan Bahan Masakan</h3>
                    <p>Jumlah Biaya : Rp. <?php echo $hargatotal_b;?></p>
                </div>
              <div class="icon">
                  <i class="ion ion-cash"></i>
              </div>
              <a href="<?php echo base_url().'pengecekanbahan'; ?>" class="small-box-footer"> Tanggal pengajuan : <?php echo $tanggalpengajuan_b;?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Kebutuhan Bahan Masakan (30 hari) : <?php echo date('Y-m-d',strtotime(date("Y-m-d") . "-30 days"))?> - <?php echo date("Y-m-d")?></h3>
                </div>
                <div class="box-body">
                <div class="chart">
                    <canvas id="barChart_bahanmasakan" style="height:230px"></canvas>
                </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Kebutuhan Masakan (30 hari) : <?php echo date('Y-m-d',strtotime(date("Y-m-d") . "-30 days"))?> - <?php echo date("Y-m-d")?></h3>
                </div>
                <div class="box-body">
                <div class="chart">
                    <canvas id="barChart_masakan" style="height:230px"></canvas>
                </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
  <!-- Main row -->
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>

<script>
  $(function () {

    var areaChartData = {
      labels  : <?php echo $grafik_nama;?>,
      datasets: [
        {
          fillColor           : 'rgb(255, 205, 86, 1)',
          strokeColor         : 'rgb(255, 205, 86, 1)',
          pointColor          : 'rgb(255, 205, 86, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgb(255, 205, 86, 1)',
          data                : <?php echo $grafik_angka;?>
        }
      ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart_bahanmasakan').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)

    var areaChartData2 = {
      labels  : <?php echo $grafik_nama_masakan;?>,
      datasets: [
        {
          fillColor           : 'rgb(255, 205, 86, 1)',
          strokeColor         : 'rgb(255, 205, 86, 1)',
          pointColor          : 'rgb(255, 205, 86, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgb(255, 205, 86, 1)',
          data                : <?php echo $grafik_pasien;?>
        }
      ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart_masakan').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData2
    
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>