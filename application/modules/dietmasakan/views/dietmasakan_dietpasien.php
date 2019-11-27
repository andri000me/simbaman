
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

<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <h3>Diet : <?php echo $namadiet[0]['namadiet'];?></h3>
    </div>
</div>

<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <a href="<?php echo base_url()?>dietmasakan/loadform_dietmasakan/<?php echo $namadiet[0]['iddiet'];?>" class="btn btn-success">Tambah Manu Diet : <?php echo $namadiet[0]['namadiet'];?></a>
    </div>
</div>

<?php
if (count($dietmasakan) != 0) {
?>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <tr>
                <td width="20%">Diet</td>
                <th><?php echo $namadiet[0]['namadiet'];?></th>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <th width="25%" style="text-align: center;">Masakan</th>
                <th style="text-align: center;">Bahan Masakan</th>
            </tr>
            <?php
            foreach ($dietmasakan as $dt) {
            ?>
            <tr>
                <td><?php echo $dt['namamasakan'];?> </td>
                <td>
                    <table class="table table-bordered">
                        <tr>
                            <th style="text-align: center;">Nama Bahan</th>
                            <th width="15%" style="text-align: center;">Kuantitas</th>
                            <th width="15%" style="text-align: center;">Pengurangan</th>
                        </tr>
                        <?php
                        foreach ($dietmasakanbahan as $bahan) {
                            if ($bahan['idmasakan'] == $dt['idmasakan']) {
                        ?>
                        <tr>
                            <td><?php echo $bahan['namabahan'];?> | <?php echo $bahan['jenis'];?> | <?php echo $bahan['satuan'];?></td>
                            <td style="text-align: right;"><?php echo $bahan['kuantitas'];?> <?php echo $bahan['satuan_kauntitas'];?></td>
                            <td style="text-align: right;"><?php echo $bahan['pengurangan'];?> <?php echo $bahan['satuan_pengurangan'];?></td>
                            
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>
<?php
} else {
    echo '';
}
?>
