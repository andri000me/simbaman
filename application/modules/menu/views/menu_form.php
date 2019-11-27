<?php
    $this->load->view('menu/js');
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
                            <input type="hidden" class="form-control" id="idmenu" name="idmenu" value="<?php echo $idmenu;?>">
                            <input type="text" class="form-control" id="namamenu" name="namamenu" placeholder="Nama Menu" value="<?php echo $namamenu;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nomor Urutan Menu</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="urutanmenu" name="urutanmenu" placeholder="Nomor Urut Menu" value="<?php echo $urutanmenu;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Ikon Menu</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ikonmenu" name="ikonmenu" placeholder="Ikon Menu" value="<?php echo $ikonmenu;?>">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" id="cari_icon"><i class="fa fa-search-plus"></i> Cari Ikon</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Keterangan Menu</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" placeholder="Keterangan Menu" id="keteranganmenu" name="keteranganmenu"><?php echo $keteranganmenu;?></textarea>
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
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>menu"><i class="fa fa-reply"></i> Kembali</a>
        </div><!-- /.box-footer -->
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>