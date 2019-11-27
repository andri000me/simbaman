<?php
    $this->load->view('access/js');
?>
<?php
    $sess_data['url'] = $this->input->server('REQUEST_URI');
    $this->session->set_userdata($sess_data);
?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Administrator</b> Log in</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <!--<p class="login-box-msg">Sign in to start your session</p>-->
        <form action="#" method="post" style="margin-bottom: 30px; margin-top: 30px;">
            <div class="form-group has-feedback">
                <input type="test" class="form-control" placeholder="Username" id="username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" id="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?php echo $image;?>
                </div><!-- /.col -->
                <div class="col-xs-6">
                    <input type="text" class="form-control" id="keycaptcha" name="keycaptcha">
                </div><!-- /.col -->
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div id="alert">&nbsp;</div>
                </div><!-- /.col -->
            </div>
            <div class="row">
                <div class="col-xs-8">
                    
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="button" class="btn btn-primary btn-block btn-flat" id="ceklogin"><i class="fa fa-sign-in"></i> Masuk</button>
                </div><!-- /.col -->
            </div>
            <!-- <a href="forgot_password">Lupa password</a> -->
            <br>
        </form>
        <hr>
        <div style="text-align: center;">
            Suport by Codeigniter and Admin LTE <br>
            Copyright Administrator © 2016
        </div>

      </div><!-- /.login-box-body -->
</div><!-- /.login-box -->