<?php    
    $sess_data['url'] = $this->input->server('REQUEST_URI');    
    $this->session->set_userdata($sess_data);
?>

<script>
$(document).ready(function () {
    $(".datepicker-input").each(function(){ $(this).datepicker();});

    $("#frm_upload").submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            data: formData,
            async: false,
            url: "<?php echo base_url().'pasien/uploadfile'; ?>",   
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $("#btnImport").attr("disabled","true");
                $("#loadinguploadfile").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                $("#kontenpesertaimport").html(resp);
                $("#loadinguploadfile").html("&nbsp;");
                $("#btnImport").removeAttr("disabled");
            },
            error: function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    });

    $("#frm_upload_json").submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            data: formData,
            async: false,
            url: "<?php echo base_url().'pasien/uploadfile_json'; ?>",   
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $("#btnImportjson").attr("disabled","true");
                $("#loadinguploadfilejson").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                $("#kontenpesertaimport").html(resp);
                $("#loadinguploadfilejson").html("&nbsp;");
                $("#btnImportjson").removeAttr("disabled");
            },
            error: function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    });
});

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

            var url = "<?php echo base_url()?>"+"rekappasien";

            //window.open(url);
            window.location.assign(url);
            $("#btn_importdata_tmp").removeAttr("disabled");
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
            <h3 class="box-title">Form</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal" name="frm_upload" id="frm_upload" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Tanggal Rekap Pasien</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datepicker-input" placeholder="Pilih Tanggal Rekap" data-date-format="yyyy-mm-dd" id="tglrekap" name="tglrekap">
                            </div>
                            <div class="col-sm-7">
                                <a href="<?php echo base_url()?>pasien/file_excel_default" class="btn btn-link">Format Default Upload Data Rekap Pasien</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">File Excel</label>
                            <div class="col-sm-5">
                                <input type="file" class="form-control" id="InputFile" name="InputFile">
                                <small id="loadinguploadfile" class="form-text text-muted">&nbsp;</small>
                            </div>                                    
                        </div>
                        <div class="form-group">                   
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" id="btnImport" class="btn btn-info"><i class="fa fa-file-text"></i> Preview Excel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal" name="frm_upload_json" id="frm_upload_json" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">File Json</label>
                            <div class="col-sm-5">
                                <input type="file" class="form-control" id="InputFileJson" name="InputFileJson">
                                <small id="loadinguploadfilejson" class="form-text text-muted">&nbsp;</small>
                            </div>                                    
                        </div>
                        <div class="form-group">                   
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" id="btnImportjson" class="btn btn-info"><i class="fa fa-file-text"></i> Preview Json</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div id="kontenpesertaimport"></div>
                </div>
            </div>            
        </div>
        <div class="box-footer">
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>rekappasien"><i class="fa fa-reply"></i> Kembali</a>
        </div><!-- /.box-footer -->
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>