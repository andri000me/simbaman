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
                        <label for="" class="col-sm-2 control-label">Nama Menu</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idbahan" name="idbahan" value="<?php echo $idbahan;?>">
                            <input type="text" class="form-control" id="namabahan" name="namabahan" placeholder="Nama Bahan" value="<?php echo $namabahan;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Satuan</label>
                        <div class="col-sm-3">                     
                            <select class="form-control" id="satuan" name="satuan">
                                <option value="bags" <?php if (!empty($satuan) && $satuan == 'bags')  echo 'selected = "selected"'; ?>>bags</option>
                                <option value="bh" <?php if (!empty($satuan) && $satuan == 'bh')  echo 'selected = "selected"'; ?>>bh</option>
                                <option value="btl" <?php if (!empty($satuan) && $satuan == 'btl')  echo 'selected = "selected"'; ?>>btl</option>
                                <option value="btr" <?php if (!empty($satuan) && $satuan == 'btr')  echo 'selected = "selected"'; ?>>btr</option>
                                <option value="dos" <?php if (!empty($satuan) && $satuan == 'dos')  echo 'selected = "selected"'; ?>>dos</option>
                                <option value="gls" <?php if (!empty($satuan) && $satuan == 'gls')  echo 'selected = "selected"'; ?>>gls</option>
                                <option value="gr" <?php if (!empty($satuan) && $satuan == 'gr')  echo 'selected = "selected"'; ?>>gr</option>
                                <option value="ktk" <?php if (!empty($satuan) && $satuan == 'ktk')  echo 'selected = "selected"'; ?>>ktk</option>
                                <option value="ml" <?php if (!empty($satuan) && $satuan == 'ml')  echo 'selected = "selected"'; ?>>ml</option>
                                <option value="ptg" <?php if (!empty($satuan) && $satuan == 'ptg')  echo 'selected = "selected"'; ?>>ptg</option>
                                <option value="sch" <?php if (!empty($satuan) && $satuan == 'sch')  echo 'selected = "selected"'; ?>>sch</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Jenis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis" value="<?php echo $jenis;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="stat" name="stat">
                                <option value="aktif" <?php if (!empty($stat) && $stat == 'aktif')  echo 'selected = "selected"'; ?>>AKTIF</option>
                                <option value="tidak" <?php if (!empty($stat) && $stat == 'tidak')  echo 'selected = "selected"'; ?>>TIDAK AKTIF</option>
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