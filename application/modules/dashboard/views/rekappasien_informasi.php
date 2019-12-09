<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Informasi Data Pasien</h4>
    </div>
    <div class="modal-body">
        <div class="row" style="margin-bottom:10px">
            <div class="col-lg-12">
                <h3>Tanggal : <?php echo $tanggalsekarang;?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <?php
                echo $informasi;
                ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
	    <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>