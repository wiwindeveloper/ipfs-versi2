<div class="container-fluid">

    <div class="card o-hidden border-0 shadow-lg bg-transparent">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <!-- <div class="col-lg-7 d-none d-lg-block bg-register-image"></div> -->

                <div class="col-md-6 m-auto">

                    <!-- <div class="navmenu-cs flex-rowcs pt-5">
                        <div class="pl-5"> -->
                    <!-- <img src="<?= base_url('assets/img/logo.png'); ?>" alt="" width="150"> -->
                    <!-- </div>
                        <div class="pr-5">
                            <div class="dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="img-profile rounded-circle"
                                        src="<?= base_url('assets/img/united-kingdom.png'); ?>" width="24">
                                    <span class="mr-2 d-lg-inline small" style="color: #545454;">English</span>
                                    <i class="fas fa-angle-down" style="color: #565252;"></i>
                                </a> -->
                    <!-- Dropdown - User Information -->
                    <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#">
                                        <img class="img-profile rounded-circle"
                                            src="<?= base_url('assets/img/united-arab-emirates.png'); ?>" width="24">
                                        <span class="mr-2 d-lg-inline small" style="color: #545454;">Arabic</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img class="img-profile rounded-circle"
                                            src="<?= base_url('assets/img/china.png'); ?>" width="24">
                                        <span class="mr-2 d-lg-inline small" style="color: #545454;">Chinese</span>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img class="img-profile rounded-circle"
                                            src="<?= base_url('assets/img/denmark.png'); ?>" width="24">
                                        <span class="mr-2 d-lg-inline small" style="color: #545454;">Danish</span>
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <img class="img-profile rounded-circle"
                                            src="<?= base_url('assets/img/philippines.png'); ?>" width="24">
                                        <span class="mr-2 d-lg-inline small" style="color: #545454 !important;">Filipino</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="p-5">
                        <div class="text-center signin-header">
                            <h1 class="h4 text-white mb-4">SIGN UP</span></h1>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="registration" method="post" action="<?= base_url('auth/registration') ?>">
                           
                            <div class="input-group check">
                                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username'); ?>" placeholder="ID">
                                <div class=" input-group-append">
                                    <button class="btn btn-secondary border text-white" name="check_id" type="submit">
                                        <?= $this->lang->line('check'); ?>
                                    </button>
                                </div>
                            </div>
                            <?php if ($check == $count) : ?>
                            <?php elseif ($check != 0) : ?>
                                <small class="text-danger pl-3"><?= $this->lang->line('id_already_use'); ?></small>
                            <?php elseif ($check == 0) : ?>
                                <small class="text-success pl-3"><?= $this->lang->line('id_can_use'); ?></small>
                            <?php endif ?>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?= set_value('firstname'); ?>" placeholder="<?= $this->lang->line('name'); ?>">
                                <?= form_error('firstname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="input-group check">
                                <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="EMAIL">
                                <div class=" input-group-append">
                                    <button class="btn btn-secondary border text-white" name="check" type="submit">
                                    <?= $this->lang->line('check'); ?>
                                    </button>
                                </div>
                            </div>
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            <div class="input-group mt-3">
                                <input type="text" class="form-control" id="check_code" name="check_code" placeholder="CODE EMAIL" value="<?= set_value('check_code'); ?>">
                            </div>
                            <?= form_error('check_code', '<small class="text-danger pl-3">', '</small>'); ?>
                           

                            <div class="input-group eye mt-3" id="show_hide_password1">
                                <input type="password" class="form-control" placeholder="PASSWORD" id="password1" name="password1">
                                <div class="input-group-append">
                                    <button class="btn" type="button">
                                        <i class="fas fa-eye-slash fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>

                           

                            <div class="input-group eye mt-3" id="show_hide_password2">
                                <input type="password" class="form-control" id="password2" name="password2" placeholder="<?= $this->lang->line('repeat'); ?> PASSWORD">
                                <div class="input-group-append">
                                    <button class="btn" type="button">
                                        <i class="fas fa-eye-slash fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                            <!-- </div>
                            </div> -->
                            <div class="form-group mt-3">
                                <!-- <div class="col-4"> -->
                                <select class="form-control" id="country" name="country">
                                    <option class="text-black text-center" selected disabled>- <?= $this->lang->line('select_country_code'); ?> -</option>
                                    <option class="text-black text-center" value="62"><?= $this->lang->line('indonesia'); ?> (+62)</option>
                                    <option class="text-black text-center" value="82"><?= $this->lang->line('korea'); ?> (+82)</option>
                                    <option class="text-black text-center" value="1"><?= $this->lang->line('united_state'); ?> (+1)</option>
                                    <option class="text-black text-center" value="44"><?= $this->lang->line('united_kingdom'); ?> (+44)</option>
                                    <option class="text-black text-center" value="66"><?= $this->lang->line('china'); ?> (+66)</option>
                                    <option class="text-black text-center" value="84"><?= $this->lang->line('vietnam'); ?> (+84)</option>
                                    <option class="text-black text-center" value="86"><?= $this->lang->line('thailand'); ?> (+86)</option>
                                </select>
                                <?= form_error('country', '<small class="text-danger pl-3">', '</small>'); ?>
                                <!-- </div> -->
                            </div>

                            <div class="form-group">
                                <!-- <div class="col-8"> -->
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= set_value('phone'); ?>" placeholder="<?= $this->lang->line('phone'); ?>" maxlength="15">
                                <?= form_error('phone', '<small class="text-danger pl-3">', '</small>'); ?>
                                <!-- </div> -->
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="basecamp" name="basecamp">
                                    <option class="text-black text-center" selected disabled>- <?= $this->lang->line('select_basecamp'); ?> -</option>
                                    <?php foreach ($camp as $row) : ?>
                                        <option class="text-black text-center" value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?= form_error('basecamp', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly></textarea>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="accept_terms">
                                <label class="form-check-label text-white" for="flexCheckDefault">
                                <?= $this->lang->line('check_agree_provision'); ?>
                                </label>
                                <?= form_error('accept_terms', '<small class="text-danger pt-1">', '</small>'); ?>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <button type="submit" class="btn btn-ok btn-block wd-px text-uppercase">
                                    <?= $this->lang->line('ok'); ?>
                                    </button>
                                </div>
                                <div class="p-5">
                                    <a class="btn btn-cancel btn-block wd-px text-uppercase" href="<?= base_url(); ?>auth"><?= $this->lang->line('cancel'); ?></a>
                                </div>
                            </div>
                        </form>
                        <!-- <div class="text-center">
                            <a class="small" href="<?= base_url(); ?>auth">Already have an account? Sign in!</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>