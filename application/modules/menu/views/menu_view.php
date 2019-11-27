<?php
    $this->load->view('menu/js');
?>
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tableListData">
                    <thead>
                        <tr>
                            <th style="text-align: center;" width="20">No</th>
                            <th style="text-align: center;" width="150">Nama Menu</th>
                            <th style="text-align: center;" width="80">Urutan</th>
                            <th style="text-align: center;" width="80">Ikon</th>
                            <th style="text-align: center;">Keterangan</th>
                            <th style="text-align: center;" width="100">Detail Modul</th>
                            <th style="text-align: center;" width="50">Aksi</th>
                            <th style="text-align: center;" width="50">Publish</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach($data as $key => $val){
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $val['namamenu']; ?></td>
                            <td style="text-align: center;"><?php echo $val['urutan']; ?></td>
                            <td style="text-align: center;"><i class="fa <?php echo $val['ikon']; ?>"></i> </td>
                            <td><?php echo $val['keterangan']; ?></td>
                            <td style="text-align: center;">
                                <a type="button" class="btn btn-default btn-xs" href="<?php echo base_url()?>menu/menudetail/<?php echo $val['idmenu']; ?>"><i class="fa fa-list-ul"></i> Detail Modul</a>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($edit == 1) { ?>
                                <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>menu/loadform/<?php echo $val['idmenu']; ?>"><i class="fa fa-edit"></i></a>
                                <?php } ?>
                                <?php if ($delete == 1) { ?>
                                <button type="button" class="btn btn-danger btn-xs" id="confirmasiDelete" dataid="<?php echo $val['idmenu']; ?>"><i class="fa fa-trash"></i></button>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if ($val['publish'] == 1){
                                ?>                        
                                    <button type="button" class="btn btn-success btn-xs" id="cekPublish" dataid="<?php echo $val['idmenu']; ?>" datastat=0><i class="fa fa-check-circle"></i></button>
                                <?php
                                } else if ($val['publish'] == 0) {
                                ?>
                                    <button type="button" class="btn btn-danger btn-xs" id="cekPublish" dataid="<?php echo $val['idmenu']; ?>" datastat=1><i class="fa fa-times-circle"></i></button>
                                <?php
                                }
                                ?>                    
                            </td>
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
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>menu/loadform" id="tambah_data"><i class="fa fa-file"></i> Tambah Data</a>
            <?php } ?>
        </div><!-- /.box-footer -->                
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>