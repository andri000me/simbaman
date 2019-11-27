<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-10-09 06:15:55
 * @modify date 2019-10-09 06:15:55
 * @desc [description]
 */

 ?>


<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Form Kesesuaian Bahan Realisasi</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12">
                <?php //print_r($get_pengajuanbahansupplier);?>
                <form class="form-horizontal" id="formoid" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Jumlah Kuantitas Real</label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" id="idpengajuan" name="idpengajuan" value="<?php echo $idpengajuan;?>">
                            <input type="hidden" class="form-control" id="idbahansupplier" name="idbahansupplier" value="<?php echo $idbahansupplier;?>">
                            <input type="hidden" class="form-control" id="pengajuan" name="pengajuan" value="<?php echo $pengajuan;?>">                            
                            <input type="text" class="form-control" id="jumlahkuantitasreal" name="jumlahkuantitasreal" placeholder="<?php echo $get_pengajuanbahansupplier[0]['jumlahkuantitas'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Harga Total Real</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="hargatotalreal" name="hargatotalreal" placeholder="<?php echo $get_pengajuanbahansupplier[0]['hargatotal'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="button" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan" onclick="javascript:simpanpengajuanbahancek();">
                            <span id="loading_simpanpengajuanbahancek"></span>
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