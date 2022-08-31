<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase"><?= $this->lang->line('change_password'); ?></h1>

    <!-- content -->
    <div class="row">
        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
        <div class="col-md-8 m-auto">
            <div class="">
                <div class="text-center mb-3">
                    <h1 class="h4 text-white"><?= $this->lang->line('change_password'); ?></h1>
                </div>

                <?= $this->session->flashdata('message'); ?>

                <form class="term-condition" method="post" action="<?php base_url('user/changePassword') ?>">
                    <div class="input-group eye" id="show_hide_password">
                        <input type="password" class="form-control" id="password" name="password" placeholder="<?= $this->lang->line('enter_current_password'); ?>" value="<?= set_value('password'); ?>">
                        <div class="input-group-append">
                            <button class="btn term-condition border text-white" type="button">
                                <i class="fas fa-eye-slash fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="mb-2"></div>
                    <div class="input-group eye" id="show_hide_password1">
                        <input type="password" class="form-control" id="password1" name="password1" placeholder="<?= $this->lang->line('enter_new_password'); ?>" value="<?= set_value('password1'); ?>">
                        <div class="input-group-append">
                            <button class="btn term-condition border text-white" type="button">
                                <i class="fas fa-eye-slash fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="mb-2"></div>
                    <div class="input-group eye" id="show_hide_password2">
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="<?= $this->lang->line('repeat_new_password'); ?>" value="<?= set_value('password2'); ?>">
                        <div class="input-group-append">
                            <button class="btn term-condition border text-white" type="button">
                                <i class="fas fa-eye-slash fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="mb-2"></div>
                    <div class="input-group check">
                        <input type="text" class="form-control" id="email_code" name="email_code" placeholder="Email Code" value="<?= set_value('email_code'); ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn term-condition border text-white" type="submit" name="check">
                            <?= $this->lang->line('check'); ?>
                            </button>
                        </div>
                    </div>
                    <?= form_error('email_code', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="mb-2"></div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                            <?= $this->lang->line('submit'); ?>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('user/setting'); ?>" class="btn btn-primary btn-user btn-block">
                            <?= $this->lang->line('cancel'); ?>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->