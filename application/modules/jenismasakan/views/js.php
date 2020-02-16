<script type="text/javascript">
    $(document).ready(function () {
        $("#tableListData").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
        });
                
        $(document).on('click', '#tampilinfo', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'jenismasakan/infomodul'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    $("#modal").modal('show');
                    $("#content_modal").html(resp);
                    $("#loading").html("");
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        $("#formoid").submit(function(event) {
            event.preventDefault();
            var namajenismasakan = $('#namajenismasakan').val();
            if (namajenismasakan == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Nama Jenis Masakan harus diisi.");
                $("#namajenismasakan").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'jenismasakan/savedata'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    },
                    success: function(resp){
                        $("#loading").html("");
                        if (resp == 101){
                            $("#loading").html("Berhasil menyimpan data");
                            window.location.assign("<?php echo base_url().'jenismasakan'; ?>");
                        } else if (resp == 100){
                            $("#loading").html("Gagal menyimpan data");;
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                       alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });
            }
        });
        
        $(document).on('click', '#confirmasiDelete', function() {
            var idjenismasakan = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'jenismasakan/loadformdelete'; ?>",
                data: {"idjenismasakan":idjenismasakan},
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    $("#modal").modal('show');
                    $("#content_modal").html(resp);
                    $("#loading").html("");
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        $(document).on('click', '#hapus_data', function() {
            var idjenismasakan = $('#idjenismasakan').val();
            $.ajax({
                type: "POST",
                data: {"idjenismasakan":idjenismasakan,"status":"delete"},
                url: "<?php echo base_url().'jenismasakan/deletedata'; ?>",
                beforeSend: function(){
                    $("#loading_delete").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        window.location.assign("<?php echo base_url().'jenismasakan'; ?>");
                    } else if (resp == 100){
                        $("#modal").modal('hide');
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
    });
    
    
</script>