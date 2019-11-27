<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-10-06 10:40:34
 * @modify date 2019-10-06 10:40:34
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
        url: "<?php echo base_url().'pengecekanbahan/tanggalrekappasien'; ?>",
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
        url: "<?php echo base_url().'pengecekanbahan/detailmenumasakan'; ?>",
        beforeSend: function(){
            $("#loading_detailmeunamsakan").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal").modal('show');
            $("#content_modal").html(resp);
            $("#loading_detailmeunamsakan").html("");
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function cek_pengajuan(idpengajuan,idbahansupplier,pengajuan)
{
    $.ajax({
        type: "POST",
        data: {"idpengajuan":idpengajuan,"idbahansupplier":idbahansupplier,"pengajuan":pengajuan},
        url: "<?php echo base_url().'pengecekanbahan/cek_pengajuan'; ?>",
        beforeSend: function(){
            $("#kebutuhan_realisasi_"+idbahansupplier).html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#harga_realisasi_"+idbahansupplier).html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $(".cek_pengajuan_"+idbahansupplier).attr("disabled",true);
        },
        success: function(resp){
            if (pengajuan == 'tidak_sesuai') {
                $("#modal").modal('show');
                $("#content_modal").html(resp);
                $(".cek_pengajuan_"+idbahansupplier).attr("disabled",false);
                $("#kebutuhan_realisasi_"+idbahansupplier).html("");
                $("#harga_realisasi_"+idbahansupplier).html("");
            } else if (pengajuan == 'kembali') {
                $("#kebutuhan_realisasi_"+idbahansupplier).html("");
                $("#harga_realisasi_"+idbahansupplier).html("");
            } else {
                //alert(resp);
                var obj = jQuery.parseJSON(resp);
                $("#button_hide_"+idbahansupplier).html("");
                $("#kebutuhan_realisasi_"+idbahansupplier).html(obj.jumlahkuantitasreal);
                $("#harga_realisasi_"+idbahansupplier).html(obj.hargatotalreal);
            }
            
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function simpanpengajuanbahancek()
{
    var idpengajuan = $('#idpengajuan').val();
    var idbahansupplier = $('#idbahansupplier').val();
    var jumlahkuantitasreal = $('#jumlahkuantitasreal').val();
    var hargatotalreal = $('#hargatotalreal').val();
    var pengajuan = $('#pengajuan').val();

    $.ajax({
        type: "POST",
        data: {"pengajuan":pengajuan,"idpengajuan":idpengajuan,"idbahansupplier":idbahansupplier,"jumlahkuantitasreal":jumlahkuantitasreal,"hargatotalreal":hargatotalreal},
        url: "<?php echo base_url().'pengecekanbahan/simpanpengajuanbahancek'; ?>",
        beforeSend: function(){
            $("#loading_simpanpengajuanbahancek").html("<img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#modal").modal('hide');
            var obj = jQuery.parseJSON(resp);
            $("#button_hide_"+idbahansupplier).html("<button type='button' class='btn btn-xs btn-warning'><i class='fa fa-retweet'></i></button>");
            $("#kebutuhan_realisasi_"+idbahansupplier).html("<font color='red'>"+obj.jumlahkuantitasreal+"</font>");
            $("#harga_realisasi_"+idbahansupplier).html("<font color='red'>"+obj.hargatotalreal+"</font>");
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