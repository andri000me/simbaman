<?php
    $this->load->view('bahan/js');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#namamenu").focus();
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
            <h3 class="box-title">Form</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <form class="form-horizontal" id="formoid" action="" title="" method="post">
                <div class="box-body">
                <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Bahan</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idbahan" name="idbahan" value="<?php echo $idbahan;?>">
                            <input type="text" class="form-control" id="namabahan" name="namabahan" placeholder="Nama Bahan" value="<?php echo $namabahan;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Satuan</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="satuan" id="satuan">
                                <option value="">-- Pilih Satuan</option>
                                <?php
                                foreach ($satuanbahan as $sat) {
                                ?>
                                    <option value="<?php echo $sat['satuan'];?>" <?php if ($sat['satuan'] == $satuan) { echo 'selected="selected"';}?>><?php echo $sat['satuan'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Jenis</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="jenis" id="jenis">
                                <option value="">-- Pilih Jenis Masakan</option>
                                <?php
                                foreach ($jenismasakan as $jns) {
                                ?>
                                    <option value="<?php echo $jns['namajenismasakan'];?>" <?php if ($jns['namajenismasakan'] == $jenis) { echo 'selected="selected"';}?>><?php echo $jns['namajenismasakan'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                            <input type="reset" class="btn btn-warning" id="resetButton" name="resetButton" value="Reset">
                        </div>
                    </div>                    
                </div><!-- /.box-body -->
            </form>
        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>bahan"><i class="fa fa-reply"></i> Kembali</a>
        </div><!-- /.box-footer -->
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>