<script>
$(document).ready(function () {
    $("#formoid_sisabahan").submit(function(event) {
        var tanggalpengajuan = $('#tanggalpengajuan').val();
        event.preventDefault();
        $.ajax({
            type: "POST",
            data: $(this).serialize(),
            url: "<?php echo base_url().'pengajuanbahan/savedata_bahansisamasakan'; ?>",
            beforeSend: function(){
                $("#loading_simpansisabahanmasakan").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                $("#submitButton_sisabahanmasakan").attr("disabled",true);
            },
            success: function(resp){                
                // alert(resp);
                // $("#submitButton_sisabahanmasakan").attr("disabled",false);
                // $("#loading_simpansisabahanmasakan").html("");
                pilihTanggalPengajuanBahan();
                form_bahansisa(tanggalpengajuan);
            },
            error: function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    });
});

function hapus_bahansisa(idsisabahan,tanggalpengajuan)
{
    $.ajax({
        type: "POST",
        data: {"idsisabahan":idsisabahan,"stat":"delete"},
        url: "<?php echo base_url().'pengajuanbahan/hapus_bahansisa'; ?>",
        beforeSend: function(){
            $("#btn_bahansisa_"+idsisabahan).attr("disabled",true);
        },
        success: function(resp){
            pilihTanggalPengajuanBahan();
            form_bahansisa(tanggalpengajuan);
        },
        error:function(event, textStatus, errorThrown) {
            alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}
</script>
<div class="modal-content">
    <div class="modal-header bg-primary">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
	<h4 id="modal-default-label" class="modal-title text-center">Form Bahan Sisa</h4>
    </div>
    <div class="modal-body">        
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <tr>
                        <td width="10%" style="text-align: center;">No</td>
                        <td style="text-align: center;">Nama Bahan</td>
                        <td width="20%" style="text-align: center;">Kuantitas</td>
                        <td width="10%" style="text-align: center;">Aksi</td>
                    </tr>
                    <?php
                    $no = 1;
                    foreach ($sisabahanmasakan as $bahan) {
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $no;?></td>
                        <td><?php echo $bahan['namabahan'];?></td>
                        <td style="text-align: center;"><?php echo $bahan['jumlahkuantitas'];?> <?php echo $bahan['satuan'];?></td>
                        <td style="text-align: center;">
                            <button class="btn btn-info btn-xs" onclick="javascript:hapus_bahansisa('<?php echo $bahan['idsisabahan'];?>','<?php echo $bahan['tanggalpengajuan'];?>');" id="btn_bahansisa_<?php echo $bahan['idsisabahan'];?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php
                    $no++;
                    }
                    ?>
                </table>                
            </div>
        </div>
    </div>
    <div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-power-off"></i> Tutup</button>
    </div>
</div>