<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title text-uppercase">GOOGLE OTP</h1>

    <div class="row">
        <div class="col-md-12">
            <?= $this->session->flashdata('message'); ?>

            <?php if ($user['is_otp'] == 0) : ?>
                <form class="payment" method="post" action="<?= base_url('user/google_otp'); ?>">
                    <div class="payment text-center text-white">
                        <h3 class="text-white"><?= $this->lang->line('otp_title'); ?></h3>
                        <div id="qr_code">
                            <div class="mt-4"></div>
                            <img src="<?= $qrCodeUrl  ?>" alt="" width="200">
                            <p class="code-text mt-4 mx-auto w-50">
                            <?= $this->lang->line('otp_description'); ?>
                            </p>

                            <div class="col-md-6 mt-5 mx-auto">
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" id="code" name="code" value="<?= set_value('code'); ?>" placeholder="<?= $this->lang->line('enter_otp_code'); ?>">
                                </div>
                                <?= form_error('code', '<small class="text-danger pl-3 float-left">', '</small>'); ?>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <button type="submit" name="submit" class="btn btn-ok btn-block wd-px text-uppercase">
                                    <?= $this->lang->line('submit'); ?>
                                    </button>
                                </div>
                                <div class="p-5">
                                    <a href="<?= base_url('user/setting'); ?>" class="btn btn-cancel btn-block wd-px text-uppercase">
                                    <?= $this->lang->line('cancel'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php else : ?>
                <form class="otp-page" method="post" action="<?= base_url('user/google_otp'); ?>">
                    <div class="otp-page text-center text-white mt-4">
                        <h5 class="border p-1 mx-auto w-50" style="border-radius: 5px;"><?= $user['secret_otp'] ?></h5>
                        <div class="col-md-6 mt-5 mx-auto">
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" id="code" name="code" value="<?= set_value('code'); ?>" placeholder="<?= $this->lang->line('enter_otp_code'); ?>">
                            </div>
                            <?= form_error('code', '<small class="text-danger pl-3 float-left">', '</small>'); ?>
                        </div>
                        <div class="col-md-12 mt-5">
                            <button type="submit" name="unactivated" class="btn btn-ok btn-user btn-block">
                            <?= $this->lang->line('unactive'); ?>
                            </button>
                        </div>
                        <div class=" col-md-12 mt-2">
                            <a href="<?= base_url('user/setting'); ?>" class="btn btn-cancel btn-user btn-block">
                            <?= $this->lang->line('cancel'); ?>
                            </a>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->