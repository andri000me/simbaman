<script type="text/javascript">
    $(document).ready(function () {
                
        $(document).on('click', '#tampilinfo', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'profil/infomodul'; ?>",
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
        
        $(document).on('click', '#editButton', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'profil/ubahdata'; ?>",
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
        
        $(document).on('click', '#submitButton', function() {
            var idpengguna = $('#idpengguna_x').val();
            var namalengkap = $('#namalengkap_x').val();
            var kelamin = $('#kelamin_x').val();
            var username = $('#username_x').val();
            var password = $('#password_x').val();
            $.ajax({
                type: "POST",
                data: {"idpengguna":idpengguna,"namalengkap":namalengkap,"kelamin":kelamin,"username":username,"password":password},
                url: "<?php echo base_url().'profil/savedata'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    if (resp == 101){
                        $("#modal").modal('hide');
                        $("#loading").html("Berhasil menyimpan data");
                        window.location.assign("<?php echo base_url().'profil'; ?>");
                    } else if (resp == 100){
                        $("#modal").modal('hide');
                        $("#loading").html("Gagal menyimpan data");;
                    }
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
        
        $(document).on('click', '#pictureButton', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'profil/ubahfoto'; ?>",
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
        
        $(document).on('click', '#delpictureButton', function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'profil/hapusfoto'; ?>",
                beforeSend: function(){
                    $("#loading").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
                },
                success: function(resp){
                    window.location.assign("<?php echo base_url().'profil'; ?>");
                },
                error:function(event, textStatus, errorThrown) {
                   alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
        });
        
    });
    
    function upload_foto (){
        var idpengguna = $('#idpengguna').val();
        var fotoFile = $('#fotoFile').val();

        $('#frm_upload_foto').ajaxForm({        
            type: 'post',
            url:'<?php echo base_url()."profil/uploadfoto";?>',
            data:{"idpengguna":idpengguna, "fotoFile":fotoFile},
            beforeSubmit: function() {
    //            $("#disabledbuttonUpload").html("<button type='button' class='btn btn-success' disabled><i class='fa fa-save'></i> Simpan</button>");
                $("#btnUpload").attr("disabled","true");
                $("#loadingsaveUpload").html("Loading Data <img src='<?php echo base_url()?>/assets/dist/img/loading.gif' width='10px'>");
            },
            success: function(resp) {
    //            $("#alertinputUpload").html(resp);
                if (resp == 1){
                    $("#modal").modal('hide');
                    window.location.assign("<?php echo base_url().'profil'; ?>");
                } else {
                    $("#alertinputUpload").html("<div class='note note-danger'><i class='fa fa-truck'></i> " + resp + " </div>");
                    $("#btnUpload").removeAttr("disabled");
                    $("#loadingsaveUpload").html("");
                }

            },
            error:function(event, textStatus, errorThrown) {
                alert('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
    };
    
    
</script>