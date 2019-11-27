<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Ubah Foto</h4>
    </div>
    <div class="modal-body">
	<div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success" style="text-align: center;">
                    <p>Disarankan ukuran maksimal foto 512pixel x 512pixel, jenis foto *.jpg dan besar file maksismal 1 MB.</p>
                </div> 
            </div>
        </div>
        <form action="javascript:upload_foto();" data-validate="parsley" class="form-horizontal" name="frm_upload_foto" id="frm_upload_foto" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg-3 control-label">Pilih foto &nbsp;<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input name="idpengguna" id="idpengguna" class="form-control" type="hidden" placeholder="" value="<?php echo $idpengguna;?>">
                    <input name="fotoFile" id="fotoFile" class="form-control" type="file">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-3">
                    <button type="submit" id="btnUpload" class="btn btn-success" onclick="javascript:upload_foto();"><i class="fa fa-save"></i> Simpan</button>                    &nbsp;
                    <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
                    &nbsp;
                    <span id="loadingsaveUpload"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-3"></div>
                <div class="col-lg-8">
                    <span id="alertinputUpload"></span>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>