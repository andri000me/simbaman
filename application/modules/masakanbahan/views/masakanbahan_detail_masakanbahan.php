<script type="text/javascript">

function ubahmasakan()
{
    var idmasakan = $('#idmasakan').val();
    var namamasakan = $('#namamasakan').val();

    $.ajax({
        type: "POST",
        data: {"idmasakan":idmasakan,"namamasakan":namamasakan},
        url: "<?php echo base_url().'masakanbahan/savedata_masakan'; ?>",
        beforeSend: function(){
            $("#loading").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#btnubahmasakan").attr("disabled",true);
        },
        success: function(resp){
            var url = "<?php echo base_url()?>"+"masakanbahan/detail_masakanbahan/"+idmasakan;
            window.location.assign(url);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function tambahmasakanbahan()
{
    var idmasakanbahan = $('#idmasakanbahan_x').val();
    var idmasakan = $('#idmasakan_x').val();
    var idbahan = $('#idbahan_x').val();
    var kuantitas = $('#kuantitas_x').val();
    var satuan = $('#satuan_x').val();

    $.ajax({
        type: "POST",
        data: {"idmasakanbahan":idmasakanbahan,"idmasakan":idmasakan,"idbahan":idbahan,"kuantitas":kuantitas,"satuan":satuan},
        url: "<?php echo base_url().'masakanbahan/savedata_masakanbahan'; ?>",
        beforeSend: function(){
            $("#loading").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#btnmasakanbahan").attr("disabled",true);
        },
        success: function(resp){
            var url = "<?php echo base_url()?>"+"masakanbahan/detail_masakanbahan/"+idmasakan;
            window.location.assign(url);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function ubahmasakanbahan()
{
    var idmasakanbahan = $('#idmasakanbahan_y').val();
    var idmasakan = $('#idmasakan_y').val();
    var idbahan = $('#idbahan_y').val();
    var kuantitas = $('#kuantitas_y').val();
    var satuan = $('#satuan_y').val();

    $.ajax({
        type: "POST",
        data: {"idmasakanbahan":idmasakanbahan,"idmasakan":idmasakan,"idbahan":idbahan,"kuantitas":kuantitas,"satuan":satuan},
        url: "<?php echo base_url().'masakanbahan/savedata_masakanbahan'; ?>",
        beforeSend: function(){
            $("#loading").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#btnubahmasakanbahan").attr("disabled",true);
        },
        success: function(resp){
            var url = "<?php echo base_url()?>"+"masakanbahan/detail_masakanbahan/"+idmasakan;
            window.location.assign(url);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function form_ubahmasakan(idmasakan) 
{
    $.ajax({
        type: "POST",
        data: {"idmasakan":idmasakan},
        url: "<?php echo base_url().'masakanbahan/form_ubahmasakan'; ?>",
        beforeSend: function(){
            $("#loading").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#loading").html('');
            $("#modal").modal('show');
            $("#content_modal").html(resp);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function form_ubahmasakanbahan(idmasakanbahan)
{
    $.ajax({
        type: "POST",
        data: {"idmasakanbahan":idmasakanbahan},
        url: "<?php echo base_url().'masakanbahan/form_ubahmasakanbahan'; ?>",
        beforeSend: function(){
            $("#loading").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#loading").html('');
            $("#modal").modal('show');
            $("#content_modal").html(resp);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function konfirmasi_hapusmasakanbahan(idmasakanbahan)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'masakanbahan/loadformdelete_masakanbahan'; ?>",
        data: {"idmasakanbahan":idmasakanbahan},
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
};

function hapus_masakanbahan()
{
    var idmasakanbahan = $('#idmasakanbahan_delete').val();
    var idmasakan = $('#idmasakan_delete').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'masakanbahan/savedata_masakanbahan'; ?>",
        data: {"idmasakanbahan":idmasakanbahan,"idmasakan":idmasakan,"stat":"delete"},
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#hapus_data").attr("disabled",true);
        },
        success: function(resp){
            var url = "<?php echo base_url()?>"+"masakanbahan/detail_masakanbahan/"+idmasakan;
            window.location.assign(url);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

</script>

<section class="content">
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">From Tambah Bahan pada Masakan</h3>
        <span class="pull-right">
            <span id="loading"></span>
        </span>
    </div>
    
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <form class="form-horizontal" id="formoid_bahanmasakan" action="" title="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Bahan</label>
                        <div class="col-sm-5">
                            <input type="hidden" class="form-control" id="idmasakan_x" name="idmasakan_x" value="<?php echo $masakan[0]['idmasakan'];?>">
                            <input type="hidden" class="form-control" id="idmasakanbahan_x" name="idmasakanbahan_x" value="">
                            <select class="form-control" name="idbahan_x" id="idbahan_x">
                                <option value="">-- Pilih Bahan</option>
                                <?php
                                foreach ($bahan as $dt) {
                                ?>
                                <option value="<?php echo $dt['idbahan'];?>"><?php echo $dt['namabahan'];?> | <?php echo $dt['satuan'];?> | <?php echo $dt['jenis'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <a type="button" class="btn btn-info" href="<?php echo base_url()?>bahan/loadform" id=""><i class="fa fa-list"></i> Tambah Bahan</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Kuantitas</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="kuantitas_x" name="kuantitas_x" value="" placholder="Kuantitas">                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Satuan</label>
                        <div class="col-sm-2">
                            <select class="form-control" name="satuan_x" id="satuan_x">
                                <option value="">-- Pilih Satuan</option>
                                <?php
                                foreach ($satuanbahan as $sat) {
                                ?>
                                    <option value="<?php echo $sat['satuan'];?>"><?php echo $sat['satuan'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" id="btnmasakanbahan" name="btnmasakanbahan" onclick="javascript:tambahmasakanbahan();">Tambah Bahan</button>
                            <a type="button" class="btn btn-danger" href="<?php echo base_url()?>masakanbahan"><i class="fa fa-reply"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>            
        </div>        
    </div>
    <!-- <div class="box-footer"> -->
                
    <!-- </div>/.box-footer                 -->
</div><!-- /.box -->	
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Masakan : <?php echo $masakan[0]['namamasakan'];?></h3>
        <span class="pull-right">
            <button type="button" class="btn btn-info" onclick="javascript:form_ubahmasakan('<?php echo $masakan[0]['idmasakan'];?>');">Ubah Masakan</button>
        </span>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">                    
                    <tr>
                        <td>Nama Bahan</td>
                        <td colspan=2>
                            <table class="table table-bordered">
                            <?php
                            foreach ($masakanbahan as $data) {
                            ?>
                                <tr>
                                    <td><?php echo $data['namabahan'];?></td>
                                    <td width="20%"><?php echo $data['kuantitas'];?></td>
                                    <td width="10%"><?php echo $data['satuan'];?></td>
                                    <td width="20%"><?php echo $data['jenis'];?></td>
                                    <td width="10%">
                                        <button type="button" class="btn btn-warning btn-xs" onclick="javascript:form_ubahmasakanbahan('<?php echo $data['idmasakanbahan'];?>')"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="javascript:konfirmasi_hapusmasakanbahan('<?php echo $data['idmasakanbahan'];?>')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>                
        </div>
    </div>
</div>
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>