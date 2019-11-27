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
                url: "<?php echo base_url().'pengguna/infomodul'; ?>",
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
            var username = $('#username').val();
            var password = $('#password').val();
            var namalengkap = $('#namalengkap').val();
            var idgrup = $('#idgrup').val();
            if (username == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Username harus diisi.");
                $("#username").focus();
            } else if (password == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Password harus diisi.");
                $("#password").focus();
            } else if (namalengkap == '') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Password harus diisi.");
                $("#namalengkap").focus();
            } else if (idgrup == 'pilih') {
                $("#loading").html("<i class='fa fa-exclamation-triangle'></i> Password harus diisi.");
                $("#idgrup").focus();
            } else {
                $.ajax({
                    type: "POST",
                    data: $(this).serialize(),
                    url: "<?php echo base_url().'pengguna/savedata'; ?>",
                    beforeSend: function(){
                        $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                    },
                    success: function(resp){
                        $("#loading").html("");
                        if (resp == 101){
                            $("#loading").html("Berhasil menyimpan data");
                            window.location.assign("<?php echo base_url().'pengguna'; ?>");
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
            var idpengguna = $(this).attr("dataid");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'pengguna/loadformdelete'; ?>",
                data: {"idpengguna":idpengguna},
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
            var idpengguna = $('#idpengguna').val();
            $.ajax({
                type: "POST",
                data: {"idpengguna":idpengguna,"stat":"delete"},
                url: "<?php echo base_url().'pengguna/deletedata'; ?>",
                beforeSend: function(){
                    $("#loading_delete").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        window.location.assign("<?php echo base_url().'pengguna'; ?>");
                    } else if (resp == 100){
                        $("#modal").modal('hide');
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        $(document).on('click', '#cekPublish', function() {
            var idpengguna = $(this).attr("dataid");
            var publish = $(this).attr("datastat");
            $.ajax({
                type: "POST",
                data: {"idpengguna":idpengguna,"publish":publish},
                url: "<?php echo base_url().'pengguna/statpublish'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#loading").html("Berhasil merubah status publish");
                        window.location.assign("<?php echo base_url().'pengguna'; ?>");
                    } else if (resp == 100){
                        $("#loading").html("Gagal merubah status publish");
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        
    });
    
    
</script>