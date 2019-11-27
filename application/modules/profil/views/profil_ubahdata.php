<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Ubah Data</h4>
    </div>
    <div class="modal-body">
	<div class="row">
            <div class="col-xs-12">
                <form class="form-horizontal" id="formubah_data" action="" title="" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="idpengguna_x" name="idpengguna_x" value="<?php echo $idpengguna;?>">
                                <input type="text" class="form-control" id="namalengkap_x" name="namalengkap_x" placeholder="Nama Lengkap" value="<?php echo $namalengkap;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="kelamin_x" name="kelamin_x">
                                    <option value="">-- Pilih Kelamin</option>
                                    <option value="pria" <?php if (!empty($kelamin) && $kelamin == 'pria')  echo 'selected = "selected"'; ?>>Pria</option>
                                    <option value="wanita" <?php if (!empty($kelamin) && $kelamin == 'wanita')  echo 'selected = "selected"'; ?>>Wanita</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username_x" name="username_x" placeholder="Username" value="<?php echo $username;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password_x" name="password_x" placeholder="Password" value="<?php echo $password;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-success" id="submitButton" name="submitButton">Simpan</button>
                                <input type="reset" class="btn btn-warning" id="resetButton" name="resetButton" value="Reset">
                                <span id="loading_save"></span>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </form>
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.row -->
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>