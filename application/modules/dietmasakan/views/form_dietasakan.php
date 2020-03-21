<script type="text/javascript">

    $(document).ready(function () {
        $("#formoid").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: "<?php echo base_url().'dietmasakan/savedata_dietmasakan'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    $("#submitButton").attr("disabled",true);
                },
                success: function(resp){
                    window.location.assign("<?php echo base_url().'dietmasakan/loadform_dietmasakan/'.$iddiet;?>");
                },
                error: function(event, textStatus, errorThrown) {
                    alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });

    });

function get_bahanmasakan()
{
    var idmasakan = $('#idmasakan').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'dietmasakan/get_bahanmasakan'; ?>",
        data: {"idmasakan":idmasakan},
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#loading").html("");
            var obj = jQuery.parseJSON(resp);
                if(obj){
                    $.each(obj, function(key, value){
                        $("#idbahan").append($("<option></option>")
                                        .attr("value",value.idbahan)
                                        .text(value.namabahan+' | '+value.kuantitas+' | '+value.satuan)); 
                    });                   
                }
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function form_ubahdietmasakan(iddietmasakanbahan)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'dietmasakan/form_ubahdietmasakan'; ?>",
        data: {"iddietmasakanbahan":iddietmasakanbahan},
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

function ubah_dietmasakan()
{
    var iddietmasakanbahan_ubah = $('#iddietmasakanbahan_ubah').val();
    var pengurangan_ubah = $('#pengurangan_ubah').val();
    var satuan_ubah = $('#satuan_ubah').val();
    var penambahan_ubah = $('#penambahan_ubah').val();
    var satuan_tambah_ubah = $('#satuan_tambah_ubah').val();
    var iddiet_ubah = $('#iddiet_ubah').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'dietmasakan/savedata_dietmasakan_ubah'; ?>",
        data: {"iddietmasakanbahan_ubah":iddietmasakanbahan_ubah,"pengurangan_ubah":pengurangan_ubah,"satuan_ubah":satuan_ubah,"penambahan_ubah":penambahan_ubah,"satuan_tambah_ubah":satuan_tambah_ubah},
        beforeSend: function(){
            $("#loading_ubah").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#ubah_data").attr("disabled",true);
        },
        success: function(resp){
            var url = "<?php echo base_url()?>"+"dietmasakan/loadform_dietmasakan/"+iddiet_ubah;
            window.location.assign(url);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function konfirmasi_hapusdietmasakan(iddietmasakanbahan)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'dietmasakan/form_hapusdietmasakan'; ?>",
        data: {"iddietmasakanbahan":iddietmasakanbahan},
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

function hapus_dietmasakan()
{
    var iddiet = $('#iddiet_delete').val();
    var iddietmasakanbahan = $('#iddietmasakanbahan_delete').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'dietmasakan/savedata_dietmasakan'; ?>",
        data: {"iddietmasakanbahan":iddietmasakanbahan,"stat":"delete"},
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#hapus_data").attr("disabled",true);
        },
        success: function(resp){
            var url = "<?php echo base_url()?>"+"dietmasakan/loadform_dietmasakan/"+iddiet;
            window.location.assign(url);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

</script>
<?php    
    $sess_data['url'] = $this->input->server('REQUEST_URI');    
    $this->session->set_userdata($sess_data);
?>

<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Form Penambahan dan Pengurangan Bahan Masakan</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal" id="formoid" action="" title="" method="post">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Diet</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="iddietmasakanbahan" name="iddietmasakanbahan" value="">
                                <select class="form-control" name="iddiet" id="iddiet" readonly>
                                    <option value="">-- Pilih Diet</option>
                                    <?php
                                    foreach ($dietpasien as $diet) {
                                    ?>
                                        <option value="<?php echo $diet['iddiet'];?>" <?php if ($diet['iddiet'] == $iddiet) { echo 'selected';}?>><?php echo $diet['namadiet'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Masakan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="idmasakan" id="idmasakan" onchange="javascript:get_bahanmasakan();">
                                    <option value="">-- Pilih Masakan</option>
                                    <?php
                                    foreach ($masakan as $msk) {
                                    ?>
                                        <option value="<?php echo $msk['idmasakan'];?>"><?php echo $msk['namamasakan'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Bahan Masakan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="idbahan" id="idbahan">
                                    <option value="">-- Pilih Bahan Masakan</option>                                    
                                </select>
                            </div>
                        </div>   
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Pengurangan</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Pungurangan" class="form-control" id="pengurangan" name="pengurangan">
                            </div>
                            <label for="" class="col-sm-2 control-label">Satuan</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="satuan" id="satuan">
                                    <option value="">-- Pilih Satuan</option>
                                    <?php
                                    foreach ($satuan as $sat) {
                                    ?>
                                        <option value="<?php echo $sat['satuan'];?>"><?php echo $sat['satuan'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Penambahan</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Penambahan" class="form-control" id="penambahan" name="penambahan">
                            </div>
                            <label for="" class="col-sm-2 control-label">Satuan</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="satuan_tambah" id="satuan_tambah">
                                    <option value="">-- Pilih Satuan</option>
                                    <?php
                                    foreach ($satuan as $sat) {
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
                                <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                                <a type="button" class="btn btn-danger" href="<?php echo base_url()?>dietmasakan"><i class="fa fa-reply"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="box-footer"> -->
            
        <!-- </div>/.box-footer -->
    </div>

    <?php
    if (count($dietmasakan) != 0) {
    ?>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Diet : <?php echo $namadiet[0]['namadiet'];?></h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">        
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%" style="text-align: center;">Masakan</th>
                            <th style="text-align: center;">Bahan Masakan</th>
                        </tr>
                        <?php
                        foreach ($dietmasakan as $dt) {
                        ?>
                        <tr>
                            <td><?php echo $dt['namamasakan'];?> </td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="text-align: center;">Nama Bahan</th>
                                        <th width="15%" style="text-align: center;">Kuantitas</th>
                                        <th width="15%" style="text-align: center;">Pengurangan</th>
                                        <th width="15%" style="text-align: center;">Penambahan</th>
                                        <th width="15%" style="text-align: center;">Aksi</th>
                                    </tr>
                                    <?php
                                    foreach ($dietmasakanbahan as $bahan) {
                                        if ($bahan['idmasakan'] == $dt['idmasakan']) {
                                    ?>
                                    <tr>
                                        <td><?php echo $bahan['namabahan'];?> | <?php echo $bahan['jenis'];?> | <?php echo $bahan['satuan'];?></td>
                                        <td style="text-align: right;"><?php echo $bahan['kuantitas'];?> <?php echo $bahan['satuan_kauntitas'];?></td>
                                        <td style="text-align: right;"><?php echo $bahan['pengurangan'];?> <?php echo $bahan['satuan_pengurangan'];?></td>
                                        <td style="text-align: right;"><?php echo $bahan['penambahan'];?> <?php echo $bahan['satuan_tambah'];?></td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-warning btn-xs" onclick="javascript:form_ubahdietmasakan('<?php echo $bahan['iddietmasakanbahan'];?>');"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="javascript:konfirmasi_hapusdietmasakan('<?php echo $bahan['iddietmasakanbahan'];?>');"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                       }
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>            
        </div>
    </div>
    <?php
    } else {
        echo '';
    }
    ?>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>