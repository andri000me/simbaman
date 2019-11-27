<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 20:50:15
 * @modify date 2019-09-26 20:50:15
 * @desc [description]
 */

 ?>

<?php  
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

function konfirmasi_hapussupplier(idsupplier)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'supplier/konfirmasi_hapussupplier'; ?>",
        data: {"idsupplier":idsupplier},
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

function hapus_supplier()
{
    var idsupplier = $('#idsupplier_delete').val();
    $.ajax({
        type: "POST",
        data: {"idsupplier":idsupplier,"stat":"delete"},
        url: "<?php echo base_url().'supplier/savedata_supplier'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#hapus_data").attr("disabled",true);
        },
        success: function(resp){
            window.location.assign("<?php echo base_url().'supplier'; ?>");
        },
        error: function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tableListData">
                    <thead>
                        <tr>
                            <th style="text-align: center;" width="20">No</th>
                            <th style="text-align: center;" width="50">Detail</th>
                            <th style="text-align: center;">Nama Supplier</th>
                            <th style="text-align: center;" width="100">Tanggal Awal</th>
                            <th style="text-align: center;" width="100">Tanggal Akhir</th>
                            <th style="text-align: center;" width="100">Status</th>
                            <th style="text-align: center;" width="50">Aksi</th>
                            <!-- <th style="text-align: center;" width="50">Publish</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach($supplier as $data){
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td>
                                <a href="<?php echo base_url()?>supplier/detailbahan/<?php echo $data['idsupplier']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-list-alt"></i> Detail Bahan</a>
                            </td>
                            <td><?php echo $data['namasupplier']; ?></td>
                            <td><?php echo $data['kontraktanggalawal']; ?></td>
                            <td><?php echo $data['kontraktanggalakhir']; ?></td>
                            <td><?php echo $data['stat']; ?></td>
                            <td style="text-align: center;">
                                <?php if ($edit == 1) { ?>
                                <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>supplier/loadform/<?php echo $data['idsupplier']; ?>"><i class="fa fa-edit"></i></a>
                                <?php } ?>
                                <?php if ($delete == 1) { ?>  
                                    <?php if ($data['jml'] <= 1) { $diss = ''; } else { $diss = 'disabled'; } ?>
                                <button type="button" <?php echo $diss;?> class="btn btn-danger btn-xs" id="confirmasiDelete" onclick="javascript:konfirmasi_hapussupplier('<?php echo $data['idsupplier']; ?>');"><i class="fa fa-trash"></i></button>
                                <?php } ?>
                            </td>
                            <!-- <td style="text-align: center;">
                                <?php
                                // if ($data['stat'] == 'aktif'){
                                ?>                        
                                    <button type="button" class="btn btn-success btn-xs" id="cekPublish" dataid="<?php //echo $data['idsupplier']; ?>" datastat=0><i class="fa fa-check-circle"></i></button>
                                <?php
                                // } else if ($data['stat'] == 'tidak aktif') {
                                ?>
                                    <button type="button" class="btn btn-danger btn-xs" id="cekPublish" dataid="<?php //echo $data['idsupplier']; ?>" datastat=1><i class="fa fa-times-circle"></i></button>
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
        <div class="box-footer">
            <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
            <?php if ($add == 1) { ?>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>supplier/loadform" id="tambah_data"><i class="fa fa-file"></i> Tambah Data</a>
            <?php } ?>
        </div><!-- /.box-footer -->                
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>