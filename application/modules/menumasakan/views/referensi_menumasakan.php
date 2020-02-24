<?php  
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>

<script>
    $(document).ready(function () {
        $(document).on('click', '#tampilinfo', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'menumasakan/infomodul'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    $("#modal").modal('show');
                    $("#content_modal").html(resp);
                    $("#loading").html("");
                },
                error:function(event, textStatus, errorThrown) {
                    alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });

        $(document).on('click', '#konfirmasi_reset_menumasakan', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'menumasakan/konfirmasi_reset'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    $("#modal").modal('show');
                    $("#content_modal").html(resp);
                    $("#loading").html("");
                },
                error:function(event, textStatus, errorThrown) {
                    alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });

        $(document).on('click', '#reset_menumasakan', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'menumasakan/reset_menumasakan'; ?>",
                beforeSend: function(){
                    $("#loading_reset").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        window.location.assign("<?php echo base_url().'menumasakan'; ?>");
                    } else if (resp == 100){
                        $("#modal").modal('hide');
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
    });
</script>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Referensi Menu Masakan </h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        
        <div class="box-body">
            <?php
            $no = 1;
            foreach ($jenismenumasakan as $jenismenu) {
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="callout callout-info">
                        <h4><?php echo $no; ?>. <?php echo $jenismenu['namajenismenu'];?></h4>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                            <table class="table table-bordered">
                            <tr>
                                <th width="" style="text-align: center;">Waktu / Kelas</th>
                                <?php
                                foreach ($kelasmenumasakan as $kelas) {
                                    if ($kelas['idjenismenu'] == $jenismenu['idjenismenu']) {
                                    ?>
                                    <th width="20%" style="text-align: center;"><?php echo $kelas['namakelas']?></th>
                                    <?php
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                            foreach ($waktumenumasakan as $waktu) {
                                if ($waktu['idjenismenu'] == $jenismenu['idjenismenu']) {
                            ?>
                            <tr>
                                <th><?php echo $waktu['namawaktumenu'];?></th>
                                <?php
                                foreach ($kelasmenumasakan as $kelas2) {
                                    if ($kelas2['idjenismenu'] == $waktu['idjenismenu']) {
                                ?>
                                    <td>
                                    <?php
                                    foreach ($menumasakan as $masakan) {
                                        if ($masakan['idkelas'] == $kelas2['idkelas'] && $masakan['idwaktumenu'] == $waktu['idwaktumenu']
                                            && $masakan['idjenismenu'] == $kelas2['idjenismenu'] && $masakan['idjenismenu'] == $waktu['idjenismenu']) {
                                            echo $masakan['namamasakan'].'<br>';
                                        }
                                    }
                                    ?>
                                    </td>
                                <?php
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div><!-- /.nav-tabs-custom -->
            </div>
            <?php
            $no++;
            }
            ?>
        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
            <button type="button" class="btn btn-warning" id="konfirmasi_reset_menumasakan"><i class="fa fa-copy"></i> Reset Menu Masakan</button>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>menumasakan"><i class="fa fa-reply"></i> Kembali</a>
        </div><!-- /.box-footer -->                
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>