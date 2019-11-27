<script type="text/javascript">
    $(document).ready(function () {
        $(".datepicker-input").each(function(){ $(this).datepicker();});
        $("#namasupplier").focus();

        $("#formoid").submit(function(event) {
            event.preventDefault();
            var namasupplier = $('#namasupplier').val();
            if (namasupplier == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama Supplier harus diisi.");
                $("#namasupplier").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'supplier/savedata_supplier'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                        $("#submitButton").attr("disabled",true);
                    },
                    success: function(resp){
                        window.location.assign("<?php echo base_url().'supplier'; ?>");
                    },
                    error: function(event, textStatus, errorThrown) {
                       alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });
            }
        });
    });
</script>
<?php    
    $sess_data['url'] = $this->input->server('REQUEST_URI');    
    $this->session->set_userdata($sess_data);
?>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Form</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <form class="form-horizontal" id="formoid" action="" title="" method="post">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Nama Supplier</label>
                    <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="idsupplier" name="idsupplier" value="<?php echo $idsupplier;?>">
                        <input type="text" class="form-control" id="namasupplier" name="namasupplier" placeholder="Nama Supplier" value="<?php echo $namasupplier;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Tanggal Awal Kontrak</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control datepicker-input" placeholder="Pilih Tanggal Awal" data-date-format="yyyy-mm-dd" id="kontraktanggalawal" name="kontraktanggalawal" value="<?php echo $kontraktanggalawal;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Tanggal Akhir Kontrak</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control datepicker-input" placeholder="Pilih Tanggal Akhir" data-date-format="yyyy-mm-dd" id="kontraktanggalakhir" name="kontraktanggalakhir" value="<?php echo $kontraktanggalakhir;?>">
                    </div>
                </div>
                <?php
                if ($idsupplier != '') {
                ?>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Stat</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="stat_supplier" id="stat_supplier">
                            <option value="aktif" <?php if ($stat_supplier == 'aktif') { echo 'selected';}?>>AKTIF</option>
                            <option value="tidak aktif" <?php if ($stat_supplier == 'tidak aktif') { echo 'selected';}?>>TIDAK AKTIF</option>
                        </select>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer">
            <a type="button" class="btn btn-danger" href="<?php echo base_url()?>supplier"><i class="fa fa-reply"></i> Kembali</a>
        </div><!-- /.box-footer -->
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>