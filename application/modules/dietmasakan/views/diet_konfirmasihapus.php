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
                <p>Apakah Anda ingin menghapus data : <?php echo $namadiet; ?> ?</p>
                <input type="hidden" class="form-control" id="iddiet_hapus" value="<?php echo $iddiet; ?>">
                <button type="button" class="btn btn-danger btn-lg" id="hapus_data_Diet"><i class="fa fa-trash"></i> Hapus</button>
                <span id="loading_delete"></span>
              </div>
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.row -->
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>