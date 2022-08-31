<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5 bg-transparent">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                        <div class="col-md-10 m-auto">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-white"><?= $this->lang->line('reset_password')?></h1>
                                    <h5 class="mb-4 text-white"><?= $this->session->userdata('reset_email'); ?></h5>
                                </div>

                                <?= $this->session->flashdata('message'); ?>

                                <form class="registration" method="post" action="<?= base_url('auth/changePassword'); ?>">
                                    <!-- <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                        id="password1" name="password1"
                                        placeholder="Enter New Password...">
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div> -->
                                    <div class="input-group eye" id="show_hide_password1">
                                        <input type="password" class="form-control" id="password1" name="password1" placeholder="<?= $this->lang->line('enter')?> New Password">
                                        <div class="input-group-append">
                                            <button class="btn" type="button">
                                                <i class="fas fa-eye-slash fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    <div class="mb-2"></div>
                                    <!-- <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                        id="password2" name="password2"
                                        placeholder="Repeat Password...">
                                    <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div> -->

                                    <div class="input-group eye" id="show_hide_password2">
                                        <input type="password" class="form-control" id="password2" name="password2" placeholder="<?= $this->lang->line('repeat_password')?>">
                                        <div class="input-group-append">
                                            <button class="btn" type="button">
                                                <i class="fas fa-eye-slash fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-2"></div>

                                    <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                    <button type="submit" class="btn btn-ok btn-user btn-block">
                                    <?= $this->lang->line('reset_password');?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>