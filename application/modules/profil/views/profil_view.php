<?php
    $this->load->view('profil/js');
?>
<?php  
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Profil Pengguna Sistem</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-lg-3">
                    <div style="text-align: center">
                    <?php
                    if ($foto == NULL) {
                    ?>                    
                        <img class="img-thumbnail" src="<?php echo base_url()?>/assets/dist/img/<?php echo $kelamin;?>.png">
                    <?php
                    } else {
                    ?>
                        <img class="img-thumbnail" src="<?php echo base_url()?><?php echo $foto;?>">
                    <?php
                    }
                    ?>
                    </div>
                </div>
                <div class="col-lg-9">
                    <form class="form-horizontal" id="formoid" action="" title="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="hidden" class="form-control" id="idpengguna" name="idpengguna" value="<?php echo $idpengguna;?>">
                                    <input type="text" readonly="" class="form-control" id="namalengkap" name="namalengkap" placeholder="Nama Lengkap" value="<?php echo $namalengkap;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly="" class="form-control" id="kelamin" name="kelamin" placeholder="Kelamin" value="<?php echo $kelamin;?>">
                                </div>
        <!--                        <div class="col-sm-10">
                                    <select readonly="" class="form-control" id="kelamin" name="kelamin">
                                        <option value="">-- Pilih Kelamin</option>
                                        <option value="pria" <?php // if (!empty($kelamin) && $kelamin == 'pria')  echo 'selected = "selected"'; ?>>Pria</option>
                                        <option value="wanita" <?php // if (!empty($kelamin) && $kelamin == 'wanita')  echo 'selected = "selected"'; ?>>Wanita</option>
                                    </select>
                                </div>-->
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly="" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-warning" id="editButton" name="editButton"><i class="fa fa-info"></i> Ubah Data</button>
                                    <button type="button" class="btn btn-primary" id="pictureButton" name="pictureButton"><i class="fa fa-picture-o"></i> Ubah Foto</button>
                                    <button type="button" class="btn btn-danger" id="delpictureButton" name="delpictureButton"><i class="fa fa-eraser"></i> Hapus Foto</button>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="box-footer"> -->
            
        <!-- </div>/.box-footer                 -->
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>