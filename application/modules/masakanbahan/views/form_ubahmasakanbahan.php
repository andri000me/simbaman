<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Form Ubah Masakan Bahan</h4>
    </div>
    <div class="modal-body">
	    <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" id="formoid" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Masakan</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idmasakanbahan_y" name="idmasakanbahan_y" value="<?php echo $masakanbahan[0]['idmasakanbahan'];?>">
                            <input type="hidden" class="form-control" id="idmasakan_y" name="idmasakan_y" value="<?php echo $masakanbahan[0]['idmasakan'];?>">
                            <input type="text" class="form-control" id="namamasakan_y" name="namamasakan_y" placeholder="Nama Masakan" readonly value="<?php echo $masakanbahan[0]['namamasakan'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Masakan</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idbahan_y" name="idbahan_y" value="<?php echo $masakanbahan[0]['idbahan'];?>">
                            <input type="text" class="form-control" id="namabahan_y" name="namabahan_y" placeholder="Nama Bahan" readonly value="<?php echo $masakanbahan[0]['namabahan'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Kuantitas</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="kuantitas_y" name="kuantitas_y" value="<?php echo $masakanbahan[0]['kuantitas'];?>" placholder="Kuantitas">                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Satuan</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="satuan_y" name="satuan_y" value="<?php echo $masakanbahan[0]['satuan'];?>" placholder="Satuan">                            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" id="btnubahmasakanbahan" name="btnubahmasakanbahan" onclick="javascript:ubahmasakanbahan();">Ubah Masakan Bahan</button>
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