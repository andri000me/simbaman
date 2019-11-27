<?php
    $this->load->view('grup/js');
?>

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
                        <label for="" class="col-sm-2 control-label">Nama Grup</label>
                        <div class="col-sm-10">
                            <input type="hidden" class="form-control" id="idgrup" name="idgrup" value="<?php echo $idgrup;?>">
                            <input type="text" class="form-control" id="namagrup" name="namagrup" placeholder="Nama Grup" value="<?php echo $namagrup;?>" readonly="">
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </form>
        </div>
        
        <div class="box-footer">
            <button type="button" class="btn btn-info" id="tampilinfo"><i class="fa fa-exclamation-triangle"></i> Info</button>
            <a type="button" class="btn btn-danger pull-right" href="<?php echo base_url()?>grup"><i class="fa fa-reply"></i> Kembali</a>
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
                                <th width="200" style="text-align: center;">Nama Menu</th>
                                <th>Nama Modul</th>
                                <th width="100" style="text-align: center;">Lihat</th>
                                <th width="100" style="text-align: center;">Tambah</th>
                                <th width="100" style="text-align: center;">Ubah</th>
                                <th width="100" style="text-align: center;">Hapus</th>
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
                                <td><?php echo $val['namamodul']; ?></td>
                                <td style="text-align: center;">
                                    <?php
                                    $viewData = $this->grup_query->whereView($val['idmodul'],$idgrup);
                                    if ($viewData->num_rows() > 0){
                                        foreach($viewData->result() as $v){
                                            $vi = $v->visited;
                                        }
                                        if ($vi == 1){
                                            $view = 'checked';
                                            $dis_add = '';
                                            $dis_edit = '';
                                            $dis_del = '';
                                        } else {
                                            $view = '';
                                            $dis_add = 'disabled';
                                            $dis_edit = 'disabled';
                                            $dis_del = 'disabled';
                                        }
                                    } else {
                                        $view = '';
                                        $dis_add = 'disabled';
                                        $dis_edit = 'disabled';
                                        $dis_del = 'disabled';
                                    }
                                    ?>
                                    <input type="checkbox" id="cekView<?php echo $val['idmodul'];?>" value="1" onclick="toggleView('<?php echo $val['idmodul'];?>','<?php echo $idgrup;?>')" <?php echo $view;?>>
                                </td>
                                <td style="text-align: center;">
                                    <?php						    
                                    $viewAdd = $this->grup_query->whereView($val['idmodul'],$idgrup);
                                    if ($viewAdd->num_rows() > 0){
                                        foreach($viewAdd->result() as $a){
                                            $ad = $a->created;
                                        }
                                        if ($ad == 1){
                                            $add = 'checked';
                                        } else {
                                            $add = '';
                                        }
                                    } else {
                                        $add = '';
                                    }
                                    ?>
                                    <input type="checkbox" id="cekAdd<?php echo $val['idmodul'];?>" value="1" onclick="toggleAdd('<?php echo $val['idmodul'];?>','<?php echo $idgrup;?>')" <?php echo $add;?> <?php echo $dis_add;?>>
                                </td>
                                <td style="text-align: center;">
                                    <?php						    
                                    $viewEdit = $this->grup_query->whereView($val['idmodul'],$idgrup);
                                    if ($viewEdit->num_rows() > 0){
                                        foreach($viewEdit->result() as $e){
                                            $ed = $e->updated;
                                        }
                                        if ($ed == 1){
                                            $edit = 'checked';
                                        } else {
                                            $edit = '';
                                        }
                                    } else {
                                        $edit = '';
                                    }
                                    ?>
                                    <input type="checkbox" id="cekEdit<?php echo $val['idmodul'];?>" value="1" onclick="toggleEdit('<?php echo $val['idmodul'];?>','<?php echo $idgrup;?>')" <?php echo $edit;?> <?php echo $dis_edit;?>>
                                </td>
                                <td style="text-align: center;">
                                    <?php						    
                                    $viewDelete = $this->grup_query->whereView($val['idmodul'],$idgrup);
                                    if ($viewDelete->num_rows() > 0){
                                        foreach($viewDelete->result() as $d){
                                            $del = $d->deleted;
                                        }
                                        if ($del == 1){
                                            $delete = 'checked';
                                        } else {
                                            $delete = '';
                                        }
                                    } else {
                                        $delete = '';
                                    }
                                    ?>
                                    <input type="checkbox" id="cekDelete<?php echo $val['idmodul'];?>" value="1" onclick="toggleDelete('<?php echo $val['idmodul'];?>','<?php echo $idgrup;?>')" <?php echo $delete;?> <?php echo $dis_del;?>>
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