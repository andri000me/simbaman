<?php
    $this->load->view('sistemlog/js');
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
                            <th style="text-align: center;" width="80">Log Tipe</th>
                            <th style="text-align: center;" width="80">Username</th>
                            <th style="text-align: center;" width="80">Log Lokasi</th>
                            <th style="text-align: center;">Pesan</th>
                            <th style="text-align: center;" width="100">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach($data as $key => $val){
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $no; ?></td>
                            <td style="text-align: center;"><?php echo $val['log_type']; ?></td>
                            <td style="text-align: center;"><?php echo $val['id']; ?></td>
                            <td style="text-align: center;"><?php echo $val['log_location']; ?></td>
                            <td><?php echo $val['log_msg']; ?></td>
                            <td style="text-align: center;"><?php echo $val['log_date']; ?></td>
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