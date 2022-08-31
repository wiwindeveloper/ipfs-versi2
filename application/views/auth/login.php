<div class="container-fluid">

    <!-- Outer Row -->
    <!-- <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12"> -->

    <div class="card o-hidden border-0 shadow-lg bg-transparent">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row vh-100">
                <!-- <div class="col-lg-8 d-none d-lg-block bg-login-image"></div> -->
                <div class="col-md-4 m-auto">
                    <div class="navmenu-cs flex-rowcs pt-5">
                        <div class="pl-5">
                            <!-- <img src="<?= base_url('assets/img/logo.png'); ?>" alt="" width="150"> -->
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="text-center signin-header">
                            <div class="d-flex justify-content-center flex-row">
                                <div class="p-2">
                                    <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" alt="logo">
                                </div>
                                <div class="p-2">
                                    <h1 class="h4 text-white mb-1">IPFS.CO.ID</h1>
                                    <p class="text-white"><?= $this->lang->line('hello'); ?>, <?= $this->lang->line('welcome'); ?></p>
                                </div>
                            </div>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('auth'); ?>">
                            <div class="input-group input-group-joined ">
                                <span class="input-group-text">
                                    <img src="<?= base_url('assets/img/icon-02.png'); ?>" alt="icon">
                                </span>
                                <input type="text" class="form-control ps-0" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="ENTER ID">
                            </div>
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>

                            <div class="input-group input-group-joined mt-3" id="show_hide_password2">
                                <span class="input-group-text">
                                    <img src="<?= base_url('assets/img/icon-01.png'); ?>" alt="icon">
                                </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="ENTER PASSWORD">
                                <div class="input-group-append">
                                    <button class="btn" type="button">
                                        <i class="fas fa-eye-slash fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>

                            <div class="input-group mt-3">
                                <input type="text" class="form-control text-center" id="otp_code" name="otp_code" placeholder="OTP CODE" value="<?= set_value('otp_code'); ?>">
                            </div>
                            <?= form_error('otp_code', '<small class="text-danger pl-3">', '</small>'); ?>

                            <div class="d-flex text-white mt-2">
                                <div class="mr-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="accept_terms">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            id <?= $this->lang->line('save'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="">
                                    <a class="text-white forgot mr-1" href="<?= base_url('auth/forgotOTP'); ?>"><?= $this->lang->line('forgot_otp'); ?></a> |
                                    <a class="text-white forgot ml-1" href="<?= base_url('auth/forgotPassword'); ?>"><?= $this->lang->line('forgot_password'); ?></a>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <button type="submit" class="btn btn-ok btn-block wd-px text-uppercase">
                                    <?= $this->lang->line('login'); ?>
                                    </button>
                                </div>
                                <div class="p-5">
                                    <a class="signup btn btn-cancel btn-block wd-px text-uppercase" href="<?= base_url('auth/registration') ?>"><?= $this->lang->line('signup'); ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="chatbutton">
        <a href="<?= base_url('#'); ?>">
            <img src="<?= base_url('assets/img/chat.png'); ?>" alt="Chat-Button" width="40px">
        </a>
    </div>

    <style>
        .chatbutton {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
        }
    </style> -->

    <!-- </div>

        </div> -->

</div>