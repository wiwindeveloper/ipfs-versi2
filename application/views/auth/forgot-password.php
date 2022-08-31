<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5 bg-transparent">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                        <div class="col-md-6 m-auto">
                            <div class="p-5">
                                <div class="text-center signin-header">
                                    <h1 class="h4 text-white mb-4"><?= $this->lang->line('forgot_password');?></h1>
                                </div>

                                <?= $this->session->flashdata('message'); ?>

                                <form class="registration" method="post" action="<?= base_url('auth/forgotPassword'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username'); ?>" placeholder="<?= $this->lang->line('enter');?> ID">
                                        <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="<?= $this->lang->line('enter');?> Email Address...">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <div class="p-5">
                                            <button type="submit" class="btn btn-ok btn-block wd-px text-uppercase">
                                            <?= $this->lang->line('ok');?>
                                            </button>
                                        </div>
                                        <div class="p-5">
                                            <a class="btn btn-cancel btn-block wd-px text-uppercase" href="<?= base_url(); ?>auth"><?= $this->lang->line('cancel');?></a>
                                        </div>
                                    </div>

                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>