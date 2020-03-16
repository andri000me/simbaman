
<?php
/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-16 21:23:10
 * @modify date 2019-09-16 21:23:10
 * @desc [description]
 */
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
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Kelas : <?php echo $namakelas[0]['namakelas'];?></h3>
        <span class="pull-right">
            <a href="<?php echo base_url()?>menumasakan/loadform_menumasakan/<?php echo $namakelas[0]['idkelas'];?>" class="btn btn-success">Tambah Menu Masakan</a>
        </span>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableListData">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="20">No</th>
                                <th style="text-align: center;" width="150">Jenis Menu</th>
                                <th style="text-align: center;" >Waktu Menu Masakan</th>
                                <th style="text-align: center;" width="50">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach($menu as $data){
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data['namajenismenu']; ?></td>
                                <td>
                                <table class="table table-bordered">
                                <?php
                                foreach ($waktumenu as $waktu) {
                                    if ($waktu['idjenismenu'] == $data['idjenismenu']) {
                                    ?>
                                    <tr>
                                        <td><?php echo $waktu['namawaktumenu'];?></td>
                                        <td>
                                        <?php 
                                        foreach ($masakan as $msk) {
                                            if (($msk['idjenismenu'] == $data['idjenismenu']) AND ($msk['idwaktumenu'] == $waktu['idwaktumenu'])) {
                                                echo $msk['namamasakan'].', ';
                                            }
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    <?php                            
                                    }
                                }
                                ?>                        
                                </table>
                                </td>
                                <td>
                                    <?php if ($edit == 1) { ?>
                                    <a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url()?>menumasakan/loadform_menumasakan/<?php echo $data['idkelas'];?>/<?php echo $data['idjenismenu'];?>"><i class="fa fa-edit"></i></a>
                                    <?php } ?>
                                    <?php if ($delete == 1) { ?>                                
                                        <button type="button" class="btn btn-danger btn-xs" id="confirmasiDelete" onclick="javascript:konfirmasi_hapusmasakan('');"><i class="fa fa-trash"></i></button>
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
</div>