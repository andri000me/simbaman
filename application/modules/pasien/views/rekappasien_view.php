<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-13 07:29:03
 * @modify date 2019-09-14 07:21:38
 * @desc [description]
 */

?>
<script>
$(document).ready(function () {
    $(".datepicker-input").each(function(){ $(this).datepicker();});

    pilihTanggalRekap();
});

function pilihTanggalRekap()
{
    var tglrekap = $('#tglrekap').val();
    $.ajax({
        type: "POST",
        data: {"tglrekap":tglrekap},
        url: "<?php echo base_url().'pasien/tanggalrekappasien'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#tanggalrekappasien").html(resp);
            $("#loading").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function form_ubahjumlahpasien(idjumlahpasien)
{
    $.ajax({
        type: "POST",
        data: {"idjumlahpasien":idjumlahpasien},
        url: "<?php echo base_url().'pasien/form_ubahjumlahpasien'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal_default").modal('show');
            $("#content_modal_default").html(resp);
            $("#loading").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function ubahjumlahpasien()
{
    var idrekapjumlahpasien = $('#idrekapjumlahpasien').val();
    var tanggalrekap = $('#tanggalrekap').val();
    var jumlahpasien = $('#jumlahpasien').val();

    $.ajax({
        type: "POST",
        data: {"idrekapjumlahpasien":idrekapjumlahpasien,"jumlahpasien":jumlahpasien},
        url: "<?php echo base_url().'pasien/ubahjumlahpasien'; ?>",
        beforeSend: function(){
            $("#loading_ubahjumlahpasien").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal_default").modal('hide');
            TanggalRekap(tanggalrekap);
            $("#loading_ubahjumlahpasien").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function TanggalRekap(tglrekap)
{
    $.ajax({
        type: "POST",
        data: {"tglrekap":tglrekap},
        url: "<?php echo base_url().'pasien/tanggalrekappasien'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#tanggalrekappasien").html(resp);
            $("#loading").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function importdata(tglrekap) {
    $.ajax({
        type: "POST",
        data: {"tglrekap":tglrekap},
        url: "<?php echo base_url().'pasien/importdata'; ?>",
        beforeSend: function(){
            $("#loading_import").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#btn_importdata_tmp").attr("disabled","true");
        },
        success: function(resp){
            $("#loading_import").html("");
            $("#btn_importdata_tmp").removeAttr("disabled");
            pilihTanggalRekap();
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
            <h3 class="box-title">Data</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        
        <div class="box-body">
            <div class="row" style="margin-bottom:10px">
                <div class="col-lg-12">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Rekap</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control datepicker-input" placeholder="Pilih Tanggal Rekap" data-date-format="yyyy-mm-dd" id="tglrekap" value="<?php echo $tanggalsekarang;?>">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" onclick="javascript:pilihTanggalRekap();">Pilih Tanggal</button>
                                <!-- <a href="<?php //echo base_url()?>pasien/kalender" target="_blank" class="btn btn-success">Lihat Rekap Pasien</a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="box-footer"> -->
            <!-- <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button> -->
            <?php //if ($add == 1) { ?>
            <!-- <a type="button" class="btn btn-danger pull-right" href="<?php //echo base_url()?>pasien/loadform" id="tambah_data"><i class="fa fa-file"></i> Tambah Data</a> -->
            <?php //} ?>
        <!-- </div>/.box-footer                 -->
    </div><!-- /.box -->	

    <div id="tanggalrekappasien"></div>
    
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>

<div id="modal_default" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog" id="content_modal_default">  	
    </div>
</div>