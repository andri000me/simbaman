<?php
    $this->load->view('menu/js');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#namamodul").focus();
    });
</script>
<?php    
    $sess_data['url'] = $this->input->server('REQUEST_URI');    
    $this->session->set_userdata($sess_data);
?>
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
            <form class="form-horizontal" id="formmodulid" action="" title="" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Menu</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idmenu" name="idmenu" value="<?php echo $idmenu;?>">
                            <input type="text" class="form-control" id="namamenu" name="namamenu" placeholder="Nama Menu" value="<?php echo $namamenu;?>" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nama Modul</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idmodul" name="idmodul">
                            <input type="text" class="form-control" id="namamodul" name="namamodul" placeholder="Nama Modul">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Nomor Urut Modul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="urutanmodul" name="urutanmodul" placeholder="Nomor Urut Modul">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Link Modul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="linkmodul" name="linkmodul" placeholder="Link Modul">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Keterangan Menu</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" placeholder="Keterangan Menu" id="keteranganmodul" name="keteranganmodul"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php if ($add == 1) { ?>
                            <input type="submit" class="btn btn-success" id="submitButton" name="submitButton" value="Simpan">
                            <input type="reset" class="btn btn-warning" id="resetButton" name="resetButton" value="Reset">
                            <?php } ?>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </form>
        </div>
        
        <div class="box-footer">
            <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>menu"><i class="fa fa-reply"></i> Kembali</a>
        </div><!-- /.box-footer -->
    </div>
    
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Data</h3>
            <span class="pull-right">
                <span id="loading"></span>
            </span>
        </div>
        <div class="box-body">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50" style="text-align: center;">No</th>
                                <th width="150" style="text-align: center;">Nama Menu</th>
                                <th width="80" style="text-align: center;">Urutan</th>
                                <th width="150" style="text-align: center;">Nama Modul</th>
                                <th width="100" style="text-align: center;">Link Modul</th>
                                <th style="text-align: center;">Ketrangan</th>
                                <th width="80" style="text-align: center;">Publish</th>
                                <th width="100" style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach($listmodul as $key => $val){
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $val['namamenu']; ?></td>
                                <td style="text-align: center;"><?php echo $val['urutan']; ?></td>
                                <td><?php echo $val['namamodul']; ?></td>
                                <td><?php echo $val['linkmodul']; ?></td>
                                <td><?php echo $val['keterangan']; ?></td>
                                <td style="text-align: center;">
                                    <?php if($val['publish'] == 1) { ?>
                                        <button type="button" class="btn btn-xs btn-success" id="cekPublish_Modul" dataid="<?php echo $val['idmodul']; ?>" dataidmenu="<?php echo $val['idmenu']; ?>" datastat=0 ><i class="fa fa-check-circle"></i></button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-xs btn-danger" id="cekPublish_Modul" dataid="<?php echo $val['idmodul']; ?>" dataidmenu="<?php echo $val['idmenu']; ?>" datastat=1 ><i class="fa  fa-times-circle"></i></button>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($edit == 1) { ?>
                                    <button type="button" class="btn btn-xs btn-warning" id="confirmasiEdit_Modul" dataid="<?php echo $val['idmodul']; ?>"><i class="fa fa-edit"></i></button>
                                    <?php } ?>
                                    <?php if ($delete == 1) { ?>
                                    <button type="button" class="btn btn-xs btn-danger" id="confirmasiDelete_Modul" dataid="<?php echo $val['idmodul']; ?>"><i class="fa fa-trash"></i></button>
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
        </div>
    </div>
</section>

<div id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="content_modal">  	
    </div>
</div>