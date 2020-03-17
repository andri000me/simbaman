
<?php  
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>
<script>

function pilihBulan()
{
    var bulan = $('#bulan').val();
    $.ajax({
        type: "POST",
        data: {"bulan":bulan},
        url: "<?php echo base_url().'prediksipengajuan/get_prediksi'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#konten_prediksi").html(resp);
            $("#loading").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

</script>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Prediksi Bahan Masakan</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>        
        <div class="box-body">
            <div class="row" style="margin-bottom:10px">
                <div class="col-lg-12">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Prediksi Pengajuan Bahan (Bulan)</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="bulan" name="bulan">
                                    <option value="1">1 bulan</option>
                                    <option value="3">3 bulan</option>
                                    <option value="6">6 bulan</option>
                                    <option value="12">12 bulan</option>
                                </select>
                            </div>       
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" onclick="javascript:pilihBulan();">Pilih Bulan</button>
                            </div>                     
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div id="konten_prediksi">
        <div class="box">
            <div class="box-header with-border">
                <h3 style="text-align: center;">
                    Prediksi Kebutuhan Bahan Selama 1 Bulan <br>
                    Mulai tanggal <?php echo $tgl_prediksi?> s/d <?php echo $tgl_sekarang?>
                </h3>
            </div>        
            <div class="box-body">
                <div class="row" style="margin-bottom:10px">
                    <div class="col-lg-12" style="text-align: center;">
                        <a target="_blank" href="<?php echo base_url()?>prediksipengajuan/cetakprediksi/1" class="btn btn-success">Cetak Prediksi Pengajuan Bahan</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align: center;">No</th>
                                        <th style="text-align: center;">Nama Bahan</th>
                                        <th width="15%" style="text-align: center;">Jml Kebutuhan</th>
                                        <th width="5%" style="text-align: center;">Satuan</th>
                                        <th width="15%" style="text-align: center;">Harga Supplier</th>
                                        <th width="25%" style="text-align: center;">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $hargatotal = 0;
                                    foreach ($prediksi as $data) {
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $no;?></td>
                                        <td><?php echo $data['namabahan'];?></td>
                                        <td style="text-align: right;"><?php echo number_format($data['rata_kuantitasreal'],2);?></td>
                                        <td style="text-align: center;"><?php echo $data['satuan'];?></td>
                                        <td style="text-align: right;"><?php echo number_format($data['hargasatuansupplier'],2);?></td>
                                        <th style="text-align: right;"><?php echo number_format($data['rata_totalreal'],2,",",".");?></th>
                                    </tr>
                                    <?php
                                    $no++;
                                    $hargatotal = $hargatotal + $data['rata_totalreal'];
                                    }
                                    ?>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Harga Total Prediksi Pengajuan Bahan Masakan</th>
                                        <th style="text-align: right;"><?php echo number_format($hargatotal,2,",",".");?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

        <!-- <div class="box-footer"> -->
            
        <!-- </div>/.box-footer                 -->
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>