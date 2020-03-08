<script>
$(document).ready(function () {
    $("#formoid_bahantambahan").submit(function(event) {
        var idpengajuan = $('#idpengajuan').val();
        event.preventDefault();
        $.ajax({
            type: "POST",
            data: $(this).serialize(),
            url: "<?php echo base_url().'pengecekanbahan/savedata_bahantambahan'; ?>",
            beforeSend: function(){
                $("#loading_simpanbahantambahan").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                $("#submitButton_bahantambahan").attr("disabled",true);
            },
            success: function(resp){                
                form_bahantambahan(idpengajuan);
                pilihTanggalPengajuanBahan();
            },
            error: function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    });
});

function hitung_hargatotal()
{
    var idbahan = $('#idbahan').val();
    var jumlahkuantitas = $('#jumlahkuantitas').val();
    $.ajax({
            type: "POST",
            data: {"idbahan":idbahan,"jumlahkuantitas":jumlahkuantitas},
            url: "<?php echo base_url().'pengecekanbahan/hitung_hargatotal'; ?>",
            beforeSend: function(){
                $("#cek_harga").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                $("#cek_harga").html("");
                $("#hargatotal").val(resp);
            },
            error: function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
}
</script>
<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Form Bahan Tambahan</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" id="formoid_bahantambahan" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Tanggal Rekap Pasien</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" readonly id="idbahanpengajuan" name="idbahanpengajuan" value="">
                            <input type="hidden" class="form-control" readonly id="idpengajuan" name="idpengajuan" value="<?php echo $idpengajuan;?>">
                            <input type="text" class="form-control" readonly id="tanggalrekappasien" name="tanggalrekappasien" value="<?php echo $tanggalrekappasien;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Tanggal Pengajuan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly id="tanggalpengajuan" name="tanggalpengajuan" value="<?php echo $tanggalpengajuan;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Bahan Masakan Tambahan</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="idbahan" id="idbahan">
                                <option value="">-- Pilih Bahan Masakan</option>
                                <?php
                                foreach ($bahantambahan as $bahan) {
                                ?>
                                    <option value="<?php echo $bahan['idbahan'];?>"><?php echo $bahan['namabahan'];?> (<?php echo $bahan['satuan'];?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Jumlah Kuantitas</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="jumlahkuantitas" name="jumlahkuantitas" placeholder="Jumlah Kuantitas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Satuan</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="satuan" id="satuan" onchange="javascript:hitung_hargatotal();">
                                <option value="">-- Pilih Satuan</option>
                                <?php
                                foreach ($satuan as $sat) {
                                ?>
                                    <option value="<?php echo $sat['satuan'];?>"><?php echo $sat['satuan'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6"><span id="cek_harga"></span></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">Harga Total</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="hargatotal" name="hargatotal" placeholder="Harga Total">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="submit" class="btn btn-success" id="submitButton_bahantambahan" name="submitButton" value="Simpan">
                            <input type="reset" class="btn btn-warning" id="resetButton" name="resetButton" value="Reset">
                            <span id="loading_simpanbahantambahan"></span>
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