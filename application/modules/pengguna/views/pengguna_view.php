<?php
    $this->load->view('pengguna/js');
?>
<?php  
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Pengguna Sistem</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        
        <div class="box-body">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <div class="pull pull-right">
                        <?php if ($add == 1) { ?>
                            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>pengguna/loadform" id="tambah_data"><i class="fa fa-file"></i> Tambah Data Pengguna</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tableListData">
                    <thead>
                        <tr>
                            <th style="text-align: center;" width="50">No</th>
                            <th style="text-align: center;">Nama Peserta</th>
                            <th style="text-align: center;" width="150">Username</th>
                            <th style="text-align: center;" width="200">Nama Grup</th>
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
                            <td><?php echo $val['namalengkap']; ?></td>
                            <td style="text-align: center;"><?php echo $val['username']; ?></td>
                            <td style="text-align: center;"><?php echo $val['namagrup']; ?></td>
                            <td style="text-align: center;">
                                <?php if ($edit == 1) { ?>
                                <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>pengguna/loadform/<?php echo $val['idpengguna']; ?>"><i class="fa fa-edit"></i></a>
                                <?php } ?>
                                <?php if ($delete == 1) { ?>                        
                                <button type="button" class="btn btn-danger btn-xs" id="confirmasiDelete" dataid="<?php echo $val['idpengguna']; ?>"><i class="fa fa-trash"></i></button>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if ($val['publish'] == 1){
                                ?>                        
                                    <button type="button" class="btn btn-success btn-xs" id="cekPublish" dataid="<?php echo $val['idpengguna']; ?>" datastat=0><i class="fa fa-check-circle"></i></button>
                                <?php
                                } else if ($val['publish'] == 0) {
                                ?>
                                    <button type="button" class="btn btn-danger btn-xs" id="cekPublish" dataid="<?php echo $val['idpengguna']; ?>" datastat=1><i class="fa fa-times-circle"></i></button>
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
        <!-- <div class="box-footer"> -->
            
        <!-- </div>/.box-footer                 -->
    </div><!-- /.box -->	
</section><!-- /.content -->

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>