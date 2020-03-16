<?php  
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>

<script>

function pilihDietPasien()
{
    var iddiet = $('#iddiet').val();
    if (iddiet == 'kosong') {
        alert('Pilih salah satu macam Diet yang tersedia');
    } else {
        $.ajax({
            type: "POST",
            data: {"iddiet":iddiet},
            url: "<?php echo base_url().'dietmasakan/getdietpasien'; ?>",
            beforeSend: function(){
                $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp){
                $("#get_dietpasien").html(resp);
                $("#loading").html("");
            },
            error:function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    }
};

</script>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Pengaturan Diet</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Diet</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="iddiet" id="iddiet">
                                    <option value="kosong">-- Pilih Diet</option>
                                    <?php
                                        foreach ($dietpasien  as $diet) {
                                            ?>
                                            <option value="<?php echo $diet['iddiet'];?>"><?php echo $diet['namadiet'];?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" onclick="javascript:pilihDietPasien();">Pilih Diet</button>
                            </div>
                        </div>
                    </form>
                </div>                
            </div>            
        </div>
        <!-- <div class="box-footer"> -->
            <?php //if ($add == 1) { ?>
            <!-- <a type="button" class="btn btn-danger pull-right" href="<?php //echo base_url()?>menumasakan/loadform" id="tambah_data"><i class="fa fa-file"></i> Tambah Data</a> -->
            <?php //} ?>
        <!-- </div>/.box-footer                 -->
    </div><!-- /.box -->	

    <div id="get_dietpasien"></div>
    
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>