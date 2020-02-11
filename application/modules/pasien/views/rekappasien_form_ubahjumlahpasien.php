<?php
/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-14 10:54:58
 * @modify date 2019-09-14 10:54:58
 * @desc [description]
 */

 ?>


<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Ubah Jumlah Pasien</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ruang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $data_jumlahpasien[0]['namaruang'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bangsal</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $data_jumlahpasien[0]['namabangsal'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kelas</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $data_jumlahpasien[0]['namakelas'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jumlah Pasien</label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" id="idrekapjumlahpasien" value="<?php echo $data_jumlahpasien[0]['idrekapjumlahpasien'];?>">                            
                            <input type="hidden" class="form-control" id="tanggalrekap" value="<?php echo $data_jumlahpasien[0]['tanggalrekap'];?>">
                            <input type="text" class="form-control" id="jumlahpasien" value="<?php echo $data_jumlahpasien[0]['jumlahpasien'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-success" onclick="javascript:ubahjumlahpasien();">Ubah Data</button>
                        </div>
                        <div class="col-sm-3">
                            <span id="loading_ubahjumlahpasien"></span>
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