<?php    
    $sess_data['url'] = $this->input->server('REQUEST_URI');    
    $this->session->set_userdata($sess_data);
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formmodulid").submit(function(event) {
            event.preventDefault();
            var namadiet = $('#namadiet').val();
            if (namadiet == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama diet harus diisi.");
                $("#namadiet").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'dietmasakan/savedata_diet'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    },
                    success: function(resp){
                        if (resp == 101){
                            $("#loading").html("Berhasil menyimpan data");
                            window.location.assign("<?php echo base_url().'dietmasakan/listdiet'; ?>");
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

        $(document).on('click', '#cekPublish_Diet', function() {
            var iddiet = $(this).attr("dataid");
            var stat = $(this).attr("datastat");
            $.ajax({
                type: "POST",
                data: {"iddiet":iddiet,"stat":stat},
                url: "<?php echo base_url().'dietmasakan/statpublish_diet'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    window.location.assign("<?php echo base_url().'dietmasakan/listdiet'; ?>");
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });

        $(document).on('click', '#confirmasiEdit_Diet', function() {
            var iddiet = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                data: {"iddiet":iddiet},
                url: "<?php echo base_url().'dietmasakan/dietdetail'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    var obj = jQuery.parseJSON(resp);
                    $("#iddiet").val(obj.iddiet);
                    $("#namadiet").val(obj.namadiet);
                    $("#urutan").val(obj.urutan);
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    $("#namadiet").focus();
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });

        $(document).on('click', '#confirmasiDelete_Diet', function() {
            var iddiet = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'dietmasakan/konfirmasihapus_diet'; ?>",
                data: {"iddiet":iddiet},
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    $("#modal").modal('show');
                    $("#content_modal").html(resp);
                    $("#loading").html("");
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });

        $(document).on('click', '#hapus_data_Diet', function() {
            var iddiet = $('#iddiet_hapus').val();
            $.ajax({
                type: "POST",
                data: {"iddiet":iddiet,"stat":"delete"},
                url: "<?php echo base_url().'dietmasakan/deletedata_diet'; ?>",
                beforeSend: function(){
                    $("#loading_delete").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        window.location.assign("<?php echo base_url().'dietmasakan/listdiet'; ?>");
                    } else if (resp == 100){
                        $("#modal").modal('hide');
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
    })
</script>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Form Tambah Diet</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <form class="form-horizontal" id="formmodulid" action="" title="" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Diet</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="iddiet" name="iddiet">
                            <input type="text" class="form-control" id="namadiet" name="namadiet" placeholder="Nama Diet">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nomor Urut Diet</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="urutan" name="urutan" placeholder="Nomor Urut Diet">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php if ($add == 1) { ?>
                            <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                            <?php } ?>
                            <a type="button" class="btn btn-danger" href="<?php echo base_url()?>dietmasakan"><i class="fa fa-reply"></i> Kembali</a>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </form>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Daftar Diet</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50" style="text-align: center;">No</th>
                                <th width="150" style="text-align: center;">Nama Diet</th>
                                <th width="80" style="text-align: center;">Urutan</th>
                                <th width="80" style="text-align: center;">Publish</th>
                                <th width="100" style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach($listdiet as $key => $val){
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $val['namadiet']; ?></td>
                                <td style="text-align: center;"><?php echo $val['urutan']; ?></td>
                                <td style="text-align: center;">
                                    <?php if($val['stat'] == 'aktif') { ?>
                                        <button type="button" class="btn btn-xs btn-success" id="cekPublish_Diet" dataid="<?php echo $val['iddiet']; ?>" datastat='tidak' ><i class="fa fa-check-circle"></i></button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-xs btn-danger" id="cekPublish_Diet" dataid="<?php echo $val['iddiet']; ?>" datastat='aktif' ><i class="fa  fa-times-circle"></i></button>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($edit == 1) { ?>
                                    <button type="button" class="btn btn-xs btn-warning" id="confirmasiEdit_Diet" dataid="<?php echo $val['iddiet']; ?>"><i class="fa fa-edit"></i></button>
                                    <?php } ?>
                                    <?php if ($delete == 1) { ?>
                                    <button type="button" class="btn btn-xs btn-danger" id="confirmasiDelete_Diet" dataid="<?php echo $val['iddiet']; ?>"><i class="fa fa-trash"></i></button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                            $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>                    
        </div>
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>