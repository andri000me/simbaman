<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 21:34:41
 * @modify date 2019-09-26 21:34:41
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

function loadform_bahansupplier(idsupplier)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'supplier/loadform_bahansupplier'; ?>",
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

function copysupplier()
{
    var idsupplier = $('#idsupplier').val();
    var idsupplier_copy = $('#idsupplier_copy').val();
    $.ajax({
        type: "POST",
        data: {"idsupplier":idsupplier,"idsupplier_copy":idsupplier_copy},
        url: "<?php echo base_url().'supplier/copy_supplier'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#btncopysupplier").attr("disabled",true);
        },
        success: function(resp){
            window.location.assign("<?php echo base_url().'supplier/detailbahan/'; ?>"+idsupplier);
        },
        error: function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function konfirmasi_hapusbahansupplier(idsupplier)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'supplier/konfirmasi_hapusbahansupplier'; ?>",
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

function hapus_bahansupplier()
{
    var idsupplier = $('#idsupplier_delete').val();
    $.ajax({
        type: "POST",
        data: {"idsupplier":idsupplier},
        url: "<?php echo base_url().'supplier/hapussemua_bahansupplier'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#hapus_data").attr("disabled",true);
        },
        success: function(resp){
            window.location.assign("<?php echo base_url().'supplier/detailbahan/'; ?>"+idsupplier);
        },
        error: function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
};

function konfirmasi_hapusbahansupplier_manual(idbahansupplier)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'supplier/konfirmasi_hapusbahansupplier_manual'; ?>",
        data: {"idbahansupplier":idbahansupplier},
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

function  hapus_bahansupplier_manual() 
{
    var idbahansupplier = $('#idbahansupplier_delete').val();
    var idsupplier = $('#idsupplier_delete').val();
    $.ajax({
        type: "POST",
        data: {"idbahansupplier":idbahansupplier,"stat":"delete"},
        url: "<?php echo base_url().'supplier/savedata_bahansupplier'; ?>",
        beforeSend: function(){
            $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            $("#hapus_data").attr("disabled",true);
        },
        success: function(resp){
            window.location.assign("<?php echo base_url().'supplier/detailbahan/'; ?>"+idsupplier);
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
            <h3 class="box-title">Data Bahan Supplier</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        
        <div class="box-body">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <div class="pull pull-right">
                        <a type="button" class="btn btn-danger" href="<?php echo base_url()?>supplier"><i class="fa fa-reply"></i> Kembali</a>
                            <?php if ($add == 1) { ?>
                            <?php
                            $jml_bahansupplier = count($bahansupplier);
                            if ($jml_bahansupplier == 0) {
                                $diss_tambah = '';
                                $diss_hapus = 'disabled';
                            } else {
                                $diss_tambah = 'disabled';
                                $diss_hapus = '';
                            }
                            ?>
                            <button type="button" <?php echo $diss_hapus;?> class="btn btn-danger" onclick="javascript:konfirmasi_hapusbahansupplier('<?php echo $idsupplier;?>');"><i class="fa fa-trash"></i> Hapus Bahan Masakan</button>
                            <a type="button" class="btn btn-warning" href="<?php echo base_url()?>supplier/loadform_bahansupplier_manual/<?php echo $idsupplier;?>"><i class="fa fa-file"></i> Tambah Bahan Masakan</a>
                            <button type="button" <?php echo $diss_tambah;?> class="btn btn-success" id="tambah_data" onclick="javascript:loadform_bahansupplier('<?php echo $idsupplier;?>');"><i class="fa fa-file"></i> Copy Bahan Supplier</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tableListData">
                    <thead>
                        <tr>
                            <th style="text-align: center;" width="20">No</th>
                            <th style="text-align: center;">Nama Bahan</th>
                            <th style="text-align: center;" width="100">Harga Satuan</th>
                            <th style="text-align: center;" width="100">Satuan</th>
                            <th style="text-align: center;" width="100">Jenis</th>
                            <th style="text-align: center;" width="100">Spesifikasi</th>
                            <th style="text-align: center;" width="50">Aksi</th>
                            <!-- <th style="text-align: center;" width="50">Publish</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;                        
                        foreach($bahansupplier as $data){
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data['namabahan']; ?></td>
                            <td><?php echo $data['hargasatuan']; ?></td>
                            <td><?php echo $data['satuan']; ?></td>
                            <td><?php echo $data['jenis']; ?></td>
                            <td><?php echo $data['spesifikasi']; ?></td>
                            <td style="text-align: center;">
                                <?php if ($edit == 1) { ?>
                                <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>supplier/loadform_bahansupplier_manual/<?php echo $idsupplier;?>/<?php echo $data['idbahansupplier']; ?>"><i class="fa fa-edit"></i></a>
                                <?php } ?>
                                <?php if ($delete == 1) { ?>   
                                <?php if ($data['jml'] <= 1) { $diss = ''; } else { $diss = 'disabled'; } ?>                     
                                <button type="button" <?php echo $diss;?> class="btn btn-danger btn-xs" id="confirmasiDelete" onclick="javascript:konfirmasi_hapusbahansupplier_manual('<?php echo $data['idbahansupplier']; ?>');"><i class="fa fa-trash"></i></button>
                                <?php } ?>
                            </td>
                            <!-- <td style="text-align: center;">
                                <?php
                                // if ($data['stat'] == 'aktif'){
                                ?>                        
                                    <button type="button" class="btn btn-success btn-xs" id="cekPublish" dataid="<?php //echo $data['idbahansupplier']; ?>" datastat=0><i class="fa fa-check-circle"></i></button>
                                <?php
                                // } else if ($data['stat'] == 'tidak aktif') {
                                ?>
                                    <button type="button" class="btn btn-danger btn-xs" id="cekPublish" dataid="<?php //echo $data['idbahansupplier']; ?>" datastat=1><i class="fa fa-times-circle"></i></button>
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
        <!-- <div class="box-footer"> -->
            
        <!-- </div>/.box-footer                 -->
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>