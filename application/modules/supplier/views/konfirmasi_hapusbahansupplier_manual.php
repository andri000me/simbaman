<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Konfirmasi Hapus Data</h4>
    </div>
    <div class="modal-body">
	    <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-info">
                    <h4><i class="icon fa fa-warning"></i> Perhatian !!</h4>
                    <hr>
                    <?php //var_dump($masakan);?>
                    <p>Apakah Anda ingin menghapus data : Bahan ini</p>
                        <input type="hidden" class="form-control" id="idbahansupplier_delete" value="<?php echo $bahansupplier[0]['idbahansupplier']; ?>">
                        <input type="hidden" class="form-control" id="idsupplier_delete" value="<?php echo $bahansupplier[0]['idsupplier']; ?>">
                        <button type="button" class="btn btn-danger btn-lg" id="hapus_data" onclick="javascript:hapus_bahansupplier_manual();"><i class="fa fa-trash"></i> Hapus</button>
                        <span id="loading_delete"></span>
                </div>
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.row -->
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>