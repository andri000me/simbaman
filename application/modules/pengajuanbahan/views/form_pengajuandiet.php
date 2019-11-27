<script>
$(document).ready(function () {
    $("#formoid").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            data: $(this).serialize(),
            url: "<?php echo base_url().'pengajuanbahan/savedata_pengajuandiet'; ?>",
            beforeSend: function(){
                $("#loading_simpandietmasakan").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                $("#submitButton_dietmasakan").attr("disabled",true);
            },
            success: function(resp){                
                $("#modal_default").modal('hide');
                pilihTanggalPengajuanBahan();
            },
            error: function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    });
});
</script>

<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Form Pengajuan Pasien Diet</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" id="formoid" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Nama Diet</label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" id="idpengajuanbahandietdetail" name="idpengajuanbahandietdetail" value="">
                            <input type="hidden" class="form-control" id="idpengajuan" name="idpengajuan" value="<?php echo $idpengajuan;?>">
                            <select class="form-control" name="iddiet" id="iddiet">
                                <option value="">-- Pilih Diet</option>
                                <?php
                                foreach ($diet as $diit) {
                                ?>
                                    <option value="<?php echo $diit['iddiet'];?>"><?php echo $diit['namadiet'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Nama Kelas</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="idkelas" id="idkelas" onchange="javascrupt:get_bangsal('<?php echo $tanggalrekap;?>');">
                                <option value="">-- Pilih Kelas</option>
                                <?php
                                foreach ($kelas as $kls) {
                                ?>
                                    <option value="<?php echo $kls['idkelas'];?>"><?php echo $kls['kodekelas'];?> <?php echo $kls['namakelas'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Nama Bangsal</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="idbangsal" id="idbangsal">
                                <option value="">-- Pilih Bangsal</option>
                                <?php
                                foreach ($bangsal as $b) {
                                ?>
                                    <option value="<?php echo $b['idbangsal'];?>"><?php echo $b['kodebangsal'];?> <?php echo $b['namabangsal'];?> (<?php echo $b['jumlahpasien'];?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Jumlah Pasien</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="jumlahpasien" name="jumlahpasien" placeholder="Jumlah Pasien">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="submit" class="btn btn-success" id="submitButton_dietmasakan" name="submitButton" value="Simpan">
                            <input type="reset" class="btn btn-warning" id="resetButton" name="resetButton" value="Reset">
                            <span id="loading_simpandietmasakan"></span>
                        </div>
                    </div>
                </form>
            </div><!-- /.nav-tabs-custom -->
        </div>
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>