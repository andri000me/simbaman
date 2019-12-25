<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-21 13:12:34
 * @modify date 2019-09-21 13:12:34
 * @desc [description]
 */
$sess_data['url'] = $this->input->server('REQUEST_URI');
$this->session->set_userdata($sess_data);
 ?>

<script>
$(document).ready(function () {
    $(".datepicker-input").each(function(){ $(this).datepicker();});

    pilihTanggalPengajuanBahan();
    
});

function pilihTanggalPengajuanBahan()
{
    var tglpengajuanbahan = $('#tglpengajuanbahan').val();
    $.ajax({
        type: "POST",
        data: {"tglpengajuanbahan":tglpengajuanbahan},
        url: "<?php echo base_url().'pengajuanbahan/tanggalrekappasien'; ?>",
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

function detailMenumasakan(idjenismenu)
{
    $.ajax({
        type: "POST",
        data: {"idjenismenu":idjenismenu},
        url: "<?php echo base_url().'pengajuanbahan/detailmenumasakan'; ?>",
        beforeSend: function(){
            $("#loading_detailmeunamsakan_"+idjenismenu).html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal").modal('show');
            $("#content_modal").html(resp);
            $("#loading_detailmeunamsakan_"+idjenismenu).html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function generatePengajuanBahan_semua(tanggalrekappasien,tanggalpengajuan) 
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'pengajuanbahan/generatepengajuanbahan_semua'; ?>",
        data: {"tanggalrekappasien":tanggalrekappasien,"tanggalpengajuan":tanggalpengajuan},
        beforeSend: function(){
            $("#loading_generate").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $(".generatepengajuanbahan").attr("disabled",true);
        },
        success: function(resp){
            pilihTanggalPengajuanBahan();
            $("#loading_generate").html("");
            $(".generatepengajuanbahan").attr("disabled",false);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function generatePengajuanBahan(tanggalrekappasien,idjenismenu,tanggalpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"tanggalrekappasien":tanggalrekappasien,"idjenismenu":idjenismenu,"tanggalpengajuan":tanggalpengajuan},
        url: "<?php echo base_url().'pengajuanbahan/generatepengajuanbahan'; ?>",
        beforeSend: function(){
            $("#loading_generate").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $(".generatepengajuanbahan").attr("disabled",true);
        },
        success: function(resp){
            pilihTanggalPengajuanBahan();
            $("#loading_generate").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function resetPengajuanBahan(idpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"idpengajuan":idpengajuan},
        url: "<?php echo base_url().'pengajuanbahan/resetpengajuanbahan'; ?>",
        beforeSend: function(){
            $("#loading_reset").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $(".resetpengajuanbahan").attr("disabled",true);
        },
        success: function(resp){
            pilihTanggalPengajuanBahan();
            $("#loading_reset").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function cetakbahanmasakanpengajuan()
{
    var idpengajuan = $('#idpengajuan_fix').val();
    var idkelas = $('#idkelas_fix').val();
    var idwaktumenu = $('#idwaktumenu_fix').val();
    var url = "<?php echo base_url()?>"+"pengajuanbahan/cetakpengajuan?idpengajuan="+idpengajuan+"&idkelas="+idkelas+"&idwaktumenu="+idwaktumenu;

    window.open(url);
};

function form_pengajuandiet(idpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"idpengajuan":idpengajuan},
        url: "<?php echo base_url().'pengajuanbahan/form_pengajuandiet'; ?>",
        beforeSend: function(){
            $("#loading_pengajuandiet").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal_default").modal('show');
            $("#content_modal_default").html(resp);
            $("#loading_pengajuandiet").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function detail_pengajuandiet(idpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"idpengajuan":idpengajuan},
        url: "<?php echo base_url().'pengajuanbahan/detail_pengajuandiet'; ?>",
        beforeSend: function(){
            $("#loading_detail_pengajuandiet").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal").modal('show');
            $("#content_modal").html(resp);
            $("#loading_detail_pengajuandiet").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function hapus_bahandiet(idpengajuanbahandietdetail,idpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"idpengajuanbahandietdetail":idpengajuanbahandietdetail,"stat":"delete"},
        url: "<?php echo base_url().'pengajuanbahan/hapus_bahandiet'; ?>",
        beforeSend: function(){
            $("#loading_hapusbahandiet").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#delete_"+idpengajuanbahandietdetail).attr("disabled",true);
        },
        success: function(resp){
            detail_pengajuandiet(idpengajuan);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}; 

function ubah_bahandiet(idpengajuanbahandietdetail)
{
    $.ajax({
        type: "POST",
        data: {"idpengajuanbahandietdetail":idpengajuanbahandietdetail},
        url: "<?php echo base_url().'pengajuanbahan/form_ubah_pengajuandiet'; ?>",
        beforeSend: function(){
            $("#loading_hapusbahandiet").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal").modal('hide');
            $("#modal_default").modal('show');
            $("#content_modal_default").html(resp);
            $("#loading_hapusbahandiet").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function get_bangsal(tanggalrekap)
{
    var idkelas = $('#idkelas').val();
    $.ajax({
            type: "POST",
            url: "<?=site_url('pengajuanbahan/get_bangsal_pengajuan'); ?>",
            data: {"tanggalrekap":tanggalrekap,"idkelas":idkelas},
            beforeSend: function() {
                $("#idbangsal").find('option').remove().end();
                $("#idbangsal").append($("<option></option>")
                                    .attr("value","")
                                    .text("-- Pilih Bangsal"));
            },
            success: function(resp){
                var obj = jQuery.parseJSON(resp);
                if(obj){
                    $.each(obj, function(key, value){
                        $("#idbangsal").append($("<option></option>")
                                        .attr("value",value.idbangsal)
                                        .text(value.kodebangsal+' '+value.namabangsal+' ('+value.jumlahpasien+')')); 
                    });                   
                }
                $("#idbangsal").val('');
   
            },
            error:function(event, textStatus, errorThrown) {
                //messagebox('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown,'Informasi','error');
            }
        });
}

function form_pengajuandiet_sat(tanggalpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"tanggalpengajuan":tanggalpengajuan},
        url: "<?php echo base_url().'pengajuanbahan/form_pengajuandiet_sat'; ?>",
        beforeSend: function(){
            $("#loading_pengajuandiet").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal_default").modal('show');
            $("#content_modal_default").html(resp);
            $("#loading_pengajuandiet").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function detail_pengajuandiet_sat(tanggalpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"tanggalpengajuan":tanggalpengajuan},
        url: "<?php echo base_url().'pengajuanbahan/detail_pengajuandiet_sat'; ?>",
        beforeSend: function(){
            $("#loading_detail_pengajuandiet").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal").modal('show');
            $("#content_modal").html(resp);
            $("#loading_detail_pengajuandiet").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

</script>

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
                            <label class="col-sm-3 control-label">Tanggal Pengajuan Bahan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control datepicker-input" placeholder="Pilih Tanggal Pengajuan Bahan" data-date-format="yyyy-mm-dd" id="tglpengajuanbahan" value="<?php echo $tanggalsekarang;?>">
                            </div>       
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" onclick="javascript:pilihTanggalPengajuanBahan();">Pilih Tanggal</button>
                            </div>                     
                        </div>
                    </form>
                </div>
            </div>

            <div id="tanggalrekappasien"></div>

        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
            <!-- <?php if ($add == 1) { ?>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>menumasakan/loadform" id="tambah_data"><i class="fa fa-file"></i> Tambah Data</a>
            <?php } ?> -->
        </div><!-- /.box-footer -->                
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>

<div id="modal_default" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog" id="content_modal_default">  	
    </div>
</div>
