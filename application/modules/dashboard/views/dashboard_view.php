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
  <!-- Main row -->
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>