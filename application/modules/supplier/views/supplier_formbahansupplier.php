<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Bahan Supplier</h4>
    </div>
    <div class="modal-body">
	    <div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" id="formoid" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Copy Bahan Supplier</label>
                        <input type="hidden" value="<?php echo $idsupplier;?>" id="idsupplier">
                        <div class="col-sm-9">
                            <select class="form-control" name="idsupplier_copy" id="idsupplier_copy">
                                <option value="">-- Pilih Supplier</option>
                                <?php
                                foreach ($supplier as $data) {
                                ?>
                                    <option value="<?php echo $data['idsupplier'];?>"><?php echo $data['namasupplier'];?></option>
                                <?php
                                }
                                ?>
                            </select>    
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-success" onclick="javascript:copysupplier();" id="btncopysupplier">Copy Bahan Supplier</button>
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