<?php
$this->load->model('listmenu_query');
?>
    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>Stm</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b> Sistem</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- Notifications: style can be found in dropdown.less -->
              
              <!-- Tasks: style can be found in dropdown.less -->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php
                    if ($foto == NULL) {
                    ?> 
                        <img src="<?php echo base_url(); ?>/assets/dist/img/<?php echo $kelamin; ?>.png" class="user-image" alt="User Image">
                    <?php
                    } else {
                    ?>
                        <img src="<?php echo base_url()?><?php echo $foto;?>" class="user-image" alt="User Image">
                    <?php
                    }
                    ?>
                  <span class="hidden-xs"><?php echo $namalengkap; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?php
                    if ($foto == NULL) {
                    ?>
                        <img src="<?php echo base_url(); ?>/assets/dist/img/<?php echo $kelamin; ?>.png" class="img-circle" alt="User Image">
                    <?php
                    } else {
                    ?>
                        <img src="<?php echo base_url()?><?php echo $foto;?>" class="img-circle" alt="User Image">
                    <?php
                    }
                    ?>
                    <p>
                      <?php // echo $email; ?>
                        <small>Bergabung sejak <br> <?php echo $tglinsert; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url()?>profil" class="btn btn-default btn-flat">Profil</a>
                    </div>
                    <div class="pull-right">
                        <a href="<?php echo base_url(); ?>access/logout">
                        <button type="button" class="btn btn-default btn-flat">
                            <i class="fa fa-sign-out"></i> Keluar
                        </button>
                        </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
    </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
                <?php
                if ($foto == NULL) {
                ?>
                    <img src="<?php echo base_url(); ?>/assets/dist/img/<?php echo $kelamin; ?>.png" class="img-circle" alt="User Image"> <!--wanita.png-->
                <?php
                } else {
                ?>
                    <img src="<?php echo base_url()?><?php echo $foto;?>" class="img-circle" alt="User Image"> 
                <?php
                }
                ?>
            </div>
            <div class="pull-left info">
              <p><?php echo $namalengkap; ?></p>
              <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <?php
                            $url = $this->uri->segment(1);
                            if ($url == '') {
                                    $activedash = "active";
                            } else {
                                    $activedash = "";
                            }
                            ?>
                            <li class="<?php echo $activedash; ?> treeview">
                      <a href="<?php echo base_url();?>">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                      </a>	  
                    </li>	
                    <?php
                            $listmenu = $this->listmenu_query->getdataMenuHakAkses($idgrup,$idpengguna);
                            foreach($listmenu->result() as $mn){
                                    $active = $this->listmenu_query->activeMenu($url,$mn->idmenu);
                                    if ($active == 1) {
                                            $actmenu = "active";
                                    } else {
                                            $actmenu = "";
                                    }
                            ?>
                    <li class="<?php echo $actmenu; ?> treeview">
                      <a href="#">
                            <i class="fa <?php echo $mn->ikon; ?>"></i> <span><?php echo $mn->namamenu; ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                                    <?php
                                    $idmenu = $mn->idmenu;
                                    $listmodul = $this->listmenu_query->getdataMenuModulHakAkses($idgrup,$idmenu,$idpengguna);
                                    foreach($listmodul->result() as $md){
                                            if ($url == $md->linkmodul) {
                                                    $actmodul = "active";
                                                    $fa = "text-red";
                                            } else {
                                                    $actmodul = "";
                                                    $fa = "";
                                            }
                                    ?>
                                    <li class="<?php echo $actmodul; ?>">
                                            <a href="<?php echo base_url().$md->linkmodul; ?>">
                                                    <i class="fa fa-circle-o <?php echo $fa; ?>"></i> <?php echo $md->namamodul; ?>
                                            </a>
                                    </li>
                                    <?php
                                    }
                                    ?>
                            </ul>

                            </li>
                            <?php
                            }
                            ?>

                    <!-- <li>
                                    <a href="">
                                            <i class="fa fa-book"></i> <span>Dokumentasi</span>
                                    </a>
                            </li> -->
                    <!-- <li class="header">LABELS</li>
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
            </ul>
        </section>
        <!-- /.sidebar -->
      </aside>