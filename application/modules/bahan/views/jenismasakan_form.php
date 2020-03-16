<?php
    //$this->load->view('jenismasakan/js');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#namajenismasakan").focus();

        $("#formoid").submit(function(event) {
            event.preventDefault();
            var namajenismasakan = $('#namajenismasakan').val();
            if (namajenismasakan == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama Jenis Masakan harus diisi.");
                $("#namajenismasakan").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'bahan/savedata_jenismasakan'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    },
                    success: function(resp){
                        $("#loading").html("");
                        if (resp == 101){
                            $("#loading").html("Berhasil menyimpan data");
                            window.location.assign("<?php echo base_url().'bahan/jenisbahan'; ?>");
                        } else if (resp == 100){
                            $("#loading").html("Gagal menyimpan data");;
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                       alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });
            }
        });
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
            <h3 class="box-title">Form Tambah Jenis Golongan Bahan Masakan</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <form class="form-horizontal" id="formoid" action="" title="" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Jenis Masakan</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idjenismasakan" name="idjenismasakan" value="<?php echo $idjenismasakan;?>">
                            <input type="text" class="form-control" id="namajenismasakan" name="namajenismasakan" placeholder="Nama Jenis Masakan" value="<?php echo $namajenismasakan;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                            <a type="button" class="btn btn-danger" href="<?php echo base_url()?>bahan/jenisbahan"><i class="fa fa-reply"></i> Kembali</a>
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