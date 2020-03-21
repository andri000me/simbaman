<div class="row">
    <div class="col-lg-12">
        <div class="callout callout-info">
            <h4 style="width: 100%; border-collapse: collapse;font-size: 12px;">Masakan dan Bahan</h4>
        </div>
    </div>                
</div>
<div class="table-responsive">
    <table style="width: 100%; border-collapse: collapse;font-size: 12px;">
        <thead>
            <tr>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;"  width="20">No</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;"  width="150">Nama Masakan</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;" >Bahan Masakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach($masakan as $data){
            ?>
            <tr>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $no; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $data['namamasakan']; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;">
                    <?php
                    foreach ($masakanbahan as $bahan) {
                        if ($bahan['idmasakan'] == $data['idmasakan']) {
                            echo $bahan['namabahan'].' ('.$bahan['kuantitas'].' '.$bahan['satuan'].' - '.$bahan['jenis'].'), ';
                            echo '<br>';
                        }
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