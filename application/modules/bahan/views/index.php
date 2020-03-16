<?php
    $this->load->view('bahan/js');
?>

<?php  
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>
<section class="content">
<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data Bahan Masakan</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        
        <div class="box-body">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-lg-12">
                    <div class="pull pull-right">
                        <?php if ($add == 1) { ?>
                            <a type="button" class="btn btn-warning" href="<?php echo base_url()?>bahan/jenisbahan" id="jenis_bahan"><i class="fa fa-file"></i> Jenis Golongan Bahan</a> 
                            <a type="button" class="btn btn-danger" href="<?php echo base_url()?>bahan/loadform" id="tambah_data"><i class="fa fa-file"></i> Tambah Bahan Masakan</a> 
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
                            <th style="text-align: center;" width="80">Satuan</th>
                            <th style="text-align: center;" width="150">Jenis</th>
                            <th style="text-align: center;" width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach($data as $key => $val){
                            if (empty($val['idmasakanbahan'])) {
                                $dissable = '';
                            } else {
                                $dissable = 'disabled';
                            }
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $val['namabahan']; ?></td>
                            <td style="text-align: center;"><?php echo $val['satuan']; ?></td>
                            <td><?php echo $val['jenis']; ?></td>
                            <td style="text-align: center;">
                                <?php if ($edit == 1) { ?>
                                <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>bahan/loadform/<?php echo $val['idbahan']; ?>"><i class="fa fa-edit"></i></a>
                                <?php } ?>
                                <?php if ($delete == 1) { ?>
                                <button type="button" <?php echo $dissable;?> class="btn btn-danger btn-xs" id="confirmasiDelete" dataid="<?php echo $val['idbahan']; ?>"><i class="fa fa-trash"></i></button>
                                <?php } ?>
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