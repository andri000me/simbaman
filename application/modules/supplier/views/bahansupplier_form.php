<script type="text/javascript">
    $(document).ready(function () {
        $("#formoid").submit(function(event) {
            var idsupplier = $('#idsupplier').val();
            event.preventDefault();
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: "<?php echo base_url().'supplier/savedata_bahansupplier'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    $("#submitButton").attr("disabled",true);
                },
                success: function(resp){
                    window.location.assign("<?php echo base_url().'supplier/detailbahan/'; ?>"+idsupplier);
                },
                error: function(event, textStatus, errorThrown) {
                    alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
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
            <h3 class="box-title">Form</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <form class="form-horizontal" id="formoid" action="" title="" method="post">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Nama Supplier</label>
                    <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="idbahansupplier" name="idbahansupplier" value="<?php echo $idbahansupplier;?>">
                        <select class="form-control" name="idsupplier" id="idsupplier">
                            <?php 
                            foreach ($supplier as $d) {
                            ?>
                                <option value="<?php echo $d['idsupplier'];?>" <?php if ($d['idsupplier'] == $idsupplier) { echo 'selected';}?>><?php echo $d['namasupplier'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Nama Bahan</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="idbahan" id="idbahan">
                            <?php 
                            foreach ($bahan as $d) {
                            ?>
                                <option value="<?php echo $d['idbahan'];?>" <?php if ($d['idbahan'] == $idbahan) { echo 'selected';}?>><?php echo $d['namabahan'];?> | <?php echo $d['satuan'];?> | <?php echo $d['jenis'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Harga Satuan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Harga Satuan" id="hargasatuan" name="hargasatuan" value="<?php echo $hargasatuan;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Satuan</label>
                    <div class="col-sm-3">
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
                    <label for="" class="col-sm-2 control-label">Spesifikasi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Spesifikasi" id="spesifikasi" name="spesifikasi" value="<?php echo $spesifikasi;?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer">
            <a type="button" class="btn btn-danger" href="<?php echo base_url()?>supplier"><i class="fa fa-reply"></i> Kembali</a>
        </div><!-- /.box-footer -->
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>