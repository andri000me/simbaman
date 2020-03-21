<div class="row">
    <div class="col-lg-12">
        <div class="callout callout-info">
            <h4 style="width: 100%; border-collapse: collapse;font-size: 12px;">Bahan Masakan</h4>
        </div>
    </div>                
</div>
<div class="table-responsive">
    <table style="width: 100%; border-collapse: collapse;font-size: 12px;">
        <thead>
            <tr>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;" width="20">No</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;">Nama Bahan</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;"width="80">Satuan</th>
                <th style="padding: 5px;border: 1px solid #000000;font-weight: bold; text-align: center; background-color: #EDEDED;"width="150">Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach($data as $key => $val){
            ?>
            <tr>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $no; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $val['namabahan']; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;text-align: center;"><?php echo $val['satuan']; ?></td>
                <td style="padding: 5px;border: 1px solid #000000;"><?php echo $val['jenis']; ?></td>                
            </tr>
            <?php
            $no++;
            }
            ?>
        </tbody>
    </table>
</div>