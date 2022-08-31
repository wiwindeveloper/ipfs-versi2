 <!-- Content Wrapper -->
 <div id="content-wrapper" class="d-flex flex-column my-3">

     <!-- Main Content -->
     <div id="content">

         <!-- Topbar -->
         <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">

             <!-- Sidebar Toggle (Topbar) -->
             <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                 <i class="fa fa-bars"></i>
             </button>

             <!-- Topbar Search -->
              <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group input-group-joined">
                        <span class="input-group-text">
                            <img src="<?= base_url('assets/img/icon-03.png'); ?>" alt="icon" width="20px">
                        </span>
                        <input class="form-control border-0 small" placeholder="<?= $this->lang->line('search');?>" aria-label="Search" aria-describedby="basic-addon2" id="myInput">
                    </div>
                </div>

             <!-- Topbar Navbar -->
             <ul class="navbar-nav ml-auto">

                 <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                 <li class="nav-item dropdown no-arrow d-sm-none">
                     <!-- Dropdown - Messages -->
                     <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                         <form class="form-inline mr-auto w-100 navbar-search">
                             <div class="input-group">
                                 <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                 <div class="input-group-append">
                                     <button class="btn btn-primary" type="button">
                                         <i class="fas fa-search fa-sm"></i>
                                     </button>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </li>

                 <!-- Nav Item - Alerts -->
                 <?php
                    if ($this->session->userdata('role_id') == '2') {
                    ?>
                     <li class="nav-item dropdown no-arrow mx-1 list-notification">
                         <a class="nav-link dropdown-toggle topbar-icon" href="<?= base_url('user/news_announcement') ?>">
                         <!--<a class="nav-link dropdown-toggle topbar-icon" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                             <!-- <i class="fas fa-bell fa-fw"></i> -->
                             <img src="<?= base_url('assets/img/icon-04.png'); ?>">
                             <!-- Counter - Alerts -->
                             <?php
                                if ($amount_notif > 0) {
                                ?>
                                 <span class="badge badge-danger badge-counter"><?= $amount_notif; ?>+</span>
                             <?php
                                }
                                ?>
                         </a>
                         <!-- Dropdown - Alerts -->
                         <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                             <h6 class="dropdown-header">
                                 Notification
                             </h6>

                             <?php
                                foreach ($list_notif as $row_list) {
                                ?>
                                 <a class="dropdown-item d-flex align-items-center" href="<?= base_url() . $row_list->link . '/' . $row_list->id ?>" <?php if ($row_list->is_show == 0) {
                                                                                                                                                            echo "style='background: #f7f7f7;'";
                                                                                                                                                        } ?>>
                                     <div class="mr-3">
                                         <?php
                                            if ($row_list->type == 1 || $row_list->type == 3 || $row_list->type == 5 || $row_list->type == 6) {
                                            ?>
                                             <div class="icon-circle bg-warning">
                                                 <i class="fas fa-exclamation-triangle text-white"></i>
                                             </div>
                                         <?php
                                            } elseif ($row_list->type == 2 || $row_list->type == 4) {
                                            ?>
                                             <div class="icon-circle bg-success">
                                                 <i class="fas fa-check text-white"></i>
                                             </div>
                                         <?php
                                            }
                                            ?>
                                     </div>
                                     <div>
                                         <div class="small text-gray-500"><?= date('d M Y', $row_list->datecreate); ?></div>
                                         <?= $row_list->title; ?>: <?= $row_list->message; ?>
                                     </div>
                                 </a>
                             <?php
                                }
                                ?>

                             <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Notification</a> -->
                         </div>
                     </li>
                 <?php
                    }
                    ?>
                 <li class="nav-item">
                     <?php
                        if($this->session->userdata('role_id') == '2')
                        {
                         ?>
                         <a class="nav-link topbar-icon" href="<?= base_url('user/customer_service'); ?>" id="#" role="button">
                            <img src="<?= base_url('assets/img/icon-05.png'); ?>">
                        </a>
                         <?php
                        }else{
                     ?>
                     <a class="nav-link topbar-icon" href="<?= base_url('admin/message'); ?>" id="#" role="button">
                         <img src="<?= base_url('assets/img/icon-05.png'); ?>">
                     </a>
                     <?php
                        }
                     ?>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link topbar-icon" href="<?= base_url('user/setting'); ?>" id="#" role="button">
                         <img src="<?= base_url('assets/img/icon-06.png'); ?>">
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link topbar-icon" href="<?= base_url('auth/logout'); ?>" id="#" role="button" data-toggle="modal" data-target="#logoutModal">
                         <img src="<?= base_url('assets/img/icon logout-43.png'); ?>">
                     </a>
                 </li>

                 <!-- Nav Item - Language -->
                 <li class="nav-item mr-2 ml-4 align-self-center ">
                     <!-- <a class="nav-link dropdown-toggle top-lang flagfirst" href="" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <img class="" src="<?= base_url('assets/img/icon-20.png'); ?>">
                     </a>
                     <div class="dropdown-menu dropdown-menu-right dropdown-lang shadow animated--grow-in" aria-labelledby="userDropdown">
                         <a class="dropdown-item top-lang" href="<?= base_url('user/switch/korea'); ?>">
                             <img class="" src="<?= base_url('assets/img/icon-19.png'); ?>">
                         </a>
                         <a class="dropdown-item top-lang" href="<?= base_url('user/switch/english'); ?>">
                             <img class="" src="<?= base_url('assets/img/icon-20.png'); ?>">
                         </a>
                         <a class="dropdown-item top-lang" href="<?= base_url('user/switch/indonesia'); ?>">
                             <img class="" src="<?= base_url('assets/img/icon-21.png'); ?>">
                         </a>
                         <a class="dropdown-item top-lang" href="#" data-toggle="modal" data-target="#logoutModal">
                             <img class="" src="<?= base_url('assets/img/icon-22.png'); ?>">
                         </a>
                         <a class="dropdown-item top-lang" href="#" data-toggle="modal" data-target="#logoutModal">
                             <img class="" src="<?= base_url('assets/img/icon-23.png'); ?>">
                         </a>
                     </div> -->
                     <!-- <form action="<?php base_url('user/marketing_plan'); ?>" method="post"> -->
                         <!-- <select class="" id="id_select2_example" style="width: 60px" name="language" onchange="this.form.submit()">
                             <?php if ($_SESSION['language'] != '') : ?>
                                 <option value="korea" data-img_src="<?= base_url('assets/img/icon-19.png'); ?>" <?= $_SESSION['language'] == 'koreaa' ? 'selected' : ''; ?>></option>
                                 <option value="english" data-img_src="<?= base_url('assets/img/icon-20.png'); ?>" <?= $_SESSION['language'] == 'english' ? 'selected' : ''; ?>></option>
                                 <option value="indonesia" data-img_src="<?= base_url('assets/img/icon-21.png'); ?>" <?= $_SESSION['language'] == 'indonesia' ? 'selected' : ''; ?>></option>
                                 <option value="china" data-img_src="<?= base_url('assets/img/icon-22.png'); ?>" <?= $_SESSION['language'] == 'china' ? 'selected' : ''; ?>></option>
                                 <option value="thailand" data-img_src="<?= base_url('assets/img/icon-23.png'); ?>" <?= $_SESSION['language'] == 'thailand' ? 'selected' : ''; ?>></option>
                             <?php else : ?>
                                 <option value="korea" data-img_src="<?= base_url('assets/img/icon-19.png'); ?>"></option>
                                 <option value="english" data-img_src="<?= base_url('assets/img/icon-20.png'); ?>" selected></option>
                                 <option value="indonesia" data-img_src="<?= base_url('assets/img/icon-21.png'); ?>"></option>
                                 <option value="china" data-img_src="<?= base_url('assets/img/icon-22.png'); ?>"></option>
                                 <option value="thailand" data-img_src="<?= base_url('assets/img/icon-23.png'); ?>"></option>
                             <?php endif ?>
                         </select> -->
                     <!-- </form> -->
                     <select class="" id="id_select2_example" style="width: 60px" name="language" onchange="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/'+this.value;">
                        <option value="english" data-img_src="<?= base_url('assets/img/icon-20.png'); ?>" <?php if($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>></option>
                        <option value="korea" data-img_src="<?= base_url('assets/img/icon-19.png'); ?>"  <?php if($this->session->userdata('site_lang') == 'korea') echo 'selected="selected"'; ?>></option>
                     </select>
                 </li>

             </ul>
         </nav>
         <!-- End of Topbar -->