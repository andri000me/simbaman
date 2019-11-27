<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Form Ubah Data</h4>
    </div>
    <div class="modal-body">
	    <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" id="formoid" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Diet</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="iddietmasakanbahan_ubah" name="iddietmasakanbahan_ubah" value="<?php echo $dietmasakanbahan[0]['iddietmasakanbahan'];?>">
                            <input type="hidden" class="form-control" id="iddiet_ubah" name="iddiet_ubah" value="<?php echo $dietmasakanbahan[0]['iddiet'];?>">
                            <input type="text" class="form-control" id="" name="" value="<?php echo $dietmasakanbahan[0]['namadiet'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Masakan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="" name="" value="<?php echo $dietmasakanbahan[0]['namamasakan'];?>" readonly> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Bahan Masakan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="" name="" value="<?php echo $dietmasakanbahan[0]['namabahan'];?> | <?php echo $dietmasakanbahan[0]['kuantitas'];?> <?php echo $dietmasakanbahan[0]['satuan_kauntitas'];?>" readonly>
                        </div>
                    </div>   
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Pengurangan</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Pungurangan" class="form-control" id="pengurangan_ubah" name="pengurangan_ubah" value="<?php echo $dietmasakanbahan[0]['pengurangan'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Satuan</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="satuan_ubah" id="satuan_ubah">
                                <option value="">-- Pilih Satuan</option>
                                <?php
                                foreach ($satuan as $sat) {
                                ?>
                                    <option value="<?php echo $sat['satuan'];?>" <?php if ($sat['satuan'] == $dietmasakanbahan[0]['satuan_pengurangan']) { echo "selected='selected'";}?>><?php echo $sat['satuan'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>                     
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" id="ubah_data" onclick="javascript:ubah_dietmasakan();">Ubah</button>
                            <span id="loading_ubah"></span>
                        </div>
                    </div>
                </form>
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.row -->
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>