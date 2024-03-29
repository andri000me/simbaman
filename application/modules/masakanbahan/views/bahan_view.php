<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 06:51:49
 * @modify date 2019-09-26 06:51:49
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

function konfirmasi_hapusbahan(idbahan)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'masakanbahan/loadformdelete_bahan'; ?>",
        data: {"idbahan":idbahan},
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

function hapus_bahan()
{
    var idbahan = $('#idbahan_delete').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'masakanbahan/savedata_bahan'; ?>",
        data: {"idbahan":idbahan,"stat":"delete"},
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
                                    <th style="text-align: center;">Nama Bahan</th>
                                    <th style="text-align: center;" width="100">Satuan</th>
                                    <th style="text-align: center;" width="200">Jenis</th>
                                    <th style="text-align: center;" width="50">Aksi</th>
                                    <!-- <th style="text-align: center;" width="50">Publish</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach($bahan as $data){
                                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $data['namabahan']; ?></td>
                                    <td><?php echo $data['satuan']; ?></td>
                                    <td><?php echo $data['jenis']; ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($edit == 1) { ?>
                                        <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>masakanbahan/loadform_bahan/<?php echo $data['idbahan']; ?>"><i class="fa fa-edit"></i></a>
                                        <?php } ?>
                                        <?php if ($delete == 1) { ?>
                                            <?php
                                            if ($data['jml'] <= 1) { $diss = ''; } else { $diss = 'disabled'; }  
                                            ?>
                                            <button type="button" <?php echo $diss;?> class="btn btn-danger btn-xs" id="confirmasiDelete" onclick="javascript:konfirmasi_hapusbahan('<?php echo $data['idbahan']; ?>');"><i class="fa fa-trash"></i></button>
                                        <?php } ?>
                                    </td>
                                    <!-- <td style="text-align: center;">
                                        <?php
                                        // if ($data['stat'] == 'aktif'){
                                        ?>                        
                                            <button type="button" class="btn btn-success btn-xs" id="cekPublish" dataid="<?php echo $data['idbahan']; ?>" datastat=0><i class="fa fa-check-circle"></i></button>
                                        <?php
                                        // } else if ($data['stat'] == 'tidak aktif') {
                                        ?>
                                            <button type="button" class="btn btn-danger btn-xs" id="cekPublish" dataid="<?php echo $data['idbahan']; ?>" datastat=1><i class="fa fa-times-circle"></i></button>
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
            <a href="<?php echo base_url()?>masakanbahan" class="btn btn-danger"><i class="fa fa-backward"></i> Kembali</a>
            <?php if ($add == 1) { ?>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>masakanbahan/loadform_bahan" id="tambah_data"><i class="fa fa-file"></i> Tambah Data</a>
            <?php } ?>
        </div><!-- /.box-footer -->                
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>