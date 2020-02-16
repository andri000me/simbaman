<script type="text/javascript">

    $(document).ready(function () {
        $("#formoid").submit(function(event) {
            event.preventDefault();
            var namabahan = $('#namabahan').val();
            if (namabahan == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama Bahan harus diisi.");
                $("#namabahan").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'masakanbahan/savedata_bahan'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                        $("#submitButton").attr("disabled",true);
                    },
                    success: function(resp){
                        window.location.assign("<?php echo base_url().'masakanbahan/bahan'; ?>");
                    },
                    error: function(event, textStatus, errorThrown) {
                       alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });
            }
        });

    });
</script>

<section class="content">
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">From Masakan Bahan</h3>
        <span class="pull-right">
            <span id="loading"></span>
        </span>
    </div>
    
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <form class="form-horizontal" id="formoid" action="" title="" method="post">
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
                        </div>
                    </div>
                </form>
            </div>                
        </div>
        <div id="get_kelaspasien"></div>
    </div>
    <div class="box-footer">
        <a type="button" class="btn btn-danger" href="<?php echo base_url()?>masakanbahan/bahan"><i class="fa fa-reply"></i> Kembali</a>
    </div><!-- /.box-footer -->                
</div><!-- /.box -->	
</section><!-- /.content -->