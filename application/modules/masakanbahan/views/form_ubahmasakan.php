<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Form Ubah Masakan</h4>
    </div>
    <div class="modal-body">
	    <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" id="formoid" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Masakan</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idmasakan" name="idmasakan" value="<?php echo $masakan[0]['idmasakan'];?>">
                            <input type="text" class="form-control" id="namamasakan" name="namamasakan" placeholder="Nama Masakan" value="<?php echo $masakan[0]['namamasakan'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" id="btnubahmasakan" name="btnubahmasakan" onclick="javascript:ubahmasakan();">Ubah Masakan</button>
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