<?php  
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>

<script>

function pilihKelasPasien()
{
    var idkelas = $('#idkelas').val();
    $.ajax({
        type: "POST",
        data: {"idkelas":idkelas},
        url: "<?php echo base_url().'menumasakan/getkelaspasien'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
        },
        success: function(resp){
            $("#get_kelaspasien").html(resp);
            $("#loading").html("");
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
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kelas</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="idkelas" id="idkelas">
                                    <option value="-">-- Pilih Kelas</option>
                                    <?php
                                        foreach ($kelaspasien  as $kelas) {
                                            ?>
                                            <option value="<?php echo $kelas['idkelas'];?>"><?php echo $kelas['namakelas'];?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" onclick="javascript:pilihKelasPasien();">Pilih Kelas Pasien</button>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>
            <div id="get_kelaspasien"></div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
            <?php if ($add == 1) { ?>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>menumasakan/ref_menumasakan" id="tambah_data"><i class="fa fa-file"></i> Referensi Menu Masakan</a>
            <?php } ?>
        </div><!-- /.box-footer -->                
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>