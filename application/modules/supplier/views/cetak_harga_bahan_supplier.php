<div class="row">
    <div class="col-lg-12">
        <div class="callout callout-info">
            <h4 style="width: 100%; border-collapse: collapse;font-size: 12px;">Supplier : <?php echo $namasupplier;?> (<?php echo $kontraktanggalawal;?> s/d <?php echo $kontraktanggalakhir;?>)</h4>
        </div>
    </div>                
</div>
<div class="table-responsive">
    <table style="width: 100%; border-collapse: collapse;font-size: 12px;">
        <thead>
            <tr>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;" width="20">No</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;">Nama Bahan</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;" width="100">Harga Satuan</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;" width="100">Satuan</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;" width="100">Jenis</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;" width="100">Spesifikasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;                        
            foreach($bahansupplier as $data){
            ?>
            <tr>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $no; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $data['namabahan']; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $data['hargasatuan']; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $data['satuan']; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $data['jenis']; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $data['spesifikasi']; ?></td>                
            </tr>
            <?php
            $no++;
            }
            ?>
        </tbody>
    </table>
</div>