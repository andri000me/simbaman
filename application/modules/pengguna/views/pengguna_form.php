<?php
    $this->load->view('pengguna/js');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#namalengkap").focus();
    });
</script>
<?php    
    $sess_data['url'] = $this->input->server('REQUEST_URI');    
    $this->session->set_userdata($sess_data);
?>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Form Tambah Pengguna</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <form class="form-horizontal" id="formoid" action="" title="" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" id="idpengguna" name="idpengguna" value="<?php echo $idpengguna;?>">
                            <input type="hidden" class="form-control" id="idpeserta" name="idpeserta" value="">
                            <input type="text" class="form-control" id="namalengkap" name="namalengkap" placeholder="Nama Lengkap" value="<?php echo $namalengkap;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kelamin" name="kelamin">
                                <option value="">-- Pilih Kelamin</option>
                                <option value="pria" <?php if (!empty($kelamin) && $kelamin == 'pria')  echo 'selected = "selected"'; ?>>Pria</option>
                                <option value="wanita" <?php if (!empty($kelamin) && $kelamin == 'wanita')  echo 'selected = "selected"'; ?>>Wanita</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $password;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Grup Pengguna</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="idgrup" name="idgrup">
                                <option value="pilih">-- Pilih Grup Pengguna</option>
                                <?php foreach($grup as $key => $val) { ?>
                                <option value="<?php echo $val['idgrup']; ?>" <?php if (!empty($idgrup) && $idgrup == $val['idgrup'])  echo 'selected = "selected"'; ?>><?php echo $val['namagrup']; ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                            <a type="button" class="btn btn-danger" href="<?php echo base_url()?>pengguna"><i class="fa fa-reply"></i> Kembali</a>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </form>            
        </div>
        <!-- <div class="box-footer"> -->
            
        <!-- </div>/.box-footer -->
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>