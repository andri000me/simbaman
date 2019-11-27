<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 06:49:19
 * @modify date 2019-09-26 06:49:19
 * @desc [description]
 */


  
$sess_data['url'] = $this->input->server('REQUEST_URI');
$this->session->set_userdata($sess_data);
?>

<script>
$(document).ready(function () {
    $("#tableListData").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true
    });

});

function konfirmasi_hapusmasakan(idmasakan)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'masakanbahan/loadformdelete_masakan'; ?>",
        data: {"idmasakan":idmasakan},
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

function hapus_masakan()
{
    var idmasakan = $('#idmasakan_delete').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'masakanbahan/savedata_masakan'; ?>",
        data: {"idmasakan":idmasakan,"stat":"delete"},
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#hapus_data").attr("disabled",true);
        },
        success: function(resp){
            location.reload();
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tableListData">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="20">No</th>
                                <th style="text-align: center;" width="150">Nama Masakan</th>
                                <th style="text-align: center;">Bahan Masakan</th>
                                <th style="text-align: center;" width="50">Aksi</th>
                                <!-- <th style="text-align: center;" width="50">Publish</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach($masakan as $data){
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data['namamasakan']; ?></td>
                                <td>
                                    <?php
                                    foreach ($masakanbahan as $bahan) {
                                        if ($bahan['idmasakan'] == $data['idmasakan']) {
                                            echo $bahan['namabahan'].' ('.$bahan['kuantitas'].' '.$bahan['satuan'].' - '.$bahan['jenis'].'), ';
                                        }
                                    }
                                    ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($edit == 1) { ?>
                                    <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>masakanbahan/detail_masakanbahan/<?php echo $data['idmasakan']; ?>"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php if ($delete == 1) { ?>
                                        <?php if ($data['jml'] == 0) { $diss = ''; } else { $diss = 'disabled'; }?>
                                            <button type="button" <?php echo $diss;?> class="btn btn-danger btn-xs" id="confirmasiDelete" onclick="javascript:konfirmasi_hapusmasakan('<?php echo $data['idmasakan']; ?>');"><i class="fa fa-trash"></i></button>
                                    <?php } ?>
                                </td>
                                <!-- <td style="text-align: center;">
                                    <?php
                                    // if ($data['stat'] == 'aktif'){
                                    ?>                        
                                        <button type="button" class="btn btn-success btn-xs" id="cekPublish" dataid="<?php echo $data['idmasakan']; ?>" datastat=0><i class="fa fa-check-circle"></i></button>
                                    <?php
                                    // } else if ($data['stat'] == 'tidak aktif') {
                                    ?>
                                        <button type="button" class="btn btn-danger btn-xs" id="cekPublish" dataid="<?php echo $data['idmasakan']; ?>" datastat=1><i class="fa fa-times-circle"></i></button>
                                    <?php
                                    // }
                                    ?>                    
                                </td> -->
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
        <div id="get_kelaspasien"></div>
    </div>
    <div class="box-footer">
        <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
        &nbsp;
        <a type="button" class="btn btn-success" href="<?php echo base_url()?>masakanbahan/bahan" id="tambah_data"><i class="fa fa-file"></i> Lihat Bahan</a>
        <?php if ($add == 1) { ?>
        <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>masakanbahan/loadform_masakan" id="tambah_data"><i class="fa fa-file"></i> Tambah Masakan</a>
        <?php } ?>
    </div><!-- /.box-footer -->                
</div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>